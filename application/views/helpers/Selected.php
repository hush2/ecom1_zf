<?php

class Zend_View_Helper_Selected extends Zend_View_Helper_Abstract
{
    public function selected($menu)
    {
        $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        if ($action == $menu) {
            return "class='selected'";
        }
    }
}