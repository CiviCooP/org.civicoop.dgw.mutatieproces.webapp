<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('email', null, array(
          'attr'=> array('class'=>'text') //make sure the layout is like a text field
        ))
        ->add('phone')
        ->add('toekomst_adres', new ToekomstAdresType(), array(
          'label' => 'Toekomstig adres'
        ))
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'CiviCoop\VragenboomBundle\Entity\Client',
      'cascade_validation' => true,
    ));
  }

  public function getName() {
    return 'civicoop_vragenboombundle_clienttype';
  }

}
