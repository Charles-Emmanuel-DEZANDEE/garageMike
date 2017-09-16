<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class OrderController extends Controller
{
    /**
     * @Route("/order", name="app.admin.order")
     */
    public function indexAction(Request $request)
    {
        $user = $request->getUser();

        return $this->render('admin/order/order.html.twig', [
                'user' => $user
        ]);
    }
}
