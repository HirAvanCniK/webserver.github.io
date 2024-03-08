// Instance manager
var Istatus = document.getElementById("instanceStatus").className;

var btn = document.getElementsByClassName("btnInstance")[0];

var btn_icon = document.createElement("i");
var btn_text = document.createElement("span");

btn_text.style.marginLeft = "5px";

btn_icon.className = "fa-solid";

btn_icon.setAttribute("aria-hidden", "true");

btn.style.color = "white";

function hoverElement(e, boxShadowOver, boxShadowOut){
    e.addEventListener("mouseover", function(){
        e.style.boxShadow = boxShadowOver;
    });
    
    e.addEventListener("mouseout", function(){
        e.style.boxShadow = boxShadowOut;
    });
}

var message = document.createElement('h3');

if(Istatus == "on"){
    hoverElement(btn, "inset 0 0 30px 1px #ee3530", "inset 0 0 50px 1px #ee3530");
    btn.style.boxShadow = "inset 0 0 50px 1px #ee3530";
    btn_text.textContent = "Stop Instance";
    btn_icon.classList.add("fa-stop");
    message.textContent = "The terminal instance is running.";
    message.style.color = "rgba(255, 0, 0, 0.6)";
}else if(Istatus == "off"){
    hoverElement(btn, "inset 0 0 30px 1px springgreen", "inset 0 0 50px 1px springgreen");
    btn.style.boxShadow = "inset 0 0 50px 1px springgreen";
    btn_text.textContent = "Start Instance";
    btn_icon.classList.add("fa-play");
    message.textContent = "The terminal instance is not running.";
    message.style.color = "gold";
}else if(Istatus == "error"){
    hoverElement(btn, "inset 0 0 30px 1px springgreen", "inset 0 0 50px 1px springgreen");
    btn.style.boxShadow = "inset 0 0 50px 1px springgreen";
    btn_text.textContent = "Start Instance";
    btn_icon.classList.add("fa-play");
    message.textContent = "There was an error in generating the terminal instance.";
    message.style.color = "gold";
}

btn.appendChild(btn_icon);
btn.appendChild(btn_text);
message.style.fontWeight = "bold";
let terminalMsg = document.getElementById("terminalmsg");
terminalMsg.appendChild(message);

