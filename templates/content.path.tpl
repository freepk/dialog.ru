{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.path"}
		{txt}<ul style="list-style-type: none; margin: 10px 0 10px 0; padding: 0; font-size: 18px; font-weight: bold; color: rgb(95, 149, 37);">{/txt}
		{blk id="content.path.folder"}
			{blk id="content.path.folder.splitter"}
				{txt}<li style="display: inline; margin: 0 0 0 0;">&nbsp;/&nbsp;</li>{/txt}
			{/blk}
			{blk id="content.path.folder.normal"}
				{txt}<li style="display: inline; margin: 0 0 0 0;"><a style="color: rgb(95, 149, 37);" href="{/txt}{var id="folder.url" /}{txt}">{/txt}{var id="folder.title" /}{txt}</a></li>{/txt}
			{/blk}
			{blk id="content.path.folder.nourl"}
				{txt}<li style="display: inline; margin: 0 0 0 0;">{/txt}{var id="folder.title" /}{txt}</li>{/txt}
			{/blk}
		{/blk}
		{txt}</ul>{/txt}
	{/blk}
{/tpl}