<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController {

    public function indexAction() {
        $form = $this->getServiceLocator()->get('FormFactory');
        $registerForm = $form->getForm('Register', FALSE);
        $viewModel = new ViewModel(array('form' => $registerForm));
        return $viewModel;
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array('controller' => 'register',
                        'action' => 'index'
                    ));
        }
        $post = $this->request->getPost();
        print_r($post);
        $form = $this->getServiceLocator()->get('FormFactory');
        $registerForm = $form->getForm('Register');
        $registerForm->setData($post);
        if (!$registerForm->isValid()) {
            //print_r($registerForm->getMessages());
            //print_r($registerForm->getData());
            $model = new ViewModel(array(
                        'error' => true,
                        'form' => $registerForm,
                    ));
            $model->setTemplate('users/register/index');
            return $model;
        }

        $this->createUser($registerForm->getData());
        return;
        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'register',
                    'action' => 'confirm'
                ));
    }

    public function confirmAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    protected function createUser($user) {
        $model = $this->getServiceLocator()->get('ModelFactory');
        $userTable = $model->getTable('Users');
        $userTable->saveUser($user);
        return true;
    }

}
