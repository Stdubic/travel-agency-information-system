<?php

namespace Modules\Accommodation\Services;


use Carbon\Carbon;

class SoapPhobsClient
{

    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * @var PhobsRequestBuilder
     */
    private $requestBuilder;

    /**
     * @var
     */
    private $authHeader;

    /**
     * @var mixed
     */
    private $userName;

    /**
     * @var mixed
     */
    private $password;

    /**
     * SoapPhobsClient constructor.
     * @param PhobsRequestBuilder $builder
     */
    public function __construct(PhobsRequestBuilder $builder)
    {
        $this->userName = env('PHOBS_USERNAME');

        $this->password = env('PHOBS_PASSWORD');

        $this->requestBuilder = $builder;

        $this->soapClient = new NewSoapClient(null, [
            'location' =>
                "https://www.phobs.net/test/webservice/pc/service.php",
            'uri'      => "http://www.opentravel.org/OTA/2003/05",
            'trace'    => 1,
            "soap_version" => SOAP_1_1,
        ]);

        $this->soapClient->__setCookie('XDEBUG_SESSION', 'PHPSTORM');

        $this->createSoapAuthHeader();

        $this->soapClient->__setSoapHeaders($this->authHeader);
    }

    /**
     * Create auth header for SOAP request
     *
     * @return $this
     */
    private function createSoapAuthHeader()
    {
        $ns_wsse = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
        $password_type = 'ns2:http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';

        // Creating WSS identification header using SimpleXML
        $root = new \SimpleXMLElement('<root/>');

        $security = $root->addChild('ns2:Security', null, $ns_wsse);

        $usernameToken = $security->addChild('ns2:UsernameToken', null, $ns_wsse);
        $usernameToken->addChild('ns2:Username', $this->userName, $ns_wsse);
        $usernameToken->addChild('ns2:Password', $this->password, $ns_wsse)->addAttribute('xsi:xsi:type', $password_type);

        // Recovering XML value from that object
        $root->registerXPathNamespace('ns2', $ns_wsse);
        $full = $root->xpath('/root/ns2:Security');
        $auth = $full[0]->asXML();

        $auth = str_replace(' xmlns:ns2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"','', $auth);

        $this->authHeader = new \SoapHeader($ns_wsse, 'Security', new \SoapVar($auth, XSD_ANYXML), true);

        return $this;
    }


