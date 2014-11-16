<?php

namespace Support\Form;

use Zend\Form\Form;
use Zend\Captcha;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class RegisterForm extends Form implements InputFilterProviderInterface, ServiceLocatorAwareInterface {

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

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'value' => '0'
            ),
        ));
        $this->add(array(
            'name' => 'confirm_password',
            'type' => 'password',
            'options' => array(
                'label' => 'Confirm Password',
            ),
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
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Register',
            ),
        ));
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

    public function getInputFilterSpecification() {
        return array(
            'confirm_password' => array(
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => array('user' => 'password'),
                        ),
                    )
                )
            )
        );
    }

}
