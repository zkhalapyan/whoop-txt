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
        
        <link rel="stylesheet" href="css/fb_styles.css" type="text/css" />  
        <link rel="stylesheet" href="css/app_styles.css" type="text/css" />   
          
        
        
    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        
        
        <div id="bodyContent">
            <h1 class="policy_header">  Whoop-Txt Help </h1>
            
            <span class="policy_title"> What is Whoop-Txt?</span>
            <p class = "policy_text">
            Whoop-Txt is a geo-aware mobile web application which allows you to send, "Whoop", messages
            to others in your vicinity. Send, share, and reply your newsworthy Whoops to people
            around you at the ease of a text. Whoop-Txt also allows you to create and join custom groups
            so that you can relay your messages to your friends of your choice. Whoop-Txt is 
            viral texting with friends and strangers (a.k.a. friends you haven't met).
            </p>
            <br/>

            <a name ="Menu Bar"></a>
            <span class="policy_title">Menu</span>
            <p class = "policy_text">The Menu bar contains the pages you can navigate to on the Whoop-Txt application. The pages include
            Messages, Groups, and Help. When you are navigating through the site, the menu bar will be located 
            on the top of the screen. </p>
            
           

            <a name ="Messages"></a>
            <span class="policy_title">Messages</span>
            <p class = "policy_text">The Messages page is the home-page of Whoop-Txt. This page includes all of the messages you have received from other Whoop
            members. </p>
            
            <p class = "policy_text">When clicking on a message, you can choose to Reply back to the message or Re-Share to other people in your
            group, your friends, or people in your vicinity.</p>
            
            <p class = "policy_text">This page also allows you to create your own messages that you want to share. There are two entry fields
            to create your message: <b>Tags</b> and <b>Message</b>.</p>
            
            <p class = "policy_text">Under <b>Tags</b>, a user chooses who to send messages to such as groups, friends, or people in your vicinity. Then the user writes their personal message they want to share under the <b>Message</b> field.
            After the user completes filling out the form, they proceed by
            hitting the Whoop button. Their message is then sent out to the people whom they tagged.</p>
            
            <p class = "policy_text">To return back to the Messages page after navigating to another
            page, simply click on the Whoop-Txt logo on the Menu bar as follows:</p>
            
            <img src="img/help-img.jpg" width="400"/>
            
            <br/>

            <a name ="Groups"></a>
            <span class="policy_title">Groups</span>
            <p class = "policy_text">The Groups page consists of two sections. The first section lists pending
                invites to other groups. The user has the option to either accept or ignore the invite request.
                </p>
           
            <p class = "policy_text">In addition, the Groups page allows you to view all the groups you are a part of. When you access one of the groups created, you can choose
            to invite others to the group or leave the group yourself. </p>
            
            <p class = "policy_text">The second section allows the user to create a new custom group.
                To do this, click on the "Create New Group" button. When clicked, the user can enter a group name. Once
                submitted, the new group will then be added to the user's group list.</p>
            
                
            <a name ="Reporting Application Issues"></a>
            <span class="policy_title">Reporting Application Issues</span>
            <p class = "policy_text">Whoop-Txt is a new application and is not perfected. If you have any
                questions or issues regarding the application, report them to the developers by going to
                <a href="report_app.php">Report/Contact this Application</a>. The developers will be happy to 
                assist you.
                </p>
                

            <?PHP include("app_footer.php"); ?>
        </div>
   
        
    </body>
    
</html>