{$var.html_header}

<script Language="JavaScript">
<!--
{$var.js}
-->
</script>

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

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ出力 *} 
{if $errors != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        {foreach from=$errors item=errors}
        <li>{$errors}</li><BR>
        {/foreach}
    </span> 
{/if}
{if $var.duplicate_err != null}
    <li>{$var.duplicate_err}<br>
{/if}
</span>
<br>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{if $var.disp_pattern == "1"} 
<table>
    <tr>    
        <td>    

<table class="List_Table" border="1">
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">支払日</td>        
        <td class="Value">{$form.form_pay_day_all.html}</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">取引区分</td> 
        <td class="Value">{$form.form_trade_all.html}</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">銀行</td> 
        <td class="Value">{$form.form_bank_all.html}</td>
    </tr>   
</table>

        </td>   
        <td valign="bottom">{$form.all_set_button.html}</td>
    </tr>   
</table>
{/if}
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>   
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">仕入先コード<font color="red">※</font><br>仕入先名<br>振込銀行</td>
        <td class="Title_Blue">支払日<font color="red">※</font></td>
        <td class="Title_Blue">取引区分<font color="red">※</font></td>
        <td class="Title_Blue">銀行名<br>支店名<br>口座番号</td>
        <td class="Title_Blue">支払予定額</td>
        <td class="Title_Blue">支払金額<font color="red">※</font><br>手数料</td>
        <td class="Title_Blue">決済日<br>手形券面番号</td>
        <td class="Title_Blue">備考</td>
        {if $var.disp_pattern == "1"}
        <td style="background-color:800080;color:white;font-style:bolde">行削除</td>
        {/if}
    </tr>
    {$var.html_l}
</table>

        </td>
    </tr>

{if $var.disp_pattern == "1"}
    <tr>
        <td>

<table width="100%">
    <tr>
        <td>
            <font color="#ff0000"><b>※は必須入力です </b></font>
            <br>
            <A NAME="foot">{$form.add_row_button.html}</A>
        </td>
    </tr>
</table>

        </td>
    </tr>
{/if}

{if $var.disp_pattern == "4"}
    <tr>
        <td>

<br style="font-size: 4px;">
<table class="List_Table" align="right">
    <tr>
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">支払金額合計</td>
        <td class="Value" align="right" width="90">{$var.sum_pay_mon|number_format}</td>
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">手数料合計</td>
        <td class="Value" align="right" width="90">{$var.sum_pay_fee|number_format}</td>
    </tr>
</table>

        </td>
    </tr>
{/if}

    <tr>
        <td>

<br style="font-size: 4px;">
<table width="100%">
    <tr style="font-weight:bold;" align="right">
        <td align="right" colspan="3">
            {if $var.disp_pattern == "1"}
            {$form.confirm_button.html}
            {elseif $var.disp_pattern == "2"}
            {$form.confirm_button.html}
            {elseif $var.disp_pattern == "3"}
            {$form.back_btn.html}
            {elseif $var.disp_pattern == "4"}
            {$form.payout_button.html}　{$form.back_btn.html}
            {/if}
        </td>
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
