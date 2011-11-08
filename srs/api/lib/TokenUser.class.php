<?php

require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

class TokenUser extends ActiveRecord
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('tokens_users', $key, $col);
    }
    
}

?>
