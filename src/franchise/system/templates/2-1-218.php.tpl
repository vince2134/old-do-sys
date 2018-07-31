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

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">直送先コード</td>
        <td class="Value">{$form.form_direct_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名</td>
        <td class="Value">{$form.form_direct_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称</td>
        <td class="Value">{$form.form_direct_cname.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>
            {$form.show_button.html}　　{$form.clear_button.html}</td>
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

{if $smarty.post.show_button == "表　示" && $smarty.post.form_output_type == 1}
<table width=$width>
    <tr>
        <td>全<b>{$var.total_count}</b>件</td>
    </tr>
</table>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">直送先コード</td>
        <td class="Title_Purple">直送先名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">請求先</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">{$j+1}</td>
        <td>{$row[$j][1]}</td>
        <td><a href="2-1-219.php?direct_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        <td>{$row[$j][3]}</td>
        <td>{$row[$j][4]}</td>
    </tr>   
    {/foreach}
</table>
{/if}
{*--------------- 画面表示２ e n d ---------------*}

        </td>
    </tr>
</table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
