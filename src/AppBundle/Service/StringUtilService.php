<?php
/**
 * Created by PhpStorm.
 * User: charles-emmauel
 * Date: 19/07/2017
 * Time: 10:18
 */

namespace AppBundle\Service;


class StringUtilService
{
    public function generateToken($length){
        $result = bin2hex(random_bytes($length));
        return $result;
    }

}