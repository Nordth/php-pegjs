// Matches: /** <?php
var regexPhpStart = /\/\*\*\s*<\?php/;
// Matches: ?> **/
var regexPhpEnd   = /\?>\s*\*\*\//;
// Matches either kind of delimiter
var regexPhpDelimiters = new RegExp(
	'(' + regexPhpStart.source + '|' + regexPhpEnd.source + ')'
);

exports.extractPhpCode = function( code ) {
	var codePieces = code.split( regexPhpDelimiters );
	var phpCode = '';
	var insidePhp = false;
	codePieces.forEach( function( piece ) {
		if ( regexPhpStart.test( piece ) ) {
			insidePhp = true;
		} else if ( regexPhpEnd.test( piece ) ) {
			insidePhp = false;
		} else if ( insidePhp ) {
			phpCode += piece;
		}
	} );
	return phpCode ? phpCode : code;
};
