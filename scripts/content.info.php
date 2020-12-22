<?php
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/content.goods.inc.php');
	function filterDescriptions($description)
	{
		if (strlen($description) >= 3)
		{
			return true;
		}
		return false;
	}
	function getInfo($goodsId)
	{
		global $db;
		$query = 'SELECT g.GoodsID, d.DrugTitle, o.OutFormTitle, m.MakerTitle, g.HasImage, g.IsImageUploaded, g.DrugCost, g.Remainder
			FROM tblGoods AS g
			INNER JOIN tblDrugs AS d ON d.DrugID = g.DrugID
			INNER JOIN tblOutForms AS o ON o.OutFormID = g.OutFormID
			INNER JOIN tblMakers AS m ON m.MakerID = g.MakerID
			WHERE g.GoodsID = ?;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $goodsId);
		$stmt->execute();
		$stmt->bind_result($goodsID, $drugTitle, $outFormTitle, $makerTitle, $hasImage, $isImageUploaded, $drugCost, $remainder);
		$stmt->fetch();
		$stmt->close();
		$result = array
		(
			'goods' => array
				(
				    'goodsId' => $goodsID
				    , 'drugTitle' => $drugTitle
				    , 'outFormTitle' => $outFormTitle
				    , 'makerTitle' => $makerTitle
				    , 'hasImage' => $hasImage
				    , 'isImageUploaded' => $isImageUploaded
				    , 'drugCost' => $drugCost
				    , 'remainder' => $remainder
				)
		);
		$descriptions = array
		(
			'd.PharmGroup' => 'Фармакологическая группа'
			, 'd.InternationalTitle' => 'Международное непатентованное наименование'
			, 'd.Prescription' => 'Условия отпуска из аптек'
			, 'd.ActiveSubstance' => 'Состав'
			, 'd.Action' => 'Фармакологическое действие'
			, 'd.Indications' => 'Показания к применению'
			, 'd.Contraindications' => 'Противопоказания'
			, 'd.AdverseEffects' => 'Побочное действие'
			, 'd.Interactions' => 'Взаимодействие с другими лекарственными средствами'
			, 'd.Overdose' => 'Передозировка'
			, 'd.Dosage' => 'Способ применения и дозировка'
			, 'd.Warning' => 'Особые указания'
			, 'd.Store' => 'Условия хранения'
			, 'd.Literature' => 'Литература'
			/*
			, 'd.Synonims' => 'Аналоги'
			, 'd.Form' => 'Форма выпуска'
			, 'd.Maker' => 'Maker'
			, 'd.Title' => 'Title'
			*/
		);
		$bind_results = array();
		$descriptionNumber = 0;
		foreach($descriptions as $description)
		{
			$bind_result = 'bind_' . ++$descriptionNumber;
			$bind_results[] = &$$bind_result;
		}
		$query = 'SELECT ' . join (', ', array_keys($descriptions)) . ' FROM tblGoods AS g
			INNER JOIN tblDescriptions AS d ON d.DescriptionID = g.DescriptionID
			WHERE g.GoodsID = ?
			LIMIT 0, 1;';
		$stmt = $db->prepare($query);
		$stmt->bind_param('i', $goodsId);
		$stmt->execute();
		$stmt->store_result();
		call_user_func_array (array($stmt, 'bind_result'), $bind_results);
		$stmt->fetch();
		if ($stmt->num_rows > 0)
		{
			$result['description'] = array_filter(array_combine($descriptions, $bind_results), 'filterDescriptions');
		}
		else
		{
			$result['description'] = array();
		}
		$stmt->free_result();
		return $result;
	}
	function parseGoodsList($goods)
	{
		global $tpl;
		$i = 0;
		foreach($goods as $item)
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
	function parseGoodsSynonims($goodsId)
	{
		global $tpl;
		$goods = getGoodsSynonims($goodsId);
		if ($goods['count'] > 0)
		{
			parseGoodsList($goods['list']);
			$tpl->Parse('content.info.synonims');
		}
	}
	function parseGoodsOutForms($goodsId)
	{
		global $tpl;
		$goods = getGoodsOutForms($goodsId);
		if ($goods['count'] > 0)
		{
			parseGoodsList($goods['list']);
			$tpl->Parse('content.info.outForms');
		}
	}
	function parseInfo()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.info.tpl');
		$info = getInfo($_GET['goodsId']);
		$tpl->Assign('goods', $info['goods']);
		if ($info['goods']['hasImage'] && $info['goods']['isImageUploaded'] == 1)
		{
			$tpl->Parse('content.info.description.image.normal');
		}
		else
		{
			$tpl->Parse('content.info.description.image.empty');
		}
		if (count($info['description']) > 0)
		{
			foreach($info['description'] as $key => $description)
			{
				$tpl->Assign('extension', array('field' => $key, 'text' => $description));
				$tpl->Parse('content.info.description.extension.item');
			}
			$tpl->Parse('content.info.description.extension');
		}
		$tpl->Parse('content.info.description.image');
		$tpl->Parse('content.info.description');
		$tpl->Load($_PATH_TPL . '/content.goods.list.tpl');
		parseGoodsOutForms($_GET['goodsId']);
		parseGoodsSynonims($_GET['goodsId']);
		$tpl->Parse('content.info');
	}
	parseInfo();
?>
