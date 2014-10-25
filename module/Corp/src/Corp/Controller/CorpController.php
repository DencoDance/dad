<?php

namespace Corp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Corp\Model\Corp;
use Corp\Form\CorpForm;
 
class CorpController extends AbstractActionController
{
    protected $corpTable;
    
    public function indexAction()
    {
         $result = new ViewModel(array(
            'corps' => $this->getCorpTable()->fetchAll(),
        ));
        return $result;
    }
 
    public function addAction()
    {
        $form = new CorpForm();
        $form->get('submit')->setValue('Save');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $corp = new Corp();
            $form->setInputFilter($corp->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $corp->exchangeArray($form->getData());
                $this->getCorpTable()->saveCorp($corp);
 
                return $this->redirect()->toRoute('corp');
            }
        }
        return array('form' => $form);
    }
 
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('corp', array(
                'action' => 'add'
            ));
        }
        $corp = $this->getCorpTable()->getCorp($id);
 
        $form  = new CorpForm();
        $form->bind($corp);
        $form->get('submit')->setAttribute('value', 'Save');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($corp->getInputFilter());
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $this->getCorpTable()->saveCorp($form->getData());
 
                return $this->redirect()->toRoute('corp');
            }
        }
 
        return array(
            'id' => $id,
            'form' => $form,
        );
    }
 
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('corp');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
 
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCorpTable()->deleteCorp($id);
            }
            return $this->redirect()->toRoute('corp');
        }
        return array(
            'id'    => $id,
            'corp' => $this->getCorpTable()->getCorp($id)
        );
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

