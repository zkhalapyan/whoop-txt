// JavaScript Document

function deleteMessage (id) {
	AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=mark_message&deleted=true&opened=true&important=false&message_id="+id, function (response) {
		
		if(response.status != "success")
		{
			handleError(response);
			return;
		}
		
		window.location = "messages.html";
		
	});
};

function getMessages(callback) {
	AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_messages", function (response) {
	
		if(response.status != "success")
		{
			handleError(response);
			return;
		}
		
		callback(response.data.messages);
	});
};

function getMessageById(id, callback) {
	getMessages(function (messages) {
		
		for (index in messages)
		{
			if(messages[index].id == id)
			{
				callback(messages[index]);
			}
		}
		
	});
};

function getTokens(callback) {
	AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_tokens", function (response) {
		callback(response.data.tokens);
	});
};

function shareWhoop(messageBody, tokenIds, lon, lat) {
	var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_message";
	url += "&message=" + messageBody;
	url += "&token_ids=" + tokenIds;
	url += "&lon=" + lon;
	url += "&lat=" + lat;
	
	AJAXRequest(url, function (response) {
		window.location = "messages.html";
	});
};

function reshareMessage(id) {
	getMessageById(id, function (msg) {
	
		var tokens = msg.tokens;
		var token_names = "";
		
		for (index in tokens)
		{
			token_names = tokens[index].name + ", ";
		}
		
		if(token_names.length != 0)
		{
			token_names = token_names.substr(0, token_names.length-2);
		}
		
		var msg_text = "Originally shared by " + msg["author_name"] + ": " + msg.text;
		
		window.location = "share.html?tokenNames=" + token_names + "&text=" + msg_text;
	
	});
};