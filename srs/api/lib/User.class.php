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
       $user_id = $this->getKey();
        
       $query = "SELECT messages.id, 
                        messages.text, 
                        messages.post_time, 
                        
                        users.full_name, 
                        users.id as author_id,
                        
                        user_messages.opened, 
                        user_messages.important
                        
                 FROM messages 
                 
                 INNER JOIN users on users.id = messages.author_id 
                 INNER JOIN user_messages ON messages.id = user_messages.messages_id 
                 
                 WHERE user_messages.users_id = '$user_id' 
                   AND user_messages.deleted <> 1 
                 
                 ORDER BY messages.post_time DESC 
       
                 LIMIT 0, $limit";
       
      
        $result = DB::query($query);
        
        //Will store a list of messages to be returned.
        $message_list = array();
        
        //Read the result row by row.
        while($row = mysqli_fetch_assoc($result))
    	{
            $message = array();
            
            $msg = new Message($row["id"]);
            
            $message["id"]          = $row["id"];
            $message["text"]        = $row["text"];
            $message["author_name"] = $row["full_name"];
            $message["author_id"]   = $row["author_id"];
            $message["tokens"]      = $msg->getUserMessageTokens($this);
            $message["post_time"]   = $row["post_time"];
            $message["opened"]      = ($row["opened"] == "1")? true : false;
            $message["important"]   = ($row["important"] == "1")? true : false;
            
            $message_list[] = $message;

    	}
        
        return $message_list;        
    } 
    

    /**
     * Sends a message to all the users in the specified tokens. 
     * 
     * 1) Filters out the tokens that the user doesn't belong to. If the user 
     *    doesn't belong to any of the tokens specified then throw an exception.
     * 2) Get distinct user IDs belonging to the provided tokens.
     * 3) Create a new message mapped to a location, and this author.
     * 4) Associate the created message to all the distinct users.
     * 5) Associate the created message with all the valid tokens.
     * 
     * 
     * @param type $msg      The message body to be sent.
     * @param type $tokens   An array of token IDs to send the message to.
     * @param type $lon      The longitude of the message geolocation.
     * @param type $lat      The latitude of the message geolocation.
     * 
     * @return type   
     */
    public function sendMessageViaToken($msg, $tokens, $lon = 0, $lat = 0)
    {
        
        //Filter out the tokens to only those that the user belongs to.
        $valid_tokens = $this->filterInvalidTokens($tokens);
        
        //If the user doesn't belong to any of the specified tokens, then 
        //throw an exception.
        if(count($valid_tokens) == 0)
        {
            throw new APIException("User [".$this->getKey()."] does not belong to tokens [".implode(',', $tokens)."]");
        }
        
        //Create a new message, and retrieve its ID.
        $message = Message::createGeoMessage($this, $msg, $lon, $lat);
        $message_id = $message->getKey();
        

        //Initial query that populates the 
        $insert_query = "INSERT INTO user_messages 
                           (users_id, messages_id, opened, deleted, important)
                         
                         SELECT DISTINCT(u.id), $message_id, 1, 0, 0
                         
                         FROM tokens t
                         
                         INNER JOIN tokens_users t_u ON t_u.tokens_id = t.id
                         INNER JOIN users u ON u.id = t_u.users_id 
                         
                         WHERE t_u.active = 1
                         AND t_u.pending <> 1
                         AND t.id IN (".implode(',', $tokens).");";
        
        $result = DB::multi_query($insert_query);
        
        //Second query that creates association between tokens and the 
        //new message.
        $token_messages_query = "INSERT INTO token_messages
                                     (messages_id, token_id)

                                 SELECT $message_id, t.id 

                                 FROM tokens t

                                 WHERE t.id IN (".implode(',', $tokens).");";

        
        $result = DB::multi_query($token_messages_query);
        
        //Mark the author's message as read.
        $message->mark($this, 1, 0, 0);

        return $message->getKey();
      
    }
    
    
    /**
     * Provided an array of token IDs, returns all those token IDs that the
     * current user is associated with. The token_user association has to be 
     * active and not pending in order for it to be valid.
     */
    public function filterInvalidTokens($tokens)
    {
        //Filters the provided tokens to only those 
        //that the user is associated with.
        $valid_tokens_query = "SELECT t_u.tokens_id
                               FROM tokens_users t_u
                               WHERE t_u.users_id = '".$this->getKey()."' 
                               AND t_u.active = 1
                               AND t_u.pending <> 1
                               AND t_u.tokens_id IN (".implode(',', $tokens).")";
        
        $result = DB::query($valid_tokens_query);
        
        $token_list = array();
        
        while($fetched_token_ids = mysqli_fetch_assoc($result))
    	{           
            $token_list[]     = $fetched_token_ids["tokens_id"];
    	}
        
        return $token_list;
    }
    
    /**
     * Returns a list of all the tokens associated with the user. Information
     * such as token ID, token name, and flags active and pending will be 
     * included in the returned data.
     * 
     * @return All token objects associated with the user.
     */
    public function getTokens()
    {
        
        //Query to select all the user's tokens.
        $query = "SELECT t.id, 
                         t_n.name, 
                         t_s.active, 
                         t_s.pending 
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
    
    /**
     * Joins a token that the user was previously invited to.
     * 
     * @param Token $token The token to join.
     * @return type 
     */
    public function joinToken($token)
    {
        
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
                  SET active=1, 
                      pending=0 
                  WHERE tokens_id=".$token->getKey()." AND
                        pending = 1 AND
                        users_id=".$this->getKey();
        
        
        $result = DB::query($query);
        
        return $result;
        
    }
    
    /**
     * If the token doesn't represent an actual token, then this method will
     * throw an exception stating the error.
     * 
     * @param  Token $token The token to ignore.
     * @return boolean True if the token was successfully ignored.
     */
    public function ignoreToken($token)
    {
        
        //If the specified token does not exist, throw an exception.
        if(!$token->exists())
        {
            throw new APIException("Unable to join token. Token [ID: $token_id] does not exist.");
        }
        
        //If the user is not part of the token, then throw an exception.
        if(!$this->isInToken($token))
        {
            throw new APIException("Unable to join token. User [".$this->getKey()."] is not associated to token [ID: $token_id].");
        }
        
        $query = "UPDATE tokens_users 
                  SET active=0, 
                      pending=0 
                  WHERE tokens_id=".$token->getKey()." AND
                        users_id=".$this->getKey();
        
        
       return DB::query($query);
        
       
        
    }
    
    
    /**
     * Creates a new token, associates it with the current user, and returns
     * the token ID.
     * 
     * @param string $new_token_name The name of the token to create.
     * 
     * @return int The primary key of the created token.
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
     *                 false, otherwise.
     */
    public function isInToken($token)
    {
        $query = "SELECT t_s.id
                  FROM tokens_users t_s
                  WHERE t_s.tokens_id='$token->id' AND
                  t_s.users_id = '".$this->getKey()."'";

        $result = DB::query($query);


        return $result->num_rows > 0;
        
    }
    
    public function isInTokens($tokens)
    {
        if(count($tokens) == 0)
        {
            return false;
        }

        $query = "SELECT t_u.tokens_id
                  FROM tokens_users t_u
                  WHERE t_u.users_id = '".$this->getKey()."' 
                  AND t_u.tokens_id IN (".implode(',', $tokens).")";
        

        $result = DB::query($query);

        if($result->num_rows == 0)
        {
            throw new APIException("User[".$this->getKey()."] doesn't belong to Token(s)[".implode(",", $token_ids)."].");
        }    
        
        $token_list = array();
        
        while($fetched_token_ids = mysqli_fetch_assoc($result))
    	{           
            $token_list[]     = $fetched_token_ids["tokens_id"];
    	}
        
        foreach($token_ids as $token_id)
        {
            if(!in_array($token_id, $token_list))
            {
                throw new APIException("User[".$this->getKey()."] doesn't belong to Token[$token_id]. No message sent.");
            }
        }
        
        return $token_list;
        
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
