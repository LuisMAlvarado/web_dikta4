<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class AddRegsCompSubscriber implements EventSubscriberInterface
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
        //$con1=$registro->getConcurso();
        //dump($registro);exit();
        //dump($con1);exit();

        $form = $event->getForm();

        if (null === $registro) {
            return;
        }

        $form->remove('puntaje');
        $form->add('puntaje', null, array(
                'attr' => array('nombre' => $registro->getAspiranteRfc()->getNombreCompleto())
            )
        );
    }

}
