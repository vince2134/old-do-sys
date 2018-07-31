
{$var.html_header}
<script>
    {$var.javascript}
</script>
<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			{* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
		</td>
	</tr>

	<tr align="left">
		<td valign="top">
		
			<table>
				<tr>
					<td>

{*---------------------メッセージ出力-------------------*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
</span>

{*-------------------- 画面表示1開始 -------------------*}
{$var.search_html}

<br style="font-size: 4px;">

<table class="Table_Search">

{if $smarty.session.group_kind == '2'}
<col width=" 80px" style="font-weight: bold;">
<col width="300px">
{/if}
<col width="110px" style="font-weight: bold;">
<col width="350px">

    <tr>
    {if $smarty.session.group_kind == '2'}
        <td class="Td_Search_3"><b>代行区分</b></td>
        <td class="Td_Search_3">{$form.form_act_div.html}</td>
    {/if}
		<td class="Td_Search_3"><b>除外巡回担当者<br>（複数選択）</td>
		<td class="Td_Search_3">{$form.form_not_multi_staff.html}<br> 例）0001,0002</td>
    </tr>
<table width='1000px'>
	<tr>
		<td align='right'>
			{$form.form_show_button.html}　　{$form.form_clear_button.html}
		</td>
	</tr>
</table>
{********************* 画面表示1終了 ********************}

					<br>
					</td>
				</tr>


				<tr>
					<td>
{if $smarty.post.form_show_button == "表　示" || $var.match_count > 0}
<div class="note">
※前集計日報(0)とは付番前の集計日報であり付番後は発行できません。
</div>
{$var.html_page}
{*-------------------- 画面表示2開始 -------------------*}
<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="900">
	<tr align="center">
		<td class="Title_Pink" width="30" ><b>No.</b></td>
		<td class="Title_Pink" width=""   ><b>日報No.</b></td>
		<td class="Title_Pink" width=""   ><b>予定巡回日</b></td>
		<td class="Title_Pink" width=""   ><b>巡回担当者コード</b></td>
		<td class="Title_Pink" width=""   ><b>巡回担当者名</b></td>
    {if $smarty.session.group_kind == '2'}
		<td class="Title_Pink" width=""   ><b>代行区分</b></td>
    {/if}    
		<td class="Title_Pink" width=""   ><b>巡回件数</b></td>
{*
		<td class="Title_Pink" width="200"   colspan="2"><b>付番</b></td>
*}
		<td class="Title_Pink" width=""   ><b>{$form.aord_prefix_all.html}</b></td>
		<td class="Title_Pink" width=""   ><b>{$form.aord_unfix_all.html}</b></td>
		<td class="Title_Pink" width=""   ><b>{$form.aord_fix_all.html}</b></td>
    </tr>
{*
    <tr align="center">
		<td class="Title_Pink" width=""><b>未</b></td>
		<td class="Title_Pink" width=""><b>済</b></td>
	</tr>
*}
    {foreach from=$page_data item=item key=i name=page_count}
    {if $i is even}
	<tr class="Result1">
    {else}
	<tr class="Result2">
    {/if}
		<td align="right">{$page_data[$i].key}</td>
		<td align="">{$page_data[$i][0]}</td>
		<td align="center"><a href="2-2-106.php?aord_id_array={$page_data[$i].ary_id}&back_display=count_daily">{$page_data[$i][1]}</a></td>
		<td align="left">{$page_data[$i][2]}</td>
		<td align="left">{$page_data[$i][3]}</td>
    {if $smarty.session.group_kind == '2'}
		<td align="center">{$page_data[$i][6]}</td>
    {/if}
		<td align="right">{$page_data[$i][4]}</td>
{*
		<td align="right">{$page_data[$i].unslip_count|default:"0"}</td>
		<td align="right">{$page_data[$i].slip_count|default:"0"}</td>
*}
        {*再発行*}
        {if $page_data[$i].slip_flg == true}
        <td></td>
        <td align="center">{$page_data[$i][7]}</td>
		<td align="center">{$form.form_reslipout_check[$i].html}</td>
        {*新規発行*}
        {else}
		<td align="center">{$form.form_preslipout_check[$i].html}</td>
		<td align="center">{$form.form_slipout_check[$i].html}</td>
        <td></td>
        {/if}
	</tr>
    {/foreach}

    <tr align="center" class="Result3">
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
        {if $smarty.session.group_kind == '2'}
            <td></td>
        {/if}
{*
	    <td></td>
	    <td></td>
*}
	    <td></td>
	    <td>{$form.form_preslipout_button.html}</td>
	    <td>{$form.form_slipout_button.html}</td>
	    <td>{$form.form_reslipout_button.html}</td>
    </tr>
</table>

        </td>
        <td>

{*伝票発行*}
<table class="List_Table" border="1">
	<tr align="center">
		<td class="Title_Pink" width=""   ><b>{$form.slip_out_all.html}</b></td>
		<td class="Title_Pink" width=""   ><b>{$form.reslip_out_all.html}</b></td>
    </tr>
    {foreach from=$page_data item=item key=i}
    {if $i is even}
	<tr class="Result1">
    {else}
	<tr class="Result2">
    {/if}
   
    {*伝票発行形式が指定以外の場合*} 
    {if $page_data[$i].slip_flg == true && ($form.form_slip_check[$i].html != null || $form.form_reslip_check[$i].html != null)}
		<td align="center">{$form.form_slip_check[$i].html|default:$page_data[$i][8]}</td>
		<td align="center">{$form.form_reslip_check[$i].html}</td>
    {else}
		<td align="center" height="23"></td>
		<td align="center"></td>
    </tr>
    {/if}
    {/foreach}

    <tr align="center" class="Result3">
	    <td>{$form.slip_out_button.html}</td>
	    <td>{$form.reslip_out_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

{$var.html_page2}
{/if}
{$form.hidden}
{********************* 画面表示2終了 ********************}


					</td>
				</tr>
			</table>
		</td>
		{********************* 画面表示終了 ********************}

	</tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
