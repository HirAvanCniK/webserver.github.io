function edit(e){
    let input = e.parentNode.getElementsByTagName("input")[0];
    if(e.classList.contains("fa-pen")){
        e.classList.remove("fa-pen");
        e.classList.add("fa-floppy-disk");
        input.disabled = false;
    }else{
        e.classList.add("fa-pen");
        e.classList.remove("fa-floppy-disk");
        input.disabled = true;
    }
}

let settings = [];

let profile = document.getElementById("profile");

for(let element of profile.children){
    if(element.className == "setting"){
        let inputElement = element.getElementsByClassName("value")[0].getElementsByTagName("input")[0];
        settings[inputElement.name] = inputElement.value;
    }
}

function reset(){
    for(let element of profile.children){
        if(element.className == "setting"){
            let inputElement = element.getElementsByClassName("value")[0].getElementsByTagName("input")[0];
            inputElement.value = settings[inputElement.name];
        }
    }
}

function apply(){
    for(let element of profile.children){
        if(element.className == "setting"){
            element.getElementsByClassName("value")[0].getElementsByTagName("input")[0].disabled = false;
        }
    }
}