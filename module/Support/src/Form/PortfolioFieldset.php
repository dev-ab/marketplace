<?php

namespace Support\Form;

use Zend\Form\Fieldset;
//use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Support\Entity\UsersPortfolio;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PortfolioFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface {

    protected $ServiceLocator;

    public function __construct() {
        parent::__construct('Users');
    }

    public function init() {
        parent::init();
        $this->setHydrator(new ClassMethods(false))
                ->setObject(new UsersPortfolio());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
            'attributes' => array(
                'value' => 'null'
            )
        ));
        $this->add(array(
            'name' => 'subject',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Textarea',
        ));
    }

    public function getCountries() {
        $model = $this->getServiceLocator()->getServiceLocator()->get('ModelFactory');
        $countriesTable = $model->getTable('Countries');
        $result = $countriesTable->fetchAll()->toArray();
        $countries = array();
        foreach ($result as $index => $array) {
            $countries[$array['id']] = $array['country_name'];
        }
        return $countries;
    }

    public function getInputFilterSpecification() {
        return array(
            'subject' => array(
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
            ),
            'description' => array(
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
            ),
        );
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

}
