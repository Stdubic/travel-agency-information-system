<?php

namespace Modules\Accommodation\Services;

use Carbon\Carbon;

class NewSoapClient extends \SoapClient
{

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {

/*        $string = '<?xml version="1.0" encoding="UTF-8"?>';*/
//
//        $request = str_replace($string , '', $request);
//
//        $request = str_replace('xmlns:xsd="http://www.w3.org/2001/XMLSchema"', 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"', $request);
//
//        $request = str_replace('xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"', '', $request);
//
//        $request = str_replace('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" >', 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">', $request);
//
//        //$request = str_replace('xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"', 'xmlns:SOAP-ENV="http://www.w3.org/2003/05/soap-envelope"', $request);
//
//        $request = trim($request);


        // Add code to inspect/dissect/debug/adjust the XML given in $request here
        //echo "$request\n"; // OK, but XML string in single line
//        $doc = new \DOMDocument('1.0');
//        $doc->preserveWhiteSpace = false;
//        $doc->formatOutput = true;
//        $doc->loadXML($request);
//        $xml_string = $doc->saveXML();
//        echo "$xml_string\n";
        //dd($request);
        //die();
        // Uncomment the following line, if you actually want to do the request
        // return parent::__doRequest($request, $location, $action, $version, $one_way);
        //return "";



        if (strpos($request,'<ns1:OTA_HotelResNotifRQ>') !== false) {
            $carbonTime = Carbon::now();
            $dt = $carbonTime->toIso8601String();
            $request = str_replace( '<ns1:OTA_HotelResNotifRQ>', '<ns1:OTA_HotelResNotifRQ EchoToken="PHOBS4a5cf3bd6b6e52b313cec209a70e50c4" TimeStamp="' . $dt .'" Version="1.006">', $request);
        }


        return parent::__doRequest($request, $location, $action, $version, $one_way); // TODO: Change the autogenerated stub
    }

}
