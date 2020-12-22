#!/usr/local/bin/php
<?php
	require_once('/usr/local/www/www.dialog.ru/scripts/core.db.php');
	function get_micro_time()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float) $usec + (float) $sec);
	}
	$query = 'update tblOrders set IsDownloaded = 1 where IsDownloaded = 0 and IsFinished = 1 and OrderDateTime < curdate() - interval 1 day';
	$stmt = $db->prepare($query);
	$stmt->execute();
	$exec_time = get_micro_time();
	echo "[$exec_time]\n";
?>
