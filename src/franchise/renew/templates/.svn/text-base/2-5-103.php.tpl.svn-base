
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* エラーメッセージ *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_claim_day1.error != null}
        <li>{$form.form_claim_day1.error}<br>
    {/if}   
    {if $var.no_target_err != null}
        <li>{$var.no_target_err}<br>
    {/if}   
    {if $var.unconf_warning != null}
        <li>{$var.unconf_warning}<br>
    {/if}   
    </span>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.update_message != null}
        <li>{$var.update_message}<br>
    {/if}   
    </span> 
{*--------------- メッセージ類 e n d ---------------*}

{*-------------------- 画面表示1開始 -------------------*}
<table  class="Data_Table" border="1" width="450" >

    <tr>
        <td class="Title_Green" width="100"><b>請求更新日<font color="red">※</font></b></td>
        <td class="Value">{$form.form_claim_day1.html}</td>
    </tr>

</table>

<table width='450'>
    <tr>
        <td align='right'>{$form.form_add_button.html}</td>
    </tr>
</table>


{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td>

{*-------------------- 画面表示2開始 -------------------*}

<table class="List_Table" border="1" width="450">
    <tr align="center">
        <td class="Title_Green" width=""><b>No.</b></td>
        <td class="Title_Green" width=""><b>請求更新日</b></td>
        <td class="Title_Green" width=""><b>請求更新実施日時</b></td>
        <td class="Title_Green" width=""><b>請求更新実施者</b></td>
    </tr>

    {foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td align="center">{$page_data[$i][0]}</td>
        <td align="center">{$page_data[$i][1]}</td>
        <td align="left">{$page_data[$i][2]}</td>
    </tr>
    {/foreach}

</table>

{********************* 画面表示2終了 ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
