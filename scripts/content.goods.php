<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.classification.inc.php');
	require_once($_PATH_SCR . '/content.pager.inc.php');
	require_once($_PATH_SCR . '/content.goods.inc.php');
	function parseGoodsHeader()
	{
		global $tpl, $_PATH_TPL;
		switch($_GET['filter'])
		{
			case 'class':
			case 'group':
			case 'subgroup':
				parseClsGroups($_GET['filter'], $_GET['value']);
				break;
			case 'keyword':
				break;
		}
		$tpl->Parse('content.goods.filter');
	}
	function parseGoodsList()
	{
		global $tpl, $_PATH_TPL;
		$pageSize = 20;
		$pageNumber = getPageNumber();
		switch($_GET['filter'])
		{
			case 'class':
			case 'group':
			case 'subgroup':
				$goods = getGoodsByGroup($_GET['filter'], $_GET['value'], $pageSize, $pageNumber);
				$baseUri = '?page=';
				break;
			case 'keyword':
				$goods = getGoodsByKeyword($_GET['value'], $pageSize, $pageNumber);
				$baseUri = '/?action=goods&amp;filter=' . $_GET['filter'] . '&amp;value=' . urlencode($_GET['value']) . '&amp;page=';
				break;
		}
		$itemCount = $goods['count'];
		parsePager($itemCount, $pageSize, $pageNumber, $baseUri);
		$tpl->Load($_PATH_TPL . '/content.goods.list.tpl');
		if ($goods['count'] > 0)
		{
			$i = 0;
			foreach($goods['list'] as $item)
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
				$item['urlTitle'] = url_title($item['drugTitle']);
				$tpl->Assign('goods', $item);
				if ($item['hasImage'] && $item['isImageUploaded'] == 1)
				{
					$tpl->Parse('content.goods.list.item.image.normal');
				}
				else
				{
					$tpl->Parse('content.goods.list.item.image.empty');
				}
				$tpl->Parse('content.goods.list.item.image');
				$tpl->Parse('content.goods.list.item');
			}
			$tpl->Parse('content.goods.list');
		}
	}
	function parseGoods()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.goods.tpl');
		if(isset($_GET['filter']) && isset($_GET['value']))
		{
			parseGoodsHeader();
			parseGoodsList();
		}
		$tpl->Parse('content.goods');
	}
	parseGoods();
?>