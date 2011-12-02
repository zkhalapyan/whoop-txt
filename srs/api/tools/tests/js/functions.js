
var d=new Date();
var t=d.getDate();
var y = d.getFullYear();
var h = d.getHours();
var m = d.getMinutes();
var s = d.getSeconds();



/************************************************************************
                            MENU FUNCTION
 *************************************************************************/

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

// close layer when click-out
document.onclick = mclose;   


              /********* ADD ELEMENT/MESSAGE TO LIST ***********/
function addElement(listDOMId, msg_id, author_name, author_id, text,token_array_id,token_array, post_time) {

       
    var msg = document.createElement("li");

      // div               
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
    grps_list_a.setAttribute("onmouseover","mopen("+msg_id+")");
    grps_list_a.setAttribute("onmouseout","mclosetime()");
  
    // image of groups
    var grps_list_pic = document.createElement("img");
    grps_list_pic.setAttribute("src","img/groups_icon.png");
    
    // div of groups in a box 
    var grps_list_div_m1 = document.createElement("div");
    grps_list_div_m1.setAttribute("id",msg_id);
    grps_list_div_m1.setAttribute("onmouseover","mcancelclosetime()");
    grps_list_div_m1.setAttribute("onmouseout","mclosetime()");

   
    // link of groups and text
    for(var i = 0; i < token_array.length; i++)
    {        
            var grps_list_link = document.createElement("a");
            grps_list_link.setAttribute("href","javascript:token_msg(\""+token_array_id[i]+"\")");
            grps_list_link.innerHTML = token_array[i];      
            grps_list_div_m1.appendChild(grps_list_link);
    }

    
    // clear div
    var div_clear = document.createElement("div");
    div_clear.style.clear = "both";
    
    
     
    grps_list_a.appendChild(grps_list_pic); 
    
    grps_list_li.appendChild(grps_list_a);
    grps_list_li.appendChild(grps_list_div_m1);
    
    grps_list_ul.appendChild(grps_list_li);    
    grps_assc.appendChild(grps_list_ul);
    grps_assc.appendChild(div_clear);
 
    var pic_link = document.createElement("a");
    pic_link.setAttribute("href", "https://www.facebook.com/profile.php?id="+author_id);
    pic_link.setAttribute("target", "_parent");
    
    var picture = document.createElement("img");
    picture.setAttribute("id", "profile_pic");
    picture.setAttribute("src", "http://graph.facebook.com/"+author_id+"/picture");
    picture.setAttribute("width", "48");
    picture.setAttribute("height", "48");
    picture.setAttribute("alt", "profile_pic");

    pic_link.appendChild(picture);
    
    var div1 = document.createElement("div");
    div1.setAttribute("id", "msg_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name");
    var name_link = document.createElement("a");
    name_link.setAttribute("href", "https://www.facebook.com/profile.php?id="+author_id);
    name_link.setAttribute("target", "_parent");
    name_link.setAttribute("id", "name_link");
    name_link.innerHTML = author_name;
    
    div2.appendChild(name_link);
    div1.appendChild(div2);
    div1.innerHTML += text;

    var div3 = document.createElement("div");
    div3.setAttribute("id", "rsd");


    var ul = document.createElement("ul");
    var li1 = document.createElement("li");
    var li2 = document.createElement("li");
    var li3 = document.createElement("li");
    var li4 = document.createElement("li");
    
    var link1 = document.createElement("a");
    link1.setAttribute("href", "javascript:reply_msg()");
    link1.innerHTML = "Reply";

    var link2 = document.createElement("a");
    link2.setAttribute("href", "javascript:anchortest()");
    link2.innerHTML = "Share";
    
    var link3 = document.createElement("a");
    link3.setAttribute("href", "javascript:delete_msg("+msg_id+")");
    link3.innerHTML = "Delete";

    var link4 = document.createElement("span");
    link4.setAttribute("id", "date");
    
    var upDate = post_time.split(" ");
    
    var date = upDate[0];
    var new_date = date.split("-");
    var month = new_date[1];
    var day = new_date[2];
    var year = new_date[0];
    
    var time = upDate[1];
    var new_time = time.split(":");
    var hour= new_time[0];
    var fixed_hour = "";
    var ampm = "";
    if(hour>12)
    {
        fixed_hour = hour-12;
        ampm = "PM";
    }
    else
    {
        fixed_hour = hour;
        ampm = "AM";
    }
    
    var minute = new_time[1];
    var seconds = new_time[2];
    

    link4.innerHTML = month+"/"+day+"/"+year+"  "+(fixed_hour-1) +":"+minute+ampm;
    
    li1.appendChild(link1);
    li2.appendChild(link2);
    li3.appendChild(link3);
    li4.appendChild(link4);
    
    
    ul.appendChild(li1);
    ul.appendChild(li2);
    ul.appendChild(li3);
    ul.appendChild(li4);
    
    div3.appendChild(ul);

    div1.appendChild(div3);

    var clr = document.createElement("div");
    clr.setAttribute("id", "clear");
    
    msg.appendChild(grps_assc);
    msg.appendChild(pic_link);
    msg.appendChild(div1);
    msg.appendChild(clr);
    
    document.getElementById(listDOMId).appendChild(msg);
};



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

 function reply_msg()
{

window.alert("This is an anchor test.");

}
 function share_msg()
{

window.alert("This is an anchor test.");
}

 function delete_msg(msg_id)
{
    
   
  var del_url = "https://rocking-apps.com/whooptxt/api/api.php?action=mark_message&message_id="+msg_id+"&opened=1&deleted=1&important=0";
  AJAXRequest(del_url, function (response) {
          if(response.status == "success")
            {
                window.location = "index.php";
            }
            else
            {
                alert("Error connecting to server!");
                
            }
    });
}


 function token_msg(token_id)
{
    
    top.location = "view_group_msg.php?id="+token_id;

        
}




/************************************************************************
                           SEND MESSAGE FUNCTIONS
 *************************************************************************/
               /********* CHANGE SIZE OF TEXT ***********/
    function ChangeSize (){
        var area_size = document.getElementById ("text_area");
        area_size.style.height = "100px";

}
    function submitWhoop() {
        
        var tokenIds = "";
        if(document.getElementById('demo-input-facebook-theme').value.split(', ')=="")
            {
                alert("Whoopsies! You forgot to enter your Group tags!");
            }
        else
            var tokenNames = document.getElementById('demo-input-facebook-theme').value.split(', ');
        
        var messageBody = document.getElementById('text_area').value;
          
        msglocation.getPosition(

                function(pos){
                        var lat = pos['latitude'];
                        var lon = pos['longitude'];
                        var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_message";
                        url += "&message=" + messageBody;
                        url += "&token_ids=" + tokenNames;
                        url += "&lon=" + lon;
                        url += "&lat=" + lat;
                        submitfunc(url);
                }, 
                function(err)
                { 
                    var lat = 0;
                    var lon = 0;
                    var url = "https://rocking-apps.com/whooptxt/api/api.php?action=send_message";
                    url += "&message=" + messageBody;
                    url += "&token_ids=" + tokenNames;
                    url += "&lon=" + lon;
                    url += "&lat=" + lat;
                    submitfunc(url);      
                }
        );

}




