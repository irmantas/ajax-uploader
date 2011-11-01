<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


file_put_contents('log.txt',print_r($_FILES, 1).print_r($_POST, 1).print_r($_GET, 1));

require 'php-lib/Uploader.php';

if (isset($_GET['file'])) {
	require 'php-lib/UploadHandlerXhr.php';
	$handler = new UploadHandlerXhr;
} else {
	require 'php-lib/UploadHandlerForm.php';
	$handler = new UploadHandlerForm;
}
$handler->setFileIdentity('file');
$uploader = new Uploader($handler);
$uploader->setUploadDir(dirname(__FILE__).'/upload/');
if (!$uploader->handleUpload()) {
	if ($uploader->hasErrors()) {
		$errors = $uploader->getErrors();
	} else {
		$errors = array('Unknown error');
	}

	echo json_encode(array('errors' => $errors));
} else {
	echo json_encode(array('success' => true));
}