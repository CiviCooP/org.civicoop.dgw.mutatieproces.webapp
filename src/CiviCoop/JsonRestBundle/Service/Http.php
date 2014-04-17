<?php

namespace CiviCoop\JsonRestBundle\Service;

use CiviCoop\JsonRestBundle\Model\Response;

class Http
{    
    public function performPostRequest($siteUrl, $data, $hostname = false)
    {
		$headers = array('Content-Type: application/json');
		if ($hostname) {
			$headers[] = 'Host: '.$hostname;
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $siteUrl);
		curl_setopt($curl, CURLOPT_POST, 1); // Do a regular HTTP POST
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data)); // Set POST data
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		
		$data = curl_exec($curl);
		
		$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		// Check if login was successful
		if ($http_code == 200) {
			// Convert json response as array
			$data = json_decode($data);
		} else {
			// Get error msg
			$error = curl_error($curl);
		}
		
		$response = new Response($http_code, $data);
		return $response;
    }
}