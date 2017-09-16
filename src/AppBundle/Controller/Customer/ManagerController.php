<?php

namespace AppBundle\Controller\Customer;

use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/customer")
 */
class ManagerController extends Controller
{
    /**
     * @Route("/update", name="app.customer.manager.update")
     */
    public function updateAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $entity = $this->getUser();
        $entityType = UserType::class;

        $form = $this->createForm($entityType,$entity);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
/*            exit(dump($entity));*/
            //insertion
            $em->persist($entity);
            $em->flush();

            //message flash à faire
            $message =  "L'adresse à été ajoutée";
            $this->addFlash('notice', $message);

            // redirection
            $this->redirectToRoute('app.customer.homepage.index');

        }

        return $this->render('customer/manager/update.html.twig', [
                'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/password", name="app.customer.manager.password")
     */
    public function passwordAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $entity = $this->getUser();
        $entityType = UserType::class;

        $form = $this->createForm($entityType,$entity);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){
            //exit(dump($entity));
            //insertion

            $em->persist($entity);
            $em->flush();

            //message flash à faire
            $message =  "Le mot de passe à été modifié";
            $this->addFlash('notice', $message);

        }

        return $this->render('customer/manager/password.html.twig', [
                'form' => $form->createView()
        ]);
    }
}
