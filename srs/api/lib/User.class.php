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
    
    	//populate UserMessage table
        
    }       
    
    public function sendMessageToTokens($msg, $token_ids)
    {
    	//TODO: Figure out if we can delete this function.
        foreach($token_ids as $token_id)
        {
            sendMessageToToken($msg, $token_id);
        }
    }
    
    public function sendMessageToUser($user)
    {
        
    }
    
    public function sendMessageToToken($msg, $token_ids, $lon, $lat)
    {
    	//Create new Location
    	$location = new Location();
    	$location->longitude = $lon;
    	$location->latitude = $lat;
    	$location->add();
    	
    	//Create new Message
    	//TODO: Sanitize the body of a message.
    	$message = new Message();
    	$message->author_id = ConfigFactory::get_facebook()->getUser();
    	$message->text = $msg;
    	$message->post_time = time();
    	$message->post_time->add();
    	
    	//Create new message Location associated to the location
    	$message_location = new MessageLocation();
    	$message_location->location_id = $location->get_PK();
    	$message_location->messages_id = $message->get_PK();
    	$message_location->add();
    		
    	//Create new token Message(s)
    	foreach($token_ids as $token_id)
        {
            //for each listd group, add the message to those tokens (tokenMessage)
            $token_message = new TokenMessage();
            $token_message->messages_id = $message->get_PK();
            $token_message->token_id = token_id;
            $token_message->add();
        }
        
        return $message->get_PK();
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
