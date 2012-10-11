<?php

class My_Controller_Action_Helper_IsFormValid extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($form)
    {
        if ($this->getRequest()->isPost()) {
            return $form->isValid($this->getRequest()->getPost());
        }
        return false;
    }
}
