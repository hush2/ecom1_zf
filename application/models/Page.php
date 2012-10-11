<?php

class Application_Model_Page extends Zend_Db_Table_Abstract
{
    protected $_name = 'pages';

    public function all($category_id)
    {
        $query = $this->select()
                      ->where('category_id=' . $category_id)
                      ->order('date_created desc');
        return $this->fetchAll($query);
    }

    public function findPage($page_id)
    {
        $page = $this->find((int) $page_id);
        if (count($page) < 1) {
            return false;
        }
        return $page->current();
    }

    public function addPage($form)
    {
        $allowed = '<div><p><span><br><a><img><h1><h2><h3><h4><ul><ol><li><blockquote><b><strong><em><i><u><strike><sub><sup><font><hr>';

        $data = array(
            'category_id' => $form['category_id'],
            'title'       => strip_tags($form['title']),
            'description' => strip_tags($form['description']),
            'content'     => strip_tags($form['content'], $allowed),
        );
        try {
            return $this->insert($data);
        } catch (Exception $e) {}
    }
}
