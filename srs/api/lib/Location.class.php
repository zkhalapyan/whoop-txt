<?php

require_once("./db/ActiveRecord.class.php");

class Locations extends ActiveToken
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('locations', $key, $col);
    }
    
}

?>
