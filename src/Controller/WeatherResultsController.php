<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\weatherApi as WeatherClient;
use App\Service\IpApi as IpApiClient;
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
    public function index(Request $request, WeatherClient $client, IpApiClient $ipClient,countriesCodesClient $countryCodeClient,  SessionInterface $session)
    {
		$dailyWeather = [];
		$forecastWeather = [];
        $geoip = [];
        $weekdays = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../public/json');

    	$form = $this->createForm(WeatherType::class);

    	$form->handleRequest($request);

        foreach ($finder as $file) {
            $jsonContent = $file->getContents();
        }
        
        $contents = json_decode($jsonContent,true);

        $keys = array_keys($contents);
        $keys = json_encode($keys);

        if($form->isSubmitted()){
            $news = $session->get('news');
        	$data = $form->getData();
            $geoip = json_decode($ipClient->getGeolocation(),true);

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
            //'forecast' => $forecastWeather,
            'weekdays' => $weekdays,
            'geoip' => $geoip,
            'file'=>$jsonContent,
            'countries'=>$keys,
            'news' => $news
        ]);
    }
}