<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AddEntregoDocsSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SET_DATA => 'postSetData',
        );
      
    }
    
    public function postSetData(FormEvent $event)
    {

        $registro = $event->getData();

        $form = $event->getForm();

        if (null === $registro) {
            return;
        }

        $form->remove('entregoDocs');
        $form->add('entregoDocs', null, array(
                'attr' => array('nombre' => $registro->getAspiranteRfc()->getNombreCompleto(), 'regID'=>$registro->getId())
            )
        );
    }

}
