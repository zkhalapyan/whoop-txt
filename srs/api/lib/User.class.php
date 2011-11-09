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
    
    public function sendMessageViaTokens($msg, $token_ids)
    {
        foreach($token_ids as $token_id)
        {
            sendMessageToToken($msg, $token_id);
        }
    }
    
    public function sendMessageToUser($user)
    {
        
    }
    
    public function sendMessageViaToken($msg, $token_id)
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
        
        //Query to select all the user's tokens.
        $query = "SELECT t.id, t_n.name, t_s.active, t_s.pending 
                  FROM tokens_users t_s
                  INNER JOIN tokens t ON t.id = t_s.tokens_id 
                  INNER JOIN token_names t_n ON t_n.id = t.token_names_id
                  WHERE users_id = '".$this->get_PK()."'";
        
        //Execute the query.
        $result = DB::mysqli()->query($query);

        //Check for any errors on query execution.
        if ($result === false)
        {
            throw new ARException('MySQL Error: '.DB::mysqli()->error);
        }
        
        //The constructed token list to be returned.
        $token_list = array();
        
        //Read the result row by row.
        while($row = mysqli_fetch_assoc($result))
    	{
            $token = array();
            
            $token["id"]      = $row["id"];
            $token["name"]    = $row["name"];
            $token["pending"] = ($row["pending"] == "1")? true : false;
            $token["active"]  = ($row["active"] == "1")? true : false;
            
            $token_list[] = $token;

    	}
        
        return $token_list;
        
    }
    
    public function joinToken($token_id)
    {
        $token = new Token($token_id);
        
        if(!$token->exists())
        {
            throw new APIException("Unable to join token. Token [ID: $token_id] does not exist.");
        }
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
        $token_user -> users_id = $this->get_PK();
        $token_user -> tokens_id = $token->get_PK();
        $token_user -> active = true;
        $token_user -> pending = false;
        $token_user->add();
        
        return $token->get_PK();
        
        
    }
    
    
    
}

?>
