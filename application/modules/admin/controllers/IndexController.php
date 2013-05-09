<?php

class Admin_IndexController extends Zend_Controller_Action {

    public function init() {
        Zend_Layout::getMvcInstance()->setLayout("admin");
        $this->view->headTitle("Trang admin");
    }

    public function preDispatch() {
        $session = new Zend_Session_Namespace("user");
        if (!$session->username)
            $this->redirect("/user/login?redirect=/admin/index");
        else
        if (!$session->isAdmin)
            $this->redirect("/");
    }

    public function indexAction() {
        $this->dispatch("some");
    }

    public function __call($methodName, $args) {
        // $this->redirect("/admin/");
    }

    public function someAction() {
        echo "helo";
    }

}