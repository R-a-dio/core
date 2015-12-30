#!/usr/bin/env bash

DIR="/home/vagrant/radio"

# add dependencies for python packages
apt-get install -y python-pip python-dev lame flac mpg123

# upgrade pip because ouch
curl -sS https://bootstrap.pypa.io/get-pip.py | python

pip install -U virtualenv

# simplify everything else
cd "${DIR}/verifier"

# get a virtualenv up in here
virtualenv .
source bin/activate

# update the ancient, dusty version of pip that comes with this
pip install -U pip setuptools

# install the verifier into the virtualenv
python setup.py install
