<?php
class Admin_Form_News extends Zend_Form {
    public function init() {
        $this->setAction("/admin/news/add")
                ->setMethod("POST");
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel("Tiêu đề : ")
                ->setRequired();
        $content = new Zend_Form_Element_Textarea("content");
        $content->setLabel("Nội dung : ")
                ->setAttribs(array(
                    'id' => 'content-id',
                    'rows' => '14',
                    "class" => "ckeditor"
                ))
                ->setRequired();
        $submit = new Zend_Form_Element_Submit('Tạo tin tức');
        $this->addElement($title)
                ->addElement($content)
                ->addElement($submit);
                
    }
}