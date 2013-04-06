<?php

class User_IndexController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("UserModel");
    }

    public function indexAction() {
        $session = new Zend_Session_Namespace("user");
        if (!$session->username)
        //login
            $this->redirect("/user/login");
        else {
            $this->view->message = "Xin chào bạn " . $session->username;
        }
    }

    public function loginAction() {
        $request = $this->_request;
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
                    //init session
                    $user_session = new Zend_Session_Namespace('user');
                    $user_session->username = $username;
                    $user_session->password = $password;
                    $this->redirect("/"); //back home
                }
                else
                    $this->view->message = "Vui lòng kiểm tra lại thông tin tài khoản";
            }
        }
    }

    public function register() {
        
    }

    public function logoutAction() {
        $session = new Zend_Session_Namespace("user");
        unset($session->username);
        //$this->_redirect("/");
        //append redirect meta tag
        $this->view ->headMeta()->appendHttpEquiv('Refresh', '3;URL='.BASE_URL);
    }

}