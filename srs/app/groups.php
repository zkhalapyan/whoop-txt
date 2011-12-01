<?PHP

require_once (dirname(dirname(__FILE__))."/api/auth/auth.php");
require_once (dirname(dirname(__FILE__))."/api/config/ConfigFactory.class.php");

?>

<!DOCTYPE html>
<html>
   
    <head>
        
        <title>Whoop-Txt Groups View </title>
           
        <!-- IMPORT JQUERY LIBRARY HOSTED BY GOOGLE -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
        
        <link rel="stylesheet" href="css/app_styles.css" type="text/css" />   
        <link rel="stylesheet" href="css/fb_styles.css" type="text/css" />    
        <script type="text/javascript" src="js/jquery.tokeninput.js"></script>
        <link rel="stylesheet" href="css/token-input-facebook-groups.css" type="text/css" />
        <script type="text/javascript" src="js/CommunicationUtility.js"></script>
        
        <script language="javascript" type="text/javascript" src="js/actb.js"></script>
        <script language="javascript" type="text/javascript" src="js/common.js"></script>
        <script language="javascript" type="text/javascript" src="js/invitations.js"></script>
        <link rel="stylesheet" href="css/menu_group.css" type="text/css" />
        <script type="text/javascript" src="js/popup.js"></script>
        
        <script type="text/javascript">
        
        AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_tokens", function (response) 
        {
            if(response.status != "success")
            {
                alert("Connection to server failed!");
                return;
            }
            var token = response.data.tokens;
            var counter = 0;
            var counter2 = 0;
            
            for (index in token)
            {
                if(token[index].active && token[index].pending)
                {
                   counter++;
                   addElement("elementList", token[index]["name"], token[index]["id"]);
                }
                else if (token[index].active)
                {
                    counter2++;
                    var token_name = stripslashes(token[index]["name"]);
                    
                    addElement2("elementList2", token_name, token[index]["id"]);    
                }
            } 
            if (counter == 0){
                $('#elementList').append('You have no pending invites.');
            }
            if (counter2 == 0){
                $('#elementList2').append('You are part of no groups.');
            }
        });
        
          function loadGroupForm()
            {
                var form = '<form name="createGroupForm" > '
                + ' <label for="group">Group Name</label> '
                + ' <input type="text" name="group" id="group" /> '
                + '<div>'
                + ' <img src="img/create.png" id="createStyle" onclick="submitGroup();">'
                + ' <img src="img/cancel.png" id ="cancelStyle1" onclick="redirectSelf();">'
                + '</div>'
                + '</form>';
                $('#newgroup').html(form);
            };
        </script>

    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        
        <div id="bodyContent">

            <h1>Invitations</h1>
            <ul id="elementList"></ul>
                
            <h1> Groups </h1>
            <img src="img/create_new_group.png" id ="group_butn" onclick="loadGroupForm();"/><br/>
            <div id="newgroup"></div>
            
            <br><ul id="elementList2"></ul><br/>
            
           
         <?PHP include("app_footer.php"); ?>
        </div>

    </body>
    
</html>