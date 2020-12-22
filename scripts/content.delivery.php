<?php
	require_once($_PATH_SCR . '/core.db.php');
        function getLastUpdateTime()
        {
                global $db;
                $query = 'SELECT MAX(LastUpdateTime) AS LastUpdateTime FROM tblUpdateInfo';
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->bind_result($lastUpdateTime);
                $stmt->fetch();
                $stmt->close();
                return $lastUpdateTime;
        }
	function parseDelivery()
	{
		global $tpl, $_PATH_TPL;
		$tpl->Load($_PATH_TPL . '/content.delivery.tpl');
		$tpl->Assign('lastUpdateTime', getLastUpdateTime());
		$tpl->Parse('content.delivery');
	}
	parseDelivery();
?>
