<?php

namespace Support\Form;

use Zend\Form\Fieldset;
//use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Support\Entity\Users;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersFieldset extends Fieldset implements ServiceLocatorAwareInterface {

    protected $ServiceLocator;

    public function __construct() {
        parent::__construct('Users');
    }

    public function init() {
        //parent::init();
        $this->setHydrator(new ClassMethods(false))
                ->setObject(new Users());

        $this->add(array(
            'name' => 'email',
            'type' => 'Email',
            'options' => array(
                'label' => 'Email Address'
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Type Your Password'
            ),
        ));
        $this->add(array(
            'name' => 'fullName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Enter your full name'
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Email Address'
            ),
        ));
        $this->add(array(
            'type' => 'Select',
            'name' => 'country',
            'options' => array(
                'label' => 'Where you from?',
                'empty_option' => 'Please choose your country',
                'value_options' => $this->getCountries(),
            )
        ));
    }

    public function getCountries() {
        print_r($this->getServiceLocator());
        $model = $this->getServiceLocator()->get('ModelFactory');
        $countriesTable = $model->getTable('Countries');
        $result = $countriesTable->fetchAll()->toArray();
        $countries = array();
        foreach ($result as $index => $array) {
            $countries[$array['id']] = $array['countryName'];
        }
        return $countries;
    }

    public function getInputFilterSpecification() {
        
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

}
