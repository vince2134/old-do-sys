
{$var.html_header}

<!-- styleseet -->
<style type="text/css">
	/** ǯ�٥��顼 **/
	font.color {ldelim}
		color: #555555;
		font-size: 16px;
	    font-weight:bold;
	{rdelim}

	/** ���������ι���(����) **/
	td.calweek {ldelim}
		background-color:  #cccccc;
		width:135px;
	{rdelim}

	/** ���������ι���(��) **/
	td.calsaturday {ldelim}
		background-color:  #66CCFF;
		width:135px;
	{rdelim}

	/** ���������ι���(��) **/
	td.calsunday {ldelim}
		background-color:  #FFBBC3;
		width:135px;
	{rdelim}

	/** ������������ **/
	tr.cal_flame {ldelim}
		font-size: 130%;
		font-weight: bold;
	{rdelim}

</style>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
<!-------------------- ���ȳ��� --------------------->
<table border="0" width="100%" height="90%" class="M_Table">
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            <!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
        </td>
    </tr>

    <tr align="center">
        <td valign="top">

            <table>
                <tr>
                    <td>
</form>
<!---------------------- ����ɽ��1���� ------------------->
<form {$form.attributes}>
{$form.hidden}
{* �����ե����� *}

<table width="450"><tr><td>

