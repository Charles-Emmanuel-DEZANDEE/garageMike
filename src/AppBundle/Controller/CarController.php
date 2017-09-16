<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CarController extends Controller
{
    /**
     * @Route("/car/{slugcar}", name="app.car.index")
     */
    public function indexAction(Request $request, $slugcar)
    {
        $car = $this->getDoctrine()->getRepository(Car::class)->findOneBy(['model' => $slugcar]);
        return $this->render('car/index.html.twig', [
            'car' => $car,
            'slugcar' => $slugcar
        ]);
    }
}
