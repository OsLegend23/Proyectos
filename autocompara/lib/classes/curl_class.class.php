<?php

class curl_class
{
	public static function send($url, $method, $args= array(), $headers = array())
	{
		$curl_config = curl_class::_curl_config($url, $args);
		
		if (!isset($curl_config[$method]))
		{
			$msg = 'Method unsupported, will be ony POST or GET';
			throw new Error(HTTP_BAD_REQUEST, $msg);
		}

		$curl = curl_init(); 
		curl_setopt_array($curl, $curl_config[$method]); 
		if(!$response = curl_exec($curl)) 
		{
			$info = curl_getinfo($curl);
			if (in_array($info['http_code'], array(HTTP_OK, HTTP_ACCEPTED)))
			{
				return $response;
			}
			
			$error_code = HTTP_INTERNAL_SERVER_ERROR;
			if (isset($info['http_code']))
			{
				$error_code = $info['http_code'];
			}
			$msg_http = curl_error($curl);
			$msg = 'An error occured reaching an external service . ' . $info['url'];
			throw new Error($error_code, $msg);
		}
		
		$info = curl_getinfo($curl);
		if (!in_array($info['http_code'], array(HTTP_OK, HTTP_ACCEPTED)))
		{
			$msg = 'An error occurred when connecting to The federation';
			throw new Error($info['http_code'], $msg);
		}
		return $response;
	}
	
	private static function _curl_config($url, $args = array())
	{
		$curl_config = array();
		
		$curl_config[GET] =  array( 
					CURLOPT_URL => $url . ((isset($args) && count($args) > 0) ? '?' : '') . http_build_query($args), 
					CURLOPT_FAILONERROR => 1, 
					CURLOPT_HEADER => 0,
					CURLOPT_FOLLOWLOCATION => 1, 
					CURLOPT_SSL_VERIFYHOST => 0, 
					CURLOPT_SSL_VERIFYPEER => 0, 
					CURLOPT_RETURNTRANSFER => 1, 
					CURLINFO_HTTP_CODE => 1,
					CURLOPT_TIMEOUT => 12
				);
				
		$curl_config[POST] = array(
					CURLOPT_POSTFIELDS => http_build_query($args),
					CURLOPT_POST => 1, 
					CURLOPT_URL => $url, 
					CURLOPT_HEADER => 0,
					CURLOPT_FRESH_CONNECT => 1,
					CURLOPT_SSL_VERIFYHOST => 0,
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_FORBID_REUSE => 1,
					CURLINFO_HTTP_CODE => 1,
					CURLOPT_TIMEOUT => 12
				);
				
		return $curl_config;
	}
}
