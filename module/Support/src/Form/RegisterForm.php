<?php

namespace Support\Form;

use Zend\Form\Form;
use Zend\Captcha;

class RegisterForm extends Form implements \Zend\ServiceManager\ServiceLocatorAwareInterface {

    protected $ServiceLocator;

    public function __construct($name = null) {
        parent::__construct('Register');
    }

    public function prepareElements() {
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/formdata');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'value' => '0'
            ),
        ));
        $this->add(array(
            'name' => 'fullname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Full Name',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
            ), 'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'required' => 'required'
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'messages' => array(\Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid')
                    )
                )
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'options' => array(
                'label' => 'Where you from?',
                'empty_option' => 'Please choose your country',
                'value_options' => $this->getCountries(),
            )
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'confirm_password',
            'attributes' => array(
                'type' => 'password',
            ),
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

    public function getCountries() {
        $model = $this->getServiceLocator()->get('ModelFactory');
        $countriesTable = $model->getTable('Countries');
        $result = $countriesTable->fetchAll()->toArray();
        $countries = array();
        foreach ($result as $index => $array) {
            $countries[$array['id']] = $array['country_name'];
        }
        return $countries;
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

}