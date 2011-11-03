<?php

require_once("./db/ActiveRecord.class.php");

class TokenNames extends ActiveRecord 
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_names', $key, $col);
    }
}

?>
