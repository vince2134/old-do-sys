{$var.html_header}

<script language="javascript">
{$var.forward_num}
 </script>
 
<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_ord_day.error != null}
        <li>{$form.form_ord_day.error}<br>
    {/if}
    {if $var.form_ord_day_err != null}
        <li>{$var.form_ord_day_err}<br>
    {/if}
    {if $form.form_ware_select.error != null}
        <li>{$form.form_ware_select.error}<br>
    {/if}
    {if $form.form_trade_select.error != null}
        <li>{$form.form_trade_select.error}<br>
    {/if}
    {if $form.form_staff_select.error != null}
        <li>{$form.form_staff_select.error}<br>
    {/if}
    {if $var.form_def_day_err != null}
        <li>{$var.form_def_day_err}<br>
    {/if}
    {if $form.form_def_day.error != null}
        <li>{$form.form_def_day.error}<br>
    {/if}
    {if $var.forward_day_err != null}
        <li>{$var.forward_day_err}<br>
    {/if}
    {if $var.forward_num_err != null}
        <li>{$var.forward_num_err}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $form.form_trans_select.error != null}
        <li>{$form.form_trans_select.error}<br>
    {/if}
    {if $form.form_note_your.error != null}
        <li>{$form.form_note_your.error}<br>
    {/if}
    {if ($var.alert_message != null && $var.alert_output != null) || $var.price_warning != null}
        <font color="#ff00ff"><p>[�ٹ�]
        {if $var.alert_message != null && $var.alert_output != null}
         <br>{$var.alert_message}</font>
        {/if}
        {if $var.price_warning != null}
        <br>{$var.price_warning}</font>
            <br>
        {/if}
        {$form.button.alert_ok.html}<p>
    {/if}
    </span>
{*+++++++++++++++ ��å������� e n d +++++++++++++++*} 
<!-- �ե꡼������Ƚ�� -->
{if $var.comp_flg != null}
	<span style="font: bold;"><font size="+1">�ʲ������ƤǼ����ޤ�����</font></span><br>
{/if}
{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<form {$form.attributes}>

<table width="800">
    <tr>
        <td>

{*
<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">FCȯ���ֹ�</td>
        <td class="Value">{$var.fc_ord_id}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������</td>
        <td class="Value" colspan="3">{$var.client_cd}��{$var.client_name}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">��˾Ǽ��</td>
        <td class="Value">{$var.hope_day}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">ľ����</td>
        <td class="Value">{$var.direct_name}</td>
        <td class="Title_Pink">�в��Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trade_select.html}</td>
        <td class="Title_Pink">����ô����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="3">{$var.note_my}</td>
    </tr>
</table>
*}

