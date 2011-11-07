<?php

require_once dirname(dirname(__FILE__)).'/config/ConfigFactory.php';

if(!ConfigFactory::get_facebook()->getUser())
	header("location:auth.php");
	
?>