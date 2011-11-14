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
  console.log(msg);
});

request_create_token.fail(function(jqXHR, textStatus) {
  console.log(textStatus);
});


        </script>
        
    <link rel="stylesheet" href="whoopStyles.css" type="text/css" />    
    </head>
    
    <body>
        <h1> Groups </h1>
        
        
<ul id="menu">
       <li><a href="index.php" target="_self">Messages</a></li>
       <li><a href="messages.php" target="_self">Whoop It</a></li>
       <li><a href="groups.php" target="_self">Groups</a></li>
       <li><a href="invitations.php" target="_self">Invitations</a></li>
       <li><a href="help.php" target="_self">Help</a></li>
</ul>
        
    </body>
    
</html>