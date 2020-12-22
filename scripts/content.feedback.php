<?php
	require_once($_PATH_SCR . '/core.db.php');
	function validateFullName()
	{
		$result = array('valid' => false, 'value' => null, 'error' => 'Фамилия Имя Отчество не указаны');
		if(isset($_POST['fullName']) && strlen($_POST['fullName']) > 0)
		{
			$result = array('valid' => true, 'value' => $_POST['fullName'], 'error' => null);
		}
		return $result;
	}
	function validateEmail()
	{
		global $db;
		$result = array('valid' => false, 'value' => null, 'error' => 'E-Mail не указан');
		if(isset($_POST['email']) && strlen($_POST['email']) > 0)
		{
			if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $_POST['email']))
			{
				$result = array('valid' => true, 'value' => $_POST['email'], 'error' => null);
			}
			else
			{
				$result['error'] = 'E-Mail ' . $_POST['email'] . ' не похож на почтовый адрес';
			}
		}
		return $result;
	}
	function validateMessage()
	{
		$result = array('valid' => false, 'value' => null, 'error' => 'Вы не ввели сообщение');
		if(isset($_POST['message']) && strlen($_POST['message']) > 0)
		{
			$result = array('valid' => true, 'value' => $_POST['message'], 'error' => null);
		}
		return $result;
	}
	function parseFeedBack()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.feedback.tpl');
		if (isset($_POST['event']) && $_POST['event'] == 'finish')
		{
			$params = array(
				'fullName' => validateFullName(),
				'email' => validateEmail(),
				'message' => validateMessage()
			);
			$hasErrors = 0;
			foreach ($params as $param)
			{
				if ($param['valid'] == false)
				{
					$hasErrors++;
					$tpl->Assign('error', $param['error']);
					$tpl->Parse('content.feedback.compose.errors.error');
				}
			}
			if ($hasErrors > 0)
			{
				$tpl->Assign('params', $params);
				$tpl->Parse('content.feedback.compose.errors');
				$tpl->Parse('content.feedback.compose.form');
				$tpl->Parse('content.feedback.compose');
			}
			else
			{
				$recipients = 'a.pyshnyak@gmail.com, akm@rambler.ru, apteka@dialog.ru, ov@dialog.ru, 5188825@mail.ru, sadmin@vitta.ru';
				$subject = 'Отзыв с сайта dialog.ru от ' . $params['fullName']['value'];
				$headers = 'From: noreply@dialog.ru' . "\r\n"
				. 'Reply-To:' . $params['email']['value'] . "\r\n"
				. 'Content-Type: text/plain; charset=windows-1251' . "\r\n"
				. 'X-Mailer: PHP/' . phpversion();
				$success = mail($recipients, $subject, $params['message']['value'] , $headers);
				if ($success)
				{
					$tpl->Parse('content.feedback.success');
				}
				else
				{
					$tpl->Parse('content.feedback.fault');
				}
			}
		}
		else
		{
			$tpl->Parse('content.feedback.compose.form');
			$tpl->Parse('content.feedback.compose');
		}
		$tpl->Parse('content.feedback');
	}
	parseFeedBack();
?>
