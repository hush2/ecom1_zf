<?php

class Application_Form_Base extends Zend_Form
{
    public function __construct()
    {
        // Note: Setting paths should be done in Boostrap.php :-)
        $this->addPrefixPath('My_Decorator', APPLICATION_PATH . '/forms/decorators', 'decorator')
             ->addElementPrefixPath('My_Validator', APPLICATION_PATH . '/forms/validators', 'validate');

        // Set default FORM decorators.
        $this->addDecorators(array(
                array('Description', array('class' => 'error',  // Login error message.
                                           'tag' => 'span',
                                           'escape' => false)),
                      'FormElements',
                      array('HtmlTag', array('tag' => 'p')),
                      'Form',
        ));

        // Set default FORM ELEMENT decorators.
        $this->setElementDecorators(array(
                'ViewHelper',
                'Error',
                array('Label', array('escape' => false)),
                array('Description', array('escape' => false, 'tag' => 'span')),
                array('HtmlTag', array('tag' => 'p')),
        ));

        parent::__construct(); // Parent constructor should be the last one called.
    }

    // Override setAction so we can add the base URL.
    public function setAction($action)
    {
        return $this->setAttrib('action', $this->getView()->baseUrl($action));
    }
}
