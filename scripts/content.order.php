<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.order.inc.php');
	require_once($_PATH_SCR . '/content.customer.inc.php');
	function changeOrder($orderId)
	{
		if(isset($_POST['orderItems']) && is_array($_POST['orderItems']) && count($_POST['orderItems']) > 0)
		{
			foreach($_POST['orderItems'] as $goodsId => $orderItem)
			{
				if (isset($orderItem['deleteMe']) && $orderItem['deleteMe'] == true)
				{
					deleteOrderItem($orderId, $goodsId);
				}
				else if(isset($orderItem['drugCount']) && is_numeric($orderItem['drugCount']) && $orderItem['drugCount'] > 0)
				{
					$orderItemCurrent = selectOrderItem($orderId, $goodsId);
					if($orderItemCurrent == false)
					{
						insertOrderItem($orderId, $goodsId, $orderItem['drugCount']);
					}
					else
					{
						updateOrderItem($orderId, $goodsId, $orderItem['drugCount']);
					}
				}
			}
		}
	}
	function checkOrderCustomer($customerId)
	{
		$result['fullName'] = validateCustomerFullName();
		$result['phone'] = validateCustomerPhoneR();
		$result['address'] = validateCustomerAddress();
		$result['comment'] = validateCustomerComment();
		return $result;
	}
	function finishOrder($orderId, $customerId, $params)
	{
		global $db;
		$errors = array();
		foreach($params as $param)
		{
			if($param['valid'] == false)
			{
				$errors[] = $param['error'];
			}
		}
		if(count($errors) == 0)
		{
			if(is_null($customerId))
			{
				$customerId = anonymousCustomer($params['fullName']['value'], $params['phone']['value']
					, $params['address']['value'], '', $params['comment']['value']);
			}
			else
			{
				
			}
			$query = 'UPDATE tblOrders
				SET CustomerID = ?, Comment = ?, IsFinished = 1
				WHERE OrderID = ?;';
			$stmt = $db->prepare($query);
			$stmt->bind_param('isi', $customerId, $params['comment']['value'], $orderId);
			$stmt->execute();
			$stmt->close();
			$sessionId = session_id();
			$query = 'UPDATE tblSessions
				SET OrderID = NULL
				WHERE SessionID = ?;';
			$stmt = $db->prepare($query);
			$stmt->bind_param('s', $sessionId);
			$stmt->execute();
			$stmt->close();
		}
		return $errors;
	}
	function parseOrderForms($orderId, $customerId, $params = null, $errors = null)
	{
		global $tpl, $_PATH_TPL;
		if(is_null($orderId))
		{
			$tpl->Parse('content.order.empty');
		}
		else
		{
			$orderItems = selectOrderItems($orderId);
			if(count($orderItems) > 0)
			{
				$tpl->Load($_PATH_TPL . '/content.customer.tpl');
				$tpl->Load($_PATH_TPL . '/content.customer.form.o.tpl');
				if(is_array($errors) && count($errors) > 0)
				{
					foreach($errors as $error)
					{
						$tpl->Assign('error', $error);
						$tpl->Parse('content.customer.errors.error');
					}
					$tpl->Parse('content.customer.errors');
				}
				if(is_null($params) ==  false)
				{
					$tpl->Assign('params', $params);
				}
				else if(is_null($customerId) == false)
				{
					$customer = selectCustomer($customerId);
					$tpl->Assign('params', $customer);
				}
				$tpl->Parse('content.customer.form');
				$tpl->Parse('content.customer');
				$i = 0;
				foreach($orderItems as $orderItem)
				{
					$i++;
					if ($i % 2 == 0)
					{
						$tpl->Assign('evenOrOdd', 'even');
					}
					else
					{
						$tpl->Assign('evenOrOdd', 'odd');
					}
					$orderItem['urlTitle'] = url_title($orderItem['drugTitle']);
					$tpl->Assign('orderItem', $orderItem);
					$tpl->Parse('content.order.normal.orderItem');
				}
				$order = selectOrder($orderId);
				$tpl->Assign('order', $order);
				if($order['delivery'] > 0)
				{
					$tpl->Parse('content.order.normal.delivery');
				}
				$tpl->Parse('content.order.normal');
			}
			else
			{
				$tpl->Parse('content.order.empty');
			}
		}
	}
	function parseOrderSuccess()
	{
		global $tpl;
		$tpl->Parse('content.order.success');
	}
	function parseOrder()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.order.tpl');
		$sessionId = session_id();
		if($sessionId == '')
		{
			session_init();
			$sessionId = session_id();
		}
		$session = session_info($sessionId);
		if(is_null($session['orderId']))
		{
			insertOrder($sessionId);
			$session = session_info($sessionId);
		}
		if(isset($_POST['event']))
		{
			if($_POST['event'] == 'change')
			{
				changeOrder($session['orderId']);
				parseOrderForms($session['orderId'], $session['customerId']);
			}
			else if($_POST['event'] == 'finish')
			{
				$params = checkOrderCustomer($session['customerId']);
				$errors = finishOrder($session['orderId'], $session['customerId'], $params);
				if(count($errors) > 0)
				{
					$params = array('fullName' => $params['fullName']['value'], 'phone' => $params['phone']['value']
						, 'address' => $params['address']['value'], 'comment' => $params['comment']['value']);
					parseOrderForms($session['orderId'], $session['customerId'], $params, $errors);
				}
				else
				{
					parseOrderSuccess();
				}
			}
			else
			{
				parseOrderForms($session['orderId'], $session['customerId']);
			}
		}
		else
		{
			parseOrderForms($session['orderId'], $session['customerId']);
		}
		$tpl->Parse('content.order');
	}
	parseOrder();
?>
