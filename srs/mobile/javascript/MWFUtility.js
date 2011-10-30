// JavaScript Document

function addElement(listDOMId, subject, text, baseOnClickURL) {
	
	var msg = document.createElement("li");
	msg.appendChild(document.createElement("a"));
	if(baseOnClickURL) {
		msg.childNodes[0].setAttribute("href", baseOnClickURL+"?subject="+subject+"&body="+text);
	}
	msg.childNodes[0].innerHTML =  subject + "<br />";
	msg.childNodes[0].innerHTML += "<span class='smallprint'>" + text + "</span>";
	document.getElementById(listDOMId).appendChild(msg);
	
};