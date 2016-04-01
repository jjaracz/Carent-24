<?php

namespace Application\Model\User\Factory;

use Application\Model\User\Entity\User;

abstract class AbstractUserFactory {
    public static function createUser(array $data){
        $user = new User();
        $user->exchangeData($data);
        
        return $user;
    }
}

