<?php

error_reporting(E_ALL);
ini_set('display_errors','On');


require_once dirname(dirname(__FILE__)).'/config/ConfigFactory.class.php';
require_once dirname(dirname(__FILE__)).'/lib/User.class.php';


//Create an application instance. This allows us to interact with Facebook SDK.
$facebook = ConfigFactory::get_facebook();

//Get User ID.
$user_id = $facebook->getUser();

// If the user is not connected, then forward him to the login page.
if (!$user_id) 
{
  	
    //Constuct the application login URL.
    $login_url = $facebook->getLoginUrl(array("scope"        => ConfigFactory::get("app_scope"), 
                                              "redirect_uri" => ConfigFactory::get("app_url") ));

    
    //Redirct the user to the application login URL.
    echo ("<script type='text/javascript'>top.location='$login_url'</script>");

    //Quit loading the rest of the page. Apprently, this is the same as exit.
    die();
  
} 

//If the user is already connected, then continue processing his record.
else 
{
 
  
 //Get the access token from the user.
 $access_token = $facebook->getAccessToken(true);

 //Create a new user with the current user's ID.
 $user = new User($user_id);
 
 //Get user's profile information i.e. name, gender. 
 $user_profile = $facebook->api('/me');

 //Check if the current user's information has already been stored.
 //If the user is new, store his information and create a new record. Otherwise,
 //if the user exists but previously uninstalled the application, then update 
 //the information.
 if(!$user->exists() || !$user->active)
 {
 	
	//Gather user information.
	$user_id       = $user_profile["id"];
	$user_name     = $user_profile["name"]; 
	$user_gender   = $user_profile["gender"];
	$user_locale   = $user_profile["locale"];
	
	//Depending on the scope of the permission, email might not be available.
	$user_email    = (isset($user_profile["email"]))? $user_profile["email"]:"";
	
	//Count the user's number of friends. This is not creepy at all.
	$user_friends_list = $facebook->api("/me/friends");
	$friends_count = count($user_friends_list["data"]); 
 	
 	//Save the user's information.
 	$user->id        = $user_id;
 	$user->full_name = $user_name; 
 	$user->gender    = $user_gender;
 	$user->locale    = $user_locale;
 	$user->email     = $user_email;
 	$user->active    = true;
 	
 	//Save date and time realted field information.
 	$user->create_time  = date('Y-m-d H:i:s');
 	$user->access_time  = date('Y-m-d H:i:s');
 	
 	//Save the number of friends the user has.
 	$user->friends_count =  $friends_count;
	
 	//Save the user's access token.
 	$user->access_token = $access_token;
 	
 	//If the user doesn't exist, create a new user. Otherwise, update his
 	//information.
 	if(!$user->exists())
 	{
 		$user->create();
 	}
 	else
 	{
 		$user->update();
 	}
 	
 }
 
 //Update the returning user's record.
 else
 {
 	//If the user already exists, update the user's access_token.
 	$user->access_token = $access_token;
 	
 	//Update the user's acccess time. Although the data field will update the 
 	//timestamp on update, in case the access_token is the same, then update
 	//time will not change. Hence, the access_time should be set manually.
 	$user->access_time = date('Y-m-d H:i:s');
 	
 	//Update the user.
 	$user->update(true);
 	

 }
 
}

