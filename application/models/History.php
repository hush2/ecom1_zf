<?php

class Application_Model_History extends Zend_Db_Table_Abstract
{
    protected $_name = 'history';

    public function init()
    {
        $this->db = $this->getAdapter();
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->user_id = Zend_Auth::getInstance()->getIdentity()->id;
        }
    }

    public function addPage($page_id)
    {
        $data = array('user_id' => $this->user_id,
                      'page_id' => $page_id,
                      'type'    => 'page',
        );
        try {
            return $this->insert($data);
        } catch (Exception $e) {}
    }

    public function addPdf($pdf_id)
    {
        $data = array('user_id' => $this->user_id,
                      'pdf_id'  => $pdf_id,
                      'type'    => 'pdf',
        );
        try {
            return $this->insert($data);
        } catch (Exception $e) {}
    }

    public function allPages()
    {
        $query = $this->select()
                      ->setIntegrityCheck(false)
                      ->from('history')
                      ->join('pages', 'history.page_id=pages.id')
                      ->where('history.user_id=?', $this->user_id)
                      ->where("history.type='page'")
                      ->group('history.page_id')
                      ->limit(10)
                      ->order('history.date_created desc')
                      ->columns(array('pages.id', 'pages.title', 'pages.description', 'DATE_FORMAT(history.date_created, "%M %d, %Y") as date'));
        return $this->fetchAll($query);
    }

    public function allPdfs()
    {
        $query = $this->select()
                      ->setIntegrityCheck(false)
                      ->from('history')
                      ->join('pdfs', 'history.pdf_id=pdfs.id')
                      ->where('history.user_id=?', $this->user_id)
                      ->where("history.type='pdf'")
                      ->group('history.pdf_id')
                      ->limit(10)
                      ->order('history.date_created desc')
                      ->columns(array('pdfs.tmp_name', 'pdfs.title', 'pdfs.description', 'DATE_FORMAT(history.date_created, "%M %d, %Y") as date'));
        return $this->fetchAll($query);
    }

    public function mostPopular()
    {
        $query = $this->select()
                      ->setIntegrityCheck(false)
                      ->from('history')
                      ->join('pages', 'history.page_id=pages.id')
                      ->where("history.type='page'")
                      ->group('history.page_id')
                      ->limit(10)
                      ->order('n desc')
                      ->columns(array('pages.id', 'pages.title', 'COUNT(history.id) as n'));
        return $this->fetchAll($query);
    }
}
