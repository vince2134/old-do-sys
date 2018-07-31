{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
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
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 登録・変更完了メッセージ出力 *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_bank_b_bank.error != null}<li>{$form.form_bank_b_bank.error}<br>{/if}
{if $form.form_deposit_kind.error != null}<li>{$form.form_deposit_kind.error}<br>{/if}
{if $form.form_account_no.error != null}<li>{$form.form_account_no.error}<br>{/if}
{if $form.form_account_identifier.error != null}<li>{$form.form_account_identifier.error}<br>{/if}
{if $form.form_account_holder.error != null}<li>{$form.form_account_holder.error}<br>{/if}
</span>


{$form.genre.html}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple"><b>銀行名<font color="#ff0000">※</font></b></td>
        <td class="Value">{*{$form.form_bank_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>支店名<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_b_bank_select.html}*}{$form.form_bank_b_bank.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">預金種目<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_deposit_kind.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座番号<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_account_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_account_identifier.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">口座名義<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_account_holder.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">非表示</td>
        <td class="Value">{$form.form_nondisp_flg.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">{$form.form_entry_btn.html}　　{$form.form_clear_btn.html}</td>
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
<table width="100%">
    <tr>
        <td>

全<b>{$var.total_count}</b>件　{$form.form_csv_btn.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">銀行コード</td>
        <td class="Title_Purple">銀行名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">支店コード</td>
        <td class="Title_Purple">支店名</td>
        <td class="Title_Purple">預金種目</td>
        <td class="Title_Purple">口座番号</td>
        <td class="Title_Purple">口座名</td>
        <td class="Title_Purple">口座名義</td>
        <td class="Title_Purple">非表示</td>
        <td class="Title_Purple">備考</td>
    </tr>
    {foreach key=i from=$row item=item}
    <tr class="{$tr[$i]}"> 
        <td align="right">{$i+1}</td>
        <td>{$item[0]}</td>
        <td>{$item[1]}</td>
        <td>{$item[2]}</td>
        <td>{$item[3]}</td>
        <td>{$item[4]}</td>
        <td>{$item[6]}</td>
        <td><a href="2-1-210.php?account_id={$item[5]}">{$item[7]}</a></td>
        <td>{$item[8]}</td>
        <td>{$item[9]}</td>
        <td align="center">{$item[10]}</td>
        <td>{$item[11]}</td>
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
