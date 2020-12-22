<?php
	function getUrlPath()
	{
		return 'CASE WHEN ISNULL(r.GoodsID) THEN \'0\' ELSE CONCAT(CAST(c.ClsClassID AS CHAR), \'/\', CAST(g.ClsGroupID AS CHAR), \'/\', CAST(s.ClsSubGroupID AS CHAR)) END AS UrlPath';
	}
	function getGoodsFrom()
	{
		return 'FROM tblGoods AS i
			INNER JOIN tblDrugs AS d ON d.DrugID = i.DrugID
			INNER JOIN tblOutForms AS o ON o.OutFormID = i.OutFormID
			INNER JOIN tblMakers AS m ON m.MakerID = i.MakerID
			LEFT JOIN tblDvrClsRel AS r ON r.GoodsID = i.GoodsID
			LEFT JOIN tblDvrClsSubGroups AS s ON s.ClsSubGroupID = r.ClsSubGroupID
			LEFT JOIN tblDvrClsGroups AS g ON g.ClsGroupID = s.ClsGroupID
			LEFT JOIN tblDvrClsClasses AS c ON c.ClsClassID = g.ClsClassID';
	}
	function getGoodsByGroupWhere($groupType)
	{
		$result = 'WHERE i.Remainder > 0';
		switch($groupType)
		{
			case 'class':
				$result .= ' AND c.ClsClassID = ?';
				break;
			case 'group':
				$result .= ' AND g.ClsGroupID = ?';
				break;
			case 'subgroup':
				$result .= ' AND s.ClsSubGroupID = ?';
				break;
		}
		return $result;
	}
	function fetchGoods($stmt)
	{
		global $db;
		$stmt->execute();
		$stmt->bind_result($goodsID, $drugTitle, $outFormTitle, $makerTitle, $hasImage, $isImageUploaded, $drugCost, $remainder, $urlPath);
		$result = array('count' => 0, 'list' => array());
		while($stmt->fetch())
		{
			$result['list'][] = array
			(
			    'goodsId' => $goodsID
			    , 'drugTitle' => $drugTitle
			    , 'outFormTitle' => $outFormTitle
			    , 'makerTitle' => $makerTitle
			    , 'hasImage' => $hasImage
			    , 'isImageUploaded' => $isImageUploaded
			    , 'drugCost' => $drugCost
			    , 'remainder' => $remainder
			    , 'urlPath' => $urlPath
			);
		}
		$stmt = $db->prepare('SELECT FOUND_ROWS();');
		$stmt->execute();
		$stmt->bind_result($result['count']);
		$stmt->fetch();
		return $result;
	}
	function getGoodsByGroup($groupType, $id, $pageSize, $pageNumber)
	{
		global $db;
		$query = 'SELECT SQL_CALC_FOUND_ROWS i.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, i.HasImage, i.IsImageUploaded, i.DrugCost, i.Remainder, '
			. getUrlPath() . ' ' . getGoodsFrom() . ' ' . getGoodsByGroupWhere($groupType)
			. ' ORDER BY d.DrugTitle, o.OutFormTitle, m.MakerTitle
				LIMIT ?, ?;';
		$stmt = $db->prepare($query);
		$start = ($pageNumber - 1) * $pageSize;
		$stmt->bind_param ('iii', $id, $start, $pageSize);
		return fetchGoods($stmt);
	}
	function getGoodsByKeyword($keyword, $pageSize, $pageNumber)
	{
		global $db;
		$query = 'SELECT SQL_CALC_FOUND_ROWS i.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, i.HasImage, i.IsImageUploaded, i.DrugCost, i.Remainder, '
			. getUrlPath() . ' ' . getGoodsFrom()
			. ' WHERE i.Remainder > 0
				AND (d.DrugTitle LIKE CONCAT(\'%\', ?, \'%\') or o.OutFormTitle LIKE CONCAT(\'%\', ?, \'%\') or m.MakerTitle LIKE CONCAT(\'%\', ?, \'%\'))
				ORDER BY d.DrugTitle, o.OutFormTitle, m.MakerTitle
				LIMIT ?, ?;';
		$stmt = $db->prepare($query);
		$start = ($pageNumber - 1) * $pageSize;
		$stmt->bind_param('sssii', $keyword, $keyword, $keyword, $start, $pageSize);
		return fetchGoods($stmt);
	}
	function getGoodsOutForms($goodsId)
	{
		global $db;
		$query = 'SELECT SQL_CALC_FOUND_ROWS i.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, i.HasImage, i.IsImageUploaded, i.DrugCost, i.Remainder, '
			. getUrlPath() . ' ' . getGoodsFrom()
			. ' INNER JOIN tblGoods AS ix ON ix.GoodsID <> i.GoodsID and ix.DrugID = i.DrugID
				WHERE ix.GoodsID = ? AND i.Remainder > 0
				ORDER BY d.DrugTitle, o.OutFormTitle, m.MakerTitle';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $goodsId);
		return fetchGoods($stmt);
	}
	function getGoodsSynonims($goodsId)
	{
		global $db;
		$query = 'SELECT SQL_CALC_FOUND_ROWS i.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, i.HasImage, i.IsImageUploaded, i.DrugCost, i.Remainder, '
			. getUrlPath() . ' ' . getGoodsFrom()
			. ' INNER JOIN tblDescriptions AS d1 ON d1.DescriptionID = i.DescriptionID
				INNER JOIN tblDescriptions AS d2 ON d2.MnnID = d1.MnnID
				INNER JOIN tblGoods AS ix ON ix.DescriptionID = d2.DescriptionID
				WHERE i.GoodsID <> ? AND ix.GoodsID = ? AND i.Remainder > 0
				ORDER BY d.DrugTitle, o.OutFormTitle, m.MakerTitle';
		echo $query;
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $goodsId, $goodsId);
		return fetchGoods($stmt);
	}
?>
