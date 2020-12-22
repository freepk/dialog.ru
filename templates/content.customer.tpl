{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.customer"}
		{blk id="content.customer.errors"}
			{txt}<div>{/txt}
			{blk id="content.customer.errors.error"}
				{txt}<div>{/txt}{var id="error" /}{txt}</div>{/txt}
			{/blk}
			{txt}</div>{/txt}
		{/blk}
		{ref id="content.customer.form" /}
	{/blk}
{/tpl}