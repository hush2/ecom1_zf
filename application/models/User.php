<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';

    public function init()
    {
        $this->db = $this->getAdapter();
    }

    public function add($data)
    {
        $user = array(
            'username'     => $data['username'],
            'email'        => $data['email'],
            'pass'         => md5($data['pass']),
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'date_expires' => new Zend_Db_Expr('ADDDATE(NOW(), INTERVAL 1 MONTH)'),
        );
        try {
            return $this->insert($user);
        } catch (Exception $e) { }
    }

    public function changePassword($password)
    {
        $data = array(
            'pass' => md5($password),
            'date_modified' => new Zend_Db_Expr('NOW()'),
        );
        $where = 'id=' . Zend_Auth::getInstance()->getIdentity()->id;
        try {
            return $this->update($data, $where);
        } catch (Exception $e) { }
    }

    public function createNewPassword($email)
    {
        $new_password = substr(md5(uniqid(rand(), true)), 10, 15);
        $data = array(
            'pass' => md5($new_password),
            'date_modified' => new Zend_Db_Expr('NOW()'),
        );
        try {
            $where = 'email=' . $this->db->quote($email);
            $this->update($data, $where);
            return $new_password;
        } catch (Exception $e) { }
    }
}