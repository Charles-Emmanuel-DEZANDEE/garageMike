<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 17/07/2017
 * Time: 09:28
 */

namespace AppBundle\Listener;


use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener
{
    private $passwordEncoderService;
    private $doctrine;

    public function __construct(UserPasswordEncoder $passwordEncoder, ManagerRegistry $doctrine)
    {
        $this->passwordEncoderService = $passwordEncoder;
        $this->doctrine = $doctrine;
    }

    /*
     * le méthodes doivent avoir strictement le nom de l'événement
     * paramétres:
     *  - le type de paramétre différe selon l'évenement écouté
     *  - instance de l'entité écoutée
     * */
    public function prePersist(User $entity, LifecycleEventArgs $args){
        // encodage du mot de passe
        $encodedPassword = $this->passwordEncoderService->encodePassword($entity, $entity->getPassword());
        //injection du pass hasher dans la bdd
        $entity->setPassword($encodedPassword);

        // selection d'un role pour l'utilisateur
        $rcRole = $this->doctrine->getRepository(Role::class);
        $role = $rcRole->findOneBy([
            'name' => 'ROLE_CUSTOMER'
        ]);

        //assigner un rôle
        $entity->addRole($role);

/*        dump($entity); exit;*/

    }

}