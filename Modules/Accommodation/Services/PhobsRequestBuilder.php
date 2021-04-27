<?php

namespace Modules\Accommodation\Services;

use Carbon\Carbon;

class PhobsRequestBuilder
{
    /**
     * @var \DOMDocument
     */
    private $dom;

    /**
     * PhobsRequestBuilder constructor.
     * @param \DOMDocument $DOMDocument
     */
    public function __construct(\DOMDocument $DOMDocument)
    {
        $this->dom = $DOMDocument;
    }


    /**
     * @param $hotelCode
     * @param $systemCode
     * @return string
     */
    public function buildFetchRoomRateRequest($hotelCode, $systemCode)
    {
        $hotelInfo = $this->dom->createElement( "ns1:HotelInfo" );
        $hotelInfo->setAttribute('HotelCode', $hotelCode);
        $hotelInfo->setAttribute('DestinationSystemCode', $systemCode);

        /*** create the root element ***/
        $this->dom->appendChild($hotelInfo);

        return $this->outputXml();
    }

    /**
     * @return string
     */
    public function buildAddReservationRequest()
    {
        return $this->buildReservationRequest();
    }


    /**
     * @param $guestInformation
     * @param $guestComment
     * @param $guestSpecialRequest
     * @return string
     */
    public function buildAddReservationRequestWithRoomingList($guestInformation, $guestComment, $guestSpecialRequest)
    {
        return $this->buildReservationRequest($guestInformation, $guestComment, $guestSpecialRequest);
    }

    /**
     * @return string
     */
    public function buildHotelRateAmountNotifResponse()
    {
        $success = $this->dom->createElement( "Success" );
        $this->dom->appendChild($success);
        return $this->outputXml();
    }


    /**
     * @return string
     */
    public function buildCancelReservationRequest()
    {
        $channelId = 'ATLANTIS';
        $carbonTime = Carbon::now();
        $dt = $carbonTime->toIso8601String();
        $reservationId = '89561576';
        $hotelCode = 'ATL476';


        //////Request body
        //ns1:POS
        $pos = $this->dom->appendChild($this->dom->createElement( "ns1:POS" ));

        //ns1:Source
        $source = $pos->appendChild($this->dom->createElement( "ns1:Source" ));

        //ns1:RequestorID
        $requestorId = $this->dom->createElement( "ns1:RequestorID");
        $requestorId->setAttribute('Type','22');
        $requestorId->setAttribute('ID','PHOBS');

        //ns1:BookingChannel
        $bookingChannel = $this->dom->createElement( "ns1:BookingChannel");
        $bookingChannel->setAttribute('Type','2');
        $bookingChannel->setAttribute('Primary','true');
        $bookingChannel->setAttribute('Code',$channelId);

        $source->appendChild($requestorId);
        $bookingChannelNode = $source->appendChild($bookingChannel);

        //ns1:CompanyName
        $companyName = $this->dom->createElement( "ns1:CompanyName", $channelId);

        $bookingChannelNode->appendChild($companyName);

        //ns1:HotelReservations
        $hotelReservations = $this->dom->appendChild($this->dom->createElement( "ns1:HotelReservations" ));

        $hotelReservation =  $this->dom->createElement( "ns1:HotelReservation" );
        $hotelReservation->setAttribute('ResStatus', 'Cancel');
        $hotelReservation->setAttribute('CreateDateTime', $dt);
        $hotelReservation->setAttribute('CreatorID', 'PHOBS');
        $hotelReservation->setAttribute('LastModifyDateTime', $dt);
        $hotelReservations->appendChild($hotelReservation);

        //UniqueId

        $uniqueId =  $this->dom->createElement( "ns1:UniqueID" );
        $uniqueId->setAttribute('Type', 14);
        $uniqueId->setAttribute('ID', $reservationId);
        $hotelReservation->appendChild($uniqueId);

        //RoomStays

        $roomStays =  $this->dom->createElement( "ns1:RoomStays" );
        $hotelReservation->appendChild($roomStays);
        $roomStay =  $this->dom->createElement( "ns1:RoomStay" );
        $roomStays->appendChild($roomStay);

        //Basic property info
        $basicPropertyInfo =  $this->dom->createElement( "ns1:BasicPropertyInfo");
        $roomStay->appendChild($basicPropertyInfo);
        $basicPropertyInfo->setAttribute('HotelCode', $hotelCode);

        //ResGlobalInfo
        $resGlobalInfo =  $this->dom->createElement( "ns1:ResGlobalInfo" );
        $hotelReservation->appendChild($resGlobalInfo);


        //Hotel reservation Ids
        $hotelReservationIDs =  $this->dom->createElement( "ns1:HotelReservationsIDs" );
        $resGlobalInfo->appendChild($hotelReservationIDs);

        //Hotel reservation Id
        $hotelReservationID =  $this->dom->createElement( "ns1:HotelReservationsID" );
        $hotelReservationIDs->appendChild($hotelReservationID);
        $hotelReservationID->setAttribute('ResID_Type', '15');
        $hotelReservationID->setAttribute('ResID_Value', $reservationId);

        return $this->outputXml();
    }

