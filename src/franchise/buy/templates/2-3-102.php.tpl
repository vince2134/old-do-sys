{$var.html_header}

<script language="javascript">
{$var.js}
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

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {if $form.form_designated_date.error != null}
        <li>{$form.form_designated_date.error}<br>
    {/if}
    {if $form.form_order_day.error != null}
        <li>{$form.form_order_day.error}<br>
    {/if}
    {if $form.form_hope_day.error != null}
        <li>{$form.form_hope_day.error}<br>
    {/if}
    {if $form.form_ware.error != null}
        <li>{$form.form_ware.error}<br>
    {/if}
    {if $form.form_trade.error != null}
        <li>{$form.form_trade.error}<br>
    {/if}
    {if $form.form_staff.error != null}
        <li>{$form.form_staff.error}<br>
    {/if}
    {if $form.form_note_your.error != null}
        <li>{$form.form_note_your.error}<br>
    {/if}
    {if $form.form_direct.error != null}
        <li>{$form.form_direct.error}<br>
    {/if}
    {if $form.form_order_no.error != null}
        <li>{$form.form_order_no.error}<br>
    {/if}
    {if $form.form_buy_money.error != null}
        <li>{$form.form_buy_money.error}<br>
    {/if}
    {foreach from=$goods_err item=item key=i}
        {if $goods_err[$i] != null}
        <li>{$goods_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$price_num_err item=item key=i}
        {if $price_num_err[$i] != null}
        <li>{$price_num_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$num_err item=item key=i}
        {if $num_err[$i] != null}
        <li>{$num_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$price_err item=item key=i}
        {if $price_err[$i] != null}
        <li>{$price_err[$i]}<br>
        {/if}
    {/foreach}
    {foreach from=$duplicate_goods_err item=item key=i}
        <li>{$duplicate_goods_err[$i]}<br>
    {/foreach}
    </ul>
    </span>

{if $var.freeze_flg != null}
    {if $var.goods_twice != null}
        <font color="red"><b>{$var.goods_twice}</b></font><br>
    {/if} 
      <span style="font: bold;"><font size="+1">�ʲ������Ƥ�ȯ���ޤ�����</font></span><br>
{/if}

{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>
{*
<table class="Data_Table" border="1" width="700">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Value" colspan="3">{$form.form_order_no.html}</td>
    </tr>
    <tr>
        {if $var.freeze_flg == null}
            <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">��</font></td>
        {else}
            <td class="Title_Blue">ȯ����<font color="#ff0000">��</font></td>
        {/if}
        <td class="Value" colspan="3">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�вٲ�ǽ��</td>
        <td class="Value" colspan="3">{$form.form_designated_date.html} ����ޤǤ�ȯ��ѿ��Ȱ��������θ����</td>
    </tr>
    <tr>
        <td class="Title_Blue">ȯ����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_order_day.html}</td>
        <td class="Title_Blue">��˾Ǽ��</td>
        <td class="Value">{$form.form_hope_day.html}</td>    </tr>
    <tr>
        <td class="Title_Blue">�����ȼ�</td>
        <td class="Value" colspan="3">{$form.form_trans.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">ľ����</td>
        <td class="Value">{$form.form_direct.html}</td>
        <td class="Title_Blue">�����Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����ʬ</a><font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Blue">ȯ��ô����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�̿���<br>�ʻ����谸��</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
*}


{*
{if $var.update_flg == true}
<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">ȯ����</td>
        <td class="VALUE">{$form.form_send_date.html}</td>
    </tr>
</table>
<br>
{/if}
*}


<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Value">{$form.form_order_no.html}</td>
        {if $var.freeze_flg == null}
            <td class="Title_Blue">{$form.form_client_link.html}<font color="#ff0000">��</font></td>
        {else}
            <td class="Title_Blue">ȯ����<font color="#ff0000">��</font></td>
        {/if}

        {if $var.head_flg == 't'}
            <td class="Value" colspan="3">{$form.form_client.html}</td>
        {else}
            <td class="Value">{$form.form_client.html}</td>
            <td class="Title_Blue">ȯ����<font color="#ff0000">��</font></td>
            <td class="Value">{$form.form_order_day.html}</td>
        {/if}

    </tr>
    <tr>
        <td class="Title_Blue">�����ʬ</a><font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_trade.html}</td>
        <td class="Title_Blue">�вٲ�ǽ��</td>
        <td class="Value">{$form.form_designated_date.html} ����ޤǤ�ȯ��ѿ��Ȱ��������θ����</td>
        <td class="Title_Blue">��˾Ǽ��</td>
        <td class="Value">{$form.form_hope_day.html}</td>    </tr>
    </tr>
    <tr>
        <td class="Title_Blue">�����Ҹ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_ware.html}</td>
        <td class="Title_Blue">ľ����</td>
        <td class="Value" colspan="3">{$form.form_direct.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">ȯ��ô����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_staff.html}</td>
        <td class="Title_Blue">�����ȼ�</td>
        <td class="Value" colspan="3">{$form.form_trans.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�̿���<br>�ʻ����谸��</td>
        <td class="Value" colspan="5">{$form.form_note_your.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold; color: #ff0000;">{$var.warning}</span>

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
<span style="font: bold; color: #ff0000;">{$var.message}</span>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
        <td class="Title_Blue">��ê��<br>(A)</td>
        <td class="Title_Blue">ȯ��ѿ�<br>(B)</td>
        <td class="Title_Blue">������<br>(C)</td>
        <td class="Title_Blue">�вٲ�ǽ��<br>(A+B-C)</td>
        <td class="Title_Blue">��åȻ���</td>
        <td class="Title_Blue">��åȿ�</td>
        <td class="Title_Blue">ȯ���<font color="#ff0000">��</font></td>
        <td class="Title_Blue">����ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Blue">�������</td>
        {if $var.warning == null && $var.freeze_flg == null}
            <td class="Title_Add" width="50">�Ժ��</td>
        {/if}
    </tr>
    {$var.html}
</table>

        </td>
    </tr>
    <tr>
        <td>

{if $var.warning == null}
<table width="100%">
    <tr>
        	<td>{$form.form_add_row.html}</td>
        <td>
            <table class="List_Table" border="1" align="right" style="font-weight: bold;">
                <tr>
                    <td class="Title_Blue" width="80" align="center">��ȴ���</td>
                    <td class="Value" width="100" align="right">{$form.form_buy_money.html}</td>
                    <td class="Title_Blue" width="80" align="center">������</td>
                    <td class="Value" width="100" align="right">{$form.form_tax_money.html}</td>
                    <td class="Title_Blue" width="80" align="center">�ǹ����</td>
                    <td class="Value" width="100" align="right">{$form.form_total_money.html}</td>
                </tr>
            </table>
        </td>
        <td>{$form.form_sum_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<A NAME="foot"></A>
<table width="100%">
    <tr>
		<td align="left"><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
		{* ��Ͽ��ǧ����Ƚ�� *} 
		{if $var.freeze_flg == null}
			{* �ʳ� *} 
        	<td align="right">{$form.form_order_button.html}</td>
		{else}
			{* ��Ͽ��ǧ���� *} 
			<td align="right">{$form.comp_button.html}����{$form.order_button.html}����{$form.return_button.html}</td>
		{/if}
    </tr>
</table>
{/if}
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
