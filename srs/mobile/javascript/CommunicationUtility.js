// JavaScript Document

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = unescape(hash[1]);
    }
    return vars;
}

function handleUnauthenticatedUser() {
	window.location = "https://apps.facebook.com/whoop_txt";
};

function handleError(error) {
	if(response.error == "Unauthenticated user.")
	{
		handleUnauthenticatedUser();
	}
	else
	{
		alert("Error: " + error);
		return;
	}
};

function AJAXRequest(url, callbackFunction)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.open("GET", url, true);
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4)
		{
			if(xmlhttp.status==200)
			{
				// Succesfull request reponse from server
				if(callbackFunction)
				{
					var stringResponse = xmlhttp.responseText;
					var JSONResponse = eval('(' + stringResponse + ')');
					
					if(JSONResponse.status == "success") {
						callbackFunction(JSONResponse);
					}
					else {
						handleError(JSONResponse.error);
					}
				}
			}
			else
			{
				console.log("Error in AJAX Request! Server returned HTTP Status " + xmlhttp.status);
			}
		}
	};
	
	xmlhttp.send();
	
}