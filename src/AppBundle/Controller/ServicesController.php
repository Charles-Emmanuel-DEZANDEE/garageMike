<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends Controller
{
    /**
     * @Route("/services", name="app.services.index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('services/index.html.twig', [

        ]);
    }
}
