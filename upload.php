<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


file_put_contents('log.txt',print_r($_FILES, 1).print_r($_POST, 1).print_r($_GET, 1));