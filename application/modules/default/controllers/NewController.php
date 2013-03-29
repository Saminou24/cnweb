<?php

class NewController extends Zend_Controller_Action {

//    public function preDispatch() {
//       $page = $this->getParam("page");
//       if ($page == null)
//           $this->redirect ("/new/1");
//    }

    public function indexAction() {
        $page = $this->getParam("page");
        if ($page == null)
            $page = 1;
        echo $page;
         if (!is_int($page))
            $this->redirect ("default/error/error");
    }

    public function getLog() {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }

}

