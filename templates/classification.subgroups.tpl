{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="classification.subGroups"}
		{txt}<div>{/txt}
		{blk id="classification.subGroups.column"}
			{txt}<ul style="float:left; width: 50%; margin: 0; padding: 0; list-style: none;" class="subgroup">{/txt}
			{blk id="classification.subGroups.line"}
				{blk id="classification.subGroups.line.normal"}
					{txt}<li class="bg_bullet_green" style="padding: 0 0 0 15px;">{/txt}
					{txt}
					<a href="/{/txt}{var id="group.urlPath" /}{txt}/">
					{/txt}
					{var id="group.groupTitle" /}
					{txt}&nbsp;({/txt}
					{var id="group.goodsCount" /}
					{txt})</a>{/txt}
					{txt}</li>{/txt}
				{/blk}
				{blk id="classification.subGroups.line.selected"}
					{txt}<li class="bg_bullet_red" style="padding: 0 0 0 15px;">{/txt}
					{var id="group.groupTitle" /}
					{txt}&nbsp;({/txt}
					{var id="group.goodsCount" /}
					{txt}){/txt}
					{txt}</li>{/txt}
				{/blk}
			{/blk}
			{txt}</ul>{/txt}
		{/blk}
		{txt}<div style="clear: both;" /></div>{/txt}
	{/blk}
{/tpl}