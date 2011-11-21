// JavaScript Document

function handleUnauthenticatedUser() {
	window.location = "https://apps.facebook.com/whoop_txt";
};

function handleError(response) {
	if(response.error == "Unauthenticated user.")
	{
		handleUnauthenticatedUser();
	}
	else
	{
		alert("Connection to server failed!");
		return;
	}
};

function deleteMessage (id) {
	AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=mark_message&delete=true&opened=true&important=false&message_id="+id, function (response) {
		
		if(response.status != "success")
		{
			handleError(response);
			return;
		}
		
		window.location = "messages.html";
		
	});
};