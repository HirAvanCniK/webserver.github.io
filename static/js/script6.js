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

let profile = document.getElementById("profile");

function apply(){
    for(let element of profile.children){
        if(element.className == "setting"){
            element.getElementsByClassName("value")[0].getElementsByTagName("input")[0].disabled = false;
        }
    }
}