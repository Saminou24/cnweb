<?php

class User_LoginController extends Cab_Controller_Action
{
    public function init() {
        Zend_Loader::loadClass("UserModel");
    }
    public function __call($methodName, $args) {
        $this->redirect("/user/login"); //redirect to login
    }
    public function indexAction(){
        $request = $this->_request;
        if ($request->isPost()){
            $username = $request->getParam('username');
            $password = $request->getParam('password');
            if ($username && $password){
                $model = new UserModel();
                $canLogin = $model->login(array(
                    "username" => $username,
                    "password" => $password
                ));
                if ($canLogin){
                    //init session
                    $user_session = new Zend_Session_Namespace('user');
                    $user_session->username= $username;
                    $user_session->password = $password;
                    $this->redirect("/"); //back home
                }
            }
        }
        
    }
}