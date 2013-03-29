<?php

class Form_Upload extends Zend_Form {

    public function init() {
        $this->setAction("/upload")
                ->setMethod("post")
                ->setAttrib("enctype", "multipart/form-data");


        $file = new Zend_Form_Element_File("file");
        
        $file->setLabel("Lua chon file")
                ->setRequired(true)
                ->addValidator('Size', false, "2MB")
                ->addValidator("Extension", false, "jpg,png,gif");
        
        $title = new Zend_Form_Element_Text("title");
        $title->setLabel('Tieu de: ')
                ->setRequired(true);
        
//        $description = new Zend_Form_Element_Text("description");
//        $description->setLabel("Mieu ta:");

        $submit = new Zend_Form_Element_Submit("Upload");

        $this->addElement($file)
                ->addElement($title)
                ->addElement($submit);
    }

}