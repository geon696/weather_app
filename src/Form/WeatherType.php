<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WeatherType extends AbstractType
{
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('POST');
        $builder->setAction($this->router->generate('results'));

        $builder
            ->add('country', TextType::Class,[
                'attr'=>[
                    'class'=>'country typeahead',
                    'autocomplete'=>'off',
                    'placeholder'=>'Insert Country Here'
                ]
            ])
            ->add('city',TextType::class,[
                'attr'=>[
                    'class'=>'city typeahead',
                    'autocomplete'=>'off',
                    'placeholder'=>'Insert City Here'
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
