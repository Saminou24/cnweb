<?php

class NewsController extends Cab_Controller_Action {
    public function init() {
        Zend_Loader::loadClass("NewsModel");
    }
    public function indexAction(){
        $request = $this->getRequest();
        $id = $request->getParam("id");
        $model = new NewsModel();
        $data = $model->getNews($id);
        $this->view->data = $data;
    }
}