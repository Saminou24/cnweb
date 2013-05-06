<?php

class CommentModel extends Zend_Db_Table_Abstract
{
    protected $_name = "comment";
    protected $_primary = "cid";
    public function addComment($data){
//
//        $st = PostModel::isExist($data['pid']);
//        if ($st) {
//            $id = $this->insert($data);
//            return 1;
//        }
//        else
//            return 0;
        $result = $this->insert($data);
        return $result;
    }
    public function removeComment($id){
        $st = $this->delete("cid = ".$id);
        return 1;
    }
    public function getAllCommentOfPost($pid){
        $sql = $this->select()
                    ->from("comment")
                    ->setIntegrityCheck(false)
                    ->join("user", "user.uid = comment.uid", array("username","avatar"))
                    ->where("comment.pid=?",$pid)
                    ->order(array("cid desc"));
        return $this->fetchAll($sql);
    }
}
