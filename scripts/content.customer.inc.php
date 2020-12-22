<?php
	function validateCustomerLoginR()
	{
		global $db;
		$result = array('valid' => false, 'value' => null, 'error' => 'E-Mail не указан');
		if(isset($_POST['login']) && strlen($_POST['login']) > 0)
		{
			if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i', $_POST['login']))
			{
				$query = 'SELECT COUNT(*) AS LoginExists FROM tblCustomers WHERE Login = ?;';
				$stmt = $db->prepare($query);
				$stmt->bind_param('s', $_POST['login']);
				$stmt->execute();
				$stmt->bind_result($loginExists);
				$stmt->fetch();
				$stmt->close();
				if($loginExists == 0)
				{
					$result = array('valid' => true, 'value' => $_POST['login'], 'error' => null);
				}
				else
				{
					$result['error'] = 'E-Mail ' . $_POST['login'] . ' уже существует';
				}
			}
			else
			{
				$result['error'] = 'E-Mail ' . $_POST['login'] . ' не похож на почтовый адрес';
			}
		}
		return $result;
	}
	function validateCustomerPasswordR()
	{
		$result = array('valid' => false, 'value' => null, 'error' => 'Пароль не указан');
		if(isset($_POST['password']) && strlen($_POST['password']) > 0)
		{
			if(strlen($_POST['password']) >= 6)
			{
				$result = array('valid' => true, 'value' => $_POST['password'], 'error' => null);
			}
			else
			{
				$result['error'] = 'Длина пароля меньше шести символов';
			}
		}
		return $result;
	}
	function validateCustomerFullName()
	{
		$result = array('valid' => true, 'value' => '', 'error' => null);
		if(isset($_POST['fullName']))
		{
			$result['value'] = $_POST['fullName'];
		}
		return $result;		
	}
	function validateCustomerFullNameR()
	{
		$result = array('valid' => false, 'value' => null, 'error' => 'Фамилия Имя Отчество не указаны');
		if(isset($_POST['fullName']) && strlen($_POST['fullName']) > 0)
		{
			$result = array('valid' => true, 'value' => $_POST['fullName'], 'error' => null);
		}
		return $result;
	}
	function validateCustomerPhoneR()
	{
		$result = array('valid' => false, 'value' => null, 'error' => 'Телефон не указан');
		if(isset($_POST['phone']) && strlen($_POST['phone']) > 0)
		{
			$phone = preg_replace('/[\D]+/', '', $_POST['phone']);
			if(strlen($phone) == 7)
			{
					$phone = '495' . $phone;
			}
			else if(strlen($phone) == 11 && ($phone{0} == '8' || $phone{0} == '7'))
			{
				$phone = substr($phone, 1);
			}
			if (strlen($phone) == 10)
			{
				$result = array('valid' => true, 'value' => $phone, 'error' => null);
			}
			else
			{
				$result['error'] = 'Телефон указан не правильно';
			}
		}
		return $result;
	}
	function validateCustomerAddress()
	{
		$result = array('valid' => true, 'value' => '', 'error' => null);
		if(isset($_POST['address']))
		{
			$result['value'] = $_POST['address'];
		}
		return $result;
	}
	function validateCustomerComment()
	{
		$result = array('valid' => true, 'value' => '', 'error' => null);
		if(isset($_POST['comment']))
		{
			$result['value'] = $_POST['comment'];
		}
		return $result;
	}
	function insertCustomer($login, $password, $fullName, $phone, $address, $email, $comment)
	{
		global $db;
		$query = 'INSERT INTO tblCustomers (Login, Password, FullName, Phone, Address, EMail, Comment)
			VALUES (?, ?, ?, ?, ?, ?, ?);';
		$stmt = $db->prepare($query);
		$md5_password = md5($password);
		$stmt->bind_param('sssssss', $login, $md5_password, $fullName, $phone, $address, $email, $comment);
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		return $result;
	}
	function registerCustomer($login, $password, $fullName, $phone, $address, $comment)
	{
		return insertCustomer($login, $password, $fullName, $phone, $address, $login, $comment);
	}
	function anonymousCustomer($fullName, $phone, $address, $email, $comment)
	{
		return insertCustomer(null, null, $fullName, $phone, $address, $email, $comment);
	}
	function selectCustomer($customerId)
	{
		global $db;
		$query = 'SELECT CustomerID, Login, Password, FullName, Phone, Address, Email, Comment
			FROM tblCustomers
			WHERE CustomerID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $customerId);
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
?>
