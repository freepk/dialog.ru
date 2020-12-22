{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.register"}
		{txt}<div id="register">{/txt}
		{blk id="content.registration.success"}
			{txt}<span>Регистрация успешно завершена</span>{/txt}
		{/blk}
		{blk id="content.registration.fault"}
			{txt}<span>Во время регистрации произошла ошибка</span>{/txt}
		{/blk}
		{ref id="content.customer" /}
		{txt}</div>{/txt}
	{/blk}
{/tpl}