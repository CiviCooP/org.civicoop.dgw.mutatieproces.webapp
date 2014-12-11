<?php

namespace CiviCoop\VragenboomBundle\Form;

use CiviCoop\VragenboomBundle\Entity\Ruimte;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class AdviesRapportFactoryType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $actieUpdater = function (FormInterface $form, Ruimte $ruimte = null) {
      $acties = array();
      if ($ruimte !== null) {
        //fetch acties belonging to this room
        foreach($ruimte->getObjects() as $object) {
          foreach($object->getActies() as $actie) {
            $acties[$actie->getObjectActieLabel()] = $actie;
          }
        }
      }
      ksort($acties);

      $form->add('acties', 'entity', array(
        'class' => 'CiviCoopVragenboomBundle:ActieDefinitie',
        'property' => 'objectActieLabel',
        'choices' => $acties,
        'expanded' => true,
        'multiple' => true,
        'required' => false,
        'mapped' => false,
      ));
    };
    
    
    $builder->add('ruimte', 'entity', array(
      'class' => 'CiviCoopVragenboomBundle:Ruimte',
      'property' => 'naam',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('r')
            ->orderBy('r.naam', 'ASC');
      },
      'empty_value' => 'Kies een ruimte',
      'mapped' => true,
    ));
    
    $builder->get('ruimte')->addEventListener(
      FormEvents::POST_SET_DATA,
      function (FormEvent $event) use ($actieUpdater) {
        $ruimte = $event->getData();
        $actieUpdater($event->getForm()->getParent(), $ruimte);
      }
    );

    $builder->get('ruimte')->addEventListener(
      FormEvents::POST_SUBMIT,
      function (FormEvent $event) use ($actieUpdater) {
        $ruimte = $event->getForm()->getData();
        $actieUpdater($event->getForm()->getParent(), $ruimte);
      }
    );
  }

  public function getName() {
    return 'adviesrapportregel';
  }

}
