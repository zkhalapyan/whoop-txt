<?PHP
error_reporting(E_ALL);
ini_set('display_errors','On');

require_once("./config/ConfigFactory.class.php");
require_once("./lib/rest/RestUtils.class.php");
require_once("./lib/rest/RestRequest.class.php");
require_once("./lib/User.class.php");
require_once("./lib/TokenName.class.php");


$request = RestUtils::processRequest();

//Retreive variables sent with the headers. 
$data = $request->getRequestVars();

//In order to proceed with the API call, there has to be some action set. 
if(!isset ($data['action']))
{
    sendErrorResponse("Please set a proper action for this API call.");
    die();
}


//Create an application instance. This is used to interact with Facebook's SDK.
$facebook = ConfigFactory::get_facebook();


//Get currently logged in user - if the ID returned by Facebook's SDK is 0, then
//the user is unauthenticated and should not return any data.
//FIXME: Check if the user hasa a valid access token.
$user_id = $facebook->getUser();


//Detect unauthenticated users and return a failure response.
if(!$user_id)
{
    
    //Send an error message to the client, explainging the situation.
    sendErrorResponse("Unauthenticated user.");
    
    //Now exit this PHP process. No more processing after this poin     t. 
    exit();
    
}


//At this point we know that the user is authenticated, so we can use the user
//ID to create an active record.
$user = new User($user_id);

//Switch on the method used for the API call. For example, the API will act
//differently for a POST method as opposed to a GET method use for request.
switch($request->getMethod())
{
    
        //Process API calls that were requested via GET method.
	case 'get':
            
            process_get_api_call($user, $data);
            
            break;
        
        
        //Process API calls that were requested via GET method.
	case 'post':
            
            process_post_api_call($user, $data);
		
            break;
        
        default:
            sendErrorResponse("method not supported.");
}

 

/**
 * Sends a JSON encoded error message to the client.
 * @param string $msg  Error message to be sent to the client.
 */
function sendErrorResponse($msg)
{
    //Construct an error message to be sent to the user. 
    $error_response = array("status" => "failure", 
                            "error"=>$msg);
    
    //Convert the response array to JSON to be sent to the client.
    $json_response = json_encode($error_response);
     
    //Send the error JSON message to the client.
    RestUtils::sendResponse(200, $json_response, "application/json");
}

function sendSuccessResponse($response_data)
{
    
    //Create an array to be included witht the response. This will be converted
    //to a JSON array before getting send to the client.
    $success_response = array("status" => "success");
    
    //If the user specified data to be sent with the response, then augment the
    //data to the response.
    if($success_response != null)
    {
        $success_response["data"] = $response_data;
    }
    
    //Send the response to the user with a JSON encoded message.
    RestUtils::sendResponse(200, json_encode($success_response), "application/json");
}


function process_get_api_call($user, $data)
{
    switch($data['action'])
    {


    /* * * * * * * * * * * * * 
     * DEBUGGING CASES BELOW *
     * * * * * * * * * * * * */

    case "say_hello":
        sendSuccessResponse("Hello from Whoop-Txt API.");
        break;



    /* * * * * * * * * * * * * * * * 
     * MESSAGE RELATED CASES BELOW *
     * * * * * * * * * * * * * * * */
    case "send_message":

        $msg       = $data["message"];
        $token_ids = $data["token_ids"];
        $lon       = $data["lon"];
        $lat       = $data["lat"];

		$message_id = $user->sendMessageToToken($msg, $token_ids, $lon, $lat);
		sendSuccessResponse(array("message_id" => $message_id));
        //sendErrorResponse("Action not implemented.");
        break;

    case "get_messages":

        sendErrorResponse("Action not implemented.");
        break;

    case "mark_message":
        sendErrorResponse("Action not implemented.");
        break;


    /* * * * * * * * * * * * * * *
     * TOKEN RELATED CASES BELOW *
     * * * * * * * * * * * * * * */

    case "create_token":

        $name = $data["name"];
        $token_id = $user->createToken($name);

        sendSuccessResponse(array("token_id" => $token_id));

        break;

    case "join_token":
        $token_id = $data["token_id"];

        sendErrorResponse("Action not implemented.");
        break;

    case "get_tokens":

        sendErrorResponse("Action not implemented.");
        break;

    case "invite_to_token":

        $token_id = $data["token_id"];

        sendErrorResponse("action not implemented.");

        break;

    case "ignore_token":

        $token_id = $data["token_id"];

        sendErrorResponse("action not implemented.");

        break;

    }

}

function process_post_api_call($user, $data)
{
    sendErrorResponse("POST is not currently supported.");
}

?>