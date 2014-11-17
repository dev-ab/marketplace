<?php

namespace Support\Form;

use Zend\Form\Form;
use Zend\Captcha;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class ProfileForm extends Form {

    protected $ServiceLocator;

    public function __construct($name = null) {
        parent::__construct('Register');
    }

    public function prepareElements() {
        $this->setAttribute('method', 'post')
                ->setHydrator(new ClassMethods(false))
                ->setInputFilter(new InputFilter());
        $this->setAttribute('enctype', 'multipart/formdata');
        $this->add(array(
            'name' => 'user',
            'type' => 'Support\Form\UsersFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

        $captcha = new Captcha\Image();
        $captcha->setFont(__dir__ . '/accid___.ttf');
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => $captcha,
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Register',
            ),
        ));
        $this->setValidationGroup(array(
            //'csrf',
            'user' => array(
                'fullName',
                'country',
            )
        ));
    }

}
