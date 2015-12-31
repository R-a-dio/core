#!/usr/bin/python
# -*- coding: utf-8 -*-
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

from setuptools import setup

VERSION='1.0.0'

setup(
    name='verifier',
    version=VERSION,
    author='Amelia Ikeda',
    author_email='amelia@dorks.io',
    url='https://r-a-d.io',
    description='',
    long_description='',
    license='MIT',
    package_dir={'verifier': ''},
    packages=['verifier'],
    install_requires=['python-audio-tools'],
    entry_points={
        'console_scripts': [
            'verifier = verifier.runner:main',
        ],
    },
    dependency_links=['git+https://github.com/R-a-dio/python-audio-tools@master#egg=python-audio-tools']
)
