<?php 

$app_name = "Whoop-Txt";

?>

<!DOCTYPE html>

<html>

<head>

<link rel="StyleSheet" href="css/fb_styles.css" type="text/css" media="screen"/>
<link rel="StyleSheet" href="css/app_styles.css" type="text/css" media="screen"/>
<title><?=$app_name?> - Privacy Policy</title>

</head>


<body>
    <?PHP  include("app_header.php"); ?>
    
    <div id="bodyContent">
        
        <h1 class="policy_header"> User Rights and Responsibilities</h1>
        <br/>
	
	<span class="policy_title">1. Privacy Policy</span>
	
	<p class = "policy_text">Your privacy is important to us. We maintain strict policies to ensure the privacy and security of your personal 
	   information that we may collect through your use of <?=$app_name?>. We do not collect or ask for any data
	   /info from you, except for the information we need to provide accurate performance of our application. This 
	   information is collected solely to facilitate and improve <?=$app_name?>, and will never be released to another
	   user, individual, entity or the public. By using <?=$app_name?> you consent to the collection and use of 
	   your personal information as outlined in this privacy policy.</p>
	   
	
	<span class="policy_title">2. Information Collection and Use</span>
	
	<p class = "policy_text">We do not collect or have access to Facebook usernames and passwords. However, we have to store the Facebook user id 
	   (which is numerical) to associate your Facebook profile with relevant information used to create a photomontage. We 
	   collect email addresses only if and when you explicitly give us your email address for getting updates from us. We 
	   may use your email address to notify you of new updates, apps, service notifications, and to solicit your feedback and
	   input. The emails will contain an 'unsubscribe' link if you ever wish that you do not want to receive further emails.</p>
	
	<p class = "policy_text">In addition to this data, you may choose to share information about yourself in results (photomontages) which you may 
	   choose to post to your profile/feed/wall. Any action you perform by posting to your wall/feed/profile are considered 
	   public, and at your own discretion.</p>
	
	<p class = "policy_text">Any images that are edited in <?=$app_name?> are uploaded on our servers temporarily to create a photomontage. These images 
	   remain private to you only and are not available publicly until you post them to your Facebook wall/profile/feed. If you 
	   post photo results in your album or wall, the photos will be visible only to your Facebook friends.</p>
	
	<p class = "policy_text">Any content you send or otherwise make available yourself through use of <?=$app_name?>, including but not limited to, posting
	   photo results on your friends' wall, is done so at your own risk. We cannot control the actions of other users with whom 
	   you may chose to share any information. Please use discretion when posting any personal information. Make sure that it is
	   accurate and not intended to embarrass, or to wrongly harm anyone's reputation.</p>
	
	<p class = "policy_text">If you no longer desire to use <?=$app_name?> as a User, you may remove the application from your Facebook account. 
	   Once you have removed it, all personal information given to us is deleted. However, any content created by you 
	   (photomontages you saved in your albums or posted on your friends' walls) is not deleted automatically.</p>
	
	<span class="policy_title">3. Advertisements</span>
	
	<p class = "policy_text"><?=$app_name?> seeks to deliver advertisements valuable to the user. A user's personal information will not be shared with advertisers without the user's consent. </p>
        
        <span class="policy_title">4. Use by Children</span>
	
	<p class = "policy_text">Some templates provided by <?=$app_name?> contain adult content. Although you can leave them out by unchecking this 
	   type of effects, the application is not recommended for use by children under the age of 13 without parental control.</p>
        <br/>
        <hr/>
	<p class = "policy_footer">We reserve the right to change this Privacy Policy and any other application guidelines at any time, so check back this 
	   privacy policy periodically for changes.<p class = "policy_text">
	
	<p class = "policy_footer">If you have any questions after reading this Privacy Policy, don't hesitate to contact our support group.</p>
	
	<hr>
        <?PHP include("app_footer.php"); ?>
	
	</div>

</body>

</html>
