
/************************************************************************
                            MENU FUNCTION
 *************************************************************************/

              /********* ADD ELEMENT TO LIST ***********/
function addElement(listDOMId, name, id, text) {

    var msg = document.createElement("li");

    var picture = document.createElement("img");
    picture.setAttribute("id", "profile_pic");
    picture.setAttribute("src", "http://profile.ak.fbcdn.net/hprofile-ak-ash2/368845_1166209105_1503547088_q.jpg");
    picture.setAttribute("width", "48");
    picture.setAttribute("height", "48");
    picture.setAttribute("alt", "profile_pic");

    var div1 = document.createElement("div");
    div1.setAttribute("id", "msg_txt");

    var div2 = document.createElement("div");
    div2.setAttribute("id", "user_name");
    div2.innerHTML = name;

    div1.appendChild(div2);
    div1.innerHTML += text;

    var div3 = document.createElement("div");
    div3.setAttribute("id", "edit_menu");

    var link1 = document.createElement("a");
    link1.setAttribute("href", "javascript:anchortest()");
    link1.innerHTML = "Reply";

    var link2 = document.createElement("a");
    link2.setAttribute("href", "javascript:anchortest()");
    link2.innerHTML = "Share";
    
    var link3 = document.createElement("a");
    link3.setAttribute("href", "javascript:anchortest()");
    link3.innerHTML = "Delete";

    div3.appendChild(link1);
    div3.appendChild(link2);
    div3.appendChild(link3);

    div1.appendChild(div3);

    var clr = document.createElement("div");
    clr.setAttribute("id", "clear");

    msg.appendChild(picture);
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

 function anchor_test()
{

window.alert("This is an anchor test.");
}


              /********* CHANGE SIZE OF TEXT ***********/
    function ChangeSize (){
var area_size = document.getElementById ("text_area");
area_size.style.height = "100px";
}


/************************************************************************
                           SEND MESSAGE FUNCTIONS
 *************************************************************************/