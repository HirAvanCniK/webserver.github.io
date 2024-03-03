// Add dir container
function add_main_dir() {
    var bb = $("#background_blurred.secondary");
    var amd_container = $("#add_main_dir");
    amd_container.toggleClass("hidden");
    bb.toggleClass("hidden");
    amd_container.toggleClass("show_add_main_dir");
    if(bb.hasClass('hidden')){
        document.body.getElementsByTagName('main')[0].style.overflowY = 'scroll';
    }else{
        document.body.getElementsByTagName('main')[0].style.overflowY = 'hidden';
    }
}

// Add dir select icons
function stringTransform(inputString) {
    const string_without_score = inputString.replace(/-/g, " ");
    const words = string_without_score.split(" ");
    const MaiuscWords = words.map((word) => {
        if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        } else {
            return word;
        }
    });

    const result = MaiuscWords.join(" ");
    return result;
}

// Toggle Select Icon Menu
function toggle_select_menu_icon(){
    var menu = document.getElementById('add_main_dir_select_icon');
    if(menu.style.display == 'none'){
        menu.style.display = 'inline-block';
    }else{
        menu.style.display = 'none';
    }
}

// Select Icon From Menu
var lista = document.getElementById('add_main_dir_select_icon');
var destination_element = document.getElementsByClassName('visible_icon')[0];
var iconInput = document.getElementById('icon');
lista.addEventListener('click', function (event){
    var icon = undefined;
    if(event.target.tagName == 'I'){
        icon = event.target;
    }else if(event.target.tagName == 'SPAN'){
        icon = event.target.parentNode.querySelector('i');
    }else if(event.target.tagName == 'LI'){
        icon = event.target.querySelector('i');
    }
    if(icon){
        var newIcon = document.createElement('i');
        newIcon.className = icon.className;
        iconInput.setAttribute('value', newIcon.classList[1]);
        destination_element.textContent = "";
        destination_element.appendChild(newIcon);
    }
});

function search_icon(){
    var search_bar = document.getElementsByClassName('search_icon')[0];
    var text_to_search = search_bar.value;
    lista.childNodes.forEach(function (li) {
        if(li.className){
            if(li.className.includes('select_icon')){
                var span = li.querySelector('span');
                if(!span.textContent.toUpperCase().includes(text_to_search.toUpperCase())){
                    li.style.display = 'none';
                }else{
                    li.style.display = 'flex';
                }
            }
        }
    })
}


// Memory Management
var percentageComplete = parseInt(document.getElementById('mem_percent_used').textContent, 10);
var p_0_40 = "#00ffac";
var p_41_80 = "#fbdf50";
var p_81_90 = "#f39a3c";
var p_91_100 = "#ee3530";
var strokeDashOffsetValue = 100 - percentageComplete;
var progressBar = $(".js-progress-bar");
progressBar.css("stroke-dashoffset", strokeDashOffsetValue);
if(percentageComplete>=0 && percentageComplete<=40){
    progressBar.css("stroke", p_0_40);
}else if(percentageComplete>=41 && percentageComplete<=80){
    progressBar.css("stroke", p_41_80);
}else if(percentageComplete>=81 && percentageComplete<=90){
    progressBar.css("stroke", p_81_90);
}else if(percentageComplete>=91 && percentageComplete<=100){
    progressBar.css("stroke", p_91_100);
}

// Services
var services = document.getElementById('services');
services.childNodes.forEach(function (child) {
    if(child.tagName == "DIV"){
        var text = child.getElementsByClassName('status_on_off_text')[0].textContent;
        var icon = child.getElementsByClassName('status_on_off')[0];
        if(text == "Online"){
            icon.textContent = "🟢";
            child.style = "box-shadow: 0px 0px 30px 3px springgreen;";
        }else if(text == "Offline"){
            icon.textContent = "🔴";
            child.style = "box-shadow: 0px 0px 30px 3px #ee3530;";
        }
    }
})
