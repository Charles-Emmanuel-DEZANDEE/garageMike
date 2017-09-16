<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class SelectCustomerController extends Controller
{
    /**
     * @Route("/selectcustomer", name="app.admin.select.customer")
     */
    public function indexAction(Request $request)
    {
        $user = $request->getUser();

        return $this->render('admin/selectcustomer/selectecustomer.html.twig', [
                'user' => $user
        ]);
    }
}
