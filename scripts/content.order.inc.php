<?php
	function selectOrder($orderId)
	{
		global $db;
		$minimalOrder = '900.00';
		$deliveryCost = '90.00';
		$query = 'SELECT o.OrderID, o.CustomerID, o.OrderDateTime, o.IsFinished, o.IsDownloaded
				, IFNULL(SUM(oi.DrugCount * oi.DrugCost), 0) + CASE WHEN IFNULL(SUM(oi.DrugCount * oi.DrugCost), 0) <= ' . $minimalOrder . ' THEN ' . $deliveryCost .  ' ELSE 0 END AS Summary
				, CASE WHEN IFNULL(SUM(oi.DrugCount * oi.DrugCost), 0) <= ' . $minimalOrder . ' THEN ' . $deliveryCost .  ' ELSE 0 END AS Delivery
			FROM tblOrders AS o
			LEFT JOIN tblOrderItems as oi ON oi.OrderID = o.OrderID
			WHERE o.OrderID = ? AND o.IsFinished = 0 AND o.IsDownloaded = 0
			GROUP BY o.OrderID, o.CustomerID, o.IsFinished, o.IsDownloaded;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $orderId);
		$stmt->execute();
		$stmt->bind_result($orderId, $customerId, $orderDateTime, $isFinished, $isDownloaded, $summary, $delivery);
		$result = false;
		if ($stmt->fetch())
		{
			$result = array('orderId' => $orderId, 'customerId' => $customerId, 'orderDateTime' => $orderDateTime
				, 'isFinished' => $isFinished, 'isDownloaded' => $isDownloaded
				, 'summary' => $summary, 'delivery' => $delivery);
		}
		$stmt->close();
		return $result;
	}
	function insertOrder($sessionId)
	{
		global $db;
		$query = 'INSERT INTO tblOrders (CustomerID, OrderDateTime, IsFinished, IsDownloaded)
			VALUES (NULL,NOW(),0,0);';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$orderId = $stmt->insert_id;
		$stmt->close();
		$query = 'UPDATE tblSessions
			SET OrderID = ?
			WHERE SessionID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('is', $orderId, $sessionId);
		$stmt->execute();
		$stmt->close();
		return $orderId;
	}
	function selectOrderItem($orderId, $goodsId)
	{
		global $db;
		$query = 'SELECT OrderItemID, OrderID, GoodsID, DrugCount, DrugCost
			FROM tblOrderItems
			WHERE OrderID = ? AND GoodsID = ?
			LIMIT 0, 1;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $orderId, $goodsId);
		$stmt->execute();
		$stmt->bind_result($orderItemId, $orderId, $goodsId, $drugCount, $drugCost);
		$result = false;
		if($stmt->fetch())
		{
			$result = array('orderItemId' => $orderItemId, 'orderId' => $orderId, 'goodsId' => $goodsId, 'drugCount' => $drugCount, 'drugCost' => $drugCost);
		}
		$stmt->close();
		return $result;
	}
	function insertOrderItem($orderId, $goodsId, $drugCount)
	{
		global $db;
		$query = 'SELECT DrugCost FROM tblGoods WHERE GoodsID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $goodsId);
		$stmt->execute();
		$stmt->bind_result($drugCost);
		$stmt->fetch();
		$stmt->close();
		$query = 'INSERT INTO tblOrderItems (OrderID, GoodsID, DrugCount, DrugCost)
			VALUES (?, ?, ?, ?);';
		$stmt = $db->prepare($query);
		$stmt->bind_param('iiid', $orderId, $goodsId, $drugCount, $drugCost);
		$stmt->execute();
		$stmt->close();
	}
	function updateOrderItem($orderId, $goodsId, $drugCount)
	{
		global $db;
		$query = 'UPDATE tblOrderItems AS oi INNER JOIN tblGoods AS g ON g.GoodsID = oi.GoodsID
			SET oi.DrugCount = ?, oi.DrugCost = g.DrugCost
			WHERE oi.OrderID = ? AND oi.GoodsID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('iii', $drugCount, $orderId, $goodsId);
		$stmt->execute();
		$stmt->close();
	}
	function deleteOrderItem($orderId, $goodsId)
	{
		global $db;
		$query = 'DELETE FROM tblOrderItems WHERE OrderID = ? AND GoodsID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $orderId, $goodsId);
		$stmt->execute();
		$stmt->close();
	}
	function selectOrderItems($orderId)
	{
		global $db;
		$query = 'SELECT g.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, oi.DrugCount, oi.DrugCost, oi.DrugCount * oi.DrugCost AS Summary
				, CASE WHEN ISNULL(rl.GoodsID) THEN \'0\' ELSE CONCAT(CAST(cl.ClsClassID AS CHAR), \'/\', CAST(gr.ClsGroupID AS CHAR), \'/\', CAST(sg.ClsSubGroupID AS CHAR)) END AS UrlPath
			FROM tblOrderItems as oi
			INNER JOIN tblGoods AS g ON g.GoodsID = oi.GoodsID
			INNER JOIN tblDrugs AS d ON d.DrugID = g.DrugID
			INNER JOIN tblOutForms AS o ON o.OutFormID = g.OutFormID
			INNER JOIN tblMakers AS m ON m.MakerID = g.MakerID
				LEFT JOIN tblDvrClsRel AS rl ON rl.GoodsID = oi.GoodsID
				LEFT JOIN tblDvrClsSubGroups AS sg ON sg.ClsSubGroupID = rl.ClsSubGroupID
				LEFT JOIN tblDvrClsGroups AS gr ON gr.ClsGroupID = sg.ClsGroupID
				LEFT JOIN tblDvrClsClasses AS cl ON cl.ClsClassID = gr.ClsClassID
			WHERE oi.OrderID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $orderId);
		$stmt->execute();
		$stmt->bind_result($goodsId, $drugTitle, $outFormTitle, $makerTitle, $drugCount, $drugCost, $summary, $urlPath);
		$result = array();
		while($stmt->fetch())
		{
			$result[] = array('goodsId' => $goodsId, 'drugTitle' => $drugTitle, 'outFormTitle' => $outFormTitle
				, 'makerTitle' => $makerTitle, 'drugCount' => $drugCount, 'drugCost' => $drugCost, 'summary' => $summary, 'urlPath' => $urlPath);
		}
		return $result;
		$stmt->close();
	}
?>
