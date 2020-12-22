<?php
	$tablesInfo = array
	(
		'`dialog.ru`.`tblDrugs`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDrugs`'
			, 'fields' => array('d1' => 'DrugID', 'd2' => 'DrugTitle')
			, 'fieldTypes' => 'is'
			, 'primaryKey' => 'DrugID'
			, 'tagName' => 'd'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblOutForms`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempOutForms`'
			, 'fields' => array('o1' => 'OutFormID', 'o2' => 'OutFormTitle')
			, 'fieldTypes' => 'is'
			, 'primaryKey' => 'OutFormID'
			, 'tagName' => 'o'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblCountries`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempCountries`'
			, 'fields' => array('c1' => 'CountryID', 'c2' => 'CountryTitle')
			, 'fieldTypes' => 'is'
			, 'primaryKey' => 'CountryID'
			, 'tagName' => 'c'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblMakers`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempMakers`'
			, 'fields' => array('m1' => 'MakerID', 'm2' => 'MakerTitle', 'm3' => 'CountryID')
			, 'fieldTypes' => 'isi'
			, 'primaryKey' => 'MakerID'
			, 'tagName' => 'm'
			, 'postProc' => 'updateAndInsert'
		)
                , '`dialog.ru`.`tblGoodsInfoTypes`' => array
                (
                        'tempTable' => '`dialog.ru`.`tblTempGoodsInfoTypes`'
                        , 'fields' => array('git1' => 'GoodsInfoTypeID', 'git2' => 'GoodsInfoTypeTitle', 'git3' => 'GoodsInfoTypeTitleRls', 'git4' => 'Priority')
                        , 'fieldTypes' => 'issi'
                        , 'primaryKey' => 'GoodsInfoTypeID'
                        , 'tagName' => 'git'
                        , 'postProc' => 'updateAndInsert'
                )
                , '`dialog.ru`.`tblGoodsInfo`' => array
                (
                        'tempTable' => '`dialog.ru`.`tblTempGoodsInfo`'
                        , 'fields' => array('gi1' => 'GoodsInfoID', 'gi2' => 'MnnID')
                        , 'fieldTypes' => 'ii'
                        , 'primaryKey' => 'GoodsInfoID'
                        , 'tagName' => 'gi'
                        , 'postProc' => 'updateAndInsert'
                )
                , '`dialog.ru`.`tblGoodsInfoItems`' => array
                (
                        'tempTable' => '`dialog.ru`.`tblTempGoodsInfoItems`'
                        , 'fields' => array('gii1' => 'GoodsInfoItemID', 'gii2' => 'GoodsInfoID', 'gii3' => 'GoodsInfoTypeID', 'gii4' => 'GoodsInfoText')
                        , 'fieldTypes' => 'iiis'
                        , 'primaryKey' => 'GoodsInfoItemID'
                        , 'tagName' => 'gii'
                        , 'postProc' => 'updateAndInsert'
                )
		, '`dialog.ru`.`tblDescriptions`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDescriptions`'
			, 'fields' => array
			(
				'i1' => 'DescriptionID', 'i2' => 'Prescription', 'i3' => 'PharmGroup'
				, 'i4' => 'Action', 'i5' => 'Warning', 'i6' => 'Synonims'
				, 'i7' => 'Overdose', 'i8' => 'Contraindications', 'i9' => 'AdverseEffects'
				, 'i10' => 'Interactions', 'i11' => 'Indications', 'i12' => 'Form'
				, 'i13' => 'Dosage', 'i14' => 'Maker', 'i15' => 'InternationalTitle'
				, 'i16' => 'Title', 'i17' => 'Literature', 'i18' => 'Store'
				, 'i19' => 'ActiveSubstance', 'i20' => 'MnnID'
			)
			, 'fieldTypes' => 'issssssssssssssssssi'
			, 'primaryKey' => 'DescriptionID'
			, 'tagName' => 'i'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblDvrClsClasses`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDvrClsClasses`'
			, 'fields' => array('cc1' => 'ClsClassID', 'cc2' => 'ClsClassTitle', 'cc3' => 'Sequence')
			, 'fieldTypes' => 'isi'
			, 'primaryKey' => 'ClsClassID'
			, 'tagName' => 'cc'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblDvrClsGroups`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDvrClsGroups`'
			, 'fields' => array('cg1' => 'ClsGroupID', 'cg2' => 'ClsGroupTitle', 'cg3' => 'ClsClassID', 'cg4' => 'Sequence')
			, 'fieldTypes' => 'isii'
			, 'primaryKey' => 'ClsGroupID'
			, 'tagName' => 'cg'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblDvrClsSubGroups`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDvrClsSubGroups`'
			, 'fields' => array('sg1' => 'ClsSubGroupID', 'sg2' => 'ClsSubGroupTitle', 'sg3' => 'ClsGroupID', 'sg4' => 'Sequence')
			, 'fieldTypes' => 'isii'
			, 'primaryKey' => 'ClsSubGroupID'
			, 'tagName' => 'sg'
			, 'postProc' => 'updateAndInsert'
		)
		, '`dialog.ru`.`tblGoods`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempGoods`'
			, 'fields' => array
			(
				'g1' => 'GoodsID', 'g2' => 'DrugID', 'g3' => 'OutFormID'
				, 'g4' => 'MakerID', 'g5' => 'DescriptionID', 'g6' => 'HasImage'
				, 'g7' => 'IsImageUploaded', 'g8' => 'DrugCost', 'g9' => 'Remainder'
			)
			, 'fieldTypes' => 'iiiiiiidi'
			, 'primaryKey' => 'GoodsID'
			, 'tagName' => 'g'
			, 'postProc' => 'updateGoods'
		)
		, '`dialog.ru`.`tblDvrClsRel`' => array
		(
			'tempTable' => '`dialog.ru`.`tblTempDvrClsRel`'
			, 'fields' => array('cr1' => 'ClsSubGroupID', 'cr2' => 'GoodsID')
			, 'fieldTypes' => 'ii'
			, 'primaryKey' => array('ClsSubGroupID', 'GoodsID')
			, 'tagName' => 'cr'
			, 'postProc' => 'updateClsRel'
		)
	);
	function truncateTemp()
	{
		global $db, $tablesInfo;
		$tableNamesReverse = array_reverse(array_keys($tablesInfo));
		foreach($tableNamesReverse as $tableName)
		{
			$query = 'TRUNCATE TABLE ' . $tablesInfo[$tableName]['tempTable'] . ';';
			$stmt = $db->prepare($query);
			$stmt->execute();
			$stmt->close();
		}
	}
	function insertToTemp($tableName, $tableData)
	{
		global $tablesInfo, $db;
		$tableInfo = $tablesInfo[$tableName];
		$db->autocommit(false);
		foreach($tableInfo['fields'] as $field)
		{
			$bind_name = 'bind_' . $field;
			$bind_names[] = &$$bind_name;
		}
		$bind_params = array($tableInfo['fieldTypes']);
		$bind_params = array_merge($bind_params, $bind_names);
		$query = 'INSERT INTO ' . $tableInfo['tempTable'] . ' (' . join(', ', $tableInfo['fields'])
			. ') VALUES (' . join(', ', array_fill(0, count($tableInfo['fields']), '?')) . ')';
		$stmt = $db->prepare($query);
		call_user_func_array (array($stmt, 'bind_param'), $bind_params);
		foreach($tableData as $dataRow)
		{
			reset($tableInfo['fields']);
			foreach($tableInfo['fields'] as $field)
			{
				$bind_name = 'bind_' . $field;
				$$bind_name = $dataRow[$field];
			}
			$stmt->execute();
		}
		$stmt->close();
		call_user_func($tableInfo['postProc'], $tableName);
		$db->commit();
	}
	function fieldsPair($fieldName, $compareSign)
	{
		return 'old.' . $fieldName . ' ' . $compareSign .  ' new.' . $fieldName;
	}
	function fieldsList($tableName, $compareSign, $joinSign)
	{
		global $tablesInfo;
		$tableInfo = $tablesInfo[$tableName];
		foreach ($tableInfo['fields'] as $field)
		{
			if ($field == $tableInfo['primaryKey'])
				continue;
			$result[] = fieldsPair($field, $compareSign);
		}
		return join($joinSign, $result);
	}
	function fieldsWithAlias($tableName, $alias)
	{
		global $tablesInfo;
		$tableInfo = $tablesInfo[$tableName];
		foreach($tableInfo['fields'] as $field)
		{
			$result[] = $alias . '.' . $field;
		}
		return join(', ', $result);
	}
	function updateAndInsert($tableName)
	{
		global $tablesInfo, $db;
		$tableInfo = $tablesInfo[$tableName];
		$oldAlias = $tableName . ' AS old';
		$newAlias = $tableInfo['tempTable'] . ' AS new';
		$joinClause = 'ON old.' . $tableInfo['primaryKey'] . ' = new.' . $tableInfo['primaryKey'];
		$query = 'UPDATE ' . $oldAlias . ' INNER JOIN ' . $newAlias . ' ' . $joinClause
		. ' SET ' . fieldsList($tableName, '=', ', ')
		. ' WHERE ' . fieldsList($tableName, '<>', ' or ') . ';';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
		$query = 'INSERT INTO ' . $tableName . '(' . join(', ', $tableInfo['fields']) . ')'
		. ' SELECT ' . fieldsWithAlias($tableName, 'new')
		. ' FROM ' . $oldAlias . ' RIGHT JOIN ' . $newAlias . ' ' . $joinClause
		. ' WHERE old.' . $tableInfo['primaryKey'] . ' IS NULL;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
	}
	function updateGoods($tableName)
	{
		global $db;
		updateAndInsert($tableName);
		$query = 'UPDATE tblGoods as old LEFT JOIN tblTempGoods as new'
			. ' ON old.GoodsID = new.GoodsID'
			. ' SET old.Remainder = 0'
			. ' WHERE new.GoodsID IS NULL;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
		$query = 'UPDATE tblGoods SET DescriptionID = NULL WHERE DescriptionID = 0;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
	}
	function updateClsRel($tableName)
	{
		global $db, $tablesInfo;
		$query = 'DELETE old FROM tblDvrClsRel AS old LEFT JOIN tblTempDvrClsRel AS new'
			. ' ON old.ClsSubGroupID = new.ClsSubGroupID AND old.GoodsID = new.GoodsID'
			. ' WHERE new.ClsSubGroupID IS NULL AND new.GoodsID IS NULL;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
		$query = 'INSERT INTO tblDvrClsRel (ClsSubGroupID, GoodsID)'
			. ' SELECT new.ClsSubGroupID, new.GoodsID FROM tblDvrClsRel AS old'
			. ' RIGHT JOIN tblTempDvrClsRel AS new'
			. ' ON old.ClsSubGroupID = new.ClsSubGroupID AND old.GoodsID = new.GoodsID'
			. ' WHERE old.ClsSubGroupID IS NULL AND old.GoodsID IS NULL;';
		$stmt = $db->prepare($query);
		$stmt->execute();
		$stmt->close();
	}
        function refreshLastUpdateTime()
        {
		global $db;
		$query = 'INSERT INTO tblUpdateInfo (LastUpdateTime) VALUES (NOW())';
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->close();
        }
?>
