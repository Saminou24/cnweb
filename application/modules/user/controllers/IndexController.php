<?php

class User_IndexController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("UserModel");
        Zend_Loader::loadClass("ResizeFilter");
        zend_loader::loadClass("MessageModel");
    }

    public function indexAction() {
        $session = new Zend_Session_Namespace("user");
        // Zend_Debug::dump($session->username);
        if (!$session->username)
        //login
            $this->redirect("/user/login");
        else {
            echo "Xin chào bạn " . $session->username;
        }
    }

    public function loginAction() {
        $this->view->headTitle("Đăng nhập ");

        $request = $this->_request;
        $redirect = $request->getParam("redirect");
        if ($request->isPost()) {
            $username = $request->getParam('username');
            $password = $request->getParam('password');
            if ($username && $password) {
                $model = new UserModel();
                $canLogin = $model->login(array(
                    "username" => $username,
                    "password" => $password
                ));
                if ($canLogin) {
                    if ($redirect)
                        $this->redirect($redirect);
                    else
                        $this->redirect("/"); //back home
                }
                else
                    $this->view->message = "Vui lòng kiểm tra lại thông tin tài khoản";
            }
        }
    }

    public function registerAction() {
        $session = new Zend_Session_Namespace("user");
        if ($session->username)
            $this->redirect("/");

        $this->view->headTitle("Đăng ký");
        $request = $this->getRequest();

        $model = new UserModel();
        $message = array();
        if ($request->isPost()) {
            $userName = $request->getParam("username");
            $password = $request->getParam("password");
            $repassword = $request->getParam("repassword");
            $email = $request->getParam("email");
            $info = $request->getParam("info");
            $date = date("Y-m-d");

            $data = array(
                "username" => $userName,
                "password" => $password,
                "repassword" => $repassword,
                "email" => $email,
                "info" => $info,
                "date" => $date
            );
            $result = $model->validateInfo($data);
            if ($result['status']) {
                //create user
                $status = $model->creatUser($data);
                if ($status['status'] == 0)
                    $message[] = "Đã có lỗi xảy ra! ";
                else {
                    $message[] = "Đăng ký thành công";
                    $this->view->status = "success";
                }
            }
            else
                $message = $result['message'];
        }
        if (!$this->view->status)
            $this->view->status = "error";
        $this->view->message = $message;
    }

    public function logoutAction() {
        // $session = new Zend_Session_Namespace("user");
        Zend_Session::namespaceUnset("user");
        //$this->_redirect("/");
        //append redirect meta tag
        $this->view->headMeta()->appendHttpEquiv('Refresh', '2;URL=' . BASE_URL);
    }

    public function profileAction() {
        $this->view->headTitle('Thông tin tài khoản');
        $session = new Zend_Session_Namespace("user");
        if (!$session->username)
            $this->redirect("/user/login?redirect=/user/profile");

        $model = new UserModel();
        $data = $model->getUserData($session->uid);
        $this->view->data = $data;
        $this->view->username = $session->username;
        $request = $this->getRequest();
        if ($request->isPost()) {
            //use user photo upload
            $upload = new Zend_File_Transfer_Adapter_Http();
            //get new name of file
            $name;
            try {
//                var_dump($upload->getFileName());


                if ($upload->isUploaded()) {
                    $info = pathinfo($upload->getFileName());
                    //generate unique file name
                    $time = time();
                    $name = base64_encode($session->uid . "_avatar_" . $time) . "." . $info['extension'];
                    //echo $name$upload->addValidator($name)
                    $upload->addFilter("Rename", UPLOAD_PATH . "/avatar/" . $name)
                            ->addFilter(ResizeFilter::getThumbnailFilter());
//                            ->addFilter(ResizeFilter::getSmallFilter());
//                    $upload->addFilter("Rename", array("target" => UPLOAD_PATH. "/medium/". $name, "overwrite"=> true));
//                            ->addFilter(ResizeFilter::getMediumFilter());
//                    echo UPLOAD_PATH . "/avatar/" . $name;
                    $info = $request->getParam("info");
                    if ($upload->receive()) {
                        //insert into database
                        $st = $model->updateUser($session->uid, array(
                            "avatar" => $name,
                            "info" => $info
                        ));
                        if ($st)
                            $this->view->status = "success";
                        else
                            $this->view->status = "error";
                    }
                }
                else {
                    $info = $request->getParam("info");
                    $st = $model->updateUser($session->uid, array(
                        "info" => $info
                    ));
                    if ($st)
                        $this->view->status = "success";
                    else
                        $this->view->status = "error";
                }

                //Zend_Debug::dump($upload->getFileInfo());
            } catch (Zend_File_Transfer_Exception $e) {
                // echo $e->message();
                $message[] = $e->getMessage();
                echo $e->getMessage();
            }
        }
    }

    public function messageAction() {
        $session = new Zend_Session_Namespace("user");
        if (!$session->uid)
            $this->redirect("/user/login?redirect=/user/message");
        $model = new MessageModel();
        $request = $this->getRequest();
        $act = $request->getParam("act", "display");
        $uid = $session->uid;
        $message = array();
        $model = new MessageModel();
        switch ($act) {
            case "display":

                $data = $model->getMessagesOfUser($uid);
                $this->view->data = $data;
                break;
            case "show_detail":
                $mid = $request->getParam("mid");
                $msgData = $model->getFirstMessages($mid);
                if ($msgData['uid_from'] == $uid) {
                    $from = $msgData['from'];
                    $to = $msgData['to'];
                    $uid_to = $msgData['uid_to'];
                } else {
                    $from = $msgData['to'];
                    $to = $msgData['from'];
                    $uid_to = $msgData['uid_from'];
                }
//              Zend_Debug::dump($mid);
                if ($request->isPost() && is_numeric($mid)) {

                    $msg = $request->getParam("msg");
                    if (strlen($msg) < 6 || strlen($msg) > 100)
                        $message[] = "Độ dài tin nhắn phải từ 6 đến 100 ký tự";
                    else {
                        $result = $model->addMessage(array(
                            "title" => "",
                            "mid_parent" => $mid,
                            "uid_from" => $uid,
                            "uid_to" => $uid_to,
                            "message" => $msg,
                            "date_created" => date("Y-m-d H:i:s")
                        ));
                        if ($result)
                            $this->view->status = "success";
                    }
                }
                
                //get all message content
                $data = $model->getChildMessages($mid);
                
                //mark read message
                $model->markReadMessage($uid, $mid);
                $this->view->data = $data;
                $this->view->uid = $uid;
                if (!$this->view->status)
                    $this->view->status = "error";
//                $class = array();
//                foreach ($data as $i=>$m){
//                    if $m['uid_from']
//                }
//                Zend_Debug::dump($data);
                //set back_link
                $this->view->back_link = "/user/message";
                break;
        }
        $this->view->act = $act;
    }

}