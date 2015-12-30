#!/usr/bin/env bash

apt-get install -y python-virtualenv lame flac mpg123
virtualenv ./verifier
source ./verifier/bin/activate
pip install -U pip setuptools
python ./verifier/setup.py install
