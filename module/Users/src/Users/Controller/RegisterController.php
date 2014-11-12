<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController {

    public function indexAction() {
        $form = $this->getServiceLocator()->get('FormFactory');
        $registerForm = $form->getForm('Register');
        $viewModel = new ViewModel(array('form' =>
                    $registerForm));
        return $viewModel;
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL, array('controller' => 'register',
                        'action' => 'index'
                    ));
        }
        $post = $this->request->getPost();
        $form = $this->getServiceLocator()->get('FormFactory');
        $registerForm = $form->getForm('Register');
        $registerForm->setData($post);
        if (!$registerForm->isValid()) {
            print_r($registerForm->getMessages());
            $model = new ViewModel(array(
                        'error' => true,
                        'form' => $registerForm,
                    ));
            $model->setTemplate('users/register/index');
            return $model;
        }
        $this->createUser($registerForm->getData());
        return $this->redirect()->toRoute(NULL, array(
                    'controller' => 'register',
                    'action' => 'confirm'
                ));
    }

    public function confirmAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    protected function createUser(array $data) {
        $model = $this->getServiceLocator()->get('ModelFactory');
        $userTable = $model->getTable('Users');
        $userTable->saveUser($data);
        return true;
    }

}
