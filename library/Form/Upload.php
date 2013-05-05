<?php

class Form_Upload extends Zend_Form {

    public function init() {
        
        //load url valid class
        Zend_Loader::loadClass("UrlValidator");
        
        $this->setAction("/upload")
                ->setMethod("post")
                ->setAttrib("enctype", "multipart/form-data");


        $file = new Zend_Form_Element_File("file");
        
        $file->setLabel("Lựa chọn file:")
//                ->setRequired(true)
                ->addValidator('Size', false, "2MB")
                ->addValidator("Extension", false, "jpg,png,gif");
        $video = new Zend_Form_Element_Text("video");
        $video->setLabel("Hoặc link video từ Youtube :")
                ->addFilter("StringTrim");
//                ->addValidator(new UrlValidator());
        
        $title = new Zend_Form_Element_Text("title");
        $title->setAttrib("placeholder", "Tiêu đề của ảnh")
                ->addValidator("StringLength", false, array("min" => 6, "max" => "70"))
                ->setRequired(true);
        
//        $description = new Zend_Form_Element_Text("description");
//        $description->setLabel("Mieu ta:");

        $submit = $this->createElement("button", "Đăng bài");
        $submit->setAttrib("type", "submit");

        $this->addElement($file)
                ->addElement($video)
                ->addElement($title)
                ->addElement($submit);
    }

}