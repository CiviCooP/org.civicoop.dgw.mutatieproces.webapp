<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EindopnameType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('eindopname', 'datetime', array(
          'required' => true,
          'label' => 'Datum eindopname',
          'widget' => 'single_text',
          'format' => 'dd-MM-yyyy H:mm',
     ))
    ;
  }


  public function getName() {
    return 'civicoop_vragenboombundle_afdverhuurtype';
  }
  
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'CiviCoop\VragenboomBundle\Entity\AdviesRapport'
      ));
  }

}
