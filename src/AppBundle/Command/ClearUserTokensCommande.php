<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 26/07/2017
 * Time: 09:16
 */

namespace AppBundle\Command;


use AppBundle\Entity\UserToken;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearUserTokensCommande extends ContainerAwareCommand
{
    protected function configure()
    {
        /*
         * set name : commande à saisir
         * setDescription : command à saisir
         * addArgument : ajout d'un argument
         * */
        $this
            ->setName('app:clear:usertoken:clear')
            ->setDescription('Remove user tokens older than a day')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // accés au container
        $container = $this->getContainer();

        //doctrine
        $doctrine = $container->get('doctrine');

        //requete
        $results = $doctrine->getRepository(UserToken::class)->clearUserTokenCommand();

        //réponse

        $output->writeln("<question> $results lines modified</question>");



        //$output->writeln('OK');
    }

}