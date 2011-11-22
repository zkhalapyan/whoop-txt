<?php

require_once(dirname(__FILE__).'/db/DB.class.php');
require_once(dirname(__FILE__).'/db/ActiveRecord.class.php');

class TokenName extends ActiveRecord 
{
    public function __construct($key = null, $col = 'id')
    {
        parent::__construct('token_names', $key, $col);
    }
    
    /**
     * The function will either retrieve an existing token name object with the
     * specified name or create a new token name with the specified name and 
     * return it. This approach of creating token names will avoid adding 
     * duplicate recrods.
     * 
     * @return TokenName A token name object with the specified token name.
     */
    public static function getTokenByName($name)
    {
        
        //Sanitize the token name.
        $name = DB::mysqli()->real_escape_string($name);
        
        $token_name = new TokenName();
        
        //Try to retrieve a token with the given name. If a token with the 
        //specified token name doesn't exist, fetch_id will return false.
        $token_name_id = $token_name->fetch_id("name", $name);
        
        //If the token with the specified name does not exist, then go ahead
        //and create it. Remember that PHP will treat 0 as false, so if the 
        //if the primary key is actually true, this if block will be executed
        //and throw a MySQL error -> to avoid this, use triple equals ===.
        if($token_name_id === false)
        {
            $token_name->name = $name;
            $token_name_id  = $token_name->create();
        }
        
        
        $produced_token_name = new TokenName($token_name_id);
        $produced_token_name->read();
        
        return $produced_token_name;
        
    }
}

?>
