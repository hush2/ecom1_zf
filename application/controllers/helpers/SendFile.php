<?php

class My_Controller_Action_Helper_SendFile extends Zend_Controller_Action_Helper_Abstract
{
     public function direct($newFileName, $originalFilePath)
     {
        if (!file_exists($originalFilePath) || !is_file($originalFilePath)) {
            throw new Zend_Controller_Action_Exception('A system error occurred. We apologize for any inconvenience.');
        }
        
        $layout = Zend_Controller_Action_HelperBroker::getStaticHelper('Layout');
        $layout->disableLayout();

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setNoRender();

        $this->getResponse()
             ->clearAllHeaders()
             //->setHeader("Pragma", "public", true)
             //->setHeader('Cache-control', 'must-revalidate, post-check=0, pre-check=0', true)
             //->setHeader('Cache-control', 'private')
             //->setHeader('Expires', '0', true)
             ->setHeader('Content-Type', 'application/octet-stream')
             ->setHeader('Content-Transfer-Encoding', 'binary', true)
             ->setHeader('Content-Length', filesize($originalFilePath), true)
             ->setHeader('Content-Disposition', 'attachment; filename=' . $newFileName)
             ->setBody(file_get_contents($originalFilePath));
    }
}
