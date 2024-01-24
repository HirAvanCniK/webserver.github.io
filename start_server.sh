#!/bin/bash

rm -rf node_modules
rm package-lock.json
rm terminalInstance.txt
touch terminalInstance.txt

npm install && php -S localhost:8095
