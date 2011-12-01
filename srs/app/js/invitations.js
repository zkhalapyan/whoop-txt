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
    
    if(document.getElementById('demo-input-facebook-theme').value.split(', ')=="")
    {
        alert("Whoopsies! You did not select any friends to invite!");
    }
    else
    {
        var tokenNames = document.getElementById('demo-input-facebook-theme').value.split(', ');

        var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_invites";
        url += "&token_id=" + id2;
        url += "&user_ids=" + tokenNames;

        AJAXRequest(url, function (response) {
                if(response.status != "success")
                {
                        alert("Connection to server failed!");
                        return;
                }
                window.location = "groups.php";
        });
    }
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
                var tokens_array = new Array();
                
                for (index in tokens)
                {
                        var token = new Object();
                        token.id   = tokens[index]["id"];
                        token.name = tokens[index]["name"];
                        tokens_array.push(token);
                }

                var form = '<form name="inviteForm" > '
                + '<input type="text" id="demo-input-facebook-theme"/>'
                + ' <img src="img/invite.png" id = "inviteStyle" onclick="sendInvite('+id2+');">'
                + ' <img src="img/cancel.png" id = "cancelStyle2" onclick="redirectSelf();">'
                + '</form>';

                $('#invite_friends'+id2).html(form);
                $("#demo-input-facebook-theme").tokenInput(tokens_array,{theme: "facebook"});                    
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

     // menu for groups
var timeout	= 500;
var closetimer = 0;
var ddmenuitem = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer // check this code 
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

function loadGroup(id)
{
    window.location = "view_group_msg.php";
}

function addElement(listDOMId, name, id) {
    
    var inv = document.createElement("li");
    
    var div1 = document.createElement("div");
    div1.setAttribute("id", "inv_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name_invitations");
    div2.innerHTML = name;

    div1.appendChild(div2);
    div1.innerHTML += "You have been invited to join a new Whoop-Txt group! What would you like to do?";

    var div3 = document.createElement("div");
    div3.setAttribute("id", "edit_menu");

    var accept = document.createElement("img"); 
    accept.setAttribute("src", "img/accept.png");
    accept.setAttribute("id","acceptStyle");
    accept.onclick = new Function("acceptInvite("+id+")");

    var decline = document.createElement("img"); 
    decline.setAttribute("src", "img/decline.png");
    decline.setAttribute("id","declineStyle");
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
    
    var grps_assc = document.createElement("div");
    grps_assc.setAttribute("id", "groups_assoc");
    
    //ul
    var grps_list_ul = document.createElement("ul");
    grps_list_ul.setAttribute("id","group_list");
    
    //li
    var grps_list_li = document.createElement("li");
    
    // image of groups link
    var grps_list_a = document.createElement("a");
    grps_list_a.setAttribute("href","#");
    grps_list_a.setAttribute("onmouseover","mopen("+id+")");
    grps_list_a.setAttribute("onmouseout","mclosetime()");
  
    // image of groups
    var grps_list_pic = document.createElement("img");
    grps_list_pic.setAttribute("src","img/group_side.png");
    
    // div of groups in a box 
    var grps_list_div_m1 = document.createElement("div");
    grps_list_div_m1.setAttribute("id",id);
    grps_list_div_m1.setAttribute("onmouseover","mcancelclosetime()");
    grps_list_div_m1.setAttribute("onmouseout","mclosetime()");

    var url = "https://rocking-apps.com/whooptxt/api/api.php?action=get_token_users";
    url += "&token_id=" + id;
    
    AJAXRequest(url, function (response) {
        if(response.status != "success")
        {
            alert("Connection to server failed!");
            return;
        }
        
        var token_users = response.data;
        var token_users_array = new Array();

        for (index in token_users)
        {
            if(token_users[index]["active"] == "1" && token_users[index]["pending"] == "0")
            {
                token_users_array.push(token_users[index]["name"]);
            }
        }
        
         // link of groups and text
        for(var i = 0; i < token_users_array.length; i++)
        {
            var grps_list_link = document.createElement("a");
            grps_list_link.setAttribute("href","#");
            grps_list_link.innerHTML = token_users_array[i];
            grps_list_div_m1.appendChild(grps_list_link);
        }
     });

    // clear div
    var div_clear = document.createElement("div");
    div_clear.style.clear = "both";
         
    grps_list_a.appendChild(grps_list_pic); 
    grps_list_li.appendChild(grps_list_a);
    grps_list_li.appendChild(grps_list_div_m1);
    grps_list_ul.appendChild(grps_list_li);    
    grps_assc.appendChild(grps_list_ul);
    grps_assc.appendChild(div_clear);
    
    inv.appendChild(grps_assc);
    
    var div1 = document.createElement("div");
    div1.setAttribute("id", "inv_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name");
    var group_link = document.createElement("a");
    group_link.innerHTML = name;
    group_link.onclick = new Function ("loadGroup("+id+")");
    
    div2.appendChild(group_link);
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
    div4.setAttribute("id", "invite_friends"+id);
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
