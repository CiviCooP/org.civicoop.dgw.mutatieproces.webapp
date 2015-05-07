<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AfdVerhuurType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('futureAddress', 'textarea', array(
          'required' => false,
          'label' => 'Toekomstig adres'
        ))
        ->add('opmAfdVerhuur', null, array(
          'required' => false,
          'label' => 'Opmerkingen'
         ))
    ;
  }


  public function getName() {
    return 'civicoop_vragenboombundle_afdverhuurtype';
  }

}
