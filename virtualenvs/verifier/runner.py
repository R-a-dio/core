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

CHOICES = ['mp3', 'flac']
ENCODERS = {
    "mp3": "lame --noreplaygain --silent --resample 44.1 -m j --preset cbr 192 -q 0 {filein} {fileout}",
    "flac": "flac -o {fileout} {filein}"
}

class Verifier(object):
    def __init__(self, node, formats, encoders, args):
        self.node = node
        self.formats = formats
        self.filename = self.get_path(args.filename)
        self.format = self.get_format(args)
        self.command = encoders[self.format]

    def get_path(self, filename):
        filename = os.path.abspath(filename)

        if not os.path.exists(filename):
            self.error("file doesn't exist")

        return filename

    def get_format(self, args):
        if args.format is None:
            _, fmt = os.path.splitext(args.filename)
            fmt = fmt.replace('.', '')

            if not fmt in self.formats:
                self.error("{0} is an unsupported file format".format(fmt))
        else:
            fmt = args.format

        return fmt

    def rename(self, src, dst):
        try:
            shutil.move(src, dst)
        except (IOError, shutil.Error) as err:
            self.error("failed to rename {0} to {1}".format(src, dst))

    def run_encode(self, filein, fileout):
        command = self.command.format(filein=filein, fileout=fileout).split(" ")
        subprocess.call(command)

    def encode(self):
        file_id = self.uuid()
        filename = "/tmp/{id}.{ext}".format(ext=self.format, id=self.uuid())

        # let's encode it
        try:
            self.run_encode(self.filename, filename)
        except:
            self.error("failed to encode")

        # now we have a file, let's verify that one
        try:
            self.verify(temp_file)
        except:
            os.remove(temp_file)
            error("re-encoding the file failed")

        # and rename it and we're good
        new = self.new_path(file_id)
        self.rename(filename, new)

        return new

    def uuid(self):
        return str(uuid.uuid1(self.node))

    def new_path(self, filename):
        return os.path.join(os.path.dirname(self.filename),
                            '{0}.{1}'.format(filename, self.format))

    def verify(self, filename=None):
        if not filename:
            filename = self.filename

        audio = audiotools.open(filename)

        # Do verification with audiotools; this might be too strict
        audio.verify()

    def error(self, message, status="fail"):
        print json.dumps({"error": message, "status": status})
        sys.exit(1)

    def check_file(self):
        try:
            self.verify()
        except (audiotools.InvalidFile, audiotools.UnsupportedFile, ValueError):
            # We failed to open it in audiotools, so the streamer
            # won't be able to play it; try re-encoding for good measure.
            try:
                filename = self.encode()
            except VerifyError:
                error("failed to encode the song")
            except:
                error("unknown error on {0}".format(self.filename))


            fileobj = audiotools.open(filename)
            length = long(fileobj.seconds_length())
            # If there was no error we now have two files, delete the old one
            os.remove(args.file)
        else:
            filename = self.new_path(self.uuid())
            self.rename(self.filename, filename)
            fileobj = audiotools.open(filename)
            length = long(fileobj.seconds_length())

        print json.dumps({"length": length, "success": True, "filename": filename})
        sys.exit(0)

def main():
    parser = argparse.ArgumentParser(description='Verify songs can be played by the streamer')
    parser.add_argument('filename', help='the filename of the input')
    parser.add_argument('--format', choices=CHOICES, help='the format of the file (default: guess)')
    args = parser.parse_args()

    verifier = Verifier(20491574538233, CHOICES, ENCODERS, args)
    verifier.check_file()

if __name__ == "__main__":
    main()
