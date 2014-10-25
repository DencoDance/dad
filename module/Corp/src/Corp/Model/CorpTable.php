<?php
namespace Corp\Model;
 
use Zend\Db\TableGateway\TableGateway;
 
class CorpTable
{
    protected $tableGateway;
 
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
 
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
 
    public function getCorp($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
 
    public function saveCorp(Corp $corp)
    {
        $data = array(
            'name' => $corp->name,
            'phone' => $corp->phone,
            'location' => $corp->location,
        );
 
        $id = (int)$corp->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCorp($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
 
    public function deleteCorp($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}