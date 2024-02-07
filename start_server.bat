@echo off

rd /s/q node_modules
del package-lock.json
del terminalInstance.txt
call > terminalInstance.txt

npm install && php -S localhost:8075
