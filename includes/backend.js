const WebSocket = require('ws');
var os = require('os');
var pty = require('node-pty');

const wss = new WebSocket.Server({ port: parseInt(process.argv[1]) });

console.log("Socket is up and running...");

var shell = os.platform() === 'win32' ? 'cmd.exe' : 'bash';

var ptyProcess = pty.spawn(shell, [], {
    name: 'xterm-color',
    cwd: process.argv[2] || process.env.HOME || process.env.USERPROFILE,
    env: process.env,
    cols: 10000
});

wss.on('connection', ws => {
    console.log("New session");

    // Catch incoming request
    ws.on('message', command => {
        var processedCommand = commandProcessor(command);
        ptyProcess.write(processedCommand);
    });

    // Output: Sent to the frontend
    ptyProcess.on('data', function (rawOutput) {
        var processedOutput = outputProcessor(rawOutput);
        ws.send(processedOutput);
        console.log(processedOutput);
    });
})

const commandProcessor = function(command) {
    return command;
}

const outputProcessor = function(output) {
    return output;
}