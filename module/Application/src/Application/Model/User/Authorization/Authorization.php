<?php

namespace Application\Model\User\Authorization;

use Application\Model\User\Authorization\AbstractAuthorizationStrategy;
use Application\Model\User\Authorization\DefaultAuthorizationStrategy;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Application\Model\User\Factory\AbstractUserFactory;
use Application\Model\User\Factory\UserFactory;

class Authorization {
    private $authStrategy;
    private $dbAdapter;
    private $userFactory;
    
    public function setAuthorizationStrategy(AbstractAuthorizationStrategy $strategy){
        $this->authStrategy = $strategy;
    }
    
    public function setAuthAdapter(DbAdapter $adapter){
        $this->dbAdapter = $adapter;
    }
    
    public function setUserFactory(AbstractUserFactory $factory){
        $this->userFactory = $factory;
    }
    
    public function login($identity,$credential){
        if(!$this->authStrategy){
            $this->authStrategy = new DefaultAuthorizationStrategy();
        }
        
        if(!$this->dbAdapter){
            throw new Exception("Nie ustawiono adaptera!");
        }
        
        $this->authStrategy->setAdapter($this->dbAdapter);
        $this->authStrategy->setUserFactory(($this->userFactory) ? $this->userFactory : new UserFactory());
        
        return $this->authStrategy->login($identity,$credential);
    }
}

