<?php

namespace AppBundle\Controller\Customer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/customer")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="app.customer.homepage.index")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        return $this->render('customer/homepage/index.html.twig', [
                'user' => $user
        ]);
    }
}
