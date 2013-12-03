<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActieDefinitieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', 'entity', array(
				'class' => 'CiviCoopVragenboomBundle:Object',
				'property' => 'naam',
			))
			->add('actie')
            ->add('description')
            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CiviCoop\VragenboomBundle\Entity\ActieDefinitie'
        ));
    }

    public function getName()
    {
        return 'civicoop_vragenboombundle_actiedefinitietype';
    }
}