<table class="Data_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
<col style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">������</td>
        <td class="Value">{$var.client_cd}��{$var.client_name}</td>
        <td class="Title_Pink">FCȯ���ֹ�</td>
        <td class="Value">{$var.fc_ord_id}</td>
    </tr>
    <tr>
        <td class="Title_Pink">������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">�вٲ�ǽ��</td>
        <td class="Value">{$form.form_designated_date.html} ����ޤǤ�ȯ��ѿ��Ȱ��������θ����</td>
        <td class="Title_Pink">����ô����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�в�ͽ����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_def_day.html}</td>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">�в��Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��˾Ǽ��</td>
        <td class="Value">{$var.hope_day}</td>
        <td class="Title_Pink">ľ����</td>
        <td class="Value">{$var.direct_name}</td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trade_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="5">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="5">{$var.note_my}</td>
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
{$form.hidden}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">���ʥ�����<br>����̾</td>
        <td class="Title_Pink">��ê��<BR>��A��</td>
        <td class="Title_Pink">ȯ��ѿ�<BR>��B��</td>
        <td class="Title_Pink">������<BR>��C��</td>
        <td class="Title_Pink">�вٲ�ǽ��<BR>��A+B-C��</td>
        <td class="Title_Pink">�����</td>
        <td class="Title_Pink"><font color="#0000ff">����ñ��</font><br><font color="#ff0000">FCȯ��ñ��</font><br>���ñ��</td>
        <td class="Title_Pink"><font color="#0000ff">�������</font><br><font color="#ff0000">FCȯ����</font><br>�����</td>
        <td class="Title_Pink">�вٲ��<font color="#ff0000">��</font></font></td>
        <td class="Title_Pink">ʬǼ���в�ͽ����<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�вٿ�<font color="#ff0000">��</font></font></td>
    </tr>
    {foreach key=j from=$row item=items}
    {if $row[$j][11] == true}
    <tr bgcolor="pink" >
    {else}
    <tr class="Result1">
    {/if}
        {* No. *}
        <td align="right">
            {if $smarty.post.show_button == "ɽ����"}
                {$j+1}
            {elseif $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*10+$j-9}
            {else if}
                {$j+1}
            {/if}
        </td>
        {* ���� *}
        <td>{$row[$j][1]}<br>{$row[$j][2]}</td>
        {* ��ê����A��*}
        <td align="right"><a href="#" onClick="Open_mlessDialmg_g('1-2-107.php',{$row[$j][0]},{$smarty.session.client_id},300,160);">{$row[$j][12]}</a></td>
        {* ȯ��ѿ���B��*}
        <td align="right">{$row[$j][13]}</td>
        {* ��������C��*}
        <td align="right">{$row[$j][14]}</td>
        {* �вٲ�ǽ����A+B-C��*}
        <td align="right">{$row[$j][15]}</td>
        {* ����� *}
        <td align="right">{$row[$j][3]}</td>
        {* ñ�� *}
        <td align="right"><font color="#0000ff">{$row[$j][4]}</font><br><font color="ff0000">{$row[$j][9]}</font><br>{$row[$j][5]}</td>
        {* ��� *}
        <td align="right"><font color="#0000ff">{$row[$j][6]}</font><br><font color="ff0000">{$row[$j][10]}</font><br>{$row[$j][7]}</td>
        {* �вٲ�� *}
		{if $var.comp_flg != null}
        <td align="right">{$form.form_forward_times[$j].html}</td>
		{else}
        <td align="center">{$form.form_forward_times[$j].html}</td>
		{/if}
        {* ʬǼ���в�ͽ���� *}
        <td align="center" width="130">
		<!-- �ե꡼������Ƚ��-->
		{if $var.comp_flg != null}
			<!-- �ե꡼������-->
			{foreach key=i from=$disp_count[$j] item=items}
        		{$form.form_forward_day[$j][$i].html}<br>
			{/foreach}
		{else}
			<!-- ���ɽ��-->
			{foreach key=i from=$num item=items}
        		{$form.form_forward_day[$j][$i].html}
        	{/foreach}
		{/if}
        </td>
        {* �вٿ� *}
		<!-- �ե꡼������Ƚ��-->
		{if $var.comp_flg != null}
        <td align="right" width="130">
			<!-- �ե꡼������-->
			{foreach key=i from=$disp_count[$j] item=items}
        		{$form.form_forward_num[$j][$i].html}<br>
			{/foreach}
		{else}
        <td align="center" width="130">
			<!-- ���ɽ��-->
			{foreach key=i from=$num item=items}
            	{$form.form_forward_num[$j][$i].html}
        	{/foreach}
		{/if}
        </td>
    </tr>
    {/foreach}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right" class="List_Table" border="1" width="650">
    <tr>
        <td class="Title_Pink" align="center" width="80"><b>��ȴ���</b></td>
        <td class="Value" align="right">{$form.form_sale_total.html}</td>
        <td class="Title_Pink" align="center" width="80"><b>������</b></td>
        <td class="Value" align="right">{$form.form_sale_tax.html}</td>
        <td class="Title_Pink" align="center" width="80"><b>�ǹ����</b></td>
        <td class="Value" align="right">{$form.form_sale_money.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
		{* ��Ͽ��ǧ����Ƚ�� *} 
		{if $var.comp_flg == null}
			{* �ʳ� *}
            {if ($var.alert_message != null && $var.alert_output != null) || $var.price_warning != null} 
        	<td align="right" colspan="2">����{$form.button.back.html}</td>
            {else}
        	<td align="right" colspan="2">{$form.button.entry.html}����{$form.button.back.html}</td>
            {/if}
		{else}
			{* ��Ͽ��ǧ���� *} 
			<td align="right" colspan="2">{$form.comp_button.html}����{$form.return_button.html}</td>
		{/if}
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
