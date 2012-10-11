<?php

class My_Decorator_Decode extends Zend_Form_Decorator_Abstract
{
    public function render($content = '')
    {
        return html_entity_decode($content);
    }
}
