<?php
	require_once($_PATH_SCR . '/core.db.php');
	function parseExit()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.exit.tpl');
		auth_exit();
		$sessionId = session_id();
		$session = session_info($sessionId);
		if(is_null($session['customerId']))
		{
			$tpl->Parse('content.exit.success');
		}
		else
		{
			$tpl->Parse('content.exit.fault');
		}
		$tpl->Parse('content.exit');
	}
	parseExit();
?>