<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Car;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAdress;
use AppBundle\Form\UserType;
use DoctrineExtensions\Query\Mysql\Now;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class NewCustomerController extends Controller
{
    /**
     * @Route("/newcustomer", name="app.admin.new.customer", defaults={"id" : null })
     * @Route("/newcustomer/update/{id}", name="app.admin.new.customer.update")
     */
    public function formAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $rcUser = $doctrine->getRepository(User::class);


        $userEntity = $id ? $rcUser->find($id) : new User();
        $userEntityType = UserType::class;

/*                exit(dump($userEntityType, $userEntity));*/
        $form = $this->createForm($userEntityType, $userEntity);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if($id){
            // handle
            $saisie = $form->getData();

            //address
            //entity
            $userAddress = new UserAdress();

            //set entity

            $userAddress->setCity($form->get('address')->getData()->getCity());
            $userAddress->setCity($form->get('address')->getData()->getCity());
            $userAddress->setCity($form->get('address')->getData()->getCity());


            $userEntity->addAddress($userAddress);

            $em->persist($userAddress);
            //car
            $car = new Car();
            $form->get('car')->getData()->getBrand()->getName();


            $userEntity->addCar($car);
            $em->persist($car);
            }

            $dateNow = new \Datetime();
            // date  de création du client
            $userEntity->setDatetimeCreateAccount($dateNow);


            //insertion
            $em->persist($userEntity);

            $em->flush();

            //message flash
            $message = $id ? 'Le contact a été mis à jour' : 'Le contact a été inséré';
            $this->addFlash('notice', $message);

            // redirection
            $this->redirectToRoute('app.admin.homepage.index');

        }

        return $this->render('admin/newcustomer/newCustomer.html.twig', [
            'form' => $form->createView(),
            'model'
        ]);
    }
}
