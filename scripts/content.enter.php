<?php
	require_once($_PATH_SCR . '/core.db.php');
	function parseEnter()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.enter.tpl');
		if(isset($_POST['login']) && isset($_POST['password']))
		{
			auth_enter($_POST['login'], $_POST['password']);
			$sessionId = session_id();
			$session = session_info($sessionId);
			if(is_null($session['customerId']))
			{
				$tpl->Parse('content.enter.fault');
			}
			else
			{
				$tpl->Parse('content.enter.success');
			}
		}
		else
		{
			$tpl->Parse('content.enter.fault');
		}
		$tpl->Parse('content.enter');
	}
	parseEnter();
?>