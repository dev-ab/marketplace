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
        $uploadFile = $this->params()->fromFiles('fileupload');
        $uploadPath = $this->getFileUploadLocation('users_files', '1/projects/2');
        // Save Uploaded file
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $adapter->setDestination($uploadPath);
        $imageFileName = rand(2, 1000);
        $adapter->addFilter('File\Rename', array('target' => $adapter->getDestination() .
            DIRECTORY_SEPARATOR . $imageFileName . '.jpeg', 'overwrite' => true));
        if ($adapter->receive($uploadFile['name'])) {
            // File upload sucessfull
            $this->generateThumbnail($imageFileName . '.jpeg', $uploadPath);
            return new \Zend\View\Model\JsonModel(array('done' => 'ok'));
        }
        return new \Zend\View\Model\JsonModel(array('done' => 'not ok'));
    }

    public function generateThumbnail($imageFileName, $path) {
        $sourceImageFileName = $path . '/' . $imageFileName;
        $thumbnailFileName = 'tn_' . $imageFileName;
        $imageThumb = $this->getServiceLocator()->get('WebinoImageThumb');
        $thumb = $imageThumb->create($sourceImageFileName, $options = array());
        $thumb->resize(100, 100);
        $thumb->save($path . '/' . $thumbnailFileName);
        return $thumbnailFileName;
    }

}
