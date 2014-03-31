<?php

namespace MediaBath;

use MediaBath\Media;

class MediaParser
{
	const TV_SHOW_PATTERN = '/s\d{1,2}e\d{1,2}|S\d{1,2}E\d{1,2}|\d{1,2}x\d{1,2}|hdtv/i';
	const CLEANER_PATTERN = '/(S[0-9].E[0-9].*)|(720p.*|1080p.*|BluRay.*|x264.*|ppvrip.*|dvdrip.*|hdtv.*|webscr.*|pdtv.*|dvdscr.*|r5.*|brrip.*|dvd5.*|(\d{1,2}x[\d{1,2}].*))/i';
	const QUALITY_PATTERN = '/720p|1080p|ppvrip|dvdrip|hdtv|webscr|pdtv|dvdscr|r5|brrip|dvd5/i';

	private $rootLocation;

	public function parse( $rootLocation )
	{
		$this->rootLocation = $rootLocation;

		return $this->retrieveMediaFiles( $rootLocation );
	}

	private function cleanFileName( $fileName )
	{
		$cleanName = preg_replace( MediaParser::CLEANER_PATTERN, '', $fileName );

		$cleanName = pathinfo( $cleanName, PATHINFO_FILENAME );

		return $cleanName;
	}

	private function determineType( $fileName )
	{
		return preg_match( MediaParser::TV_SHOW_PATTERN, $fileName ) ? Media::TV : Media::MOVIE;
	}

	private function determineRemovePath( $fileName )
	{
		return dirname( str_replace( $this->rootLocation . DIRECTORY_SEPARATOR, '', $fileName ) );
	}

	private function retrieveMediaFiles( $path )
	{
    	$fileNames = array();
    	$dir       = opendir( $path );

    	while( ( $file = readdir( $dir ) ) !== false )
    	{
			if( $file[0] == '.' ) 
				continue;
        	
        	$fullpath = $path . '/' . $file;
        	
        	if( is_dir( $fullpath ) )
        	{
            	$fileNames = array_merge( $fileNames, $this->retrieveMediaFiles( $fullpath ) );
        	}
        	else
        	{
        		$media = new Media( $fullpath );
        		
        		//if( $media->getExtension() != '!sync' )
        		{
            		$path = $media->getPath();

            		$media->setCleanFileName( $this->cleanFileName( $path ) );
            		$media->setType( $this->determineType( $path ) );
            		$media->setRemovePath( $this->determineRemovePath( $path ) );

            		$fileNames[] = $media;
        		}
        	}
    	}

    	return $fileNames;
	}
}