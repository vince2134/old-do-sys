{$var.html_header}

<script language="javascript">
{$var.code_value}
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
    {if $form.form_build_no.error != null}
        <li>{$form.form_build_no.error}
    {/if}
    {if $form.form_goods_name.error != null}
        <li>{$form.form_goods_name.error}
    {/if}
    {if $form.form_create_num.error != null}
        <li>{$form.form_create_num.error}
    {/if}
    {if $form.form_output_ware.error != null}
        <li>{$form.form_output_ware.error}
    {/if}
    {if $form.form_input_ware.error != null}
        <li>{$form.form_input_ware.error}
    {/if}
    {if $var.error != null}
        <li>{$var.error}
    {/if}
    {if $form.form_create_day.error != null}
        <li>{$form.form_create_day.error}
    {/if}
</span>  
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">組立管理番号<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_build_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">組立日<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_create_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">
        {if $var.freeze_flg != true}
            <a href="#" onClick="return Open_SubWin_2('../dialog/1-0-210.php',Array('form_goods_cd','form_goods_name'),500,450,7,0,1);">商品コード</a>
        {else}
            商品コード
        {/if}
        <font color="#ff0000">※</font>
        </td>
        <td class="Value" colspan="3">{$form.form_goods_cd.html}　{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">組立数<font color="#ff0000">※</font></td>
        <td class="Value" colspan="3">{$form.form_create_num.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">引落倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_output_ware.html}</td>
        <td class="Title_Yellow">入庫倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_input_ware.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{if $var.freeze_flg != true}{$form.form_show_button.html}　　{/if}{$form.form_clear_button.html}</td>
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
{$form.hidden}
{if $var.validate_flg == true}

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%" style="font-weight: bold;">
<col width="110">
<col>
<col width="110">
<col>
    <tr align="center">
        <td class="Title_Yellow">組立数</td>
        <td class="Value" align="right">{$var.create_num}</td>
        <td class="Title_Yellow">完成品在庫数<br>（引当数）</td>
        <td class="Value" align="right">{$var.stock_num}（{$var.rstock_num}）</td>
    </tr>
    <tr align="center">
        <td class="Title_Yellow">引当倉庫</td>
        <td class="Value">{$var.output_ware_name}</td>
        <td class="Title_Yellow">入庫倉庫</td>
        <td class="Value">{$var.input_ware_name}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">部品コード</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">構成数</td>
        <td class="Title_Yellow">現在庫数</td>
        <td class="Title_Yellow">使用数</td>
    </tr>
    {foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td>{$page_data[$i][1]}</td>
        <td>{$page_data[$i][2]}</td>
        <td align="right">{$page_data[$i][4]}/{$page_data[$i][3]}</td>
        <td align="right">{$page_data[$i][5]}</td>
        <td align="right">{$page_data[$i][6]}</td>
    </tr>
    {/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_create_button.html}</td>
    </tr>
</table>

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
