<?php
	header('Content-Type: text/xml;');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../scripts/core.config.php');
	require_once($_PATH_LIB . '/misc.php');
	require_once($_PATH_SCR . '/core.db.php');

	function prepCategories()
	{
		global $db;
		$query = "
			insert into tblCategories (ParentID, ClsClassID)
			select 1 as ParentID, cl.ClsClassID from tblDvrClsClasses as cl
			where not exists (
				select * from tblCategories as ct where ct.ClsClassID = cl.ClsClassID
			);";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->free_result();
		$query = "
			insert into tblCategories (ParentID, ClsGroupID)
			select ct.CategoryID as ParentID, gr.ClsGroupID as ClsGroupID
			from tblDvrClsGroups as gr
				inner join tblCategories as ct on ct.ClsClassID = gr.ClsClassID
			where not exists (
				select * from tblCategories as ct where ct.ClsGroupID = gr.ClsGroupID
			);";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->free_result();
	}

	function addCategories(&$shop)
	{
		global $db;
		$categories = $shop->addChild('categories');
		prepCategories();
		$query = "select ct.CategoryID, ct.ParentID
			, case
				when ct.CategoryID = 1 then 'Препараты'
				when ct.ClsClassID is null then gr.ClsGroupTitle
				when ct.ClsGroupID is null then cl.ClsClassTitle
			end as CategoryTitle
			from tblCategories as ct
				left join tblDvrClsClasses as cl on cl.ClsClassID = ct.ClsClassID
				left join tblDvrClsGroups as gr on gr.ClsGroupID = ct.ClsGroupID;";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($categoryId, $parentId, $categoryTitle);
		$stmt->store_result();
		while ($stmt->fetch())
		{
			$category = $categories->addChild('category', w2u(htmlspecialchars($categoryTitle)));
			$category->addAttribute('id', $categoryId);
			if ($parentId != null)
			{
				$category->addAttribute('parentId', $parentId);
			}
		}
		$stmt->free_result();
	}

	function addOffers(&$shop)
	{
		global $db;
		$offers = $shop->addChild('offers');
		$query = "
			select g.GoodsID, g.Remainder, cl.ClsClassID, gr.ClsGroupID, sg.ClsSubGroupID, g.DrugCost
				, ct.CategoryID, d.DrugTitle, o.OutFormTitle, c.CountryTitle, g.HasImage & g.IsImageUploaded as HasImage
			from tblDvrClsRel as rl
			  inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = rl.ClsSubGroupID
			  inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
			  inner join tblDvrClsClasses as cl on cl.ClsClassID = gr.ClsClassID
			  inner join tblCategories as ct on ct.ClsGroupID = gr.ClsGroupID
			  inner join tblGoods as g on g.GoodsID = rl.GoodsID
			  inner join tblDrugs as d on d.DrugID = g.DrugID
				inner join tblOutForms as o on o.OutFormID = g.OutFormID
				inner join tblMakers as m on m.MakerID = g.MakerID
				inner join tblCountries as c on c.CountryID = m.CountryID
				inner join tblDescriptions as ds on ds.DescriptionID = g.DescriptionID
			where ds.Prescription = 'Отпускается без рецепта';
		";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($goodsId, $remainder, $clsClassId, $clsGroupId, $clsSubGroupId, $drugCost, $categoryId, $drugTitle, $outFormTitle, $countryTitle, $hasImage);
		$stmt->store_result();
		while ($stmt->fetch())
		{
			$offer = $offers->addChild('offer');
			$offer->addAttribute('id', $goodsId);
			if ($remainder > 0)
			{
				$offer->addAttribute('available', 'true');
			}
			else
			{
				$offer->addAttribute('available', 'false');
			}
			$offer->addChild('url', 'http://www.dialog.ru/'.$clsClassId.'/'.$clsGroupId.'/'.$clsSubGroupId.'/'.url_title($drugTitle).'_'.$goodsId.'.html');
			$offer->addChild('price', $drugCost);
			$offer->addChild('currencyId', 'RUR');
			$offer->addChild('categoryId', $categoryId);
			if ($hasImage)
			{
				$offer->addChild('picture', 'http://www.dialog.ru/images/goods/'.$goodsId.'_240.jpg');
			}
			$offer->addChild('delivery', 'false');
			$offer->addChild('name', w2u(htmlspecialchars($drugTitle.' '.$outFormTitle)));
			$offer->addChild('country_of_origin', w2u(htmlspecialchars($countryTitle)));
		}
		$stmt->free_result();
	}

	$yml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd"><yml_catalog />');
	$yml->addAttribute('date', date('Y-m-d H:i'));

	$shop = $yml->addChild('shop');
	$shop->addChild('name', w2u(htmlspecialchars('Аптека Диалог')));
	$shop->addChild('company', w2u(htmlspecialchars('ООО "Диалог"')));
	$shop->addChild('url', 'www.dialog.ru');

	$currencies = $shop->addChild('currencies');
	$rur = $currencies->addChild('currency');
	$rur->addAttribute('id', 'RUR');
	$rur->addAttribute('rate', '1');

	addCategories($shop);
	addOffers($shop);
	//echo $yml->asXML();

	$dom = dom_import_simplexml($yml)->ownerDocument;
	$dom->formatOutput = true;
	echo $dom->saveXML();

?>
