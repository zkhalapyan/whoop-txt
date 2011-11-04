<?php

require_once("./db/ActiveRecord.class.php");

class Tokens extends ActiveToken
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('tokens', $key, $col);
    }
    
}

?>
