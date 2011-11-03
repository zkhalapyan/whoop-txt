<?PHP

require_once("./lib/RestUtils.php");
require_once("./lib/RestRequest.php");

$request = RestUtils::processRequest();
$data = $request->getRequestVars();


if(!isset ($data['action']))
{
    echo "Please set a proper action for this api call.";
}

            
 
switch($request->getMethod())
{
	case 'get':
            
           
            switch($data['action'])
            {
                
            }

            break;
        
        	
	case 'post':
		
            break;
}

 

?>