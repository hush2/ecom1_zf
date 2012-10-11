<?php

class Zend_View_Helper_Categories extends Zend_View_Helper_Abstract
{
    public function categories()
    {
        $category = new Application_Model_Category();
        return $category->all();
    }
}
