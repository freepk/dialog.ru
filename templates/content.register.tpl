{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.register"}
		{txt}<div id="register">{/txt}
		{blk id="content.registration.success"}
			{txt}<span>����������� ������� ���������</span>{/txt}
		{/blk}
		{blk id="content.registration.fault"}
			{txt}<span>�� ����� ����������� ��������� ������</span>{/txt}
		{/blk}
		{ref id="content.customer" /}
		{txt}</div>{/txt}
	{/blk}
{/tpl}