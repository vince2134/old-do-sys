{$var.html_header}
{$var.form_potision}

{* rev.1.2 ñ���߽вٿ���פ�JavaScript *}
<script language="javascript">
{$var.html_js}
</script>


<form {$form.attributes}>

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_order_no.error != null}
    <li>{$form.form_order_no.error}<br>
{/if}
{if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
{/if}
{if $form.form_designated_date.error != null}
    <li>{$form.form_designated_date.error}<br>
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}<br>
{/if}
{if $form.form_hope_day.error != null}
    <li>{$form.form_hope_day.error}<br>
{/if}
{if $form.form_arr_day.error != null}
    <li>{$form.form_arr_day.error}<br>
{/if}
{if $form.form_ware_select.error != null}
    <li>{$form.form_ware_select.error}<br>
{/if}
{if $form.trade_aord_select.error != null}
    <li>{$form.trade_aord_select.error}<br>
{/if}
{if $form.form_staff_select.error != null}
    <li>{$form.form_staff_select.error}<br>
{/if}
{if $form.form_trans_select.error != null}
    <li>{$form.form_trans_select.error}<br>
{/if}
{if $form.form_note_client.error != null}
    <li>{$form.form_note_client.error}<br>
{/if}
{if $form.form_note_head.error != null}
    <li>{$form.form_note_head.error}<br>
{/if}
{if $form.form_sale_num.error != null}
    <li>{$form.form_sale_num.error}<br>
{/if}
{if $goods_error0 != null}
    <li>{$goods_error0}<br>
{/if}
{foreach from=$goods_error1 key=i item=item}
{if $goods_error1[$i] != null}
    <li>{$goods_error1[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error2 key=i item=item}
{if $goods_error2[$i] != null}
    <li>{$goods_error2[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error3 key=i item=item}
{if $goods_error3[$i] != null}
    <li>{$goods_error3[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error4 key=i item=item}
{if $goods_error4 != null}
    <li>{$goods_error4[$i]}<br>
{/if}
{/foreach}
{foreach from=$goods_error5 key=i item=item}
{if $goods_error5[$i] != null}
    <li>{$goods_error5[$i]}<br>
{/if}
{/foreach}
{if $var.duplicate_err != null}
    <li>{$var.duplicate_err}<br>
{/if}
{foreach from=$duplicate_goods_err key=i item=item}
    <li>{$duplicate_goods_err[$i]}<br>
{/foreach}

{* rev.1.2 ʬǼ���в�ͽ�������вٿ� *}
{if $var.forward_day_err != null}
    <li>{$var.forward_day_err}<br>
{/if}
{if $var.forward_num_err != null}
    <li>{$var.forward_num_err}<br>
{/if}


</span>

<!-- �ե꡼������Ƚ�� -->
{if $var.comp_flg != null}
	<span style="font: bold;"><font size="+1">�ʲ������ƤǼ����ޤ�����</font></span><br>
{/if}
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">�����ֹ�</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">
		{* �ե꡼������Ƚ�� *} 
        {if $var.comp_flg == null && $var.check_flg != true && $smarty.get.aord_id == null}
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,6,1);">������</a>
		{else}
            ������
        {/if}
		<font color="#ff0000">��</font></td>
        <td class="Value" colspan="4">{$form.form_client.html}</td>
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
        <td class="Title_Pink">�в�ͽ����</td>
        <td class="Value">{$form.form_arr_day.html}</td>
        <td class="Title_Pink">�����ȼ�</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">�в��Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">��˾Ǽ��</td>
        <td class="Value">{$form.form_hope_day.html}</td>
		{* rev.1.3 ľ����ƥ��������� *}
        {* <td class="Title_Pink">ľ����</td> *}
        <td class="Title_Pink">
		{* �ե꡼������Ƚ�� *} 
        {if $var.comp_flg != true}
			<a href="#" onClick="return Open_SubWin('../dialog/1-0-260.php',Array('form_direct_text[cd]','form_direct_text[name]','form_direct_text[claim]','hdn_direct_search_flg'),500,450,'1-3-207',1);">ľ����</a>
		{else}
            ľ����
        {/if}
		</td>
        {* <td class="Value">{$form.form_direct_select.html}</td> *}
        <td class="Value">{$form.form_direct_text.cd.html}&nbsp;{$form.form_direct_text.name.html}&nbsp;&nbsp;�����衧{$form.form_direct_text.claim.html}</td>
        <td class="Title_Pink">�����ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.trade_aord_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>�������谸��</td>
        <td class="Value" colspan="5">{$form.form_note_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">�̿���<br>����������</td>
        <td class="Value" colspan="5">{$form.form_note_head.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

{if $var.warning != null}<font color="#ff0000"><b>{$var.warning}</b></font>{/if}

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
{$form.hidden}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr class="Result1" align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">���ʥ�����<font color="#ff0000">��</font><br>����̾<font color="#ff0000">��</font></td>
        <td class="Title_Pink">��ê��<br>(A)</td>
        <td class="Title_Pink">ȯ��ѿ�<br>(B)</td>
        <td class="Title_Pink">������<br>(C)</td>
        <td class="Title_Pink">�вٲ�ǽ��<br>(A+B-C)</td>
		{if $var.edit_flg == "true"}
	        <td class="Title_Pink">�����<font color="#ff0000">��</font></td>
		{/if}
        <td class="Title_Pink">����ñ��<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Pink">�������<br>�����</td>
		{if $var.edit_flg != "true"}
	        <td class="Title_Pink">�вٲ��<font color="#ff0000">��</font></td>
    	    <td class="Title_Pink">ʬǼ���в�ͽ����<font color="#ff0000">��</font></td>
        	<td class="Title_Pink">�вٿ�<font color="#ff0000">��</font></td>
		{/if}
{*
    {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
    {if $var.warning == null && $var.comp_flg == null}
        <td class="Title_Add" width="50">�Ժ��</td>
    {/if}
    </tr>
    {$var.html}
</table>

<table width="100%">
    <tr>
{*�����å�����̵��
        {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
        {if $var.warning == null && $var.comp_flg == null}
            <td>{$form.add_row_link.html}</td>
        {/if}
        <td align="right">
            <table class="List_Table" border="1" width="600">
                <tr>
                    <td class="Title_Pink" width="80" align="center"><b>��ȴ���</b></td>
                    <td class="Value" align="right">{$form.form_sale_total.html}</td>
                    <td class="Title_Pink" width="80" align="center"><b>������</b></td>
                    <td class="Value" align="right">{$form.form_sale_tax.html}</td>
                    <td class="Title_Pink" width="80" align="center"><b>�ǹ����</b></td>
                    <td class="Value" align="right">{$form.form_sale_money.html}</td>
                </tr>
            </table>
        </td>
{*�����å�����̵��
        {if $var.warning == null && $var.comp_flg == null && $var.check_flg != true}
*}
        {if $var.warning == null && $var.comp_flg == null}
            <td>{$form.form_sum_button.html}</td>
        {/if}
    </tr>
</table>

<A NAME="foot"></A>
<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
		{* ��Ͽ��ǧ����Ƚ�� *} 
		{if $var.comp_flg == null}
			<td align="right" colspan="2">
			{* ���ܸ�Ƚ�� *}
{*�����å�����̵��
			{if $var.check_flg == true}
*}
				{* ����Ȳ񤫤����� *}
{*
				{$form.complete.html}����{$form.return_button.html}
			{else}
*}
				{* ����Ĥ�������or���ɽ�� *}
				{$form.order.html}
{*�����å�����̵��
			{/if}
*}
        	</td>
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
