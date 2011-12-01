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
        

<script type="text/javascript">
        function ChangeSize (){
            var area_size = document.getElementById ("text_area");
            area_size.style.height = "100px";
        }

       
</script>
        
        
    </head>
    
    <body>
        <?PHP include("app_header.php"); ?>
        <div id="bodyContent">
        
        <div align="center" id ="form_div">
        <form class="form-full form-padded">
            <h1>Share New Whoop</h1>
            <label for="audience">Tags:</label>
            <br/>
            <input type="text" name="audience" id="audience" />
            <br/>
            <label for="subject">Subject:</label>
            <br/>
            <br/>
            <input type="text" name="subject" id="subject" />
            <br/>
            <br/>
            <label for="body">Message:</label>
            <br/>
            <textarea id ="text_area"onfocus="ChangeSize(this);"></textarea> 
            <br/>
            <input type="submit" name="submit" value="Whoop It" onclick="">
        </form>
        </div>

        <div>
        <?PHP include("app_footer.php"); ?>
    </body>
    
</html>