<?php

class SuggestController extends Zend_Controller_Action {

    public function init() {
        //set no view render
        //$this->_helper->viewRender->setNoRender(true);
        $this->_helper->layout->disableLayout();
    }

    public function preDispatch() {
        
    }

    public function indexAction() {
        $query = $this->_request->getParam("q");
        echo $query;
        $index = new Zend_Search_Lucene("lucene");
        $result = $index->find("*".$query."*");

        echo "<section data-type='list' ><ul  >";
        foreach ($result as $r) {
            echo '<li>
                    <label class="danger">
                        <input type="checkbox">
                        <span></span>
                    </label>
                    <a href="' . $r->link . '">' . $r->title . '</a>
                  </li>';
        }
        echo "</ul></section>";
    }

}