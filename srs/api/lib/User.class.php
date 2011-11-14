<?php


require_once(dirname(__FILE__).'/APIException.class.php');
require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');
require_once(dirname(__FILE__).'/Token.class.php');
require_once(dirname(__FILE__).'/TokenName.class.php');
require_once(dirname(__FILE__).'/TokenUser.class.php');
require_once(dirname(__FILE__).'/Location.class.php');
require_once(dirname(__FILE__).'/Message.class.php');
require_once(dirname(__FILE__).'/TokenMessage.class.php');
require_once(dirname(__FILE__).'/MessageLocation.class.php');
require_once(dirname(__FILE__).'/UserMessage.class.php');

class User extends ActiveRecord
{
    
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('users', $key, $col);
        
    }
    
    public function getMessages($limit = 100)
    {
        
    } 
    
    public function sendMessageToUser($user)
    {
        
    }
    
    public function sendMessageViaToken($msg, $tokens, $lon, $lat)
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
    	$message->add();
    	
    	//Create new message Location associated to the location
    	$message_location = new MessageLocation();
    	$message_location->location_id = $location->getKey();
    	$message_location->messages_id = $message->getKey();
    	$message_location->add();
    		
    	//Create new token Message(s)
    	foreach($tokens as $token_id)
        {
            //for each listd group, add the message to those tokens (tokenMessage)
            $token_message = new TokenMessage();
            $token_message->messages_id = $message->getKey();
            $token_message->token_id = $token_id;
            $token_message->add();
            
            //For each token, get every user id associated to it.
            $query = "SELECT t.id, t_s.users_id
                  FROM tokens_users t_s
                  INNER JOIN tokens t ON t.id = t_s.tokens_id 
                  INNER JOIN token_names t_n ON t_n.id = t.token_names_id
                  WHERE tokens_id = $token_id";
            
            //Execute the query
            $result = DB::mysqli()->query($query);
            
            //Check for any errors on query execution
            if($result === false)
            {
                throw new ARException('MySQL Error: '.DB::mysqli()->error);
            }
            
        
            //Read the result row by row.
            
            while($row = mysqli_fetch_assoc($result))
            {   
                $user_message = new UserMessage();
                $user_message->users_id = $row["users_id"];
                $user_message->messages_id = $message->getKey();
                $user_message->add();
            }            
        }
        
        
        return $message->getKey();
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
                  WHERE users_id = '".$this->getKey()."'";
        
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
        
        //If the specified token does not exist, throw an exception.
        if(!$token->exists())
        {
            throw new APIException("Unable to join token. Token [ID: $token_id] does not exist.");
        }
        
        //If the user is not part of the token, then throw an exception.
        if(!$this->isInToken($token))
        {
            throw new APIException("Unable to join token. User [".$this->getKey()."] is not invited to token [ID: $token_id].");
        }
        
        $query = "UPDATE tokens_users 
                  SET active=1, pending=0 
                  WHERE tokens_id=$token_id AND
                        pending = 1 AND
                        users_id=".$this->getKey();
        
        
        $result = DB::mysqli()->query($query);
        
        if ($result === false)
        {
            throw new APIException('MySQL Error: '.DB::mysqli()->error);
        }        
        
        return $result;
        
    }
    
    public function ignoreToken($token_id)
    {
        $token = new Token($token_id);
        
        //If the specified token does not exist, throw an exception.
        if(!$token->exists())
        {
            throw new APIException("Unable to join token. Token [ID: $token_id] does not exist.");
        }
        
        //If the user is not part of the token, then throw an exception.
        if(!$this->isInToken($token))
        {
            throw new APIException("Unable to join token. User [".$this->getKey()."] is not invited to token [ID: $token_id].");
        }
        
        $query = "UPDATE tokens_users 
                  SET active=0, pending=0 
                  WHERE tokens_id=$token_id AND
                        users_id=".$this->getKey();
        
        
        $result = DB::mysqli()->query($query);
        
        if ($result === false)
        {
            throw new APIException('MySQL Error: '.DB::mysqli()->error);
        }        
        
        return $result;
        
    }
    
    
    /**
     * 
     * @param string $new_token_name The name of the token to create.
     * @return int The primary key of the created token->user coupling record.
     */
    public function createToken($new_token_name)
    {
        
        //If the token name already exits then retrieve it, and if it doesn't 
        //exist, create it and then return it. Using getTokenName allows 
        //avoiding creating duplicate token names.
        $token_name = TokenName::getTokenName($new_token_name);
        
        //Create a new token associated with the new token name.
        $token = new Token();
        $token -> token_names_id = $token_name->getKey();
        $token -> add();
        
        //Create a new token user.
        $token_user = new TokenUser();
        $token_user -> users_id = $this->getKey();
        $token_user -> tokens_id = $token->getKey();
        $token_user -> active = true;
        $token_user -> pending = false;
        $token_user->add();
        
        //Return the created token's ID.
        return $token->getKey();
        
        
    }
    
    
    /**
     * Uses the token's ID and the user's ID to check if the user is associated
     * with the token in the users_tokens table. Returns a boolean value.
     * 
     * @param Token $token Token object that is associated with a primary key.
     * @return boolean True if this user is associated with the given token, 
     *                  false, otherwise.
     */
    public function isInToken($token)
    {
        $query = "SELECT t_s.id
                  FROM tokens_users t_s
                  WHERE t_s.tokens_id='$token->id' AND
                  t_s.users_id = '".$this->getKey()."'";
        
        $result = DB::mysqli()->query($query);

        if ($result === false)
        {
            throw new APIException('MySQL Error: '.DB::mysqli()->error);
        }
        
        return $result->num_rows > 0;
        
    }
    
    /**
     * Checks if the user is associated with at least one token with the 
     * specified name. 
     * 
     * @param string $token_name The name of the token to check.
     * @return boolean Returns true if a user is associated with at least one
     *                 token with the specified name.
     */
    public function isInTokenByName($token_name)
    {
        //Get the tokens associated with users.
        $user_tokens = $this->getTokens();
        
        //Walk through the tokens associated with the user, and if one of the 
        //token's name equal to the specified token name, then return true.
        foreach($user_tokens as $token)
        {
            if($token["name"] == $token_name)
            {
                return true;
            }
        }
        
        //If the user was not associated with a 
        return false;
    }
    
    /**
     * Returns false if the user is an invalid Facebook users; otherwise,
     * retreives public information about the user and returns it.
     */
    public function getProfile()
    {
        try 
        {
            $profile = ConfigFactory::get_facebook()->api("/".$this->getKey());
        }
        catch(Exception $ex)
        {
            return false;
        }
        
        return $profile;
    }
}

?>
