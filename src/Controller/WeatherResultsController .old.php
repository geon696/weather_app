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
        $weekdays = ['monday' => [], 'tuesday' => [], 'wednesday' => [], 'thursday' => [], 'friday' => [], 'saturday' => [], 'sunday' => []];
        

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
	        			array_push($weekdays['monday'],$list);
	        			break;
	        		case 'Tue':
                        array_push($weekdays['tuesday'],$list);
	        			break;
	        		case 'Wed':
                        array_push($weekdays['wednesday'],$list);
	        			break;
	        		case 'Thu':
                        array_push($weekdays['thursday'],$list);
	        			break;
	        		case 'Fri':
                        array_push($weekdays['friday'],$list);
	        			break;
	        		case 'Sat':
                        array_push($weekdays['saturday'],$list);
	        			break;
	        		case 'Sun':
                        array_push($weekdays['sunday'],$list);
	        			break;
        		}
        	}
            
        }
        return $this->render('weather_results/index.html.twig', [
            'weatherForm' => $form->createView(),
            'weather' => $dailyWeather,
            'forecast' => $forecastWeather,
            'weekdays' => $weekdays,
            'geoip' => $geoip
        ]);
    }
}


// questions
// how not to create the form all the time
// if i want to show a new page, how do i get the form data in a new controller