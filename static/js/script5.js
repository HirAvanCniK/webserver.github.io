require.config({ paths: { 'vs': 'https://unpkg.com/monaco-editor@latest/min/vs' }});
// window.MonacoEnvironment = { getWorkerUrl: () => proxy };

// let proxy = URL.createObjectURL(new Blob([`
//     self.MonacoEnvironment = {
//         baseUrl: 'https://unpkg.com/monaco-editor@latest/min/'
//     };
//     importScripts('https://unpkg.com/monaco-editor@latest/min/vs/base/worker/workerMain.js');
// `], { type: 'text/javascript' }));

function getBasename(path) {
    if(path != undefined){
        path = path.split('?')[0];
        const parts = path.split(/[/\\]/);
        return parts[parts.length - 1];
    }else{
        return path;
    }
}

function getPath(){
    let path = location.search.split("file=")[1];
    if(path != undefined){
        if(path.indexOf("&") != -1){
            path = path.split("&")[0];
        }
        if (path != "") {
            while (path.indexOf("+") != -1) {
                path = path.replace("+", "%20");
            }
            path = decodeURIComponent(path);
        }
    }
    return path;
}

let saved = true;

function writeNameFile(){
    document.getElementById("filename").textContent = saved ? getBasename(getPath()) || "Untitled" : (getBasename(getPath()) || "Untitled") + "*";
}

let value;

writeNameFile();

function getFileContent(file){
    fetch(`/get_file_content.php?file=${file}`).then(response => response.text()).then((res) => {
        return res;
    });
}

let editor;

require(["vs/editor/editor.main"], function () {
    editor = monaco.editor.create(document.getElementById('editor'), {
        value: value,
        language: '',
        theme: 'vs-dark',
        codeLens: true,
        dragAndDrop: true,
        automaticLayout: true,
        glyphMargin: true,
        padding: 1,
    });
});

// Add all languages to the selector
require(["vs/editor/editor.main"], function () {
    let selector = document.getElementById("languages");
    let languages = [];
    for(let lang of monaco.languages.getLanguages()){
        if(lang.id != "plaintext" && lang.id.length < 20)
            languages.push(lang.id);
    }
    languages.sort();
    for(let lang of languages){
        let op = document.createElement("option");
        selector.appendChild(op);
        op.textContent = lang.toUpperCase();
        op.setAttribute('onclick', 'changeLanguage(this)');
    }
});

function changeLanguage(e){
    console.log(monaco.editor);
    require(["vs/editor/editor.main"], function () {
        monaco.editor.setModelLanguage(editor.getModel(), e.value.toLowerCase());
    });
}

function toggleEditorFilename(){
    $("#insertFileName").toggleClass("close");
    $("#insertFileName").toggleClass("open");
    $("#background_blurred.secondary").toggleClass("hidden");
}

function save(){
    saved = true;
    let newTextFile = "";
    let lines = document.getElementsByClassName("view-line");
    for(let line of lines){
        newTextFile += line.textContent + "\n";
    }
    newTextFile = newTextFile.substring(0, newTextFile.length - 1);
    console.log(newTextFile);
    if(getPath()){
        writeNameFile();
    }else{
        toggleEditorFilename();
    }
}

function saveAs(){
    console.log("TODO");
}

require(["vs/editor/editor.main"], function () {
    editor.getModel().onDidChangeContent((event) => {
        saved = false;
        writeNameFile();
    });
});