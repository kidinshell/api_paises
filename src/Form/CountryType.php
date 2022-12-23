<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CountryType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('countryName', TextType::class, array(
            'label' => 'Nombre del País'
        ));

        $builder->add('countryCode', TextType::class, array(
            'label' => 'Código'
        ));

        $builder->add('countryCapital', TextType::class, array(
            'required'   => false,
            'label' => 'Capital'
        ));

        $builder->add('countryPopulation', TextType::class, array(
            'required'   => false,
            'label' => 'Población'
        ));

         $builder->add('countryFlag', TextType::class, array(
            'required'   => false,
            'label' => 'Imagen de la Bandera (URL)'
        ));

        $builder->add('submit', SubmitType::class, array(
            'label' => 'Enviar Datos'
        ));
    }
}

