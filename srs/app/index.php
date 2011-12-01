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
          //alert(url_vars["token_id"]);

          var url = "https://rocking-apps.com/whooptxt/api/api.php?action=get_messages";
          var url2 = "https://rocking-apps.com/whooptxt/api/api.php?action=get_messages&token_id="+url_vars["token_id"];
          
        if(url_vars["token_id"]==undefined)
        {                 
            AJAXRequest(url, function (response) {

                    if(response.status != "success")
                    {
                            alert("brokenshit");
                    }

                    var messages = response.data.messages;

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
        }
        else{
             AJAXRequest(url2, function (response) {

                    if(response.status != "success")
                    {
                            alert("brokenshit");
                    }

                    var messages = response.data.messages;

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
        }


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
                        window.location = "index.php";
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
<!--        <div id="messages_logo">
            <img src="images/header_messages.png"/>
        </div>  
        <div id="header_bars">
            <img src="images/header_bars.png"/>
        </div>  -->
            <h1> Messages </h1>
            

  

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
<!--                        <td id ="tbl_buttons">     
                            <input type="button"  onclick="submitWhoop()" id ="whoop_butn"/>
                                                                        
                        </td>-->
                    </tr>
                </tbody>
            </table>
            
            <br/><br/> 
            
            
            <!--SHOW MESSAGE LIST-->
            <ul id="elementList">
                
               <li>
                    <div id ="groups_assoc">
                        <ul id="group_list">
                            <li>
                                <a href="#" onmouseover="mopen('m1');popup('The groups associated with this message are listed here.')" onmouseout="mclosetime()">
                                    <img src = "img/group_side.png"/>
                                </a>
                                <div id="m1" onmouseover="mcancelclosetime();popup('Clicking on any of the groups here will redirect you to the messages associated with this group.')" onmouseout="mclosetime()">
                                    <a href="javascript:group_sample()">Group1</a>
                                    <a href="javascript:group_sample()">Group2</a>
                                    <a href="javascript:group_sample()">Group3</a>
                                    
                                </div>
                            </li>
                          
                        </ul>
                        <div style="clear:both"></div>    
                    </div>
                   
                        <a href ="#" onmouseover="popup('Clicking on the profile picture of this user will redirect you to their Facebook profile.')"> 
                            <img id="profile_pic" src="img/avatar.jpg" width="48" height="48" alt="profile_pic" />
                        </a>
                       <div id="msg_txt">
                        <div id="user_name" onmouseover="popup('Clicking on the user name will redirect you to their Facebook profile.')">Whoop-Txt</div>
                        Welcome to Whoop-Txt. Share your messages and view them here! Highlight over the links for a brief description of how things work!                   
                        <div id ="rsd" >
                            <ul>
                                <li><a onmouseover="popup('Reply will allow you to reply to the group the message originated from.')" href="#">Reply</a></li>
                                <li><a onmouseover="popup('Share will allow you to re-share this message to other groups.')" href="#">Share</a></li>
                                <li><a onmouseover="popup('Delete will delete the message from your message stream.')" href="#">Delete</a></li>
                             </ul>
                        </div>                                               
                    </div>
                    
                    <div id="clear"></div>                      
                </li>  
            </ul>

            <br/>
            <br/>
            <br/>
        
        <!--SHOW FOOTER LIST-->
        <?PHP include("app_footer.php"); ?> 
        </div>      

    </body>
    
</html>