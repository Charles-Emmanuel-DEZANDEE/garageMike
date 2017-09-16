<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BrandController extends Controller
{
    /**
     * @Route("/brand/{slugbrand}", name="app.brand.index")
     */
    public function indexAction(Request $request, $slugbrand)
    {
        $brand = $this->getDoctrine()->getRepository(Brand::class)->findOneBy(['name' => $slugbrand]);
        return $this->render('brand/index.html.twig', [
            'brand' => $brand,
            'slugbrand' => $slugbrand
        ]);
    }
}
