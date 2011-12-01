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
            <h1> Help </h1>
            
            <h2 >What is Whoop-Txt?</h2>
            <br/>
            <p>
            Whoop-Txt is a geo-aware mobile web application which allows you to send, "Whoop", messages
            to others in your vicinity. Send, share, and reply your newsworthy Whoops to people
            around you at the ease of a text. Whoop-Txt also allows you to create and join custom groups
            so that you can relay your messages to your friends of your choice. Whoop-Txt is 
            viral texting with friends and strangers (a.k.a. friends you haven't met).
            </p>
            <br/>

            <h2>Navigating through Whoop-Txt</h2>
            <br/>

            <p>Listed below are the different pages that you can navigate to on Whoop-Txt.</p>

                    <li><a href="#Menu">Menu</a></li>
                    <li><a href="#WhoopIt">Whoop It</a></li>
                    <li><a href="#Messages">Messages</a></li>
                    <li><a href="#Groups">Groups</a></li>
                    <li><a href="#Invitations">Invitation</a></li>
            <br/>

            <a name ="Menu"></a>
            <h3>Menu</h3>
            <p>The Menu page contains the core of the pages you can navigate to on the application. The pages include
            Whoop it, Messages, Groups, and Invitations. When you are navigating through the site, there will be a menu button 
            on the upper-right corner of the screen to allow you to navigate back to the menu screen.</p>

            <a name ="WhoopIt"></a>
            <h3>Whoop It</h3>
            <p>The Whoop It page allows you to create your own messages that you want to share. There are three entry fields
            to create your message: Tags, Subject, and Message.</p>
            <ul>
                    <li><h4>Tags</h4></li>
                    User chooses who to send messages to such as groups, friends, or people in your vicinity.
                    <li><h4>Subject</h4></li>
                    User can create a subject for the message.
                    <li><h4>Message</h4></li>
                    User writes their personal message they want to share in this field.
            </ul>
            <p> After the user completes filling out the form, they proceed by
            hitting the Whoop It!. Their message is then sent out to the people whom they tagged.</p>
            </br>

            <a name ="Messages"></a>
            <h3>Messages</h3>
            <p>The Messages page is the homepage of Whoop-Txt. This page includes all of the messages you have recieved from other Whoop
            members. When clicking on a message, you can choose to Reply back to the message or Re-Share to other people in your
            group, your friends, or people in your vicinity. There is a back navigation link included to take you back to the message
            page.</p>
            <br/>

            <a name ="Groups"></a>
            <h3>Groups</h3>
            <p>The Groups page allows you to view all the groups you are a part of. When you access one of the groups created, you can choose
            to invite others to the group or leave the group yourself. Whoop-Txt also allows you to make new custom groups.</p>
            <br/>

            <a name ="Invitations"></a>
            <h3>Invitations</h3>
            <pr>The Invitations page shows you all the pending invites of who wants to add you to their group. When you select a group, you can decice
            to accept or ignore the invite request.</p>

        </div>
   
        <?PHP include("app_footer.php"); ?>
    </body>
    
</html>