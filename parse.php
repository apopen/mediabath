#!/usr/bin/php
<?php

include "autoload.php";

use MediaBath\MediaParser;

$source      = '/Users/paul/Movies/In Box';
$destination = '/Users/paul/Movies';

$parser      = new MediaParser();
$mediaFiles  = $parser->parse( $source );

if( sizeof( $mediaFiles ) == 0 )
{
	echo "Nothing new found" . PHP_EOL;
}
else
{
	foreach( $mediaFiles as $media )
	{				
		//echo "---------------------------------------------------------------------------------" . PHP_EOL;
		//echo $media;

		// move file to new destination and remove the source location
		$sourcePath     = $source . '/' . $media->getRemovePath();
		$files          = scandir( $sourcePath );
		$filesRemaining = count( $files ) - 2;

		echo '> Moving 1 of ' . $filesRemaining . ' files from ' . $media->getRemovePath() . PHP_EOL;

		foreach( $files as $file )
		{
 			if( in_array( $file, array( ".", ".." ) ) ) 
 				continue;
  
  			// create the source path if it doesn't already exist
 			$saveDestination = $destination . '/' . ucwords( $media->getType() ) . '/' . $media->getCleanFileName();
  			if( !file_exists( $saveDestination ) )
  			{
  				echo "> Destination {$saveDestination} doesn't exist, creating it" . PHP_EOL;
				
				mkdir( $saveDestination, 0777, true );
			}
 			
 			//echo "> Moving " . ( $sourcePath . '/' . $file ) . ' to ' . ( $saveDestination . '/' . $file ) . PHP_EOL;
  			
  			// If we copied this successfully, mark it for deletion
  			rename( $sourcePath . '/' . $file, $saveDestination . '/' . $file );  			
		}

		//echo "---------------------------------------------------------------------------------" . PHP_EOL;
	}	
}

// clean up any empty folders in the source location
$iterator = new RecursiveDirectoryIterator( $source ); 
$iterator->setFlags( RecursiveDirectoryIterator::SKIP_DOTS ); 

$directories = new ParentIterator( $iterator ); 
$it = new RecursiveIteratorIterator( $directories, RecursiveIteratorIterator::CHILD_FIRST );
foreach( $it as $dir ) 
{ 
	// Count the number of "children" from the main directory iterator 
	if( iterator_count( $iterator->getChildren() ) === 0 ) 
	{
		echo '> Removing empty directory ' . $dir->getPathname() . PHP_EOL;
		
		rmdir( $dir->getPathname() ); 
	} 
}
