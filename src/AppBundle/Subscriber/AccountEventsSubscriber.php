<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 19/07/2017
 * Time: 09:38
 */

namespace AppBundle\Subscriber;


use AppBundle\Entity\User;
use AppBundle\Event\AccountEvents;
use AppBundle\Event\AccountPasswordChangeEvent;
use AppBundle\Event\AccountPasswordForgotEvent;
use AppBundle\Service\StringUtilService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccountEventsSubscriber implements EventSubscriberInterface
{
    private $doctrine;
    private $translator;
    private $stringUtils;
    private $mailer;

    public function __construct(ManagerRegistry $doctrine, Translator $translator, StringUtilService $stringUtils, \Swift_Mailer $mailer)
    {
        $this->doctrine = $doctrine;
        $this->translator = $translator;
        $this->stringUtils = $stringUtils;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return[
            AccountEvents::PASSWORD_CHANGE => 'passwordChange',
            AccountEvents::PASSWORD_FORGOT => 'passwordForgot',
        ];
    }

    public function passwordChange(AccountPasswordChangeEvent $event){
        dump('password change event');
    }
    public function passwordForgot(AccountPasswordForgotEvent $event){
/*        dump('password forgot event');*/
/*        $rcUser = $this->doctrine->getRepository(User::class);
        //on vérifie si l'email existe deja

        $userEmailExist = !empty($rcUser->findOneBy([
            'email' => $event->getEmail()
        ]));

        $user = $rcUser->findOneBy([
            'email' => $event->getEmail()
        ]);*/


    }

}