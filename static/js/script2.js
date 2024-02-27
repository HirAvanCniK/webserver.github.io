// Explorer
let path = location.search.split("path=")[1].split("&")[0];
if(path!=""){
    while(path.indexOf("+")!=-1){
        path = path.replace("+", "%20");
    }
    var pathInput = document.getElementById("path");
    console.log(decodeURIComponent(path));
    
    pathInput.value = decodeURIComponent(path);
}
