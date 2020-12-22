{?xml version="1.0" encoding="windows-1251"?}
{tpl}
	{blk id="main"}
		{txt}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">{/txt}
		{txt}<html xmlns="http://www.w3.org/1999/xhtml">{/txt}
		{txt}
		<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
		<style type="text/css">@import url('/css/main.css');</style>
		<style type="text/css">@import url('/sas/main.css');</style>
		<!--[if lt IE 7]>
		<style type="text/css">@import url('/css/ie.css');</style>
		<![endif]-->
	    	<title>
		{/txt}{var id="headTitle" /}{txt}
		</title>
	  	</head>
	  	<body class="margin_auto_outer">
		<form action="" method="get">
			<span style="margin: 0 0 0 10px;">уровень вещи:</span>
                        <select name="level">
                                <option value="">[all]</option>
                                <option value="40" {/txt}{var id="level_40" /}{txt}>40</option>
                                <option value="41" {/txt}{var id="level_41" /}{txt}>41</option>
                                <option value="42" {/txt}{var id="level_42" /}{txt}>42</option>
                                <option value="43" {/txt}{var id="level_43" /}{txt}>43</option>
                                <option value="44" {/txt}{var id="level_44" /}{txt}>44</option>
                                <option value="45" {/txt}{var id="level_45" /}{txt}>45</option>
                                <option value="46" {/txt}{var id="level_46" /}{txt}>46</option>
                                <option value="47" {/txt}{var id="level_47" /}{txt}>47</option>
                                <option value="48" {/txt}{var id="level_48" /}{txt}>48</option>
                                <option value="49" {/txt}{var id="level_49" /}{txt}>49</option>
                                <option value="50" {/txt}{var id="level_50" /}{txt}>50</option>
                                <option value="51" {/txt}{var id="level_51" /}{txt}>51</option>
                                <option value="52" {/txt}{var id="level_52" /}{txt}>52</option>
                                <option value="53" {/txt}{var id="level_53" /}{txt}>53</option>
                                <option value="54" {/txt}{var id="level_54" /}{txt}>54</option>
                                <option value="55" {/txt}{var id="level_55" /}{txt}>55</option>
                                <option value="56" {/txt}{var id="level_56" /}{txt}>56</option>
                                <option value="57" {/txt}{var id="level_57" /}{txt}>57</option>
                                <option value="58" {/txt}{var id="level_58" /}{txt}>58</option>
                                <option value="59" {/txt}{var id="level_59" /}{txt}>59</option>
                                <option value="60" {/txt}{var id="level_60" /}{txt}>60</option>
                                <option value="61" {/txt}{var id="level_61" /}{txt}>61</option>
                                <option value="62" {/txt}{var id="level_62" /}{txt}>62</option>
                                <option value="63" {/txt}{var id="level_63" /}{txt}>63</option>
                                <option value="64" {/txt}{var id="level_64" /}{txt}>64</option>
                                <option value="65" {/txt}{var id="level_65" /}{txt}>65</option>
                        </select>
			<span style="margin: 0 0 0 10px;">тип вещи:</span>
			<select name="type">
				<option value="">[all]</option>
				<option value="1" {/txt}{var id="type_1" /}{txt}>Меч</option>
				<option value="2" {/txt}{var id="type_2" /}{txt}>Нож</option>
				<option value="3" {/txt}{var id="type_3" /}{txt}>Молот</option>
				<option value="4" {/txt}{var id="type_4" /}{txt}>Дополнительный Меч</option>
				<option value="5" {/txt}{var id="type_5" /}{txt}>Двуручный Меч</option>
				<option value="6" {/txt}{var id="type_6" /}{txt}>Алебарда</option>
				<option value="7" {/txt}{var id="type_7" /}{txt}>Тяжелая броня</option>
				<option value="8" {/txt}{var id="type_8" /}{txt}>Тяжелые Сапоги</option>
				<option value="9" {/txt}{var id="type_9" /}{txt}>Кольчужные Сапоги</option>
				<option value="10" {/txt}{var id="type_10" /}{txt}>Легкие Сапоги</option>
				<option value="11" {/txt}{var id="type_11" /}{txt}>Тяжелые Перчатки</option>
				<option value="12" {/txt}{var id="type_12" /}{txt}>Кольчужные Перчатки</option>
				<option value="13" {/txt}{var id="type_13" /}{txt}>Легкие Перчатки</option>
				<option value="14" {/txt}{var id="type_14" /}{txt}>Кольчуга</option>
				<option value="15" {/txt}{var id="type_15" /}{txt}>Легкая Броня</option>
				<option value="16" {/txt}{var id="type_16" /}{txt}>Тяжелый Шлем</option>
				<option value="17" {/txt}{var id="type_17" /}{txt}>Кольчужный Шлем</option>
				<option value="18" {/txt}{var id="type_18" /}{txt}>Легкий Шлем</option>
				<option value="19" {/txt}{var id="type_19" /}{txt}>Кольцо Рыцаря</option>
				<option value="20" {/txt}{var id="type_20" /}{txt}>Кольцо Снайпера</option>
				<option value="21" {/txt}{var id="type_21" /}{txt}>Кольцо Убийцы</option>
				<option value="22" {/txt}{var id="type_22" /}{txt}>Тяжелый Щит</option>
				<option value="23" {/txt}{var id="type_23" /}{txt}>Средний Щит</option>
				<option value="24" {/txt}{var id="type_24" /}{txt}>Легкий Щит</option>
				<option value="25" {/txt}{var id="type_25" /}{txt}>Ружье</option>
			</select>
			<span style="margin: 0 0 0 10px;">тип дропа:</span>
                        <select name="drop_class">
				<option value="">[all]</option>
                                <option value="1" {/txt}{var id="drop_class_1" /}{txt}>10% (черное)</option>
                                <option value="2" {/txt}{var id="drop_class_2" /}{txt}>20% (синее)</option>
                                <option value="3" {/txt}{var id="drop_class_3" /}{txt}>30% (красное)</option>
                                <option value="4" {/txt}{var id="drop_class_4" /}{txt}>40% (фиолетовое)</option>
                                <option value="5" {/txt}{var id="drop_class_5" /}{txt}>50% (оранжевое)</option>
                        </select>
			<input type="submit" value="ok" />
		</form>
		{/txt}
		{blk id="things"}
			{txt}<div class="things">{/txt}
			{blk id="thing"}
				{txt}<br /><br /><div class="thing drop_{/txt}{var id="thing.drop_class" /}{txt}"><a href="http://www.dreamwar.ru/item.php?id={/txt}
				{var id="thing.id" /}
				{txt}">{/txt}
				{var id="thing.name" /}
				{txt}[{/txt}{var id="thing.level" /}
				{txt}]</a></div><span>{/txt}{var id="thing.opis" /}{txt}</span>{/txt}
			{/blk}
			{txt}</div>{/txt}
		{/blk}
		{txt}
	  	</body>
		</html>
		{/txt}
	{/blk}
{/tpl}
