<?php

namespace MediaBath;

class Media
{
	const TV    = 'TV';
	const MOVIE = 'Movies';

	private $path;
	private $cleanFileName;
	private $extension;
	private $fileName;
	private $type;
	private $removePath;

	public function __construct( $path )
	{
		$this->path      = $path;
		$this->extension = pathinfo( $path, PATHINFO_EXTENSION );
		$this->fileName  = pathinfo( $path, PATHINFO_FILENAME );
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getExtension()
	{
		return $this->extension;
	}

	public function getFileName()
	{
		return $this->fileName;
	}

	public function getCleanFileName()
	{
		return $this->cleanFileName;
	}

	public function setCleanFileName( $cleanFileName )
	{
		$this->cleanFileName = $cleanFileName;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType( $type )
	{
		$this->type = $type;
	}

	public function getRemovePath()
	{
		return $this->removePath;
	}

	public function setRemovePath( $removePath )
	{
		$this->removePath = $removePath;
	}

	public function __toString()
	{
		$string  = "Full Path    = {$this->path}" . PHP_EOL;
		$string .= "Dirty Name   = {$this->fileName}" . PHP_EOL;
		$string .= "Clean Name   = {$this->cleanFileName}" . PHP_EOL;
		$string .= "Extension    = {$this->extension}" . PHP_EOL;
		$string .= "Type         = {$this->type}" . PHP_EOL;
		$string .= "Remove Path  = {$this->removePath}" . PHP_EOL;

		return $string;
	}
}