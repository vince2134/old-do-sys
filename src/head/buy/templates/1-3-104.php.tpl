{$var.html_header}

<script language="javascript">
<!--
{$html.js}
-->
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{* エラーメッセージ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_c_staff.error != null}
    <li>{$form.form_c_staff.error}
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}
{/if}
{if $form.form_hope_day.error != null}
    <li>{$form.form_hope_day.error}
{/if}
{if $form.err_bought_slip.error != null}
    <li>{$form.err_bought_slip.error}
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>

{$html.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_day"}</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Blue">発注金額</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_hope_day"}</td>
        <td class="Title_Blue">仕入完了</td>
        <td class="Title_Blue">削除</td>
        <td class="Title_Blue">発注書印刷</td>
    </tr>
    {foreach key=j from=$row item=items}
    {if $j is even}
    <tr class="Result1"> 
    {else}
    <tr class="Result2">
    {/if}
        <td align="right">
            {$var.no+$j+1}
        </td>
        <td align="center">{$row[$j][1]}</td>
            {* 取消かNULLかつ未処理の時、変更可 *} 
            {if $row[$j][8] == '1'}
                <td align="center"><a href="1-3-102.php?ord_id={$row[$j][0]}">{$row[$j][3]}</a></td>
            {else}
                <td align="center"><a href="1-3-103.php?ord_id={$row[$j][0]}&ord_flg=true">{$row[$j][3]}</a></td>
            {/if}
        <td>{$row[$j][11]}<br>{$row[$j][4]}</td>
        <td align="right">
            {$row[$j][5]|number_format}
        </td>
        <td align="center">
            {$row[$j][7]}
        </td>
        <td align="center">
            {if $row[$j][8] == '3' || $row[$j][8] == '4'}
                済
            {else}
                <font color="#ff0000">未</font>
            {/if}
        </td>
        <td align="center">
            {if $row[$j][8] == '1'}
                {if $var.auth == "w"}<a href="#" onClick="Order_Delete('data_delete_flg','ord_id_flg',{$row[$j][0]},'hdn_del_enter_date','{$row[$j][15]}');">削除</a>{/if}
            {/if}
        </td>
        <td align="center">
            {if $row[$j][6] == 't' && $row[$j][10] == 't'}
                <a href="#" onClick="window.open('../../head/buy/1-3-105.php?ord_id={$row[$j][0]}','_blank','');">印刷</a>
            {elseif $row[$j][6] == 't' && $row[$j][10] == 'f'}
                <a href="#" onClick="window.open('../../head/buy/1-3-105.php?ord_id={$row[$j][0]}','_blank','');">印刷</a>
            {elseif $row[$j][6] == 'f' && $row[$j][10] == 't'}
                {*<a href="#" onClick="javascript: window.location.reload(); window.open('../../head/buy/1-3-105.php?ord_id={$row[$j][0]}','_blank','');">印刷</a>*}
                <a href="#" onClick="Order_Sheet('order_sheet_flg','ord_id_flg',2,{$row[$j][0]},{$row[$j][8]});">印刷</a>
            {elseif $row[$j][6] == 'f' && $row[$j][10] == 'f'}
                {*<a href="#" onClick="javascript: window.location.reload(); window.open('../../head/buy/1-3-105.php?ord_id={$row[$j][0]}','_blank','');">印刷</a>*}
                <a href="#" onClick="Order_Sheet('order_sheet_flg','ord_id_flg',2,{$row[$j][0]},{$row[$j][8]});">印刷</a>
            {else}
                ----
            {/if}
        </td>
    </tr>
    {/foreach}
</table>
{$html.html_page2}

        </td>
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
