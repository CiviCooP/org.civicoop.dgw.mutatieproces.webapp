<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ToekomstAdresType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('street_address')
      ->add('supplemental_address_1')
      ->add('postal_code')
      ->add('city')
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'CiviCoop\VragenboomBundle\Entity\ToekomstAdres'
    ));
  }

  public function getName() {
    return 'civicoop_vragenboombundle_toekomstadrestype';
  }

}
