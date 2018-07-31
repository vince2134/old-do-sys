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
{* エラーメッセージ出力 *} 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_shop_gcd.error == null && $form.form_shop_gname.error == null && $form.form_rank.error == null}
        <li>{$var.message}<br>
    {/if}
    </span>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_shop_gcd.error != null}
        <li>{$form.form_shop_gcd.error}<br>
    {/if}
    {if $form.form_shop_gname.error != null}
        <li>{$form.form_shop_gname.error}<br>
    {/if}
    {if $form.form_rank.error != null}
        <li>{$form.form_rank.error}<br>
    {/if}
    </span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="2" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">FCグループコード<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_shop_gcd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FCグループ名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_shop_gname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC・取引先区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_rank.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value">{$form.form_shop_gnote.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">{$form.form_entry_button.html}　　{$form.form_clear_button.html}</td>
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

全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">FCグループコード</td>
        <td class="Title_Purple">FCグループ名</td>
        <td class="Title_Purple">本社</td>
        <td class="Title_Purple">ショップコード</td>
        <td class="Title_Purple">ショップ名</td>
    </tr>
    {*1行目*}
{foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td><a href=?shop_gid={$item[1]}>{$item[0]}</a></td>
        <td>{$item[5]}</a></td>
        <td align="center">{$item[2]}</td>
        <td>{$item[3]}</td>
        <td>{$item[4]}</td>
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
