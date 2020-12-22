<?php
	require_once($_PATH_SCR . '/core.db.php');
	function parseAbout()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.about.tpl');
		$tpl->Parse('content.about');
	}
	parseAbout();
?>