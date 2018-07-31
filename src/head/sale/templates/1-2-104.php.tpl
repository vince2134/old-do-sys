{$var.html_header}

<script language="javascript">
{$var.forward_num}
 </script>
 
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
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
    {if $form.form_ord_day.error != null}
        <li>{$form.form_ord_day.error}<br>
    {/if}
    {if $var.form_ord_day_err != null}
        <li>{$var.form_ord_day_err}<br>
    {/if}
    {if $form.form_ware_select.error != null}
        <li>{$form.form_ware_select.error}<br>
    {/if}
    {if $form.form_trade_select.error != null}
        <li>{$form.form_trade_select.error}<br>
    {/if}
    {if $form.form_staff_select.error != null}
        <li>{$form.form_staff_select.error}<br>
    {/if}
    {if $var.form_def_day_err != null}
        <li>{$var.form_def_day_err}<br>
    {/if}
    {if $form.form_def_day.error != null}
        <li>{$form.form_def_day.error}<br>
    {/if}
    {if $var.forward_day_err != null}
        <li>{$var.forward_day_err}<br>
    {/if}
    {if $var.forward_num_err != null}
        <li>{$var.forward_num_err}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $form.form_trans_select.error != null}
        <li>{$form.form_trans_select.error}<br>
    {/if}
    {if $form.form_note_your.error != null}
        <li>{$form.form_note_your.error}<br>
    {/if}
    {if ($var.alert_message != null && $var.alert_output != null) || $var.price_warning != null}
        <font color="#ff00ff"><p>[警告]
        {if $var.alert_message != null && $var.alert_output != null}
         <br>{$var.alert_message}</font>
        {/if}
        {if $var.price_warning != null}
        <br>{$var.price_warning}</font>
            <br>
        {/if}
        {$form.button.alert_ok.html}<p>
    {/if}
    </span>
{*+++++++++++++++ メッセージ類 e n d +++++++++++++++*} 
<!-- フリーズ画面判定 -->
{if $var.comp_flg != null}
	<span style="font: bold;"><font size="+1">以下の内容で受注しますか？</font></span><br>
{/if}
{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<form {$form.attributes}>

<table width="800">
    <tr>
        <td>

{*
<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">FC発注番号</td>
        <td class="Value">{$var.fc_ord_id}</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先</td>
        <td class="Value" colspan="3">{$var.client_cd}　{$var.client_name}</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">希望納期</td>
        <td class="Value">{$var.hope_day}</td>
    </tr>
    <tr>
        <td class="Title_Pink">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">直送先</td>
        <td class="Value">{$var.direct_name}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade_select.html}</td>
        <td class="Title_Pink">受注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="3">{$var.note_my}</td>
    </tr>
</table>
*}

