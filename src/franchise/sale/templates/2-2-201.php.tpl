{$var.html_header}

<script language="javascript">
{$var.html_js}
</script>

{* �ܵ��褬����Ƚ�� *}
{if ($var.comp_flg == null && $var.renew_flg != "true" && $var.done_flg != "true" && $var.slip_del_flg != true && $var.buy_err_mess == null)}
    {if ($var.client_id != null && $smarty.session.group_kind == "2")}
    {* ���򤵤줿��硢���������ؿ��ƽФ� *}
    <body onLoad="tegaki_daiko_checked(); ad_offset_radio_disable();">
    {else}
    <body onLoad="ad_offset_radio_disable();">
    {/if}
{else}
    {* ���򤵤�Ƥ��ʤ� *}
    <body >
{/if}

{* {$var.form_potision} *}

<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    {if $var.done_flg == true}
    	<tr align="center" valign="top" height="160">
	{else}
		<tr align="center" valign="top">
	{/if}
        <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{if $var.slip_del_flg == true}
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li>��ɼ���������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right">{$form.ok_button.html}</td>
        </tr>
    </table>
{elseif $var.buy_err_mess != null}
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <ul style="margin-left: 16px;">
            <li>{$var.buy_err_mess}�λ�����������������������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ���<br>
        </ul>
    </span>

    <table width="100%" height="100%">
        <tr>
            <td align="right">{$form.ok_button.html}</td>
        </tr>
    </table>
{elseif $var.done_flg == true}
            <table>
                <tr>
                    <td>

    <span style="font: bold;"><font size="+1">�����ɼ�κ�������λ���ޤ�����<br><br>
    </font></span>
    <table>
        <tr>
            <td align="left">{$form.ok_button.html}</td><td align="left">{$form.ok_slip_button.html}</td>
        </tr>
        <tr>
            <td align="left">{$form.slip_bill_button.html}</td><td align="left">{$form.ok_slip_bill_button.html}</td><td>����{$form.slip_copy_button.html}</td>
        </tr>
    </table>
    <table width="435">
        <tr><td colspan="3" width="100%" height="70" align="right" valign="bottom">{$form.return_edit_button.html}</td></tr>
    </table>

{else}
<fieldset>
<legend>
    <span style="font: bold 15px; color: #555555;">����ɼ�ֹ�ۡ� {$form.form_sale_no.html} </span>
