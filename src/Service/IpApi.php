<?php 
namespace App\Service;

use GuzzleHttp\Client as HttpClient;
/**
 * 
 */
class IpApi
{
	protected $geoipKey;
	protected $geoipClient;
	
	function __construct($geoipEndpoint,$geoipKey)
	{
		$this->geoipKey = $geoipKey;

		$geoipDefault = ['base_uri' => $geoipEndpoint];
		$this->geoipClient = new HttpClient($geoipDefault);
	}


	public function getGeolocation(){
		$parameters = '?fields=time_zone,country_code2&apiKey='.$this->geoipKey;
		$response = $this->geoipClient->request('GET',$parameters);

		return $response->getBody()->getContents();
	}
}