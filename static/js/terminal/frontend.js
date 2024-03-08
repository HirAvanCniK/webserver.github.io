
const SERVER = location.hostname;
const PORT = parseInt(location.port)+1;
const socket = new WebSocket(`ws://${SERVER}:${PORT}`);
socket.onmessage = (event) => {
    term.write(event.data);
}

var term = new window.Terminal({
    cursorBlink: true,
    cursorStyle: 'bar'
});

var terminal = document.getElementById('terminal');

const fitAddon = new window.FitAddon.FitAddon();
term.loadAddon(fitAddon);
term.open(terminal);
fitAddon.fit();

const resize_ob = new ResizeObserver(function() {
    fitAddon.fit();
});

resize_ob.observe(terminal);

function init() {
    if (term._initialized) {
        return;
    }
    term._initialized = true;
    term.prompt = () => {
        runCommand('\n');
    };
    setTimeout(() => {
        term.prompt();
    }, 300);
    term.onKey(keyObj => {
        runCommand(keyObj.key);
    });
}

function runCommand(command) {
    socket.send(command);
}

init();
