{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
{$var.js}
</script>


<body bgcolor="#D8D0C8" onLoad="Text_Disabled('{$smarty.post.form_slipout_type[0]}')">
<form {$form.attributes}>
{$form.hidden}
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_branch_id.error != null}
        <li>{$form.form_branch_id.error}<br>
    {/if}
    {if $form.form_claim_day1.error != null}
        <li>{$form.form_claim_day1.error}<br>
    {/if}
    {if $form.form_claim_day2.error != null}
        <li>{$form.form_claim_day2.error}<br>
    {/if}
    {if $form.form_claim.error != null}
        <li>{$form.form_claim.error}<br>
    {/if}
    {if $form.form_year_month.error != null}
        <li>{$form.form_year_month.error}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    <ul>
    {foreach from=$sale_err key=i item=item}
        {if $i == 0}
        <li>�ʲ��������ɼ��������������Ƥ��ʤ���������ǡ����κ����˼��Ԥ��ޤ�����<br>
        {/if}
        {$item}<br>
    {/foreach}
    {foreach from=$pay_err key=i item=item}
        {if $i == 0}
        <li>�ʲ���������ɼ��������������Ƥ��ʤ���������ǡ����κ����˼��Ԥ��ޤ�����<br>
        {/if}
        {$item}<br>
    {/foreach}
    {foreach from=$advance_err key=i item=item}
        {if $i == 0}
        <li>�ʲ�����������ɼ�ϳ��ꤵ��Ƥ��ʤ���������ǡ����κ����˼��Ԥ��ޤ�����<br>
        {/if}
        {$item}<br>
    {/foreach}
    </ul>
</span>   
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>
        <div class="note">
        ����ǡ����κ����ˤĤ���<br>
        ���������򹹿���Ϻƺ�������ޤ���<br>
        ������������������������ǡ������ѹ���ǽ�Ǥ���â������������ѤΥǡ����������ƺ�����ǽ�Ǥ���<br>
        <div><p>
<table width="500" >
    <tr>
        <td align="left" colspan="2">{$form.form_slipout_type[0].html}</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        ���ꤷ����������������Ф��ơ�������������ޤ�
        <table class="Data_Table" border="1" width="300">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">�ܻ�Ź<font color="#ff0000">��</font></td>
                <td class="Value">{$form.form_branch_id.html}</td>
            </tr>
            <tr>
                <td class="Title_Pink">��������<font color="#ff0000">��</font></td>
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

<table width="660" >
    <tr>
        <td align="left" colspan="2">{$form.form_slipout_type[1].html}</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        ���ꤷ����������Ф��ơ����ꤷ�����������ޤǤ�������������ޤ�
        <table class="Data_Table" border="1" width="450">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">{$form.form_claim_link.html}<font color="#ff0000">��</font></td>
                <td class="Value">{$form.form_claim.html}</td>
            </tr>
            <tr>
                <td class="Title_Pink">��������<font color="#ff0000">��</font></td>
                {*<td class="Value">{$form.form_claim_day2.html}����{$form.form_year_month.html}��</td>*}
                <td class="Value">{$form.form_claim_day2.html}</td>
            </tr>
        </table>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_create_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="450" align="center">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink" rowspan="2" width="30">����</td>
        <td class="Title_Pink" colspan="{$page_data.colspan}">{$var.last_date}</td>
        <td class="Title_Pink" colspan="{$page_data.colspan}">{$var.now_date}</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        {foreach from=$page_data.cd item=item key=i}
            <td class="Title_Pink">{$page_data[$item].name}</td>
        {/foreach}
        {foreach from=$page_data.cd item=item key=i}
            <td class="Title_Pink">{$page_data[$item].name}</td>
        {/foreach}
    </tr>

    {foreach from=$page_data.close_day item=item key =i}
    <tr class="Result1">
        <td align="right">{$item}</td>
        {foreach from=$page_data.cd item=items key=j}
            {if $page_data[$items].data.$item.last != null}
            <td align="center">{$page_data[$items].data.$item.last}</td>
            {else}
            <td align="center">-</td>
            {/if}
        {/foreach}
        {foreach from=$page_data.cd item=items key=j}
            {if $page_data[$items].data.$item.last != null}
            <td align="center">{$page_data[$items].data.$item.now}</td>
            {else}
            <td align="center">-</td>
            {/if}
        {/foreach}
    </tr> 
    {/foreach}    
</table>
<br>
�����������ѡ����ߡ�������̤�����ݡ��о�������������̵��
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
