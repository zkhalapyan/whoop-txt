<?php

require_once(dirname(__FILE__).'/db/DB.class.php');
require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

require_once(dirname(__FILE__).'/APIException.class.php');


class Message extends ActiveRecord 
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('messages', $key, $col);
    }
    
    
    /**
     * Returns an array of token IDs and names associated with this message.
     * 
     * @return Token IDs and names associated with this message.
     */
    public function getTokens()
    {
        
        $query = "SELECT t.id, t_n.name
                  FROM token_messages t_m 
                  INNER JOIN tokens t ON t.id = t_m.token_id
                  INNER JOIN token_names t_n ON t_n.id = t.token_names_id
                  WHERE t_m.messages_id = ".$this->getKey();
        
        $result = DB::mysqli()->query($query);

        if ($result === false)
        {
            throw new ARException('MySQL Error: '.DB::mysqli()->error);
        }
        
        $tokens = array();
        
        //Read the result row by row.
        while($row = mysqli_fetch_assoc($result))
    	{
            $token = array();
            
            $token["id"]      = $row["id"];
            $token["name"]    = $row["name"];
            
            $tokens[] = $token;

    	}
        
        return $tokens;
        
    }
    
    
    /**
     * Marks the message as opened, deleted, or important.
     * 
     * @param integer $opened Indicates the the user has opened the message.
     * @param integer $deleted Indicates if the user has deleted a message.
     * @param integer $important Indicates if a message is important to the user.
     * 
     * @return boolean True, if the message was marked successfully. 
     * 
     * @precondition This message exists.
     */
    public function mark($user, $opened = 1, $deleted = 0, $important = 0)
    {
        
        //Sanitize the body of the message.
        $opened    = DB::mysqli()->real_escape_string($opened);
        $deleted   = DB::mysqli()->real_escape_string($deleted);
        $important = DB::mysqli()->real_escape_string($important);
        
        $query = "UPDATE user_messages 
        
                  SET opened    = $opened, 
                      deleted   = $deleted, 
                      important = $important 
        
                  WHERE users_id    = '".$user->getKey()."' 
                    AND messages_id = '".$this->getKey()."'";
        
        DB::query($query);
        
        //If the update query matched any records, then the user was not associated
        //with the given message ID.
        if(DB::matched_rows() == 0)
        {
            throw new APIException("User [".$user->getKey()."] is not associated with message [".$this->getKey()."].");
        }    
        
        return true;
    }
    
    
    /**
     * Creates a message and associates it with the provided geolocation.
     * If longitude and latitude are both 0s, then no location will be 
     * associated with the message.
     * 
     * All user inputs will be sanitized prior to Database query.
     * 
     * @param User The author of the message.
     * @param type $body The body of the message.
     * @param float $lon The longitude of the message's location.
     * @param float $lat The latitude of the message's location.
     * 
     * @return Message Created message.
     */
    public static function createGeoMessage($author, $body, $lon, $lat)
    {
    
        //Sanitize the body of the message.
        $body = DB::mysqli()->real_escape_string($body);
        
    	//Create new Message    
    	$message = new Message();
    	$message->author_id = $author->getKey();
    	$message->text = $body;
    	$message->post_time = date('Y-m-d H:i:s');
    	$message->add();
    	
        if($lon != 0 && $lat != 0)
        {
            //Sanitize the provided location.
            $lon = DB::mysqli()->real_escape_string($lon);
            $lat = DB::mysqli()->real_escape_string($lat);
            
            //Create new Location
            $location = new Location();
            $location->longitude = $lon;
            $location->latitude = $lat;
            $location->add();

            //Create new message Location associated to the location
            $message_location = new MessageLocation();
            $message_location->location_id = $location->getKey();
            $message_location->messages_id = $message->getKey();
            $message_location->add();
        }

        
        return $message;
    }
    
}

?>
