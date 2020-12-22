<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.customer.inc.php');
	function parseLeftAuth()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/left.auth.tpl');
		$sessionId = session_id();
		if($sessionId == '')
		{
			session_init();
			$sessionId = session_id();
		}
		$session = session_info($sessionId);
		if(is_null($session['customerId']))
		{
			$tpl->Parse('left.auth.enter');
		}
		else
		{
			$customer = selectCustomer($session['customerId']);
			$tpl->Assign('customer', $customer);
			$tpl->Parse('left.auth.exit');
		}
		$tpl->Parse('left.auth');
	}
	parseLeftAuth();
?>