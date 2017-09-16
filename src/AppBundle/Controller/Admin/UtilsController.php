<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @Route("/admin")
 */
class UtilsController extends Controller
{
    /**
     * @Route("/utils", name="app.admin.utils.index")
     */
    public function indexAction(Request $request, KernelInterface $kernel)
    {
        // créer une application
        $app = new Application($kernel);
        $app->setAutoExit(false);

        //commande

        $input = new ArrayInput([
            'command' => 'app:exchangerate:update'
        ]);

        // réponse
        $output = new BufferedOutput();

        //executer la commande
        $app->run($input,$output);

        //récupérartion d ela réponse
        $response = $output->fetch();

        return $this->render('admin/utils/index.html.twig', [
            'response' => $response
        ]);
    }
}
