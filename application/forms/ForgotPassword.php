<?php

class Application_Form_ForgotPassword extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('forgot_password');

        $this->addElement('text', 'email', array(
            'label' => 'Email Address<br/>',
            'required'=> true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your email address.')),
                array('EmailAddress', true, array('messages' => 'Please enter a valid email address.')),
                array('Db_RecordExists', true, array('users', 'email', 'messages' => 'The submitted email address does not match those on file!')),
        )));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'class' => 'formbutton',
            'label' => 'Reset &rarr;',
            'decorators' => array('ViewHelper',
                                  'Decode'),
        ));
    }
}