<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginFilter;

class LoginController extends AbstractActionController {

    public $authservice;

    public function indexAction() {
        $form = $this->getServiceLocator()->get('FormFactory');
        $loginForm = $form->getForm('Login');
        $viewModel = new ViewModel(array('form' => $loginForm));
        return $viewModel;
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array(
                        'controller' => 'login',
                        'action' => 'index'
                    ));
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('FormFactory');
        $loginForm = $form->getForm('Login');
        //$loginForm->setInputFilter(new LoginFilter());
        $loginForm->setData($post);
        
        if (!$loginForm->isValid()) {
            $model = new ViewModel(array(
                        'error' => true,
                        'form' => $loginForm,
                    ));
            $model->setTemplate('users/login/index');
            return $model;
        }
        $result = $this->getAuthService()->authenticateUser($this->request->getPost('email'), $this->request->getPost('password'));
        var_dump($result);
        if ($result->isValid()) {
            $this->getAuthService()->getStorage()->write($this->getAuthService()->getResult());
            return $this->redirect()->toRoute(NULL, array(
                        'controller' => 'login',
                        'action' => 'confirm'
                    ));
        }
    }

    public function confirmAction() {
        $user_object = $this->getAuthService()->getStorage()->read();
        $user_email = $user_object->email;
        $viewModel = new ViewModel(array('user_email' => $user_email));
        return $viewModel;
    }

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

}
