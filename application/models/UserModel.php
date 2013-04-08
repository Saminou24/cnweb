<?php

require_once 'Zend/Db/Table/Abstract.php';
class UserModel extends Zend_Db_Table_Abstract{
    protected $_name = "user";
    protected $_primary= "uid";
    public function login($data){
       $sql = $this->select()
                    ->where("username=?", $data['username'])
                    ->where('password=?', $data['password']);
       $r = $this->fetchRow($sql);
       if ($r['active']) //user can login
           return true;
       else
           return false;
       
    }

}