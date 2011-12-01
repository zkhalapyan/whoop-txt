<?PHP

require_once (dirname(dirname(__FILE__))."/api/auth/auth.php");
require_once (dirname(dirname(__FILE__))."/api/config/ConfigFactory.class.php");

?>

<!DOCTYPE html>
<html>
   
    <head>
        <title> Welcome to Whoop-Txt </title>
           
        <!-- IMPORT JQUERY LIBRARY HOSTED BY GOOGLE -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
    
        <link rel="stylesheet" href="css/app_styles.css" type="text/css" />    
        <link rel="stylesheet" href="css/fb_styles.css" type="text/css" />    
        
    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        
        <div id="bodyContent">
        <h1> Invitations </h1>
        </div>
        <?PHP include("app_footer.php"); ?>
    </body>
    
</html>