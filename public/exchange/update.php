<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../scripts/core.config.php');
	require_once($_PATH_LIB . '/misc.php');
	require_once($_PATH_SCR . '/core.db.php');
	require_once($_PATH_SCR . '/update.inc.php');
	function getData()
	{
		$data = $_FILES['data']['tmp_name'];
		if(is_uploaded_file($data))
		{
			return simplexml_load_file('zip://' . $data . '#data');
		}
		return false;
	}
	function putData()
	{
		global $tablesInfo;
		$xml = getData();
		truncateTemp();
		foreach($tablesInfo as $tableName => $tableInfo)
		{
			$tableData = array();
			foreach($xml->{$tableInfo['tagName']} as $xmlRow)
			{
				$dataRow = array();
				foreach($tableInfo['fields'] as $attrName => $fieldName)
				{
					$dataRow[$fieldName] = u2w($xmlRow[$attrName]);
				}
				$tableData[] = $dataRow;
			}
			if (count($tableData) > 0)
			{
				insertToTemp($tableName, $tableData);
			}
		}
		truncateTemp();
	}
	refreshLastUpdateTime();
	putData();
?>