<table class="Data_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">得意先</td>
        <td class="Value">{$var.client_cd}　{$var.client_name}</td>
        <td class="Title_Pink">FC発注番号</td>
        <td class="Value">{$var.fc_ord_id}</td>
    </tr>
    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">出荷可能数</td>
        <td class="Value">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Pink">受注担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_def_day.html}</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">希望納期</td>
        <td class="Value">{$var.hope_day}</td>
        <td class="Title_Pink">直送先</td>
        <td class="Value">{$var.direct_name}</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_trade_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="5">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="5">{$var.note_my}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>
{$form.hidden}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">商品コード<br>商品名</td>
        <td class="Title_Pink">実棚数<BR>（A）</td>
        <td class="Title_Pink">発注済数<BR>（B）</td>
        <td class="Title_Pink">引当数<BR>（C）</td>
        <td class="Title_Pink">出荷可能数<BR>（A+B-C）</td>
        <td class="Title_Pink">受注数</td>
        <td class="Title_Pink"><font color="#0000ff">原価単価</font><br><font color="#ff0000">FC発注単価</font><br>売上単価</td>
        <td class="Title_Pink"><font color="#0000ff">原価金額</font><br><font color="#ff0000">FC発注金額</font><br>売上金額</td>
        <td class="Title_Pink">出荷回数<font color="#ff0000">※</font></font></td>
        <td class="Title_Pink">分納時出荷予定日<font color="#ff0000">※</font></td>
        <td class="Title_Pink">出荷数<font color="#ff0000">※</font></font></td>
    </tr>
    {foreach key=j from=$row item=items}
    {if $row[$j][11] == true}
    <tr bgcolor="pink" >
    {else}
    <tr class="Result1">
    {/if}
        {* No. *}
        <td align="right">
            {if $smarty.post.show_button == "表　示"}
                {$j+1}
            {elseif $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*10+$j-9}
            {else if}
                {$j+1}
            {/if}
        </td>
        {* 商品 *}
        <td>{$row[$j][1]}<br>{$row[$j][2]}</td>
        {* 実棚数（A）*}
        <td align="right"><a href="#" onClick="Open_mlessDialmg_g('1-2-107.php',{$row[$j][0]},{$smarty.session.client_id},300,160);">{$row[$j][12]}</a></td>
        {* 発注済数（B）*}
        <td align="right">{$row[$j][13]}</td>
        {* 引当数（C）*}
        <td align="right">{$row[$j][14]}</td>
        {* 出荷可能数（A+B-C）*}
        <td align="right">{$row[$j][15]}</td>
        {* 受注数 *}
        <td align="right">{$row[$j][3]}</td>
        {* 単価 *}
        <td align="right"><font color="#0000ff">{$row[$j][4]}</font><br><font color="ff0000">{$row[$j][9]}</font><br>{$row[$j][5]}</td>
        {* 金額 *}
        <td align="right"><font color="#0000ff">{$row[$j][6]}</font><br><font color="ff0000">{$row[$j][10]}</font><br>{$row[$j][7]}</td>
        {* 出荷回数 *}
		{if $var.comp_flg != null}
        <td align="right">{$form.form_forward_times[$j].html}</td>
		{else}
        <td align="center">{$form.form_forward_times[$j].html}</td>
		{/if}
        {* 分納時出荷予定日 *}
        <td align="center" width="130">
		<!-- フリーズ画面判定-->
		{if $var.comp_flg != null}
			<!-- フリーズ画面-->
			{foreach key=i from=$disp_count[$j] item=items}
        		{$form.form_forward_day[$j][$i].html}<br>
			{/foreach}
		{else}
			<!-- 初期表示-->
			{foreach key=i from=$num item=items}
        		{$form.form_forward_day[$j][$i].html}
        	{/foreach}
		{/if}
        </td>
        {* 出荷数 *}
		<!-- フリーズ画面判定-->
		{if $var.comp_flg != null}
        <td align="right" width="130">
			<!-- フリーズ画面-->
			{foreach key=i from=$disp_count[$j] item=items}
        		{$form.form_forward_num[$j][$i].html}<br>
			{/foreach}
		{else}
        <td align="center" width="130">
			<!-- 初期表示-->
			{foreach key=i from=$num item=items}
            	{$form.form_forward_num[$j][$i].html}
        	{/foreach}
		{/if}
        </td>
    </tr>
    {/foreach}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right" class="List_Table" border="1" width="650">
    <tr>
        <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
        <td class="Value" align="right">{$form.form_sale_total.html}</td>
        <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
        <td class="Value" align="right">{$form.form_sale_tax.html}</td>
        <td class="Title_Pink" align="center" width="80"><b>税込金額</b></td>
        <td class="Value" align="right">{$form.form_sale_money.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
		{* 登録確認画面判定 *} 
		{if $var.comp_flg == null}
			{* 以外 *}
            {if ($var.alert_message != null && $var.alert_output != null) || $var.price_warning != null} 
        	<td align="right" colspan="2">　　{$form.button.back.html}</td>
            {else}
        	<td align="right" colspan="2">{$form.button.entry.html}　　{$form.button.back.html}</td>
            {/if}
		{else}
			{* 登録確認画面 *} 
			<td align="right" colspan="2">{$form.comp_button.html}　　{$form.return_button.html}</td>
		{/if}
    </tr>
</table>

        </td>
    </tr>
</table>
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
