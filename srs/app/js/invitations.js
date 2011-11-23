/********* ADD ELEMENT TO LIST ***********/
function acceptInvite(token_id) 
{
    var url = "https://rocking-apps.com/whooptxt/api/api.php?action=join_token&token_id=" + token_id;
    AJAXRequest(url, function (response) {
        if(response.status == "success")
        {
            window.location = "groups.php";
        }
        else
        {
            alert("Error connecting to server!");
        }
    });
}

function rejectInvite(token_id) {
    var url = "https://rocking-apps.com/whooptxt/api/api.php?action=ignore_token&token_id=" + token_id;
    AJAXRequest(url, function (response) {
        if(response.status == "success")
        {
            window.location = "groups.php";
        }
        else
        {
            alert("Error connecting to server!");
        }
    });
}

function sendInvite(id2){
    var tokenIds = "";
	var tokenNames = document.getElementById('invite'+id2).value.split(',');
	for (var i=0; i<tokenNames.length; i++)
	{
		for (index in autoCompleteArray)
		{
			if(tokenNames[i] == autoCompleteArray[index] || tokenNames[i] == " " + autoCompleteArray[index])
			{
				tokenIds += autoCompleteIds[index] + ",";
			}
		}
	}
	
	if(tokenIds.length > 0)
	{
		tokenIds = tokenIds.substr(0, tokenIds.length-1);
	}
	
	var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_invites";
	url += "&token_id=" + id2;
	url += "&user_ids=" + tokenIds;
	
	AJAXRequest(url, function (response) {
		if(response.status != "success")
		{
			alert("Connection to server failed2!");
			return;
		}
		window.location = "groups.php";
	});
}    

function redirectSelf(){
    window.location = "groups.php";
    return;
}

function inviteMembers(id2) {
	var id = getUrlVars()["id"];

        autoCompleteArray = new Array();
        autoCompleteIds = new Array();

        AJAXRequest("https://rocking-apps.com/whooptxt/api/api.php?action=get_friends", function (response) {

                if(response.status != "success")
                {
			alert("Connection to server failed!");
			return;
                }

                var tokens = response.data;
                for (index in tokens)
                {
                        autoCompleteArray.push(tokens[index].name);
                        autoCompleteIds.push(tokens[index].id);
                }

                var form = '<form name="inviteForm" > '
//                + ' <label for="invite">New Members</label> '
                +  '  <input type="text" name="invite'+id2+'" id="invite'+id2+'" /> '
                + ' <input type="button" value="Invite" onclick="sendInvite('+id2+');">'
                + ' <input type="button" value="Cancel" onclick="redirectSelf();">'
                + '</form>';

       $('#'+id2).html(form);
       
                actb(document.getElementById('invite'+id2), autoCompleteArray);

        });
}
 
function submitGroup() {
        
	var groupName = document.forms["createGroupForm"]["group"].value;
	var url = "https://rocking-apps.com/whooptxt/api/api.php?action=create_token&name=" + groupName;

	AJAXRequest(url, function (response) {
		if(response.status == "success")
		{
			window.location = "groups.php";
		}
		else
		{
			alert("Error creating group!");
		}
	});

}

function addElement(listDOMId, name, id) {
    
    var inv = document.createElement("li");
    
    var div1 = document.createElement("div");
    div1.setAttribute("id", "inv_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name");
    div2.innerHTML = name;

    div1.appendChild(div2);
    div1.innerHTML += "You have been invited to join a new Whoop-Txt group! What would you like to do?";

    var div3 = document.createElement("div");
    div3.setAttribute("id", "edit_menu");

    var accept = document.createElement("input"); 
    accept.value = 'Accept'; 
    accept.type  = 'button';
    accept.onclick = new Function("acceptInvite("+id+")");

    var decline = document.createElement("input"); 
    decline.value = 'Decline'; 
    decline.type  = 'button';
    decline.onclick = new Function("rejectInvite("+id+")");

    div3.appendChild(accept);
    div3.appendChild(decline);

    div1.appendChild(div3);

    var clr = document.createElement("div");
    clr.setAttribute("id", "clear");
    
    inv.appendChild(div1);
    inv.appendChild(clr);
    
    document.getElementById(listDOMId).appendChild(inv);
}

function addElement2(listDOMId, name, id) {
    
    var inv = document.createElement("li");
    
    var div1 = document.createElement("div");
    div1.setAttribute("id", "inv_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name");
    div2.innerHTML = name;

    div1.appendChild(div2);

    var div3 = document.createElement("div");
    div3.setAttribute("id", "edit_menu");

    var link1 = document.createElement("a");
    link1.innerHTML = "Leave Group";
    link1.onclick = new Function("rejectInvite("+id+")");

    var link2 = document.createElement("a");
    link2.innerHTML = "Invite More Friends";
    link2.onclick = new Function("inviteMembers("+id+")");
    
    var space = document.createElement();
    space.innerHTML = " ";

    div3.appendChild(link2);
    div3.appendChild(space);
    div3.appendChild(link1);
    
    div1.appendChild(div3);   
 
    var div4 = document.createElement("div");
    div4.setAttribute("id", id);
    div1.appendChild(div4);  

    var clr = document.createElement("div");
    clr.setAttribute("id", "clear");
    
    inv.appendChild(div1);
    inv.appendChild(clr);
    
    document.getElementById(listDOMId).appendChild(inv);
}

function stripslashes (str) {
    return (str + '').replace(/\\(.?)/g, function (s, n1) {
        switch (n1) {
        case '\\':
            return '\\';
        case '0':
            return '\u0000';
        case '':
            return '';
        default:
            return n1;
        }
    });
}

              /********* SHOW ELEMENT ***********/
function showElement(layer)
{
        var myLayer = document.getElementById(layer);
        if(myLayer.style.display=="none"){
        myLayer.style.display="block";
        myLayer.backgroundPosition="top";
        } 
        else{ 
        myLayer.style.display="none";
        }
}

 function anchor_test()
{

window.alert("This is an anchor test.");
}


              /********* CHANGE SIZE OF TEXT ***********/
    function ChangeSize (){
var area_size = document.getElementById ("text_area");
area_size.style.height = "100px";
}
