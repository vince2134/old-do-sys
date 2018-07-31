{$var.html_header}
<script language="javascript">
{$var.js}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

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
{* エラーメッセージ出力 *}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $var.price_err != null}
       <li> {$var.price_err}<br>
    {/if}
    {if $var.rprice_err != null}
       <li>{$var.rprice_err}<br>
    {/if}
    {if $var.cday_err != null}
       <li>{$var.cday_err}<br>
    {/if}
    {foreach from=$form.errors item=item key=i}
       <li>{$item}<br>
    {/foreach}
    </span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="650">
    <tr>
        <td>
<span style="font: bold 15px; color: #555555;">
【商品名】： {$var.goods_name} <br>
【略　記】： {$var.goods_cname} 
</span>
<br>
{if $var.warning != null}
<span style=" color: blue;">
<b>{$var.warning}
</b>
</span>
{/if}
<br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">単価項目</td>
        <td class="Title_Purple" rowspan="2">現在単価</td>
        <td class="Title_Purple" colspan="2">改訂単価</td>
        <td class="Title_Purple" rowspan="2">改訂日</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">指定</td>
        <td class="Title_Purple">標準価格の％</td>
    </tr>
    <!--1行目-->
    <tr class="Result1">
        <td class="Title_Purple"><b>{$form.form_price[0].label}<font color="#ff0000">※</font></b></td>
        <td align="right">{$form.form_price[0].html}</a></td>
        <td align="center">{$form.form_rprice[0].html}</td>
        <td align="center"></td>
        <td align="center">{$form.form_cday[0].html}</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b>{$form.form_price[2].label}<font color="#ff0000">※</font></b></td>
        <td align="right">{$form.form_price[2].html}</a></td>
        <td align="center">{$form.form_rprice[2].html}</td>
        <td align="center">{$form.form_cost_rate[2].html}%</td>
        <td align="center">{$form.form_cday[2].html}</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b>{$form.form_price[1].label}<font color="#ff0000">※</font></b></td>
        <td align="right">{$form.form_price[1].html}</a></td>
        <td align="center">{$form.form_rprice[1].html}</td>
        <td align="center">{$form.form_cost_rate[1].html}%</td>
        <td align="center">{$form.form_cday[1].html}</td>
    </tr>
    <tr class="Result1">
        <td class="Title_Purple"><b>{$form.form_price[3].label}<font color="#ff0000">※</font></b></td>
        <td align="right">{$form.form_price[3].html}</a></td>
        <td align="center">{$form.form_rprice[3].html}</td>
        <td></td>
        <td align="center">{$form.form_cday[3].html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_entry_button.html}　　{$form.form_back_button.html}</td>
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

<span style="font: bold 15px; color: #555555;">【改定履歴】</span>
<br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center">
        <td class="Title_Purple"><b>改定日</b></td>
        <td class="Title_Purple"><b>単価項目</b></td>
        <td class="Title_Purple"><b>改定前単価</b></td>
        <td class="Title_Purple"><b>改定後単価</b></td>
        <td class="Title_Purple"><b>単価改定者</b></td>
    </tr>
    <!--1行目-->
    {foreach from=$page_data item=items}
    <tr class="Result1">
        {foreach key=i from=$items item=item }
        {if $i == 0}
            <td align="center">{$item}</td>
        {elseif $i == 1}
            <td>{$item}</a></td>
        {elseif $i == 2}
            <td align="right">{$item}</a></td>
        {elseif $i>= 3}
            <td align="right">{$item}</td>
        {/if}
        {/foreach}
    </tr>
    {/foreach}
</table>
{$var.html_page2}

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
