{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.goods.list"}
		{txt}<table summary="" cellpadding="1" cellspacing="0" style="width: 100%; margin: 10px 0 0 0;">{/txt}
		{blk id="content.goods.list.item"}
			{txt}<tr class="{/txt}{var id="evenOrOdd" /}{txt}">{/txt}
			{blk id="content.goods.list.item.image"}
				{txt}
				<td style="width: 100px;">
				<a href="/{/txt}{var id="goods.urlPath" /}{txt}/{/txt}{var id="goods.urlTitle" /}{txt}_{/txt}{var id="goods.goodsId" /}{txt}.html">
				{/txt}
				{blk id="content.goods.list.item.image.normal"}
					{txt}<img src="/images/goods/{/txt}{var id="goods.goodsId" /}{txt}_100.jpg" width="100" height="100" alt="{/txt}{var id="goods.drugTitle" /}{txt}" style="border: 1px solid black;" />{/txt}
				{/blk}
				{blk id="content.goods.list.item.image.empty"}
					{txt}<img src="/images/nophoto.gif" width="100" height="100" alt="{/txt}{var id="goods.drugTitle" /}{txt}" style="border: 1px solid black;" />{/txt}
				{/blk}
				{txt}</a></td>{/txt}
			{/blk}
			{txt}
			<td style="vertical-align: center; padding: 0 0 0 10px;">
			<a href="/{/txt}{var id="goods.urlPath" /}{txt}/{/txt}{var id="goods.urlTitle" /}{txt}_{/txt}{var id="goods.goodsId" /}{txt}.html">
			{/txt}
			{txt}<span>{/txt}{var id="goods.drugTitle" /}{txt}</span><br />{/txt}
			{txt}<span>{/txt}{var id="goods.outFormTitle" /}{txt}</span><br />{/txt}
			{txt}<span>{/txt}{var id="goods.makerTitle" /}{txt}</span>{/txt}
			{txt}
			</a>
			</td>
			<td style="vertical-align: center; text-align: right; font-size: 120%;">{/txt}{var id="goods.drugCost" /}{txt}</td>
			<td style="vertical-align: center; text-align: right; width: 140px;">
			<form action="/?action=order" method="post" style="margin: 0; padding: 0;">
			<input type="hidden" name="event" value="change" style="" />
			{/txt}
			{txt}<input type="text" maxlength="3" size="3" style="text-align: right; width: 30px; position: relative; top: -1px;" name="orderItems[{/txt}{var id="goods.goodsId" /}{txt}][drugCount]" value="1" />{/txt}
			{txt}
			<input type="submit" value="В корзину" style="width: 90px;" />
			</form>
			</td>
			</tr>
			{/txt}
		{/blk}
		{txt}</table>{/txt}
	{/blk}
{/tpl}
