<?php
/**
 * Created by PhpStorm.
 * User: wap55
 * Date: 04/07/17
 * Time: 13:49
 */

namespace AppBundle\Twig;


use AppBundle\Controller\HomepageController;
use AppBundle\Entity\Brand;
use AppBundle\Entity\SparePartCategory;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class AppExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{

    private $doctrine;
    private $twig;
    private $currencies;
    private $currency;
    private $session;
    private $router;
    private $request;
    private $locales;

    //injection des services dans le constructeur
    public function __construct(ManagerRegistry $doctrine,Environment $twig, $currencies, $currency, SessionInterface $session, RouterInterface $router, RequestStack $request, $locales )
    {
        $this->twig = $twig;
        $this->doctrine = $doctrine;
        $this->currencies = $currencies;
        $this->currency = $currency;
        $this->session = $session;
        $this->router = $router;
        $this->request = $request->getMasterRequest();
        $this->locales = $locales;

    }


    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('date_diff_in_word', [$this, 'dateDiffInWord']),
            new \Twig_SimpleFunction('generate_nav', [$this, 'generateNav']),
            new \Twig_SimpleFunction('generate_currencies', [$this, 'generateCurrencies']),
            new \Twig_SimpleFunction('calculate_price_from_currency', [$this, 'calculatePriceFromCurrency']),
            new \Twig_SimpleFunction('generates_languages', [$this, 'generateLanguages']),

        ];
    }

    public function generateLanguages(){
        $route = $this->request->get('_route');
        $routeParams = $this->request->get('_route_params');
/*        dump($route,$routeParams);*/

        foreach ($this->locales as $key => $value){
            // remplacer la locale
            $newRouteParams['_locale'] = $value;
            $routes = [];

            //remplacer les variable d'url
            if (array_key_exists('spartPartCategory', $routeParams)){
                $rc = $this->doctrine->getRepository(SparePartCategory::class)->getOneBySlug($routeParams['spartPartCategory']);

                $results = $rc->translate($value)->getSlug();

                $newRouteParams['spartPartCategory'] = $results;
            }

            // fusionner les paramétre de la route
            $merge = array_merge($routeParams, $newRouteParams);

            //création de l'url finale
            $url = $this->router->generate($route, $merge);

            //routes
            $routes[$value] = $url;

/*            dump($url);*/
        }

        return $this->twig->render('inc/languages.html.twig', [
            'routes' => $routes

        ]);
    }

    public function dateDiffInWord($start,$end){
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $diff = $start->diff($end);

        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];
    }

    public function calculatePriceFromCurrency($price){
        if (($this->session->has('currency'))){
            $rate = $this->session->get('currency')['rate'];
            $price *= $rate;
        }

    }


    public function generateNav(){
        //récupération des résultats
        $brands = $this->doctrine->getRepository(Brand::class)->findAll();

        //renvoi d'une vue partielle

        return $this->twig->render('homepage/nav.html.twig',[
            'brands' => $brands
        ]);
    }

    public function generateCurrencies(){
        // renvois des données dans la vue
        return $this->twig->render('inc/currencies.html.twig', [
            'currencies'  => $this->currencies
        ]);
    }



    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('hidden_link', [$this, 'hiddenLink'])
        ];
    }
    public function hiddenLink($value){
        $result = preg_replace('/<a .*\/a>/', '[hidden link]', $value);
        return $result;
    }

    public function getGlobals()
    {
        return [
            'code_GA' => 'XXX-XXX-XXX-XXX',
            'current_currency' => $this->session->has('currency') ? $this->session->get('currency')['code'] : $this->currency
        ];
    }


}