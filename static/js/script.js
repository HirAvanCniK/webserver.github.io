// Phone navbar manager
function toggle_navbar_phone() {
    var navbar_phone = $("#navbar_phone").children(".navbar");
    var bb = $("#background_blurred.all");
    navbar_phone.toggleClass("navbar_phone_enable");
    navbar_phone.toggleClass("navbar_phone_disable");
    if (navbar_phone.hasClass("navbar_phone_disable")) {
        bb.hide();
    } else {
        bb.show();
    }
    var button = $("#navbar_phone").children(".navbar_phone_button");
    button.toggleClass("fa-bars");
    button.toggleClass("fa-xmark");
}

/* Background blurred */
var navbar_phone = document
    .getElementById("navbar_phone")
    .querySelector(".navbar");
var navbar_pc = document.getElementById("navbar_pc");
var bb = $("#background_blurred.all");

navbar_pc.addEventListener("mouseover", () => {
    bb.show();
});

navbar_pc.addEventListener("mouseout", () => {
    bb.hide();
});

// Add dir container
function add_main_dir() {
    var bb = $("#background_blurred.add_main_dir");
    var amd_container = $("#add_main_dir");
    amd_container.toggleClass("hidden");
    bb.toggleClass("hidden");
    amd_container.toggleClass("show_add_main_dir");
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

var selectmenu = document.getElementById("add_main_dir_select_icon");
fetch("all-icons.php")
    .then((response) => response.text())
    .then((content) => {
        const icons = content.split("<br>");
        icons.pop();
        icons.forEach((icon) => {
            var option = document.createElement("li");
            option.className = "select_icon";
            var ic = document.createElement("i");
            ic.classList.add("fa-solid");
            var icon_name = icon.split("/")[icon.split("/").length - 1].split(".")[0];
            ic.classList.add("fa-"+icon_name);
            option.appendChild(ic);
            var span = document.createElement("span");
            span.textContent = stringTransform(icon_name);
            option.appendChild(span);
            selectmenu.appendChild(option);
        });
    });

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
    var icon;
    if(event.target.tagName == 'I'){
        icon = event.target;
    }else if(event.target.tagName == 'SPAN'){
        icon = event.target.parentNode.querySelector('i');
    }else{
        icon = event.target.querySelector('i');
    }
    var newIcon = document.createElement('i');
    newIcon.className = icon.className;
    iconInput.setAttribute('value', newIcon.classList[1]);
    destination_element.textContent = "";
    destination_element.appendChild(newIcon);
})

