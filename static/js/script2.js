// Explorer
let path = location.search.split("path=")[1];
if(path != undefined){
    if(path.indexOf("&") != -1){
        path = path.split("&")[0];
    }
    if (path != "") {
        while (path.indexOf("+") != -1) {
            path = path.replace("+", "%20");
        }
        var pathInput = document.getElementById("path");    
        pathInput.value = decodeURIComponent(path);
    }
}

function view_properties(f){
    if(f == undefined){
        try{
            let table2 = document.getElementById("mytable2");
            table2.removeChild(table2.getElementsByTagName("tbody")[0]);
        }catch(e){
            // console.log("The table is empty");
        }
    }else{
        fetch("/get_all_informations.php?f="+document.getElementById("path").value+"/"+f.trim()).then(response => response.text()).then((html) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            let table2 = document.getElementById("mytable2")
            let tbody = document.createElement("tbody");
            table2.appendChild(tbody);
            // console.log(doc.getElementById("response").textContent);
            let res = JSON.parse(doc.getElementById("response").textContent);
            for(const key in res) {
                let tr = document.createElement("tr");
                let Key = document.createElement("th");
                let Value = document.createElement("td");
                Key.textContent = key;
                Value.textContent = res[key];
                tr.appendChild(Key);
                tr.appendChild(Value);
                tbody.appendChild(tr);
            }
        });
    }
}

function toggle_select(e){
    if(e.classList.length != 0){
        e.classList.remove("selected");
        view_properties(undefined);
    }else{
        let table = document.getElementById("mytable").getElementsByTagName("tbody")[0];
        for(let i=1; i<table.children.length; i++){
            table.children[i].classList.remove("selected");
        }
        view_properties(undefined);
        e.classList.add("selected");
        view_properties(e.getElementsByTagName('td')[0].textContent);
    }
}



let table = document.getElementById("mytable").getElementsByTagName("tbody")[0];
for(let i=1; i<table.children.length; i++){
    table.children[i].setAttribute("onclick", "toggle_select(this);");
}