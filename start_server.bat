@echo off

rd /s/q node_modules
del package-lock.json

npm install && php -S localhost:8095
