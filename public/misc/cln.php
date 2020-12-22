<?php
	/*
	pk	: field : unique
	x	: a     : b       - разрешение конфликтов уникальности делать не нужно
	x	: a     : a       - delete from table where a = @old and exists (select * from table where a = @new)
	x	: a     : a, b, c - delete from table where a = @old and exists (select * from table where a = @new and b = b and c = c)
	*/

	function compare($fields, $old, $new)
	{
		$pairs = array();
		foreach($fields as $field)
		{
			$pairs[] = '(' . $old . '.' . $field . ' = ' . $new . '.' . $field . ')';
		}
		return join(' and ', $pairs);
	}

	function subque($table, $alias, $value, $column, $value1, $column1)
	{
		return <<<"EOD"
select $column = $value, $alias.* from $table as $alias where $alias.$column1 = $value1
EOD;
	}

	class MyGenerator
	{
		private $_old;
		private $_new;
		public function __construct($old, $new)
		{
			$this->_old = $old;
			$this->_new = $new;
		}
		public function __get($name)
		{
			switch($name)
			{
				case 'Old':
					return $this->_old;
					break;
				case 'OldVal':
					return '@' . $this->Old . 'Val';
					break;
				case 'OldCol':
					return $this->Old . 'Col';
					break;
				case 'New':
					return $this->_new;
					break;
				case 'NewVal':
					return '@' . $this->New . 'Val';
					break;
				case 'NewCol':
					return $this->New . 'Col';
					break;
			}
		}
		private function compare($fields)
		{
			return compare($fields, $this->Old, $this->New);
		}
		private function oldsub($table, $column)
		{
			return subque($table, $this->Old, $this->NewVal, $this->NewCol, $this->OldVal, $column);
		}
		private function newsub($table, $column)
		{
			return subque($table, $this->New, $this->OldVal, $this->OldCol, $this->NewVal, $column);
		}
		private function rowset($table, $column)
		{
			$oldsub = $this->oldsub($table, $column);
			$newsub = $this->newsub($table, $column);
			return <<<"EOD"
from ($oldsub) as $this->Old
inner join ($newsub) as $this->New
on $this->Old.$column = $this->New.$this->OldCol
EOD;
		}
		private function keyset($table, $column, $primary)
		{
			$rowset = $this->rowset($table, $column);
			return <<<"EOD"
select distinct $this->Old.$primary, $this->New.$primary
$rowset
EOD;
		}
		public function Delete($table, $column)
		{
			$rowset = $this->rowset($table, $column);
			return <<<"EOD"
delete from $this->Old $rowset
EOD;
		}
		public function Update($table, $column)
		{
			$oldsub = $this->oldsub($table, $column);
			return <<<"EOD"
update $this->Old set $this->Old.$column = $this->NewVal from ($oldsub) as $this->Old
EOD;
		}
		public function Change($table, $column)
		{
			$delete = $this->Delete($table, $column);
			$update = $this->Update($table, $column);
			return <<<"EOD"
$delete
$update
EOD;
		}
		public function ChangeEx($table, $column, $fields)
		{
			$delete = $this->Delete($table, $column);
			$update = $this->Update($table, $column);
			$compare = $this->compare($fields);
			return <<<"EOD"
$delete
and $compare
$update
EOD;
		}
		public function CbChangeEx($callback, $table, $column, $fields, $primary)
		{
			$keyset = $this->keyset($table, $column, $primary);
			$update = $this->Update($table, $column);
			$compare = $this->compare($fields);
			return <<<"EOD"
delete from @keys
insert into @keys (oid, nid)
$keyset
and $compare
set @rc = @@rowcount
set @id = scope_identity()
set @i = 0
while @i < @rc
begin
	select @oid = oid, @nid = nid from @keys where id = @id - @i
	exec $callback $this->OldVal = @oid, $this->NewVal = @nid
	set @i = @i + 1
end
$update
EOD;
		}
	}

	$gen = new MyGenerator('old', 'new');

	//echo "\n" . $gen->ChangeEx('dbo.tblGoodsDevide', 'SmallGoodsID', array('BigGoodsID'));
	//echo "\n" . $gen->Change('dbo.tblGoodsDevide', 'BigGoodsID');

	echo $gen->Change('dbo.tblBarcodes', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblNoBarcode', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblGoodsDisabled', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblDvrClsRel', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblGoodsVolumes', 'GoodsID')
		. "\n" . $gen->ChangeEx('dbo.tblGoodsClasses', 'GoodsID', array('IsRetail'))
		. "\n" . $gen->ChangeEx('dbo.tblGoodsDevide', 'SmallGoodsID', array('BigGoodsID'))
		. "\n" . $gen->Change('dbo.tblGoodsDevide', 'BigGoodsID')
		. "\n" . $gen->ChangeEx('dbo.vwClnLnkRel4', 'GoodsID', array('LnkCorpID'))
		. "\n" . $gen->ChangeEx('dbo.vwClnLnkRel123', 'GoodsID', array('LnkCorpID', 'LnkDrugID'))
		. "\n" . $gen->ChangeEx('dbo.tblLnkNoRel', 'GoodsID', array('LnkCorpID'))
		. "\n" . $gen->Change('dbo.tblNDSRel', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblNisDemGoodsForInv', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblOrdListBoxItems', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblInvItems', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblLnkDataStorageStock', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblSCSOrderItems', 'GoodsID')
		// 2011.08.08
		. "\n" . $gen->ChangeEx('dbo.tblIndGoodsSetItems', 'GoodsID', array('IndGoodsSetID'))
		. "\n" . $gen->Update('dbo.tblIndPriceInvItemsTmp', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblInvItemsTmp', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblOrdDiffItems', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblOrdItemsReturns', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblPromoItems', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblSCSOrdDiffItems', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblSerials', 'GoodsID')
		. "\n" . $gen->ChangeEx('dbo.tblWhGoodsCellsLnk', 'GoodsID', array('WhCellID'))
                . "\n" . $gen->Change('dbo.tblGoodsBarcodes', 'GoodsID')
		. "\n" . $gen->Change('dbo.tblGoodsActual', 'GoodsID')
		. "\n" . $gen->Update('dbo.tblGosReestr', 'GoodsID')
                // 2012.05.23
                . "\n" . $gen->Update('dbo.tblDeliveryBoxItems', 'GoodsID')

		. "\n" . $gen->Delete('dbo.tblGoods', 'GoodsID')
		;

	/*
	echo $gen->CbChangeEx('dbo.spClnGoodsChange', 'dbo.tblGoods', 'MakerID', array('DrugID', 'OutFormID'), 'GoodsID')
		. "\n" . $gen->ChangeEx('dbo.tblMakerGroups', 'ParentMakerID', array('MakerID'))
		. "\n" . $gen->ChangeEx('dbo.tblMakerGroups', 'MakerID', array('ParentMakerID'))
		. "\n" . $gen->ChangeEx('dbo.tblLnkMFYDemand', 'MakerID', array('DrugID', 'OutFormID'))
		. "\n" . $gen->Update('dbo.tblSCSOrderItems', 'MakerID')
		. "\n" . $gen->Delete('dbo.tblMakers', 'MakerID')
		;

	echo $gen->CbChangeEx('dbo.spClnGoodsChange', 'dbo.tblGoods', 'OutFormID', array('DrugID', 'MakerID'), 'GoodsID')
		. "\n" . $gen->ChangeEx('dbo.tblLnkMFYDemand', 'OutFormID', array('DrugID', 'MakerID'))
		. "\n" . $gen->ChangeEx('dbo.tblLnkNFRel', 'OutFormID', array('DrugID', 'LnkDrugID'))
		. "\n" . $gen->ChangeEx('dbo.tblLnkNFNoRel', 'OutFormID', array('DrugID', 'LnkCorpID'))
		. "\n" . $gen->Update('dbo.tblSCSOrderItems', 'OutFormID')
		. "\n" . $gen->Delete('dbo.tblOutForms', 'OutFormID')
		;
	*/
?>
