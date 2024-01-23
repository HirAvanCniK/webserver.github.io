// Explorer
const path = location.search.split("path=")[1].split("&")[0];
if(path!=""){
    var pathInput = document.getElementById("path");
    console.log(decodeURIComponent(path));
    pathInput.value = decodeURIComponent(path);
}