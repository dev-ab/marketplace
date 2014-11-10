<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZendSearch\Lucene;
use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Index;

class SearchController extends AbstractActionController {

    public function indexAction() {
        $request = $this->getRequest();
        $searchResults = array();
        if ($request->isPost()) {
            $queryText = $request->getPost()->get('query');
            $searchIndexLocation = $this->getIndexLocation();
            $index = Lucene\Lucene::open($searchIndexLocation);
            $searchResults = $index->find($queryText);
        }
        // prepare search form
        $form = new \Zend\Form\Form();
        $form->add(array(
            'name' => 'query',
            'attributes' => array(
                'type' => 'text',
                'id' => 'queryText',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Search String',
            ),
        ));
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Search'
            ),
        ));
        $viewModel = new ViewModel(array(
            'form' => $form,
            'searchResults' => $searchResults
                )
        );
        return $viewModel;
    }

    public function getIndexLocation() {
        // Fetch Configuration from Module Config
        $config = $this->getServiceLocator()->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        if (!empty($config['module_config']['search_index'])) {
            return $config['module_config']['search_index'];
        } else {
            return FALSE;
        }
    }

    public function generateIndexAction() {
        $searchIndexLocation = $this->getIndexLocation();
        $index = Lucene\Lucene::create($searchIndexLocation);
        $userTable = $this->getServiceLocator()->get('UserTable');
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $allUploads = $uploadTable->fetchAll();
        foreach ($allUploads as $fileUpload) {
            $uploadOwner = $userTable->getUser($fileUpload->user_id);
            // create lucene fields
            $fileUploadId = Document\Field::unIndexed('upload_id', $fileUpload->id);
            $label = Document\Field::Text('label', $fileUpload->label);
            $owner = Document\Field::Text('owner', $uploadOwner->name);
            // create a new document and add all fields
            $indexDoc = new Lucene\Document();
            $indexDoc->addField($label);
            $indexDoc->addField($owner);
            $indexDoc->addField($fileUploadId);
            $index->addDocument($indexDoc);
        }
        $index->commit();
    }

}
