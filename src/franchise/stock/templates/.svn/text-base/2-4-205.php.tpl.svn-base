{$var.html_header}

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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{* エラーメッセージ出力 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error != null}
    <li>{$var.error}<br>
{/if}
</span><br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">調査表番号</td>
        <td class="Value">{$form.form_invent_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow"><b>棚卸日</td>
        <td class="Value">{$form.form_ex_day.html}</td>
    </tr>
    {if $smarty.session.shop_div == '1'}
        <tr>
            <td class="Title_Yellow">事業所</td>
            <td class="Value">{$form.form_cshop.html}</td>
        </tr>
    {/if}
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

<span style="font: bold 16px; color: #555555;">
【棚卸日：
{if $var.error == null && ($var.ex_start != NULL || $var.ex_end != NULL)}
    {$var.ex_start} 〜 {$var.ex_end}
{else}
    指定無し
{/if}
{if $smarty.session.shop_div == '1'}　事業所:{$var.cshop_name}{/if}
】
</span><br>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Title_Yellow">調査表番号</td>
        <td class="Title_Yellow">棚卸一覧表</td>
    </tr>
    {foreach key=j from=$row item=items}
    {* 偶数なら色付けない *}
    {if $j==0 || $j%2==0}
        <tr class="Result1">
    {else}
        {* 奇数なら色付ける *}
        <tr class="Result2">
    {/if}
        <td align="right">
        {if $smarty.post.form_show_button == "表　示"}
            {$j+1}
        {elseif $smarty.post.f_page1 != null}
            {$smarty.post.f_page1*100+$j-99}
        {else}
            {$j+1}
        {/if}
        </td>
        {* 棚卸日 *}
        <td align="center">{$row[$j][0]}</td>
        {* 調査番号 *}
        <td>{$row[$j][1]}</td>
        {* 棚卸一覧表 *}
        <td align="center"><a href="2-4-208.php?invent_no={$row[$j][1]}">表示</a></td>
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
