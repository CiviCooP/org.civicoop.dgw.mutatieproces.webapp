<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdviesRapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remarks')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CiviCoop\VragenboomBundle\Entity\AdviesRapport'
        ));
    }

    public function getName()
    {
        return 'civicoop_vragenboombundle_adviesrapporttype';
    }
}
