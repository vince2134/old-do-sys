{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

<table width="100%" height="90%" class="M_table">


    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>

    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å����� *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_illegal_verify.error != null}
    <li>{$form.err_illegal_verify.error}<br>
{/if}
{if $form.err_noway_forms.error != null}
    <li>{$form.err_noway_forms.error}<br>
{/if}
{foreach from=$form.err_claim1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_claim2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date6 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date3 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date4 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_payin_date5 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_trade key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_bank key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_amount1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_amount2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_rebate key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date2 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_limit_date3 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
</ul>
</span>

{* �����褬�ƻҴط����Υ�å����� *} 
{foreach from=$var.filiation_flg key=j item=err_flg}
{if $err_flg == 1}
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">���{$j+1}���ܡ��ƻҴط��Τ��������褬���򤵤�Ƥ��ޤ���<br></span>
{/if}
{/foreach}

{* ��Ͽ��ǧ��å����� *} 
{if $var.verify_flg == true}
    <span style="font: bold 16px;">�ʲ������Ƥ����⤷�ޤ�����</span><br><br>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

{if $var.verify_flg != true}
<br>
{$form.form_trans_client_btn.html}��{$form.form_trans_bank_btn.html}
<br><br><br>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value">{$form.form_payin_date_clt_set.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ</td>
        <td class="Value">{$form.form_trade_clt_set.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">���</td>
        <td class="Value">{$form.form_bank_clt_set.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table>
    <tr>
        <td>{$form.form_clt_set_btn.html}</td>
    </tr>
</table>
{/if}

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
<table width="100%">
    <tr>
        <td>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����襳����<br>������̾<font color="#ff0000">��</font><br>����̾��1<br>����̾��2</td>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Title_Pink">���<font color="#ff0000">{*��*}</font><br>��Ź<font color="#ff0000">{*��*}</font><br>�����ֹ�<font color="#ff0000">{*��*}</font></td>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink">���<font color="#ff0000">��</font><br>�����</td>
        <td class="Title_Pink">�������<br>��������ֹ�</td>
        <td class="Title_Pink">����</td>
        {if $var.verify_flg != true}<td class="Title_Add">�Ժ��</td>{/if}
    </tr>
    {$var.html}
</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td align="left"><A NAME="foot">{$form.form_add_row_btn.html}</A></td>
        {if $var.verify_flg != true}
        <td align="right">{$form.form_calc_btn.html}</td>
        {/if}
    </tr>
    <tr>
        <td colspan="2" align="right">
            <table class="List_Table" border="1">
            <col width="80" align="center" style="font-weight: bold;">
            <col>
            <col width="80" align="center" style="font-weight: bold;">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">����۹��</td>
                    <td class="Value" align="right" width="100">{$form.form_amount_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">��������</td>
                    <td class="Value" align="right" width="100">{$form.form_rebate_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">���</td>
                    <td class="Value" align="right" width="100">{$form.form_payin_total.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            {if $var.verify_flg != true}<font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>{/if}
        </td>
        <td colspan="2" align="right">
            {* ���ϲ��� *}
            {if $var.verify_flg != true}
            {$form.form_verify_btn.html}
            {* ���ϸ�γ�ǧ���� *}
            {elseif $var.verify_flg == true}
            {$form.hdn_form_ok_btn.html}��{$form.form_return_btn.html}
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
