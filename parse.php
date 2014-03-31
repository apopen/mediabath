#!/usr/bin/php
<?php

include "autoload.php";

use MediaBath\MediaParser;

$parser     = new MediaParser();
$mediaFiles = $parser->parse( '/Users/paul/Movies/In Box' );

if( sizeof( $mediaFiles ) == 0 )
{
	echo "Nothing new found" . PHP_EOL;
}
else
{
	foreach( $mediaFiles as $media )
	{				
		echo "---------------------------------------------------------------------------------" . PHP_EOL;
		echo $media;
	}	
}
