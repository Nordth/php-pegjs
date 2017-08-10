var fs = require('fs');
var pegjs = require('pegjs');
var phppegjs = require('../src/phppegjs.js');

var examples =
{
    'Digits':      'digits.pegjs',
    'Arithmetics': 'arithmetics.pegjs',
    'Json':        'json.pegjs',
    'Css':         'css.pegjs',
    'Javascript':  'javascript.pegjs'
};

function generateParser(input_file, output_file, classname)
{
    var data = fs.readFileSync(input_file);
    
    var parser = pegjs.buildParser(data.toString(),
        {
            cache: true,
            plugins: [phppegjs],
            phppegjs: {parserNamespace: 'Parser', parserClassName: classname}
        });
    fs.writeFileSync(output_file, parser);

}

if (!fs.existsSync('output')) fs.mkdirSync('output');

for (var classname in examples)
{
    generateParser('../examples/' + examples[classname],
                   "output/" + examples[classname].replace(/\.[^/.]+$/, ".php"),
                   classname);
}

