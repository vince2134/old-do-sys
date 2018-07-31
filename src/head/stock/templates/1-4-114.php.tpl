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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">取扱期間</td>
        <td class="Value">{$form.form_start.html}{if $smarty.get.start != NULL || $smarty.get.end != NULL} 〜 {/if}{$form.form_end.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value">{$form.form_ware_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">商品名</td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
{*
    <tr>
        <td class="Title_Yellow">前在庫</td>
        <td class="Value">{$form.form_renew_num.html}</td>
    </tr>
*}
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

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">伝票番号</td>
        <td class="Title_Yellow">取扱日</td>
        <td class="Title_Yellow">取扱区分</td>
        <td class="Title_Yellow">入庫数</td>
        <td class="Title_Yellow">出庫数</td>
        <td class="Title_Yellow">受払先</td>
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
        {if $smarty.post.f_page1 != null}
            {$smarty.post.f_page1*100+$j-99}
        {else}
            {$j+1}
        {/if}
        </td>
        <td>{$row[$j][0]}</td>
        <td align="center">{$row[$j][1]}</td>
        <td align="center">{$row[$j][2]}</td>
        {* 入庫・出庫判定 *}
        {if $row[$j][3] == '1'}
            {* 入庫数 *}
            <td align="right">{$row[$j][4]}</td>
            <td align="right"></td>
        {else}
            {* 出庫数 *}
            <td align="right"></td>
            <td align="right">{$row[$j][4]}</td>
        {/if}
        {* 得意先名がNULLの場合は、「自倉庫」とする *}
        {if $row[$j][5] == NULL}
            <td>自倉庫</td>
        {else}
            <td>{$row[$j][5]}</td>
        {/if}
    </tr>
    {/foreach}
    <tr class="Result3" align="center">
        <td><b>総合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.in_count}</td>
        <td align="right">{$var.out_count}</td>
        <td></td>
    </tr>
</table>
{$var.html_page2}

<table align="right">
    <tr>
        <td>{$form.return_btn.html}</td>
    </tr>
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
