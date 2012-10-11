<?php

class AdminController extends Zend_Controller_Action
{
    //--------------------------------------------------------------------------
    // Show/process Add Page form.
    //--------------------------------------------------------------------------
    public function addpageAction()
    {
        $form = new Application_Form_AddPage();
        if ($this->_helper->isFormValid($form)) {
            $page = new Application_Model_Page();
            if ($page->addPage($this->getRequest()->getPost())) {
                $this->_helper->setFlash('success');
                $this->_redirect('/add_page');
            }
            throw new Zend_Controller_Action_Exception('The page could not be added due to a system error. We apologize for any inconvenience.');
        }
        $this->view->form= $form;
    }

    //--------------------------------------------------------------------------
    // Show form/process submitted PDF file.
    //--------------------------------------------------------------------------
    public function addpdfAction()
    {
        $form = new Application_Form_AddPdf();
        if ($this->_helper->isFormValid($form)) {
            if ($form->pdf->receive()) {
                $pdf = new Application_Model_Pdf();
                $pdf->add($form->getValues(), $form->pdf->getFileInfo());
                $this->_helper->setFlash('success');
                $this->_redirect('/add_pdf');
            } else {
                throw new Zend_Controller_Action_Exception('The PDF could not be added due to a system error. We apologize for any inconvenience.');
            }
        }
        $this->view->form = $form;
    }
}
