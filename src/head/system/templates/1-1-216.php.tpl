
{$var.html_header}

<script language="javascript">
{$var.contract}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td valign="top">
            <table>
                <tr>
                    <td>

{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_area_id.error != null}
        <li>{$form.form_area_id.error}<br>
    {/if}
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_shop_gr_1.error != null}
    <li>{$form.form_shop_gr_1.error}<br>
    {/if}
    {if $var.client_cd_err != null}
    <li>{$var.client_cd_err}<br>
    {elseif $form.form_client_cd.error != null}
    <li>{$form.form_client_cd.error}<br>
    {/if}
    {if $form.form_client_name.error != null}
        <li>{$form.form_client_name.error}<br>
    {/if}
    {if $form.form_client_cname.error != null}
        <li>{$form.form_client_cname.error}<br>
    {/if}
    {if $form.form_post.error != null}
        <li>{$form.form_post.error}<br>
    {/if}
    {if $form.form_address1.error != null}
        <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_capital.error != null}
        <li>{$form.form_capital.error}<br>
    {/if}
    {if $form.form_tel.error != null}
    <li>{$form.form_tel.error}<br>
    {elseif $var.tel_err != null}
    <li>{$var.tel_err}<br>
    {/if}
    {if $form.form_fax.error != null}
    <li>{$form.form_fax.error}<br>
    {/if}
    {if $var.email_err != null}
    <li>{$var.email_err}<br>
    {/if}
    {if $var.url_err != null}
    <li>{$var.url_err}<br>
    {/if}
    {if $form.form_rep_name.error != null}
        <li>{$form.form_rep_name.error}<br>
    {/if}
    {if $form.form_account.error != null}
        <li>{$form.form_account.error}<br>
    {/if}
    {if $form.form_represent_cell.error != null}
    <li>{$form.form_represent_cell.error}<br>
    {/if}
    {if $form.form_direct_tel.error != null}
    <li>{$form.form_direct_tel.error}<br>
    {elseif $var.d_tel_err != null}
    <li>{$var.d_tel_err}<br>
    {/if}
    {if $form.trade_ord.error != null}
        <li>{$form.trade_ord.error}<br>
    {/if}
    {if $form.form_cshop.error != null}
        <li>{$form.form_cshop.error}<br>
    {/if}
    {if $var.close_err != null}
        <li>{$var.close_err}<br>
    {/if}
    {if $var.c_staff_err != null}
        <li>{$var.c_staff_err}<br>
    {/if}
    {if $form.form_close.error != null}
        <li>{$form.form_close.error}<br>
    {/if}
    {if $form.form_pay_m.error != null}
        <li>{$form.form_pay_m.error}<br>
    {/if}
    {if $form.form_pay_d.error != null}
        <li>{$form.form_pay_d.error}<bt>
    {/if}
    {if $form.form_start.error != null}
        <li>{$form.form_start.error}<br>
    {elseif $var.start_err != null}
        <li>{$var.start_err}<br>
    {/if}
    {if $form.form_trans_s_day.error != null}
        <li>{$form.form_trans_s_day.error}<br>
    {elseif $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    </span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table width="810">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right">{if $smarty.get.client_id != null}{$form.back_button.html}��{$form.next_button.html}{/if}</td> 
   </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Type" width="60" align="center"><b>����</b></td>
                    <td class="Value">{$form.form_state.html}</td>
                </tr>
            </table>
        </td>
       </tr>   
</table>

<table width="100%">
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>�϶�<font color="#ff0000">��</font></b></td>
                    <td class="Value">{$form.form_area_id.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>�ȼ�<font color="#ff0000">��</font></b></td>
                    <td class="Value">{$form.form_btype.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_inst.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table class="Data_Table" border="1" width="403">
                <tr>
                    <td class="Title_Purple" width="60"><b>����</b></td>
                    <td class="Value" width="*">{$form.form_bstruct.html}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%" style="border: 2px solid #3300ff;">
<col width="150" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_client_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_client_name.html}</td>
        <td class="Title_Purple">������̾1<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_client_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾2</td>
        <td class="Value">{$form.form_client_name2.html}</td>
        <td class="Title_Purple">������̾2<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_client_read2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ά��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_client_cname.html}</td>
        <td class="Title_Purple">ά��<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_cname_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">͹���ֹ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_post.html}����{$form.button.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_address1.html}</td>
        <td class="Title_Purple">����2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����3</td>
        <td class="Value">{$form.form_address3.html}</td>
        <td class="Title_Purple">����2<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_address_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ܶ�</td>
        <td class="Value" colspan="3">{$form.form_capital.html}����</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_tel.html}</td>
        <td class="Title_Purple">FAX</td>
        <td class="Value">{$form.form_fax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Email</td>
        <td class="Value">{$form.form_email.html}</td>
        <td class="Title_Purple">URL</td>
        <td class="Value">{$form.form_url.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Ի�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_rep_name.html}</td>
        <td class="Title_Purple">��ɽ����</td>
        <td class="Value">{$form.form_represent_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Է���</td>
        <td class="Value">{$form.form_represent_cell.html}</td>
        <td class="Title_Purple">ľ��TEL</td>
        <td class="Value">{$form.form_direct_tel.html}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
<col width="64" style="font-weight: bold;">
<col width="84" style="font-weight: bold;">
<col width="240">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">�����ô��</td>
        <td class="Value">{$form.form_charger.html}</td>
        <td class="Title_Purple">����ô��</td>
        <td class="Value">{$form.form_staff_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����������</td>
        <td class="Value" colspan="3">{$form.form_part.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.trade_ord.html}</td>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_close.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��ʧ��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_pay_m.html}��{$form.form_pay_d.html}��</td>
        <td class="Title_Purple">��ʧ���</td>
        <td class="Value">{$form.form_pay_terms.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��������</td>
        <td class="Value" colspan="3">{$form.form_bank.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">��������ά��</td>
        <td class="Value" colspan="3">{$form.form_b_bank_name.html}</td>
    </tr>

{*
    <tr>
        <td class="Title_Purple" colspan="2">�����ֹ�</td>
        <td class="Value">{$form.form_intro_ac_num.html}</td>
        <td class="Title_Purple">����̾��</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="3">{$form.form_holiday.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�϶���</td>
        <td class="Value">{$form.form_start.html}</td>
        <td class="Title_Purple">���������</td>
        <td class="Value">{$form.form_trans_s_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���<font color="#ff0000">��</font></td>
        <td class="Title_Purple">�ޤ���ʬ</td>
        <td class="Value" colspan="3">{$form.form_coax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="3">������<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��</td>
        <td class="Value" colspan="3">{$form.form_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ü����ʬ</td>
        <td class="Value" colspan="3">{$form.form_tax_franct.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ƕ�ʬ</td>
        <td class="Value" colspan="3">{$form.form_c_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">�������</td>
        <td class="Value" colspan="3">{$form.form_record.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">���׻���</td>
        <td class="Value" colspan="3">{$form.form_important.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" colspan="2">����</td>
        <td class="Value" colspan="3">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.button.entry_button.html}����{*{$form.button.res_button.html}*}{$form.button.ok_button.html}����{$form.button.back_button.html}</td>
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
