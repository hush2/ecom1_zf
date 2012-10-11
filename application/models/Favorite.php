<?php
class Application_Model_Favorite extends Zend_Db_Table_Abstract
{
    protected $_name = 'favorite_pages';

    public function init()
    {
        $this->db = $this->getAdapter();
        $this->user_id = Zend_Auth::getInstance()->getIdentity()->id;
    }

    public function add($page_id)
    {
        $page = new Application_Model_Page();
        if ($page->findPage($page_id)) {
            // Zend_Db_Table has no replace()
            $sql = 'REPLACE INTO favorite_pages (user_id, page_id) VALUES (?, ?)';
            $this->db->query($sql, array($this->user_id, $page_id));
        }
    }

    public function remove($page_id)
    {
        $page = new Application_Model_Page();
        if ($page->findPage($page_id)) {
            $where[] = $this->db->quoteInto('user_id=?', $this->user_id);
            $where[] = $this->db->quoteInto('page_id=?', $page_id);
            $this->delete($where);
        }
    }

    public function isFavorite($page_id)
    {
        $query = $this->select()
                      ->where('user_id=?', $this->user_id)
                      ->where('page_id=?', $page_id);
        return count($this->fetchRow($query));
    }

    public function all()
    {
        $query = $this->select()
                      ->setIntegrityCheck(FALSE)
                      ->from('favorite_pages')
                      ->join('pages', 'favorite_pages.page_id = pages.id')
                      ->where('favorite_pages.user_id=?', $this->user_id)
                      ->order('title')
                      ->limit(10);

        return $this->fetchAll($query);
    }
}
