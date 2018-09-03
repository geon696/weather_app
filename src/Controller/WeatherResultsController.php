<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\weatherApi as WeatherClient;
use App\Service\IpApi as IpApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeatherResultsController extends Controller
{
    /**
     * @Route("/results", name="results")
     */
    public function index(Request $request, WeatherClient $client, IpApiClient $ipClient)
    {
		$dailyWeather = [];
		$forecastWeather = [];
        $geoip = [];
        $weekdays = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];

    	$form = $this->createForm(WeatherType::class);

    	$form->handleRequest($request);

        if($form->isSubmitted()){

        	$data = $form->getData();

        	$dailyWeather = json_decode($client->weatherSearch($data),true);
        	$forecastWeather = json_decode($client->forecastSearch($data),true);
            $geoip = json_decode($ipClient->getGeolocation(),true);

        	foreach ($forecastWeather['list'] as $list ) {
        		$day = gmdate('D', $list['dt']);
        		switch ($day) {
        			
        			case 'Mon':
	        			array_push($weekdays['Mon'],$list);
	        			break;
	        		case 'Tue':
                        array_push($weekdays['Tue'],$list);
	        			break;
	        		case 'Wed':
                        array_push($weekdays['Wed'],$list);
	        			break;
	        		case 'Thu':
                        array_push($weekdays['Thu'],$list);
	        			break;
	        		case 'Fri':
                        array_push($weekdays['Fri'],$list);
	        			break;
	        		case 'Sat':
                        array_push($weekdays['Sat'],$list);
	        			break;
	        		case 'Sun':
                        array_push($weekdays['Sun'],$list);
	        			break;
        		}
        	}    
        }
        return $this->render('weather_results/index.html.twig', [
            'weatherForm' => $form->createView(),
            'weather' => $dailyWeather,
            //'forecast' => $forecastWeather,
            'weekdays' => $weekdays,
            'geoip' => $geoip
        ]);
    }
}