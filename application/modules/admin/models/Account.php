<?php

class Admin_Model_Account extends Zend_Db_Table_Abstract{
    protected $_name = "user";
    protected $_primary = "uid";
   
    public function creatUser($info){
        var_dump($info);
        $row = $this->createRow($info);
        $row->save();
        
        return $row->uid;
    }
    public function updateUser($id, $info){
        $ressult = $this->update($info, 'uid='.$id); //return num of row is update
        return $ressult;
    }
    public function deleteUser($id){
        $del = $this->delete("uid=".$id);
        return $del;
    }
    public function getUserData($id){
        $query = $this->select()
                    ->where("uid=?", $id);
        
        return $this->fetchRow($query);
    }
    public function getAllUsersData(){
        return $this->fetchAll();
    }
}