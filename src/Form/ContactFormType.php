<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ContactFormType extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router){
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');
        $builder->setAction($this->router->generate('contact_me'));

        $builder
            ->add('firstname', TextType::Class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Insert your Name',
                    'required' => true
                ]
            ])
            ->add('lastname',TextType::Class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Insert your Last Name'
                ]
            ])
            ->add('email',EmailType::Class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Insert your Email here',
                    'required' => true
                ]
            ])
            ->add('message',TextareaType::Class,[
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Insert your message here',
                    'required' => true,
                    'rows' => '4'
                ]
            ])
            ->add('theme',TextType::Class,[
                'attr'=> [
                    'class' => 'form-control',
                    'placeholder' => 'Insert your message theme here',
                    'required' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
