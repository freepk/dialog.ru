<?php
	require_once($_PATH_SCR . '/core.db.php');
	function parseVacancy()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.vacancy.tpl');
		$tpl->Parse('content.vacancy');
	}
	parseVacancy();
?>