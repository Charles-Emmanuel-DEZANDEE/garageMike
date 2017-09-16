<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 17/07/2017
 * Time: 10:46
 */

namespace AppBundle\Subscriber;


use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $twig;
    private $request;
    private $session;

    /*
     * retourne un tableau d'évenements relié à un gestionnaire d'évenements
     * */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, RequestStack $request, SessionInterface $session)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->request = $request->getMasterRequest();
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'success',
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'failure'
        ];
    }

    /**
     * @return \Swift_Mailer
     */
    public function failure(AuthenticationFailureEvent $event)
    {
        //tester lexistence de la clef
        if (!$this->session->has('authentication_failure_count')){
            //création de la clef
            $this->session->set('authentication_failure_count',1);
        }
        // si la clef existe
        else {
            $count = $this->session->get('authentication_failure_count');
            $count++;
            $this->session->set('authentication_failure_count', $count);
        }

    }

    public function success(AuthenticationEvent $event){
        if($event->getAuthenticationToken()->getUser() instanceof User){
        //utilisateur connecté
            $user = $event->getAuthenticationToken()->getUser();
        //utilisation du service de mail
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo($user->getEmail())
            ->setSubject('connexion')
            ->setBody($this->twig->render('mailing/connexion/authentication.succes.txt.twig',[
                'username' => $user->getUsername(),
                'ip' => $this->request->getClientIp()
            ]))
            ->addPart($this->twig->render('mailing/connexion/authentication.succes.html.twig',[
                'username' => $user->getUsername(),
                'ip' => $this->request->getClientIp()
            ]),'text/html')
        ;
        // envoi du mail
            $this->mailer->send($message);

        };

    }

}