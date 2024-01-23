
const socket = new WebSocket("ws://localhost:50107");
socket.onmessage = (event) => {
    term.write(event.data);
}

var term = new window.Terminal({
    cursorBlink: true,
    cursorStyle: 'bar',
    rows: 30
});

var terminal = document.getElementById('terminal');

term.open(terminal);

const resize_ob = new ResizeObserver(function(entries) {
	// since we are observing only a single element, so we access the first element in entries array
	let rect = entries[0].contentRect;

	// current width & height
	let width = rect.width;
	let height = rect.height;

    // term.cols = height/10;
    // term.rows = width/10;

    term.resize(width/10, height/10);
    term.refresh();
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
