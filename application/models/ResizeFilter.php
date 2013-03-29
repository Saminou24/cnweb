<?php

require_once 'Skoch/Filter/File/Resize.php';
class ResizeFilter {

    public static function getMediumFilter() {
        $filter = new Zend_Filter();
        $filter->appendFilter(new Skoch_Filter_File_Resize(array(
            'width' => 650,
            'height' => 30000, //scale by width
            'keepRatio' => true,
        )));
        
        return $filter;
    }
    public static function getSmallFilter() {
        $filter = new Zend_Filter();
        $filter->appendFilter(new Skoch_Filter_File_Resize(array(
            'width' => 400,
            'height' => 30000, // scale by width 
            'keepRatio' => true,
        )));
        
        return $filter;
    }

}