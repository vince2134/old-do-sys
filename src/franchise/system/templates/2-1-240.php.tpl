
{$var.html_header}

<script language="javascript">
{$var.java_sheet}
 </script>

<body class="bgimg_purple" {$var.form_load}>
<form name="dateForm" method="post">
<!--------------------- ���ȳ��� --------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ����ɽ������ ------------------->
		<td valign="top">

<table border="0">
		<tr>
			<td>

{$form.hidden}
<!---------------------- ����ɽ��1���� ------------------->

<!-- ���顼ɽ�� -->
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=item}
    <li>{$item}<br>
{/foreach}
{* ͽ��ǡ�����ʣ�������顼ɽ�� *}
{$var.duplicat_mesg}
</span>

<!--�����ʬ�����ꤵ��Ƥ��ʤ����ϡ����顼ɽ��(��Ǥ��ν������) -->
{if $var.trade_error_flg == true && $var.client_id != NULL}
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;"><font size="+1">�����ʬ�����ꤵ��Ƥ��ޤ���</font>
    </span><br>
	<td align='right'>{$form.form_back_trade.html}</td>
{else}

<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="113"><b>������</b></td>
		<td class="Value" width="310">{$form.form_daiko_price.html}</td>
		<td class="Title_Purple" width="113"><b>�������</b></td>
		<td class="Value" width="310">{$form.state.html}</td>
	</tr>
