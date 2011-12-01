<?php 
	
	$app_name = "Whoop-Txt";

?>
<!DOCTYPE html>
<html>
<head>

<link rel="StyleSheet" href="css/fb_styles.css" type="text/css" media="screen"/>
<link rel="StyleSheet" href="css/app_styles.css" type="text/css" media="screen"/>
<title>Report Application - <?=$app_name ?></title>

</head>

<body>
<?PHP  include("app_header.php"); ?>
    
    <div id="bodyContent">

        <h1 class="policy_header">Feedback/Contact Us</h1>
        <p class = "policy_text">NOTE: This is not the official "report" page of Facebook!
            You are reporting an application that is in violation of 
            the <a href="http://www.facebook.com/terms.php" target="blank" class="fb_link"> 
            Statement of Rights and Responsibilities</a>. Developers will 
            accept your report and work on it at once.</p>
                                         
         <p class = "policy_text"><b>Description & Steps to Reproduce:</b>
            <span style="color:darkred">Include step-by-step instructions to reach content and sample user IDs where applicable.</span></p>  
         
         <table>     

                                <td style="width:400px">
                                        <textarea name="msg" style="width:150%;height:150px;"></textarea>
                                </td>

                        </tr>
                        <tr>
                                <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>

                                <td colspan="2" align="center" style="text-align:right">
                                        <a class="uiButton uiButtonConfirm" rel="nofollow"  href="">
                                                <span class="uiButtonText">Report Application</span>
                                        </a>

                                        <a class="uiButton uiButtonConfirm" rel="nofollow"  href="../index.php">
                                                <span class="uiButtonText">Cancel</span>
                                        </a>
                                </td>

                        </tr>
                </table>
        </form>
        <?PHP include("app_footer.php"); ?>
    </div>
</body>

</html>

