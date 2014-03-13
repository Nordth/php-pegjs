var fs = require('fs');
var pegjs = require('pegjs');
var pegjsphp = require('../src/pegjsphp.js');

var examples =
{
    'Arithmetics': 'arithmetics.pegjs',
    'Json':        'json.pegjs',
    'Css':         'css.pegjs',
    'Javascript':  'javascript.pegjs'
};

function generateParser(input_file, output_file, classname)
{
    fs.readFile(input_file, function (err, data) {
        if (err) throw err;

        var parser = pegjs.buildParser(data.toString(),
            {
                cache: true,
                plugins: [pegjsphp],
                pegjsphp: {parserNamespace: 'Parser', parserClassName: classname}
            });
        fs.writeFile(output_file, parser);
    });

}

if (!fs.existsSync('output')) fs.mkdirSync('output');

for (var classname in examples)
{
    generateParser('../examples/' + examples[classname],
                   "output/" + examples[classname].replace(/\.[^/.]+$/, ".php"),
                   classname);
}

