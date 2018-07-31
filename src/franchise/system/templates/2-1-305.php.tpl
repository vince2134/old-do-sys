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
{* エラーメッセージ出力 *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_close_day.error != null}
        <li>{$form.form_close_day.error}<br>
    {/if}   
    {if $form.form_set_error.error != null}
        <li>{$form.form_set_error.error}<br>
    {/if}   
    {if $var.add_msg != null}
        <b><font color="blue"><li>{$var.add_msg}</font></b><br>
    {/if}   
    </span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="350">
    <tr>
        <td>
<div style="text-align: left; font: bold; color: #3300ff;">
    ・本残高初期設定は各得意先登録後、取引の確定前に１回だけ、任意に設定できます。
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ・本設定なしに取引（売上、入金、仕入、支払等）を確定した場合、自動的にゼロに設定されます。
</div>

<table border="1" class="Data_Table" width="100%">
<col width="80" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state_radio.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">残高設定</td>
        <td class="Value">{$form.form_zandaka_radio.html}</td>
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

{if $smarty.post.show_button_flg == true}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
    <tr>
        <td class="Title_Purple" width="120"><b>残高移行年月日<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_close_day.html}</td>
    </tr>
</table>
<br>

全<b>{$var.match_count}</b>件<br>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先コード</td>
        <td class="Title_Purple">得意先名1</td>
        <td class="Title_Purple">得意先名2</td>
        <td class="Title_Purple">売掛残高</td>
        <td class="Title_Purple">残高移行日</td>
    </tr>
    {foreach from=$show_data item=item key=i}
    {if $show_data[$i][8] == 't'}
    <tr class="Result1" style="font-weight: bold; color: blue;">
    {elseif $show_data[$i][8] == 'f'}
    <tr class="Result1" style="color: green;">
    {else}
    <tr class="Result1">
    {/if}
        <td align="right">{$i+1}</td>
        <td>{$show_data[$i][1]}-{$show_data[$i][2]}</td>
        <td>{$show_data[$i][3]}</td>
        <td>{$show_data[$i][4]}</td>
        <td align="center">{$form.form_init_cbln[$i].html}</td>
        <td>{$show_data[$i][7]}</td>
    </tr>
    {/foreach}
    <tr class="Result3" align="right" style="font-weight: bold;">
        <td colspan="4">残高合計</td>
        <td>{$form.static_sum.html}</td>
        <td></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_entry_button.html}</td>
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
