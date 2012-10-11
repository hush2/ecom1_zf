<?php

class My_Decorator_Error extends Zend_Form_Decorator_Abstract
{
    public function render($content = '')
    {
        if ($messages = $this->getElement()->getMessages()) {
            $messages = array_values($this->getElement()->getMessages());
            return "<span class='error'> $content {$messages[0]} </span>";
        }
        return $content;
    }
}