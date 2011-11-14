<?PHP
error_reporting(E_ALL);
ini_set('display_errors','On');

require_once("./lib/APIException.class.php");
require_once("./config/ConfigFactory.class.php");
require_once("./lib/rest/RestUtils.class.php");
require_once("./lib/rest/RestRequest.class.php");
require_once("./lib/User.class.php");
require_once("./lib/Token.class.php");
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

try 
{
    
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
                throw new APIException("[".$request->getMethod()."] not supported.");
    }
    
}
//Catch any exceptions thrown while processing the API call.
catch(Exception $ex)
{
    
    sendErrorResponse($ex->getMessage());
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

        //Set the parameter requirements for this API call.
        param_check($data, array("message", "token_ids", "lon", "lat"));
        
        $msg       = $data["message"];
        $token_ids = explode(',', $data["token_ids"]);
        $lon       = $data["lon"];
        $lat       = $data["lat"];
        
        sendSuccessResponse(array("message_id"=>$user->sendMessageViaToken($msg, $token_ids, $lon, $lat)));
        break;

    case "get_messages":

        throw new APIException("Action [".$data['action']."] not implemented.");
        break;

    case "mark_message":
        param_check($data, array("message_id", "opened", "delete", "important"));
        
        $msg_id = $data["message_id"];
        $opened = $data["opened"];
        $delete = $data["delete"];
        $important = $data["important"];
        sendSuccessResponse(array("mark_status"=>$user->markMessage($msg_id, $opened, $delete, $important)));
        
        throw new APIException("Action [".$data['action']."] not implemented.");
        break;


    /* * * * * * * * * * * * * * *
     * TOKEN RELATED CASES BELOW *
     * * * * * * * * * * * * * * */

    case "create_token":

        //Set the parameter requirements for this API call.
        param_check($data, array("name"));
        
        sendSuccessResponse(array("token_id"=>$user->createToken($data["name"])));

        break;

    case "join_token":
        
        //Set the parameter requirements for this API call.
        param_check($data, array("token_id"));
 
        $user->joinToken($data["token_id"]);
        
        sendSuccessResponse();
        
        break;

    case "get_tokens":
        
        sendSuccessResponse(array("tokens" => $user->getTokens()));
        
        break;

    case "send_invites":

        //Set the parameter requirements for this API call.
        param_check($data, array("token_id", "user_ids"));
        
        $token_id = $data["token_id"];
        $user_ids = explode(",", $data["user_ids"]);
        
        $token = new Token($token_id);
        
        //If the specified token does not exist, throw an exception.
        if(!$token->exists())
        {
            throw new APIException("Unable to join token. Token [ID: $token_id] does not exist.");
        }
        
        $token->inviteUsers($user_ids);

        break;

    case "ignore_token":

        //Set the parameter requirements for this API call.
        param_check($data, array("token_id"));
        
        $user->ignoreToken($data["token_id"]);
        
        sendSuccessResponse();

        break;

    default:
        throw new APIException("Action [".$data['action']."] not supported.");
        
    }

}

function process_post_api_call($user, $data)
{
    throw new APIException("POST is not currently supported");
}

/**
 * Checks to see if all the parameter names are included in the parameter list. 
 * This method is useful for specifing requirement parameterss for an API call.
 * If one of the specified keys is not in the specified data, a new APIException
 * will be thrown.
 * 
 * Example use:
 * 
 * param_check($_GET, array("name", "message_id"));
 * 
 * @param array $data An associative array.
 * @param array $param_list A list of keys that have to be in the specified 
 *                          associative array. 
 */ 
function param_check($data, $param_list)
{
    foreach($param_list as $param)
    {
        if(!isset($data[$param]))
            throw new APIException("Parameter [$param] is not set.");
    }
}

/**
 * Sends a JSON encoded error message to the client.
 * @param string $msg  Error message to be sent to the client.
 */
function sendErrorResponse($msg = null)
{
    //Construct an error message to be sent to the user. 
    $error_response = array("status" => "failure", 
                            "error"=>$msg);
    
    //Convert the response array to JSON to be sent to the client.
    $json_response = json_encode($error_response);
     
    //Send the error JSON message to the client.
    RestUtils::sendResponse(200, $json_response, "application/json");
}

/**
 * Sends a JSON encoded success message to the client.
 * @param type $response_data  Data to be sent to the client.
 */
function sendSuccessResponse($response_data = null)
{
    
    //Create an array to be included witht the response. This will be converted
    //to a JSON array before getting send to the client.
    $success_response = array("status" => "success");
    
    //If the user specified data to be sent with the response, then augment the
    //data to the response.
    if($response_data != null)
    {
        $success_response["data"] = $response_data;
    }
    
    //Send the response to the user with a JSON encoded message.
    RestUtils::sendResponse(200, json_encode($success_response), "application/json");
}


?>