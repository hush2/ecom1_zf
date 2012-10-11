<?php

class Zend_View_Helper_HasFlash extends Zend_View_Helper_Abstract
{
    private $flash= null;

    public function hasFlash($key)
    {
        if (!$this->flash) {
            $this->flash= Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        }
        return $this->flash->hasMessages($key);
    }
}