<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.customer.inc.php');
	function checkRegisterCustomer()
	{
		$result['login']	= validateCustomerLoginR();
		$result['password']	= validateCustomerPasswordR();
		$result['fullName']	= validateCustomerFullNameR();
		$result['phone']	= validateCustomerPhoneR();
		$result['address']	= validateCustomerAddress();
		$result['comment']	= validateCustomerComment();
		return $result;
	}
	function finishRegister($params)
	{
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
			registerCustomer($params['login']['value'], $params['password']['value'], $params['fullName']['value']
				, $params['phone']['value'], $params['address']['value'], $params['comment']['value']);
			auth_enter($params['login']['value'], $params['password']['value']);
		}
		return $errors;
	}
	function parseRegisterForm($params = null, $errors = null)
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.customer.tpl');
		$tpl->Load($_PATH_TPL . '/content.customer.form.tpl');
		if(is_array($errors) && count($errors) > 0)
		{
			foreach($errors as $error)
			{
				$tpl->Assign('error', $error);
				$tpl->Parse('content.customer.errors.error');
			}
			$tpl->Parse('content.customer.errors');
		}
		$tpl->Assign('params', $params);
		$tpl->Parse('content.customer.form');
		$tpl->Parse('content.customer');
	}
	function parseRegisterSuccess()
	{
		global $tpl;
		$tpl->Parse('content.registration.success');
	}
	function parseRegister()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.register.tpl');
		if(isset($_POST['event']))
		{
			if($_POST['event'] == 'finish')
			{
				$params = checkRegisterCustomer();
				$errors = finishRegister($params);
				if(count($errors) > 0)
				{
					$params = array('login' => $params['login']['value'], 'password' => $params['password']['value'], 'fullName' => $params['fullName']['value']
						, 'phone' => $params['phone']['value'], 'address' => $params['address']['value'], 'comment' => $params['comment']['value']);
					parseRegisterForm($params, $errors);
				}
				else
				{
					parseRegisterSuccess();
				}
			}
			else
			{
				parseRegisterForm();
			}
		}
		else
		{
			parseRegisterForm();
		}
		$tpl->Parse('content.register');
	}
	parseRegister();
?>