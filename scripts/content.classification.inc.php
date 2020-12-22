<?php
	function calcDevider($rowsCount, $columnsCount)
	{
		if ($rowsCount % $columnsCount == 0)
		{
			return $rowsCount / $columnsCount;
		}
		else
		{
			return floor($rowsCount / $columnsCount) + 1;
		}
	}
	function calcClsGroupsSelect($groupType)
	{
		$result = array('SELECT');
		switch($groupType)
		{
			case 'class':
				array_push($result, 'c.ClsClassID AS ID, c.ClsClassTitle AS Title, 0 AS ParentID, c.Sequence
					, 0 AS Level, \'class\' AS Type, COUNT(DISTINCT r.GoodsID) AS GoodsCount
					, CAST(c.ClsClassID AS CHAR) AS UrlPath');
				break;
			case 'group':
				array_push($result, 'g.ClsGroupID AS ID, g.ClsGroupTitle AS Title, g.ClsClassID AS ParentID, g.Sequence
					, 1 AS Level, \'group\' AS Type, COUNT(DISTINCT r.GoodsID) AS GoodsCount
					, CONCAT(CAST(c.ClsClassID AS CHAR), \'/\', CAST(g.ClsGroupID AS CHAR)) AS UrlPath');
				break;
			case 'subgroup':
				array_push($result, 's.ClsSubGroupID AS ID, s.ClsSubGroupTitle AS Title, s.ClsGroupID AS ParentID, s.Sequence
					, 2 AS Level, \'subgroup\' AS Type, COUNT(DISTINCT r.GoodsID) AS GoodsCount
					, CONCAT(CAST(c.ClsClassID AS CHAR), \'/\', CAST(g.ClsGroupID AS CHAR), \'/\', CAST(s.ClsSubGroupID AS CHAR)) AS UrlPath');
				break;
		}
		return join("\n", $result);
	}
	function calcClsGroupsFrom($groupType)
	{
		$result = 'FROM tblDvrClsRel AS r
			INNER JOIN tblDvrClsSubGroups AS s ON s.ClsSubGroupID = r.ClsSubGroupID
			INNER JOIN tblDvrClsGroups AS g ON g.ClsGroupID = s.ClsGroupID
			INNER JOIN tblDvrClsClasses AS c ON c.ClsClassID = g.ClsClassID';
		return $result;
	}
	function calcClsGroupsQuery($groupType)
	{
		$groupBy = 'GROUP BY ID, Title, ParentID, Sequence, Level, Type';
		$orderBy = 'ORDER BY Level, CASE Level WHEN 0 THEN Sequence ELSE Title END';
		$result = '';
		switch($groupType)
		{
			case 'root':
				$result = array(
					calcClsGroupsSelect('class'), calcClsGroupsFrom('class'), 'WHERE 0 = ?', $groupBy
					, 'UNION ALL'
					, calcClsGroupsSelect('group'), calcClsGroupsFrom('group'), 'WHERE 0 = ?', $groupBy
				);
				break;
			case 'class':
				$result = array(
					calcClsGroupsSelect('class'), calcClsGroupsFrom('class'), 'WHERE c.ClsClassID = ?', $groupBy
					, 'UNION ALL'
					, calcClsGroupsSelect('group'), calcClsGroupsFrom('group'), 'WHERE g.ClsClassID = ?', $groupBy
				);
				break;
			case 'group':
				$result = array(
					calcClsGroupsSelect('group'), calcClsGroupsFrom('group'), 'WHERE g.ClsGroupID = ?', $groupBy
						, 'UNION ALL'
						, calcClsGroupsSelect('subgroup'), calcClsGroupsFrom('subgroup'), 'WHERE s.ClsGroupID = ?', $groupBy
				);
				break;
			case 'subgroup':
				$result = array(
					calcClsGroupsSelect('group'), calcClsGroupsFrom('group')
					, 'WHERE g.ClsGroupID = (SELECT x.ClsGroupID FROM tblDvrClsSubGroups AS x WHERE x.ClsSubGroupID = ?)', $groupBy
					, 'UNION ALL'
					, calcClsGroupsSelect('subgroup'), calcClsGroupsFrom('subgroup')
					, 'WHERE s.ClsGroupID = (SELECT x.ClsGroupID FROM tblDvrClsSubGroups AS x WHERE x.ClsSubGroupID = ?)', $groupBy
				);
				break;
		}
		$result[] = $orderBy;
		$result = join("\n", $result);
		return $result;
	}
	function getClsGroups($clsGroupType, $clsGroupId)
	{
		global $db;
		$query = calcClsGroupsQuery($clsGroupType);
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $clsGroupId, $clsGroupId);
		$stmt->execute();
		$stmt->bind_result($groupId, $groupTitle, $parentId, $sequence, $groupLevel, $groupType, $goodsCount, $urlPath);
		$result = array();
		switch($clsGroupType)
		{
			case 'root':
			case 'class':
				$clsGroupType = 'class';
				$clsSubGroupType = 'group';
				break;
			case 'group':
			case 'subgroup':
				$clsGroupType = 'group';
				$clsSubGroupType = 'subgroup';
				break;
		}
		while($stmt->fetch())
		{
			if ($groupType == $clsGroupType)
			{
				$result[$groupId]['group'] = array('groupId' => $groupId, 'groupTitle' => $groupTitle, 'groupType' => $groupType, 'goodsCount' => $goodsCount, 'urlPath' => $urlPath);
			}
			else if ($groupType == $clsSubGroupType)
			{
				$result[$parentId]['subGroups'][] = array('groupId' => $groupId, 'groupTitle' => $groupTitle, 'groupType' => $groupType, 'goodsCount' => $goodsCount, 'urlPath'=> $urlPath);
			}
		}
		return $result;
	}
	function parseClsGroups($groupType, $groupId)
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/classification.groups.tpl');
		$tpl->Load($_PATH_TPL . '/classification.subgroups.tpl');
		$clsGroups = getClsGroups($groupType, $groupId);
		foreach($clsGroups as $clsGroup)
		{
			$devider = calcDevider(count($clsGroup['subGroups']), 2);
			$clsGroup['subGroups'] = array_chunk($clsGroup['subGroups'], $devider);
			foreach($clsGroup['subGroups'] as $clsColumn)
			{
				foreach($clsColumn as $clsSubGroup)
				{
					$tpl->Assign('group', $clsSubGroup);
					if ($clsSubGroup['groupType'] == $groupType && $clsSubGroup['groupId'] == $groupId)
					{
						$tpl->Parse('classification.subGroups.line.selected');
					}
					else
					{
						$tpl->Parse('classification.subGroups.line.normal');
					}
					$tpl->Parse('classification.subGroups.line');
				}
				$tpl->Parse('classification.subGroups.column');
			}
			$tpl->Parse('classification.subGroups');
			$tpl->Assign('group', $clsGroup['group']);
			$tpl->Parse('classification.group');
		}
		$tpl->Parse('classification.groups');
	}
?>
