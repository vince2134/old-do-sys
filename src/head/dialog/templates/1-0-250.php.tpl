{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_client_name.focus()">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップ名/フリガナ</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    {if $var.display == "2-409"}
    <tr>
        <td class="Title_Purple">銀行カナ</td>
        <td class="Value">{$form.form_bank_kana.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座名義</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
    {/if}
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示順</td>
        <td class="Value">{$form.form_turn.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_button.show_button.html}　　{$form.form_button.close_button.html}</td>
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

全<b>{$var.match_count}</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ショップコード<br>社名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">状態</td>
    </tr>
    {foreach key=j from=$page_data item=items}
    <tr class="Result1"> 
        <td align="right">
            　  {$j+1}
        </td>               
        <td>
            {$page_data[$j][0]}-{$page_data[$j][1]}<br>
            {if $page_data[$j][5] == 'true'}
            <a href="#" onClick="returnValue=Array({$return_data[$j]});window.close();">{$page_data[$j][2]}</a>
            {else}
            {$page_data[$j][2]}
            {/if}
        </td>
        <td>{$page_data[$j][3]}</td>
        <td align="center">{$page_data[$j][4]}</td>
        <td align="center">{$page_data[$j][7]}</td>
    </tr>
    {/foreach}
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
