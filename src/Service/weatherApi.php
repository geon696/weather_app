<?php 
namespace App\Service;


use GuzzleHttp\Client as HttpClient;
use App\Form\WeatherType;
use Symfony\Component\Finder\Finder as ContentFinder;

/**
 * 
 */
class weatherApi
{

	protected $wkey;
	protected $weatherClient;
	protected $forecastClient;
	// protected $finder;
	function __construct($forecastEndpoint,$weatherEndpoint,$weatherKey)
	{
		$this->wkey = $weatherKey;
		// $this->finder = new ContentFinder();

		$weatherDefault = ['base_uri' => $weatherEndpoint];
        $this->weatherClient = new HttpClient($weatherDefault);

        $forecastDefault = ['base_uri' => $forecastEndpoint];
        $this->forecastClient = new HttpClient($forecastDefault);
	}

	public function weatherSearch($search){

		$parameters = '?q='.$search['city'].'&units=metric&APPID='.$this->wkey;
		$response = $this->weatherClient->request('GET',$parameters);

		return $response->getBody()->getContents();
	}

	public function forecastSearch($search){

		$parameters = '?q='.$search['city'].'&units=metric&APPID='.$this->wkey;
		$response = $this->forecastClient->request('GET',$parameters);

		return $response->getBody()->getContents();
		
	}
}