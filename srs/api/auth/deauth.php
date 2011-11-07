<?php

require_once dirname(dirname(__FILE__)).'/config/ConfigFactory.php';
require_once dirname(dirname(__FILE__)).'/lib/Users.class.php';

//Create an application instance.
$facebook = ConfigFactory::get_facebook();

//Get the user ID from the signed request.
$signed_request = $facebook->getSignedRequest();
$user_id = $signed_request['user_id'];

//Set the user to inactive. 
$user = new User($user_id);
$user->active = false;
$user->update();

?>