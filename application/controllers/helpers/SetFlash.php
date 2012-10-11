<?php

class My_Controller_Action_Helper_SetFlash extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($key, $message=true)
    {
        $flash = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');        
        $flash->addMessage($message, $key);
    }
}
