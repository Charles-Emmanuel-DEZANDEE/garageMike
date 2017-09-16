<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 20/07/2017
 * Time: 12:12
 */

namespace AppBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SparePartCategoryFormSubscriber implements EventSubscriberInterface
{
    private $locales;

    /**
     * SparePartCategoryFormSubscriber constructor.
     * @param $locales
     */
    public function __construct($locales)
    {
        $this->locales = $locales;
    }


    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit'
        ];
    }

    public function preSubmit(FormEvent $event){
        //saisie
        $data = $event->getData();

        //formulaire
        $form = $event->getForm();

        //entité
        $entity = $form->getData();

        // vient de doctrine behaviors
        //remplir les traductions
        foreach ($this->locales as $key => $value){
            $entity->translate($value)->setName($data['translations']["name_$value"]);
        }
        // fusionner les traductions
        $entity->mergeNewTranslations();

/*        exit(dump($data, $entity));*/
    }

}