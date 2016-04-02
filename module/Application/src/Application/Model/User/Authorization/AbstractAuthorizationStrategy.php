<?php

namespace Application\Model\User\Authorization;

use Application\Model\User\Authorization\AuthorizationInterface;
use Zend\Session\Container;
use Application\Model\User\Factory\AbstractUserFactory;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

abstract class AbstractAuthorizationStrategy implements AuthorizationInterface {
    private $authAdapter;
    private $userFactory;
    
    public function login($identity,$credential){
        if(!$this->authAdapter){
            throw new Exception("Nie ustawiono adaptera!");
        }
        
        $this->authAdapter->setIdentity($identity);
        $this->authAdapter->setCredential($credential);
        
        $result = $this->authAdapter->authenticate();

        if($result->isValid()){       
            $container = new Container('user');
            $container->user = $this->userFactory->createUser((array)$this->authAdapter->getResultRowObject());
        }
        
        return $result;
    }
    
    public function logout(){
        
    }
    
    public function setAdapter(AuthAdapter $authAdapter){
        $this->authAdapter = $authAdapter;
    }
    
    public function getAdapter(){
        return $this->authAdapter;
    }
    
    public function setUserFactory(AbstractUserFactory $factory){
        $this->userFactory = $factory;
    }
}

