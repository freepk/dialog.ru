<?php
	require_once($_PATH_SCR . '/core.db.php');
	function assignHeadTitle($folders)
	{
		global $tpl;
		$headTitle = '������ ������. �������� ��������. ���� ����� � ������ � �����������.';
		if(is_array($folders) && count($folders) > 0)
		{
			$headTitle = join(', ', array_reverse($folders)) . ' �� ����� ������ ������';
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
								$folders['path'][] = array('url' => null, 'title' => '���������� ������ &quot;' . htmlspecialchars($_GET['value']) . '&quot;');
								break;
						}
					}
					break;
				case 'order':
					$folders['path'][] = array('url' => null, 'title' => '���������� ������');
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
					$folders['path'][] = array('url' => null, 'title'=>'����������� ������������');
					break;
				case 'enter':
					$folders['path'][] = array('url' => null, 'title'=>'���� ������������');
					break;
				case 'exit':
					$folders['path'][] = array('url' => null, 'title'=>'����� ������������');
					break;
				case 'about':
					$folders['path'][] = array('url' => null, 'title'=>'� ��������');
					break;
				case 'delivery':
					$folders['path'][] = array('url' => null, 'title'=>'������� ��������');
					break;
				case 'vacancy':
					$folders['path'][] = array('url' => null, 'title'=>'��������');
					break;
				case 'feedback':
					$folders['path'][] = array('url' => null, 'title'=>'�������� �����');
					break;
				case 'filials':
					$folders['path'][] = array('url' => null, 'title'=>'���� ������');
					if(isset($_GET['location']))
					{
						switch($_GET['location'])
						{
							case 'aviamotornaja':
								$folders['path'][] = array('url' => null, 'title'=>'������������');
								break;
							case 'kurskaja':
								$folders['path'][] = array('url' => null, 'title'=>'�������');
								break;
							case 'buninskaja':
								$folders['path'][] = array('url' => null, 'title'=>'��������� �����');
								break;
							case 'varshavskaja':
								$folders['path'][] = array('url' => null, 'title'=>'����������');
								break;
							case 'vdnh':
								$folders['path'][] = array('url' => null, 'title'=>'����');
								break;
							case 'domodedovskaja':
								$folders['path'][] = array('url' => null, 'title'=>'�������������');
								break;
							case 'vernadskogo':
								$folders['path'][] = array('url' => null, 'title'=>'�������� �����������');
								break;
							case 'balashiha':
								$folders['path'][] = array('url' => null, 'title'=>'��������');
								break;
							case 'korolev':
								$folders['path'][] = array('url' => null, 'title'=>'�������');
								break;
							case 'protvino-lenina9':
								$folders['path'][] = array('url' => null, 'title'=>'��������, ��. ������ �.9');
								break;
							case 'protvino-lenina15':
								$folders['path'][] = array('url' => null, 'title'=>'��������, ��. ������ �.15');
								break;
							case 'serpuhov':
								$folders['path'][] = array('url' => null, 'title'=>'��������');
								break;
							case 'troick':
								$folders['path'][] = array('url' => null, 'title'=>'������');
								break;
							case 'shelkovo':
								$folders['path'][] = array('url' => null, 'title'=>'�������-4');
								break;
							case 'sherbinka':
								$folders['path'][] = array('url' => null, 'title'=>'��������');
								break;
							case 'ivanteevka':
								$folders['path'][] = array('url' => null, 'title'=>'����������');
								break;
							case 'marjino':
								$folders['path'][] = array('url' => null, 'title'=>'�������');
								break;
                                                        case 'sokol':
                                                                $folders['path'][] = array('url' => null, 'title'=>'�����');
                                                                break;
						}
					}
					break;
			}
		}
		assignHeadTitle($folders['head']);
		if (count($folders['path']) > 0)
		{
			array_unshift($folders['path'], array('url' => '/', 'title'=>'�������'));
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
