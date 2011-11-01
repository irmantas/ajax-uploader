<?php
/*
 * This file is part of is-ajax-upload package
 * (c) Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

/**
 * XHR upload handler
 * @author Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */
require_once 'UploadHandlerAbstract.php';
class UploadHandlerXhr extends UploadHandlerAbstract implements UploadHandlerInterface
{
	/**
	 * Saves uploaded file
	 * @param string $path file save path
	 * @throws Exception
	 * @return boolen
	 */
	public function save ($path)
	{
		/* Read file from stram and save it in temproary file */
		$input = fopen("php://input", "r");
		$temp = tmpfile();
		$realSize = stream_copy_to_stream($input, $temp);

		/* if file sizes does not match, somthing wrog is */
		if ($realSize != $this->getSize()){
			throw new Exception ('File size mismatch');
		}

		/* save tmp file to real location */
		$target = fopen($path, "w");
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);

		return true;
	}

	/**
	 * Returns file name
	 * @throws Exception
	 * @return string file name
	 */
	public function getName ()
	{
		if (!isset($_GET[$this->id])) {
			throw new Exception ('File name by identity not exists');
		}

		if (empty($_GET[$this->id])) {
			throw new Exception ('File name cannot be empty');
		}

		return $_GET[$this->id];
	}

	/**
	 * Returns file size
	 * @throws Exception
	 * @return integer file size
	 */
	public function getSize ()
	{
		if (isset($_SERVER["CONTENT_LENGTH"])) {
			return (int)$_SERVER["CONTENT_LENGTH"];
		} else {
			throw new Exception ('Server does not suport content length');
		}
	}
}