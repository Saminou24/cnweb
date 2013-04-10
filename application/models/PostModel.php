<?php

require_once 'Zend/Db/Table/Abstract.php';

class PostModel extends Zend_Db_Table_Abstract {

    protected $_name = "post";
    protected $_primary = "pid";

    public static function getAll() {
        $model = new PostModel();

        return $model->fetchAll();
    }

    public static function addPost($data) {
        $model = new PostModel();
        $model->insert($data);
        return $model->getDefaultAdapter()->lastInsertId();

    }

    public static function dellPost($id) {
        $this->delete("id=", $id);
    }

    public static function getPost($id) {
        $model = new PostModel();
        return $model->fetchRow("pid=$id");
    }

    public static function addKeyword($data) {
        Zend_Debug::dump($data);
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
        $index = Zend_Search_Lucene::open('post');
        $doc = new Zend_Search_Lucene_Document();
        $doc->addField(Zend_Search_Lucene_Field::Keyword('link', $data['url'], 'UTF-8'));
        $doc->addField(Zend_Search_Lucene_Field::Text('keyword', self::normalizeName($data['keyword']), 'UTF-8'));
        $doc->addField(Zend_Search_Lucene_Field::Text('title', $data['keyword'], 'UTF-8'));
        $index->addDocument($doc);
        $index->commit();
    }

    public static function normalizeName($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        // $str = str_replace(" ", "-", str_replace("&*#39;", "", $str));
        $str = strtolower($str);

        return $str;
    }

    public static function getHotPage($page) {
        $offset = $page * NUM_PER_PAGE;
        $model = new PostModel();
        $total = $model->select()
                ->order("like desc")
                ->from("post", "count(pid)");
        if ($offset > $total)
            return array();
        $num = $offset + NUM_PER_PAGE < $total ? NUM_PER_PAGE : $total - $offset;
        $sql = $model->select()
                ->limit($num, $offset);

        return $model->fetchAll($sql);
    }

    public static function getNewPage($page) {
        $offset = $page * NUM_PER_PAGE;
        $model = new PostModel();
        $total = $model->select()
                ->order("date_created desc")
                ->from("post", "count(pid)");
        if ($offset > $total)
            return array();
        $num = $offset + NUM_PER_PAGE < $total ? NUM_PER_PAGE : $total - $offset;
        $sql = $model->select()
                ->limit($num, $offset);

        return $model->fetchAll($sql);
    }

    public static function getHotPages($page) {
        $model = new PostModel();
        $total = $model->fetchRow(
            $model->select()
                ->from("post", "count(pid) as count"));
        //echo $total["count"];
        $total = $total['count'];

        $offset = $page * NUM_PER_PAGE;
        echo $offset;
        $num = NUM_PER_PAGE * SEG_PER_PAGE;
        $sql = $model->select()
                ->order("like desc")
                ->limit($num, $offset);
        return $model->fetchAll($sql);
    }

}

