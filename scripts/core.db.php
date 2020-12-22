<?php
	$db = new mysqli('localhost', 'root', 'just@some.useless', 'dialog.ru');
	if ($db->connect_error)
	{
		die('Connect Error (' . $db->connect_errno . ') ' . $db->connect_error);
	}
?>
