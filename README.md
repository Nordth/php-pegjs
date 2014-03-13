PHP PEG.js
======

PHP PEG.js is a php code generation plugin for 
[PEG.js](https://github.com/dmajda/pegjs).

## Requirements

* [PEG.js](http://pegjs.majda.cz/) 

Installation
------------

### Node.js

Install PEG.js with php-pegjs plugin

    $ npm install php-pegjs

Usage
-----

### Generating a Parser

In Node.js, require both the PEG.js parser generator and the php-pegjs plugin:

    var pegjs = require("pegjs");
    var phppegjs = require("php-pegjs");

To generate a php parser, pass to `PEG.buildParser` php-pegjs plugin and your grammar:

    var parser = pegjs.buildParser("start = ('a' / 'b')+", {
        plugins: [phppegjs]
    });
