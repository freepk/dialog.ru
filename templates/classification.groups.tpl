{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="classification.groups"}
		{blk id="classification.group"}
			{txt}
			<div>
			<div class="bg_name_bottom" style="margin: 10px 0 0 0; float: left; width: 100%;">
			<div class="bg_name_center" style="float: left;">
			<div class="bg_name_left" style="float: left;">
			<div class="bg_name_right" style="float: left; height: 24px; padding: 3px 15px 0 15px; color: rgb(255,255,255); font-size: 15px; font-weight: bold;">
			<a style="color: rgb(255,255,255); text-decoration: none;"
				href="/{/txt}{var id="group.urlPath" /}{txt}/">
			{/txt}
			{var id="group.groupTitle" /}
			{txt}&nbsp;({/txt}
			{var id="group.goodsCount" /}
			{txt})</a>
			</div>
			</div>
			</div>
			</div>
			<br style="clear: both;" />
			{/txt}
			{ref id="classification.subGroups" /}
			{txt}</div>{/txt}
		{/blk}
	{/blk}
{/tpl}