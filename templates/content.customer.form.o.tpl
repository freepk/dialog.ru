{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.customer.form"}
		{txt}
		<div style="margin: 5px 0 0 0;">&nbsp;<span style="color: red;">*</span>&nbsp; - поля обязательные для заполнения.</div>
		<form action="/?action=order" method="post" style="margin: 5px 0 0 0;">
		<input type="hidden" name="event" value="finish" />
		<table summary="" cellpadding="0" cellspacing="1" style="width: 520px; margin: 5px 0 0 0;">
			<tbody>
				<tr>
					<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Фамилия Имя Отчество:</td>
					<td style="width: 270px;"><input maxlength="50" style="width: 265px;" type="text" name="fullName" value="{/txt}{var id="params.fullName" /}{txt}" /></td>
				</tr>
				<tr>
					<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Телефон&nbsp;<span style="color: red;">*</span>&nbsp;:</td>
					<td style="width: 270px;"><input maxlength="20" style="width: 265px;" type="text" name="phone" value="{/txt}{var id="params.phone" /}{txt}" /></td>
				</tr>
				<tr>
					<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Адрес:</td>
					<td style="width: 270px;"><input maxlength="200" style="width: 265px;" type="text" name="address" value="{/txt}{var id="params.address" /}{txt}" /></td>
				</tr>
				<tr>
					<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Дополнительно:</td>
					<td style="width: 270px;"><textarea style="width: 265px; height: 100px;" name="comment"
						onkeyup="if(this.value.length>255)this.value=this.value.substring(0,255);"
						onblur="if(this.value.length>255)this.value=this.value.substring(0,255);"
					>{/txt}{var id="params.comment" /}{txt}</textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="right"><input style="width: 130px; margin: 5px 0 0 0;" type="submit" value="Оформить заказ" /></td>
				</tr>
			</tbody>
		</table>
		</form>	
		{/txt}
	{/blk}
{/tpl}
