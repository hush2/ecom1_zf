<?php

class Acl extends Zend_Acl
{
    public function __construct(Zend_Auth $auth)
    {
        $this->add(new Zend_Acl_Resource('home'));
        $this->add(new Zend_Acl_Resource('account'));
        $this->add(new Zend_Acl_Resource('content'));
        $this->add(new Zend_Acl_Resource('admin'));

        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('member'));
        $this->addRole(new Zend_Acl_Role('admin'));

        $this->allow('guest', 'home');
        $this->allow('guest', 'content', 'category');
        $this->allow('guest', 'content', 'page');
        $this->allow('guest', 'content', 'pdfs');
        $this->allow('guest', 'content', 'viewpdf');
        $this->allow('guest', 'account', 'register');
        $this->allow('guest', 'account', 'login');
        $this->allow('guest', 'account', 'forgotpassword');

        $this->allow('member', 'home');
        $this->allow('member', 'content');
        $this->allow('member', 'account');
        $this->deny('member',  'account', 'register');
        $this->deny('member',  'account', 'login');
        $this->deny('member',  'account', 'forgotpassword');

        $this->allow('admin');
    }
}