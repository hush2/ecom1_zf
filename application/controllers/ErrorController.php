<?php

class ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $this->_helper->layout->disableLayout();

        $errors = $this->_getParam('error_handler');

        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                $this->getResponse()->setHttpResponseCode(500);
                $message = $errors->exception->getMessage() ?: 'This page has been accessed in error';
                $this->view->message = $message;
                break;
        }

        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        $this->view->request   = $errors->request;
    }
}
