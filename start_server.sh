#!/bin/bash

rm -rf node_modules
rm package-lock.json

npm install && php -S localhost:8095
