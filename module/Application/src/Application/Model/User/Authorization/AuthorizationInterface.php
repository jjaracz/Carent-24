<?php

namespace Application\Model\User\Authorization;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Application\Model\User\Factory\AbstractUserFactory;

interface AuthorizationInterface {
    public function login($identity,$credential);
    public function logout();
    public function setAdapter(AuthAdapter $authAdapter);
    public function getAdapter();
    public function setUserFactory(AbstractUserFactory $factory);
}
