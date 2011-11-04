<?php

require_once("./db/ActiveRecord.class.php");

class MessageLocations extends ActiveToken
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('message_locations', $key, $col);
    }
    
}

?>
