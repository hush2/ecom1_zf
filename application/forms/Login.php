<?php

class Application_Form_Login extends Application_Form_Base
{
    public function init()
    {
        $this->setAction('login');

        $this->addElement('text', 'login_email', array(
            'label' => 'Email Address<br/>',
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your email address.')),
                array('EmailAddress', true, array('messages' => 'Please enter a valid email address.')),
                array('Db_RecordExists', true, array('users', 'email', 'messages' => 'You email was not found.')),
            ),
            'decorators' => array(
                'ViewHelper',
                'Error',
                array('Label', array('escape' => false))),
        ));

        $this->addElement('password', 'login_password', array(
            'label' => 'Password<br/>',
            'required' => true,
            'description' => '<a href="'.$this->getView()->baseUrl('forgot_password').'">Forgot?</a><br/>',
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Please enter your password.')),
                array('StringLength', true, array(6, 20, 'messages' => 'Password must be %min% to %max% characters.')),
            ),
            'decorators' => array(
                'ViewHelper',
                'Error',
                array('Label', array('escape' => false)),
                array('HtmlTag', array('tag' => 'br',
                                       'openOnly' => true)),
                array('Description', array('escape' => false,
                                           'tag' => 'span'))
        )));

        $this->addElement('submit', 'login_submit', array(
            'label' => 'Login &rarr;',
            'ignore' => true,
            'decorators' => array('ViewHelper',
                                  'Decode'),
        ));
    }

    public function authFailed()
    {
        $this->setDescription('The email address and password do not match those on file.<br/>');
    }
}
