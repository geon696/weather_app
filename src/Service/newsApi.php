<?php 
namespace App\Service;

use GuzzleHttp\Client as HttpClient;
/**
 * 
 */
class newsApi
{
	protected $newsKey;
	protected $newsClient;
	
	function __construct($newsEndpoint,$newsKey)
	{
		$this->newsKey = $newsKey;

		$newsDefault = ['base_uri' => $newsEndpoint];
		$this->newsClient = new HttpClient($newsDefault);
	}


	public function getNews(){
		$parameters = '?sources=techcrunch&apiKey='.$this->newsKey;
		$response = $this->newsClient->request('GET',$parameters);

		return $response->getBody()->getContents();
	}
}