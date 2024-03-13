#!/bin/bash

DESTINATION="/var/www/webserver.irvanni.it"
USERNAME="HirAvanCniK"
REPOSITORY="webserver.github.io"

cd $DESTINATION
rm -rf * .git .gitignore

git clone https://github.com/$USERNAME/$REPOSITORY.git $DESTINATION
npm install
chmod -R 777 $DESTINATION

function check_udates() {
  SHA1_ONLINE=$(git ls-remote https://github.com/$USERNAME/$REPOSITORY.git HEAD | awk '{print $1}')
  SHA1_LOCAL=$(git rev-parse HEAD)
  exit_code=$(echo $?)
  if [ "$SHA1_ONLINE" != "$SHA1_LOCAL" -o $exit_code != 0 ]; then
    echo "Updates available..."
    git pull --force origin main
    npm install
    chmod -R 777 $DESTINATION
  else
    echo "Nice there are not updates!"
  fi
}

while true; do
  check_udates
  sleep 30
done
