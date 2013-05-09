<?php

class HotController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("TimeUtil");
        Zend_Loader::loadClass("LikeModel");
        Zend_Loader::loadClass("MessageModel");
        Zend_Loader::loadClass("NewsModel");
    }

    public function indexAction() {
        $session = new Zend_Session_Namespace("user");
        $uid = $session->uid;
        //contain message information
        $message = array();
        $messageModel = new MessageModel();
        $likeModel = new LikeModel();
        if ($uid)
            $this->view->unread_message = $messageModel->countUnreadMessageOfUser($uid);

        $page = $this->_request->getParam("page", 1);
        if (!is_numeric($page))
            $message['error'] = 'Boi nham duong roi cac ca :)';
        else {
            //create model
            $message['error'] = null;
            $message['content'] = PostModel::getHotPage($page); //load page
            $t = array();
            $like = array();
            $likeStatus = array();
            foreach ($message['content'] as $i => $v) {
                $t[$i] = TimeUtil::calRelativeTime($v['date-created']);
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

        $newsModel = new NewsModel();
        $news = $newsModel->getAllNews();
        $this->view->news = $news;
        $this->view->message = $message;
        $this->view->page = $page;


        //add show Scroll effect to layout
        $this->view->scroll_script_include = true;
        $this->view->menu_include = true;
        $this->view->section = 'hot';
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

