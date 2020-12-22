{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="main.content"}
		{txt}
		<div style="padding: 0 10px 0 10px;">
			<div class="bg_banner">
				<div class="bg_banner_left">
					<div class="bg_banner_right">
		        			<form method="get" action="/" style="margin: 0;">
		          			<input type="hidden" name="action" value="goods" />
		          			<input type="hidden" name="filter" value="keyword" />
		          			<table summary="" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tr>
		              				<td style="padding: 0 0 0 5px; width: 100%;"><input type="text" name="value" onclick="this.value='';" value="Поиск препаратов" style="width: 98%;" /></td>
		              				<td style="padding: 0;"><input type="submit" value="Найти" style="width: 60px;" /></td>
							<td><img src="/images/banner.gif" alt="" style="margin: 0 0 0 10px;" /></td>
						</tr>
						</table>
		        			</form>
					</div>
				</div>
			</div>
		{/txt}
		{ref id="content.path" /}
		{ref id="content.search" /}
		{ref id="content.classification" /}
		{ref id="content.catalogue" /}
		{ref id="content.goods" /}
		{ref id="content.order" /}
		{ref id="content.info" /}
		{ref id="content.register" /}
		{ref id="content.enter" /}
		{ref id="content.exit" /}
		{ref id="content.about" /}
		{ref id="content.delivery" /}
		{ref id="content.vacancy" /}
		{ref id="content.filials" /}
		{ref id="content.feedback" /}
		{txt}</div>{/txt}
	{/blk}
{/tpl}