</legend>
            <table>
                <tr>
                    <td>

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <ul style="margin-left: 16px;">

    {* ��ɼ�ֹ椬��ʣ���� *}
    {if $var.duplicate_err != null}
        <li>{$var.duplicate_err}<br>
    {/if}
    {* ��ɼ��������������������Ƥ��뤿�ᡢ�ѹ��Ǥ��ޤ��� *}
    {if $var.slip_renew_mess != null}
        <li>{$var.slip_renew_mess}<br>
    {/if}
    {* ���׾��� *}
    {if $form.form_delivery_day.error != null}
        <li>{$form.form_delivery_day.error}<br>
    {/if}
    {* ������ *}
    {if $form.form_request_day.error != null}
        <li>{$form.form_request_day.error}<br>
    {/if}
    {* ���������������褫�����å� *}
    {if $var.error_msg16 != null}
        <li>{$var.error_msg16}<br>
    {/if}
    {* ������ *}
    {if $form.form_client.error != null}
        <li>{$form.form_client.error}<br>
    {/if}
    {* �в��Ҹ� *}
    {if $form.form_ware_select.error != null}
        <li>{$form.form_ware_select.error}<br>
    {/if}
    {* �����ʬ *}
    {if $form.trade_sale_select.error != null}
        <li>{$form.trade_sale_select.error}<br>
    {/if}
    {* ���ô���� *}
    {if $form.form_ac_staff_select.error != null}
        <li>{$form.form_ac_staff_select.error}<br>
    {/if}
    {* ������ *}
    {if $form.form_daiko.error != null}
        <li>{$form.form_daiko.error}<br>
    {/if}
    {* ����*}
    {if $form.form_note.error != null}
        <li>{$form.form_note.error}<br>
    {/if}
    {* �����껦�۹�פ����ߤ�������Ĺ����礭�� *}
    {if $form.form_ad_offset_total.error != null}
        <li>{$form.form_ad_offset_total.error}<br>
    {/if}
    {* ��԰����� *}
{*
    {if $form.form_daiko_price.error != null}
        <li>{$form.form_daiko_price.error}<br>
    {/if}
*}
    {if $form.act_div[0].error != null}
        <li>{$form.act_div[0].error}<br>
    {/if}
    {if $form.act_request_rate.error != null}
        <li>{$form.act_request_rate.error}<br>
    {/if}
    {if $form.act_request_price.error != null}
        <li>{$form.act_request_price.error}<br>
    {/if}

    {* ����ñ����������� *}
    {if $form.intro_ac_price.error != null}
        <li>{$form.intro_ac_price.error}<br>
    {/if}

    {* ����Ψ��������� *}
    {if $form.intro_ac_rate.error != null}
        <li>{$form.intro_ac_rate.error}<br>
    {/if}

    {* ������(������) *}
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

    {* ������(Ψ) *}
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

    {* �����ӥ��������ƥ�����Ƚ�� *}
    {if $var.error_msg3 != null}
        <li>{$var.error_msg3}<br>
    {/if}

    {* �����ӥ������������硢�����ӥ�ID�����뤫Ƚ�� *}
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

    {* �����ƥ�����������硢�����ƥ�ID�����뤫Ƚ�� *}
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

    {* �����ʬ *}
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

    {* �����ӥ��������켰�ե饰 *}
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

    {* �����ӥ������������ƥ���� *}
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

    {* ���ΰ���������ID *}
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

    {* �����ƥॳ����*}
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

    {* ���̡��켰*}
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

    {* ���ο��� *}
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

    {* �����ʿ��� *}
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

    {* �Ķȸ��� *}
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

    {* ���ñ�� *}
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

    {* �����ӥ������� *}
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

    {* ���Ρ����� *}
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

    {* �����ʡ����� *}
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

    {* ������ *}
    {foreach key=i from=$error_loop_num1 item=items}
        {if $form.form_ad_offset_amount[$i].error != null}
            <li>{$form.form_ad_offset_amount[$i].error}<br>
        {/if}
    {/foreach}

    </ul>
    </span>

    {if $var.comp_flg != null}
        <span style="font: bold;"><font size="+1">�ʲ������ƤǼ����ɼ��������ޤ�����</font></span><br>
    {/if}

{* ���顼���ʤ��ơ���ɼ��ס��ǹ��ˤ�������껦�۹�פ��礭����硢�ٹ� *}
{if $var.error_flg != true && $var.ad_total_warn_mess != null}
<br>
<table border="0" width="650px" cellpadding="0" cellspacing="0" style="font-weight: bold; width: 650px;">
    <tr width="650px" style="width: 650px;"><td width="650px" style="width: 650px;">
    <font color="#ff00ff">[�ٹ�]<br>{$var.ad_total_warn_mess}</font>
    </td></tr>
