
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			{*+++++++++++++++ �إå��� begin +++++++++++++++*} {$var.page_header} {*--------------- �إå��� e n d ---------------*}
		</td>
	</tr>

	<tr align="center">
	

		{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
		<td valign="top">

			<table border="0">
				<tr>
					<td>
{* ---------------------- ����ɽ��1���� --------------------- *}

{* ��Ͽ���ѹ���λ��å��������� *}
	<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
	{if $var.fin_msg != null}<li>{$var.fin_msg}<br>{/if}
	</span>
{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $var.head_cd_err != null}
    <li>{$var.head_cd_err}<br>
    {/if}
    {if $form.form_head_cd.error != null}
    <li>{$form.form_head_cd.error}<br>
    {/if}
    {if $form.form_comp_name.error != null}
    <li>{$form.form_comp_name.error}<br>
    {/if}
    {if $form.form_rep_name.error != null}
    <li>{$form.form_rep_name.error}<br>
    {/if}
    {if $form.form_post_no.error != null}
    <li>{$form.form_post_no.error}<br>
    {/if}
    {if $form.form_address1.error != null}
    <li>{$form.form_address1.error}<br>
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
    {if $var.email_err != null}
    <li>{$var.email_err}<br>
    {/if}
    {if $var.url_err != null}
    <li>{$var.url_err}<br>
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
    {if $form.form_cname.error != null}
    <li>{$form.form_cname.error}<br>
    {/if}
    {if $form.form_pay_month.error != null}
    <li>{$form.form_pay_month.error}<br>
    {/if}
    {if $form.form_pay_day.error != null}
    <li>{$form.form_pay_day.error}<br>
    {/if}
    {if $form.form_close_month.error != null}
    <li>{$form.form_close_month.error}<br>
    {/if}
    {if $form.form_ware.error != null}
    <li>{$form.form_ware.error}<br>
    {/if}
    {if $form.form_abcd_day.error != null}
    <li>{$form.form_abcd_day.error}<br>
    {/if}
    </span><br>
<font size="+0.5" color="#555555"><b>�ڼ��Ҿ����</b></font>
{$form.hidden}
<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
	<tr>
		<td class="Title_Purple"><b>����������<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_head_cd.html}</td>
		<td class="Title_Purple" align="center" colspan="2"><b>�Ұ�</b></td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��̾<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_comp_name.html}</td>
		<td class="Value" rowspan="4" colspan="2">
			<table align="center">
			<tr>
				<td>
                    <table width="60" height="60" align="center" style="background-image: url({$var.path_shain});background-repeat:no-repeat; cellspacing="0" cellpadding="0" border="0">
                        <tr><td><br></td></tr>
                    </table>
				</td>
				<td valign="top"><br>
				</td>
			</tr>
			</table>
			<table align="center">
			<tr>
				{* <td colspan="2">��<input type="file" name="File"></td> *}
				<td colspan="2">{$form.button.change_stamp.html}��{$form.button.delete_stamp.html}</td>
			</tr>
			</table>
			</td>
		</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��̾2</b></td>
	 	<td class="Value">{$form.form_comp_name2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>��̾<br>(�եꥬ��)</b></td>
	 	<td class="Value">{$form.form_comp_read.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��̾2<br>(�եꥬ��)</b></td>
	 	<td class="Value">{$form.form_comp_read2.html}</td>
	</tr>

	<tr>
        <td class="Title_Purple"><b>ά��<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_cname.html}</td>
        <td class="Title_Purple"><b>ά��<br>(�եꥬ��)</b></td>
        <td class="Value">{$form.form_cread.html}</td>
    </tr>

	<tr>
		<td class="Title_Purple"width="100"><b>͹���ֹ�<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_post_no.html}��{$form.button.input_button.html}</td>
	</tr>

    <tr>
        <td class="Title_Purple"><b>����1<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_address1.html}</td>
        <td class="Title_Purple"><b>����2</b></td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>����3<br>(�ӥ�̾��¾)</b></td>
        <td class="Value">{$form.form_address3.html}</td>
        <td class="Title_Purple"><b>����2<br>(�եꥬ��)</b></td>
        <td class="Value">{$form.form_address_read.html}</td>
    </tr>

	<tr>
		<td class="Title_Purple" width="130"><b>���ܶ�</b></td>
		<td class="Value" colspan="3">{$form.form_capital_money.html}����</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>TEL<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_tel.html}</td>
		<td class="Title_Purple"><b>FAX</b></td>
		<td class="Value">{$form.form_fax.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>Email</b></td>
		<td class="Value">{$form.form_email.html}</td>
		<td class="Title_Purple"><b>URL</b></td>
		<td class="Value">{$form.form_url.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��ɽ�Ի�̾<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_rep_name.html}</td>
		<td class="Title_Purple"><b>��ɽ����</b></td>
		<td class="Value">{$form.form_represe.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>��ɽ�Է���</b></td>
		<td class="Value">{$form.form_represent_cell.html}</td>
		<td class="Title_Purple"><b>ľ��TEL</b></td>
		<td class="Value">{$form.form_direct_tel.html}</td>
	</tr>


</table>
<br>
<font size="+0.5" color="#555555"><b>�ھ����������</b></font>
<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
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
<font size="+0.5" color="#555555"><b>�ڴĶ������</b></font>
<table class="Data_Table" border="1" width="810">
<col width="125">
<col width="280">
<col width="125">
<col width="280">
	<tr>
		<td class="Title_Purple"><b>����<font color="#ff0000">��</font></b></td>
		<td class="Value">
			{$form.form_close_day.html}
		</td>
		<td class="Title_Purple"><b>��ʧ��<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_pay_month.html}��{$form.form_pay_day.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>�軻��</b></td>
		<td class="Value">{$form.form_cutoff_month.html}�� {$form.form_cutoff_day.html}��</td>
		<td class="Title_Purple"><b>ABCD�������</b></td>
		<td class="Value">{$form.form_abcd_day.html}<br> ��A�����������Ȥ���</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>������ֹ�����<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_claim_num.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>��ۤޤ���ʬ<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_coax.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>������ü����ʬ<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.from_fraction_div.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>�����Ҹ�<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_ware.html}</td>
	</tr>

</table>
<table width="810">
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
		<td align="right">
			{$form.button.entry_button.html}
		</td>
	</tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

					<br>
					</td>
				</tr>

			</table>
		</td>
		{*--------------- ����ƥ���� e n d ---------------*}

	</tr>
</table>
{*--------------- ���� e n d ---------------*}

{$var.html_footer}
	

