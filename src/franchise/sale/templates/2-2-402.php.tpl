{$var.html_header}

<script language="javascript">
{$var.js_sheet}
</script>

<body bgcolor="#D8D0C8" {if $var.verify_flg != true && $var.verify_only_flg != true && $var.group_kind == "2"}onLoad="Staff_Select(); Act_Select();"{/if}>
<form {$form.attributes}>
{$form.hidden}

</script>

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
{if $form.form_payin_date.error != null}
    <li>{$form.form_payin_date.error}<br>
{/if}
{if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
{/if}
{if $form.form_collect_staff.error != null}
    <li>{$form.form_collect_staff.error}<br>
{/if}
{if $form.form_act_client.error != null}
    <li>{$form.form_act_client.error}<br>
{/if}
{if $form.form_claim_select.error != null}
    <li>{$form.form_claim_select.error}<br>
{/if}
{if $form.form_bill_no.error != null}
    <li>{$form.form_bill_no.error}<br>
{/if}
{if $form.err_noway_forms.error != null}
    <li>{$form.err_noway_forms.error}<br>
{/if}
{if $form.err_plural_rebate.error != null}
    <li>{$form.err_plural_rebate.error}<br>
{/if}
{if $form.err_act_trade.error != null}
    <li>{$form.err_act_trade.error}<br>
{/if}
{foreach from=$form.err_trade1 key=j item=err_form}
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
{foreach from=$form.err_bank1 key=j item=err_form}
    {if $err_form.error != null}
        <li>{$err_form.error}<br>
    {/if}
{/foreach}
{foreach from=$form.err_bank2 key=j item=err_form}
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
{if $var.duplicate_err_msg != null}
    <li>{$var.duplicate_err_msg}<br>
{/if}
{if $var.just_daily_update_flg == true}
    <li>���������������Ԥ��Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
{/if}
</ul>
</span>

{* �����褬�ƻҴط����Υ�å����� *}
{if $var.filiation_flg == true}
    <span style="color: #ff00ff; font-weight: bold; line-height: 130%;">��˿ƻҴط��Τ��������褬���򤵤�Ƥ��ޤ���<br></span>
{/if}

{* ��Ͽ��ǧ��å����� *}
{if $var.verify_flg == true && $var.verify_only_flg != true && $var.just_daily_update_flg != true}
    <span style="font: bold 16px;">�ʲ������Ƥ����⤷�ޤ�����</span><br><br>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

{if $var.verify_flg != true && $var.verify_only_flg != true}
<br>
{$form.form_trans_client_btn.html}��{$form.form_trans_bank_btn.html}��{$form.405_button.html}
<br><br><br>
{/if}

<table class="List_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col width="220">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value">{$form.form_payin_no.html}</style></td>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_payin_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" valign="bottom">
            {if $var.verify_flg != true && $var.verify_only_flg != true}<a href="#" onClick="return Open_SubWin('../dialog/2-0-402.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">������</a>{else}������{/if}<font color="#ff0000">��</font><br><br style="font-size: 8px;">���<br>��Ź<br>����</td>
        <td class="Value" colspan="3">{$form.form_client.html}��{$var.client_state_print}<br><br style="font-size: 5px;">{$form.form_c_bank.html}<br>{$form.form_c_b_bank.html}<br>{$form.form_c_account.html}<br></td>
    </tr>
    <tr>
        <td class="Title_Pink">����ô����</td>
        <td class="Value"{if $var.group_kind != "2"} colspan="3"{/if}>{$form.form_collect_staff.html}</td>
        {if $var.group_kind == "2"}
        <td class="Title_Pink">
            {if $var.verify_flg != true && $var.verify_only_flg != true}
{*
            <a href="#" onClick="return Open_SubWin('../dialog/2-0-251.php',Array('form_act_client[cd1]','form_act_client[cd2]','form_act_client[name]','act_client_search_flg'),500,450,5,'daiko');">���Ź����</a>
*}
            <div id="link_str"></div>
            {else}
            ���Ź����
            {/if}
        </td>
        <td class="Value">{$form.form_act_client.html}</td>
        {/if}
    <tr>
        <td class="Title_Pink" valign="bottom">������<span style="color: #ff0000;">��</span><br><br style="font-size: 8px;">����̾��1<br>����̾��2</td>
        <td class="Value">{$form.form_claim_select.html}<br><br style="font-size: 5px;"><div id="pay_account_name">{$var.pay_account_name}</div></td>
        <td class="Title_Pink">�����ֹ�<br>�����</td>
        <td class="Value">{$form.billbill.html}<div id="bill_no_amount">{$var.bill_no_amount}</div></td>
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
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Title_Pink">���<font color="#ff0000">��</font></td>
        <td class="Title_Pink">���<br>��Ź<br>�����ֹ�</td>
        <td class="Title_Pink">�������</td>
        <td class="Title_Pink">��������ֹ�</td>
        <td class="Title_Pink">����</td>
        {if $var.verify_flg != true && $var.verify_only_flg != true}<td class="Title_Add">�Ժ��</td>{/if}
    </tr>
    {$var.html}
</table>
<br style="font-size: 4px;">

<table width="100%">
    <tr>
        <td><A NAME="foot">{$form.form_add_row_btn.html}</A></td>
        {if $var.verify_flg != true && $var.verify_only_flg != true}
        <td align="right"><A NAME="sum">{$form.form_calc_btn.html}</A></td>
        {/if}
    </tr>
    <tr align="right">
        <td colspan="2">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">������</td>
                    <td class="Value" align="right" width="100">{$form.form_amount_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">��������</td>
                    <td class="Value" align="right" width="100">{$form.form_rebate_total.html}</td>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">���</td>
                    <td class="Value" align="right" width="100">{$form.form_payin_total.html}</td>
                </tr>
            </table>
            <br style="font-size: 4px;">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" width="80" align="center" style="font-weight: bold;">�����</td>
                    <td class="Value" align="right" width="100"><div id="bill_amount">{$var.bill_amount}</div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="15"><td colspan="3"></td></tr>
    <tr>
        <td>
            {if $var.verify_flg != true && $var.verify_only_flg != true}<font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>{/if}
        </td>
        <td colspan="2" align="right">
            {* ���ϲ��� *}
            {if $var.verify_flg != true && $var.verify_only_flg != true}
            {$form.form_verify_btn.html}
            {* ���ϸ�γ�ǧ���� *}
            {elseif $var.verify_flg == true && $var.verify_only_flg != true}
            {$form.hdn_form_ok_btn.html}��{$form.form_return_btn.html}
            {* ����������ޤ������ID������ǡ����γ�ǧ���� *}
            {elseif $var.verify_flg != true && $var.verify_only_flg == true}
            {$form.form_return_btn.html}
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
