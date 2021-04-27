<?php

namespace Modules\Accommodation\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Accommodation\Entities\AccommodationCategory;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\AccommodationObjectImage;
use Modules\Accommodation\Entities\AccommodationType;
use Modules\Accommodation\Entities\AmenitySet;
use Modules\Accommodation\Entities\Country;
use Modules\Accommodation\Entities\Region;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectCreateRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectEditRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectImageDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectListRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectSyncRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectUpdateRequest;
use Modules\Accommodation\Http\Requests\TestRequest;
use Modules\Accommodation\Services\AccommodationHelper;
use Modules\Accommodation\Services\PhobsMapper;
use Modules\Accommodation\Services\SoapPhobsClient;
use Modules\Base\Entities\User;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationObject\AccommodationObjectStoreRequest;
use Intervention\Image\ImageManager;

class AccommodationObjectController extends Controller
{
    /**
     * List accommodation objects
     *
     * @param AccommodationObjectListRequest $request
     * @param AccommodationObject $accommodationObject
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AccommodationObjectListRequest $request, AccommodationObject $accommodationObject)
    {
        $objects = $accommodationObject->with(['country', 'region', 'city', 'owner', 'units'])->paginate(50);

        return view('accommodation::accommodation.object.list', compact('objects'));
    }

    /**
     * Returns page for creating new accommodation object
     *
     * @param AccommodationObjectCreateRequest $request
     * @param AccommodationType $accommodationType
     * @param AccommodationCategory $accommodationCategory
     * @param Country $country
     * @param AccommodationObject $object
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AccommodationObjectCreateRequest $request, AccommodationType $accommodationType, AccommodationCategory $accommodationCategory, Country $country, AccommodationObject $object, AmenitySet $amenitySet)
    {
//        $types = $accommodationType->withTranslation()->get();
//
//        $typesSelectArray = [];
//
//        foreach ($types as $type) {
//            $typesSelectArray[$type->translations->first()->accommodation_type_id] = $type->translations->first()->title;
//        }

        $categories = $accommodationCategory->withTranslation()->get();

        $categorySelectArray = [];

        foreach ($categories as $category) {
            $categorySelectArray[$category->translations->first()->accommodation_category_id] = $category->translations->first()->title;
        }

        $imageArray = [];

        $countries = array_merge([0 => 'Choose'], $country->pluck('global_name', 'id')->toArray());

        $amenitySet = $amenitySet->with(['translations', 'amenities' => function ($query) {
            $query->withTranslation();
        }])->get();

        $timeZones = AccommodationHelper::getTimeZoneArray();

        return view('accommodation::accommodation.object.create', compact(['categorySelectArray', 'countries', 'object', 'amenitySet', 'timeZones', 'imageArray']));
    }

    /**
     * Store new accommodation object
     *
     * @param AccommodationObjectStoreRequest $request
     * @param AccommodationObject $accommodationObject
     * @param User $user
     * @param FilesystemManager $filesystemManager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationObjectStoreRequest $request, AccommodationObject $accommodationObject, User $user, FilesystemManager $filesystemManager, ImageManager $imageManager)
    {
        $amenityParams = [];

        $merged = array_replace($request->input('amenity'), $request->input('distance_amenity'));

        foreach (array_filter($merged) as $id => $value) {
            $amenityParams[$id] = [
                'value' => $value
            ];
        }


        $user = $user->where('name', $request->input('owner'))->first();

        $params = array_merge([
            'name' => $request->input('name'),
            'tel_num' => $request->input('reception_phone'),
            'rating' => $request->input('object_rating'),
            'channel_manager' => $request->input('channel_manager'),
            'channel_manager_code' => $request->input('channel_manager_code'),
            'type' => $request->input('type'),
            'supplier_id' => $user->id,
            'country_id' => $request->input('country_id'),
            'region_id' => $request->input('region_id'),
            'city_id' => $request->input('city_id'),
            'lat' => $request->input('lat'),
            'long' => $request->input('long'),
            'contact_person' => $request->input('contact_person'),
            'reception_phone' => $request->input('reception_phone'),
            'reception_email' => $request->input('reception_email'),
            'website' => $request->input('website'),
            'address' => $request->input('address'),
            'time_zone' => $request->input('time_zone'),
            'currency' => $request->input('currency'),
            'added_tax' => $request->input('added_tax'),
            'booking_email' => $request->input('booking_email'),
            'office_phone' => $request->input('office_phone'),
            'office_tax' => $request->input('office_tax'),
            'bank_name' => $request->input('bank_name'),
            'bank_office' => $request->input('bank_office'),
            'bank_swift' => $request->input('bank_swift'),
            'account_number' => $request->input('account_number'),
            'company_name' => $request->input('company_name'),
            'bank_iban' => $request->input('bank_iban'),
        ], $request->input('description_translation'));

        try {
            $accommodationObject = $accommodationObject->create($params);

            $accommodationObject->settings()->create([
                'front_visibility' => $request->input('site_visibility', 0),
                'admin_visibility' => $request->input('admin_visibility', 0),
                'rating' => $request->input('allow_rating', 0),
                'recommendation' => $request->input('recommended', 0),
                'medical' => $request->input('medical', 0),
                'household' => $request->input('household', 0),
            ]);


            $accommodationObject->categories()->attach($request->input('object_category'));

            if($request->has('set')) {
                $accommodationObject->amenitySets()->attach(array_keys($request->input('set')));
            }

            if(count($amenityParams)) {
                $accommodationObject->amenities()->sync($amenityParams);
            }

            $uploadedFiles = $request->files;

            foreach ($uploadedFiles->get('files') as $key => $file) {
                $unique = rand();

                $params = array_merge([
                    'unique_id' => $unique
                ], $request->input('translation')[$key]);

                $accommodationObject->images()->create($params);

                $thumb = $imageManager->make(file_get_contents($file))->resize(200,100);

                $thumbData = $thumb->response();

                $content = $thumbData->getContent();

                $filesystemManager->disk('s3')->put('object/' . $accommodationObject->id . '/' . $unique, file_get_contents($file), 'public');

                $filesystemManager->disk('s3')->put('object/' . $accommodationObject->id . '/thumbnail/' . $unique, $content , 'public');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.object.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.object.store.success'));
    }

    /**
     * Returns page for editing accommodation object
     *
     * @param AccommodationObjectEditRequest $request
     * @param AccommodationObject $object
     * @param AccommodationType $accommodationType
     * @param AccommodationCategory $accommodationCategory
     * @param Country $country
     * @param Region $region
     * @param User $user
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AccommodationObjectEditRequest $request, AccommodationObject $object, AccommodationType $accommodationType, AccommodationCategory $accommodationCategory, Country $country, Region $region, User $user, AmenitySet $amenitySet, FilesystemManager $filesystemManager)
    {
//        $types = $accommodationType->withTranslation()->get();
//
//        $typesSelectArray = [];
//
//        foreach ($types as $type) {
//            $typesSelectArray[$type->translations->first()->accommodation_type_id] = $type->translations->first()->title;
//        }

        $categories = $accommodationCategory->withTranslation()->get();

        $categorySelectArray = [];

        foreach ($categories as $category) {
            $categorySelectArray[$category->translations->first()->accommodation_category_id] = $category->translations->first()->title;
        }

        $countries = array_merge([0 => 'Choose'], $country->pluck('global_name', 'id')->toArray());


        $object->load(['settings', 'country', 'region', 'city' ,'categories', 'owner', 'amenities', 'amenitySets', 'translations' => function ($query) {
            $query->orderBy('accommodation_object_description_translations.created_at', 'desc');
        }]);

        $object->formattedTranslations = $object->translations->keyBy('locale');

        $selectedCategories = $object->categories->pluck('id');

        $selectedCountry = $country->find($object->country_id);

        $regions = $selectedCountry->regions()->pluck('name', 'id');

        $selectedRegion = $region->find($object->region_id);

        $cities = $selectedRegion->cities()->pluck('name', 'id');

        $owner = $user->find($object->supplier_id);

        $amenitySet = $amenitySet->with(['translations', 'amenities' => function ($query) {
            $query->withTranslation();
        }])->get();

        $distanceAmenitiesSet = $amenitySet->get(1)->amenities;

        $distanceAmenities = $distanceAmenitiesSet->pluck('id')->toArray();

        $objectSetArray = $object->amenitySets->pluck('id')->toArray();

        $amenityArray = [];

        foreach ($object->amenities as $key => $value) {
            $amenityArray[$value->pivot->amenity_id] = $value->pivot->value;
        }

        $distanceAmenitiesArray = [];

        foreach ($distanceAmenities as $amenityId) {
            if(isset($amenityArray[$amenityId])) {
                $distanceAmenitiesArray[$amenityId] = $amenityArray[$amenityId];
                unset($amenityArray[$amenityId]);
            }
        }

        $objectImages = $object->images()->get();

        $imageArray = [];

        if($objectImages->count()) {
            foreach ($objectImages as $image) {
                $imageArray[$image->unique_id] = $filesystemManager->cloud()->url('api-test-v2/object/' . $image->accommodation_object_id . '/thumbnail/' . $image->unique_id);
            }
        }

        $timeZones = AccommodationHelper::getTimeZoneArray();

        return view('accommodation::accommodation.object.create', compact(['timeZones', 'categorySelectArray', 'countries', 'object', 'selectedCategories', 'regions', 'cities', 'owner', 'amenitySet', 'objectSetArray', 'amenityArray', 'imageArray', 'distanceAmenitiesArray']));
    }

    /**
     * Updates accommodation object
     *
     * @param AccommodationObjectUpdateRequest $request
     * @param User $user
     * @param AccommodationObject $object
     * @param FilesystemManager $filesystemManager
     * @param ImageManager $imageManager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccommodationObjectUpdateRequest $request, User $user, AccommodationObject $object, FilesystemManager $filesystemManager, ImageManager $imageManager)
    {
        $user = $user->where('name', $request->input('owner'))->first();

        $amenityParams = [];

        $merged = array_replace($request->input('amenity'), $request->input('distance_amenity'));

        foreach (array_filter($merged) as $id => $value) {
            $amenityParams[$id] = [
                'value' => $value
            ];
        }
        

        try {
            $object->update([
                'name' => $request->input('name'),
                'tel_num' => $request->input('reception_phone'),
                'rating' => $request->input('object_rating'),
                'channel_manager' => $request->input('channel_manager'),
                'channel_manager_code' => $request->input('channel_manager_code'),
                'type_id' => $request->input('type'),
                'supplier_id' => $user->id,
                'country_id' => $request->input('country_id'),
                'region_id' => $request->input('region_id'),
                'city_id' => $request->input('city_id'),
                'lat' => $request->input('lat'),
                'long' => $request->input('long'),
                'contact_person' => $request->input('contact_person'),
                'reception_phone' => $request->input('reception_phone'),
                'reception_email' => $request->input('reception_email'),
                'website' => $request->input('website'),
                'address' => $request->input('address'),
                'time_zone' => $request->input('time_zone'),
                'currency' => $request->input('currency'),
                'added_tax' => $request->input('added_tax'),
                'booking_email' => $request->input('booking_email'),
                'office_phone' => $request->input('office_phone'),
                'office_tax' => $request->input('office_tax'),
                'bank_name' => $request->input('bank_name'),
                'bank_office' => $request->input('bank_office'),
                'bank_swift' => $request->input('bank_swift'),
                'account_number' => $request->input('account_number'),
                'company_name' => $request->input('company_name'),
                'bank_iban' => $request->input('bank_iban')
            ]);

            foreach ($request->input('description_translation') as $language => $description) {
                foreach ($description as $key => $value) {
                    $query[$key] = $request->input("description_translation.{$language}.{$key}");
                }

                $object->translations()->updateOrCreate(['locale' => $language], $query);
            }

//            $object->settings()->update([
//                'front_visibility' => $request->input('site_visibility', 0),
//                'admin_visibility' => $request->input('admin_visibility', 0),
//                'rating' => $request->input('allow_rating', 0),
//                'recommendation' => $request->input('recommended', 0),
//                'medical' => $request->input('medical', 0),
//                'household' => $request->input('household', 0),
//            ]);

            $object->categories()->sync($request->input('object_category'));

            if($request->has('set')) {
                $object->amenitySets()->sync(array_keys($request->input('set')));
            }

            $object->amenities()->sync($amenityParams);

            $uploadedFiles = $request->files;

            if($uploadedFiles->count()) {
                foreach ($uploadedFiles->get('files') as $key => $file) {
                    $unique = rand();

                    $params = array_merge([
                        'unique_id' => $unique
                    ], $request->input('translation')[$key]);

                    $object->images()->create($params);

                    $thumb = $imageManager->make(file_get_contents($file))->resize(200,100);

                    $thumbData = $thumb->response();

                    $content = $thumbData->getContent();

                    $filesystemManager->disk('s3')->put('object/' . $object->id . '/' . $unique, file_get_contents($file), 'public');

                    $filesystemManager->disk('s3')->put('object/' . $object->id . '/thumbnail/' . $unique, $content , 'public');
                }
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.object.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.object.update.success'));
    }


    /**
     * Delete accommodation object
     *
     * @param AccommodationObjectDeleteRequest $request
     * @param AccommodationObject $accommodationObject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AccommodationObjectDeleteRequest $request, AccommodationObject $accommodationObject)
    {
        $object = $accommodationObject->find($request->route('id'));
        try {
            $object->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.object.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.object.delete.success'));
    }

    /**
     * Delete accommodation object images
     *
     * @param AccommodationObjectImageDeleteRequest $request
     * @param FilesystemManager $filesystemManager
     * @param AccommodationObjectImage $objectImage
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyImage(AccommodationObjectImageDeleteRequest $request, FilesystemManager $filesystemManager, AccommodationObjectImage $objectImage)
    {
        $objectImage = $objectImage->where('unique_id', $request->input('imageId'))->firstOrFail();

        $object = $objectImage->object()->get()->first();

        try {
            $filesystemManager->disk('s3')->delete('object/' . $object->id . '/thumbnail/' . $request->input('imageId'));
            $filesystemManager->disk('s3')->delete('object/' . $object->id . '/' . $request->input('imageId'));
            $objectImage->delete();
        } catch (\Exception $exception) {
            return response()->json("There has been an error while deleting images.", 500);
        }

        return response()->json("Object images deleted successfully.", 200);
    }

    /**
     * Sync accommodation object with channel manager
     *
     * @param AccommodationObjectSyncRequest $request
     * @param AccommodationObject $object
     * @param SoapPhobsClient $soapPhobsClient
     * @param PhobsMapper $phobsMapper
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function channelManagerSync(AccommodationObjectSyncRequest $request, AccommodationObject $object ,SoapPhobsClient $soapPhobsClient, PhobsMapper $phobsMapper)
    {

        try{
            $response = $soapPhobsClient->fetchRoomRate($object->channel_manager_code , env('PHOBS_CHANNEL'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.object.sync.error'));
        }


        try{
            $plans = $object->ratePlans()->createMany($response['room_rates']);

            $units = $object->units()->createMany($response['unit_types']);

            $phobsMapper->mapRatesUnits($plans, $units, $response);

            $object->update([
                'is_synced' => 1
            ]);
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.object.sync.store.error'));
        }

        $client = new GuzzleClient();

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE001" InvTypeCode="DBL">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="100.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';

        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);

        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE002" InvTypeCode="DBL">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="105.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';


        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);



        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE002" InvTypeCode="SGL">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="109.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';


        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);


        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE003" InvTypeCode="DBL">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="119.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';


        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);


        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE003" InvTypeCode="SGL">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="109.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';


        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);


        $xml = '<?xml version="1.0" encoding="utf-8"?>
<OTA_HotelRateAmountNotifRQ
	xmlns="http://www.opentravel.org/OTA/2003/05"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_HotelRateAmountNotifRQ.xsd" Version="1.006"
EchoToken="54638383" TimeStamp="2005-08-01T09:30:47-05:00">
	<RateAmountMessages HotelCode="ATL476">
		<RateAmountMessage>
			<StatusApplicationControl Start="2008-12-15" End="2008-12-18" RatePlanCode="RATE003" InvTypeCode="KING">
				<DestinationSystemCodes>
					<DestinationSystemCode>ATLANTIS</DestinationSystemCode>
				</DestinationSystemCodes>
			</StatusApplicationControl>
			<Rates>
				<Rate CurrencyCode="EUR">
					<BaseByGuestAmts>
						<BaseByGuestAmt AmountBeforeTax="129.00" />
					</BaseByGuestAmts>
				</Rate>
			</Rates>
		</RateAmountMessage>
	</RateAmountMessages>
</OTA_HotelRateAmountNotifRQ>';


        $request = new GuzzleRequest(
            'POST',
            'travel/api/phobs/rate/ammount',
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );

        $response = $client->send($request);




        return redirect()->back()->with('success', __('accommodation::accommodation.object.sync.success'));
    }
}
