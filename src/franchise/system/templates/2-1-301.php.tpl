{$var.html_header}

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
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ɽ�����¤Τ߻��Υ�å����� *} 
{* ��Ͽ���ѹ���λ��å��������� *}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.fin_msg != null}<li>{$var.fin_msg}<br>{/if}
    </span>
{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $var.head_cd_err != null}
    <li>{$var.head_cd_err}<br>
    {/if}
    {if $form.form_shop_cd.error != null}
    <li>{$form.form_shop_cd.error}<br>
    {/if}
    {if $form.form_comp_name.error != null}
    <li>{$form.form_comp_name.error}<br>
    {/if}
    {if $form.form_post_no.error != null}
    <li>{$form.form_post_no.error}<br>
    {/if}
    {if $form.form_address1.error != null}
    <li>{$form.form_address1.error}<br>
    {/if}
    {if $form.form_area.error != null}
    <li>{$form.form_area.error}<br>
    {/if}
    {if $form.form_capital_money.error != null}
    <li>{$form.form_capital_money.error}<br>
    {/if}
    {if $form.form_tel.error != null}
    <li>{$form.form_tel.error}<br>
    {elseif $var.tel_err != null}
    <li>{$var.tel_err}<br>
    {/if}
    {if $var.fax_err != null}
    <li>{$var.fax_err}<br>
    {/if}
	{if $var.cal_err != null}
    <li>{$var.cal_err}<br>
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
    {if $var.d_tel_err != null}
    <li>{$var.d_tel_err}<br>
    {/if}
    {if $var.contact_cell_err != null}
    <li>{$var.contact_cell_err}<br>
    {/if}
    {if $form.form_establish_day.error != null}
    <li>{$form.form_establish_day.error}<br>
    {elseif $var.eday_err != null}
    <li>{$var.eday_err}<br>
    {/if}
    {if $form.form_corpo_day.error != null}
    <li>{$form.form_corpo_day.error}<br>
    {elseif $var.cday_err != null}
    <li>{$var.cday_err}<br>
    {/if}
    {* 2009-12-24 aoyama-n *}
    {*{if $form.form_tax.error != null}*}
    {*<li>{$form.form_tax.error}<br>*}
    {if $form.form_tax_rate_new.error != null}
    <li>{$form.form_tax_rate_new.error}<br>
    {/if}
    {* 2009-12-24 aoyama-n *}
    {*{if $form.form_tax_rate_day.error != null}*}
    {*<li>{$form.form_tax_rate_day.error}<br>*}
    {if $form.form_tax_change_day_new.error != null}
    <li>{$form.form_tax_change_day_new.error}<br>
    {elseif $var.rday_err != null}
    <li>{$var.rday_err}<br>
    {/if}
    {if $form.form_close_day.error != null}
    <li>{$form.form_close_day.error}<br>
    {/if}
    {if $form.form_pay_month.error != null}
    <li>{$form.form_pay_month.error}<br>
    {/if}
    {if $form.form_pay_day.error != null}
    <li>{$form.form_pay_day.error}<br>
    {/if}
    {if $form.form_cutoff_month.error != null}
    <li>{$form.form_cutoff_month.error}<br>
    {/if}
    {if $form.form_cutoff_day.error != null}
    <li>{$form.form_cutoff_day.error}<br>
    {/if}
    {if $form.form_cname.error != null}
    <li>{$form.form_cname.error}<br>
    {/if}
    {if $form.form_my_close_day.error != null}
    <li>{$form.form_my_close_day.error}<br>
    {/if}
    {if $form.form_my_pay_day.error != null}
    <li>{$form.form_my_pay_day.error}<br>
    {/if}
    {if $form.form_my_pay_month.error != null}
    <li>{$form.form_my_pay_month.error}<br>
    {/if}
    </span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}
<table>
    <tr>
        <td>

