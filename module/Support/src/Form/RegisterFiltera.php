<?php

namespace Support\Form;

use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter {

    public function __construct() {


        $this->add(array(
            'name' => 'id',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                        'messages' => array(\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid')
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'fullname',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 140,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'country',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Digits',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Digits',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'confirm_password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                )
            )
        ));
    }

}
