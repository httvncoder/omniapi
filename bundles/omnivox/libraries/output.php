<?php namespace Omnivox\Libraries;

use Laravel\Request;
use Laravel\Response;

class Output {

	public static function outputWithFormat($data, $format = 'json', $status = 200)
	{
		//return var_dump($data);
		switch ($format) {
			case 'json':
				return \Laravel\Response::make(json_encode($data, JSON_HEX_QUOT), $status)/*->header('Content-Type', 'application/json')*/;
			case 'xml':
				$xml = new \SimpleXMLElement('<result/>');
				//$data = array_flip($data);
				//array_walk_recursive($data, array ($xml, 'addChild'));

				foreach ($data as $object) {
					$e = $xml->addChild('item');
					foreach ($object as $key => $value) {
						$e->addChild($key, htmlspecialchars($value));
					}
				}

				return \Laravel\Response::make($xml->asXML(), $status)->header('Content-Type', 'application/xml');
		}
	}

	public static function response($response, $status = 200, $headers = array())
	{
		$environment = Request::env();

        if ($environment == 'local')
        {
            return Response::make(json_encode($response), $status, $headers);
        }

        return Response::json($response, $status, $headers);
	}

}