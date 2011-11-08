<?php
/*
 * This file is part of is-ajax-upload package
 * (c) Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

/**
 * Form upload handler
 * @author Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */
require_once 'UploadHandlerAbstract.php';
class UploadHandlerForm extends UploadHandlerAbstract implements UploadHandlerInterface
{
	/**
	 * Saves uploaded file
	 * @param string $path file save path
	 * @return boolean
	 */
	public function save ($path)
	{
		$this->_checkFileIdentity();
		return move_uploaded_file($_FILES[$this->id]['tmp_name'], $path);
	}

	/**
	 * Gets file name
	 * @return string file name
	 */
	public function getName ()
	{
		$this->_checkFileIdentity();
		return $_FILES[$this->id]['name'];
	}

	/**
	 * Returns file size
	 * @return integer file size
	 */
	public function getSize ()
	{
		$this->_checkFileIdentity();
		return (int)$_FILES[$this->id]['size'];
	}

	/**
	 * Checks if file identity exists
	 * @throws Exception
	 * @return void
	 */
	protected function _checkFileIdentity ()
	{
		if (!isset($_FILES[$this->id])) {
			throw new Exception('File by identity does not exists');
		}

		if (empty($_FILES[$this->id]['size'])) {
			throw new Exception('Empty file element');
		}
	}
}