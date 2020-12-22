<?php
	$_PATH_PUB = $_SERVER['DOCUMENT_ROOT'];
	$_PATH_LIB = $_PATH_PUB . '/../libraries';
	$_PATH_TPL = $_PATH_PUB . '/../templates';
	$_PATH_SCR = $_PATH_PUB . '/../scripts';
	$_PATH_SES = $_PATH_PUB . '/../sessions';
	session_save_path($_PATH_SES);
?>