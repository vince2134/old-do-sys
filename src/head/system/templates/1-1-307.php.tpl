{$var.html_header}

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
    {if $form.form_close_day.error != null}
    <li>{$form.form_close_day.error}<br>
    {/if}
    {if $form.bill_day_err.error != null}
    <li>{$form.bill_day_err.error}<br>
    {/if}
    {if $form.bill_amount_err.error != null}
    <li>{$form.bill_amount_err.error}<br>
    {/if}
    {if $form.bill_all_err.error != null}
    <li>{$form.bill_all_err.error}<br>
    {/if}
    </span><br>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null}
    <li>{$var.message}<br>
    {/if}
    </span><br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="400">
    <tr>
        <td>

<div style="text-align: left; font: bold; color: #3300ff;">
    ・本残高初期設定は各得意先登録後、取引の確定前に１回だけ、任意に設定できます。
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ・本設定なしに取引（売上、入金、仕入、支払等）を確定した場合、自動的にゼロに設定されます。
</div>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求残高</td>
        <td class="Value">{$form.form_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分</td>
        <td class="Value">{$form.form_trade.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">締日</td>
        <td class="Value">{$form.form_close_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示件数</td>
        <td class="Value">{$form.hyoujikensuu.html}</td>
    </tr>
</table>

<br>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>    
        <td class="Title_Purple">残高移行年月日<font color="#ff0000">※</td></td>
        <td class="Value">{$form.form_bill_day.html}</td>
    </tr>   
</table>

<table align="right">
    <tr>    
        <td>{$form.form_show_button.html}</td>
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

{if $smarty.post.renew_flg == 1}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
{*全<b>{$var.match_count}</b>件<br>*}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先名</td>
        <td class="Title_Purple">請求先名</td>
        <td class="Title_Purple">請求残高</td>
        <td class="Title_Purple">残高移行日</td>
    </tr>
{foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+$var.page_snum}</td>
        <td>{$page_data[$i][1]}<br>{$page_data[$i][2]}<br>{$page_data[$i][3]}</td>
        <td>{$page_data[$i][5]}<br>{$page_data[$i][6]}</td>
        <td align="right">{$form.form_bill_amount[$i].html}</td>
{*        <td align="center">{$form.form_bill_day[$i].html}</td>*}
        <td align="center">{$page_data[$i][10]}</td>
    </tr>
{/foreach}
    </tr>
    <tr class="Result3" align="right" style="font-weight: bold;">
        <td colspan="4">残高合計</td>
        <td>{$var.total_amount|number_format}</td>
    </tr>
</table>

 {$var.html_page2}
<table align="right">
    <tr>
        <td>{$form.form_add_button.html}</td>
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
