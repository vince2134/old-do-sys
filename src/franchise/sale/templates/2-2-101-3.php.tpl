
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
<!-------------------- ���ȳ��� ---------------------->
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
<!---------------------- ����ɽ��1���� --------------------->
<form {$form.attributes}>
{$form.hidden}
{* �����ե����� *}

<table  class="Data_Table" border="1" width="450">
    <tr>
        <td class="Title_Pink" width="100"><b>���Ϸ���</b></td>
        <td class="Value">{$form.form_output.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>����</b></td>
        <td class="Value" align="left">{$form.form_part_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink" width="100"><b>���ô����</b></td>
        <td class="Value" align="left">{$form.form_staff_1.html}</td>
    </tr>
</table>
<table width="450">
    <tr>
        <td align="right">{$form.form_button.indicate_button.html}����{$form.form_button.clear_button.html}</td>
    </tr>
</table>

<!--ɽ���ܥ��󤬲����줿���or������ܥ��󲡲����ˡ���������ɽ��-->
{if $smarty.post.form_button.indicate_button == "ɽ����" || $smarty.post.back_button_flg == true || $smarty.post.next_button_flg == true}
	<br>
	<font size="+0.5" color="#555555"><b>�ڥ�������ɽ�����֡�{$var.cal_range}��</b></font>
	<!---------------------- ����ɽ��1��λ ---------------------->
	<br>
	<hr>
	<!---------------------- ����ɽ��2���� ---------------------->

	<!-- �̾���ɼ -->
	{foreach from=$disp_data key=i item=item}
		<!---------------------- ô���ԥ����������� ---------------------->
		{foreach from=$calendar[$i] key=j item=item}

			<!-- ��Υǡ���¸��Ƚ�� -->	
			{if $cal_msg[$i][$j] != NULL}
				<!-- ��Υǡ�����̵�����ϡ��ٹ�ɽ�� -->	

				<font class="color">{$year[$j]}ǯ {$month[$j]}��</font><br>
				<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$cal_msg[$i][$j]}</span></font><br><br>
			{else}
				<!-- ��Υǡ���ɽ�� -->	

				<A NAME="{$i}">
				{* ��̥إå� *}
				<!-- ô���Ի���Ƚ�� -->	
				{if $smarty.post.form_staff_1 == NULL}
					<!-- ������ܥ���ɽ�� -->
					<font class="color">{$form.back_button.$i.html}��{$year[$j]}ǯ {$month[$j]}�{$form.next_button.$i.html}</font>������
				{else}
					<!-- ô���Ԥ����ꤵ�줿���ϡ�������ܥ�����ɽ�� -->
					<font class="color">{$year[$j]}ǯ {$month[$j]}��
				{/if}
				<font size="+0.5" color="#555555"><b>����ɼ���̡���<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font><br><br>
				
				<table border="0" width="100%">
				    <tr>
					<td align="left">

				        <table class="Data_Table" border="1" width="450">
				            <tr>
				                <td class="Title_Pink" width="100"><b>����</b></td>
				                <td class="Value" align="left" width="125">{$disp_data[$i][$j][0][0]}</td>
				                <td class="Title_Pink" width="100"><b>���ô����</b></td>
				                <td class="Value" align="left" width="125">{$disp_data[$i][$j][0][1]}</td>
				            </tr>
				            <tr>
				                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
				                <td class="Value" align="right" width="125">{$disp_data[$i][$j][0][2]}��</td>
				                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
				                <td class="Value" align="right" width="125">{$disp_data[$i][$j][0][3]}</td>
				            </tr>
				        </table>
				    </td>
					<td align="left">
						<table width="600">
						<tr>
							<td>{$form.form_slip_button.html}</td>
							<td width="200">{$form.form_course.html}</td>
						</tr>
						</table>
					</td>
					</tr>
				</table>
				
				{* ��̥������� *}
				<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

				<tr height="20" valign="middle">
				    <td align="center" bgcolor="#cccccc" width="30"><b>���<br>���</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calsaturday" ><b>��</b></td>
				    <td align="center" class="calsunday" ><b>��</b></td>
				</tr>

				{$calendar[$i][$j]}

				</table>
				</A>
				<!---------------------- ô���ԥ���������λ ---------------------->

				<br>
			{/if}
		{/foreach}
		<hr>
		<br>
	{/foreach}

	<!-- �����ɼ -->
	{foreach from=$act_disp_data key=i item=item}
		<!---------------------- ô���ԥ����������� ---------------------->
		{foreach from=$act_calendar[$i] key=j item=item}

			<!-- ��Υǡ���¸��Ƚ�� -->	
			{if $act_cal_msg[$i][$j] != NULL}
				<!-- ��Υǡ�����̵�����ϡ��ٹ�ɽ�� -->	

				<font class="color">{$year[$j]}ǯ {$month[$j]}��</font><br>
				<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$act_cal_msg[$i][$j]}</span></font><br><br>
			{else}
				<!-- ��Υǡ���ɽ�� -->	

				<A NAME="{$i}">
				{* ��̥إå� *}
				<!-- ô���Ի���Ƚ�� -->	
				<!-- ������ܥ���ɽ�� -->
				<font class="color">{$form.back_button.$i.html}��{$year[$j]}ǯ {$month[$j]}�{$form.next_button.$i.html}</font>������
				<font size="+0.5" color="#555555"><b>����ɼ���̡���<font color="blue">�ġ�ͽ����ɼ</font>��<font color="Fuchsia">��ͽ����ɼ(2��)</font>��<font color="FF6600">����ͽ����ɼ(3�Ͱʾ�)</font>��<font color="green">�С������ɼ</font>��<font color="gray">����������ɼ</font>��</b></font><br><br>
				
				<table border="0" width="100%">
				    <tr>
					<td align="left">

				        <table class="Data_Table" border="1" width="450">
				            <tr>
				                <td class="Title_Pink" width="100"><b>������</b></td>
				                <td class="Value" align="left" width="125" colspan="3">{$act_disp_data[$i][$j][0][0]}</td>
				            </tr>
				            <tr>
				                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
				                <td class="Value" align="right" width="125">{$act_disp_data[$i][$j][0][1]}��</td>
				                <td class="Title_Pink" width="100"><b>ͽ����</b></td>
				                <td class="Value" align="right" width="125">{$act_disp_data[$i][$j][0][2]}</td>
				            </tr>
				        </table>
				    </td>
					<td align="left">
						<table width="600">
						<tr>
							<td>{$form.form_slip_button.html}</td>
							<td width="200">{$form.form_course.html}</td>
						</tr>
						</table>
					</td>
					</tr>
				</table>
				
				{* ��̥������� *}
				<table class="Data_Table"  height="" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding: 5px;">

				<tr height="20" valign="middle">
				    <td align="center" bgcolor="#cccccc" width="30"><b>���<br>���</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calweek" ><b>��</b></td>
				    <td align="center" class="calsaturday" ><b>��</b></td>
				    <td align="center" class="calsunday" ><b>��</b></td>
				</tr>

				{$act_calendar[$i][$j]}

				</table>
				</A>
				<!---------------------- ô���ԥ���������λ ---------------------->

				<br>
			{/if}
		{/foreach}
		<hr>
		<br>
	{/foreach}

	<!-- �ǡ�����̵����硢������ܥ������ɽ�� -->
	{if $var.cal_data_flg == false}
		<font class="color">{$form.back_button.html}��{$year[0]}ǯ {$month[0]}�{$form.next_button.html}</font><br><br>
		<!-- ���顼ɽ�� -->
		<font size="+1"><span style="color: #ff0000; font-weight: bold; line-height: 130%;">{$var.data_msg}</span></font>
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
