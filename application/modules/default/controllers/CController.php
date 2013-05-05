<?php

class CController extends Cab_Controller_Action {

    public function init() {
        Zend_Loader::loadClass("PostModel");
        Zend_Loader::loadClass("CommentModel");
        Zend_Loader::loadClass("LikeModel");
        Zend_Loader::loadClass("TimeUtil");
    }

    public function indexAction() {
        $id = $this->_request->getParam("page");
        $message = array();
        $request = $this->_request;
        $mode = $request->getParam("mode", "normal");
        $this->view->mode = $mode;
        if ($mode == "plugin")
              $this->_helper->layout->disableLayout();
        if ($id == null || !is_numeric($id)) {
            $this->view->message = "Lỗi! Bơi nhầm đường rồi cá ợ :D. Trở về trang chủ nào<br/>
                <a href='" . BASE_URL . "' > Trang chủ </a>";
            $this->view->status = "error";
  
        } else {
            //get data
            $likeModel = new LikeModel();
            $data = PostModel::getPost($id);

            $this->view->content = $data;
            $this->view->relative_time = TimeUtil::calRelativeTime($data['date-created']);
            $this->view->like_count = $likeModel->getLikeByTargetId($id, "photo");
            $this->view->prevId = PostModel::getPreviousPostId($id);
            $this->view->nextId = PostModel::getNextPostId($id);



            if ($request->isPost()) {
                $session = new Zend_Session_Namespace("user");
                if (!$session->username)
                    $message[] = "Bạn phải đăng nhập để gửi bình luận";
                else {
                    $comment = $request->getParam("comment");
                    if (strlen($comment) < 6 || strlen($comment) > 100)
                        $message[] = "Bình luận phải có độ dài 6-100 ký tự";
                    else {
                        $model = new CommentModel();
                        $status = $model->addComment(array(
                            "uid" => $session->uid,
                            "pid" => $id,
                            "comment" => $comment,
                            "date_created" => date("Y-m-d H:i:s")
                        ));
                        if (!$status)
                            $message[] = "Đã có lỗi xảy ra";
                    }
                }
            }

            //getcomment 
            $commentModel = new CommentModel();
            $comments = $commentModel->getAllCommentOfPost($id);
            $this->view->commentData = $comments;
        }
    }

    public function testAction() {
        
    }

}
