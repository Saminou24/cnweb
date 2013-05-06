<?php

class Admin_Model_Account extends Zend_Db_Table_Abstract {

    protected $_name = "user";
    protected $_primary = "uid";

    public function creatUser($info) {
        //check info
        $result = $this->checkAccount($info);
        //var_dump($info);
        if ($result['status'] == TRUE) {
            $row = $this->createRow($info);
            $row->save();
            $result['uid'] = $row->uid;
        }
        return $result;
    }

    public function updateUser($id, $info) {
        $result = $this->checkAccount($info);
        if ($result['status'])
            $this->update($info, 'uid=' . $id); //return num of row is update

        return $ressult;
    }

    public function deleteUser($id) {
        $del = $this->delete("uid=" . $id);
        return $del;
    }

    public function checkAccount($info) {
        $result = array();
        $result['message'] = array();
        if ($info['username']) {
            $user = $this->fetchRow('username="' . $info['username'] . '"');
            if ($user)
                $result['message'][] = "Tên tài khoản đã tồn tại. Vui lòng thử tên khác";
        }
        if ($info['email']) {
            $email = $this->fetchRow('email="' . $info['email'] . '"');
            if ($email)
                $result['message'][] = "Email này dã được sử dụng. Hãy thử sử dụng email khác";
        }
        if (count($result['message']))
            $result['status'] = FALSE;
        else
            $result['status'] = TRUE;

        return $result;
    }

    public function getUserData($id) {
        $query = $this->select()
                ->where("uid=?", $id);

        return $this->fetchRow($query);
    }

    public function getAllUsersData() {
        return $this->fetchAll();
    }
 

}