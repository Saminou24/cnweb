<?php

class CController extends Zend_Controller_Action
{
    public function init(){
        Zend_Loader::loadClass("PostModel");
    }
    public function indexAction(){
        $id = $this->_request->getParam("page");
        if ($id == null || !is_numeric($id)){
            $this->view->message = "Lỗi! Bơi nhầm đường rồi cá ợ :D. Trở về trang chủ nào<br/>
                <a href='".BASE_URL."' > Trang chủ </a>";
            $this->view->status="error";
            $this->view->test ="hêlo";
        }
        else {
            //get data
            $this->view->content = PostModel::getPost($id);
            //test message
            $this->view->message =" Thành công rồi ";
        }
        
        
    }
    public function testAction(){
        
    }
}
