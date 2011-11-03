<?php

require_once("./db/ActiveRecord.class.php");

class UserMessages extends ActiveToken
{
    
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('user_messages', $key, $col);
    }
   
}

?>
