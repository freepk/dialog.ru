{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.order"}
		{txt}<div class="order">{/txt}
		{blk id="content.order.empty"}
			{txt}<span>Ваша корзина пуста</span>{/txt}
		{/blk}
		{blk id="content.order.success"}
			{txt}<p>Оформление заказа прошло успешно. Через несколько минут с Вами свяжется оператор.</p><p>Спасибо за заказ!</p>{/txt}
		{/blk}
		{blk id="content.order.fault"}
			{txt}<p>Во время оформления произошла ошибка</p>{/txt}
		{/blk}
		{blk id="content.order.normal"}
			{txt}
			<form action="/?action=order" method="post" style="margin: 0;">
			<input type="hidden" name="event" value="change" />
			<table summary="" cellpadding="0" cellspacing="0" style="width: 520px; margin: 5px 0 0 0;">
				<tr>
					<th style="vertical-align: top; width: 50px;">Удал.</th>
					<th style="vertical-align: top; width: 300px;">Препарат</th>
					<th style="vertical-align: top; width: 50px; text-align: right;">Цена<br />руб.</th>
					<th style="vertical-align: top; width: 50px; text-align: right;">Кол-во</th>
					<th style="vertical-align: top; width: 70px; text-align: right;">Сумма<br />руб.</th>
				</tr>
			{/txt}
			{blk id="content.order.normal.orderItem"}
				{txt}
				<tr class="{/txt}{var id="evenOrOdd" /}{txt}">
					<td style="text-align: center; vertical-align: center; width: 20px;"><input type="checkbox" name="orderItems[{/txt}{var id="orderItem.goodsId" /}{txt}][deleteMe]"/></td>
					<td>
						<a href="/{/txt}{var id="orderItem.urlPath" /}{txt}/{/txt}{var id="orderItem.urlTitle" /}{txt}_{/txt}{var id="orderItem.goodsId" /}{txt}.html">
							<span>{/txt}{var id="orderItem.drugTitle" /}{txt}</span><br />
							<span>{/txt}{var id="orderItem.outFormTitle" /}{txt}</span><br />
							<span>{/txt}{var id="orderItem.makerTitle" /}{txt}</span>
						</a>
					</td>
					<td style="vertical-align: center; text-align: right;">{/txt}{var id="orderItem.drugCost" /}{txt}</td>
					<td style="vertical-align: center; text-align: right;">
						<input type="text" maxlength="3" size="3" style="text-align: right; width: 30px; position: relative; top: -1px;" name="orderItems[{/txt}{var id="orderItem.goodsId" /}{txt}][drugCount]" value="{/txt}{var id="orderItem.drugCount" /}{txt}" />
					</td>
					<td style="vertical-align: center; text-align: right;">{/txt}{var id="orderItem.summary" /}{txt}</td>
				</tr>
				{/txt}
			{/blk}
			{blk id="content.order.normal.delivery"}
				{txt}
				<tr>	
					<td style="vertical-align: center; text-align: right;" colspan="4" align="right">Доставка (для заказов на сумму меньше 900 рублей):</td>
					<td style="vertical-align: center; text-align: right;">{/txt}{var id="order.delivery" /}{txt}</td>
				</tr>
				{/txt}
			{/blk}
			{txt}
			<tr>
				<td style="vertical-align: center; text-align: right;" colspan="4">Итого:</td>
				<td style="vertical-align: center; text-align: right;">{/txt}{var id="order.summary" /}{txt}</td>
			</tr>
			<tr>
				<td colspan="5" style="vertical-align: top; text-align: right;">
					<button style="margin: 5px 0 0 0;" type="button" onclick="document.location.href='http://83.222.15.53/';">Продолжить<br />покупки</button>
					<input style="width: 130px; margin: 5px 0 0 0;" type="submit" value="Пересчитать" />
				</td>
			</tr>
			</table>
			</form>
			{/txt}
			{ref id="content.customer" /}
		{/blk}
		{txt}</div>{/txt}
	{/blk}
{/tpl}
