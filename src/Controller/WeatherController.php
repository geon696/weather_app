<?php

namespace App\Controller;

use App\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends Controller
{
    /**
     * @Route("/", name="weather")
     */
    public function index(Request $request)
    {
    	
        $form = $this->createForm(WeatherType::class);

        

        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'weatherForm' => $form->createView()
        ]);
    }
}
