<?php
class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'categories';

    public function all()
    {
        $query = $this->select()
                      ->order('category');
        return $this->fetchAll($query);
    }

    public function findId($id)
    {
        $category = $this->find($id);
        if (count($category) > 0) {
            return $category;
        }
    }
}
