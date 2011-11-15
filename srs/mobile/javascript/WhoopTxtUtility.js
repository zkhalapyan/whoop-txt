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