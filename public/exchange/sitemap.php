<?php
	header('Content-Type: text/xml;');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../scripts/core.config.php');
	require_once($_PATH_LIB . '/misc.php');
	require_once($_PATH_SCR . '/core.db.php');
	function genGeneralMap(&$sitemap)
	{
		$links = array(
			'/'
			, '/?action=about'
			, '/?action=delivery'
			, '/?action=vacancy'

			, '/?action=filials&amp;location=aviamotornaja'
			, '/?action=filials&amp;location=buninskaja'
			, '/?action=filials&amp;location=varshavskaja'
			, '/?action=filials&amp;location=domodedovskaja'
			, '/?action=filials&amp;location=vernadskogo'
			, '/?action=filials&amp;location=marjino'
			, '/?action=filials&amp;location=sokol'
			, '/?action=filials&amp;location=ivanteevka'
			, '/?action=filials&amp;location=korolev'
			, '/?action=filials&amp;location=protvino-lenina9'
			, '/?action=filials&amp;location=protvino-lenina15'
			, '/?action=filials&amp;location=serpuhov'
			, '/?action=filials&amp;location=troick'
			, '/?action=filials&amp;location=shelkovo'
			, '/?action=filials&amp;location=sherbinka'
		);
		foreach($links as $link)
		{
			$url = $sitemap->addChild('url');
			$loc = $url->addChild('loc', 'http://www.dialog.ru' . $link);
		}
	}
	function genClsMap(&$sitemap)
	{
		global $db;
		$query = "
			select concat('/',cast(cl.ClsClassID as char), '/') as FolderPath, count(*) as Count
			from tblDvrClsRel as rl
			  inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = rl.ClsSubGroupID
			  inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
			  inner join tblDvrClsClasses as cl on cl.ClsClassID = gr.ClsClassID
			group by cl.ClsClassID
			union
			select concat('/',cast(cl.ClsClassID as char), '/', cast(gr.ClsGroupID as char), '/') as FolderPath, count(*) as Count
			from tblDvrClsRel as rl
			  inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = rl.ClsSubGroupID
			  inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
			  inner join tblDvrClsClasses as cl on cl.ClsClassID = gr.ClsClassID
			group by cl.ClsClassID, gr.ClsGroupID
			union
			select concat('/',cast(cl.ClsClassID as char), '/', cast(gr.ClsGroupID as char), '/', cast(sg.ClsSubGroupID as char), '/') as FolderPath, count(*) as Count
			from tblDvrClsRel as rl
			  inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = rl.ClsSubGroupID
			  inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
			  inner join tblDvrClsClasses as cl on cl.ClsClassID = gr.ClsClassID
			group by cl.ClsClassID, gr.ClsGroupID, sg.ClsSubGroupID;
		";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($folderPath, $count);
		$stmt->store_result();
		while ($stmt->fetch())
		{
			$url = $sitemap->addChild('url');
			$url->addChild('loc', 'http://www.dialog.ru' . $folderPath);
		}
		$stmt->free_result();
	}
	function genGoodsMap(&$sitemap)
	{
		global $db;
		$query = "
			select concat('/',cast(cl.ClsClassID as char), '/', cast(gr.ClsGroupID as char), '/', cast(sg.ClsSubGroupID as char), '/') as FolderPath, g.GoodsID, d.DrugTitle
			from tblDvrClsRel as rl
			  inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = rl.ClsSubGroupID
			  inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
			  inner join tblDvrClsClasses as cl on cl.ClsClassID = gr.ClsClassID
			  inner join tblGoods as g on g.GoodsID = rl.GoodsID
			  inner join tblDrugs as d on d.DrugID = g.DrugID;
		";
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($folderPath, $goodsId, $drugTitle);
		$stmt->store_result();
		while ($stmt->fetch())
		{
			$url = $sitemap->addChild('url');
			$url->addChild('loc', 'http://www.dialog.ru' . $folderPath . url_title($drugTitle) . '_' . $goodsId . '.html');
		}
		$stmt->free_result();
	}
	$sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
	genGeneralMap($sitemap);
	genClsMap($sitemap);
	genGoodsMap($sitemap);
	//echo $sitemap->asXML();

	$dom = dom_import_simplexml($sitemap)->ownerDocument;
	$dom->formatOutput = true;
	echo $dom->saveXML();	
?>