<span style="font: bold 16px; color: #555555;">�ڼ��Ҿ����</span><br>
<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col width="250">
    <tr>
        <td class="Title_Purple">����åץ�����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_shop_cd.html}</td>
        <td class="Title_Purple" align="center" colspan="2">�Ұ�</td>
    </tr>
    <tr>
        <td class="Title_Purple">����å�̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_cname.html}</td>
        <td class="Value" rowspan="6" colspan="2" valign="middle">
            <table align="center">
                <tr>
                    <td align="center" valign="middle">
                        <table width="60" height="60" align="center" style="background-image: url({$var.path_shain});background-repeat:no-repeat; cellspacing="0" cellpadding="0" border="0">
                            <tr><td><br></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table align="center">
                <tr>
                    {*<td colspan="2">��<input type="file" name="File"></td>*}
                    <td colspan="2">{$form.button.change_stamp.html}��{$form.button.delete_stamp.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">����å�̾<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_cread.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_comp_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾1<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_comp_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾2</td>
        <td class="Value">{$form.form_comp_name2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��̾2<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_comp_read2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">͹���ֹ�<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_post_no.html}��{$form.button.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����1<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_address1.html}</td>
        <td class="Title_Purple">����2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����3<br>(�ӥ�̾��¾)</td>
        <td class="Value">{$form.form_address3.html}</td>
        <td class="Title_Purple">����2<br>(�եꥬ��)</td>
        <td class="Value">{$form.form_address_read.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_area.html}</td>
        <td class="Title_Purple">���ܶ�</td>
        <td class="Value">{$form.form_capital_money.html}����</td>
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
        <td class="Value">{$form.form_represe.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ�Է���</td>
        <td class="Value">{$form.form_represent_cell.html}</td>
        <td class="Title_Purple">ľ��TEL</td>
        <td class="Value">{$form.form_direct_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Ϣ��ô���Ի�̾</td>
        <td class="Value">{$form.form_contact_name.html}</td>
        <td class="Title_Purple">Ϣ��ô������</td>
        <td class="Value">{$form.form_contact_position.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">Ϣ��ô���Է���</td>
        <td class="Value" colspan="3">{$form.form_contact_cell.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶���</td>
        <td class="Value">{$form.form_establish_day.html}</td>
        <td class="Title_Purple">ˡ���е���</td>
        <td class="Value">{$form.form_corpo_day.html}</td>
    </tr>
</table>
<br>

<span style="font: bold 16px; color: #555555;">�ھ����������</span><br>
<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col width="250">
    <tr>
        <td class="Title_Purple"><b>�������Ψ</b></td>
        <td class="Value" colspan="3">{$form.form_tax_rate_old.html} %</td>
    </tr>
    <tr>
        <td class="Title_Purple" style="color: blue; font-weight: bold">��������Ψ</td>
        <td class="Value" style="color: blue; font-weight: bold">{$form.form_tax_rate_now.html} %</td>
        <td class="Title_Purple" style="color: blue; font-weight: bold">����Ψ������</td>
        <td class="Value" style="color: blue; font-weight: bold">{$form.form_tax_change_day_now.html}</td>
    </tr>
    <tr>
        <td class="Value" colspan="4">{$form.form_tax_setup_flg.html} ��������Ψ�����ꤹ��
            <span style="color: #ff0000; font-weight: bold; font-size:12px;">��
            �����å���Ĥ�����硢�����ι��ܤ�ɬ�����Ϥˤʤ�ޤ�
            </span>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>��������Ψ</b></td>
        <td class="Value">{$form.form_tax_rate_new.html} %</td>
        <td class="Title_Purple"><b>����Ψ������</b></td>
        <td class="Value">{$form.form_tax_change_day_new.html}</td>
    </tr>
</table>
<br>

<table border="0" width="985">
	<tr>
	<td align="left"><span style="font: bold 16px; color: #555555;">�ڴĶ������</span></td>
	<td align="left" width=922><b><font color="blue"><li>��������ɽ�����֤��ѹ�����ȡ���¸��ͽ��ǡ����������˺������������ޤ���</font></b></td>
	</tr>
</table>
<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col width="250">
<col width="160" style="font-weight: bold;">
<col width="250">
    <tr>
        <td class="Title_Purple">�����������</td>
        <td class="Value">{$form.form_close_day.html}</td>
        <td class="Title_Purple">���������ʧ��</td>
        <td class="Value">{$form.form_pay_month.html}��{$form.form_pay_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���Ҽ������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_my_close_day.html}</td>
        <td class="Title_Purple">���Ҽ����ʧ��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_my_pay_month.html}��{$form.form_my_pay_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�軻��</td>
        <td class="Value" colspan="3">{$form.form_cutoff_month.html}�� {$form.form_cutoff_day.html}��</td>
    </tr>
    <tr>
        <td class="Title_Purple">ABCD�������</td>
        <td class="Value">{$form.form_abcd_day.html} ��A�����������Ȥ���</td>
        <td class="Title_Purple">��������ɽ������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_cal_peri.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������ֹ�����<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_claim_num.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ۤޤ���ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.form_coax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������ü����ʬ<font color="#ff0000">��</font></td>
        <td class="Value" colspan="3">{$form.from_fraction_div.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.button.entry_button.html}</td>
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