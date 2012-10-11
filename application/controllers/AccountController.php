<?php

class AccountController extends Zend_Controller_Action
{
    //--------------------------------------------------------------------------
    // Process user login.
    //--------------------------------------------------------------------------
    public function loginAction()
    {
        $form = new Application_Form_Login();
        if ($this->_helper->isFormValid($form)) {
            $email = $form->getValue('login_email');
            $password = $form->getValue('login_password');
            if ($this->authAttempt($email, $password)) {
                $this->_redirect('/home');
            }
            $form->authFailed();
        }
        $this->view->loginForm = $form;
        $this->renderScript('home/index.phtml');
    }

    //--------------------------------------------------------------------------
    // Logout current user.
    //--------------------------------------------------------------------------
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/home');
    }

    //--------------------------------------------------------------------------
    // Show/process registration form.
    //--------------------------------------------------------------------------
    public function registerAction()
    {
        $form = new Application_Form_Register();
        if ($this->_helper->isFormValid($form)) {
            $user = new Application_Model_User();
            if ($user->add($this->getRequest()->getParams())) {
                $this->_helper->setFlash('success');
                $this->_redirect('/register');
            }
            throw new Zend_Controller_Action_Exception('You could not be registered due to a system error. We apologize for any inconvenience.');
        }
        $this->view->form = $form;
    }

    //--------------------------------------------------------------------------
    // Show/process change password form.
    //--------------------------------------------------------------------------
    public function changepasswordAction()
    {
        $form = new Application_Form_ChangePassword();
        if ($this->_helper->isFormValid($form)) {
            $user = new Application_Model_User();
            if ($user->changePassword($this->_getParam('new_password'))) {
                $this->_helper->setFlash('success');
                $this->_redirect('/change_password');
            }
            throw new Zend_Controller_Action_Exception('Your password could not be changed due to a system error. We apologize for any inconvenience.');
        }
        $this->view->form = $form;
    }

    //--------------------------------------------------------------------------
    // Show/process forgot password form.
    //--------------------------------------------------------------------------
    public function forgotpasswordAction()
    {
        $form = new Application_Form_ForgotPassword();
        if ($this->_helper->isFormValid($form)) {
            $user = new Application_Model_User();
            $email = $this->_getParam('email');
            $new_password = $user->createNewPassword($email);            
            if ($new_password) {
                //$message = "Your password to log into <whatever site> has been temporarily changed to '$new_password'. Please log in using that password and this email address. Then you may change your password to something more familiar.";
                //mail($email, 'Your temporary password.', $message, 'From: admin@example.com');
                $this->_helper->setFlash('success');
                $this->_redirect('/forgot_password');
            }
            throw new Zend_Controller_Action_Exception('Your password could not be changed due to a system error. We apologize for any inconvenience.');
        }
        $this->view->form = $form;
    }

    //--------------------------------------------------------------------------
    // Authenticate user.
    //--------------------------------------------------------------------------
    protected function authAttempt($email, $password)
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        $authAdapter->setTableName('users')
                    ->setIdentityColumn('email')
                    ->setCredentialColumn('pass')
                    ->setCredentialTreatment('MD5(?)')
                    ->setIdentity($email)
                    ->setCredential($password);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);        
        if ($result->isValid()) {
            $user = $authAdapter->getResultRowObject();
            $user->isExpired = time() > strtotime($user->date_expires);
            $auth->getStorage()->write($user);
            return true;
        }
    }

    //--------------------------------------------------------------------------
    // Show account renewal form.
    //--------------------------------------------------------------------------
    public function renewAction()
    {
    }
}
