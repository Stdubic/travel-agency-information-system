<?php

namespace Modules\Accommodation\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\RatePlan;
use Modules\Accommodation\Services\SoapHandler;
use Modules\Accommodation\Services\SoapPhobsClient;
use Modules\Base\Http\Controllers\Controller;

class PhobsController extends Controller
{


    public function postPhobsRateAmount(Request $request, SoapPhobsClient $client, RatePlan $ratePlan, AccommodationObject $object)
    {
        Log::channel('phobs')->info($request->getContent());

        try {
            $parsedRequest = json_decode(json_encode((array)simplexml_load_string($request->getContent())),1);
        } catch (\Exception $exception) {
            Log::channel('phobs')->critical('Error while parsing Phobs request');

            return response()->json("Invalid request", 400);
        }

        $phobsData = $client->handleRateAmountRequest($parsedRequest);


        try{
            $object = $object->where('channel_manager_code', $phobsData['hotelCode'])->firstOrFail();
        } catch (\Exception $exception) {
            Log::channel('phobs')->critical('Object does not exists in system. Code: ' . $phobsData['hotelCode']);

            return response()->json("Invalid request", 400);
        }

        try {
            /** @var RatePlan $ratePlan */
            $ratePlan = $object->ratePlans()->where('code', $phobsData['rateCode'])->firstOrFail();
        } catch (\Exception $exception) {
            Log::channel('phobs')->critical('Rate plan: ' . $phobsData['rateCode'] . 'does not exists in hotel: '. $phobsData['hotelCode']);

            return response()->json("Invalid request", 400);
        }

        try {
            $accomodationUnit = $ratePlan->units()->where('code', $phobsData['roomCode'])->firstOrFail();
        } catch (\Exception $exception) {
            Log::channel('phobs')->critical('Rate plan: ' . $phobsData['rateCode'] . 'does not have unit with code: '. $phobsData['roomCode']);

            return response()->json("Invalid request", 400);
        }

        if($phobsData['type'] === 'rate-per-unit-occupancy') {
            $ratePlan = $ratePlan->update([
                'type' => $phobsData['type'],
                'start' => $phobsData['start'],
                'stop' => $phobsData['end'],
                'currency' => $phobsData['currency'],
                'base_price' => serialize($phobsData['rates'])
            ]);
        } else {
            $ratePlan = $ratePlan->update([
                'type' => $phobsData['type'],
                'start' => $phobsData['start'],
                'stop' => $phobsData['end'],
                'currency' => $phobsData['currency'],
                'base_price' => $phobsData['rate']
            ]);
        }

        $client->hotelRateAmountResponse();

        return response()->json("Success", 200);
    }

    protected function OTA_HotelRateAmountNotifRQ($request)
    {
        dd($request);
    }

    //    public function test(SoapPhobsClient $client)
//    {
//
//        $response = $client->fetchRoomRate('ATL476' ,env('PHOBS_CHANNEL'));
//

//        dd([
//            'type' => $type,
//            'rate' => $rate,
//            'rates' => $rates,
//            'start' => $startDate,
//            'end' => $endDate,
//            'currency' => $currencyCode,
//            'rateCode' => $ratePlanCode,
//            'roomCode' => $roomCode,
//            'hotelCode' => $hotelCode
//        ]);


//        $options= array('uri'=>'http://travel/api/phobs/rate/ammount', 'soap_version' => SOAP_1_1);
//        $server=new \SoapServer(NULL,$options);
//        $server->setClass(SoapHandler::class,[$arg1]);
//        //$server->addFunction('handle');
//        try{
//            $response = $server->handle();
//        } catch (\SoapFault $exception)
//        {
//            dd($exception);
//            if($exception->getMessage() === 'Wrong Version' && $exception->faultcode === 'VersionMismatch') {
//                //do nothing, response is not valid SOAP but the response is returned
//            }
//        }

//
//    }


}
