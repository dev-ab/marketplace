<?php

namespace Support\General;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class Authentication implements AuthenticationServiceInterface, FactoryInterface {

    protected $AuthService;
    protected $AuthAdapter;
    protected $ServiceLocator;

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $this->ServiceLocator = $serviceLocator;
        $this->AuthService = new AuthenticationService();
        return $this;
    }

    public function authenticateUser($identity, $credential, $identityType = 'email') {
        $this->setAuthAdapter();
        $this->AuthAdapter->setIdentityColumn($identityType)
                ->setIdentity($identity)
                ->setCredential($credential)
                ->setCredentialTreatment("MD5(CONCAT('staticSalt', ?, salt))");
        return $this->authenticate();
    }

    public function authenticate() {
        return $this->AuthService->authenticate($this->AuthAdapter);
    }

    public function getResult() {
        return $this->AuthAdapter->getResultRowObject();
    }

    public function setAuthAdapter() {
        if ($this->AuthAdapter) {
            return;
        }
        $this->AuthAdapter = new AuthAdapter($this->ServiceLocator->get('Zend\Db\Adapter\Adapter'));
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

}
