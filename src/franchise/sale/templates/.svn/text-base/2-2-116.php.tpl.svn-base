{$var.html_header}
<body bgcolor="#D8D0C8">
<script>
    {$var.javascript}
</script>
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>   
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>    

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$html.html_s}
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr style="page-break-before: always;">
                    <td align="left">

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<div class="note">
※前集計日報(0)とは付番前の集計日報であり付番後は発行できません。
</div>
<table width="1000">
    <tr>
        <td colspan="2">{$var.html_page}</td>
    </tr>
    <tr>
        <td>
<table class="List_Table" border="1" width="800">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Pink">No.</td>
		<td class="Title_Pink">予定巡回日</td>
		<td class="Title_Pink">委託先コード</td>
		<td class="Title_Pink">委託先名</td>
		<td class="Title_Pink">巡回件数</td>
		<td class="Title_Pink">{$form.aord_prefix_all.html}</td>
		<td class="Title_Pink">{$form.aord_unfix_all.html}</td>
		<td class="Title_Pink">{$form.aord_fix_all.html}</td>
    </tr>

    {foreach from=$aord_data item=item key=i}
	<tr class="{$aord_data[$i].bg_color}">
        <td align="right" >{$aord_data[$i].no}</td>
        <td align="center">{$aord_data[$i].ord_time}</td>
        <td align="center">{$aord_data[$i].shop_cd}</td>
        <td align="left"  >{$aord_data[$i].shop_name}</td>
        <td align="right" >{$aord_data[$i].count}</td>
        <td align="center">{$form.form_preslip_out[$i].html}</td>
        <td align="center">{$form.form_unslip_out[$i].html}</td>
        <td align="center">{$form.form_slip_out[$i].html}</td>
	</tr>
    {/foreach}

    <tr class="Result3">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">{$form.form_preslipout_button.html}</td>
        <td align="center">{$form.form_slipout_button.html}</td>
        <td align="center">{$form.form_reslipout_button.html}</td>
    </tr>
</table>
        </td>
        <td>
<table class="List_Table" border="1">
	<tr align="center" style="font-weight: bold;">
		<td class="Title_Pink">{$form.slip_out_all.html}</td>
		<td class="Title_Pink">{$form.reslip_out_all.html}</td>
    </tr>
    {foreach from=$aord_data item=item key=i}
	<tr class="{$aord_data[$i].bg_color}">
        <td align="center" height="23">{$form.form_slip_check[$i].html}</td>
        <td align="center">{$form.form_reslip_check[$i].html}</td>
    </tr>
    {/foreach}
    <tr class="Result3">
        <td align="center">{$form.slip_out_button.html}</td>
        <td align="center">{$form.reslip_out_button.html}</td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td colspan="2">{$var.html_page2}</td>
    </tr>
</table>

{/if}
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
