
{$var.html_header}

<script language="javascript">
{$var.java_sheet}
 </script>

<body bgcolor="#D8D0C8" {$var.form_load}>
<form name="dateForm" method="post">
{$form.hidden}
<!--------------------- ���ȳ��� ------------------------>
<table border="0" width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
		<td valign="top">
		
			<table>
{*
				<tr>
					<td>

<!--------------------- ����ɽ��1���� --------------------->


<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>
*}

				<tr>
					<td>

<!---------------------- ����ɽ��2���� ---------------------->
{* ���顼ɽ�� *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<!-- ��������å� -->
{if $var.err_mess_confirm_flg != null}
    <li>{$var.err_mess_confirm_flg}<br>
{/if}
<!-- ��������å� -->
{if $var.del_mess != null}
    <li>{$var.del_mess}<br>
{/if}

{if $var.concurrent_err_flg != true}
    {* ͽ������ *}
    {if $form.form_delivery_day.error != null}
        <li>{$form.form_delivery_day.error}<br>
    {/if}

    <!-- ������ -->
    {if $form.form_request_day.error != null}
        <li>{$form.form_request_day.error}<br>
    {/if}
    {if $var.error_msg16 != null}
        <li>{$var.error_msg16}<br>
    {/if}

    <!-- ���� -->
    {if $form.form_note.error != null}
        <li>{$form.form_note.error}<br>
    {/if}

    {* ����ñ����������� *}
    {if $form.intro_ac_price.error != null}
        <li>{$form.intro_ac_price.error}<br>
    {/if}

    {* ����Ψ��������� *}
    {if $form.intro_ac_rate.error != null}
        <li>{$form.intro_ac_rate.error}<br>
    {/if}

    {* ������ʸ���ۡ� *}
    {if $form.act_request_price.error != null}
        <li>{$form.act_request_price.error}<br>
    {/if}

    <!-- �����ʬ -->
    {if $form.trade_aord.error != null}
        <li>{$form.trade_aord.error}<br>
    {/if}
    <!-- ������ͳ -->
    {if $form.form_reason.error != null}
        <li>{$form.form_reason.error}<br>
    {/if}

    <!-- ô���ᥤ�� -->
    {if $form.form_c_staff_id1.error != null}
        <li>{$form.form_c_staff_id1.error}<br>
    {/if}
    <!-- ���Ψ��ô���ᥤ�󤬤�����˥��顼Ƚ�� -->
    {if $form.form_sale_rate1.error != null && $form.form_c_staff_id1.error == null}
        <li>{$form.form_sale_rate1.error}<br>
    {/if}

    <!-- ô�����֣� -->
    {if $form.form_c_staff_id2.error != null}
        <li>{$form.form_c_staff_id2.error}<br>
    {/if}
    {if $form.form_sale_rate2.error != null}
        <li>{$form.form_sale_rate2.error}<br>
    {/if}

    <!-- ô�����֣� -->
    {if $form.form_c_staff_id3.error != null}
        <li>{$form.form_c_staff_id3.error}<br>
    {/if}
    {if $form.form_sale_rate3.error != null}
        <li>{$form.form_sale_rate3.error}<br>
    {/if}

    <!-- ô�����֣� -->
    {if $form.form_c_staff_id4.error != null}
        <li>{$form.form_c_staff_id4.error}<br>
    {/if}
    {if $form.form_sale_rate4.error != null}
        <li>{$form.form_sale_rate4.error}<br>
    {/if}

    <!-- ���ô���Խ�ʣȽ�� -->
    {if $var.error_msg2 != null}
        <li>{$var.error_msg2}<br>
    {/if}

    <!-- �����ӥ��������ƥ�����Ƚ�� -->
    {if $var.error_msg3 != null}
        <li>{$var.error_msg3}<br>
    {/if}

    <!-- ���Ψ -->
    {if $var.error_msg != null}
        <li>{$var.error_msg}<br>
    {/if}
    {foreach key=i from=$error_loop_num3 item=items}
        {if $error_msg10[$i] != null}
            <li>{$error_msg10[$i]}<br>
        {/if}
    {/foreach}

    <!-- �����ӥ������������硢�����ӥ�ID�����뤫Ƚ�� -->
    {if $error_msg4[1] != null}
        <li>{$error_msg4[1]}<br>
    {/if}
    {if $error_msg4[2] != null}
        <li>{$error_msg4[2]}<br>
    {/if}
    {if $error_msg4[3] != null}
        <li>{$error_msg4[3]}<br>
    {/if}
    {if $error_msg4[4] != null}
        <li>{$error_msg4[4]}<br>
    {/if}
    {if $error_msg4[5] != null}
        <li>{$error_msg4[5]}<br>
    {/if}

    <!-- �����ƥ�����������硢�����ƥ�ID�����뤫Ƚ�� -->
    {if $error_msg5[1] != null}
        <li>{$error_msg5[1]}<br>
    {/if}
    {if $error_msg5[2] != null}
        <li>{$error_msg5[2]}<br>
    {/if}
    {if $error_msg5[3] != null}
        <li>{$error_msg5[3]}<br>
    {/if}
    {if $error_msg5[4] != null}
        <li>{$error_msg5[4]}<br>
    {/if}
    {if $error_msg5[5] != null}
        <li>{$error_msg5[5]}<br>
    {/if}

    <!-- ��ϩ -->
    {if $form.form_route_load.error != null}
        <li>{$form.form_route_load.error}<br>
    {/if}

    <!-- �����ʬ -->
    {if $form.form_divide[1].error != null}
        <li>{$form.form_divide[1].error}<br>
    {/if}
    {if $form.form_divide[2].error != null}
        <li>{$form.form_divide[2].error}<br>
    {/if}
    {if $form.form_divide[3].error != null}
        <li>{$form.form_divide[3].error}<br>
    {/if}
    {if $form.form_divide[4].error != null}
        <li>{$form.form_divide[4].error}<br>
    {/if}
    {if $form.form_divide[5].error != null}
        <li>{$form.form_divide[5].error}<br>
    {/if}

    <!-- �����ӥ��������켰�ե饰 -->
    {if $form.form_print_flg1[1].error != null}
        <li>{$form.form_print_flg1[1].error}<br>
    {/if}
    {if $form.form_print_flg1[2].error != null}
        <li>{$form.form_print_flg1[2].error}<br>
    {/if}
    {if $form.form_print_flg1[3].error != null}
        <li>{$form.form_print_flg1[3].error}<br>
    {/if}
    {if $form.form_print_flg1[4].error != null}
        <li>{$form.form_print_flg1[4].error}<br>
    {/if}
    {if $form.form_print_flg1[5].error != null}
        <li>{$form.form_print_flg1[5].error}<br>
    {/if}

    <!-- �����ӥ������������ƥ���� -->
    {if $form.form_print_flg2[1].error != null}
        <li>{$form.form_print_flg2[1].error}<br>
    {/if}
    {if $form.form_print_flg2[2].error != null}
        <li>{$form.form_print_flg2[2].error}<br>
    {/if}
    {if $form.form_print_flg2[3].error != null}
        <li>{$form.form_print_flg2[3].error}<br>
    {/if}
    {if $form.form_print_flg2[4].error != null}
        <li>{$form.form_print_flg2[4].error}<br>
    {/if}
    {if $form.form_print_flg2[5].error != null}
        <li>{$form.form_print_flg2[5].error}<br>
    {/if}

    <!-- ���ΰ���������ID -->
    {if $form.form_print_flg3[1].error != null}
        <li>{$form.form_print_flg3[1].error}<br>
    {/if}
    {if $form.form_print_flg3[2].error != null}
        <li>{$form.form_print_flg3[2].error}<br>
    {/if}
    {if $form.form_print_flg3[3].error != null}
        <li>{$form.form_print_flg3[3].error}<br>
    {/if}
    {if $form.form_print_flg3[4].error != null}
        <li>{$form.form_print_flg3[4].error}<br>
    {/if}
    {if $form.form_print_flg3[5].error != null}
        <li>{$form.form_print_flg3[5].error}<br>
    {/if}

    <!-- �����ƥॳ����-->
    {foreach key=i from=$error_loop_num1 item=items}
        {if $form.form_goods_cd1[$i].error != null}
            <li>{$form.form_goods_cd1[$i].error}<br>
        {/if}
        {if $form.form_goods_cd3[$i].error != null}
            <li>{$form.form_goods_cd3[$i].error}<br>
        {/if}
        {if $form.form_goods_cd2[$i].error != null}
            <li>{$form.form_goods_cd2[$i].error}<br>
        {/if}
    {/foreach}

    <!-- ���̡��켰-->
    {if $form.form_goods_num1[1].error != null}
        <li>{$form.form_goods_num1[1].error}<br>
    {/if}
    {if $form.form_goods_num1[2].error != null}
        <li>{$form.form_goods_num1[2].error}<br>
    {/if}
    {if $form.form_goods_num1[3].error != null}
        <li>{$form.form_goods_num1[3].error}<br>
    {/if}
    {if $form.form_goods_num1[4].error != null}
        <li>{$form.form_goods_num1[4].error}<br>
    {/if}
    {if $form.form_goods_num1[5].error != null}
        <li>{$form.form_goods_num1[5].error}<br>
    {/if}

    <!-- ���ο��� -->
    {if $form.form_goods_num2[1].error != null}
        <li>{$form.form_goods_num2[1].error}<br>
    {/if}
    {if $form.form_goods_num2[2].error != null}
        <li>{$form.form_goods_num2[2].error}<br>
    {/if}
    {if $form.form_goods_num2[3].error != null}
        <li>{$form.form_goods_num2[3].error}<br>
    {/if}
    {if $form.form_goods_num2[4].error != null}
        <li>{$form.form_goods_num2[4].error}<br>
    {/if}
    {if $form.form_goods_num2[5].error != null}
        <li>{$form.form_goods_num2[5].error}<br>
    {/if}

    <!-- �����ʿ��� -->
    {if $form.form_goods_num3[1].error != null}
        <li>{$form.form_goods_num3[1].error}<br>
    {/if}
    {if $form.form_goods_num3[2].error != null}
        <li>{$form.form_goods_num3[2].error}<br>
    {/if}
    {if $form.form_goods_num3[3].error != null}
        <li>{$form.form_goods_num3[3].error}<br>
    {/if}
    {if $form.form_goods_num3[4].error != null}
        <li>{$form.form_goods_num3[4].error}<br>
    {/if}
    {if $form.form_goods_num3[5].error != null}
        <li>{$form.form_goods_num3[5].error}<br>
    {/if}

    <!-- �Ķȸ��� -->
    {if $form.form_trade_price[1].error != null}
        <li>{$form.form_trade_price[1].error}<br>
    {/if}
    {if $form.form_trade_price[2].error != null}
        <li>{$form.form_trade_price[2].error}<br>
    {/if}
    {if $form.form_trade_price[3].error != null}
        <li>{$form.form_trade_price[3].error}<br>
    {/if}
    {if $form.form_trade_price[4].error != null}
        <li>{$form.form_trade_price[4].error}<br>
    {/if}
    {if $form.form_trade_price[5].error != null}
        <li>{$form.form_trade_price[5].error}<br>
    {/if}

    <!-- ���ñ�� -->
    {if $form.form_sale_price[1].error != null}
        <li>{$form.form_sale_price[1].error}<br>
    {/if}
    {if $form.form_sale_price[2].error != null}
        <li>{$form.form_sale_price[2].error}<br>
    {/if}
    {if $form.form_sale_price[3].error != null}
        <li>{$form.form_sale_price[3].error}<br>
    {/if}
    {if $form.form_sale_price[4].error != null}
        <li>{$form.form_sale_price[4].error}<br>
    {/if}
    {if $form.form_sale_price[5].error != null}
        <li>{$form.form_sale_price[5].error}<br>
    {/if}

    {foreach key=i from=$error_loop_num1 item=items}
        {foreach key=j from=$error_loop_num2 item=items}
            <!-- �����αĶȸ��� -->
            {if $error_msg6[$i][$j] != null}
                <li>{$error_msg6[$i][$j]}<br>
            {/if}
            <!-- ���������ñ�� -->
            {if $error_msg7[$i][$j] != null}
                <li>{$error_msg7[$i][$j]}<br>
            {/if}
            <!-- �����ο���-->
            {if $error_msg8[$i][$j] != null}
                <li>{$error_msg8[$i][$j]}<br>
            {/if}
            <!-- �����Υ����ƥ�-->
            {if $error_msg11[$i][$j] != null}
                <li>{$error_msg11[$i][$j]}<br>
            {/if}
            <!-- ����������Ƚ��-->
            {if $error_msg13[$i][$j] != null}
                <li>{$error_msg13[$i][$j]}<br>
            {/if}
        {/foreach}
    {/foreach}

    <!-- �����ӥ������� -->
    {if $form.form_serv[1].error != null}
        <li>{$form.form_serv[1].error}<br>
    {/if}
    {if $form.form_serv[2].error != null}
        <li>{$form.form_serv[2].error}<br>
    {/if}
    {if $form.form_serv[3].error != null}
        <li>{$form.form_serv[3].error}<br>
    {/if}
    {if $form.form_serv[4].error != null}
        <li>{$form.form_serv[4].error}<br>
    {/if}
    {if $form.form_serv[5].error != null}
        <li>{$form.form_serv[5].error}<br>
    {/if}

    <!-- ���Ρ����� -->
    {if $form.error_goods_num2[1].error != null}
        <li>{$form.error_goods_num2[1].error}<br>
    {/if}
    {if $form.error_goods_num2[2].error != null}
        <li>{$form.error_goods_num2[2].error}<br>
    {/if}
    {if $form.error_goods_num2[3].error != null}
        <li>{$form.error_goods_num2[3].error}<br>
    {/if}
    {if $form.error_goods_num2[4].error != null}
        <li>{$form.error_goods_num2[4].error}<br>
    {/if}
    {if $form.error_goods_num2[5].error != null}
        <li>{$form.error_goods_num2[5].error}<br>
    {/if}

    <!-- �����ʡ����� -->
    {if $form.error_goods_num3[1].error != null}
        <li>{$form.error_goods_num3[1].error}<br>
    {/if}
    {if $form.error_goods_num3[2].error != null}
        <li>{$form.error_goods_num3[2].error}<br>
    {/if}
    {if $form.error_goods_num3[3].error != null}
        <li>{$form.error_goods_num3[3].error}<br>
    {/if}
    {if $form.error_goods_num3[4].error != null}
        <li>{$form.error_goods_num3[4].error}<br>
    {/if}
    {if $form.error_goods_num3[5].error != null}
        <li>{$form.error_goods_num3[5].error}<br>
    {/if}

    {* ����̾ɬ�� *}
    {foreach key=i from=$error_loop_num1 item=items}
        {* �����ƥ����� *}
        {if $form.official_goods_name[$i].error != null}
            <li>{$form.official_goods_name[$i].error}<br>
        {/if}
        {* �����ƥ�ά�� *}
        {if $form.form_goods_name1[$i].error != null}
            <li>{$form.form_goods_name1[$i].error}<br>
        {/if}
        {* ������ *}
        {if $form.form_goods_name3[$i].error != null}
            <li>{$form.form_goods_name3[$i].error}<br>
        {/if}
        {* ���ξ��� *}
        {if $form.form_goods_name2[$i].error != null}
            <li>{$form.form_goods_name2[$i].error}<br>
        {/if}
    {/foreach}

    <!-- ������(������) -->
    {if $form.form_account_price[1].error != null}
        <li>{$form.form_account_price[1].error}<br>
    {/if}
    {if $form.form_account_price[2].error != null}
        <li>{$form.form_account_price[2].error}<br>
    {/if}
    {if $form.form_account_price[3].error != null}
        <li>{$form.form_account_price[3].error}<br>
    {/if}
    {if $form.form_account_price[4].error != null}
        <li>{$form.form_account_price[4].error}<br>
    {/if}
    {if $form.form_account_price[5].error != null}
        <li>{$form.form_account_price[5].error}<br>
    {/if}

    <!-- ������(Ψ) -->
    {if $form.form_account_rate[1].error != null}
        <li>{$form.form_account_rate[1].error}<br>
    {/if}
    {if $form.form_account_rate[2].error != null}
        <li>{$form.form_account_rate[2].error}<br>
    {/if}
    {if $form.form_account_rate[3].error != null}
        <li>{$form.form_account_rate[3].error}<br>
    {/if}
    {if $form.form_account_rate[4].error != null}
        <li>{$form.form_account_rate[4].error}<br>
    {/if}
    {if $form.form_account_rate[5].error != null}
        <li>{$form.form_account_rate[5].error}<br>
    {/if}

    {* ������ *}
    {foreach key=i from=$error_loop_num1 item=items}
        {if $form.form_ad_offset_amount[$i].error != null}
            <li>{$form.form_ad_offset_amount[$i].error}<br>
        {/if}
    {/foreach}

{/if}
</span>

{* ���顼���ʤ��ơ���ɼ��ס��ǹ��ˤ�������껦�۹�פ��礭����硢�ٹ� *}
{* rev.1.3 ͽ������2����ʾ�Υ��Ƥ���ٹ��ɲ� *}
{* {if $var.error_flg != true && $var.ad_total_warn_mess != null} *}
{if $var.error_flg != true && ($var.ad_total_warn_mess != null || $var.warn_lump_change != null)}
<br>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[�ٹ�]<br>
	{if $var.ad_total_warn_mess != null}
	{$var.ad_total_warn_mess}<br>
	{/if}
	{if $var.warn_lump_change != null}
	{$var.warn_lump_change}<br>
	{/if}
    {$form.form_ad_warn.html}<br><br>
	</font>
    </td></tr>
</table>
{/if}

<fieldset>
<legend><span style="font: bold 15px; color: #555555;">����ɼ�ֹ�ۡ� {$var.ord_no} </span>{$form.form_con_link.html}</legend>
<BR>
<table border="0">
    <tr>
        <td>
            <table class="List_Table" border="1" width="400">
                <tr class="Result1">
                    <td class="Title_Pink" width="78" align="center"><b>��Զ�ʬ</b></td>
                    <td class="Value">{if $var.contract_div == "1"}���ҽ��{elseif $var.contract_div == "2"}����饤�����{else}���ե饤�����{/if}</td>
                </tr>
                <tr class="Result1">
                    <td class="Title_Pink" width="78" align="center"><b>�����</b></td>
                    <td class="Value">{$var.round_form}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<BR>
<table class="List_Table" border="1">
	<tr align="center">
		<td class="Title_Pink" width=""><b>ͽ������<font color="red">��</font></b></td>
		<!-- �����ʬor�ƣ�Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '3'}
			<!-- �̾�orFC -->
			<td class="Title_Pink" width=""><b>��ϩ<font color="red">��</font></b></td>
		{else}
			<!-- ľ��¦����ԤϽ�ϩ�ʤ� -->
		{/if}
		<td class="Title_Pink" width=""><b>������</b></td>
		<td class="Title_Pink" width=""><b>�����ʬ<font color="red">��</font></b></td>
		<!-- �����ʬorľ��Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
			<!-- �̾�orľ�� -->
			<td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
			<td class="Title_Pink" width=""><b>������</b></td>
		{else}
			<!-- FC¦����Ԥ���������������ʤ� -->
		{/if}
		<!-- �����ʬor�ƣ�Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '3'}
			<!-- �̾�orFC -->
			<td class="Title_Pink" width=""><b>���ô��������</b></td>
		{else}
			<!-- ľ��¦����Ԥ���ɽ�� -->
		{/if}
	</tr>

	<!--1����-->
	<tr class="Result1">
		<td align="center" width="150">{$form.form_delivery_day.html}</td>
		<!-- �����ʬor�ƣ�Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '3'}
			<!-- �̾�orFC -->
			<td align="left">{$form.form_route_load.html}</td>
		{else}
			<!-- ľ��¦����ԤϽ�ϩ�ʤ� -->
		{/if}
		<td align="left" width="180">{$var.client_cd}<br>{$var.client_name}</td>
		<td align="center">{$form.trade_aord.html}</td>
		<!-- �����ʬorľ��Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
			<!-- �̾�orľ�� -->
			<td align="center" width="150">{$form.form_request_day.html}</td>
			<td align="left" width="180">{$form.form_claim.html}</td>
		{else}
			<!-- FC¦����Ԥ���������������ʤ� -->
		{/if}
		
		<!-- �����ʬor�ƣ�Ƚ�� -->
		{if $var.contract_div == 1 || $smarty.session.group_kind == '3'}
			<!-- �̾�orFC -->
			<td align="left">
				<table >
					<tr>
						<td><font color="#555555">
							�ᥤ��1<b><font color="#ff0000">��</font></b> {$form.form_c_staff_id1.html}�����{$form.form_sale_rate1.html}��<br>
							����2�� <b>��</b>{$form.form_c_staff_id2.html}�����{$form.form_sale_rate2.html}��<br>
							����3�� <b>��</b>{$form.form_c_staff_id3.html}�����{$form.form_sale_rate3.html}��<br>
							����4�� <b>��</b>{$form.form_c_staff_id4.html}�����{$form.form_sale_rate4.html}��<br>
							</font>
						</td>
					</tr>
				</table>
			</td>
		{/if}
	</tr>

	{* ���ҽ�󡢤ޤ���ľ��¦����Ԥξ�硢�Ҳ���¤�ɽ�� *}
	{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
		<tr class="Result1">
			<td class="Title_Purple" width="110"><b>�Ҳ������</b></td>
	    {if $var.contract_div == "1"}
			<td class="Value" width="185" colspan="3"><nobr>{$var.ac_name}</nobr></td>
            <td class="Title_Purple" width="110"><b>{$form.intro_ac_div[1].label}</b></td>
            <td class="Value" width="185" colspan="3">
        {else}
			<td class="Value" width="185" colspan="2"><nobr>{$var.ac_name}</nobr></td>
            <td class="Title_Purple" width="110"><b>{$form.intro_ac_div[1].label}</b></td>
            <td class="Value" width="185" colspan="">
        {/if}
                <table cellpadding="0" cellspacing="0" style="color: #555555;">
                    {if $var.ac_name == "̵��"}
                    <tr><td>{$form.intro_ac_div[3].html}</td></tr>
                    {else}
                    <tr><td>{$form.intro_ac_div[0].html}{$form.intro_ac_price.html}��</td><td>��{$form.intro_ac_div[3].html}</td></tr>
                    <tr><td>{$form.intro_ac_div[1].html}{$form.intro_ac_rate.html}��</td><td></td></tr>
                    <tr><td>{$form.intro_ac_div[2].html}</td><td></td></tr>
                    {/if}
                </table>
            </td>
		</tr>
	{/if}

	<!-- �����ʬor�ƣ�Ƚ�� -->
	{if $var.contract_div == 1}
		{* �̾� *}
		<tr class="Result1">
			<td class="Title_Pink"><b>����</b></td>
			<td class="Value" colspan="3">{$form.form_note.html}</td>
			<td class="Title_Pink" ><b>������ͳ<font color="red">��</font></b></td>
			<td class="Value" colspan="2">{$form.form_reason.html}</td>
		</tr>
		<tr class="Result1">
			<td class="Title_Pink"><b>��ȴ���<br>������</b></td>
			<td class="Value" colspan="3" align="right">{$form.form_sale_total.html}<br>{$form.form_sale_tax.html}</td>
			<td class="Title_Pink" ><b>��ɼ���</b></td>
			<td class="Value" colspan="2" align="right">{$form.form_sale_money.html}</td>
		</tr>
	{else}
		{* ��� *}
        {if $smarty.session.group_kind == "2"}
		<tr class="Result1">
			<td class="Title_Purple"><b>�����</b></td>
			<td class="Value" colspan="2"><nobr>{$var.act_name}</nobr></td>
            <td class="Title_Purple"><b>��԰�����</b></td>
            {if $var.act_div == "1"}
            <td class="Value" colspan="3" align="left">{$var.act_amount}</td>
            {elseif $var.act_div == "2"}
            <td class="Value" colspan="3" align="left">�����{$form.act_request_price.html}��</td>

            {elseif $var.act_div == "3"}
            <td class="Value" colspan="3" align="right">{$var.act_amount}</td>
            {/if}
		</tr>
        {/if}
		<tr class="Result1">
			<td class="Title_Pink"><b>����</b></td>
			<td class="Value" colspan="2">{$form.form_note.html}</td>
			<td class="Title_Pink" ><b>������ͳ<font color="red">��</font></b></td>
			<td class="Value" colspan="1">{$form.form_reason.html}</td>
		</tr>
		<tr class="Result1">
			<td class="Title_Pink"><b>��ȴ���<br>������</b></td>
			<td class="Value" align="right" colspan="2">{$form.form_sale_total.html}<br>{$form.form_sale_tax.html}</td>
			<td class="Title_Pink" ><b>��ɼ���</b></td>
			<td class="Value" align="right" colspan="1">{$form.form_sale_money.html}</td>
		</tr>
	{/if}

	{* ���ҽ�󡢤ޤ���ľ��¦����Ԥξ�硢�������ɽ�� *}
	{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
		<tr class="Result1">
			<td class="Title_Pink">
            <table width="100%" cellspacing="0" cellpadding="0"><tr>
                <td class="Title_Pink"><b>������Ĺ�</b></td>
                {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
                <td align="right">{$form.form_ad_sum_btn.html}</td>
                {/if}
            </tr></table>
            </td>
            {if $var.contract_div == "1"}
			<td class="Value" align="right" colspan="3">{$form.form_ad_rest_price.html}</td>
			<td class="Title_Pink" ><b>�����껦�۹��</b></td>
			<td class="Value" align="right" colspan="2">{$form.form_ad_offset_total.html}</td>
            {else}
			<td class="Value" align="right" colspan="2">{$form.form_ad_rest_price.html}</td>
			<td class="Title_Pink" ><b>�����껦�۹��</b></td>
			<td class="Value" align="right" colspan="1">{$form.form_ad_offset_total.html}</td>
            {/if}
		</tr>
	{/if}

</table>
<BR>
<A NAME="hand">
<table border="0" width="985">
	<tr>
	<td align="left"><font size="+0.5" color="#555555"><b>�ھ��ʽв��Ҹˡ�{$var.ware_name}</b></font></td>
	<td align="left" width=922><b><font color="blue">
        <li>�����껦�۰ʳ�����ȴ��ۤ���Ͽ���Ƥ���������
        <li>�֥����ӥ�̾�ס֥����ƥ�פ˥����å����դ������ɼ�˰�������ޤ�
    </b></td>
	</tr>
</table>

<table class="Data_Table" border="1" width="950">
	<tr>
		<td class="Title_Purple" rowspan="2"><b>�����ʬ<font color="#ff0000">��</font></b></td>
		<td class="Title_Purple" rowspan="2"><b>�����ӥ�̾</b></td>
		<td class="Title_Purple" rowspan="2"><b>�����ƥ�</b></td>
		<td class="Title_Purple" rowspan="2"><b>����</b></td>
		<td class="Title_Purple" colspan="2"><b>���</b></td>
		<td class="Title_Purple" rowspan="2"><b>������</b></td>
		<td class="Title_Purple" rowspan="2"><b>����</b></td>
		<td class="Title_Purple" rowspan="2"><b>���ξ���</b></td>
		<td class="Title_Purple" rowspan="2"><b>����</b></td>
		{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
			<td class="Title_Purple" rowspan="2"><b>������<br>(����ñ��)</b></td>
			<td class="Title_Purple" rowspan="2"><b>�����껦��</b></td>
		{/if}
    	{* <td class="Title_Purple" rowspan="2"><b>����</b></td> *}
		{if $var.contract_div == 1}
	    	<td class="Title_Purple" rowspan="2"><b>���ꥢ</b></td>
		{/if}
	</tr>

	<tr>
		<td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></b></td>
		<td class="Title_Purple" ><b>������׳�<br>����׳�</b></td>
	</tr>

	{foreach key=i from=$loop_num item=items}
        {* 2009-09-21 hashimoto-y *}
        {if $toSmarty_discount_flg[$i] === 't'}
            <tr class="Value" style="color: red">
        {else}
		    <tr>
        {/if}

			<td class="Value" align="center">{$form.form_divide[$i].html}</td>
			<td class="Value">{$form.form_print_flg1[$i].html}<br>{$form.form_serv[$i].html}</td>
			<!-- �ե꡼��Ƚ�� -->
			{if $var.contract_div == '1'}
				<!-- �̾�ξ�� -->
                <td class="Value">
                    {$form.form_goods_cd1[$i].html}({$form.form_search1[$i].html}){$form.form_print_flg2[$i].html}<br>
                    {$form.official_goods_name[$i].html}<br>
                    {$form.form_goods_name1[$i].html}
                </td>
				<td class="Value" align="right"><font color=#555555>�켰</font>{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
			{else}
				<!-- �����ɼ�ξ�縡����󥯤Ρʡ�̵�� -->
                <td class="Value">
                    {$form.form_goods_cd1[$i].html}��{$form.form_print_flg2[$i].html}<br>
                    {$form.official_goods_name[$i].html}<br>
                    {$form.form_goods_name1[$i].html}
                </td>
                {* 2009-09-21 hashimoto-y *}
                {if $toSmarty_discount_flg[$i] === 't'}
				    <td class="Value" align="right">�켰{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
                {else}
				    <td class="Value" align="right"><font color=#555555>�켰</font>{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
                {/if}
			{/if}
			<td class="Value" align="right">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
			<td class="Value" align="right">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>
			<!-- �ե꡼��Ƚ�� -->
			{if $var.contract_div == '1'}
				<!-- �̾�ξ�� -->
				<td class="Value">{$form.form_goods_cd3[$i].html}({$form.form_search3[$i].html})<br>{$form.form_goods_name3[$i].html}</td>
			{else}
				<!-- �����ɼ�ξ�縡����󥯤Ρʡ�̵�� -->
				<td class="Value">{$form.form_goods_cd3[$i].html}<br>{$form.form_goods_name3[$i].html}</td>
			{/if}
			<td class="Value" align="right">{$form.form_goods_num3[$i].html}</td>
			<!-- �ե꡼��Ƚ�� -->
			{if $var.contract_div == '1'}
				<!-- �̾�ξ�� -->
				<td class="Value">{$form.form_goods_cd2[$i].html}({$form.form_search2[$i].html})<br>{$form.form_goods_name2[$i].html}</td>
			{else}
				<!-- �����ɼ�ξ�縡����󥯤Ρʡ�̵�� -->
				<td class="Value">{$form.form_goods_cd2[$i].html}<br>{$form.form_goods_name2[$i].html}</td>
			{/if}
			<td class="Value" align="right">{$form.form_goods_num2[$i].html}</td>
			<!-- �ƣ�¦�����Ƚ�� -->
			{if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
				<!-- �̾�orľ�� -->
				<td class="Value">
					<table height="20">
                    {* 2009-09-21 hashimoto-y *}
                    {if $toSmarty_discount_flg[$i] === 't'}
                        <tr style="color: red">
							<td>{$form.form_aprice_div[$i].html}</td>
							<td>
								{$form.form_br.html}<br>
		      					{$form.form_account_price[$i].html}��<br>
		      					{$form.form_account_rate[$i].html}%
							</td>
                    {else}
						<tr>
							<td><font color="#555555">{$form.form_aprice_div[$i].html}</font></td>
							<td><font color="#555555">
								{$form.form_br.html}<br>
		      					{$form.form_account_price[$i].html}��<br>
		      					{$form.form_account_rate[$i].html}%
							</font></td>
                    {/if}
						</tr>
					</table>
				</td>
                {* �����껦�� *}
                <td class="Value">
                {* 2009-09-21 hashimoto-y *}
                {if $toSmarty_discount_flg[$i] === 't'}
                    <table cellspacing="0" cellpadding="0">
                        <tr style="color: red"><td>{$form.form_ad_offset_radio[$i][1].html}</td><td></td></tr>
                        <tr style="color: red">
                            <td>{$form.form_ad_offset_radio[$i][2].html}</td>
                            <td>{$form.form_ad_offset_amount[$i].html}</td>
                        </tr>
                    </table>
                {else}
                    <table cellspacing="0" cellpadding="0">
                        <tr><td><font color="#555555">{$form.form_ad_offset_radio[$i][1].html}</font></td><td></td></tr>
                        <tr>
                            <td><font color="#555555">{$form.form_ad_offset_radio[$i][2].html}</font></td>
                            <td><font color="#555555">{$form.form_ad_offset_amount[$i].html}</font></td>
                        </tr>
                    </table>
                {/if}
                </td>
			{/if}
    		{* <td class="Value" align="center">{$form.form_breakdown[$i].html}</td> *}
            {* ���ҽ��ξ��Τ߹ԥ��ꥢ *}
			{if $var.contract_div == 1}
	    		<td class="Value" align="center">{$form.clear_line[$i].html}</td>
			{/if}
		</tr>
	{/foreach}
</table>

<!-- �ƣ�or�̾���ɼ�ǡ�Ʊ���¹ԥ��顼�ʤ��Τߥ��ꥢ�ܥ���ɽ�� -->
{* {if ($var.group_kind == 3 || $var.contract_div == '1') && $var.concurrent_err_flg != "true"} *}
{if $var.concurrent_err_flg != "true"}
	<table width="960">
		<tr>
			<td align='right'>{$form.clear_button.html}</td>
		</tr>
	</table>
{/if}

</A>
</fieldset>

<table border="0" width="970">
	<tr>
		<td align="left"><b><font color="red">����ɬ�����ϤǤ�</font></b></td>
	</tr>
	<tr>
		<td align='right'>
			{if $var.concurrent_err_flg == "true"}
				{$form.slip_del_ok.html}
			{else}
				{* {$form.correction_button.html}����{$form.form_back.html} *}
				{* rev.1.3 �ٹ�ξ�硢�����ܥ����ɽ�����ʤ� *}
				{if $var.ad_total_warn_mess == null && $var.warn_lump_change == null}{$form.correction_button.html}����{/if}
				{$form.form_back.html}
			{/if}
		</td>
	</tr>
</table>

<!--******************** ����ɽ��2��λ *******************-->

					</td>
				</tr>
			</table>
		<!--******************** ����ɽ����λ *******************-->

		</td>
	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

{$var.html_footer}
	
