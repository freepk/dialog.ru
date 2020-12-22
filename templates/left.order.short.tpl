{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="left.order.short"}
		{blk id="left.order.short.empty"}
			{txt}
			<div class="bg_basket_top" style="padding: 10px 0 5px 65px; color: rgb(255, 255, 255); font-weight: bold; text-decoration: none; font-size: 120%;">
				<span>Ваша корзина:</span><br />
				<span>нет товаров</span>
			</div>
			{/txt}
		{/blk}
		{blk id="left.order.short.normal"}
			{txt}
			<div class="bg_basket_top" style="padding: 10px 0 5px 65px; color: rgb(255, 255, 255); font-weight: bold; text-decoration: none; font-size: 120%;">
				<a href="/?action=order" style="color: rgb(255, 255, 255);">Ваша корзина:</a><br />
				<span>Сумма:</span>
				<span>{/txt}{var id="order.summary" /}{txt}</span>
			</div>
			<table class="bg_basket_center" summary="" cellpadding="0" cellspacing="0" style="width: 100%; color: rgb(37, 37, 37);">
			{/txt}
			{blk id="left.order.short.normal.orderItem"}
			{txt}
			<tr>
				<td style="width: 125px; text-align: left; vertical-align: top; padding: 5px 0 0 15px;">
				<a style="color: rgb(37, 37, 37);" href="/{/txt}{var id="orderItem.urlPath" /}{txt}/{/txt}{var id="orderItem.urlTitle" /}{txt}_{/txt}{var id="orderItem.goodsId" /}{txt}.html">{/txt}
				{var id="orderItem.drugTitle" /}
				{txt}
				</a>
				</td>
				<td style="width: 25px; text-align: right; vertical-align: top; padding: 5px 5px 0 0;">{/txt}{var id="orderItem.drugCount" /}{txt}</td>
				<td style="width: 60px; text-align: right; vertical-align: top; padding: 5px 10px 0 0;">{/txt}{var id="orderItem.drugCost" /}{txt}</td>
			</tr>
			{/txt}
			{/blk}
			{blk id="left.order.short.normal.delivery"}
				{txt}
				<tr>
					<td style="width: 125px; text-align: left; vertical-align: top; padding: 5px 0 0 15px;">Доставка</td>
					<td style="width: 25px; text-align: right; vertical-align: top; padding: 5px 5px 0 0;">1</td>
					<td style="width: 60px; text-align: right; vertical-align: top; padding: 5px 10px 0 0;">{/txt}{var id="order.delivery" /}{txt}</td>
				</tr>
				{/txt}
			{/blk}
			{txt}
			</table>
			{/txt}
		{/blk}
		{txt}<div class="bg_basket_bottom" style="height: 23px;"></div>{/txt}
	{/blk}
{/tpl}