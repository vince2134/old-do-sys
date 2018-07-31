{$var.html_header}
<script>
    {$var.javascript}
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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error != null}
    <li>{$var.error}<br>
{/if}
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}
{elseif $var.sale_day_error != null}
    <li>{$var.sale_day_error}
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票形式</td>
        <td class="Value" colspan="3">{$form.form_slip_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" colspan="3">{$form.form_slip_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">売上計上日</td>
        <td class="Value" colspan="3">{$form.form_sale_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">得意先コード</td>
        <td class="Value">{$form.form_client_cd.html}</td>
        <td class="Title_Pink">得意先名</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分</td>
        <td class="Value" colspan="3">{$form.form_trade_sale.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">発行状況</td>
        <td class="Value">{$form.form_order_slip.html}</td>
        <td class="Title_Pink">日次更新</td>
        <td class="Value">{$form.form_renew.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
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

<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">得意先</td>
        <td class="Title_Pink">伝票番号</td>
        <td class="Title_Pink">売上計上日</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">売上金額</td>
        <td class="Title_Pink">{$form.slip_check_all.html}</td>
        <td class="Title_Pink">{$form.re_slip_check_all.html}</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {if $smarty.post.form_show_button == "表　示"}
                {$j+1}
            {elseif $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
                {$j+1}
            {/if}
        </td>
        <td>{$row[$j][3]} - {$row[$j][4]}<br>{$row[$j][5]}</td>
        <td><a href="1-2-205.php?sale_id={$row[$j][0]}">{$row[$j][1]}</a></td>
        <td align="center">{$row[$j][2]}</td>
        {*取引区分*}
        {if $row[$j][6] == '11'}
        <td align="center">掛売上</td>
        {elseif $row[$j][6] == '13'}
        <td align="center">掛返品</td>
        {elseif $row[$j][6] == '14'}
        <td align="center">掛値引</td>
        {elseif $row[$j][6] == '15'}
        <td align="center">割賦売上</td>
        {elseif $row[$j][6] == '61'}
        <td align="center">現金売上</td>
        {elseif $row[$j][6] == '63'}
        <td align="center">現金返品</td>
        {elseif $row[$j][6] == '64'}
        <td align="center">現金値引</td>
        {/if}
        <td align="right">{$row[$j][7]}</td>
        <td align="center">{$form.slip_check[$j].html}</td>
        <td align="center">{$form.re_slip_check[$j].html}</td>
    </tr>
    {/foreach}
    <tr class="Result2" align="center">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.total_amount}</td>
        <td>{$form.output_slip_button.html}</td>
        <td>{$form.output_re_slip_button.html}</td>
    </tr>
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
