<?php
namespace Corp;
 
use Corp\Model\Corp;
use Corp\Model\CorpTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
 
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CorpModelCorpTable' =>  function($sm) {
                    $tableGateway = $sm->get('CorpTableGateway');
                    $table = new CorpTable($tableGateway);
                    return $table;
                },
                'CorpTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Corp());
                    return new TableGateway('corp', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
    
}

