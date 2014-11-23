<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $info;

    function __construct() {
        $this->setInfo();
    }

    protected function setInfo() {
        $this->info = array();
    }

    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function editProfileAction() {
        $form = $this->getServiceLocator()->get('FormFactory')->getForm('Profile');
        $view = new ViewModel(array('form' => $form));
        return $view;
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
        $user_object = $this->getAuthService()->getStorage()->read();
        $uploadPath = $this->getFileUploadLocation('users_files', '1/portfolio/2');
        $adapter = new \Zend\File\Transfer\Adapter\http();
        $files = $adapter->getFileInfo();
        $adapter->addValidator('IsImage', false);
        $adapter->addValidator('ImageSize', false, array(
            'minWidth' => 50, 'minHeight' => 50,
            'maxWidth' => 1024, 'maxHeight' => 768,
        ));
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
        return new \Zend\View\Model\JsonModel(array('done' => 'ok'));
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
