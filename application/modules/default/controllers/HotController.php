<?php

class HotController extends Cab_Controller_Action
{
    
    public function init() {
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("TimeUtil");
    }

    public function indexAction()
    {
        //contain message information
        $message = array();
        $page = $this->_request->getParam("page");
        
        if ($page == null)
            $page = 1;
        if (!is_numeric($page))
           $message['error'] = 'Boi nham duong roi cac ca :)';
        else {
            //create model
            $message['error'] = null;
            $message['content'] = PostModel::getHotPages($page); //load page
            $t = array();
            foreach ($message['content'] as $i=>$v){
                $t[] = TimeUtil::calRelativeTime($v['date-created']);
            }
            $message['relative_time'] = $t;
         //   print_r($message['content']);
            
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

