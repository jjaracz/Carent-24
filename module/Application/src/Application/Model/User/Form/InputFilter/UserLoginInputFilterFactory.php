<?php

namespace Application\Model\User\Form\InputFilter;

use Zend\InputFilter\InputFilter;

abstract class UserLoginInputFilterFactory {

    public static function createInputFilter() {
        $inputFilter = new InputFilter();

        $inputFilter->add(array(
            'name' => 'login',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'Podane pole jest puste.'
                        )
                    )
                )
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        
        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'Podane pole jest puste.'
                        )
                    )
                )
            ),
        ));
        
        return $inputFilter;
    }

}
