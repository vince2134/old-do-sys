{$var.html_header}

<script language="javascript">
{$var.java_sheet}

{literal}
function h_column_disabled(f_obj) {

    if(f_obj.value == "3" ){
			//�Ķȸ���
			document.dateForm.elements["form_trade_price[1][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[1][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[2][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[3][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[4][2]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][1]"].readOnly = true;
			document.dateForm.elements["form_trade_price[5][2]"].readOnly = true;
		}
		

}
{/literal}


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

<!-- ����Ƚ�� -->
{if $var.injust_msg == true}
		{*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
	    	<tr align="center" valign="top" height="160">
	        <td>
	            <table>
	                <tr>
	                    <td>
	<span style="font: bold;"><font size="+1">�ʲ������ˤ�ꡢ�����˼��Ԥ��ޤ�����<br><br>��¾�Υ桼������˽�����Ԥä�<br>���֥饦�������ܥ��󤬲����줿<br><br></font></span>
	
	<table width="100%">
	    <tr>
	        <td align="right">
			{$form.disp_btn.html}</td>
	    </tr>
	</table>

{else}

	    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
	    <tr align="center" valign="top">
	        <td>
	            <table>
	                <tr>
	                    <td>
{*
	<!-- ���顼ɽ�� -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	{foreach from=$form.errors item=item}
		<li>{$item}<br>
	{/foreach}
	</span>
*}
	{*+++++++++++++++ ��å������� begin +++++++++++++++*}
	<!-- ���顼ɽ�� -->
	<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
	<!-- ��󥿥��ֹ� -->
	{if $var.error_msg != null}
	    <li>{$var.error_msg}<br>
	{/if}
	<!-- �桼�� -->
	{if $var.error_msg2 != null}
	    <li>{$var.error_msg2}<br>
	{/if}
	<!-- ������������å� -->
	{if $var.goods_error != null}
	    <li>{$var.goods_error}<br>
	{/if}
	<!-- ��󥿥뿽���� -->
	{if $form.form_rental_day.error != null}
	    <li>{$form.form_rental_day.error}<br>
	{/if}
	<!-- ��󥿥�в��� -->
	{if $form.form_forward_day.error != null}
	    <li>{$form.form_forward_day.error}<br>
	{/if}
	<!-- ����ô���� -->
	{if $form.form_app_staff.error != null}
	    <li>{$form.form_app_staff.error}<br>
	{/if}
	<!-- ���ô���� -->
	{if $form.form_round_staff.error != null}
	    <li>{$form.form_round_staff.error}<br>
	{/if}
	<!-- ����� -->
	{if $form.form_claim_day.error != null}
	    <li>{$form.form_claim_day.error}<br>
	{/if}
	<!-- ͹���ֹ� -->
	{if $form.form_post.error != null}
	    <li>{$form.form_post.error}<br>
	{/if}
	<!-- ����1 -->
	{if $form.form_add1.error != null}
	    <li>{$form.form_add1.error}<br>
	{/if}
	<!-- TEL -->
	{if $form.form_tel.error != null}
	    <li>{$form.form_tel.error}<br>
	{/if}
	<!-- ���� -->
	{if $form.form_note.error != null}
	    <li>{$form.form_note.error}<br>
	{/if}

	{foreach key=i from=$error_loop_num item=items}
		<!-- ���ʥ����å� -->
		{if $form.form_goods_cd[$i].error != null}
		    <li>{$form.form_goods_cd[$i].error}<br>
		{/if}
		<!-- ���� -->
		{if $form.form_num[$i].error != null}
		    <li>{$form.form_num[$i].error}<br>
		{/if}
		<!-- ���ꥢ�� -->
		{foreach key=j from=$error_loop_num2[$i] item=items}
			{if $form.form_serial[$i][$j].error != null}
			    <li>{$form.form_serial[$i][$j].error}<br>
			{/if}
		{/foreach}
		<!-- ���ꥢ�������� -->
		{if $form.form_goods_cname[$i].error != null}
		    <li>{$form.form_goods_cname[$i].error}<br>
		{/if}
		<!-- ��󥿥�ñ�� -->
		{if $form.form_rental_price[$i].error != null}
		    <li>{$form.form_rental_price[$i].error}<br>
		{/if}
		<!-- �桼��ñ�� -->
		{if $form.form_user_price[$i].error != null}
		    <li>{$form.form_user_price[$i].error}<br>
		{/if}
		<!-- ����� -->
		{if $form.form_renew_num[$i].error != null}
		    <li>{$form.form_renew_num[$i].error}<br>
		{/if}
		<!-- �»��� -->
		{if $form.form_exec_day[$i].error != null}
		    <li>{$form.form_exec_day[$i].error}<br>
		{/if}
		<!-- ��������å� -->
		{if $form.form_calcel1[$i].error != null}
		    <li>{$form.form_calcel1[$i].error}<br>
		{/if}
	{/foreach}

	</span>
	{*--------------- ��å������� e n d ---------------*}

	{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
	<!-- ��ǧ����Ƚ�� -->
	{if $var.comp_flg != null}
		<!-- ����ɽ��Ƚ�� -->
		{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
			<!-- ��󥿥�ID̵������úѡ����������� -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ���Ͽ���ޤ�����</font></span><br>
		{elseif ($var.disp_stat == 2 && $var.stat_flg == false) || $var.online_flg == "f" }
			<!-- ����ѡ������(����ѤΤ�) -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ��ѹ����ޤ�����</font></span><br>
		{else}
			<!-- ����ѡ�����ѡ�������������ͽ�� -->
			<span style="font: bold;"><font size="+1">�ʲ������Ƥ��ѹ��������ޤ�����</font></span><br>
		{/if}
	{/if}
	{$form.hidden}
	<table width="100%">
	    <tr>
	        <td>

	<table class="Data_Table" border="1" width="600">
	<col width="120" style="font-weight: bold;">
	<tr>
	    <td class="Title_Purple" width="130">{$form.online_flg.label}</td>
	    <td class="Value" >{$form.online_flg.html}</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">��󥿥��ֹ�</td>
	    <td class="Value" >{$form.form_rental_no.html}</td>
	</tr>
	<tr>
	    <td class="Title_Purple" width="130">����å�̾</td>
	    <td class="Value" >{$var.shop_name}</td>
	</tr>
	</table>
	<br>
	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	<col width="120" style="font-weight: bold;">
	    <tr>
	        <td class="Title_Purple" width="130">��󥿥뿽����<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3">{$form.form_rental_day.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">����ô����<font color="#ff0000">��</font></td>
	        <td class="Value">{$form.form_app_staff.html}</td>
			<td class="Title_Purple" width="130">���ô����<font color="#ff0000">��</font></td>
	        <td class="Value">{$form.form_round_staff.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">
			<!-- �桼�����ɽ��Ƚ�� -->
			{if $var.comp_flg == true}
				<!-- ��ǧ���� -->
			    �桼��̾
			{else}
				<!-- ��Ͽ���� -->
			    {$form.form_client_link.html}
			{/if}
			<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3">{$form.form_client.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">͹���ֹ�<font color="#ff0000">��</font></td>
	        <td class="Value" colspan="3">{$form.form_post.html}
			<!-- ��ư���ϥܥ���ɽ��Ƚ�� -->
			{if $var.comp_flg != true}
				<!-- ��ǧ���̤���ɽ�� -->
			    ����{$form.input_auto.html}
			{/if}
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����1<font color="#ff0000">��</font></td>
	        <td class="Value">{$form.form_add1.html}</td>
	        <td class="Title_Purple" width="130">����2</td>
	        <td class="Value">{$form.form_add2.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����3<br>(�ӥ�̾��¾)</td>
	        <td class="Value" colspan=>{$form.form_add3.html}</td>
	        <td class="Title_Purple" width="130">����2<br>(�եꥬ��)</td>
	        <td class="Value">{$form.form_add_read.html}</td>
	    </tr>
		<tr>
	        <td class="Title_Purple" width="130">�桼��TEL</td>
	        <td class="Value" colspan="3">{$form.form_tel.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����</td>
	        <td class="Value" colspan="3">{$form.form_note.html}</td>
	    </tr>
	</table>
	<br>

	<table class="Data_Table" border="1" width="900">
	<col width="120" style="font-weight: bold;">
	<col>
	    <tr>
	        <td class="Title_Purple" width="130">��󥿥�в���</td>
	        <td class="Value">{$form.form_forward_day.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����ô����</td>
	        <td class="Value">{$form.form_head_staff.html}</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">�����</td>
	        <td class="Value">{$form.form_claim_day.html}
			<!-- ����ѡ�����ѡ�������������ͽ��Τ�ɽ�� -->
			{if $var.disp_stat == 2 || $var.disp_stat == 3 || $var.disp_stat == 4}
				 ����
			{/if}
			</td>
	    </tr>
	    <tr>
	        <td class="Title_Purple" width="130">����(������)</td>
	        <td class="Value">{$form.form_h_note.html}</td>
	    </tr>
	</table>
	<br>

	<!-- ����ɽ��Ƚ�� -->
	{if $var.disp_stat == 2 || $var.disp_stat == 3 || $var.disp_stat == 4}
	<table border="0" width="900">
	<tr>
		<td align="right" width=900><b><font color="blue"><li>����饤��β����������ǧ��˼»ܤ���ޤ���</font></b></td>
	</tr>
	</table>

	{/if}

	<!-- �桼������Ƚ�� -->
	{if $var.warning != null}
		<!-- ����ʤ� -->
		<font color="#ff0000"><b>{$var.warning}</b></font>
	{else}
		<!-- �ǡ���ɽ�� -->
		<table class="Data_Table" border="1" width="100%">
				<!-- ����ɽ��Ƚ�� -->
				{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
					<!-- ��󥿥�ID̵������úѡ����������� -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">No.</td>
						<td class="Title_Purple">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
						<td class="Title_Purple">����<font color="#ff0000">��</font></td>
						<td class="Title_Purple">���ꥢ��
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple">��󥿥�ñ��<font color="#ff0000">��</font><br>�桼����ñ��<font color="#ff0000">��</font></td>
						<td class="Title_Purple">��󥿥���<br>�桼���󶡶��</td>
						<!-- ����������or��ǧ���̤Ϻ��̵�� -->
						{if $var.disp_stat != 6 && $var.comp_flg != true}
							<td class="Title_Add">���</td>
						{/if}
					</tr>
				{else}
					<!-- ����ѡ�����ѡ�������������ͽ�� -->
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple" rowspan="2">No.</td>
						<td class="Title_Purple" rowspan="2">����</td>
						<td class="Title_Purple" rowspan="2">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
						<td class="Title_Purple" rowspan="2">����<font color="#ff0000">��</font></td>
						<td class="Title_Purple" rowspan="2">���ꥢ��
						{if $var.comp_flg != true}
							<br>{$form.input_form_btn.html}
						{/if}
						</td>
						<td class="Title_Purple" rowspan="2">��󥿥�ñ��<font color="#ff0000">��</font><br>�桼����ñ��<font color="#ff0000">��</font></td>
						<td class="Title_Purple" rowspan="2">��󥿥���<br>�桼���󶡶��</td>
						<td class="Title_Purple" rowspan="2">������</td>
						<td class="Title_Purple" colspan="3">����</td>
					{if $var.online_flg == f && $var.comp_flg != true}
						<td class="Title_Purple" rowspan="2">���</td>
					{/if}
					</tr>
					<tr align="center" style="font-weight: bold;">
						<td class="Title_Purple">�����</td>
						<td class="Title_Purple">������ͳ</td>
						<td class="Title_Purple">�»���</td>
					</tr>

				{/if}
			
			{$var.html}
		</table>


		<A NAME="foot"></A>
		<table width="100%">
		{if $var.comp_flg == true}
		<!-- ��ǧ���� -->
				<tr>
					<td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
					<td align="right">{$form.ok_btn.html}����{$form.back_btn.html}</td>
				</tr>
		{else}
		<!-- ��Ͽ���� -->
				<tr>
					<td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
					<td align="right">{$form.comp_btn.html}����{$form.return_btn.html}</td>
				</tr>
				<tr>
					<td align="left">{$form.add_row_btn.html}</td>
				</tr>
		{/if}
		</table>
	{/if}
	        </td>
	    </tr>
	</table>
{/if}
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
