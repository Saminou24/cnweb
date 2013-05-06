<?php

class CommentController extends Zend_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("CommentModel");
    }

    public function preDispatch() {
        $this->_helper->layout->disableLayout();
        $this->_response->setHeader("content-type", "text/html;charset=utf-8");
    }

    public function postAction() {
         $user = new Zend_Session_Namespace("user");
        
        $parent = $this->_request->getParam("parent");
        $pid = $this->_request->getParam("pid");
        $msg = $this->_request->getParam("msg");
        if (is_numeric($pid) &&
                is_numeric($parent) &&
                strlen($msg) > 6) {
            $model = new CommentModel();
        }
    }

    public function indexAction() {
        $this->_helper->layout->disableLayout();
        $pid = $this->_request->getParam("pid");
        if (is_numeric($pid)) {
            $model = new CommentModel();
            $data = $model->getAllCommentOfPost($pid);
            $this->view->data = $data;
        } else {
            $this->view->data = array();
            $this->view->message = array("Lỗi! trang không tồn tại..");
        }
    }

}