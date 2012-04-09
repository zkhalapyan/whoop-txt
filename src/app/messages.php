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
        <script type="text/javascript" src="js/CommunicationUtility.js"></script>
        <script language="javascript" type="text/javascript" src="js/actb.js"></script>
        <script language="javascript" type="text/javascript" src="js/common.js"></script>
        <script language="javascript" type="text/javascript" src="js/functions.js"></script>

        <script type="text/javascript">
            
                AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_messages", function (response) {

                        if(response.status != "success")
                        {
                                alert(response);
                        }
                        
                        var messages = response.data.messages;
                        for (index in messages)
                        {
                                
                                addElement("elementList", messages[index]["author_name"], messages[index]["id"], messages[index]["text"]);
                        }
                });
                
                
//                
//        function delete_msg()
//        {
//
//       // var del_url = "http://www.whoop-txt.com/api/mark_message?user_id="+user_id+"&message_id="+msg_id+"&read=true&delete=true";
//        window.alert("This is an anchor test.");
//        }
                
                
        </script>
        
   <!--SAMPLE TO TEXT-->
   
       <script>
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

            actb(document.getElementById('audience'), autoCompleteArray);

            });

        function submitWhoop () {

                var tokenIds = "";
                var tokenNames = document.getElementById('audience').value.split(', ');
                for (var i=0; i<tokenNames.length; i++)
                {
                        for (index in autoCompleteArray)
                        {
                                if(tokenNames[i] == autoCompleteArray[index] || tokenNames[i] == " " + autoCompleteArray[index])
                                {
                                        tokenIds += autoCompleteIds[index] + ",";
                                }
                        }
                }

                if(tokenIds.length > 0)
                {
                        tokenIds = tokenIds.substr(0, tokenIds.length-1);
                }

                var messageBody = document.getElementById('text_area').value;


                mwf.touch.geolocation.getPosition(
                        function(pos){
                                var lat = pos['latitude'];
                                var lon = pos['longitude'];

                                var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_message";
                                url += "&message=" + messageBody;
                                url += "&tokenIds=" + tokenIds;
                                url += "&lon=" + lon;
                                url += "&lat=" + lat;

                                AJAXRequest(url, function (response) {
                                        alert(JSON.stringify(response));
                                });
                        }, 
                        function(err){ alert("Err:"+err); }
                );

    }
    
 
    </script>

    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        
        <div id="bodyContent">
            <h1> Messages </h1>
             
            <table>
                <tbody>
                    <tr >
                        <td id ="tbl_msg">
                             
                                <textarea id ="text_area"onfocus="ChangeSize(this);" off></textarea>
                                
                        </td>
                    </tr>
                    <tr>
                        <td id ="tbl_tags">
                            
                                <input type="text" name="name_tag" id ="audience"/>
                            
                        </td>
                    </tr>
                    <tr>
                        <td id ="tbl_buttons">
                           
                            <input type="submit" name="submit"  onclick="submitWhoop()" id ="whoop_butn"/>
                                <input type="button" name="tag_button" onclick="show_tags()" id ="tag_butn"/>
                                
                            
                        </td>
                    </tr>
                </tbody>
            </table>

            <br/><br/> 
            <ul id="elementList">
                <li>                 
                    <img id="profile_pic" src="http://demo.tutorialzine.com/2009/09/making-our-own-twitter-timeline/img/avatar.jpg" width="48" height="48" alt="profile_pic" />
                    <div id="msg_txt">
                        <div id="user_name">Anthony Balmeo</div>
                        Check out this new layout, its pretty awesome!
                    </div>
                    <div id ="edit_menu" >
                         <a href="javascript:reply_msg()">Reply</a>
                         <a href="javascript:share_msg()">Share</a>
                         <a href="javascript:delete_msg()">Delete</a>
                    </div>
                    <div id="clear"></div>                      
                </li>  
            </ul>

        <br/>
        <br/>
        <br/>
        
        <?PHP include("app_footer.php"); ?> 
        </div>      

    </body>
    
</html>