{* ���顼ɽ�� *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{* ͽ������ *}
{if $form.form_sale_day.error != null}
    <li>{$form.form_sale_day.error}<br>
{/if}
</span>

<table  width="100%">
	<tr align="right" style="color: #555555;">
    	<td><b>���Ϸ���</b>{$form.form_output_type.html}</td>
	</tr>
</table>
<table  class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Pink" width="100" nowrap><b>����</b></td>
        <td class="Value" align="left">{$form.form_part_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>���ô����</b></td>
        <td class="Value" align="left">{$form.form_staff_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>ͽ�����<font color="#ff0000">��</font></b></td>
        <td class="Value" align="left">{$form.form_sale_day.html}</td>
    </tr>
	{* FC�ξ���ɽ���ʤ� *}
	{if $smarty.session.group_kind != '3'}
		<tr>
        	<td class="Title_Pink" width="100"><b>�����</b></td>
        	<td class="Value" align="left">{$form.form_fc.html}</td>
    	</tr>
	{/if}
</table>
<table width="100%">
    <tr>
        <td align="right">{$form.indicate_button.html}����{$form.clear_button.html}</td>
    </tr>
</table>

</td></tr></table>


<!--ɽ���ܥ��󤬲����줿���or������ܥ��󲡲�or���إܥ�����ˡ���������ɽ��-->
{if $smarty.post.indicate_button == "ɽ����" || $smarty.post.back_button_flg == true || $smarty.post.next_button_flg == true}
	<br>
	<font size="+0.5" color="#555555"><b>�ڥ�������ɽ�����֡�{$var.cal_range}��</b></font>
	<!---------------------- ����ɽ��1��λ ---------------------->
	<br>
	<hr>

{*
	����
    �����ա�������BɼNo.��������ô���ԡ��������ơ�
    ��2006/10/31��02-027��������suzuki��    �������ɼ���ʤ��Ȥ��ˤϡ�������ܥ��������ɽ��
*}

	<!-- �ǡ�����̵����硢������ܥ������ɽ�� -->
	{if $var.cal_range_err == true}
{*
        <!-- ������ܥ���ɽ�� -->
        <font class="color">{$form.back_button.html}��{$year}ǯ {$month}�{$form.next_button.html}</font>��
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">���ͽ���ϥ�������ɽ�����֤���ꤷ�Ʋ�������</span></font>
*}

	<!-- �ǡ�����̵����硢������ܥ������ɽ�� -->
	{elseif $var.cal_data_flg == false}
        <!-- ������ܥ���ɽ�� -->
        <font class="color">{$form.back_button.html}��{$year}ǯ {$month}�{$form.next_button.html}</font>��
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$var.data_msg}</span></font>

	{else}
		<!-- �ǡ������� -->

		<!---------------------- ����ɽ��2���� ---------------------->
		<!-- �̾���ɼ -->
		{foreach from=$disp_data key=i item=item}
			<!---------------------- ô���ԥ����������� ---------------------->

				<!-- ��Υǡ���¸��Ƚ�� -->	
				{if $cal_msg[$i] != NULL}
					<!-- ��Υǡ�����̵�����ϡ��ٹ�ɽ�� -->
					<font class="color">{$form.back_button.$i.html}��{$year}ǯ {$month}�{$form.next_button.$i.html}</font>��
					<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$cal_msg[$i]}</span></font><br><br>

				{else}
					<!-- ��Υǡ���ɽ�� -->	

					<A NAME="{$i}">
					<A NAME="m">
					{* ��̥إå� *}
					<!-- ������ܥ���ɽ�� -->
					<font class="color">{$form.back_button.$i.html}��{$year}ǯ {$month}�{$form.next_button.$i.html}</font>��

					<font size="+0.5" color="#555555"><b>����ɼ���̡�<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font><br><br>

					<table border="0" width="100%">
					    <tr>
						<td align="left">

					        <table class="Data_Table" border="1" width="450">
					            <tr>
					                <td class="Title_Pink" width="100"><b>����</b></td>
					                <td class="Value" align="left" width="125">{$disp_data[$i][0][0]}</td>
					                <td class="Title_Pink" width="100"><b>���ô����</b></td>
					                <td class="Value" align="left" width="125">{$disp_data[$i][0][1]}</td>
					            </tr>
					            <tr>
					                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
					                <td class="Value" align="right" width="125">{$disp_data[$i][0][2]}��</td>
					                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
					                <td class="Value" align="right" width="125">{$disp_data[$i][0][3]}</td>
					            </tr>
					        </table>
					    </td>
						<td align="left">
							<table width="600">
							<tr>
								<td>{$form.form_slip_button.html}</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					
					{* ��̥������� *}
					<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

					<tr height="20" valign="middle">
					    <td align="center" bgcolor="#cccccc" width="30"><b>���<br>���</b></td>
						<td align="center" class="calsunday" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calsaturday" ><b>��</b></td>
					</tr>

					{$calendar[$i]}

					</table>
					</A>
					</A>
					<!---------------------- ô���ԥ���������λ ---------------------->

                    <br>
                    <hr>
					<br>
				{/if}
			<br>
		{/foreach}

		<!-- �����ɼ -->
		{foreach from=$act_disp_data key=i item=item}
			<!---------------------- ô���ԥ����������� ---------------------->

				<!-- ��Υǡ���¸��Ƚ�� -->	
				{if $act_cal_msg[$i] != NULL}
					<!-- ��Υǡ�����̵�����ϡ��ٹ�ɽ�� -->	
					<font class="color">{$form.back_button.$i.html}��{$year}ǯ {$month}�{$form.next_button.$i.html}</font>��
					<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$act_cal_msg[$i]}</span></font><br><br>
				{else}
					<!-- ��Υǡ���ɽ�� -->	

					<A NAME="{$i}">
					<A NAME="m">
					{* ��̥إå� *}
					<!-- ������ܥ���ɽ�� -->
					<font class="color">{$form.back_button.$i.html}��{$year}ǯ {$month}�{$form.next_button.$i.html}</font>��

					<font size="+0.5" color="#555555"><b>����ɼ���̡�<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font><br><br>

					<table border="0" width="100%">
					    <tr>
						<td align="left">

					        <table class="Data_Table" border="1" width="450">
					            <tr>
					                <td class="Title_Pink" width="110"><b>������</b></td>
					                <td class="Value" align="left" width="400" colspan="3">{$act_disp_data[$i][0][0]}</td>
					            </tr>
					            <tr>
					                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
					                <td class="Value" align="right" width="125">{$act_disp_data[$i][0][1]}��</td>
					                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
					                <td class="Value" align="right" width="125">{$act_disp_data[$i][0][2]}</td>
					            </tr>
					        </table>
					    </td>
						<td align="left">
							<table width="600">
							<tr>
								<td>{$form.form_slip_button.html}</td>
							</tr>
							</table>
						</td>
						</tr>
					</table>
					
					{* ��̥������� *}
					<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

					<tr height="20" valign="middle">
					    <td align="center" bgcolor="#cccccc" width="30"><b>���<br>���</b></td>
						<td align="center" class="calsunday" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calweek" ><b>��</b></td>
					    <td align="center" class="calsaturday" ><b>��</b></td>
					</tr>

					{$act_calendar[$i]}

					</table>
					</A>
					</A>
					<!---------------------- ô���ԥ���������λ ---------------------->

                    <br>
                    <hr>
					<br>
				{/if}
			<br>
		{/foreach}
	{/if}
{/if}
<!--******************** ����2ɽ����λ *******************-->
                    </td>
                </tr>
            </table>
        </td>
        <!--******************** ����ɽ����λ *******************-->

    </tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

{$var.html_footer}
