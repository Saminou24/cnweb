<?php

class Admin_IndexController extends Zend_Controller_Action {
    public function init() {
        Zend_Layout::getMvcInstance()->setLayout("admin");
    }

    public function indexAction(){
        $this->dispatch("some");
    }
    public function __call($methodName, $args) {
       // $this->redirect("/admin/");
    }
    public function someAction(){
        echo "helo";
    }
}