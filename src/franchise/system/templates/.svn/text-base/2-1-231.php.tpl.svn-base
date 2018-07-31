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

全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}
<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" colspan="3">大分類業種</td>
        <td class="Title_Purple" colspan="3">小分類業種</td>
    </tr>   
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
    </tr>   
{foreach from=$page_data item=item key=i}
    <tr class={$tr[$i]}>
        <td align="right">{$i+1}</td>
        <td>{$item[0]}</td>
        <td>{$item[1]}</td>
        <td>{$item[2]}</a></td>
        <td>{$item[3]}</td>
        <td>{$item[4]}</a></td>
        <td>{$item[5]}</a></td>
    </tr>   
{/foreach}
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
