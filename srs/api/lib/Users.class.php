<?php

require_once("./db/ActiveRecord.class.php");

class Users extends ActiveToken
{
    
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('users', $key, $col);
    }
    
    public function getMessages($limit = 100)
    {
        
    }       
    
    public function sendMessageToTokens($msg, $token_ids)
    {
        foreach($token_ids as $token_id)
        {
            sendMessageToToken($msg, $token_id);
        }
    }
    
    public function sendMessageToUser()
    {
        
    }
    
    public function sendMessageToToken($msg, $token_id)
    {
        
    }
    
    /**
     * 
     * @return All token objects associated with the user.
     */
    public function getTokens()
    {
        
    }
    
    /**
     *
     * @param Token $token The token to associate with the user.
     */
    public function addToken($token)
    {
        
    }
    
    
    
}

?>
