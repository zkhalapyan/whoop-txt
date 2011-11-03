<?php

require_once("./db/ActiveRecord.class.php");

class TokenMessages extends ActiveToken
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_messages', $key, $col);
    }
    
}

?>
