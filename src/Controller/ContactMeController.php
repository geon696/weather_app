<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ContactMeController extends Controller
{
    /**
     * @Route("/contact-me", name="contact_me")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

    	$form = $this->createForm(ContactFormType::class);
    	$form->handleRequest($request);
    	if ($form->isSubmitted()) {
    		$data = $form->getData();
    		
    		$message = (new \Swift_Message('New Email'))
    					->setFrom($data['email'])
    					->setTo('bageorge123@gmail.com')
    					->setSubject($data['theme'])
    					->setBody(
    						$data['firstname'] ." ". $data['lastname']." sent you this message: ".$data['message'],'text/plain'
    					)
    		;
    		$mailer->send($message);
    		
    	}
        return $this->render('contact_me/index.html.twig', [
            'contactme' => $form->createView()
        ]);
    }
}
