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
use Symfony\Component\Process\Process;

class MysqlDumpCommande extends ContainerAwareCommand
{
    protected function configure()
    {
        /*
         * set name : commande à saisir
         * setDescription : command à saisir
         * addArgument : ajout d'un argument
         * */
        $this
            ->setName('app:mysql:dump')
            ->setDescription('Dump Mysql database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //nom de fichier
        $date = new \DateTime();
        $format = $date->format('Y-m-d');
        $filename = "$filename";

        // commande
        $command = "mysqldump -u root -proot garage > var/dump/$filename.sql && cd var/dump && zip $filename.zip $filename.sql && rm $filename.sql";

        //processus
        $process = new Process($command);

        //test
        try{
        $process->run();
            $message = '<info>Dump OK<info>';
        } catch (\Exception $e){
            $message = "<error>{$e->getMessage()}</error>";
        }
        //envois par mail
        $mail = (new \Swift_Message())
            ->setFrom('admin@admin.fr')
            ->setSubject("Dump SQL - $format")
            ->setBody("Dump SQL - $format")
            ->attach(\Swift_Attachment::fromPath("var/dump/$filename.zip"))
        ;

        //mailer
        $mailer = $this->getContainer()->get('mailer');

        //envoi par mail
        $mailer->send($mail);


        //réponse

        $output->writeln($message);



        //$output->writeln('OK');
    }

}