#!/usr/bin/env bash

DIR="/home/vagrant/radio"

# add dependencies for python packages
apt-get install -y python-pip python-dev lame flac mpg123

# upgrade pip because ouch
curl -sS https://bootstrap.pypa.io/get-pip.py | python
pip install -U virtualenv ndg-httpsclient

function install() {
  local virtualenv=$1
  cd "${DIR}/virtualenvs/${virtualenv}"
  virtualenv .
  source bin/activate
  python setup.py install
  deactivate
}

# go through each virtualenv and set them up
install verifier
#install hanyuu