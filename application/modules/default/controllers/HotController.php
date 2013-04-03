<?php

class HotController extends Cab_Controller_Action
{
    
    public function init() {
        Zend_Loader::loadClass("PostModel");
    }

    public function indexAction()
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

