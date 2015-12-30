#!/usr/bin/python
# -*- coding: utf-8 -*-
# Author: Amelia Ikeda <amelia@dorks.io>
#
# Copyright (c) 2015 R/a/dio
#
# Permission is hereby granted, free of charge, to any person obtaining
# a copy of this software and associated documentation files (the "Software"),
# to deal in the Software without restriction, including without limitation the
# rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
# sell copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
# EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
# OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
# IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
# DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
# OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
# THE USE OR OTHER DEALINGS IN THE SOFTWARE.

"""Verification tool to ensure that songs can be played by R/a/dio's
streaming irc bot (radio.streamer, hanyuu), re-encoding them using
lame or flac as needed."""

import subprocess
import os
import os.path
import shutil
import json
import audiotools
import argparse
import uuid
import sys

NODE=20491574538233 # python 2 doesn't have int.from_bytes, so this is a
                    # hardcoded 48-bit int with the 8th bit set per RFC4122

CHOICES = ['mp3', 'flac']
ENCODERS = {
    "mp3": "lame --noreplaygain --silent --resample 44.1 -m j --preset cbr 192 -q 0 {filein} {fileout}",
    "flac": "flac -o {fileout} {filein}"
}

def path(filename):
    file = os.path.abspath(args.file)

    if not os.path.exists(file):
        error("file doesn't exist")

    return file

def format(fmt):
    if fmt is None:
        _, fmt = os.path.splitext(args.file).replace('.', '')
        if not fmt in CHOICES:
            error("{0} is an unsupported file format".format(fmt))
    else:
        format = args.format

    return fmt

def error(message, status="fail"):
    print json.dumps({"error": message, "status": status})
    sys.exit(1)

def rename(src, dst):
    try:
        shutil.move(src, dst)
    except (IOError, shutil.Error) as err:
        error("failed to rename {0} to {1}".format(src, dst))

def encode():
    command = ENCODERS[args.format]
    id = str(uuid.uuid1(NODE))
    temp_file = "/tmp/verifying-{id}.{ext}".format(ext=args.format, id=id)
    command = command.format(filein=args.file, fileout=temp_file).split(" ")
    try:
        subprocess.call(command)
    except:
        error("failed to encode")

    try:
        verify(temp_file)
    except:
        os.remove(temp_file)
        error("re-encoding the file failed", "fail")

    new = new_path(id)
    rename(temp_file, new)

    return new

def new_path(id):
    return os.path.join(os.path.dirname(args.file), '{0}.{1}'.format(id, args.format))

def verify(filename):
    audio = audiotools.open(filename)

    # Do verification with audiotools; this might be too strict
    audio.verify()

def main():
    parser = argparse.ArgumentParser(description='Verify songs can be played by the streamer')
    parser.add_argument('file', type=path, help='the filename of the input')
    parser.add_argument('--format', type=format, choices=CHOICES, help='the format of the file (default: guess)')
    args = parser.parse_args()

    try:
        verify(args.file)
    except (audiotools.InvalidFile, audiotools.UnsupportedFile, ValueError):
        # We failed to open it in audiotools, so the streamer
        # won't be able to play it; try re-encoding for good measure.
        try:
            filename = encode()
        except VerifyError:
            error("failed to encode the song")
        except Error as e:
            error("unknown error on {0}".format(args.file))


        fileobj = audiotools.open(filename)
        length = long(fileobj.seconds_length())
        # If there was no error we now have two files, delete the old one
        os.remove(args.file)
    else:
        filename = new_path(str(uuid.uuid1(NODE)))
        rename(args.file, filename)
        length = long(fileobj.seconds_length())

    json.dumps({"length": length, "success": true, "filename": filename})
    sys.exit(0)

if __name__ == "__main__":
    main()
