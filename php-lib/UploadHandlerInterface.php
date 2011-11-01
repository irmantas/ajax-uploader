<?php
/*
 * This file is part of is-ajax-upload package
 * (c) Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

/**
 * Interface of upload handlers
 * @author Irmantas Šiupšinskas <i.siupsinskas@gmail.com>
 */

interface UploadHandlerInterface
{
	public function save ($path);
	public function setFileIdentity($id);
	public function getName();
	public function getSize();
}