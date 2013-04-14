<?php

class Admin_NewsController extends Cab_Controller_Action {

    public function init() {
        $this->view->headTitle("Quản lý thông báo");
    }

    public function preDispatch() {
        Zend_Layout::getMvcInstance()->setLayout("admin");
    }

    public function indexAction() {
        $model = new Admin_Model_News();
        $request = $this->_request;

        $page = $request->getParam("page", 1);
        $message = array();
        if (!is_numeric($page)) {
            $message[] = "Lỗi trang không tồn tại.";
        } else {
            $data = $model->getAllNews();
            if (count($data) == 0) //no data
                $message[] = "Lỗi! Trang không tồn tại!";
            $paginator = Zend_Paginator::factory($data);
            $paginator->setCurrentPageNumber($page);
            $paginator->setDefaultItemCountPerPage(ITEM_PER_PAGE);
            $this->view->paginator = $paginator; //send page to zend view
        }
        $this->view->message = $message;
    }

    public function previewAction() {
        $id = $this->_request->getParam('id');
        $message = array();
        if (!is_numeric($id))
            $message[] = "Trang không tồn tại";
        else {
            $model = new Admin_Model_News();
            $data = $model->getNews($id);
            if (count($data) == 0)
                $message[] = "Thông báo không tồn tại";
            else
                $this->view->data = $data;
        }
        $this->view->message = $message;
    }

    public function addAction() {
        $form = new Admin_Form_News();
        $request = $this->_request;
        $message = array();
        if ($request->isPost()) {
            if ($form->isValid($_POST)) {
                $title = $request->getParam("title");
                $content = $request->getParam("content");
                $date = date("YYYY-MMM-DD h-i-s", time());
                $model = new Admin_Model_News();

                $status = $model->addNews(array(
                    'title' => $title,
                    'content' => $content,
                    'date_created' => $date
                ));
                if (!$status)
                    $message[] = "Đã có lỗi xảy ra vui lòng kiểm tra lại!";
                else
                    $this->redirect("/admin/news/");
            }
        }
        $this->view->form = $form;
        $this->view->message = $message;
    }

    public function editAction() {
        $form = new Admin_Form_News();
        $form->getElement('Tạotintức')->setLabel('Cập nhật tin tức');
        $request = $this->_request;
        $message = array();

        $id = $request->getParam('id');
        if (is_numeric($id)) {
            $model = new Admin_Model_News();
            $data = $model->getNews($id);
            if ($data != null) {
                $form->getElement ('title')->setValue ($data['title']);
                $form->getElement('content')->setValue($data['content']);
            }
            if ($request->isPost()) {
                if ($form->isValid($_POST)) {
                    $title = $request->getPost("title");
                    $content = $request->getPost("content");
                    $date = date("YYYY-MMM-DD h-i-s", time());


                    $status = $model->updateNews($id, array(
                        'title' => $title,
                        'content' => $content
                    ));
                    if (!$status)
                        $message[] = "Đã có lỗi xảy ra vui lòng kiểm tra lại!";
                }
            }
        }
        $this->view->form = $form;
        $this->view->message = $message;
    }

    public function delAction() {
        $id = $this->_request->getParam("id");
        if (is_numeric($id)) {
            $model = new Admin_Model_News();
            $model->delNews($id);
            $this->redirect("/admin/news/");
        }
    }

}
