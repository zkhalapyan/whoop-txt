// JavaScript Document

function generateFooterCode()
{
	var footer = document.createElement("div");
	footer.setAttribute("id", "footer");
	
	var link1 = document.createElement("a");
	link1.setAttribute("href", "help.html");
	link1.innerHTML = "Help";
	
	var link2 = document.createElement("a");
	link2.setAttribute("href", "https://apps.facebook.com/whoop_txt");
	link2.innerHTML = "View Full Site";
	
	var p = document.createElement("p");
	p.appendChild(link1);
	p.innerHTML += " | ";
	p.appendChild(link2);
	
	footer.appendChild(p);
	document.body.appendChild(footer);
};

function addElement(listDOMId, subject, text, baseOnClickURL) {
	
	var msg = document.createElement("li");
	msg.appendChild(document.createElement("a"));
	if(baseOnClickURL) {
		msg.childNodes[0].setAttribute("href", baseOnClickURL+"&subject="+subject+"&body="+text);
	}
	msg.childNodes[0].innerHTML =  subject + "<br />";
	msg.childNodes[0].innerHTML += "<span class='smallprint'>" + text + "</span>";
	document.getElementById(listDOMId).appendChild(msg);
	
};

function addElementWithPicture(listDOMId, userId, subject, text, baseOnClickURL) {
	
	var msgLink = document.createElement("a");
	if(baseOnClickURL) {
		msgLink.setAttribute("href", baseOnClickURL+"&subject="+subject+"&body="+text);
	}
	msgLink.innerHTML =  subject + "<br />";
	msgLink.innerHTML += "<span class='smallprint'>" + text + "</span>";
	
	var profPic = document.createElement("img");
	profPic.setAttribute("src", "https://graph.facebook.com/"+userId+"/picture");
	
	var msg = document.createElement("li");
	msg.appendChild(msgLink);
	msg.setAttribute("style", "padding-left: 60px; background: white url(https://graph.facebook.com/"+userId+"/picture) 2px 2px no-repeat;");
	
	document.getElementById(listDOMId).appendChild(msg);
	
};
