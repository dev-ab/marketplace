<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function editProfileAction() {
        $form = $this->getServiceLocator()->get('FormFactory')->getForm('Profile');
        $view = new ViewModel(array('form'=> $form));
        return $view;
    }

}