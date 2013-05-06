<?php

class Admin_PostController extends Cab_Controller_Action {

    public function preDispatch() {
        Zend_Layout::getMvcInstance()->setLayout("admin");
    }

    public function indexAction() {
        
    }

}