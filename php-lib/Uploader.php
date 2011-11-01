<?php
/*
 * This file is part of is-ajax-upload package
 * (c) Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

/**
 * Uploader
 * @author Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */
require_once 'UploadHandlerInterface.php';
class Uploader
{
	protected $_allowedExtensions = array();
	protected $_minSize = 10240;
	protected $_maxSize = 5242880;
	protected $_uploadDir = null;

	private $_handler;

	protected $_errors = array();

	public function __construct (UploadHandlerInterface $handler)
	{
		$this->_handler = $handler;
	}

	public function setMinSize ($size)
	{
		$size = (int)$size;
		if ($size < 0) {
			throw new Exception('Size cannot be negative value');
		}
		$this->_minSize = $size;
		return $this;
	}

	public function setMaxSize ($size)
	{
		$size = (int)$size;
		if ($size < 0) {
			throw new Exception('Size cannot be negative value');
		}
		$this->_maxSize = $size;
		return $this;
	}

	public function setUploadDir ($path)
	{
		$this->_uploadDir = $path;
		return $this;
	}

	public function setError ($error)
	{
		$this->_errors[] = $error;
		return $this;
	}

	public function getErrors ()
	{
		return $this->_errors;
	}

	public function hasErrors ()
	{
		return !empty($this->_errors);
	}

	public function handleUpload ()
	{
		if (empty($this->_uploadDir)) {
			$this->setError('Upload dir is not set');
		}
		if (!is_writable($this->_uploadDir)) {
			$this->setError('Upload directory is not writeable');
		}

		$size = $this->_handler->getSize();
		if ($size == 0) {
			$this->setError('File is empty');
		}

		if ($size > $this->_maxSize) {
			$this->setError('File is too large');
		}

		if (!$this->hasErrors()) {
			$pathinfo = pathinfo($this->_handler->getName());
			$filename = $pathinfo['filename'];
			$ext = strtolower($pathinfo['extension']);

			if (!empty($this->_allowedExtensions) && !in_array($ext, $this->_allowedExtensions)) {
				$this->setError('File has an invalid extension');
				return false;
			}

			if ($this->_handler->save($this->_uploadDir . $filename . '.' . $ext)){
				return true;
			}

			$this->setError('Upload error');
		}

		return false;
	}
}