    /**
     * Final processing of request body
     *
     * @return string
     */
    private function outputXml()
    {
        $stringXML = $this->dom->saveXML();

        $stringXML = str_replace('<?xml version="999"?>', '', $stringXML);

        //dd(trim($stringXML));

        return trim($stringXML);
    }

    private function buildReservationRequest($guestInformation = null, $guestComment = null, $guestSpecialRequest = null)
    {
        //params
        $carbonTime = Carbon::now();
        $dt = $carbonTime->toIso8601String();
        $reservationId = '89561576';
        //$reservationId = rand();
        $roomTypeCode = 'DBL';
        $numberOfUnits = '1';
        $channelId = 'ATLANTIS';
        $ratePlanCode = 'RATE002';
        $effectiveDate = '2008-04-26';
        $expireDate = '2008-04-28';
        $currencyCode = 'EUR';
        $ageCode = '10';  //10 adult, 8 child
        $numOfGuests = '1';
        $guaranteeType = 'CC/DC/Voucher';  //GuaranteeRequired, None, CC/DC/Voucher, PrePay
        $cardHolderName = 'Vlaho Soletic';
        $guaranteeDescriptionText = 'Credit card guarantee';
        $hotelCode = 'ATL476';
        $namePrefixString = 'MR';
        $name = 'Vlaho';
        $surnameString = 'Soletic';
        $phoneNum1 = '0038520357307';
        $phoneNum2 = '0038520358345';
        $customerEmail = 'mail@mail.com';
        $customerAddress = 'Vukovarska17';
        $customerCity = 'Dubrovnik';
        $customerPostalCode = '20000';
        $customerCountryName = 'Croatia (Hrvatska)';
        $customerCountryCode = 'HR';
        $customerCompanyName = 'PHOBS';


        //////Request body
        //ns1:POS
        $pos = $this->dom->appendChild($this->dom->createElement( "ns1:POS" ));

        //ns1:Source
        $source = $pos->appendChild($this->dom->createElement( "ns1:Source" ));

        //ns1:RequestorID
        $requestorId = $this->dom->createElement( "ns1:RequestorID");
        $requestorId->setAttribute('Type','22');
        $requestorId->setAttribute('ID','PhobsCRS');

        //ns1:BookingChannel
        $bookingChannel = $this->dom->createElement( "ns1:BookingChannel");
        $bookingChannel->setAttribute('Type','2');
        $bookingChannel->setAttribute('Primary','true');

        $source->appendChild($requestorId);
        $bookingChannelNode = $source->appendChild($bookingChannel);

        //ns1:CompanyName
        $companyName = $this->dom->createElement( "ns1:CompanyName", $channelId);
        $companyName->setAttribute('Code', $channelId);

        $bookingChannelNode->appendChild($companyName);

        //ns1:HotelReservations
        $hotelReservations = $this->dom->appendChild($this->dom->createElement( "ns1:HotelReservations" ));

        $hotelReservation =  $this->dom->createElement( "ns1:HotelReservation" );
        $hotelReservation->setAttribute('ResStatus', 'Commit');
        $hotelReservation->setAttribute('CreateDateTime', $dt);
        $hotelReservation->setAttribute('CreatorID', 'PHOBS');
        $hotelReservations->appendChild($hotelReservation);

        //UniqueId

        $uniqueId =  $this->dom->createElement( "ns1:UniqueID" );
        $uniqueId->setAttribute('Type', 14);
        $uniqueId->setAttribute('ID', $reservationId);
        $hotelReservation->appendChild($uniqueId);

        //RoomStays

        $roomStays =  $this->dom->createElement( "ns1:RoomStays" );
        $hotelReservation->appendChild($roomStays);
        $roomStay =  $this->dom->createElement( "ns1:RoomStay" );
        $roomStays->appendChild($roomStay);

        $roomRates =  $this->dom->createElement( "ns1:RoomRates" );
        $roomStay->appendChild($roomRates);

        $roomRate =  $this->dom->createElement( "ns1:RoomRate" );
        $roomRate->setAttribute('RoomTypeCode', $roomTypeCode);
        $roomRate->setAttribute('NumberOfUnits', $numberOfUnits); //broj soba
        $roomRate->setAttribute('RatePlanCode', $ratePlanCode);
        $roomRate->setAttribute('EffectiveDate', $effectiveDate);  //In format YYYY-MM-DD
        $roomRate->setAttribute('ExpireDate', $expireDate); //In format YYYY-MM-DD
        $roomRates->appendChild($roomRate);


        //This will be dynamical, for now it will be hardcoded @todo
        $rates =  $this->dom->createElement( "ns1:Rates" );
        $roomRate->appendChild($rates);
        $rate1 =  $this->dom->createElement( "ns1:Rate" );
        $rates->appendChild($rate1);
        $rate1->setAttribute('RateTimeUnit', 'Day');  //enum default is "Day"
        $rate1->setAttribute('UnitMultiplier', '1');
        $rate1->setAttribute('EffectiveDate', '2008-04-26');  //In format YYYY-MM-DD
        $rate1->setAttribute('ExpireDate', '2008-04-27'); //In format YYYY-MM-DD
        $base1 =  $this->dom->createElement( "ns1:Base" );
        $rate1->appendChild($base1);
        $base1->setAttribute('AmountAfterTax', '121');
        $base1->setAttribute('CurrencyCode', $currencyCode);

        $rate2 =  $this->dom->createElement( "ns1:Rate" );
        $rates->appendChild($rate2);
        $rate2->setAttribute('RateTimeUnit', 'Day');  //enum default is "Day"
        $rate2->setAttribute('UnitMultiplier', '1');
        $rate2->setAttribute('EffectiveDate', '2008-04-27');  //In format YYYY-MM-DD
        $rate2->setAttribute('ExpireDate', '2008-04-28'); //In format YYYY-MM-DD
        $base2 =  $this->dom->createElement( "ns1:Base" );
        $rate2->appendChild($base2);
        $base2->setAttribute('AmountAfterTax', '122');
        $base2->setAttribute('CurrencyCode', $currencyCode);


        //Guest counts

        $guestCounts =  $this->dom->createElement( "ns1:GuestCounts" );
        $roomStay->appendChild($guestCounts);

        if($guestInformation === null) {
            //Guest count
            $guestCount =  $this->dom->createElement( "ns1:GuestCount" );
            $guestCounts->appendChild($guestCount);
            $guestCount->setAttribute('AgeQualifyingCode', $ageCode);
            $guestCount->setAttribute('Count', $numOfGuests);
        } else {
            foreach ($guestInformation as $key => $value) {

            }
        }


        //Time span
        $timeSpan =  $this->dom->createElement( "ns1:TimeSpan" );
        $roomStay->appendChild($timeSpan);
        $timeSpan->setAttribute('Start', $effectiveDate);
        $timeSpan->setAttribute('End', $expireDate);

        //Guarantee
        $guarantee =  $this->dom->createElement( "ns1:Guarantee" );
        $roomStay->appendChild($guarantee);
        $guarantee->setAttribute('GuaranteeType', $guaranteeType);

        //GuaranteesAccepted
        $guaranteesAccepted =  $this->dom->createElement( "ns1:GuaranteesAccepted" );
        $guarantee->appendChild($guaranteesAccepted);

        //GuaranteeAccepted
        $guaranteeAccepted =  $this->dom->createElement( "ns1:GuaranteeAccepted" );
        $guaranteesAccepted->appendChild($guaranteeAccepted);

        //Payment card
        $paymentCard =  $this->dom->createElement( "ns1:PaymentCard" );
        $guaranteeAccepted->appendChild($paymentCard);
        $paymentCard->setAttribute('CardType', '1');  //optional field, if there its 1
        $paymentCard->setAttribute('CardCode', 'CA');
        $paymentCard->setAttribute('CardNumber', '21000000008');  //card num
        $paymentCard->setAttribute('SeriesCode', '123');  //CVC
        $paymentCard->setAttribute('ExpireDate', '0509');  //expiry date of credit card


        //CardHolderName

        $cardHolder =  $this->dom->createElement( "ns1:CardHolderName", $cardHolderName);
        $paymentCard->appendChild($cardHolder);


        //GuaranteeDescription
        $guaranteeDescription =  $this->dom->createElement( "ns1:GuaranteeDescription" );
        $guarantee->appendChild($guaranteeDescription);

        //Text
        $text =  $this->dom->createElement( "ns1:Text", $guaranteeDescriptionText);
        $guaranteeDescription->appendChild($text);

        //Total
        $total =  $this->dom->createElement( "ns1:Total");
        $roomStay->appendChild($total);
        $total->setAttribute('AmountAfterTax', '243'); //sum of two ammounts above @todo
        $total->setAttribute('CurrencyCode', $currencyCode);

        //Basic property info
        $basicPropertyInfo =  $this->dom->createElement( "ns1:BasicPropertyInfo");
        $roomStay->appendChild($basicPropertyInfo);
        $basicPropertyInfo->setAttribute('HotelCode', $hotelCode);


        //ResGlobalInfo
        $resGlobalInfo =  $this->dom->createElement( "ns1:ResGlobalInfo" );
        $hotelReservation->appendChild($resGlobalInfo);

        //Profiles
        $profiles =  $this->dom->createElement( "ns1:Profiles" );
        $resGlobalInfo->appendChild($profiles);

        //ProfileInfo
        $profileInfo =  $this->dom->createElement( "ns1:ProfileInfo" );
        $profiles->appendChild($profileInfo);

        //Profile
        $profile =  $this->dom->createElement( "ns1:Profile" );
        $profileInfo->appendChild($profile);
        $profile->setAttribute('ProfileType', '1'); //always one

        //Customer
        $customer =  $this->dom->createElement( "ns1:Customer" );
        $profile->appendChild($customer);

        //Person name
        $personName =  $this->dom->createElement( "ns1:PersonName" );
        $customer->appendChild($personName);

        //Name prefix
        $namePrefix =  $this->dom->createElement( "ns1:NamePrefix", $namePrefixString );
        $personName->appendChild($namePrefix);

        //Given name
        $givenName =  $this->dom->createElement( "ns1:GivenName", $name );
        $personName->appendChild($givenName);

        //Surname
        $surname =  $this->dom->createElement( "ns1:Surname", $surnameString );
        $personName->appendChild($surname);

        //Telephone1, there can be more phone, so this should be in foreach @todo
        $telephone1 =  $this->dom->createElement( "ns1:Telephone");
        $customer->appendChild($telephone1);
        $telephone1->setAttribute('PhoneLocationType', '6'); //6 - home, 7 - office, 8 - other (mobile)
        $telephone1->setAttribute('PhoneTechType', '1'); //1 - voice, 3 - fax
        $telephone1->setAttribute('PhoneNumber', $phoneNum1);
        $telephone1->setAttribute('FormattedInd', 'false'); //it is connected to location, check in docs

        $telephone2 =  $this->dom->createElement( "ns1:Telephone");
        $customer->appendChild($telephone2);
        $telephone2->setAttribute('PhoneLocationType', '6'); //6 - home, 7 - office, 8 - other (mobile)
        $telephone2->setAttribute('PhoneTechType', '3'); //1 - voice, 3 - fax
        $telephone2->setAttribute('PhoneNumber', $phoneNum2);
        $telephone2->setAttribute('FormattedInd', 'false'); //it is connected to location, check in docs


        //Email
        $email =  $this->dom->createElement( "ns1:Email", $customerEmail);
        $customer->appendChild($email);
        $email->setAttribute('EmailType', '1'); //1 - personal, 2 - business
        $email->setAttribute('DefaultInd', 'true');


        //Address

        $address =  $this->dom->createElement( "ns1:Address");
        $customer->appendChild($address);
        $address->setAttribute('Type', '1'); //1 - home, 2 - business, 3 - other


        //Address line
        $addressLine =  $this->dom->createElement( "ns1:AddressLine", $customerAddress);
        $address->appendChild($addressLine);

        //City name
        $cityName =  $this->dom->createElement( "ns1:CityName", $customerCity);
        $address->appendChild($cityName);

        //Postal code
        $cityName =  $this->dom->createElement( "ns1:PostalCode", $customerPostalCode);
        $address->appendChild($cityName);

        //Country name
        $countryName =  $this->dom->createElement( "ns1:CountryName", $customerCountryName);
        $address->appendChild($countryName);
        $countryName->setAttribute('Code', $customerCountryCode);

        //Company name
        $companyName =  $this->dom->createElement( "ns1:CompanyName", $customerCompanyName);
        $address->appendChild($companyName);

        return $this->outputXml();
    }

}
