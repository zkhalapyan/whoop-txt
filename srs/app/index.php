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
        
        <script>
            
            
            var request = $.ajax({
              url: "https://rocking-apps.com/whooptxt/api/api.php",
              type: "GET",
              data: {   
                        action   : "say_hello"
                    },
              dataType: "json"
            });

            request.done(function(msg) {
              console.log(msg);
            });

            request.fail(function(jqXHR, textStatus) {
              console.log(textStatus);
            });
            
            submitWhoop();
            
            
        </script>
        
    </head>
    
    <body>
        
    </body>
    
</html>