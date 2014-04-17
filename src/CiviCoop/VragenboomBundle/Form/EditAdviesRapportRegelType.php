<?php

namespace CiviCoop\VragenboomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditAdviesRapportRegelType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			
			->add('verantwoordelijke', 'choice', array(
         'choices' => array(
           'De Goede Woning' => 'De Goede Woning', 
           'Huurder' => 'Huurder',
           'Akkoord' => 'Akkoord',
           'Huurder (mag overgenomen worden)' => 'Huurder (mag overgenomen worden)',
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
        return 'editadviesrapportregel';
    }
}
