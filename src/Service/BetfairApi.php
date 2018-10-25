<?php 
namespace App\Service;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Middleware;

/**
 * 
 */
class BetfairApi
{

	protected $betfairLoginEpoint;
	protected $betfairNeEndpoint;
	protected $betfairClient;
	protected $betfairClientN;
	protected $betfairK;
	// protected $finder;
	function __construct($betfairKey, $betfairLoginEndpoint, $betfairNextEndpoint)
	{
		// $this->finder = new ContentFinder();
		
		$this->betfairK = $betfairKey;

		$betfairDefault = ['base_uri' => $betfairLoginEndpoint];
        $this->betfairClient = new HttpClient($betfairDefault);

        $betfairNext = ['base_uri' => $betfairNextEndpoint];
        $this->betfairClientN = new HttpClient($betfairNext);
	}

	public function login($username, $password){

		$parameters = '?username='.$username.'&password='.$password;

		$response = $this->betfairClient->request('POST',$parameters,[
			'headers'=> [
				'X-Application' => 'WLsLIUabgRCGrxMf',
        		'Accept'     => 'application/json'
			]
		]);
		$tokenResp = json_decode($response->getBody()->getContents());
		$token = $tokenResp->token;
		var_dump($token);
		exit;
		self::getNextUkHorseRacingMarket($this->betfairK,$token);
		exit;
		return $response->getBody()->getContents();

	}

	public function getAllTypes($betfairKey, $sessionToken, $horseRacingEventTypeId=7){

		$body = '{"filter":{"eventTypeIds":"'.$horseRacingEventTypeId.'",
              "marketCountries":["GB"],
              "marketTypeCodes":["WIN"],
              "marketStartTime":{"from":"' . date('c') . '"}},
              "sort":"FIRST_TO_START",
              "maxResults":"1",
              "marketProjection":["RUNNER_DESCRIPTION"]}';

        $parameters = "v1/listEventTypes/";


        $json = array('filter'=> new \StdClass);

		$json = json_encode($json);
		// var_dump($json);
		// exit;


		$response = $this->betfairClientN->request('POST',$parameters,[
			'headers'=> [
				'X-Application' => $betfairKey,
				'X-Authentication' => $sessionToken,
        		'Accept'     => 'application/json',
        		'Content-Type' => 'application/json'
			],
			'json' => [ 
				'filter' => new \StdClass
			],
			'debug' => 'true'
		
		]);
		var_dump($response->getBody()->getContents());
		exit;

		return $response->getBody()->getContents();
		
	}
}