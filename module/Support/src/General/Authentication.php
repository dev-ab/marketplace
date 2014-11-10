<?php

namespace Support\General;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Authentication implements AuthenticationServiceInterface, ServiceLocatorAwareInterface {

    protected $AuthService;
    protected $AuthAdapter;
    protected $ServiceLocator;

    function __construct() {
        $this->AuthService = new AuthenticationService();
    }

    public function authenticateUser($identity, $credential, $identityType = 'email') {
        $this->setAuthAdapter();
        $this->AuthAdapter->setIdentityColumn($identityType)
                ->setIdentity($identity)
                ->setCredential($credential)
                ->setCredentialTreatment("MD5(CONCAT('staticSalt', ?, salt))");
        return $this->authenticate($this->AuthAdapter);
    }

    public function authenticate() {
        return $this->AuthService->authenticate($this->AuthAdapter);
    }

    public function setAuthAdapter() {
        if ($this->AuthAdapter) {
            return;
        }
        $this->AuthAdapter = new AuthAdapter($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
        $this->AuthAdapter->setTableName('users')->setCredentialColumn('password');
    }

    public function hasIdentity() {
        return $this->AuthService->hasIdentity();
    }

    public function clearIdentity() {
        return $this->AuthService->clearIdentity();
    }

    public function getIdentity() {
        return $this->AuthService->getIdentity();
    }

    public function getStorage() {
        return $this->AuthService->getStorage();
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->ServiceLocator;
    }

}
