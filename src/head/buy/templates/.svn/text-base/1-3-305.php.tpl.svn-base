{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table align="center">
    <tr>
        <td align="center">
            {if $smarty.get.err == null}
            <p style="font:bold 15px;margin-top:100px;"> 支払入力完了しました。</p>
            {elseif $smarty.get.err == "1"} 
            <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
            <ul style="margin-left: 16px;">
                <li>伝票が削除されているため、変更できません。<br>
            </ul>
            </span>
            {elseif $smarty.get.err == "2"} 
            <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
            <ul style="margin-left: 16px;">
                <li>日次更新処理が行われているため、変更できません。<br>
            </ul>
            </span>
            {/if}
            {$form.ok_button.html}<br>

        </td>
    </tr>
</table>
<br>
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

