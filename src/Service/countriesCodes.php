<?php 
namespace App\Service;

use GuzzleHttp\Client as HttpClient;
/**
 * 
 */
class countriesCodes
{
	protected $countriesCodesClient;
	
	function __construct($countriesCodeEndpoint)
	{
		$countriesCodesDefault = ['base_uri' => $countriesCodeEndpoint];
		$this->countriesCodesClient = new HttpClient($countriesCodesDefault);
	}


	public function getCountryCode($code){
		$parameters = $code.'?fullText=true';
		$response = $this->countriesCodesClient->request('GET',$parameters);

		return $response->getBody()->getContents();
	}
}