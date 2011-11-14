<?php

require_once (dirname(dirname(__FILE__))."/config/ConfigFactory.class.php");
require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');
require_once(dirname(__FILE__).'/APIException.class.php');
require_once(dirname(__FILE__).'/User.class.php');


class Token extends ActiveRecord
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('tokens', $key, $col);
    }
    
    
    public function inviteUsers($user_ids)
    {
        
        //If the user is not a valid Facebook user, throw an exception.
        //On the other hand if the user is a valid Facebook user, but doesn't
        //have a record within the whoop-txt API, create a record and use it.
        //Note that the created user will be inactive.
        foreach($user_ids as $user_id)
        {   
            $user = new User($user_id);
            
            if(!$user->exists())
            {
                $profile = $user->getProfile();
                
                if(!$profile)
                {
                    throw new APIException("User [$user_id] is not a valid Facebook user. No invites sent.");
                }
                
                //Save the user's information.
                $user->id        = $user_id;
                $user->full_name = $profile["name"]; 
                $user->gender    = $profile["gender"];
                $user->locale    = $profile["locale"];
                $user->email     = "";
                $user->active    = false;

                //Save date and time realted field information.
                $user->create_time  = date('Y-m-d H:i:s');
                $user->access_time  = date('Y-m-d H:i:s');

                //Set the number 
                $user->friends_count =  0;

                //Save an empty access token.
                $user->access_token = "";
                
                $user->add();
                
            }
            
            if(!$user->isInToken($this))
            {
                $tokenUser = new TokenUser();
                
                $tokenUser->users_id = $user_id;
                $tokenUser->tokens_id = $this->getKey();
                
                $tokenUser->active = 0;
                $tokenUser->pending = 1;
                
                $tokenUser->add();
            }
               
        }
      
    }
  

}

?>
