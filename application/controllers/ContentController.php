<?php

class ContentController extends Zend_Controller_Action
{
    //--------------------------------------------------------------------------
    // Show list of favorite pages.
    //--------------------------------------------------------------------------
    public function favoritesAction()
    {
        $favorites = new Application_Model_Favorite();
        $this->view->titles = $favorites->all();
    }

    //--------------------------------------------------------------------------
    // Show titles from a category.
    //--------------------------------------------------------------------------
    public function categoryAction()
    {
        $category_id = $this->_getParam('category_id');
        $category = new Application_Model_Category();
        if ($category = $category->findId($category_id)) {
            $page = new Application_Model_Page();
            $this->view->pageTitle = $category->current()->category;
            $this->view->titles = $page->all($category_id);
        } else {
            throw new Zend_Controller_Action_Exception();
        }
    }

    //--------------------------------------------------------------------------
    // Show page info.
    //--------------------------------------------------------------------------
    public function pageAction()
    {
        $page_id = $this->_getParam('page_id');
        $page = new Application_Model_Page();
        if ($this->view->page = $page->findPage($page_id)) {
            if (Zend_Auth::getInstance()->hasIdentity()) {
                // Check if selected page is marked as favorite.
                $favorite = new Application_Model_Favorite();
                $this->view->isFavorite = $favorite->isFavorite($page_id);

                $history = new Application_Model_History();
                $history->addPage($page_id);
            }
        } else {
            throw new Zend_Controller_Action_Exception();
        }
    }

    //--------------------------------------------------------------------------
    // Add page to favorites.
    //--------------------------------------------------------------------------
    public function addtofavoritesAction()
    {
        $page_id = $this->_getParam('page_id');

        $favorite = new Application_Model_Favorite();
        $favorite->add($page_id);

        $this->_helper->setFlash('added');
        $this->_redirect("/page/{$page_id}");
    }

    //--------------------------------------------------------------------------
    // Remove page from favorites.
    //--------------------------------------------------------------------------
    public function removefromfavoritesAction()
    {
        $page_id = $this->_getParam('page_id');

        $favorite = new Application_Model_Favorite();
        $favorite->remove($page_id);

        $this->_helper->setFlash('removed');
        $this->_redirect("/page/{$page_id}");
    }

    //--------------------------------------------------------------------------
    // Show PDF titles
    //--------------------------------------------------------------------------
    public function pdfsAction()
    {
        $this->pdfs = new Application_Model_Pdf();
        $this->view->titles = $this->pdfs->all();
    }

    //--------------------------------------------------------------------------
    // Download PDF file
    //--------------------------------------------------------------------------
    public function viewpdfAction()
    {
        $pdf = new Application_Model_Pdf();
        $pdf = $pdf->findPdf($this->_getParam('pdf_name'));

        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity() || $auth->getIdentity()->isExpired) {
            return $this->view->pdf = $pdf;
        }

        $history = new Application_Model_History();
        $history->addPdf($pdf->id);

        $this->_helper->sendFile($pdf->file_name, PDF_DIR . $pdf->tmp_name);
    }

    //--------------------------------------------------------------------------
    // Show 'Your Viewing History'.
    //--------------------------------------------------------------------------
    public function historyAction()
    {
        $history = new Application_Model_History;
        $this->view->pages = $history->allPages();
        $this->view->pdfs = $history->allPdfs();
    }

}
