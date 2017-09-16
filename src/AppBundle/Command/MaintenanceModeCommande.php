<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 26/07/2017
 * Time: 09:16
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaintenanceModeCommande extends ContainerAwareCommand
{
    protected function configure()
    {
        /*
         * set name : commande à saisir
         * setDescription : command à saisir
         * addArgument : ajout d'un argument
         * */
        $this
            ->setName('app:maintenance:mode')
            ->setDescription('enable or disable maintenance mode')
            ->addArgument('active', InputArgument::REQUIRED, 'true to enable, false to disable')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // récupération des arguments
        $active = $input->getArgument('active');

        //tester l'argument
        if($active !== 'true' && $active !== 'false'){
            throw new \InvalidArgumentException('you must use true or false!');
        }

        //traitement
        $file = file_get_contents('app/config/maintenance.yml');
        //dump($file);
        $content = preg_replace('/maintenance: (true|false)/',"maintenance: $active", $file);
        //dump($content);
        file_put_contents('app/config/maintenance.yml', $content);

        //réponse
        $response = $active === 'true' ? '<comment>maintenance : enable</comment>' : '<comment>maintenance : disable</comment>';


        $output->writeln($response);
        //$output->writeln('OK');
    }

}