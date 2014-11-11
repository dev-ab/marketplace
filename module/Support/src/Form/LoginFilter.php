<?php

namespace Support\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'required' => true,
        ));
    }

}
