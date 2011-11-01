<?php
/*
 * This file is part of is-ajax-upload package
 * (c) Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

/**
 * Abstraction of upload handlers
 * @author Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */
require_once 'UploadHandlerInterface.php';
abstract class UploadHandlerAbstract
{
	/**
	 * @var string file identity
	 */
	protected $id;
	
	/**
	 * Sets file identity
	 * @param string $id file identity
	 * @return void
	 */
	public function setFileIdentity ($id)
	{
		if (empty($id)) {
			throw new Exception('Provided empty file identity');
		}
		$this->id = $id;
	}

	/**
	 * Handler constructor
	 * @param string $id file identity
	 * @return void
	 */
	public function __construct ($id = null) {
		if (!is_null($id)) {
			$this->setFileIdentity($id);
		}
	}
}