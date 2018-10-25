<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\weatherApi as WeatherClient;
use App\Service\BetfairApi as Betfair;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Finder\Finder;

class WeatherResultsController extends Controller
{
    /**
     * @Route("/results", name="results")
     */
    public function index(Request $request, WeatherClient $weatherClient,  SessionInterface $session, Betfair $betfairClient)
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../public/json');
		$dailyWeather = [];
		$forecastWeather = [];
        $weekdays = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];

    	$form = $this->createForm(WeatherType::class);

    	$form->handleRequest($request);

        foreach ($finder as $file) {
            if ($file->getfileName() == 'alpha2code.json') {
                $contents = $file->getContents();
            }
        }

        $contents = json_decode($contents,true);


        if($form->isSubmitted()){
        	$data = $form->getData();
            foreach ($contents as $country) {
                if($data['country'] == $country['Name']){
                    $countryCode = $country['Code'];
                }
            }


            $countryCode = strtolower($countryCode);
        	$dailyWeather = json_decode($weatherClient->weatherSearch($data,$countryCode),true);
        	$forecastWeather = json_decode($weatherClient->forecastSearch($data,$countryCode),true);
            // $betfairResponse = $betfairClient->login('betpractice','Bpc@6712013');
            // $betfairResponse = $betfairClient->getAllTypes('WLsLIUabgRCGrxMf','3nPcCpmA+aw1uzxpGi8TXxBRj6T7vamxO/aMjBlZerc=');
        	foreach ($forecastWeather['list'] as $list ) {
        		$day = gmdate('D', $list['dt']);
                $weekdays[$day][]=$list;
        	}    
        }
        return $this->render('weather_results/index.html.twig', [
            'weatherForm' => $form->createView(),
            'file'=>$session->get('contents'),
            'countries'=>$session->get('keys'),
            'geoip' => $session->get('geoip'),
            'news' => $session->get('news'),
            'weather' => $dailyWeather,
            'weekdays' => $weekdays
        ]);
    }
}