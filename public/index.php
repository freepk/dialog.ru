<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../scripts/core.config.php');
	require_once($_PATH_LIB . '/tpl.php');
	require_once($_PATH_LIB . '/session.php');
	require_once($_PATH_LIB . '/auth.php');
	require_once($_PATH_LIB . '/misc.php');
	$startTime = getMicroTime();
	$tpl = new Template();
	$tpl->Load($_PATH_TPL . '/main.tpl');
	$tpl->Load($_PATH_TPL . '/main.top.tpl');
	$tpl->Load($_PATH_TPL . '/main.left.tpl');
	$tpl->Load($_PATH_TPL . '/main.content.tpl');
	$tpl->Load($_PATH_TPL . '/main.right.tpl');
	if(isset($_GET['action']))
	{
		switch($_GET['action'])
		{
			case 'goods':
				require_once($_PATH_SCR . '/content.goods.php');
				break;
			case 'order':
				require_once($_PATH_SCR . '/content.order.php');
				break;
			case 'info':
				require_once($_PATH_SCR . '/content.info.php');
				break;
			case 'info2':
				require_once($_PATH_SCR . '/content.info2.php');
				break;
			case 'register':
				require_once($_PATH_SCR . '/content.register.php');
				break;
			case 'enter':
				require_once($_PATH_SCR . '/content.enter.php');
				break;
			case 'exit':
				require_once($_PATH_SCR . '/content.exit.php');
				break;
			case 'about':
				require_once($_PATH_SCR . '/content.about.php');
				break;
			case 'delivery':
				require_once($_PATH_SCR . '/content.delivery.php');
				break;
			case 'vacancy':
				require_once($_PATH_SCR . '/content.vacancy.php');
				break;
			case 'filials':
				require_once($_PATH_SCR . '/content.filials.php');
				break;
			case 'feedback':
				require_once($_PATH_SCR . '/content.feedback.php');
				break;
			default:
				require_once($_PATH_SCR . '/content.classification.php');
				break;
		}
	}
	else
	{
		require_once($_PATH_SCR . '/content.classification.php');
	}
	require_once($_PATH_SCR . '/content.path.php');	
	require_once($_PATH_SCR . '/left.order.short.php');	
	require_once($_PATH_SCR . '/left.auth.php');
	$tpl->Parse('main.top');
	$tpl->Parse('main.left');
	$tpl->Parse('main.content');
	$tpl->Parse('main.right');
	$tpl->Parse('main');
	$contentDelay = getMicroTime() - $startTime;
	ob_start();
	$tpl->Out('main');
	$out = ob_get_clean();
	$tdh = new Tidy();
	$tdh->parseString($out, array ('indent' => true, 'output-xhtml' => true, 'wrap' => 0), 'raw');
	$validateDelay = getMicroTime() - $startTime - $contentDelay;
	echo $tdh;
	echo "\r\n" . '<!-- Proccess content in ' . $contentDelay . ' seconds -->';
	echo "\r\n" . '<!-- Validate content in ' . $validateDelay . ' seconds -->';
	echo "\r\n" . '<!-- Did all in ' . (getMicroTime() - $startTime) . ' seconds -->';
	echo "\r\n" . '<!-- Errors ' . $tdh->errorBuffer . '-->';
?>
