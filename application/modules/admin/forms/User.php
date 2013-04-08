<?php

class Admin_Form_User extends Zend_Form {

    public function init() {
        $this->setAction('/admin/account/add')
                ->setLegend("Thêm tài khoản")
                ->setMethod('POST');

        $username = new Zend_Form_Element_Text('username');
        $username->addValidator("stringLength", false, array(6,20))
                ->addFilter("StripTags")
                ->addFilter("StringTrim")
                ->addValidator("NotEmpty")
                ->setLabel("Tên tài khoản");

        $password = new Zend_Form_Element_Password("password");
        $password ->addValidator("stringLength", false, array(6,40))
                ->setLabel("Mật khẩu");
//        $repassword = new Zend_Form_Element_Password("repassword");
//        
//        $repassword
//                ->setLabel("Nhập lại mật khẩu");
//        
        $info = new Zend_Form_Element_Textarea("info");
        $info->setLabel("Thông tin thêm");
        
        $email = new Zend_Form_Element_Text("email");
        $email->addValidator(new Zend_Validate_EmailAddress())
                ->addValidator("NotEmpty", false)
                ->setLabel("Email");
        $isAdmin = new Zend_Form_Element_Checkbox('admin');
        $isAdmin->setLabel("Là admin:");
        $active = new Zend_Form_Element_Checkbox('active');
        $active->setLabel("Kích hoạt")
               ->setAttrib("checked", "checked");
        $submit = new Zend_Form_Element_Submit("Tạo tài khoản");
        $this->addElement($username)
                ->addElement($password)
//                ->addElement($repassword)
                ->addElement($info)
                ->addElement($email)
                ->addElement($isAdmin)
                ->addElement($active)
                ->addElement($submit);
    }

}