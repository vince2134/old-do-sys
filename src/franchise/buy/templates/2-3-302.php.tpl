{$var.html_header}

<script Language="JavaScript">
<!--
{$var.js}
-->
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>   
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>    
            <table> 
                <tr>    
                    <td>    

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å��������� *} 
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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $var.disp_pattern == "1"} 
<table>
    <tr>    
        <td>    

<table class="List_Table" border="1">
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">��ʧ��</td>        
        <td class="Value">{$form.form_pay_day_all.html}</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">�����ʬ</td> 
        <td class="Value">{$form.form_trade_all.html}</td>
    </tr>   
    <tr>    
        <td class="Title_Blue" style="font-weight:bold;">���</td> 
        <td class="Value">{$form.form_bank_all.html}</td>
    </tr>   
</table>

        </td>   
        <td valign="bottom">{$form.all_set_button.html}</td>
    </tr>   
</table>
{/if}
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>   
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
<col>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">�����襳����<font color="red">��</font><br>������̾<br>�������</td>
        <td class="Title_Blue">��ʧ��<font color="red">��</font></td>
        <td class="Title_Blue">�����ʬ<font color="red">��</font></td>
        <td class="Title_Blue">���̾<br>��Ź̾<br>�����ֹ�</td>
        <td class="Title_Blue">��ʧͽ���</td>
        <td class="Title_Blue">��ʧ���<font color="red">��</font><br>�����</td>
        <td class="Title_Blue">�����<br>��������ֹ�</td>
        <td class="Title_Blue">����</td>
        {if $var.disp_pattern == "1"}
        <td style="background-color:800080;color:white;font-style:bolde">�Ժ��</td>
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
            <font color="#ff0000"><b>����ɬ�����ϤǤ� </b></font>
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
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">��ʧ��۹��</td>
        <td class="Value" align="right" width="90">{$var.sum_pay_mon|number_format}</td>
        <td class="Title_Blue" width="90" style="font-weight:bold;" align="center">��������</td>
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
            {$form.payout_button.html}��{$form.back_btn.html}
            {/if}
        </td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ����ƥ���� e n d ---------------*}

</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
