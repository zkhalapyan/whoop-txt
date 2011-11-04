<?php

require_once("./db/ActiveRecord.class.php");

class TokenUsers extends ActiveToken
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_users', $key, $col);
    }
    
}

?>
