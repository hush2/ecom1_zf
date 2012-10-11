<?php

class My_Validator_CorrectPassword extends Zend_Validate_Abstract
{
    protected $_messageTemplates = array(
                'failed' => 'Current password is incorrect.'
              );

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function isValid($value, $context = null)
    {
        $user = new Application_Model_User();
        $row = $user->find($this->id);
        if (count($row) > 0) {
            if ($row->current()->pass == md5($value)) {
                return true;
            }
        }
        $this->_error('failed');
        return false;
    }
}