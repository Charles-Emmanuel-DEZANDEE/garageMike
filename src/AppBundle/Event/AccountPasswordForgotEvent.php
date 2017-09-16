<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 19/07/2017
 * Time: 09:31
 */

namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class AccountPasswordForgotEvent extends Event
{
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


}