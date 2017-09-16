<?php
namespace AppBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserFormSubscriber implements EventSubscriberInterface
{
    private $request;
    private $passwordEncoderService;

    /**
     * UserFormSubscriber constructor.
     * @param $request
     */
    public function __construct(RequestStack $request,UserPasswordEncoder $passwordEncoder)
    {
        $this->request = $request->getMasterRequest();
        $this->passwordEncoderService = $passwordEncoder;
    }


    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SET_DATA => 'postSetData',
            FormEvents::SUBMIT => 'presubmitSetData'
        ];
    }

    public function postSetData(FormEvent $event)
    {
        // données saisies
        $data = $event->getData();

        // on récupére la route utilisée
        $currentRoute = $this->request->get('_route');
        //dump($currentRoute);

        // builder du formulaire
        $form = $event->getForm();

        // objet relié au formulaire
        $entity = $form->getData();

        // si pas d'adresse d'enregistrée
        if ($entity){
        $isAddressFree = !empty($entity->getAddress());
        }
        //exit(dump($isAddressFree));

/*        // si nouvel utilisateur
        $isNewUser = $entity->getId();*/


        if($currentRoute == 'app.account.signin'){

            // cacher des champs
            $form
                ->remove('address.main')
            ;

        }
        // inscription d'un client par l'admin
        elseif ($currentRoute == 'app.admin.new.customer' || $currentRoute == 'app.admin.new.customer.update' ) {
            $form
                ->remove('username')
                ->remove('password')
                ->remove('main')
                ->remove('name')
            ;
        }
        // la création de la premiére adresse est principale par défault
        elseif ($currentRoute == 'app.customer.manager.update' && $isAddressFree == true) {
            $form
                ->remove('username')
                ->remove('email')
                ->remove('password')
                ->remove('address.main')
            ;
        }
        elseif ($currentRoute == 'app.customer.manager.update' && $isAddressFree == false) {
            $form
                ->remove('username')
                ->remove('email')
                ->remove('password')
            ;
        }
        elseif ($currentRoute == 'app.customer.manager.password') {
            $form
                ->remove('username')
                ->remove('email')
                ->remove('address')
            ;
        }
        //dump($data, $form, $entity);
    }

    public function presubmitSetData(FormEvent $event)
    {
        // données saisies
        $data = $event->getData();
        //exit(dump($event->getData()));

        // on récupére la route utilisée
        $currentRoute = $this->request->get('_route');
        //dump($currentRoute);

        // builder du formulaire
        $form = $event->getForm();

        // objet relié au formulaire
        $entity = $form->getData();

        //exit(dump($form));

        if ($currentRoute == 'app.customer.manager.password'){
            // encodage du mot de passe
            $encodedPassword = $this->passwordEncoderService->encodePassword($entity, $data->getPassword());
            //injection du pass hasher dans la bdd
            $entity->setPassword($encodedPassword);
            //dump($entity, $data);
        }

    }


    }