</table>
<br>
{/if}

    {*--------------- ��å������� e n d ---------------*}

    {*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
    <table>
        <tr>
            <td>

    <!-- ľ��Ƚ�� -->
    {if $smarty.session.group_kind == "2" && $var.client_id != NULL}
    <table class="Data_Table" border="1" width="400">
        <tr>
            <td class="Title_Purple" align="center" width="92"><b>��Զ�ʬ</b></td>
            <td class="Value" width="308">{$form.daiko_check.html}</td>
        </tr>
    </table>
    <br>
    {/if}

<table class="List_Table" border="1">
    <tr align="center">
        <td class="Title_Pink" width=""><b>���׾���<font color="red">��</font></b></td>
        <td class="Title_Pink" nowrap><b>
        {* �ե꡼������Ƚ�� *} 
        {if $var.aord_id == null && $var.comp_flg == null && $var.renew_flg != "true"}
            <a href="#" onClick="return Open_SubWin('../dialog/2-0-250.php',Array('form_client[cd1]','form_client[cd2]','form_client[name]','client_search_flg'),500,450,5,1);">������</a><font color="#ff0000">��</font></td>
        {else}
            ������<font color="#ff0000">��</font></b></td>
        {/if}
        <td class="Title_Pink" width=""><b>�����ʬ<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>������<font color="red">��</font></b></td>
        <td class="Title_Pink" width=""><b>������</b></td>
        <td class="Title_Pink" width=""><b>���ô����</b></td>
    </tr>

    <tr class="Result1">
        <td align="center" width="150">{$form.form_delivery_day.html}</td>
        <td align="left" width="" nowrap>{$form.form_client.cd1.html}&nbsp;-&nbsp;{$form.form_client.cd2.html}��{$var.client_state_print}<br>{$form.form_client.name.html}</td>
        <td align="left">{$form.trade_sale_select.html}</td>
        <td align="center" width="150">{$form.form_request_day.html}</td>
        <td align="left" width="180">{$form.form_claim.html}</td>
        <td align="left">{$form.form_ac_staff_select.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>ľ����</b></td>
        <td class="Value" width="185" colspan="5">{$form.form_direct_select.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Purple" width="110"><b>�Ҳ������</b></td>
        <td class="Value" width="185" colspan="2"><nobr>{$var.ac_name}</nobr></td>
        <td class="Title_Purple" width="110"><b>{$form.intro_ac_div[1].label}</b></td>
        <td class="Value" width="185" colspan="2">
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

    {if $smarty.session.group_kind == "2" && $var.client_id != NULL}
    <tr>
        <td class="Title_Pink" nowrap><b>
        {if $var.aord_id == null && $var.comp_flg == null && $var.renew_flg != "true"}
            {$form.form_daiko_link.html}
        {else}
            {$form.form_daiko_link.label}
        {/if}
        </b></td>
        <td class="Value" colspan="2">{$form.form_daiko.cd1.html}&nbsp;-&nbsp;{$form.form_daiko.cd2.html}<br>{$form.form_daiko.name.html}</td>
        <td class="Title_Pink" nowrap><b>��԰�����</b></td>
        <td class="Value" colspan="2">
            <table cellpadding="0" cellspacing="0" style="color: #555555;">
                <tr><td>{$form.act_div[0].html}{$form.act_request_price.html}��</td><td>��{$form.act_div[2].html}</td></tr>
                <tr><td>{$form.act_div[1].html}{$form.act_request_rate.html}��</td><td></td></tr>
            </table>
        </td>
    </tr>
    {/if}

    <tr class="Result1">
        <td class="Title_Pink"><b>����</b></td>
        <td class="Value" colspan="5">{$form.form_note.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Pink"><b>��ȴ���<br>������</b></td>
        <td class="Value" colspan="2" align="right">{$form.form_sale_total.html}<br>{$form.form_sale_tax.html}</td>
        <td class="Title_Pink" ><b>��ɼ���</b></td>
        <td class="Value" colspan="2" align="right">{$form.form_sale_money.html}</td>
    </tr>

    <tr class="Result1">
        <td class="Title_Pink">
            <table width="100%" cellspacing="0" cellpadding="0"><tr>
                <td class="Title_Pink"><b>������Ĺ�</b></td>
                {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
                <td align="right">{$form.form_ad_sum_btn.html}</td>
                {/if}
            </tr></table>
        </td>
        <td class="Value" colspan="2" align="right">{$form.form_ad_rest_price.html}</td>
        <td class="Title_Pink" ><b>�����껦�۹��</b></td>
        <td class="Value" colspan="2" align="right">{$form.form_ad_offset_total.html}</td>
    </tr>

</table>
<BR>

    {if $var.warning != null}<font color="#ff0000"><b>{$var.warning}</b></font><br>{/if}

    {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
    <table width="100%">
        <tr><td align="right" colspan="3">{$form.form_sum_btn.html}</td></tr>
    </table>
    {/if}

            </td>
        </tr>
    </table>

            </td>
        </tr>
        <tr>
            <td>

<A NAME="hand">

<table border="0" width="985">
    <tr>
    <td align="left"><font size="+0.5" color="#555555"><b>�ھ��ʽв��Ҹˡ�{$form.form_ware_select.html}&nbsp;��</b></font></td>
    <td align="left" width="922"><b><font color="blue">
        <li>�����껦�۰ʳ�����ȴ��ۤ���Ͽ���Ƥ���������
        <li>�֥����ӥ�̾�ס֥����ƥ�פ˥����å����դ������ɼ�˰�������ޤ�
    </font></b></td>
    </tr>
</table>

    {*--------------- ����ɽ���� e n d ---------------*}


    {*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}

    <table class="Data_Table" border="1" width="950">
        {* �إå��� *}
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
            <!-- �ƣ�¦�����Ƚ�� -->
            {if $var.contract_div == 1 || $smarty.session.group_kind == '2'}
                <!-- �̾�orľ�� -->
                <td class="Title_Purple" rowspan="2"><b>������<br>(����ñ��)</b></td>
            {else}
                <!-- FC¦����Ԥϸ������ʤ� -->
            {/if}
            <td class="Title_Purple" rowspan="2"><b>�����껦��</b></td>
            {* <td class="Title_Purple" rowspan="2"><b>����</b></td> *}
            {* �ե꡼�����̤Ǥϥ��ꥢ�ϽФ��ʤ� *}
            {if $var.freeze_flg != true}
            <td class="Title_Purple" rowspan="2"><b>���ꥢ</b></td>
            {/if}
        </tr>

        <tr>
            <td class="Title_Purple"><b>�Ķȸ���<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></b></td>
            <td class="Title_Purple" ><b>������׳�<br>����׳�</b></td>
        </tr>


        {* �ǡ����� *}
        {foreach key=i from=$loop_num item=items}
        {* 2009-09-18 hashimoto-y *}
        {if $toSmarty_discount_flg[$i] === 't'}
            <tr class="Value" style="color: red">
        {else}
            <tr>
        {/if}
            {* �����ʬ *}
            <td class="Value" align="center">{$form.form_divide[$i].html}</td>

            {* �����ӥ� *}
            <td class="Value">{$form.form_print_flg1[$i].html}<br>{$form.form_serv[$i].html}</td>

            {* �����ƥ� *}
            <td class="Value">
                {$form.form_goods_cd1[$i].html}{if $var.freeze_flg == false}({$form.form_search1[$i].html}){/if}{$form.form_print_flg2[$i].html}<br>
                {$form.official_goods_name[$i].html}<br>
                {$form.form_goods_name1[$i].html}
            </td>
            {* �켰������ *}
            {* 2009-09-18 hashimoto-y *}
            {if $toSmarty_discount_flg[$i] === 't'}
                <td class="Value" align="right">�켰{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
            {else}
                <td class="Value" align="right"><font color=#555555>�켰</font>{$form.form_issiki[$i].html}<br>{$form.form_goods_num1[$i].html}</td>
            {/if}
            {* ��������� *}
            <td class="Value" align="right">{$form.form_trade_price[$i].html}<br>{$form.form_sale_price[$i].html}</td>
            <td class="Value" align="right">{$form.form_trade_amount[$i].html}<br>{$form.form_sale_amount[$i].html}</td>

            {* ������ *}
            <td class="Value">{$form.form_goods_cd3[$i].html}{if $var.freeze_flg == false}({$form.form_search3[$i].html}){/if}<br>{$form.form_goods_name3[$i].html}</td>
            <td class="Value" align="right">{$form.form_goods_num3[$i].html}</td>

            {* ���ξ��� *}
            <td class="Value">{$form.form_goods_cd2[$i].html}{if $var.freeze_flg == false}({$form.form_search2[$i].html}){/if}<br>{$form.form_goods_name2[$i].html}</td>
            <td class="Value" align="right">{$form.form_goods_num2[$i].html}</td>

            {* �Ҳ��� *}
            <td class="Value">
                <table height="20">
                    {* 2009-09-18 hashimoto-y *}
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
                {* 2009-09-18 hashimoto-y *}
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

            {if $var.freeze_flg != true}
            <td class="Value" align="center">{$form.clear_line[$i].html}</td>
            {/if}
        </tr>
    {/foreach}

    </table>

            </td>
        </tr>
    </table>

{*
    {if $var.warning == null && $var.comp_flg == null && $var.renew_flg != "true"}
    <table width="100%">
        <tr><td align="right" colspan="3">{$form.form_sum_btn.html}</td></tr>
    </table>
    {/if}
*}

</fieldset>
{/if}

<A NAME="foot"></A>
{* ���顼������λ���̰ʳ��Ϣ���ɽ�� *}
{if $var.slip_del_flg != true && $var.buy_err_mess == null && $var.done_flg != true}
    <table width="100%">
        <tr>
            <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        </tr>
        <tr>
            {* ��Ͽ��ǧ����Ƚ�� *} 
            {if $var.renew_flg == "true"}
                {* ���������ѤȤ������ٲ��� *}
                <td align="right" colspan="2">{$form.return_button.html}</td>
            {elseif $var.client_id != null && $var.comp_flg == null}
                {* �ʳ� *} 
                <td align="right" colspan="2">{$form.form_sale_btn.html}{if $var.new_entry == "false"}��{$form.form_back_button.html}{/if}</td>
            {elseif $var.client_id != null && $var.comp_flg == true}
                {* ��Ͽ��ǧ���� *} 
                <td align="right" colspan="2">{$form.comp_button.html}����{$form.history_back.html}</td>
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
