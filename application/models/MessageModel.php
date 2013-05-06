<?php

class MessageModel extends Zend_Db_Table_Abstract {

    protected $_name = "message";
    protected $_primary = "mid";

    public function addMessage($data) {

        $r = $this->createRow();
        $r['uid_from'] = $data['uid_from'];
        $r['uid_to'] = $data['uid_to'];
        $r['title'] = $data['title'];
        if ($data['mid_parent'])
            $r['mid_parent'] = $data['mid_parent'];
        $r['date_created'] = $data['date_created'];
        $r['message'] = $data['message'];
        $id = $r->save();
        if (!$data['mid_parent']) {
            $r['mid_parent'] = $r['mid'];
            $r->save();
        }
        return 1;
    }

    public function getFirstMessages($mid) {
        $sql = $this->select()
                ->from("message")
                ->setIntegrityCheck(false)
                ->where("message.mid_parent=?", $mid)
                ->join("user", "message.uid_from= user.uid", array("user.username as from", "user.avatar as avatar_from"))
                ->join("user as u", "message.uid_to=u.uid", array("u.username as to", "u.avatar as avatar_to"))
                ->order("message.mid");
//        die($sql);
        return $this->fetchRow($sql);
    }

    public function getChildMessages($mid) {
        $sql = $this->select()
                ->from("message")
                ->setIntegrityCheck(false)
                ->where("message.mid_parent=?", $mid)
                ->join("user", "message.uid_from= user.uid", array("user.username as from", "user.avatar as avatar_from"))
                ->join("user as u", "message.uid_to=u.uid", array("u.username as to", "u.avatar as avatar_to"))
                ->order("message.mid asc");
        return $this->fetchAll($sql);
    }

    public function getMessagesOfUser($uid) {
        $count = $this->select()
                ->from("message", array("mid_parent", "count(*) as_unread"))
                ->where("uid_from=$uid or uid_to = $uid")
                ->where('read=0');

        $sql = $this->select()
                ->distinct()
                ->from(array("m" => "message"), array("m.*", 'unread' => '(' . new Zend_Db_Expr('select count(*) from message  where message.mid_parent = m.mid_parent and message.uid_to ='.$uid .' and message.read=0') . ')'))
                ->where("m.uid_from=$uid or m.uid_to = $uid")
                ->where("m.title <> '' ")
//                ->join("user", "message.uid_from= user.uid", array("user.username as from", "user.avatar as avatar_from"))
//                ->join("user", "message.uid_to=user.uid", array("user.username as to", "user.avatar as avatar_to"))
//                ->join("message as m", "message.mid_parent = m.mid_parent AND m.read = 0", array("count(*) as not_read "))
                ->order("unread desc")
                ->order("m.mid_parent  desc");
//        die($sql);
        return $this->fetchAll($sql);
    }

    public function getMessagesFromUser($uid) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->where("user.uid_from=?", $uid)
                ->join("user", "message.uid_from = user.uid", "user.username as from")
                ->join("u", "message.uid_to = u.uid", "u.username as to")
                ->order("message.mid_parent asc");

        $this->fetchAll($sql);
    }

    public function getMessagesToUser($uid) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->where("user.uid_to=?", $uid)
                ->join("user", "message.uid_from = user.uid", "user.username as from")
                ->join("u", "message.uid_to = u.uid", "u.username as to")
                ->order("message.mid_parent asc");

        $this->fetchAll($sql);
    }

    public function countUnreadMessageOfUser($uid) {
        $sql = $this->select()
                ->from("message", array("count(distinct mid) as count"))
                ->where("message.uid_to = $uid")
                ->where("message.read = 0");

        $r = $this->fetchRow($sql);
//        die($r['count']);
        return $r['count'];
    }

    public function setReadStatus($mid_parent) {
        $sql = $this->update(array("read" => 1), "mid_parent=$mid_parent");
        die($sql);
    }

    public function markReadMessage($uid, $mid_parent) {
        return $this->update(array("read" => 1), "mid_parent='$mid_parent' AND uid_to ='$uid'");
    }

}
