<?php

class HotController extends Zend_Controller_Action
{
    
    public function init() {
        Zend_Loader::loadClass("PostModel");
        
    }
    public function __call($methodName, $args) {
       // $this->redirect("/index/1");
    }

    public function displayAction()
    {
        //contain message information
        $message = array();
        $page = $this->_request->getParam(1);
        
        if ($page == null)
            $page = 1;
        if (!is_int($page))
           $message['error'] = 'Boi nham duong roi cac ca :)';
        else {
            //create model
            $message['error'] = null;
            $message['content'] = PostModel::getAll();
            
        }
        $this->view->message = $message;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

