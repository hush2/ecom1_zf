<?php

class Application_Form_ChangePassword extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('change_password');

        $this->addElement('password', 'current_password', array(
            'label' => 'Current Password<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your current password.')),
                array('StringLength', true, array(6, 20, 'messages' => 'Password must be %min% to %max% characters.')),
                array('CorrectPassword', true, Zend_Auth::getInstance()->getIdentity()->id),
        )));

        $this->addElement('password', 'new_password', array(
            'label' => 'New Password<br/>',
            'description' => '<small>Must be between 6 and 20 characters long, with at least one lowercase letter, one uppercase letter, and one number.</small>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your new password.')),
                array('StringLength', true, array(6, 20, 'messages' => 'Password must be %min% to %max% characters.')),
                array('Regex', true, array('pattern' => '/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*)+/', 'messages' => 'Password format is not valid.')),
        )));

        $this->addElement('password', 'confirm_password', array(
            'label' => 'Confirm New Password<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please confirm your password.')),
                array('Identical', true, array('token' => 'new_password', 'messages' => 'You confirm password does not match.')),
        )));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Change &rarr;',
            'class' => 'formbutton',
            'decorators' => array('ViewHelper',
                                  'Decode'),
        ));
    }
}
