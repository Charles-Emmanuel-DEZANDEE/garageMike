<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brand;
use AppBundle\Entity\ExchangeRate;
use AppBundle\Entity\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax", name="app.ajax.test")
     */
    public function testAction(Request $request)
    {
        // récupération de la réponse
        $myvar = $request->request->get('myvar');
        $myvar2 = $request->request->get('myvar2');

        // réponse json
        $reponse = [
          'data' => [
              'myvarResult' => $myvar,
              'myvarResult2' => $myvar2,
          ]
        ];

        // réponse json
        return new JsonResponse($reponse);
    }

    /**
     * @Route("/change-currency", name="app.ajax.change.currency")
     */
    public function changeCurrencyAction(Request $request)
    {
        // récupération des données en POST
        $currency = $request->request->get('currency');

        //récupération du taux de change
        $exchangeRate = $this->getDoctrine()->getRepository(ExchangeRate::class)->findOneBy([
            'code' => $currency
        ]);

        // session
        $session = $request->getSession();
        $session->set('currency',[
            'code' => $exchangeRate->getCode(),
            'rate' => $exchangeRate->getRate()
        ] );
/*        $session->remove('currency');*/

        // reponse
        $response = [
            'response' => 'change currency OK'
        ];

        return new JsonResponse($response);

    }

    /**
     * @Route("/cookie-disclaimer", name="app.ajax.cookie.disclaimer")
     */
    public function changeCookieDisclaimerAction(Request $request)
    {
        //session
        $session = $request->getSession();

        //entrée dans la session
        $session->set('cookie-disclaimer', true);

        return new Response();

    }

    /**
     * @Route("/form-brand-model", name="app.ajax.form.brand.model")
     */
    public function changeFormBrandModelAction(Request $request)
    {
        // récupération des données en POST
        $idBrand = $request->request->get('data');


        $listModel = $this->getDoctrine()->getRepository(Model::class)->findAllToArray($idBrand);


        //exit(dump($listModel));

        return new JsonResponse($listModel);

    }

}
