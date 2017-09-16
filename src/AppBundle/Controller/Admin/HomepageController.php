<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="app.admin.homepage.index")
     */
    public function indexAction(Request $request)
    {
        $user = $request->getUser();

        return $this->render('admin/homepage/index.html.twig', [
                'user' => $user
        ]);
    }
}
