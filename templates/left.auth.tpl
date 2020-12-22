{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="left.auth"}
		{txt}<div style="padding: 5px 0 5px 5px; background-color: rgb(255,255,255);">{/txt}
		{blk id="left.auth.enter"}
			{txt}
			<form action="/?action=enter" method="post" style="margin: 0; padding: 0;">
				<div><input type="text" name="login" onclick="this.value='';" value="E-Mail" /></div>
				<div style="margin: 5px 0 0 0;"><input type="password" name="password" /><input type="submit" value="Войти" style="margin: 0 0 0 5px;" /></div>
			</form>{/txt}
			{txt}<div style="margin: 5px 0 0 0;"><a href="/?action=register">Регистрация</a></div>{/txt}
		{/blk}
		{blk id="left.auth.exit"}
			{txt}<div>{/txt}{var id="customer.fullName" /}{txt}</div>{/txt}
			{txt}<div style="margin: 5px 0 0 0;"><a href="/?action=exit">Выйти</a></div>{/txt}
		{/blk}
		{txt}</div>{/txt}
	{/blk}
{/tpl}