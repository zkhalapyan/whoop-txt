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
    <link rel="stylesheet" href="css/menu.css" type="text/css" />   
    <link rel="stylesheet" href="css/fb_styles.css" type="text/css" />    
    <script type="text/javascript" src="js/CommunicationUtility.js"></script>
    <script language="javascript" type="text/javascript" src="js/actb.js"></script>
    <script language="javascript" type="text/javascript" src="js/common.js"></script>
    <script language="javascript" type="text/javascript" src="js/functions.js"></script>
    <script language="javascript" type="text/javascript" src="js/geoloc.js"></script>
    <script type="text/javascript" src="js/popup.js"></script>


    <script type="text/javascript" src="js/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="css/token-input.css" type="text/css" />
    <link rel="stylesheet" href="css/token-input-facebook.css" type="text/css" />
    


        
        
    <script type="text/javascript">
    /*GET MESSAGE AJAX REQUEST*/
    
          var url_vars = getUrlVars();
                 
          var lat = url_vars["lat"];
          var lon = url_vars["lon"];
         
          var url = "https://rocking-apps.com/whooptxt/api/api.php?action=get_geomessages&lat="+lat+"&lon="+lon; 
          
           
         AJAXRequest(url, function (response) {

                if(response.status != "success")
                {
                        alert("Server Error!");
                }

                var messages = response.data;

                for (index in messages)
                {
                    var names_array = new Array();
                    var token_id_array = new Array();

                    for(index2 in messages[index]["tokens"])
                        {
                            token_id_array.push(messages[index]["tokens"][index2]["id"]);
                            names_array.push( messages[index]["tokens"][index2]["name"]  );
                        }

                    addElement("elementList",messages[index]["id"], messages[index]["author_name"], messages[index]["author_id"], messages[index]["text"], token_id_array,names_array, messages[index]["post_time"]);
                }
        }); 



        /*GET TOKENS FOR AUTOCOMPLETE AJAX REQUEST*/
        var autoCompleteArray = new Array();
        var autoCompleteIds = new Array();

        AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_tokens", function (response) {

            if(response.status != "success")
            {
                    alert("Connection to server failed!");
                    return;
            }

            var tokens = response.data.tokens;
            for (index in tokens)
            {
                    if(tokens[index].pending === false && tokens[index].active === true)
                    {
                            autoCompleteArray.push(tokens[index].name);
                            autoCompleteIds.push(tokens[index].id);
                    }
            }

        });

        /*SUBMIT MESSAGE AJAX REQUEST*/
        function submitfunc(url){
          AJAXRequest(url, function (response) {
                  if(response.status == "success"){
                        window.location= "geo_messages.php?lat="+lat+"&lon="+lon;
                    }
                    else{
                        //alert("Error connecting to server!");
                    }
            });
        }



    </script>
    
    <script type="text/javascript">

        $(document).ready(function() {
            

          var url = "https://rocking-apps.com/whooptxt/api/api.php?action=get_tokens";

          AJAXRequest(url, function (response) {

                if(response.status != "success") {
                    alert("Connection to server failed!");
                    return;       
                }

                var tokens = response.data.tokens;

                //Create a new array to store the token objects that will
                //contain the token's ID and Name values.
                var tokens_array = new Array();

                //Iterate through each received token.
                for (var index in tokens)
                {     
                    //A new JavaScript object that will contain the name and
                    //the ID of the token to be pushed to the tokens array.
                    var token = new Object();
                    
                    // Checks to see if user is in the token
                    if(tokens[index].pending === false && tokens[index].active === true)
                    {                    
                        //Store the token's ID and the token's name within 
                        //ojbect variables of the created token.
                        token.id   = tokens[index]["id"];
                        token.name = tokens[index]["name"];

                        //Push this object into array of the rest of tokens.
                        tokens_array.push(token);
                    }
                } 

                //Now populate the autocomplete box.
                $("#demo-input-facebook-theme").tokenInput(tokens_array,{theme: "facebook"});                    
                
          });


        });
    </script>
   </head>
    
   <body>
        <?PHP include("app_header.php"); ?>

        <!-- CONTENT IN THE BODY , MESSAGES, COMMENT BOX-->
        <div id="bodyContent">
            
            <h1 id ="msgPage1"> Messages Nearby </h1>
            

            <!--COMMENT BOX IN A TABLE-->
            <table>
                <tbody>
                    <tr>
                        <td id ="tbl_tags">
                            <img id ="tag_img" alt="" src="img/tag_button.png" onmouseover="popup('Include the groups you wish to send a messaage to.')"/>
                            <input type="text" id="demo-input-facebook-theme"/>
                        </td>
                    </tr>
                    <tr >
                        <td id ="tbl_msg">
                             <img id ="msg_img" alt="" src="img/msg_icon.png" onmouseover="popup('Write the message to the associated groups you want to send to.')"/>
                            <textarea id ="text_area"onfocus="ChangeSize(this);" off></textarea>    
                            <img src="img/new_whoop_button.png" onclick="submitWhoop()" id ="whoop_butn"/>  
                        </td>
                    </tr>
                    <tr>

                    </tr>
                </tbody>
            </table>
            
            <br/><br/> 
            
            
            <!--SHOW MESSAGE LIST-->
            <ul id="elementList"></ul>

            <br/>
            <br/>
            <br/>
        
        <!--SHOW FOOTER LIST-->
        <?PHP include("app_footer.php"); ?> 
        </div>      

    </body>
    
</html>