<?php
	function session_open($sessionId)
	{
		global $db;
		$query = 'INSERT INTO tblSessions (SessionID, SessionDateTime, OrderID, CustomerID)
			VALUES (?, NOW(), NULL, NULL);';
		$stmt = $db->prepare($query);
		$stmt->bind_param('s', $sessionId);
		$stmt->execute();
		$stmt->close();
	}
	function session_close($sessionId)
	{
		global $db;
		$query = 'DELETE FROM tblSessions
			WHERE SessionID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('s', $sessionId);
		$stmt->execute();
		$stmt->close();
	}
	function session_info($sessionId)
	{
		global $db;
		$query = 'SELECT SessionID, SessionDateTime, OrderID, CustomerID
			FROM tblSessions
			WHERE SessionID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('s', $sessionId);
		$stmt->execute();
		$stmt->bind_result($sessionId, $sessionDateTime, $orderId, $customerId);
		$result = false;
		if($stmt->fetch())
		{
			$result = array('sessionId' => $sessionId, 'sessionDateTime' => $sessionDateTime, 'orderId' => $orderId, 'customerId' => $customerId);
		}
		return $result;
	}
	function session_init($regenerate_session_id = false)
	{
		$sessionId = session_id();
		if($sessionId > '')
		{
			if($regenerate_session_id == true)
			{
				session_close($sessionId);
				session_regenerate_id(true);
				$sessionId = session_id();
				session_open($sessionId);
			}
		}
		else
		{
			session_start();
			$sessionId = session_id();
			$session = session_info($sessionId);
			if($session == false)
			{
				session_open($sessionId);
			}
		}
		$_SESSION['lastUpdate'] = microtime();
		session_commit();
		session_start();
	}
?>
