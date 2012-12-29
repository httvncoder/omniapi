<?php

namespace Omnivox\Libraries;

use Laravel\Bundle;
use Laravel\Session;

class Curl
{
	protected $cookieJar;

	private $charset;

	public function __construct()
	{
		$this->cookieJar = Bundle::path('omnivox').'cookies/'.Session::instance()->session['id'];
	}

	private function setOptions()
	{
		curl_setopt_array($this->curl, array(
			CURLOPT_AUTOREFERER    => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.27 (KHTML, like Gecko) Chrome/26.0.1386.0 Safari/537.27",
			CURLOPT_COOKIEJAR      => $this->cookieJar,
			CURLOPT_COOKIEFILE     => $this->cookieJar,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER         => false,
			CURLOPT_PORT		   => 443,
			CURLOPT_HEADERFUNCTION => array($this, 'callbackHeader'),
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_SSL_VERIFYHOST => 2,
		));
	}

	public function callbackHeader($ch, $field)
	{
		// Content-Type: text/html; charset=iso-8859-1
		if (strpos($field, 'Content-Type: text') !== false) {
			$this->charset = trim(substr($field, strpos($field, 'charset=') + 8));
		}

		return strlen($field);
	}

	public function get($url)
	{
		$this->curl = curl_init($url);
		$this->setOptions();

		$response = curl_exec($this->curl);

		if ($response === false) {
			throw new \Exception('Curl error '.curl_errno($this->curl).': '.curl_error($this->curl));
		}

		curl_close($this->curl);


		if ($this->charset != 'utf-8') {
			return mb_convert_encoding($response, "UTF-8", "ISO-8859-1");
		}
		else {
			return $response;
		}
	}

	public function post($url, $params = '')
	{
		$this->curl = curl_init($url);
		$this->setOptions();

		curl_setopt($this->curl, CURLOPT_POST,       TRUE);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);

		$response = curl_exec($this->curl);

		if ($response === false) {
			throw new \Exception('Curl error '.curl_errno($this->curl).': '.curl_error($this->curl));
		}

		curl_close($this->curl);

		return $response;
	}
}
