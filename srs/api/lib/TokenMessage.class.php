<?php

require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

class TokenMessage extends ActiveRecord
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_messages', $key, $col);
    }
    
}

?>
