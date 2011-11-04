<?php

require_once("./db/ActiveRecord.class.php");

class Messages extends ActiveRecord 
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('messages', $key, $col);
    }
}

?>
