<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\IpApi as IpApiClient;
use App\Service\newsApi as NewsApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class WeatherController extends Controller
{
    /**
     * @Route("/", name="weather")
     */
    public function index(Request $request, IpApiClient $ipClient, NewsApiClient $newsClient, SessionInterface $session)
    {
    	
        $form = $this->createForm(WeatherType::class);
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../public/json');
        $geoip = [];
        $news = [];

        $news = $newsClient->getNews();
        $news = json_decode($news,true);
        $session->set('news',$news);

        foreach ($finder as $file) {
            if($file->getfileName()=='countries.min.json'){     
                $jsonContent = $file->getContents();
            }
        }
        
        $contents = json_decode($jsonContent,true);
        $geoip = json_decode($ipClient->getGeolocation(),true);
        $keys = array_keys($contents);
        $keys = json_encode($keys);

        $session->set('contents',$jsonContent);
        $session->set('geop',$geoip);
        $session->set('keys',$keys);

        return $this->render('weather/index.html.twig', [
            'weatherForm' => $form->createView(),
            'file'=>$session->get('contents'),
            'countries'=>$session->get('keys'),
            'geoip' => $session->get('geoip'),
            'news' => $session->get('news')
        ]);
    }
}