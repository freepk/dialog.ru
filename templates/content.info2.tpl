{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="content.info"}
		{txt}<div>{/txt}
		{blk id="content.info.description"}
			{txt}<div>{/txt}
			{blk id="content.info.description.image"}
				{txt}<div style="float: right;">{/txt}
				{blk id="content.info.description.image.normal"}
					{txt}<img src="/images/goods/{/txt}{var id="goods.goodsId" /}{txt}_240.jpg" width="240" height="240" style="border: 1px solid black;" alt="{/txt}{var id="goods.drugTitle" /}{txt}" />{/txt}
				{/blk}
				{blk id="content.info.description.image.empty"}
					{txt}<img src="/images/nophotox.gif" width="240" height="240" style="border: 1px solid black;" alt="{/txt}{var id="goods.drugTitle" /}{txt}" />{/txt}
				{/blk}
				{txt}</div>{/txt}
			{/blk}
			{txt}
			<div style="overflow: auto;">
				<span style="font-size: 150%;">{/txt}{var id="goods.drugTitle" /}{txt}</span><br />
        <span style="font-size: 110%;">{/txt}{var id="goods.outFormTitle" /}{txt}</span><br />
        <span style="font-size: 110%;">{/txt}{var id="goods.makerTitle" /}{txt}</span>
			</div>
		  <form action="/?action=order" method="post" style="margin: 10px 0 0 0;">
		    <input type="hidden" name="event" value="change" />
		    <span style="font-size: 120%;">{/txt}{var id="goods.drugCost" /}{txt}&nbsp;руб.</span>
		    <input type="text" maxlength="3" size="3"
		    	style="text-align: right; width: 30px;"
		    	name="orderItems[{/txt}{var id="goods.goodsId" /}{txt}][drugCount]" value="1" />
		    <input type="submit" value="В корзину"
		    	style="width: 90px;" />
		  </form>
			{/txt}
			{blk id="content.info.description.extension"}
				{blk id="content.info.description.extension.item"}
					{txt}<p><span><b>{/txt}{var id="extension.field" /}{txt}</b></span><br /><span>{/txt}{var id="extension.text" /}{txt}</span></p>{/txt}
				{/blk}
			{/blk}
			{txt}<div style="clear: both;" /></div>{/txt}
		{/blk}
		{blk id="content.info.outForms"}
			{txt}
      <div class="bg_name_bottom" style="margin: 10px 0 0 0; float: left; width: 100%;">
        <div class="bg_name_center" style="float: left;">
          <div class="bg_name_left" style="float: left;">
            <div class="bg_name_right" style="float: left; height: 24px; padding: 3px 15px 0 15px; color: rgb(255,255,255); font-size: 15px; font-weight: bold;">
              <span style="color: rgb(255,255,255);">Формы выпуска</span>
            </div>
          </div>
        </div>
      </div><br style="clear: both;" />
			{/txt}
			{ref id="content.goods.list" /}
		{/blk}
		{blk id="content.info.synonims"}
			{txt}
      <div class="bg_name_bottom" style="margin: 10px 0 0 0; float: left; width: 100%;">
        <div class="bg_name_center" style="float: left;">
          <div class="bg_name_left" style="float: left;">
            <div class="bg_name_right" style="float: left; height: 24px; padding: 3px 15px 0 15px; color: rgb(255,255,255); font-size: 15px; font-weight: bold;">
              <span style="color: rgb(255,255,255);">Аналоги</span>
            </div>
          </div>
        </div>
      </div><br style="clear: both;" />
			{/txt}
			{ref id="content.goods.list" /}
		{/blk}
		{txt}</div>{/txt}
	{/blk}
{/tpl}