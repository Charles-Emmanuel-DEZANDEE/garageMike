<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserToken;
use AppBundle\Event\AccountEvents;
use AppBundle\Event\AccountPasswordForgotEvent;
use AppBundle\Form\PasswordForgottenType;
use AppBundle\Form\UserType;
use AppBundle\Form\UserUpdatePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{

    /**
     * @Route("/password/forgotten", name="app.account.password.forgotten")
     */
    public function passwordForgottenAction(Request $request)
    {
/*        $entity = new UserToken();*/
        $entityType = PasswordForgottenType::class;

        $form = $this->createForm($entityType);
        $form->handleRequest($request);

        $interval = new \DateInterval('PT1D');


        if ($form->isSubmitted() && $form->isValid()){
            //récupération de la saisie
            $data = $form->getData();
            $email = $data['email'];

/*            // service de déclenchement d'événement
            $eventDispatcherService = $this->get('event_dispatcher');

            // instancie l'évenement
            $event = new AccountPasswordForgotEvent();

            //déclencher l'évenement
            $eventDispatcherService->dispatch(AccountEvents::PASSWORD_FORGOT, $event); exit;*/



            // on récupère l'entité


            $doctrine = $this->getDoctrine();
            $rcUserToken = $doctrine->getRepository(UserToken::class);

            $rcUser = $doctrine->getRepository(User::class);
            //on vérifie si l'email existe deja

            $userEmailExist = !empty($rcUser->findOneBy([
                'email' => $email
            ]));

            $user = $rcUser->findOneBy([
                'email' => $email
            ]);

            //message toujours affiché quelque soit le résultat
            $translator = $this->get('translator');

            $messageFlash = $translator->trans('authentication.failure.passwordForgotten.emailNoExit');
            $this->addFlash('notice', $messageFlash);


            // si non, on fait rien avec redirection vers la page de mot de passe oublié avec message d'info qui indique que c'est envoyé
            if (!$userEmailExist)
            {
                // on stop le process
                return $this->redirectToRoute('app.account.password.forgotten');

            }
            // si oui
            else
            {
                $token = null;
                // test si email exit dans usertoken
                $emailExistUserToken = !empty($rcUserToken->findOneBy([
                    'email' => $email
                ]));


                // si pas de demande de déja faite
                if (!$emailExistUserToken)
                {
                    //on fixe le temps de refresh du token
                    //on créé la date de création new Date()+ 1 jour
                    $newDate = new \Datetime();
                    $newDate->add($interval);

                    //on instancie une entitée
                    $newUserToken = new UserToken();

                    // on ajoute la date
                    $newUserToken->setDate($newDate);

                    // on créé le token
                    $token = $this->get('AppBundle\Service\StringUtilService')->generateToken(6);
/*                    $token = bin2hex(random_bytes(6));*/

                    // on l'ajoute le token
                    $newUserToken->setToken($token);

                    //on ajoute l'email
                    $newUserToken->setEmail($email);

                    // on met à jour la base
                    $em = $doctrine->getManager();
                    $em->persist($newUserToken);
                    $em->flush();
                }
                else
                {
/*dump($emailExistUserToken);exit;*/
                    // on vérifie si la date du jour est sup a +1 jour de la date enregistrée
                    $dateNow = new \Datetime();
                    $userTokenExist = $rcUserToken->findOneBy([
                        'email' => $email
                    ]);
                    $dateToken = $userTokenExist->getDate();
                    dump($dateToken, $dateNow);
/*dump($dateToken < $dateNow);exit;*/
                    // si non,
                    if($dateToken > $dateNow)
                    {
                        // message d'info que l'email a été envoyé (mensonge)
/*                        dump('trop court');dump($dateNow); dump($dateToken);exit;*/
                        return $this->redirectToRoute('app.account.password.forgotten');

                    }
                    // si oui, on continu
                    else
                    {
                        // on créé un nouveau le token
                        $token = bin2hex(random_bytes(6));

                        // on met à jour  le token
                        $userTokenExist->setToken($token);


                        //on créé la date de création new Date()+ 1 jour
                        $newDate = new \Datetime();
                        $newDate->add($interval);

                        // on met à jour la date
                        $userTokenExist->setDate($newDate);

                        // update dans la bdd
                        $em = $doctrine->getManager();
                        $em->persist($userTokenExist);
                        $em->flush();
/*                dump('cest bon');dump($dateNow); dump($dateToken);exit;*/
                    }
                }
            }
                    //on envoie l'email

                    //utilisation du service de mail
                    $message = (new \Swift_Message())
                        ->setFrom(['john@doe.com' => 'John Doe'])
                        ->setTo($email)
                        ->setSubject('nouveau mot de passe')
                        ->setBody($this->render('mailing/passwordForgotten/passwordForgotten.succes.txt.twig',[
                            'email' => $email,
                            'token' => $token,
                        ]))
                        ->addPart($this->render('mailing/passwordForgotten/passwordForgotten.succes.html.twig',[
                            'email' => $email,
                            'token' => $token,
                        ]),'text/html')
                    ;
                    // envoi du mail
                    $mailer= $this->get('mailer');
                    $mailer->send($message);


                    return $this->redirectToRoute('app.account.password.forgotten');
        }


        return $this->render('account/passwordForgotten.html.twig', [
            'form' => $form->createView()

        ]);

    }
    /**
     * @Route("/password/update/{email}/{token}", name="app.account.password.update")
     */
    public function updateAction(Request $request,$email, $token)
    {
        // Appel des services
        $doctrine = $this->getDoctrine();
        $entityType = UserUpdatePasswordType::class;
        $translator = $this->get('translator');

        $form = $this->createForm($entityType);
        $form->handleRequest($request);

        //on vérifie si l'email et le token match
        $rcUser = $doctrine->getRepository(User::class);
        $ExistUser = $rcUser->findOneBy([
            'email' => $email
        ]);
        $rcUserToken = $doctrine->getRepository(UserToken::class);
        $ExistUserToken = $rcUserToken->findOneBy([
            'email' => $email
        ]);
/*dump($ExistUserToken->getToken());exit;*/
        $tokenTest = $ExistUserToken->getToken();
        if ($tokenTest == $token){
            if ($form->isSubmitted() && $form->isValid()){
            //récupération de la saisie
            $data = $form->getData();
                //encodage du password

                //appel du service
                $passwordEncoderService = $this->get('security.password_encoder');
                // encodage du mot de passe
                $encodedPassword = $passwordEncoderService->encodePassword($ExistUser, $data['password']);
                // on met à jour le mot de passe
                $ExistUser->setPassword($encodedPassword);

                // update dans la bdd
                $em = $doctrine->getManager();
                $em->persist($ExistUser);
                $em->flush();

                //message flash de succes
                $messageFlash = $translator->trans('authentication.success.updatePassword');
                $this->addFlash('notice', $messageFlash);

            }
        return $this->render('account/update.html.twig', [
            'form' => $form->createView()

        ]);

        }
        //  si ça ne concorde pas => redirection avec message token faux
        else{
            $messageFlash = $translator->trans('authentication.failure.passwordForgotten.tokenExpired');
            $this->addFlash('notice', $messageFlash);

            return $this->redirectToRoute('app.account.password.forgotten');

        }
    }
    /**
     * @Route("/signin", name="app.account.signin")
     */
    public function signinAction(Request $request)
    {
        $entity = new User();
        $entityType = UserType::class;

        $form = $this->createForm($entityType, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //dump($entity); exit;

/*  // on déplace cette action dans userlistener
     //encodage du password

            //appel du service
            $passwordEncoderService = $this->get('security.password_encoder');
            // encodage du mot de passe
            $encodedPassword = $passwordEncoderService->encodePassword($entity, $entity->getPassword());
            //injection du pass hasher dans la bdd
            $entity->setPassword($encodedPassword);

            // selection d'un role pour l'utilisateur
            $rcRole = $doctrine->getRepository(Role::class);
            $role = $rcRole->findOneBy([
                'name' => 'ROLE_CUSTOMER'
            ]);

            //assigner un rôle
            $entity->addRole($role);
*/
            $doctrine = $this->getDoctrine();

            //dump($entity);exit;

            // insertion dans la bdd
            $em = $doctrine->getManager();
            $em->persist($entity);
            $em->flush();

            //message flash
            $translator = $this->get('translator');
            $message = $translator->trans('entity.user.flashmessage.add');
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.security.login');
        }
        return $this->render('account/index.html.twig', [
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/redirect-by-role", name="app.account.redirect.by.role")
     */
    public function redirectByRoleAction(Request $request)
    {
        $user = $this->getUser();
        $route = null;
        if (in_array('ROLE_ADMIN', $user->getRoles() ))
        {
            $route = 'app.admin.homepage.index';
        }
        elseif (in_array('ROLE_EMPLOYEE', $user->getRoles() ))
        {
            $route = 'app.admin.homepage.index';
        }
        elseif (in_array('ROLE_CUSTOMER', $user->getRoles() ))
        {
            $route = 'app.customer.homepage.index';
        }
        return $this->redirectToRoute($route);

    }


}
