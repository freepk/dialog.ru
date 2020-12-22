<?php
	require_once($_PATH_SCR . '/core.db.php');
	function assignHeadTitle($folders)
	{
		global $tpl;
		$headTitle = 'Аптека Диалог. Доставка лекарств. Сеть аптек в Москве и подмосковье.';
		if(is_array($folders) && count($folders) > 0)
		{
			$headTitle = join(', ', array_reverse($folders)) . ' на сайте Аптека Диалог';
		}
		$tpl->Assign('headTitle', $headTitle);
	}
	function parseFolders()
	{
		global $db, $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.path.tpl');
		$folders = array('path' => array(), 'head' => array());
		if(isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'goods':
					if(isset($_GET['filter']) && isset($_GET['value']))
					{
						switch($_GET['filter'])
						{
							case 'class':
								$query = 'select c.ClsClassID, c.ClsClassTitle
									from tblDvrClsClasses as c
									where c.ClsClassID = ?;';
								$stmt = $db->prepare($query);
								$stmt->bind_param('i', $_GET['value']);
								$stmt->execute();
								$stmt->bind_result($classId, $classTitle);
								if($stmt->fetch())
								{
									$folders['head'][] = $classTitle;
								}
								$stmt->close();
								break;
							case 'group':
								$query = 'select c.ClsClassID, c.ClsClassTitle, gr.ClsGroupID, gr.ClsGroupTitle
									from tblDvrClsClasses as c
										inner join tblDvrClsGroups as gr on gr.ClsClassID = c.ClsClassID
									where gr.ClsGroupID = ?;';
								$stmt = $db->prepare($query);
								$stmt->bind_param('i', $_GET['value']);
								$stmt->execute();
								$stmt->bind_result($classId, $classTitle, $groupId, $groupTitle);
								if($stmt->fetch())
								{
									$folders['path'][] = array('url' => '/' . $classId . '/', 'title' => $classTitle);
									$folders['head'][] = $classTitle;
									$folders['head'][] = $groupTitle;
								}
								$stmt->close();
								break;
							case 'subgroup':
								$query = 'select c.ClsClassID, c.ClsClassTitle, gr.ClsGroupID, gr.ClsGroupTitle, sg.ClsSubGroupID, sg.ClsSubGroupTitle
									from tblDvrClsClasses as c
									inner join tblDvrClsGroups as gr on gr.ClsClassID = c.ClsClassID
									inner join tblDvrClsSubGroups as sg on sg.ClsGroupID = gr.ClsGroupID
									where sg.ClsSubGroupID = ?;';
								$stmt = $db->prepare($query);
								$stmt->bind_param('i', $_GET['value']);
								$stmt->execute();
								$stmt->bind_result($classId, $classTitle, $groupId, $groupTitle, $subGroupId, $subGroupTitle);
								if($stmt->fetch())
								{
									$folders['path'][] = array('url' => '/' . $classId . '/', 'title' => $classTitle);
									$folders['head'][] = $classTitle;
									$folders['head'][] = $groupTitle;
								}
								$stmt->close();
								break;
							case 'keyword':
								$folders['path'][] = array('url' => null, 'title' => 'Результаты поиска &quot;' . htmlspecialchars($_GET['value']) . '&quot;');
								break;
						}
					}
					break;
				case 'order':
					$folders['path'][] = array('url' => null, 'title' => 'Оформление заказа');
					break;
				case 'info':
					if(isset($_GET['goodsId']) && is_numeric($_GET['goodsId']))
					{
						$query = 'select c.ClsClassID, c.ClsClassTitle, gr.ClsGroupID, gr.ClsGroupTitle, sg.ClsSubGroupID, sg.ClsSubGroupTitle, d.DrugID, d.DrugTitle
							from tblGoods as g
							inner join tblDrugs as d on d.DrugID = g.DrugID
							inner join tblDvrClsRel as r on r.GoodsID = g.GoodsID
							inner join tblDvrClsSubGroups as sg on sg.ClsSubGroupID = r.ClsSubGroupID
							inner join tblDvrClsGroups as gr on gr.ClsGroupID = sg.ClsGroupID
							inner join tblDvrClsClasses as c on c.ClsClassID = gr.ClsClassID
						where g.GoodsID = ?;';
						$stmt = $db->prepare($query);
						$stmt->bind_param('i', $_GET['goodsId']);
						$stmt->execute();
						$stmt->bind_result($classId, $classTitle, $groupId, $groupTitle, $subGroupId, $subGroupTitle, $drugId, $drugTitle);
						if($stmt->fetch())
						{
							$folders['path'][] = array('url' => '/' . $classId . '/', 'title' => $classTitle);
							$folders['path'][] = array('url' => '/' . $classId . '/' . $groupId . '/', 'title' => $groupTitle);
							$folders['path'][] = array('url' => '/' . $classId . '/' . $groupId . '/' . $subGroupId . '/', 'title' => $subGroupTitle);
							$folders['head'][] = $classTitle;
							$folders['head'][] = $groupTitle;
							$folders['head'][] = $drugTitle;
						}
						$stmt->close();
					}
					break;
				case 'register':
					$folders['path'][] = array('url' => null, 'title'=>'Регистрация пользователя');
					break;
				case 'enter':
					$folders['path'][] = array('url' => null, 'title'=>'Вход пользователя');
					break;
				case 'exit':
					$folders['path'][] = array('url' => null, 'title'=>'Выход пользователя');
					break;
				case 'about':
					$folders['path'][] = array('url' => null, 'title'=>'О компании');
					break;
				case 'delivery':
					$folders['path'][] = array('url' => null, 'title'=>'Условия доставки');
					break;
				case 'vacancy':
					$folders['path'][] = array('url' => null, 'title'=>'Вакансии');
					break;
				case 'feedback':
					$folders['path'][] = array('url' => null, 'title'=>'Обратная связь');
					break;
				case 'filials':
					$folders['path'][] = array('url' => null, 'title'=>'Наши аптеки');
					if(isset($_GET['location']))
					{
						switch($_GET['location'])
						{
							case 'aviamotornaja':
								$folders['path'][] = array('url' => null, 'title'=>'Авиамоторная');
								break;
							case 'kurskaja':
								$folders['path'][] = array('url' => null, 'title'=>'Курская');
								break;
							case 'buninskaja':
								$folders['path'][] = array('url' => null, 'title'=>'Бунинская аллея');
								break;
							case 'varshavskaja':
								$folders['path'][] = array('url' => null, 'title'=>'Варшавская');
								break;
							case 'vdnh':
								$folders['path'][] = array('url' => null, 'title'=>'ВДНХ');
								break;
							case 'domodedovskaja':
								$folders['path'][] = array('url' => null, 'title'=>'Домодедовская');
								break;
							case 'vernadskogo':
								$folders['path'][] = array('url' => null, 'title'=>'Проспект Вернадского');
								break;
							case 'balashiha':
								$folders['path'][] = array('url' => null, 'title'=>'Балашиха');
								break;
							case 'korolev':
								$folders['path'][] = array('url' => null, 'title'=>'Королев');
								break;
							case 'protvino-lenina9':
								$folders['path'][] = array('url' => null, 'title'=>'Протвино, ул. Ленина д.9');
								break;
							case 'protvino-lenina15':
								$folders['path'][] = array('url' => null, 'title'=>'Протвино, ул. Ленина д.15');
								break;
							case 'serpuhov':
								$folders['path'][] = array('url' => null, 'title'=>'Серпухов');
								break;
							case 'troick':
								$folders['path'][] = array('url' => null, 'title'=>'Троицк');
								break;
							case 'shelkovo':
								$folders['path'][] = array('url' => null, 'title'=>'Щелково-4');
								break;
							case 'sherbinka':
								$folders['path'][] = array('url' => null, 'title'=>'Щербинка');
								break;
							case 'ivanteevka':
								$folders['path'][] = array('url' => null, 'title'=>'Ивантеевка');
								break;
							case 'marjino':
								$folders['path'][] = array('url' => null, 'title'=>'Марьино');
								break;
                                                        case 'sokol':
                                                                $folders['path'][] = array('url' => null, 'title'=>'Сокол');
                                                                break;
						}
					}
					break;
			}
		}
		assignHeadTitle($folders['head']);
		if (count($folders['path']) > 0)
		{
			array_unshift($folders['path'], array('url' => '/', 'title'=>'Главная'));
		}
		foreach($folders['path'] as $number => $folder)
		{
			$tpl->Assign('folder', $folder);
			if(is_null($folder['url']))
			{
				$tpl->Parse('content.path.folder.nourl');
			}
			else
			{
				$tpl->Parse('content.path.folder.normal');
			}
			if ($number > 0)
			{
				$tpl->Parse('content.path.folder.splitter');
			}
			$tpl->Parse('content.path.folder');
		}
		$tpl->Parse('content.path');
	}
	parseFolders();
?>
