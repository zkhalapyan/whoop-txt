<?php

require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

class MessageLocation extends ActiveRecord
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('message_locations', $key, $col);
    }
    
}

?>
