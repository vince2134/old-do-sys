{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
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

{*+++++++++++++++ エラーメッセージ begin +++++++++++++++*}
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_claim_day1.error != null}
        <li>{$form.form_claim_day1.error}<br>
    {/if}
    {if $form.form_claim_day2.error != null}
        <li>{$form.form_claim_day2.error}<br>
    {/if}
    {if $form.form_claim.error != null}
        <li>{$form.form_claim.error}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $var.duplicate_msg != null}
        <li>{$var.duplicate_msg}<br>
    {/if}


    {foreach from=$non_update_err item=item key=i}
        {if $i == 0}
            <li>以下の取引先は未更新の仕入締データがあるため作成されませんでした。<br>
        {/if}
           　　{$non_update_err[$i].client_cd}　{$non_update_err[$i].client_name}<br>
    {/foreach}

</span>   
{*--------------- エラーメッセージ e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>
<table width="500" >
    <tr>
        <td width="100"></td>
        <td>
        指定した締日の仕入先に対して、仕入締処理を行います
        <table class="Data_Table" border="1" width="300">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">仕入締日<font color="#ff0000">※</font></td>
                <td class="Value">{$form.form_claim_day1.html}</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>
<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">{$form.submit.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br><br>

{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="350" align="center">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">締日</td>
        <td class="Title_Pink">{$var.last_date}</td>
        <td class="Title_Pink">{$var.now_date}</td>
    </tr>
    {foreach from=$page_data item=item key=i}
    <tr class="Result1">        <td align="right">{$i+1}</td>
        <td>{$page_data[$i][0]}</td>
        {if $page_data[$i][1] == null}
        <td align="center">×</td>
        {else}
        <td align="center">○</td>
        {/if}
        {if $page_data[$i][2] == null}
        <td align="center">×</td>
        {else}
        <td align="center">○</td>
        {/if}
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
