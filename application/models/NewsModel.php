<?php

class NewsModel extends Zend_Db_Table_Abstract {

    protected $_name = "news";
    protected $_primary = "id";

    public function getAllNews() {
        return $this->fetchAll();
    }

    public function addNews($data) {
        $this->insert($data);
        return 1;
    }

    public function delNews($id) {
        $this->delete("id = " . $id);
    }

    public function updateNews($id, $data) {
        $this->update($data, "id=$id");
    }

    public function getNews($id) {
        $sql = $this->select()
                ->where("id=?", $id);
        return $this->fetchRow($sql);
    }

   

}

