{$var.html_header}

<script language="javascript">
{$var.code_value}
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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{* 登録・変更完了メッセージ出力 *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>

{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_value != null}<li>{$var.error_value}<br>{/if}
{if $form.rental_txt.error != null}<li>{$form.rental_txt.error}<br>{/if}
{if $form.f_goods.error != null}<li>{$form.f_goods.error}<br>{/if}
{if $form.money_txt.error != null}<li>{$form.money_txt.error}<br>{/if}
{if $form.num_txt.error != null}<li>{$form.num_txt.error}<br>{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value">{$form.shop_txt.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル先<font color="#ff0000">※</font></td>
        <td class="Value">{$form.rental_txt.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-210.php',Array('f_goods[code]','f_goods[name]'),500,450);">商品名</a><font color="#ff0000">※</font></td>
        <td class="Value">{$form.f_goods.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル料<font color="#ff0000">※</font></td>
        <td class="Value">{$form.money_txt.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル数<font color="#ff0000">※</font></td>
        <td class="Value">{$form.num_txt.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value">{$form.note_txt.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">{$form.button.touroku.html}　　{$form.button.clear.html}</td>
    </tr>
</table>

        </td>
    <tr>
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

全<b>{$var.total_count.html}</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">レンタル先</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">レンタル料</td>
        <td class="Title_Purple">レンタル数</td>
        <td class="Title_Purple">レンタル額</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">変更</td>
        <td class="Title_Purple">削除</td>
    </tr>
{foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">{$j+1}</td>
    {foreach key=i from=$items item=item}
        {if $i == 0 || $i == 1 || $i == 5}
            <td align="left">{$item}</td>
        {elseif 2 <= $i && $i <= 4}
            <td align="right">{$item}</td>
        {elseif $i == 6}
            <td align="center"><a href="1-1-112.php?rental_id={$item}">変更</a></td>
            <td align="center"><a href="#" style="color:blue" onClick="javascript: return Dialogue_1('削除します。',{$item},'delete_row_id')">削除</a></td>
        {/if}
    {/foreach}
    </tr>   
{/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.button.modoru.html}</td>
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
