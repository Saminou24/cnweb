<?php

require_once 'Zend/Db/Table/Abstract.php';

class UserModel extends Zend_Db_Table_Abstract {

    protected $_name = "user";
    protected $_primary = "uid";

    public function validateInfo($data) {

        $message = array();
        $message['message'] = array();
        if (strlen($data['username']) < 6)
            $message['message'][] = "Tên tài khoản phải có ít nhất 6 chữ cái";
        else if (strstr($data['username'], " "))
            $message['message'][] = "Tên tài khoản không dược có dấu cách";

        if (strlen($data['password']) < 6)
            $message['message'][] = "Mật khẩu phải có ít nhất 6 chữ cái";
        if ($data['password'] != $data['repassword'])
            $message['message'][] = "Vui lòng nhập lại đúng mật khẩu";
        if (!count($message['message'])) { //check from server
            $r = $this->fetchRow("username='" . $data['username'] . "'");
            if ($r != null)
                $message['message'][] = "Tên tài khoản đã tồn tại";

            $r = $this->fetchRow("email= '" . $data['email'] . "'");
            if ($r != null)
                $message['message'][] = "Email đã tồn tại";
        }
        $message['status'] = count($message['message']) ? 0 : 1;
        return $message;
    }
    /**
     * Checkvalid of user id
     * @param {int} $id
     * @return username of user with id $id or null if not exist
     */
    public function isValidUserId($id){
        $r = $this->fetchRow("uid=".$id);
        if ($r)
            return $r['username'];
        else
            return null;
        
    }
    public function login($data) {
        $sql = $this->select()
                ->where("username=?", $data['username'])
                ->where("password =?", $data['password']);
        $r = $this->fetchRow($sql);
        if ($r) {
            //start session
            //init session
            $user_session = new Zend_Session_Namespace('user');
            $user_session->username = $r['username'];
            $user_session->password = $r['password'];
            $user_session->uid = $r['uid'];
            $user_session->isAdmin = $r['admin'];
            return TRUE;    
        }
        else
            return FALSE;
    }

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
        $st = $this->update($info, 'uid=' . $id); //return num of row is update

        return $st;
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
                ->setIntegrityCheck(false)
                ->where("uid=?", $id);

        return $this->fetchRow($query);
    }

    public function getAllUsersData() {
        return $this->fetchAll();
    }

}