</table>
<br>
<table class="Data_Table" border="1" width="950">
	<tr>
		<td class="Title_Purple" width="90"><b>�ܵ�̾</b></td>
		<td class="Value" width="310">{$form.form_client.html}</td>
		<td class="Title_Purple" width="110"><b>������</b></td>
		<td class="Value" width="230">{$form.form_contract_day.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="90"><b>�����谸����</b></td>
		<td class="Value" width="310" colspan="3">{$form.form_daiko_note.html}</td>
	</tr>
</table>

	<br>
	<br>
	<table border="0" width="985">
		<tr>
		<td align="left"><font size="+0.5" color="#555555"><b>�ڷ��������١�</b></font></td>
        <td align="left" width=832><b><font color="blue">
            <li>�Ķȸ�������ȴ��ۤ���Ͽ���Ƥ���������
        </td>
		</tr>
	</table>

	<table class="Data_Table" border="1" width="950">
		<tr>
			<td class="Title_Purple" rowspan="2" width="90"><b>�����ʬ</b></td>
			<td class="Title_Purple" rowspan="2" width="200"><b>�����ӥ�̾</b></td>
			{* <td class="Title_Purple" rowspan="2" width="130"><b>�����ƥ��������<br>����������ά�Ρ�</b></td> *}
			<td class="Title_Purple" rowspan="2" width="130"><b>�����ƥ�</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" colspan="2"><b>���</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>������</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" rowspan="2" width="130"><b>���ξ���</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>����</b></td>
			<td class="Title_Purple" rowspan="2" width="40"><b>��Ʊ��</b></td>
			<!--<td class="Title_Purple" rowspan="2" width="50"><b>����</b></td>-->
		</tr>

		<tr>
			<td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��</b></td>
			<td class="Title_Purple" ><b>������׳�<br>����׳�</b></td>
		</tr>
		
		{foreach key=i from=$loop_num item=items}
            {* 2009-09-22 hashimoto-y *}
            {if $toSmarty_discount_flg[$i] === 't'}
                 <tr class="Value" style="color: red">
            {else}
			    <tr>
            {/if}
			<A NAME="{$i}">
				<td class="Value" align="center">{$form.form_divide[$i].html}</td>
				<td class="Value">{$form.form_print_flg1[$i].html} {$form.form_serv[$i].html}</td>
				<td class="Value">
					{$form.form_print_flg2[$i].html} {$form.form_goods_cd1[$i].html}<br>
					�� {$form.official_goods_name[$i].html}<br>
					�� {$form.form_goods_name1[$i].html}
				</td>
				<td class="Value" align="right">{$form.form_issiki[$i].html}{if $var.br_flg == 'true'}<br>{/if}{$form.form_goods_num1[$i].html}</td>
				<td class="Value" align="right">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
				<td class="Value" align="right">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>
				<td class="Value">{$form.form_goods_cd3[$i].html}<br>{$form.form_goods_name3[$i].html}</td>
				<td class="Value" align="right">{$form.form_goods_num3[$i].html}</td>
				<td class="Value">{$form.form_goods_cd2[$i].html}<br>{$form.form_goods_name2[$i].html}</td>
				<td class="Value" align="right">{$form.form_goods_num2[$i].html}</td>
				<td class="Value" align="center">{$form.mst_sync_flg[$i].html}</td>
				{* <td class="Value" align="center">{$form.form_breakdown[$i].html}</td> *}
			</A>
			</tr>
		{/foreach}

	</table>
	<table width="950">
		<tr>
			<td align='right'>{$form.clear_button.html}</td>
		</tr>
	</table>
	
	<p>
	<table>
	<tr>
	<td>
	<br><br>
		<table class="Data_Table" border="1" width="450" height="240" >
			<tr>
				<td class="Title_Purple" width="110"><b>��No.<font color="#ff0000">��</font></b></td>
				<td class="Value" width="185">{$form.form_line.html}</td>
			</tr>
			<tr>
				<td class="Title_Purple" width="90">
					<b>���ô��<br>������</b>
				</td>
				<td class="Value" >
					�ᥤ��1<b><font color="#ff0000">��</font></b> {$form.form_c_staff_id1.html}�����{$form.form_sale_rate1.html}��<br>
					����2�� <b>��</b>{$form.form_c_staff_id2.html}�����{$form.form_sale_rate2.html}��<br>
					����3�� <b>��</b>{$form.form_c_staff_id3.html}�����{$form.form_sale_rate3.html}��<br>
					����4�� <b>��</b>{$form.form_c_staff_id4.html}�����{$form.form_sale_rate4.html}��<br>
				</td>
			</tr>

			<tr>
				<td class="Title_Purple"><b>��ϩ<font color="#ff0000">��</font></b></td>
				<td class="Value" >{$form.form_route_load.html}</td>
			</tr>

			<tr>
				<td class="Title_Purple" width="90"><b>����</b></td>
				<td class="Value" width="200">{$form.form_note.html}</td>
			</tr>
		</table>
	</td>

	<td valign="top">
	<b><font color="blue">
	<li>�ֽ���ȯ�����װʹߤ�ͽ��ǡ����Ϻƺ�������ޤ���<br>
	<li>�ַ���λ���װʹߤ�ͽ��ǡ����Ϻ�������ޤ���
	</font></b>
		<table class="Data_Table" border="1" width="450" height="240" >
			<tr>
				<td class="Title_Purple" width="90" nowrap rowspan="4"><b>�����</b></td>
					<td class="Value">{$form.form_stand_day.label}��{$form.form_stand_day.html}</td>
				</tr>
				
				<tr>
					<td class="Value">{$form.form_update_day.label}��{$form.form_update_day.html}</td>
				</tr>
				
				<tr>
					<td class="Value">{$form.form_contract_eday.label}��{$form.form_contract_eday.html}</td>
				</tr>
				
				<tr>
				<td class="Value" width="460" colspan="3">
					<table border="0">

						<tr>
							<td><b><font color="#ff0000">��</font></b><br>
							<font color="#555555">
								��{$form.form_round_div1[0].html}
								{$form.form_abcd_week1.html}����{$form.form_week_rday1.html}����<br>

								��{$form.form_round_div1[1].html}
								��{$form.form_rday2.html}��<br>

								��{$form.form_round_div1[2].html}
								����{$form.form_cale_week3.html}
								��{$form.form_week_rday3.html}����<br>

								��{$form.form_round_div1[3].html}
								{$form.form_cale_week4.html}���ּ�����{$form.form_week_rday4.html}����<br>

								��{$form.form_round_div1[4].html}
								{$form.form_cale_month5.html}���������{$form.form_week_rday5.html}��<br>

								��{$form.form_round_div1[5].html}
								{$form.form_cale_month6.html}�����������{$form.form_cale_week6.html}��{$form.form_week_rday6.html}����<br>

								��{$form.form_round_div1[6].html}
								{$form.form_irr_day.html}(�ǽ���:{$var.last_day})
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>

	</tr>
	</table>

	<!--******************** ����ɽ��1��λ *******************-->



	<!---------------------- ����ɽ��2���� ------------------->
	<table width="950">
		<tr>
			<td align='left'><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
		</tr>

		<tr>
			<td align='right'>{$form.entry_button.html}����{$form.form_back.html}</td>
		</tr>
	</table>
<!--******************** ����ɽ��2��λ *******************-->

<!-- ��Ǻ��-->
{/if}
<!-- -->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->
{$var.html_footer}