    /**
     * Handle rate amount notification
     *
     * @param $request
     * @return array
     */
    public function handleRateAmountRequest($request)
    {
        $hotelCode = '';
        $startDate = '';
        $endDate = '';
        $ratePlanCode = '';
        $roomCode = '';
        $systemCode = '';
        $currencyCode = '';
        $rates = [];
        $rate = '';

        $type = '';


        foreach ($request['RateAmountMessages'] as $key1 => $value1) {
            if($key1 === '@attributes') {
                $hotelCode = $value1['HotelCode'];
            } elseif ($key1 === 'RateAmountMessage') {
                foreach ($value1 as $key2 => $value2) {
                    if($key2 === 'StatusApplicationControl'){
                        foreach ($value2 as $key3 => $value3) {
                            if($key3 === '@attributes') {
                                $startDate = $value3['Start'];
                                $endDate = $value3['End'];
                                $ratePlanCode = $value3['RatePlanCode'];
                                $roomCode = $value3['InvTypeCode'];
                            } elseif ($key3 === 'DestinationSystemCodes') {
                                $systemCode =  $value3['DestinationSystemCode'];
                            }
                        }
                    } elseif ($key2 === 'Rates') {
                        foreach ($value2 as $key3 => $value3) {
                            foreach ($value3 as $key4 => $value4) {
                                if($key4 === '@attributes') {
                                    $currencyCode = $value4['CurrencyCode'];
                                } elseif ($key4 === 'BaseByGuestAmts') {
                                    foreach ($value4 as $key5 => $value5) {
                                        foreach ($value5 as $key6 => $value6) {
                                            if($key6 === '@attributes') {
                                                $rate = $value6['AmountBeforeTax'];
                                                $type = 'rate-per-person-per-night';
                                            } else {
                                                $rates[] = [
                                                    'amount_before_tax' => $value6['@attributes']['AmountBeforeTax'],
                                                    'number_of_guests' => $value6['@attributes']['NumberOfGuests'],
                                                    'age_code' => $value6['@attributes']['AgeQualifyingCode'],
                                                ];
                                                $type = 'rate-per-unit-occupancy';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            'type' => $type,
            'rate' => $rate,
            'rates' => $rates,
            'start' => $startDate,
            'end' => $endDate,
            'currency' => $currencyCode,
            'rateCode' => $ratePlanCode,
            'roomCode' => $roomCode,
            'hotelCode' => $hotelCode,
            'systemCode' => $systemCode,
        ];
    }


    /**
     * Fetch room rate request
     *
     * @param $hotelCode
     * @param $systemCode
     * @return mixed
     */
    public function fetchRoomRate($hotelCode, $systemCode)
    {
        $request = $this->requestBuilder->buildFetchRoomRateRequest($hotelCode, $systemCode);

        try {

            $this->soapClient->__soapCall("OTA_RoomRateListRQ",[
                new \SoapVar($request, \XSD_ANYXML)
            ]);

        } catch (\SoapFault $exception)
        {
            if($exception->getMessage() === 'Wrong Version' && $exception->faultcode === 'VersionMismatch') {
                //do nothing, response is not valid SOAP but the response is returned
            }
        }

        $response = json_decode(json_encode((array)simplexml_load_string($this->soapClient->__getLastResponse())),1);

        return $this->parseFetchRoomRate($response);
    }


    /**
     * Response for successful pulling of hotel room rate
     */
    public function hotelRateAmountResponse()
    {
        $request = $this->requestBuilder->buildHotelRateAmountNotifResponse();

        try {

            $this->soapClient->__soapCall("OTA_HotelRateAmountNotifRS",[
                new \SoapVar($request, \XSD_ANYXML)
            ]);

        } catch (\SoapFault $exception)
        {
            if($exception->getMessage() === 'Wrong Version' && $exception->faultcode === 'VersionMismatch') {
                //do nothing, response is not valid SOAP but the response is returned
            }
        }

        //dd($this->soapClient->__getLastResponse());

        //$response = json_decode(json_encode((array)simplexml_load_string($this->soapClient->__getLastResponse())),1);

        //return $this->parseFetchRoomRate($response);

        return true;
    }


    /**
     * Parse fetch room rate response
     *
     * @param $response
     * @return array
     */
    private function parseFetchRoomRate($response)
    {
        $ratePlansArray = [];

        $accommodationUnitArray = [];

        $ratePlanName = '';

        foreach ($response as $ratePlans => $ratePlan) {
            foreach ($ratePlan as $key => $details) {
                foreach ($details as $key => $item) {
                    foreach ($item as $attribute => $value) {
                        if($attribute === '@attributes') {
                            $ratePlanName = $value['RatePlanName'];
                        } elseif ($attribute === 'RatePlanRooms') {
                            foreach ($value as $room => $roomAttributes) {
                                foreach ($roomAttributes as $attributes => $roomValue) {
                                    if(is_int($attributes)) {
                                        foreach ($roomValue as $attributesArray) {
                                            $ratePlansArray[] = [
                                                'plan_name' => $ratePlanName,
                                                'plan_code' => $attributesArray['RatePlanCode'],
                                            ];

                                            $accommodationUnitArray[] = [
                                                'unit_name' => $attributesArray['RoomName'],
                                                'unit_code' => $attributesArray['InvTypeCode'],
                                            ];
                                        }
                                    } else {
                                        $ratePlansArray[] = [
                                            'plan_name' => $ratePlanName,
                                            'plan_code' => $roomValue['RatePlanCode'],
                                        ];

                                        $accommodationUnitArray[] = [
                                            'unit_name' => $roomValue['RoomName'],
                                            'unit_code' => $roomValue['InvTypeCode'],
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $ratePlansArrayFormatted = [];

        for($i = 0; $i < count($ratePlansArray); $i++) {
            if($i === 0 ) {
                $ratePlansArrayFormatted[] = [
                    'name' => $ratePlansArray[0]['plan_name'],
                    'code' => $ratePlansArray[0]['plan_code'],
                    'imported' => 1
                ];
            }

            if(($i + 1) < count($ratePlansArray)) {
                if($ratePlansArray[$i]['plan_name'] == $ratePlansArray[$i+1]['plan_name']) {
                    continue;
                } else {
                    $ratePlansArrayFormatted[] = [
                        'name' => $ratePlansArray[$i+1]['plan_name'],
                        'code' => $ratePlansArray[$i+1]['plan_code'],
                        'imported' => 1
                    ];
                }
            }
        }


        $accommodationUnitsFormatted = [];
        $insertedNames = [];

        for($i = 0; $i < count($accommodationUnitArray); $i++) {
            if($i === 0 ) {
                $accommodationUnitsFormatted[] = [
                    'name' => $accommodationUnitArray[0]['unit_name'],
                    'code' => $accommodationUnitArray[0]['unit_code'],
                    'imported' => 1
                ];

                array_push($insertedNames, $accommodationUnitArray[0]['unit_name']);
            }


            if (in_array($accommodationUnitArray[$i]['unit_name'], $insertedNames)) {
                continue;
            } else {
                $accommodationUnitsFormatted[] = [
                    'name' => $accommodationUnitArray[$i]['unit_name'],
                    'code' => $accommodationUnitArray[$i]['unit_code'],
                    'imported' => 1
                ];

                array_push($insertedNames, $accommodationUnitArray[$i]['unit_name']);
            }
        }

        return [
            'unit_types' => $accommodationUnitsFormatted,
            'room_rates' => $ratePlansArrayFormatted,
            'rates_array' => $ratePlansArray,
            'unit_array' => $accommodationUnitArray,
        ];
    }


    /**
     * @param $messageToken
     * @return bool|mixed
     * @throws PhobsException
     */
    public function addReservation($messageToken)
    {

        //89561576
        $request = $this->requestBuilder->buildAddReservationRequest();

        $this->soapClient->__setLocation('https://www.phobs.net/test/channel_ads/phobs/index.php');

        try {

            $response = $this->soapClient->__soapCall("OTA_HotelResNotifRQ", [
                new \SoapVar($request, \XSD_ANYXML)
            ] );

        } catch (\SoapFault $exception)
        {
            if($exception->getMessage() === 'Wrong Version' && $exception->faultcode === 'VersionMismatch') {
                //do nothing, response is not valid SOAP but the response is returned
            }
        }

        $rawResponse = $this->soapClient->__getLastResponse();

        $xml = new \SimpleXMLElement($rawResponse);
        $body = $xml->xpath('//SOAP-ENV:Body')[0];
        $arrayResponse = json_decode(json_encode((array)$body), TRUE);

        if (array_key_exists('OTA_HotelResNotifRS', $arrayResponse) ) {
            $notifRs = $arrayResponse['OTA_HotelResNotifRS'];

            if(array_key_exists('Success', $notifRs)) {
                return $arrayResponse;
            } elseif (array_key_exists('Success', $notifRs)) {
                return false;
            }
        }

        throw new PhobsException();
    }

    //private function createReservation

    public function addReservationWithRoomingList(array $guestInformation)
    {
        $guesComment = 'Komentar';
        $guesSpecialRequest = 'Zahtjev';

        $guestInformation = [
            'count' => 3,
            'structure' => [
                'adult' => 2,
                'minor' => 1,
            ],
            'data' => [
                0 => [
                    'prefix' => 'Mr',
                    'name' => 'Vlaho',
                    'lastName' => 'Soletic'
                ],
                1 => [
                    'prefix' => 'Mr',
                    'name' => 'Kristina',
                    'lastName' => 'Soletic'
                ],
                2 => [
                    'prefix' => 'Mr',
                    'name' => 'Maroje',
                    'lastName' => 'Soletic'
                ]
            ]
        ];
    }

    /**
     * @return bool|mixed
     * @throws PhobsException
     */
    public function cancelReservation()
    {
        $request = $this->requestBuilder->buildCancelReservationRequest();

        $this->soapClient->__setLocation('https://www.phobs.net/test/channel_ads/phobs/index.php');

        try {
            $response = $this->soapClient->__soapCall("OTA_HotelResNotifRQ", [
                new \SoapVar($request, \XSD_ANYXML)
            ] );

        } catch (\SoapFault $exception)
        {
            if($exception->getMessage() === 'Wrong Version' && $exception->faultcode === 'VersionMismatch') {
                //do nothing, response is not valid SOAP but the response is returned
            }
        }

        $rawResponse = $this->soapClient->__getLastResponse();

        $xml = new \SimpleXMLElement($rawResponse);
        $body = $xml->xpath('//SOAP-ENV:Body')[0];
        $arrayResponse = json_decode(json_encode((array)$body), TRUE);

        if (array_key_exists('OTA_HotelResNotifRS', $arrayResponse) ) {
            $notifRs = $arrayResponse['OTA_HotelResNotifRS'];

            if(array_key_exists('Success', $notifRs)) {
                return $arrayResponse;
            } elseif (array_key_exists('Errors', $notifRs)) {
                return false;
            }
        }

        throw new PhobsException();

    }

    /**
     * Dump request info
     */
    public function dumpRequestInfo()
    {
        echo("\nDumping request:\n"
            .$this->soapClient->__getLastRequest());

        echo("\nDumping request headers:\n"
            .$this->soapClient->__getLastRequestHeaders());
    }

    /**
     * Dump response info
     */
    public function dumpResponseInfo()
    {
        echo("\nDumping response:\n"
            .$this->soapClient->__getLastResponse());

        echo("\nDumping response headers:\n"
            .$this->soapClient->__getLastResponseHeaders());
    }

}
