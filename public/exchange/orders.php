<?php
	header('Content-Type: text/xml;');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../scripts/core.config.php');
	require_once($_PATH_LIB . '/misc.php');
	require_once($_PATH_SCR . '/core.db.php');
	function getXml()
	{
		$orders = getOrders();
		$sxeRoot = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes"?><root />');
		$sxeCustomers = $sxeRoot->addChild('customers');
		if(isset($orders['customers']) && is_array($orders['customers']))
		{
			foreach($orders['customers'] as $customerId => $customer)
			{
				$sxeCustomer = $sxeCustomers->addChild('customer');
				$sxeCustomer->addAttribute('customerId', $customerId);
				$sxeCustomer->addAttribute('customerName', w2u($customer['fullName']));
				$sxeCustomer->addAttribute('phone', w2u($customer['phone']));
				$sxeCustomer->addAttribute('address', w2u($customer['address']));
				$sxeCustomer->addAttribute('email', w2u($customer['email']));
				$sxeCustomer->addAttribute('comment', w2u($customer['comment']));
			}
		}
		$sxeOrders = $sxeRoot->addChild('orders');
 		if(isset($orders['orders']) && is_array($orders['orders']))
		{
			foreach($orders['orders'] as $orderId => $order)
			{
				$sxeOrder = $sxeOrders->addChild('order');
				$sxeOrder->addAttribute('orderId', $orderId);
				$sxeOrder->addAttribute('customerId', $order['customer']['customerId']);
				$sxeOrder->addAttribute('summary', $order['summary']);
				$sxeOrder->addAttribute('comment', w2u($order['comment']));
				if(isset($order['orderItems']) && is_array($order['orderItems']))
				{
					foreach($order['orderItems'] as $orderItemId => $orderItem)
					{
						$sxeOrderItem = $sxeOrder->addChild('orderItem');
						$sxeOrderItem->addAttribute('orderId', $orderId);
						$sxeOrderItem->addAttribute('orderItemId', $orderItemId);
						$sxeOrderItem->addAttribute('goodsId', $orderItem['goodsId']);
						$sxeOrderItem->addAttribute('drugCount', $orderItem['drugCount']);
						$sxeOrderItem->addAttribute('drugCost', $orderItem['drugCost']);
					}
				}
			}
		}
		return $sxeRoot->asXML();
	}
	function getOrders()
	{
		global $db;
		$query = 'SELECT o.OrderID, o.Comment, oi.OrderItemID, oi.GoodsID, oi.DrugCount, oi.DrugCost
				, c.CustomerID, c.FullName, c.Phone, c.Address, c.Email, c.Comment
			FROM tblOrders AS o
			INNER JOIN tblOrderItems AS oi ON oi.OrderID = o.OrderID
			INNER JOIN tblCustomers AS c ON c.CustomerID = o.CustomerID
			WHERE o.IsFinished = 1 AND o.IsDownloaded = 0;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($orderId, $ordComment, $orderItemId, $goodsId, $drugCount, $drugCost
			, $customerId, $fullName, $phone, $address, $email, $custComment);
		$stmt->store_result();
		$result = array();
		while ($stmt->fetch())
		{
			$result['customers'][$customerId] = array('customerId' => $customerId, 'fullName' => $fullName, 'phone' => '(' . substr($phone, 0, 3) . ')-' . substr($phone, 3, 7)
				, 'address' => $address, 'email' => $email, 'comment' => $custComment);
			$result['orders'][$orderId]['comment'] = $ordComment;
			$result['orders'][$orderId]['customer'] =& $result['customers'][$customerId];
			$result['orders'][$orderId]['orderItems'][$orderItemId] = array('orderItemId' => $orderItemId, 'goodsId' => $goodsId
				, 'drugCount' => $drugCount, 'drugCost' => $drugCost);
			if (isset($result['orders'][$orderId]['summary']))
			{
				$result['orders'][$orderId]['summary'] += $drugCount * $drugCost;
			}
			else
			{
				$result['orders'][$orderId]['summary'] = $drugCount * $drugCost;
			}
		}
		$stmt->free_result();
		return $result;
	}
	echo getXml();
?>
