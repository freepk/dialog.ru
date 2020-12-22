{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.pager"}
		{txt}<br style="clear: both;" /><div style="margin: 5pt 0 0 0;">{/txt}
		{blk id="content.pager.info"}
			{txt}<span>Показано&nbsp;<b>{/txt}
			{var id="pager.itemFirst" /}
			{txt}</b>&nbsp;-&nbsp;<b>{/txt}
			{var id="pager.itemLast" /}
			{txt}</b>&nbsp;(всего&nbsp;<b>{/txt}
			{var id="pager.itemCount" /}
			{txt}</b>)</span>{/txt}
		{/blk}
		{blk id="content.pager.pages"}
			{blk id="content.pager.back"}
				{txt}<span style="margin: 0 0 0 5pt;"><a href="{/txt}{var id="pager.baseUri"/}{var id="pager.pagerBack" /}{txt}">&lt;&lt;</a></span>{/txt}
			{/blk}
			{blk id="content.pager.page"}
				{blk id="content.pager.page.normal"}
					{txt}<span style="margin: 0 0 0 5pt;"><a href="{/txt}{var id="pager.baseUri"/}{var id="page" /}{txt}">{/txt}{var id="page" /}{txt}</a></span>{/txt}
				{/blk}
				{blk id="content.pager.page.selected"}
					{txt}<span style="margin: 0 0 0 5pt;font-size: 120%;">{/txt}{var id="page" /}{txt}</span>{/txt}
				{/blk}
			{/blk}
			{blk id="content.pager.forward"}
				{txt}<span style="margin: 0 0 0 5pt;"><a href="{/txt}{var id="pager.baseUri"/}{var id="pager.pagerForward" /}{txt}">&gt;&gt;</a></span>{/txt}
			{/blk}
		{/blk}
		{txt}</div>{/txt}
	{/blk}
{/tpl}
