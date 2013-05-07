<?php

class UploaderController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("UserModel");
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("TimeUtil");
        Zend_Loader::loadClass("LikeModel");
        Zend_Loader::loadClass("MessageModel");
    }

    public function indexAction() {
        $request = $this->getRequest();
        $id = $request->getParam("id");
        $page = $request->getParam("page", 1);
        $session = new Zend_Session_Namespace("user");
        $act = $request->getParam("act", "display");
        $uid = $session->uid;
        $message = array();
        $this->view->act = $act;
        $this->view->show_send_link = $uid != $id ? true : false;

        //set uploader_loader mode
        $this->view->mode = "uploader";
        $this->view->page = $page;
        if ($act == "display") {
            if (!is_numeric($id) || !is_numeric($page))
                $message[] = "Trang bạn yêu cầu không tồn tại";
            else {
                $model = new UserModel();
                $user = $model->getUserData($id);
                
                if (!$user)
                    $message[] = "Trang bạn yêu cầu không tồn tại";
                else {
                    $postModel = new PostModel();
                    $likeModel = new LikeModel();
                    $data = $postModel->getPageOfUser($id, $page);
                    $like = array();
                    $likeStatus = array();
                    $likeModel = new LikeModel();
                    
                    $user_like = $likeModel->getTotalLikeToUser($id);
                    $this->view->like_count = $user_like;
                    $this->view->post_count = $postModel->getTotalPageOfUser($id);
//                    die($user_like);
                    $relative_time = array();
                    foreach ($data as $i => $r) {
                        $relative_time[$i] = TimeUtil::calRelativeTime($r['date-created']);
                        $like[$i] = $likeModel->getLikeByTargetId($r['pid'], "photo");
                        if ($uid)
                            $likeStatus[$i] = $likeModel->getStatus(array(
                                "uid" => $uid,
                                "type" => "photo",
                                "targetId" => $r['pid']
                            ));
                        else
                            $likeStatus[$i] = null;
                    }
                    $this->view->data = $data;
                    $this->view->relative_time = $relative_time;
                    $this->view->user = $user;
                    $this->view->id = $id;

                    $this->view->headTitle("Trang cá nhân - " . $user['username']);


                    //add show Scroll effect to layout
                    $this->view->scroll_script_include = true;
                    $this->view->show_toolbar = true;
//         $this->view->menu_include = true;
                }
            }
        }
        else if ($act == "send_message") {
            if (!$uid) {
                $this->redirect("/user/login?redirect=/uploader/" . $id . "?act=send_message");
            } else {
                $uid_from = $uid;
                $uid_to = $id;
                $title = $request->getParam("title");
                $msg = $request->getParam("msg");
                $mid_parent = $request->getParam("mid_parent", "0");
                if (is_numeric($mid_parent) && $request->isPost()) {
                    $uid_from = $uid;
                    $uid_to = $id;
                    $title = $request->getParam("title");
                    $model = new MessageModel();
                    $tatus = $model->addMessage(array(
                        "uid_from" => $uid_from,
                        "uid_to" => $uid_to,
                        "message" => $msg,
                        "title" => $title,
                        "date_created" => date("Y-m-d H:i:s")
                    ));
                }
            }
            $this->view->message = $message;
        }
    }

}