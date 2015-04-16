<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ToekomstAdresType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('street_address', null, array(
        'label' => 'Adres',
        'required' => false,
      ))
      ->add('supplemental_address_1', null, array(
        'label' => 'Adres toevoeging',
        'required' => false,
      ))
      ->add('postal_code', null, array(
        'label' => 'Postcode',
        'required' => false,
      ))
      ->add('city', null, array(
        'label' => 'Woonplaats',
        'required' => false,
      ))
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
