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
  
<script language="javascript" type="text/javascript" src="js/actb.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script>
        var customarray=new Array('Nearby','My Groups','UCLA friends','TMNT','Whoop'); <!-- where  all tags go -->
        var custom2 = new Array('something','randomly','different');
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
            <input type="text" name="audience" id="audience" autocomplete="off" /> 
            <br/>
            <br/>
            <label for="subject">Subject:</label>
            <br/>
            <input type="text" name="subject" id="subject" autocomplete="off"/>
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
            
       <script>
            var obj = actb(document.getElementById('audience'),customarray);
       </script>
       
        <?PHP include("app_footer.php"); ?>
    </body>
    
</html>