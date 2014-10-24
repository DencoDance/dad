<?php

namespace Corp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
 
class CorpController extends AbstractActionController
{
    protected $corpTable;
    
    public function indexAction()
    {
         $result = new ViewModel(array(
            'corps' => $this->getCorpTable()->fetchAll(),
        ));
        var_dump($result);
        return $result;
    }
 
    public function addAction()
    {
    }
 
    public function editAction()
    {
    }
 
    public function deleteAction()
    {
    }
    
    public function getCorpTable()
    {
        if (!$this->corpTable) {
            $sm = $this->getServiceLocator();
            $this->corpTable = $sm->get('Corp\Model\CorpTable');
        }
        return $this->corpTable;
    }
}

