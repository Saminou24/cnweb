<?php

class NewController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("TimeUtil");
        Zend_Loader::loadClass("LikeModel");
        Zend_Loader::loadClass("MessageModel");
    }

    public function indexAction() {
        $session = new Zend_Session_Namespace("user");
        $uid = $session->uid;

        //get number of unread message
        $messageModel = new MessageModel();
        if ($uid)
            $this->view->unread_message = $messageModel->countUnreadMessageOfUser($uid);
        //contain message information

        $message = array();
        $page = $this->_request->getParam("page", 1);
        if (!is_numeric($page))
            $message['error'] = 'Boi nham duong roi cac ca :)';
        else {
            //create model
            $message['error'] = null;
            $message['content'] = PostModel::getNewPage($page); //load page
            $t = array();
            $likeStatus = array();
            $likeModel = new LikeModel();
            foreach ($message['content'] as $i => $v) {
                $t[$i] = TimeUtil::calRelativeTime($v['date-created']);
                $like[$i] = $likeModel->getLikeByTargetId($v['pid'], "photo");
                if ($uid)
                    $likeStatus[$i] = $likeModel->getStatus(array(
                        "uid" => $uid,
                        "type" => "photo",
                        "targetId" => $v['pid']
                    ));
                else
                    $likeStatus[$i] = null;
            }
            $message['relative_time'] = $t;
            $message['like_status'] = $likeStatus;
            //   print_r($message['content']);
        }
        $this->view->message = $message;
        $this->view->page = $page;

        //add show Scroll effect to layout
        $this->view->scroll_script_include = true;
        $this->view->menu_include = true;
        $this->view->section = 'new';
        if ($uid)
            $this->view->show_toolbar = true;
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

