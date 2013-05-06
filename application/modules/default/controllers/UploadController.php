<?php

class UploadController extends Cab_Controller_Action {

    public static $id = 0;

    public function init() {
        Zend_Loader::loadClass("Form_Upload");
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("ResizeFilter");
        // Zend_Loader::loadClass("Skoch_Filter_File_Resize");
    }

    public function indexAction() {

        //check login before upload
        $session = new Zend_Session_Namespace("user");
        if (!$session->username)
            $this->redirect("/user/login?redirect=/upload");
        $uid = $session->uid;

        $form = new Form_Upload();
        $request = $this->_request;
        $message = array();
        if ($this->getRequest()->isPost())
            if ($form->isValid($_POST)) {

                $title = htmlentities($request->getParam('title'));
                $name = htmlentities($request->getParam('name'));
                $video = trim($request->getParam("video"));
//                echo $video;
                if ($video) { //use link youtube to upload
                    if (!filter_var($video, FILTER_VALIDATE_URL))
                        $message[] = "Link video không hợp lệ ";
                    else {
                        $parsed_url = parse_url($video);
                       // var_dump($parsed_url);
                        if (strtolower($parsed_url['host']) != "youtube.com" && strtolower($parsed_url["host"]) != "www.youtube.com")
                            $message[] = "Chúng tôi hiện tại chỉ hỗ trợ video từ Youtube";
                        else {
                            $queryArr = $this->queryToArray($parsed_url['query']);
                            $url = $queryArr['v'];
                            $date = date("Y-m-d H:i:s");
                            $id = PostModel::addPost(array(
                                        'uid' => $uid,
                                        'title' => $title,
                                        'name' => $url,
                                        'type' => "video",
                                        'date-created' => $date
                            ));

                            if ($id >= 0) {
                                $this->view->url = "/c/$id";
                                //add keyword
                                PostModel::addKeyword(array(
                                    "keyword" => $title,
                                    "url" => $this->view->url
                                ));
                                $this->view->status = "success";
                            }
                           
                        }
                    }
                    if (!$this->view->status)
                        $this->view->status = "error";
                } else {
                    //use user photo upload
                    $upload = new Zend_File_Transfer_Adapter_Http();
//                $upload->setDestination(UPLOAD_PATH);
                    //get new name of file
                    try {
                        $info = pathinfo($upload->getFileName());

                        //generate unique file name
                        $time = time();
                        $date = date("Y-m-d H:i:s");
                        $name = base64_encode($uid . "_" . $time) . "." . $info['extension'];
                        //echo $name$upload->addValidator($name)
                        $upload->addFilter("Rename", UPLOAD_PATH . "/medium/" . $name)
                                ->addFilter(ResizeFilter::getMediumFilter());
//                            ->addFilter(ResizeFilter::getSmallFilter());
//                    $upload->addFilter("Rename", array("target" => UPLOAD_PATH. "/medium/". $name, "overwrite"=> true));
//                            ->addFilter(ResizeFilter::getMediumFilter());

                        if ($upload->receive()) {
                            //insert into database
                            $id = PostModel::addPost(array(
                                        'uid' => $uid,
                                        'title' => $title,
                                        'name' => $name,
                                        'type' => "photo",
                                        'date-created' => $date
                            ));

                            if ($id >= 0) {
                                $this->view->url = "/c/$id";
                                //add keyword
                                PostModel::addKeyword(array(
                                    "keyword" => $title,
                                    "url" => $this->view->url
                                ));
                                $this->view->status = "success";
                            }
                            else
                                $this->view->status = "error";
                        }
                        else
                            $message[] = "Đã có lỗi xảy ra! Vui lòng thử lại!";
                        //Zend_Debug::dump($upload->getFileInfo());
                    } catch (Zend_File_Transfer_Exception $e) {
                        // echo $e->message();
                        $message[] = $e->getMessage();
                    }
                }

                //post if upload success
            }
        $this->view->form = $form;
        $this->view->message = $message;
    }

    public function uploadAction() {
        
    }

    /**
     *  Extract query string to array
     * @param type $query
     * @return array
     */
    function queryToArray($query) {
        $queryParts = explode('&', $query);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }

        return $params;
    }

}

