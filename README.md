PHP PEG.js
======

PHP PEG.js is a php code generation plugin for 
[PEG.js](https://github.com/dmajda/pegjs) parser generator.

Installation
------------

### Node.js

Install PEG.js with php-pegjs plugin

    $ npm install php-pegjs

Usage
-----

### Generating a Parser

In Node.js, require both the PEG.js parser generator and the php-pegjs plugin:

    var PEG = require("pegjs");
    var phpPEG = require("php-pegjs");

To generate a php parser, pass to `PEG.buildParser` php-pegjs plugin and your grammar:

    var parser = PEG.buildParser("start = ('a' / 'b')+", {
        plugins: [pegjsphp]
    });

