
{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
 </script>
<body bgcolor="#D8D0C8" onLoad="Check_Button2({$var.check_which}); WindowSizeChange();">
<form name="referer" method="post">

<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="left">
		<td width="14%" valign="top" lowspan="2">
			<!-- ��˥塼���� --> {$var.page_menu} <!-- ��˥塼��λ -->
		</td>

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border="0" width="100%">
				<tr>
					<td>

</form>
<!---------------------- ����ɽ��1���� ---------------------><!-->
<form {$form.attributes}>
{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">

    {if $var.client_cd_err != null}
    <li>{$var.client_cd_err}<br>
    {/if}
    {if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
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
    {if $form.form_area_id.error != null}
        <li>{$form.form_area_id.error}<br>
    {/if}
    {if $form.form_tel.error != null}
        <li>{$form.form_tel.error != null}<br>
    {/if}
    {if $form.form_fax.error != null}
        <li>{$form.form_fax.error}<br>
    {/if}
    {if $form.form_rep_name.error != null}
        <li>{$form.form_rep_name.error}<br>
    {/if}
    {if $form.form_trade_stime1.error != null || 
        $form.form_trade_etime1.error != null || 
        $form.form_trade_stime2.error != null || 
        $form.form_trade_etime2.error != null}
        <li>�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���<br>
    {/if}
    {if $var.claim_err != null}
        <li>{$var.claim_err}<br>
    {/if}
    {if $var.intro_act_err != null}
        <li>{$var.intro_act_err}<br>
    {/if}
    {if $form.form_account.error != null}
        <li>{$form.form_account.error}<br>
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
    {if $form.form_cont_s_day.error != null}
        <li>{$form.form_cont_s_day.error}<br>
    {elseif $var.sday_err != null}
        <li>{$var.sday_err}<br>
    {/if}
    {if $form.form_cont_peri.error != null}
        <li>{$form.form_cont_peri.error}<br>
    {/if}
    {if $form.form_cont_r_day.error != null}
        <li>{$form.form_cont_r_day.error}<br>
    {elseif $var.rday_err != null}
        <li>{$var.rday_err}<br>
    {elseif $var.sday_rday_err != null}
        <li>{$var.sday_rday_err}<br>
    {/if}
    {if $form.form_deliver_note.error != null}
        <li>{$form.form_deliver_note.error}<br>
    {/if}
    </span><br>
{$form.hidden}
<table class="Data_Table" border="1" width="750">
<col width="130">
<col width="235">
<col width="130">

	<tr>
		<td class="Title_Purple"><b>�����襳����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_client.html}</td>
		<td class="Title_Purple"><b>�����</b></td>
		<td class="Value">{$form.form_state.html}</td>
	</tr>


	<tr>
		<td class="Title_Purple"><b>������̾<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_client_name.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>������̾(�եꥬ��)</b></td>
		<td class="Value" colspan="3">{$form.form_client_read.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>ά��<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_client_cname.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>͹���ֹ�<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_post.html}����{$form.button.input_button.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>����1<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_address1.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����2</b></td>
		<td class="Value" colspan="3">{$form.form_address2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����(�եꥬ��)</b></td>
		<td class="Value" colspan="3">{$form.form_address_read.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>�϶�<font color="#ff0000">��</font></b></td>
		<td class="Value" colspan="3">{$form.form_area_id.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>TEL<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_tel.html}</td>
		<td class="Title_Purple"><b>FAX<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_fax.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>��ɽ�Ի�̾<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_rep_name.html}</td>
		<td class="Title_Purple"><b>��ô����1</b></td>
		<td class="Value">{$form.form_charger1.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>��ô����2</b></td>
		<td class="Value">{$form.form_charger2.html}</td>
		<td class="Title_Purple"><b>��ô����3</b></td>
		<td class="Value">{$form.form_charger3.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>��ô����4</b></td>
		<td class="Value">{$form.form_charger4.html}</td>
		<td class="Title_Purple"><b>��ô����5</b></td>
		<td class="Value">{$form.form_charger5.html}</td>
	</tr>
	
	<tr>
		<td class="Title_Purple"><b>�ĶȻ���</b></td>
		<td class="Value" colspan="3">{$form.form_trade_stime1.html} �� {$form.form_trade_etime1.html} <br>{$form.form_trade_stime2.html} �� {$form.form_trade_etime2.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>����</b></td>
		<td class="Value" colspan="3">{$form.form_holiday.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>�ȼ�</b></td>
		<td class="Value">{$form.form_btype.html}</td>
		<td class="Title_Purple"><b>����</b></td>
		<td class="Value">{$form.form_b_struct.html}</td>
	</tr>
</table>
<br>

<table class="Data_Table" border="1" width="750">
	<tr>
		<td class="Title_Purple" width="130">
			<b><a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_claim[cd1]','form_claim[cd2]','form_claim[name]'), 500, 450);">������</a></b>
		</td>
		<td class="Value">{$form.form_claim.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130">
			<b><a href="#" onClick="return Open_SubWin('../dialog/1-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450);">�Ҳ������</a></b>
		</td>
		<td class="Value">{$form.form_intro_act.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>������<br>(����̾������)</b></td>
		<td class="Value">{$form.form_account.html}</td>
	</tr>
</table>
<br>

<table class="Data_Table" border="1" width="750">
	<tr>
		<td class="Title_Purple"  width="130"><b>ô����Ź<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_cshop.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"  width="130"><b>����ô����</b></td>
		<td class="Value">{$form.form_c_staff_id1.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>����ô����</b></td>
		<td class="Value">{$form.form_c_staff_id2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>���ô����</b></td>
		<td class="Value">{$form.form_d_staff_id1.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple"><b>���ô����</b></td>
		<td class="Value">{$form.form_d_staff_id2.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple"><b>���ô����</b></td>
		<td class="Value">{$form.form_d_staff_id3.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="750">
	
	<tr>
		<td class="Title_Purple" width="130"><b>������</b></td>
		<td class="Value" colspan="3">{$form.form_col_terms.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>Ϳ������</b></td>
		<td class="Value">{$form.form_cledit_limit.html}����</td>
		<td class="Title_Purple" width="130"><b>���ܶ�</b></td>
		<td class="Value">{$form.form_capital.html}����</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>�����ʬ</b></td>
		<td class="Value">{$form.form_work.html}</td>
		<td class="Title_Purple" width="130"><b>����<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_close.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>��ʧ��<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_pay_m.html}������{$form.form_pay_d.html}��</td>
		<td class="Title_Purple" width="130"><b>��ʧ��ˡ</b></td>
		<td class="Value">{$form.form_pay_way.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>�������</b></td>
		<td class="Value" colspan="3">{$form.form_bank.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>����̾��</b></td>
		<td class="Value">{$form.form_pay_name.html}</td>
		<td class="Title_Purple" width="130"><b>����̾��</b></td>
		<td class="Value">{$form.form_account_name.html}</td>
	</tr>


</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>����ǯ����</b></td>
		<td class="Value">{$form.form_cont_s_day.html}</td>
		<td class="Title_Purple" width="130"><b>����λ��</b></td>
		<td class="Value">{$form.form_cont_e_day.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>�������</b></td>
		<td class="Value">{$form.form_cont_peri.html}ǯ</td>
		<td class="Title_Purple" width="130"><b>������</b></td>
		<td class="Value">{$form.form_cont_r_day.html}</td>
	</tr>
	
</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>��ɼȯ��<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_slip_out.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>Ǽ�ʽ񥳥���</b></td>
		<td class="Value">{$form.form_deliver_note.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="130"><b>�����ȯ��<font color="#ff0000">��</font></b></td>
		<td class="Value">{$form.form_claim_out.html}</td>
	</tr>

</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>���<font color="#ff0000">��</font></b></td>
		<td class="Title_Purple" width="130"><b>�ޤ���ʬ</b></td>
		<td class="Value">{$form.form_coax.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" rowspan="3" width="130"><b>������<font color="#ff0000">��</font></b></td>
		<td class="Title_Purple" width="130"><b>���Ƕ�ʬ</b></td>
		<td class="Value">{$form.form_tax_io.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>����ñ��</b></td>
		<td class="Value">{$form.form_tax_div.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="130"><b>ü����ʬ</b></td>
		<td class="Value">{$form.form_tax_franct.html}</td>
	</tr>

</table>
<br>
<table class="Data_Table" border="1" width="750">

	<tr>
		<td class="Title_Purple" width="130"><b>����������������¾</b></td>
		<td class="Value">{$form.form_note.html}</td>
	</tr>

</table>
<table width="750">
	<tr>
		<td align="left">
			<b><font color="#ff0000">����ɬ�����ϤǤ�</font></b>
		</td>
		<td align="right">
			{$form.button.entry_button.html}����{$form.button.res_button.html}����{$form.button.back_button.html}
		</td>
	</tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->

					<br>
					</td>
                    <td valign="bottom">
                        <fieldset>
                        <legend><font size="+0.5" color="#555555"><b>����Ͽ�Ѥߡ�</b></font></legend>
                        <iframe src="../dialog/1-0-250-1.php" name="goods" width="700" height="1230" SCROLLING="auto">
                        ������ʬ�ϥ���饤��ե졼�����Ѥ��Ƥ��ޤ���
                        </iframe>
                        </fieldset>
                    </td>
				</tr>

			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

{$var.html_footer}
	
