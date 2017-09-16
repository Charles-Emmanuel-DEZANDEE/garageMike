<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 26/07/2017
 * Time: 09:16
 */

namespace AppBundle\Command;


use AppBundle\Entity\ExchangeRate;
use AppBundle\Entity\UserToken;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateExchangeRateCommande extends ContainerAwareCommand
{
    protected function configure()
    {
        /*
         * set name : commande à saisir
         * setDescription : command à saisir
         * addArgument : ajout d'un argument
         * */
        $this
            ->setName('app:exchangerate:update')
            ->setDescription('Update exchange rates')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // accés au container
        $container = $this->getContainer();

        //devises utilisées
        $currencies = $container->getParameter('currencies');

        //doctrine
        $doctrine = $container->get('doctrine');

        //API
        $listCurrencies = strtoupper(implode(',', $currencies));
        $apiContent = json_decode(file_get_contents("http://api.fixer.io/latest?symbols=$listCurrencies"));

        dump($apiContent);

        //requete
        $results = $doctrine->getRepository(ExchangeRate::class)->updateExchangeRateCommand($apiContent->rates);

        //réponse

        $output->writeln("<question>currencies updated</question>");



        //$output->writeln('OK');
    }

}