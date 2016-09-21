<?php

/**
 * PHP Class to handle file uploads.
 * @author Mhyk C.D. - http://www.phphybrid.com
 * @copyright 2005 LGNU
 * @version 1.1 BETA
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 * @example see example.php
 *
 */

/**
 * File Size: Bytes
 */
define('UPLOAD_SIZE_BYTES',1);

/**
 * File Size: Megabytes
 */
define('UPLOAD_SIZE_MBYTES',2);

/**
 * Error Code: No file selected
 */
define('UPLOAD_ERROR_NOFILE',1);

/**
 * Error Code: File exceeds the file size limit
 */
define('UPLOAD_ERROR_SIZE',2);

/**
 * Error Code: File Type is invalid
 */
define('UPLOAD_ERROR_TYPE',3);

/**
 * Error Code: Error moving file
 */
define('UPLOAD_ERROR_MOVING',4);


class Upload
{

	/**
	 * The directory where uploaded files will be placed
	 * @var string
	 */
	var $uploadDir;
	
	/**
	 * Uploaded file's name
	 * @var string
	 */
	var $fileName;
	
	/**
	 * Uploaded file's size
	 * @var int
	 */
	var $fileSize;
	
	/**
	 * The file's temporary location
	 * @var string
	 */
	var $tempLocation;
	
	/**
	 * The maximum file size alloted for this file (in bytes)
	 * @var int
	 */
	var $maxFileSize;
	
	/**
	 * The allowed file extensions
	 * @var array
	 */
	var $allowedTypes = array();
	
	/**
	 * Container of the error message
	 * @var string
	 */
	var $errorMsg;
	
	/**
	 * Class constructor.
	 * @access public
	 * @param string $fieldName the name of the file input field
	 * @param string $uploadDir Directory to store uploaded files
	 */
	function Upload($fieldName,$uploadDir)
	{
		if ($this->getVersion() == 4) {
			if (! isset($_FILES[$fieldName])) {
				$this->setErrorMessage(UPLOAD_ERROR_NOFILE);
				return false;
			}
			$file = $_FILES[$fieldName];
		} else {
			if (! isset($HTTP_POST_FILES[$fieldName])) {
				$this->setErrorMessage(UPLOAD_ERROR_NOFILE);
				return false;
			}
			$file = $HTTP_POST_FILES[$fieldName];
		}

		$this->uploadDir = $uploadDir;
		$this->fileName = $file['name'];
		$this->fileSize = $file['size'];
		$this->tempLocation = $file['tmp_name'];		
	}
	
	/**
	 * Sets the acceptable maximum file size : Bytes of Megabytes<br />
	 * Use Constants UPLOAD_SIZE_BYTES || UPLOAD_SIZE_MBYTES
	 * @access public
	 * @param int $size
	 * @param int $sizeType
	 * @return void
	 */
	function setMaxFileSize($size,$sizeType=UPLOAD_SIZE_MBYTES)
	{
		if ($sizeType == UPLOAD_SIZE_MBYTES) {
			$bytes = $this->toBytes($size);
			$this->maxFileSize = $bytes;
		} else {
			$this->maxFileSize = intval($size);
		}
	}
	
	/**
	 * Sets an array of acceptable file extensions
	 * @access public
	 * @param array $types
	 */
	function setTypes($types)
	{
		if (! is_array($types)) {
			trigger_error('Invalid parameter type. Expecting array ',E_USER_WARNING);
		}
		$this->allowedTypes = $types;
	}
	
	/**
	 * Checks if a file has been uploaded
	 * @access private
	 * @return boolean
	 */
	function isUploaded()
	{
		$temp = $this->tempLocation;
		if (@is_uploaded_file($temp)) {
			return true;
		} else {
			$this->setErrorMessage(UPLOAD_ERROR_NOFILE);
			return false;
		}
	}
	
	/**
	 * Attempts to move the file to the defined location
	 * @access private
	 * @return boolean
	 */
	function moveFile()
	{
		$destination = $this->uploadDir;
		$filename = $this->fileName;
		$temp = $this->tempLocation;
		if (@move_uploaded_file($temp,$destination.$filename)) {
			return true;
		} else {
			$this->setErrorMessage(UPLOAD_ERROR_MOVING);
			return false;
		}
	}
	
