<?php
	function getPageNumber()
	{
		if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 1)
		{
			return $_GET['page'];
		}
		else
		{
			return 1;
		}
	}
	function parsePager($itemCount, $pageSize, $pageNumber, $baseUri)
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.pager.tpl');
		$itemFirst = min(($pageNumber - 1) * $pageSize + 1, $itemCount);
		$itemLast = min($pageSize * $pageNumber, $itemCount);
		$pageCount = ceil ($itemCount / $pageSize);
		$pagerSize = 10;
		$pagerPageNumber = ceil($pageNumber / $pagerSize);
		$pagerBack = ($pagerPageNumber - 1) * $pagerSize;
		$pagerForward = $pagerPageNumber * $pagerSize + 1;
		$pager = array
		(
			'baseUri' => $baseUri
			, 'itemCount' => $itemCount
			, 'itemFirst' => $itemFirst
			, 'itemLast' => $itemLast
			, 'pagerBack' => $pagerBack
			, 'pagerForward' => $pagerForward
		);
		$tpl->Assign('pager', $pager);
		if ($pageCount > 1)
		{
			if ($pagerBack > 0)
			{
				$tpl->Parse('content.pager.back');
			}
			for ($i = 1; $i <= $pagerSize; $i++)
			{
				$page = $pagerBack + $i;
				if ($page > $pageCount)
					break;
				$tpl->Assign('page', $page);
				if ($page == $pageNumber)
				{
					$tpl->Parse('content.pager.page.selected');
				}
				else
				{
					$tpl->Parse('content.pager.page.normal');
				}
				$tpl->Parse('content.pager.page');
			}
			if ($pagerForward < $pageCount)
			{
				$tpl->Parse('content.pager.forward');
			}
			$tpl->Parse('content.pager.pages');
		}
		$tpl->Parse('content.pager.info');
		$tpl->Parse('content.pager');
	}
?>