<?php

require_once 'Zend/Db/Table/Abstract.php';

class LikeModel extends Zend_Db_Table_Abstract {

    protected $_name = "like";
    protected $_primary = array("uid", "targetId");

    public function like($data) {
        $sql = $this->select()
                ->where("uid=?", $data["uid"])
                ->where("targetId=?", $data['targetId'])
                ->where('type=?', $data['type']);
        $r = $this->fetchRow($sql);

        if ($r) {
            $r->delete();
            $total = $this->getLikeByTargetId($data['targetId'], $data['type']);
            return "0|" . $total;
        } else {
            $this->insert($data);
            $total = $this->getLikeByTargetId($data['targetId'], $data['type']);
            return "1|" . $total;
        }
    }

    public function getTotalLikeToUser($id) {
        $sql = $this->select()
                ->from("post", array("pid", "uid"))
                ->where("post.uid =?", $id)
                ->setIntegrityCheck(false)
                ->join("like", "post.pid = like.targetId and post.type='photo'", array("count(*) as count"));

        $r = $this->fetchRow($sql);
//        Zend_Debug::dump($r);
        return $r['count'];
    }

    public function getStatus($data) {
        $sql = $this->select()
                ->where("uid=?", $data["uid"])
                ->where("targetId=?", $data['targetId'])
                ->where('type=?', $data['type']);
        $r = $this->fetchRow($sql);
        if ($r)
            return 1;
        else
            return 0;
    }

    public function getLikeByTargetId($targetId, $type) {
        $sql = $this->select()
                ->from("like", "count('pid') as count")
                ->where("targetId=?", $targetId)
                ->where("type=?", $type);
        $r = $this->fetchRow($sql);

        return $r['count'];
    }

}