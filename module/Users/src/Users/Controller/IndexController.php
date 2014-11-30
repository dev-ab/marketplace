<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $info = array();
    protected $authservice;

    protected function setInfo() {
        $auth = $this->getAuthService();
        $user_object = $auth->getStorage()->read();
        $model = $this->getServiceLocator()->get('ModelFactory');
        $hyd = new \Zend\Stdlib\Hydrator\ClassMethods(false);

        $userTable = $model->getTable('Users');
        $user = $userTable->getUser($user_object->id);
        $this->info['user'] = $hyd->extract($user);

        $portfolioTable = $model->getTable('users_portfolio');
        $this->info['work'] = $portfolioTable->getPortfolioByUser($this->info['user']['id']);
        foreach ($this->info['work'] as $index => $array) {
            $all_imgs = glob($this->getFileUploadLocation('users_files', $this->info['user']['id'] . '/portfolio/' . $array['id']) . '/*');
            $thumbs = glob($this->getFileUploadLocation('users_files', $this->info['user']['id'] . '/portfolio/' . $array['id']) . '/tn_*');
            $this->info['work'][$index]['img'] = array_diff($all_imgs, $thumbs);
        }
    }

    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function editProfileAction() {
        $auth = $this->getAuthService();
        if ($auth->hasIdentity()) {
            $this->setInfo();
            $form = $this->getServiceLocator()->get('FormFactory')->getForm('Profile');
            $form->setData(array('user' => $this->info['user']));
            $view = new ViewModel(array('form' => $form, 'work' => $this->info['work']));
            return $view;
        } else {
            
        }
    }

    public function getFileUploadLocation($name = 'upload_location', $subfolder = null) {
        // Fetch Configuration from Module Config
        $config = $this->getServiceLocator()->get('config');
        $dir = $subfolder ? $config['module_config'][$name] . "/$subfolder" : $config['module_config'][$name];
        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir, '0777', true);
        }
        return $dir;
    }

    public function uploadWorkAction() {
        $this->setInfo();
        if ($this->getRequest()->isPost()) {
            $adapter = new \Zend\File\Transfer\Adapter\http();
            $files = $adapter->getFileInfo();
            $adapter->addValidator('IsImage', false);
            $adapter->addValidator('ImageSize', false, array(
                'minWidth' => 50, 'minHeight' => 50,
                'maxWidth' => 1024, 'maxHeight' => 768,
            ));
            $form = $this->getServiceLocator()->get('FormFactory')->getForm('Profile');
            $form->setValidationGroup(array(
                'work' => array(
                    'subject',
                    'description',
                )
            ));
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $data = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
                $portfolioTable = $this->getServiceLocator()->get('ModelFactory')->getTable('users_portfolio');
                $data['work']['id'] = 0;
                $data['work']['user_id'] = $this->info['user']['id'];
                $data['work']['type'] = 1;
                $data['work']['time'] = time();
                $new_work = $portfolioTable->savePortfolio($data['work']);
                $uploadPath = $this->getFileUploadLocation('users_files', $this->info['user']['id'] . '/portfolio/' . $new_work);
                foreach ($files as $file => $fileInfo) {
                    $fileName = $fileInfo['name'];
                    $attempts = 0;
                    while (file_exists($uploadPath . DIRECTORY_SEPARATOR . $fileName)) {
                        $attempts++;
                        $fileName = rand(1, 100) . '_' . $fileInfo['name'];
                        if ($attempts >= 100)
                            break;
                    }
                    $adapter->addFilter('File\Rename', array('target' => $uploadPath . DIRECTORY_SEPARATOR .
                        $fileName, 'overwrite' => true));
                    if ($adapter->isUploaded($file)) {
                        if ($adapter->isValid($file)) {
                            if ($adapter->receive($file)) {
                                $this->generateThumbnail($fileName, $uploadPath);
                            }
                        }
                    }
                }
                return new \Zend\View\Model\JsonModel(array('done' => 'ok', 'data' => $data));
            }
            return new \Zend\View\Model\JsonModel(array('done' => 'invalid'));
        }
    }

    public function processEditAction() {
        $this->setInfo();
        $form = $this->getServiceLocator()->get('FormFactory')->getForm('Profile');
        $userTable = $this->getServiceLocator()->get('ModelFactory')->getTable('Users');
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $valid_data = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
                $valid_data['user']['id'] = $this->info['user']['id'];
                $userTable->saveUser($valid_data['user']);
                return new \Zend\View\Model\JsonModel(array('done' => 'ok'));
            }
        }
        return new \Zend\View\Model\JsonModel(array('done' => 'invalid'));
    }

    public function generateThumbnail($imageFileName, $path) {
        $sourceImageFileName = $path . '/' . $imageFileName;
        $thumbnailFileName = 'tn_' . $imageFileName;
        $imageThumb = $this->getServiceLocator()->get('WebinoImageThumb');
        $thumb = $imageThumb->create($sourceImageFileName, $options = array());
        $thumb->resize(75, 75);
        $thumb->save($path . '/' . $thumbnailFileName);
        return $thumbnailFileName;
    }

    public function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

}
