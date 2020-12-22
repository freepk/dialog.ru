<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.classification.inc.php');
	function parseClsRoot()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.classification.tpl');
		parseClsGroups('root', 0);
		$tpl->Parse('content.classification');
	}
	parseClsRoot();
?>