<?php

class UploadController extends Zend_Controller_Action {

    public static $id = 0;

    public function init() {
        Zend_Loader::loadClass("Form_Upload");
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("ResizeFilter");
       // Zend_Loader::loadClass("Skoch_Filter_File_Resize");
    }
 
    public function indexAction() {

        $_SESSION['uid'] = 2;
        $uid = $_SESSION['uid'];
        if (!$_SESSION['uid'])
            $this->_redirect("/new/1");

        $form = new Form_Upload();
        $request = $this->_request;
        $message = array();
        if ($this->getRequest()->isPost())
            if ($form->isValid($_POST)) {

                $title = addslashes($request->getParam('title'));
                $name = addslashes($request->getParam('name'));
//                echo UPLOAD_PATH;
//                die();
                $upload = new Zend_File_Transfer_Adapter_Http();
                $upload->setDestination(UPLOAD_PATH);

                //get new name of file
                $name;
                try {
                    $info = pathinfo($upload->getFileName());

                    //generate unique file name
                    $time = time();
                    $name = base64_encode($uid . "_" . $time) . "." . $info['extension'];
                    //echo $name$upload->addValidator($name)
                    $upload->addFilter("Rename", $name);
                    
                    //add filter to scale image
                    $upload->addFilter(ResizeFilter::getSmallFilter());
                    
                    if ($upload->receive()) {
                        //insert into database
                        $id = PostModel::addPost(array(
                                    'uid' => $uid,
                                    'title' => $title,
                                    'name' => $name,
                                    'date' => $time
                        ));

                        if ($id >= 0)
                            $this->view->url = "/c/$id";
                        else
                            $message[] = "Bạn đã đăng bài thành công!";
                    }
                    else
                        $message[] = "Đã có lỗi xảy ra! Vui lòng thử lại!";
                    //Zend_Debug::dump($upload->getFileInfo());
                } catch (Zend_File_Transfer_Exception $e) {
                    // echo $e->message();
                    $message[] = $e->getMessage();
                }

                //post if upload success
            }
        $this->view->form = $form;
        $this->view->message = $message;
    }

    public function uploadAction() {
        
    }

}