	/**
	 * Method to check for a valid file size
	 * @access private
	 * @return boolean
	 */
	function checkSize()
	{
		$maxFileSize = $this->maxFileSize;
		$fileSize = $this->fileSize;
		if ($fileSize > $maxFileSize) {
			$this->setErrorMessage(UPLOAD_ERROR_SIZE);
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Checks for a valid file extension
	 * @access private
	 * @return boolean
	 */
	function checkType()
	{
		$types = $this->allowedTypes;
		$file = $this->fileName;
		
		if ($types[0] == '*') {
			// All types are permitted
			return true;
		}
		
		/*foreach ($types as $type) {
			if (ereg($type.'$',$file)) {
				return true;
			}
		}
		*/
		$this->setErrorMessage(UPLOAD_ERROR_TYPE);
		return false;
	}

	/**
	 * Method to set the file's name
	 * @access public
	 * @param string $newName
	 */
	function setRenameFile($newName)
	{		
		rename ($this->uploadDir."/".$this->fileName, $this->uploadDir."/".$newName);
	}
	
	/**
	 * Method to get the file's name
	 * @access public
	 * @return string
	 */
	function getFileName()
	{
		return $this->fileName;
	}
	
	/**
	 * Method to get the file's size : Use constants UPLOAD_SIZE_BYTES || UPLOAD_SIZE_MBYTES(default)
	 * @access public
	 * @param int $sizeType
	 * @return int / float
	 */
	function getFileSize($sizeType=UPLOAD_SIZE_MBYTES)
	{
		$bytes = $this->fileSize;
		if ($sizeType == UPLOAD_SIZE_MBYTES) {
			return $this->toMBytes($bytes);
		} else {
			return $bytes;
		}
	}
	
	/**
	 * Method to convert byte to MegaBytes
	 * @access private
	 * @param int $bytes
	 * @param int [optional] $decimal Decimal places to show
	 * @return float
	 */
	function toMBytes($bytes,$decimal=2)
	{
		// KB
		$kb = ($bytes * 8) / 1024;
		// MB
		$mb = ($kb /1024) / 8;
	
		return round($mb,$decimal);
	}

	/**
	 * Method to convert MB to Bytes
	 * @access private
	 * @param float $mb
	 * @return int
	 */
	function toBytes($mb)
	{
		$bytes = ((($mb * 8) * 1024) * 1024) / 8;
		return $bytes;
	}
	
	/**
	 * Process the file
	 * @return boolean
	 */
	function process()
	{
		if (! $this->isUploaded())
			return false;
		if (! $this->checkSize())
			return false;
		if (! $this->checkType())
			return false;
		if (! $this->moveFile())
			return false;
		return true;
	}
	
	/**
	 * Method to set the error message
	 * @access private
	 * @param int $code The error code
	 */
	function setErrorMessage($code)
	{
		switch ($code)
		{
			case UPLOAD_ERROR_SIZE:
			$msg = 'Archivo excede el tamaño maximo permitido.';
			break;
			
			case UPLOAD_ERROR_TYPE:
			$msg = 'Tipo de archivo invalido.';
			break;
			
			case UPLOAD_ERROR_NOFILE:
			$msg = 'No se ha seleccionado archivo o es demasiado grande.';
			break;
			
			case UPLOAD_ERROR_MOVING:
			$msg = 'Error al mover el archivo.';
			break;
			
			default:
			$msg = 'Error desconocido.';
		}
		$this->errorMsg = $msg;
	}
	
	/**
	 * Method to get the error message
	 * @access public
	 * @return string The error message
	 */
	function getMessage()
	{
		return $this->errorMsg;
	}
	
	/**
	 * Method to get PHP's Version<br />
	 * If version is 4.1.0 and above, use $_FILES<br />
	 * If version is below 4.1.0, use $HTTP_POST_FILES
	 * @access private
	 * @return int Version
	 */
	function getVersion()
	{
		$version = phpversion();
		$version = explode('.',$version);
		
                if ( ($version[0]>4) ||($version[0] = 4 && $version[1] >= 1) ){
                    return 4;
                } else {
                    return 3;
                }
	}

}

?>