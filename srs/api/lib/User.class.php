<?php

require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

require_once(dirname(__FILE__).'/Token.class.php');
require_once(dirname(__FILE__).'/TokenName.class.php');
require_once(dirname(__FILE__).'/TokenUser.class.php');

class User extends ActiveRecord
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
    
    public function sendMessageToUser($user)
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
    
    public function joinToken($token)
    {
        
    }
    
    /**
     * 
     * @param string $new_token_name The name of the token to create.
     * @return int The primary key of the created token->user coupling record.
     */
    public function createToken($new_token_name)
    {
        
        //TODO: Do bunch of "duplicate" checks before proceeding.
        
        //Create a new token name.
        $token_name = new TokenName();
        $token_name->name = $new_token_name;
        $token_name->add();
        
        //Create a new token associated with the new token name.
        $token = new Token();
        $token -> token_names_id = $token_name->get_PK();
        $token -> add();
        
        //Create a new token user.
        $token_user = new TokenUser();
        $token_user -> users_id = ConfigFactory::get_facebook()->getUser();
        $token_user -> tokens_id = $token->get_PK();
        $token_user -> active = true;
        $token_user -> pending = false;
        
        return $token->get_PK();
        
        
    }
    
    
    
}

?>
