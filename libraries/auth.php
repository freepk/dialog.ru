<?php
	function auth_customer($login, $password)
	{
		global $db;
		$query = 'SELECT CustomerID, Login, Password, FullName, Phone, Address, Email, Comment
			FROM tblCustomers
			WHERE Login = ? AND Password = ?;';
		$stmt = $db->prepare($query);
		$md5_password = md5($password);
		$stmt->bind_param('ss', $login, $md5_password);
		$stmt->execute();
		$stmt->bind_result($customerId, $login, $password, $fullName, $phone, $address, $email, $comment);
		$result = false;
		if($stmt->fetch())
		{
			$result = array('customerId' => $customerId, 'login' => $login, 'password' => $password
				, 'fullName' => $fullName, 'phone' => $phone, 'address' => $address, 'email' => $email, 'comment' => $comment);
		}
		return $result;
	}
	function auth_enter($login, $password)
	{
		global $db;
		session_init();
		$sessionId = session_id();
		$session = session_info($sessionId);
		if(is_null($session['customerId']))
		{
			$customer = auth_customer($login, $password);
			if($customer == false){}
			else
			{
				$query = 'UPDATE tblSessions SET CustomerID = ? WHERE SessionID = ?;';
				$stmt = $db->prepare($query);
				$stmt->bind_param('is', $customer['customerId'], $sessionId);
				$stmt->execute();
				$stmt->close();
			}
		}
		else
		{
			$customer = auth_customer($login, $password);
			if($customer == false){}
			else
			{
				//if($login['customerId'] != $session['customerId'])
				if($customer['customerId'] != $session['customerId'])
				{
					$query = 'UPDATE tblSessions SET CustomerID = ? WHERE SessionID = ?;';
					$stmt = $db->prepare($query);
					$stmt->bind_param('is', $customer['customerId'], $sessionId);
					$stmt->execute();
					$stmt->close();
				}
			}
		}
	}
	function auth_exit()
	{
		global $db;
		session_init();
		$sessionId = session_id();
		$session = session_info($sessionId);
		if(is_null($session['customerId']) == false)
		{
			$query = 'UPDATE tblSessions SET CustomerID = NULL WHERE SessionID = ?;';
			$stmt = $db->prepare($query);
			$stmt->bind_param('s', $sessionId);
			$stmt->execute();
			$stmt->close();
		}
	}
?>
