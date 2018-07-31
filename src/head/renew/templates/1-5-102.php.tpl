{* -------------------------------------------------------------------
 * @Program         1-5-102.php.tpl 2-5-102.php.tpl
 * @fnc.Overview    月次更新処理
 * @author          kajioka-h <kajioka-h@bhsk.co.jp>
 * @Cng.Tracking    #1: 2006/09/09
 * ---------------------------------------------------------------- *}

{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

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

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 実行完了メッセージ *}
{if $var.complete_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>{$var.complete_msg}<br>
    </span><br>
{/if}

{* エラーメッセージ *}
{if $var.renew_err_flg == true}
    <span style="font: bold; color: #ff0000;">
    <ul style="margin-left: 16px;">
    {if $form.form_renew_day.error != null}
        <li>{$form.form_renew_day.error}</li><br>
    {/if}
    {if $var.form_input_err_msg != null}
        <li>{$var.form_input_err_msg}</li><br>
    {/if}
    {if $var.start_day_err_msg != null}
        <li>{$var.start_day_err_msg}</li><br>
    {/if}
    {if $var.renew_day_sale_err_msg != null}
        <li>{$var.renew_day_sale_err_msg}</li><br>
    {/if}
    {if $var.renew_day_buy_err_msg != null}
        <li>{$var.renew_day_buy_err_msg}</li><br>
    {/if}
    {if $var.renew_day_payin_err_msg != null}
        <li>{$var.renew_day_payin_err_msg}</li><br>
    {/if}
    {if $var.renew_day_payout_err_msg != null}
        <li>{$var.renew_day_payout_err_msg}</li><br>
    {/if}
    {if $var.invent_err_msg != null}
        <li>{$var.invent_err_msg}</li><br>
    {/if}
    {if $var.payment_err_msg != null}
        <li>{$var.payment_err_msg}</li><br>
    {/if}
    {if $var.bill_err_msg != null}
        <li>{$var.bill_err_msg}</li><br>
    {/if}
    </ul>
    </span>
{/if}
{* インフォメーション *}
<span style="font:bold; color: #555555;">入力した年月の情報を月次更新します</span><br><br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="300">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td width="80" class="Title_Green"><b>更新年月<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_renew_day.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.jikkou.html}</td>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">月次更新年月</td>
        <td class="Title_Green">締日</td>
        <td class="Title_Green">実施時間</td>
    </tr>
    {foreach from=$rec_data key=i item=item}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td align="center">{$item[0]}</td>
        <td align="center">{$item[1]}</td>
        <td align="center">{$item[2]}</td>
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
