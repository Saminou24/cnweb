<?php

class Admin_AccountController extends Cab_Controller_Action {

    public function preDispatch() {
        Zend_Layout::getMvcInstance()->setLayout("admin");
        $session = new Zend_Session_Namespace("user");
        if (!$session->username)
            $this->redirect("/user/login?redirect=/admin/index");
        else
        if (!$session->isAdmin)
            $this->redirect ("/");

    }

    public function indexAction() {
        //set title
        $this->view->headTitle('Quản lý thành viên');
        $this->view->message = [];
        $model = new Admin_Model_Account();

        $page = $this->_request->getParam("page", 1);

        if (!is_numeric($page))
            $this->view->message[] = "Lỗi! Trang không tồn tại";
        else {
            //fetch all account
            $listUser = $model->getAllUsersData();
            $paginator = Zend_Paginator::factory($listUser);
            $paginator->setCurrentPageNumber($page);
            $paginator->setDefaultItemCountPerPage(ITEM_PER_PAGE);
            $this->view->paginator = $paginator; //send page to zend view
        }
    }

    public function editAction() {
        $message = [];
        $request = $this->getRequest();
        $id = $request->getParam("id");
        $model = new Admin_Model_Account();
        $form = new Admin_Form_User();
        $form->setAction("/admin/account/edit/id/$id");

        $userData = $model->getUserData($id);

        if (count($userData) == 0)
            $message[] = "Tài khoản không tồn tại!";
        $form->getElement("username")->setValue($userData['username']);
        $form->getElement('password')->setValue($userData['password']);
        $form->getElement('info')->setValue($userData['info']);
        $form->getElement('email')->setValue($userData['email']);
        if ($userData['active'])
            $form->getElement('active')->setAttrib("checked", "checked");

        if ($userData['admin'])
            $form->getElement('admin')->setAttrib("checked", "checked");

        if ($request->isPost()) {



            if ($form->isValid($_POST)) {
                $username = $request->getPost('username');
                $pass = $request->getPost('password');
                $info = $request->getPost('info');
                $active = $this->getPost('active');
                $isAdmin = $this->getPost('admin');
                $email = $this->getPost('email');
                $result = $model->updateUser($id, array(
                    'username' => $username,
                    'password' => $pass,
                    'info' => $info,
                    'active' => $active,
                    'admin' => $isAdmin,
                    'email' => $email,
                    'date_created' => date("YYYY - MM - DD h:i:s")
                ));
                if ($result['status'])
                    $this->redirect("/admin/account/");
                else
                    $message = $result['message'];
            }
        }
        $this->view->message = $message;
        $this->view->form = $form;
    }

    public function addAction() {
        $request = $this->_request;
        $form = new Admin_Form_User();
        $form->setAction("/admin/account/add");

        $model = new Admin_Model_Account();
        $this->view->form = $form;

        $message = array();
        if ($request->isPost()) {

            // exit(0);
            if ($form->isValid($_POST)) {
                $username = $request->getPost('username');
                $pass = $request->getPost('password');
                $info = $request->getPost('info');
                $active = $request->getPost('active');
                $isAdmin = $request->getPost('admin');
                $email = $request->getPost('email');
                if (strstr($username, " ") ||
                        strstr($pass, " "))
                    $message[] = "Tên tài khoản hoặc mật khẩu không được có dấu cách";
                else {
                    $result = $model->creatUser(array(
                        'username' => $username,
                        'password' => $pass,
                        'info' => $info,
                        'email' => $email,
                        'active' => $active,
                        'admin' => $isAdmin,
                        'date_created' => date("d M Y H:i:s")
                    ));

                    if ($result['status']) //redirect
                        $this->redirect("/admin/account/");
                    else
                        $message = $result['message'];
                }
            }
        }
        $this->view->message = $message;
    }

    public function delAction() {
        $id = $this->_request->getParam('id');

        if (is_numeric($id)) {
            $model = new Admin_Model_Account();
            $model->deleteUser($id);
            $this->redirect("/admin/account");
        }
        else
            Zend_Debug::dump($id);
    }

    public function __call($methodName, $args) {
        //$this->redirect("/admin/account/index");
    }

}