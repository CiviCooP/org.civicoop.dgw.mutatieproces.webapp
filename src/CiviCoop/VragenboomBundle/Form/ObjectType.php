<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('naam')
        ->add('ruimtes', 'entity', array(
          'class' => 'CiviCoopVragenboomBundle:Ruimte',
          'property' => 'naam',
          'expanded'  => true,
          'multiple'  => true
        ))
    ;
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'CiviCoop\VragenboomBundle\Entity\Object'
    ));
  }

  public function getName() {
    return 'civicoop_vragenboombundle_objecttype';
  }

}
