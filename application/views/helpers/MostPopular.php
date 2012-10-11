<?php

class Zend_View_Helper_MostPopular extends Zend_View_Helper_Abstract
{
    public function mostPopular()
    {
        $history = new Application_Model_History();
        return $history->mostPopular();
    }
}