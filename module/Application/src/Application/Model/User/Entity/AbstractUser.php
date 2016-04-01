<?php

namespace Application\Model\User\Entity;

abstract class AbstractUser {
    protected $id;
    protected $login;
    protected $password;
    protected $email;
    protected $permission;
    protected $created;
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPermission() {
        return $this->permission;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPermission($permission) {
        $this->permission = $permission;
    }

    public function setCreated($created) {
        $this->created = $created;
    }
       
    public function exchangeData(array $data) {
        ($data['id'] != null) ? $this->setId($data['id']) : null;
        ($data['login'] != null) ? $this->setPassword($data['password']) : null;
        ($data['email'] != null) ? $this->setEmail($data['email']) : null;
        ($data['permission'] != null) ? $this->setPermission($data['permission']) : null;
        ($data['created'] != null) ? $this->setCreated($data['created']) : null;
    }
}