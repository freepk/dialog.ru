<?php
	require_once ($_PATH_SCR . '/core.db.php');
	require_once ($_PATH_SCR . '/content.order.inc.php');
	function parseOrderShort()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/left.order.short.tpl');
		$sessionId = session_id();
		if($sessionId == '')
		{
			session_init();
			$sessionId = session_id();
		}
		$session = session_info($sessionId);
		if(is_null($session['orderId']))
		{
			$tpl->Parse('left.order.short.empty');
		}
		else
		{
			$orderItems = selectOrderItems($session['orderId']);
			if (count($orderItems) > 0)
			{
				foreach ($orderItems as $orderItem)
				{
					$orderItem['urlTitle'] = url_title($orderItem['drugTitle']);
					if (strlen($orderItem['drugTitle']) > 16)
						$orderItem['drugTitle'] = substr($orderItem['drugTitle'], 0, 15) . '...';
					$tpl->Assign('orderItem', $orderItem);
					$tpl->Parse('left.order.short.normal.orderItem');
				}
				$order = selectOrder($session['orderId']);
				$tpl->Assign('order', $order);
				if($order['delivery'] > 0)
				{
					$tpl->Parse('left.order.short.normal.delivery');
				}
				$tpl->Parse('left.order.short.normal');
			}
			else
			{
				$tpl->Parse('left.order.short.empty');
			}
		}
		$tpl->Parse('left.order.short');
	}
	parseOrderShort();
?>