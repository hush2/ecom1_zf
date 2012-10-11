<?php

class Application_Model_Pdf extends Zend_Db_Table_Abstract
{
    protected $_name = 'pdfs';

    public function all()
    {
        $query = $this->select()
                      ->order('date_created desc');
        return $this->fetchAll($query);
    }

    public function findPdf($pdf_name)
    {
        $query = $this->select()
                      ->where('tmp_name=?', $pdf_name);
        return $this->fetchRow($query);
    }

    public function add($form, $pdf)
    {
        $data = array(
            'tmp_name'    => $pdf['pdf']['name'],
            'title'       => strip_tags($form['title']),
            'description' => strip_tags($form['description']),
            'file_name'   => $_FILES['pdf']['name'],
            'size'        => round($pdf['pdf']['size'] / 1024),
        );
        try {
            return $this->insert($data);
        } catch (Exception $e) {}
    }

}
