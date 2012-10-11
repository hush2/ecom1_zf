<?php

class Application_Form_Register extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('register')
             ->setAttrib('id', 'register');

        $this->addElement('text', 'first_name', array(
            'label' => 'First Name<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your first name.')),
                array('StringLength', true, array(2, 20, 'messages' => 'First name must be %min% to %max% characters.')),
                array('Regex', true, array('pattern' => '/^[A-Z \'.-]+$/i',
                                           'messages' => 'Please enter a valid first name.')),
        )));

        $this->addElement('text', 'last_name', array(
            'label' => 'Last Name<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your last name.')),
                array('StringLength', true, array(2, 40, 'messages' => 'Last name must be %min% to %max% characters.')),
                array('Regex', true, array('pattern' => '/^[A-Z \'.-]+$/i',
                                           'messages' => 'Please enter a valid last name.')),
        )));

        $this->addElement('text', 'username', array(
            'label' => 'Desired Username<br/>',
            'description' => '<small>Only letters and numbers are allowed.</small>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your desired username.')),
                array('StringLength', true, array(2, 30, 'messages' => 'Username must be %min% to %max% characters.')),
                array('Alnum', true, array('messages' => 'Please enter a valid username.')),
                array('Db_NoRecordExists', true, array('users', 'username', 'messages' => 'This username has already been registered. Please try another.')),
        )));

        $this->addElement('text', 'email', array(
            'label' => 'Email Address<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your email address.')),
                array('EmailAddress', true, array('messages' => 'Please enter a valid email address.')),
                array('Db_NoRecordExists', true, array('users', 'email', 'messages' => 'This email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.')),
        )));

        $this->addElement('password', 'pass', array(
            'label' => 'Password<br/>',
            'description' => '<small>Must be between 6 and 20 characters long, with at least one lowercase letter, one uppercase letter, and one number.</small>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your password.')),
                array('StringLength', true, array(6, 20, 'messages' => 'Password must be %min% to %max% characters.')),
                array('Regex', true, array('pattern' => '/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*)+/', 'messages' => 'Password format is not valid.')),
        )));

        $this->addElement('password', 'pass2', array(
            'label' => 'Confirm Password<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please confirm your password.')),
                array('Identical', true, array('token' => 'pass', 'messages' => 'Your confirm password does not match.')),
        )));

        $this->addElement('submit', 'submit', array(
            'label' => 'Next &rarr;',
            'ignored' => true,
            'class' => 'formbutton',
            'decorators' => array('ViewHelper',
                                  'Decode'),
        ));
    }
}
