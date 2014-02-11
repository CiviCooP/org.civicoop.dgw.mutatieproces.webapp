<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdviesRapportFactoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('ruimte', 'entity', array(
				'class' => 'CiviCoopVragenboomBundle:Ruimte',
				'property' => 'naam',
				'empty_value' => 'Kies een ruimte',
			))
			->add('object', 'entity', array(
				'class' => 'CiviCoopVragenboomBundle:Object',
				'property' => 'naam',
				'empty_value' => 'Kies een object',
				'required' => false,
			))
			->add('actie', 'entity', array(
				'class' => 'CiviCoopVragenboomBundle:ActieDefinitie',
				'property' => 'actie',
				'empty_value' => 'Kies een actie',
				'required' => false,
			))
			->add('verantwoordelijke', 'choice', array(
         'choices' => array(
           'De Goede Woning' => 'De Goede Woning', 
           'Huurder' => 'Huurder',
           'Akkoord' => 'Akkoord',
           'Wordt overgenomen' => 'Wordt overgenomen',
           'Niet van toepassing' => 'Niet van toepassing'
        ), 
        'required' => true))
			->add('remark', 'textarea', array(
				'required' => false,
			))
        ;
    }

    public function getName()
    {
        return 'adviesrapportregel';
    }
}
