<?php

namespace Application\Model\User\Form;

use Zend\Form\Form;

class UserLoginForm extends Form {

    public function __construct() {
        parent::__construct('UserLoginForm');

        $this->add(array(
            'name' => 'login',
            'type' => 'text',
            'attributes' => array(
                'class' => '', // wprowadź sobie klase/y
                'placeholder' => 'Login',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'attributes' => array(
                'class' => '', // wprowadź sobie klase/y
                'placeholder' => 'Hasło'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'id' => 'submitbutton',
                'value' => 'Wyślij',
                'class' => '' // wprowadź sobie klase/y
            )
        ));
    }

}
