<?php
require_once 'Mobile_Detect.php';
class Cab_Controller_Action extends Zend_Controller_Action {
    public function init() {
         Zend_Layout::getMvcInstance()->setLayout('mobile');
    }
    public function preDispatch() {
        $detect = new Mobile_Detect();
        $deviceType = $detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer';

        //$layoutPath = APPLICATION_PATH . '/layouts';
        
       Zend_Layout::getMvcInstance()->setLayout('mobile');
        
     
//        if ($deviceType == 'computer')
//            Zend_Layout::getMvcInstance()->setLayout('default');
//        else
//            Zend_Layout::getMvcInstance()->setLayout('mobile');
        

    }

}
