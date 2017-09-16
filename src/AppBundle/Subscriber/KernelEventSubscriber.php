<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 24/07/2017
 * Time: 13:45
 */

namespace AppBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $maintenance;
    private $session;

    /**
     * KernelEventSubscriber constructor.
     * @param $twig
     */
    public function __construct(\Twig_Environment $twig, $maintenance, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->maintenance = $maintenance;
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'maintenanceMode',
            KernelEvents::RESPONSE => 'securityHeader',
/*            KernelEvents::RESPONSE => 'cookiesDisclaimer'*/
        ];
    }

    public function MaintenanceMode(GetResponseEvent $event){
        if ($this->maintenance) {
        // contenu de la réponse
        $contentResponse = $this->twig->render('maintenance/maintenance.html.twig');


        // réponse
        $response = new Response($contentResponse, 503);

        // retourner une réponse (response)
        return $event->setResponse($response);

        }
    }

    public function securityHeader(FilterResponseEvent $event){
        //récupérartion de la réponse / requete
        $response = $event->getResponse();
        $request = $event->getRequest();
        // on ajoute des ententes à celles existantes
        $headers = [
            'Content-Security-Policy: default-src https:',
            'Strict-Transport-Security: max-age=63072000'

        ];


        // modification de la réponse
        $newResponse = new Response($response->getContent(), $response->getStatusCode(),$headers);


        //retourner une réponse
        return $event->setResponse($newResponse);
    }

    public function cookiesDisclaimer(FilterResponseEvent $event){
        if (!$this->session->has('cookie-disclaimer')){
             //récupérartion de la réponse / requete
            $content = $event->getResponse()->getContent();

            $newContent = str_replace('<body>', '<body><div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close close-cookie-disclaimer" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Warning!</strong> Better check yourself, you\'re not looking too good.
    </div>', $content);

            //modif de de la réponse
            $response = new Response($newContent);


            // retourner une réponse (response)
            return $event->setResponse($response);

            }

        }

}