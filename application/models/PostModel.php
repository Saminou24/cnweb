<?php

require_once 'Zend/Db/Table/Abstract.php';
class PostModel extends Zend_Db_Table_Abstract {

    protected $_name = "post";
    protected $_primary = "pid";
    public static function getAll() {
        $model = new PostModel();
        
        return $model->fetchAll();
    }

    public static function addPost($data){
        $model = new PostModel();
        $model -> insert($data);
        return self::getDefaultAdapter()->lastInsertId();
    }

    public static function dellPost($id){
        $this->delete("id=", $id);
    }
    public static function getPost($id){
        $model = new PostModel();
        return  $model->fetchRow("pid=$id");
                
    }
}

