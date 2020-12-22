<?php
	function parseFilials()
	{
		global $tpl, $_PATH_TPL, $_PATH_SCR;
		$tpl->Load($_PATH_TPL . '/content.filials.tpl');
		if(isset($_GET['location']))
		{
			switch($_GET['location'])
			{
				case 'aviamotornaja':
					$tpl->Parse('content.filials.aviamotornaja');
					break;
				case 'kurskaja':
					$tpl->Parse('content.filials.kurskaja');
					break;
				case 'buninskaja':
					$tpl->Parse('content.filials.buninskaja');
					break;
				case 'varshavskaja':
					$tpl->Parse('content.filials.varshavskaja');
					break;
				case 'vdnh':
					//$tpl->Parse('content.filials.vdnh');
					require_once($_PATH_SCR . '/content.410.php');
					break;
				case 'domodedovskaja':
					$tpl->Parse('content.filials.domodedovskaja');
					break;
				case 'vernadskogo':
					$tpl->Parse('content.filials.vernadskogo');
					break;
				case 'balashiha':
					$tpl->Parse('content.filials.balashiha');
					break;
				case 'korolev':
					$tpl->Parse('content.filials.korolev');
					break;
				case 'protvino-lenina9':
					$tpl->Parse('content.filials.protvino-lenina9');
					break;
				case 'protvino-lenina15':
					$tpl->Parse('content.filials.protvino-lenina15');
					break;
				case 'serpuhov':
					$tpl->Parse('content.filials.serpuhov');
					break;
				case 'troick':
					$tpl->Parse('content.filials.troick');
					break;
				case 'shelkovo':
					$tpl->Parse('content.filials.shelkovo');
					break;
				case 'sherbinka':
					$tpl->Parse('content.filials.sherbinka');
					break;
				case 'ivanteevka':
					$tpl->Parse('content.filials.ivanteevka');
					break;
				case 'marjino':
					$tpl->Parse('content.filials.marjino');
					break;
                                case 'sokol':
                                        $tpl->Parse('content.filials.sokol');
                                        break;
			}
		}
		$tpl->Parse('content.filials');
	}
	parseFilials();
?>
