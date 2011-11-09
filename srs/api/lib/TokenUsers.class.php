<?php

require_once("./db/ActiveRecord.class.php");

class TokenUsers extends ActiveRecord
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_users', $key, $col);
    }
    
    public function create_token($name, $friend_id)
    {
        //add this to token_name table.  See if it's already there
        //if already exists, set $name_id to query value.
        //otherwise, add it to the table and get the ID for $name_id
        //Add to tokens table, associated to $name_id
        //Get tokens table token ID
        //Insert row into tokens_users table with current
        
        foreach( $friend_id as $value)
        {
            //For each
        }
    }
    
}

?>
