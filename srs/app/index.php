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
        
        <script type="text/javascript">

/*
            var request_say_hello = $.ajax({
              url: "https://rocking-apps.com/whooptxt/api/api.php",
              type: "GET",
              data: {   
                        action   : "say_hello"
                    },
              dataType: "json"
            });

            request_say_hello.done(function(msg) {
              console.log(msg);
            });

            request_say_hello.fail(function(jqXHR, textStatus) {
              console.log(textStatus);
            });
            
            var request_create_token = $.ajax({

              url: "https://rocking-apps.com/whooptxt/api/api.php",
              type: "GET",
              data: {   
                        action   : "create_token",
                        name     : "unique_token_name"
                    },

              dataType: "json"
            });

            request_create_token.done(function(msg) {
              alert(msg);
              console.log(msg);
            });

            request_create_token.fail(function(jqXHR, textStatus) {
              console.log(jqXHR);
            });

*/
        </script>
        
    <link rel="stylesheet" href="css/app_styles.css" type="text/css" />    
    <link rel="stylesheet" href="css/fb_styles.css" type="text/css" />    
    
    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        
        <div id="bodyContent">
        <h1> Messages </h1>
        </div>
        
        <?PHP include("app_footer.php"); ?>
    </body>
    
</html>