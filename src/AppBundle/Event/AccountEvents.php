<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 19/07/2017
 * Time: 09:27
 */

namespace AppBundle\Event;


class AccountEvents
{
    /* Liste d'événements sous forme de constante*/

    const PASSWORD_CHANGE = 'app.account.password.change';
    const PASSWORD_FORGOT = 'app.account.password.forgot';
}