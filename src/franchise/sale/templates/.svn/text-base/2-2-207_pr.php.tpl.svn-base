{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border=0 width="100%" height="90%" class="M_Table">
    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

<table class="List_Table" border="1" width="100%">
    {foreach key=j from=$page_data item=item}
    <tr class="Result1"{if bcmod($j, 20) == 0 && $j != 0} style="page-break-before: always;"{/if}>
        <td align="right">{$j+1}</td>
		<td align="left">{$page_data[$j][20]}<br>{$page_data[$j][0]}</td>
        {if $var.group_kind == "2"}
		<td align="left">{$page_data[$j][24]}<br>{$page_data[$j][25]}</td>
        {/if}
        {if $page_data[$j][16] == 'f'}
    		<td align="left"><a href="2-2-202.php?sale_id={$page_data[$j][1]}&renew_flg=true">{$page_data[$j][2]}</a></td>
        {else}
    		<td align="left"><a href="2-2-201.php?sale_id={$page_data[$j][1]}&renew_flg=true">{$page_data[$j][2]}</a></td>
        {/if}
        <td align="center">{$page_data[$j][3]}</td>
		<td align="left">{$page_data[$j][4]}{$page_data[$j][5]}</td>
        <td align="center">{$page_data[$j][21]}</td>

		{if $page_data[$j][21] == '掛売上' || $page_data[$j][21] == '掛返品' || $page_data[$j][21] == '掛値引' || $page_data[$j][21] == '割賦売上'}
			{if $page_data[$j][12] < 0}
	        <td align="right"><font color="red">{$page_data[$j][12]}</font></td>
	        {else}
	        <td align="right">{$page_data[$j][12]}</td>
	        {/if}
			{if $page_data[$j][14] < 0}
	        <td align="right"><font color="red">{$page_data[$j][14]}</font></td>
	        {else}
	        <td align="right">{$page_data[$j][14]}</td>
			{/if}
			<td align="right">　</td>
			<td align="right">　</td>
		{else}
			<td align="right">　</td>
			<td align="right">　</td>
			{if $page_data[$j][12] < 0}
	        <td align="right"><font color="red">{$page_data[$j][12]}</font></td>
	        {else}
	        <td align="right">{$page_data[$j][12]}</td>
	        {/if}
			{if $page_data[$j][14] < 0}
	        <td align="right"><font color="red">{$page_data[$j][14]}</font></td>
	        {else}
	        <td align="right">{$page_data[$j][14]}</td>
			{/if}
		{/if}

		{*分割回数*}
		{if $page_data[$j][21] == "割賦売上"}
        	<td align="right"><a href="2-2-214.php?sale_id={$page_data[$j][1]}&division_flg=true">{$page_data[$j][23]}回</a></td>
        {else}
        	<td></td>
        {/if}

		{if $page_data[$j][15] == '○' || ($page_data[$j][16] == 'f' && $page_data[$j][17] == NULL) || $page_data[$j][19] == 't' || $page_data[$j][18] == '2' || $page_data[$j][18] == '3'}
			<td align="center">{$page_data[$j][15]}</td>
			<td align="center">　</td>
			<td align="center">　</td>
			<td align="center">　</td>
		{else}
			<td align="center">{$page_data[$j][15]}</td>

			{if $page_data[$j][16] == 't'}
				<td align="center"><a href="2-2-201.php?sale_id={$page_data[$j][1]}">変更</a></td>
				<td align="center">　</td>
				{if $var.disabled == NULL}
					<td align="center"><a href="#" onClick="return Dialogue_1('削除します。',{$page_data[$j][1]},'hdn_delete_id');">削除</a></td>
				{else}
					<td align="center">　</td>
				{/if}
			{else}
				<td align="center"><a href="2-2-202.php?sale_id={$page_data[$j][1]}">変更</a></td>
				{if $var.disabled == NULL}
					<td align="center"><a href="#" onClick="return Dialogue_1('取消します。',{$page_data[$j][1]},'hdn_cancel_id');">取消</a></td>
				{else}
					<td align="center">　</td>
				{/if}
				<td align="center">　</td>
			{/if}

		{/if}
		<td align="center">{$page_data[$j][22]}</td>
		<td align="center">{$form.form_slip_check[$j].html}</td>
    </tr>
    {/foreach}
</table>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

{$var.html_footer}
    

