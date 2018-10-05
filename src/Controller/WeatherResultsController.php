<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\weatherApi as WeatherClient;
use App\Service\countriesCodes as countriesCodesClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class WeatherResultsController extends Controller
{
    /**
     * @Route("/results", name="results")
     */
    public function index(Request $request, WeatherClient $client,countriesCodesClient $countryCodeClient,  SessionInterface $session)
    {
		$dailyWeather = [];
		$forecastWeather = [];
        $weekdays = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];

    	$form = $this->createForm(WeatherType::class);

    	$form->handleRequest($request);

        if($form->isSubmitted()){
            $news = $session->get('news');
        	$data = $form->getData();
            $code = json_decode($countryCodeClient->getCountryCode($data['country']));
            $countryCode = strtolower($code[0]->alpha2Code);
        	$dailyWeather = json_decode($client->weatherSearch($data,$countryCode),true);
        	$forecastWeather = json_decode($client->forecastSearch($data,$countryCode),true);

        	foreach ($forecastWeather['list'] as $list ) {
        		$day = gmdate('D', $list['dt']);
                $weekdays[$day][]=$list;
        	}    
        }
        return $this->render('weather_results/index.html.twig', [
            'weatherForm' => $form->createView(),
            'weather' => $dailyWeather,
            'weekdays' => $weekdays,
            'geoip' => $session->get('geoip'),
            'file'=>$session->get('contents'),
            'countries'=>$session->get('keys'),
            'news' => $news
        ]);
    }
}