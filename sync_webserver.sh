#!/bin/bash

DESTINATION="/var/www/html"
USERNAME="HirAvanCniK"
REPOSITORY="webserver.github.io"

function clone(){
  cd $DESTINATION
  rm -rf * .*

  git clone https://github.com/$USERNAME/$REPOSITORY.git $DESTINATION
  npm install
  chmod -R 777 $DESTINATION
}

function check_udates() {
  SHA1_ONLINE=$(git ls-remote https://github.com/$USERNAME/$REPOSITORY.git HEAD | awk '{print $1}')
  SHA1_LOCAL=$(git rev-parse HEAD)
  exit_code=$(echo $?)
  if [ "$SHA1_ONLINE" != "$SHA1_LOCAL" -o "$exit_code" != "0" ]; then
    echo "Updates available..."
    clone
  else
    echo "Nice there are not updates!"
  fi
}

# Wait 2 minutes for the network
sleep 120

# At the start the server clone repository
clone

# Each hour check if there are updates
while true; do
  check_udates
  sleep 3600
done