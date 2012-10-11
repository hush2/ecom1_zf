<?php

class AclPlugin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $auth        = Zend_Auth::getInstance();
        $acl         = new Acl($auth);
        $controller  = $request->getControllerName();
        $action      = $request->getActionName();
        $role        = $auth->hasIdentity() ? $auth->getIdentity()->type : 'guest';

        if (!$acl->has($controller) || $acl->isAllowed($role, $controller, $action)) {
            return;
        }
        throw new Zend_Controller_Action_Exception('ACCESS DENIED!');
    }
}
