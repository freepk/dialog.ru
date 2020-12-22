{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.feedback"}
		{blk id="content.feedback.compose"}
			{blk id="content.feedback.compose.errors"}
				{txt}<div>{/txt}
				{blk id="content.feedback.compose.errors.error"}
					{txt}<div>{/txt}{var id="error" /}{txt}</div>{/txt}
				{/blk}
				{txt}</div>{/txt}
			{/blk}
			{blk id="content.feedback.compose.form"}
				{txt}
				<form action="/?action=feedback" method="post">
				<input type="hidden" name="event" value="finish" />
				<table summary="" cellpadding="0" cellspacing="1" style="width: 520px; margin: 5px 0 0 0;">
					<tbody>
						<tr>
							<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Ваше ФИО&nbsp;<span style="color: red;">*</span>&nbsp;:</td>
							<td style="width: 270px;"><input style="width: 265px;" type="text" name="fullName" value="{/txt}{var id="params.fullName.value" /}{txt}" /></td>
						</tr>
						<tr>
							<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Ваш e-mail&nbsp;<span style="color: red;">*</span>&nbsp;:</td>
							<td style="width: 270px;"><input style="width: 265px;" type="text" name="email" value="{/txt}{var id="params.email.value" /}{txt}" /></td>
						</tr>
						<tr>
							<td style="width: 250px; background-color: rgb(236,250,209); vertical-align: top;">Ваш вопрос&nbsp;<span style="color: red;">*</span>&nbsp;:</td>
							<td style="width: 270px;"><textarea style="width: 265px; height: 100px;" name="message">{/txt}{var id="params.message.value" /}{txt}</textarea></td>
						</tr>
						<tr>
							<td colspan="2" align="right"><input style="width: 130px; margin: 5px 0 0 0;" type="submit" value="Отправить" /></td>
						</tr
					</tbody>
				</table>
				</form>
				{/txt}
			{/blk}
		{/blk}
		{blk id="content.feedback.success"}
			{txt}<span>Спасибо! Ваше сообщение успешно отправлено.</span>{/txt}
		{/blk}
		{blk id="content.feedback.fault"}
			{txt}<span>Во время отправки сообщения прошла ошибка.</span>{/txt}
		{/blk}
	{/blk}
{/tpl}