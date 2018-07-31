{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
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
            <table height="100%" valign="bottm">
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>    
        <td align=center>    

{if $smarty.get.err == null}
{*-- 2009/06/26 改修No.32 追加 --*}
<span style="color: red;">※ブラウザの戻るボタンは使用せずに、OKボタンをクリックして下さい。</span>
<br><br><br>
<span style="font: bold 16px;">入金完了しました。</span><br><br>
{*<span style="font: bold 16px;">入金完了しました。</span><br><br>*}
{*-------------------------------*}
{elseif $smarty.get.err == "1"}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>伝票が削除されているため、変更できません。<br>
</ul>
</span>
{/if}

<table width="100%">
    <tr>
{*        <td align="right">{$form.form_ok_btn.html}　{$form.form_return_btn.html}</td>*}
        <td align="center">{$form.form_ok_btn.html}</td>
    </tr>
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
