{$var.html_header}

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
    {if $var.freeze_flg == true}
        <tr align="center" valign="top" height="160">
    {else}
        <tr align="center" valign="top">
    {/if}
        <td>
            <table>
                <tr>
                    <td>

{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

{* ʬ�����ꥨ�顼��å����� *}
{if $var.ary_division_err_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {foreach key=i from=$var.ary_division_err_msg item=division_err_msg}<li>{$division_err_msg}</li><br>{/foreach}
    </span>
{/if}

{* �ե����२�顼��å����� *}
{foreach from=$form.form_split_pay_amount item=item key=i}
    {if $form.form_split_pay_amount[$i].error != null}
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>{$form.form_split_pay_amount[$i].error}</li><br>
        </span>
    {/if}
{/foreach}

{if $var.renew_msg != null}
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li>{$var.renew_msg}</li><br>
        </span>
{/if}


{* ʬ���ʧ��Ͽ��λ��å����� *}
{if $var.division_comp_flg == true}
    <span style="font: bold 15px; color: #555555;">ʬ���ʧ��Ͽ��λ���ޤ�����<br><br></span>
{/if}


{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col width="140">
<col width="80" style="font-weight: bold;">
<col width="200">
<col width="80" style="font-weight: bold;">
<col width="140">
    <tr>
        <td class="Title_Blue">��ɼ�ֹ�</td>
        <td class="Value">{$form.form_buy_no.html}</td>
        <td class="Title_Blue">������</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Blue">ȯ���ֹ�</td>
        <td class="Value">{$form.form_ord_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">������</td>
        <td class="Value">{$form.form_arrival_day.html}</td>
        <td class="Title_Blue">�����ʬ</td>
        <td class="Value">{$form.form_trade_buy.html}</td>
        <td class="Title_Blue">������</td>
        <td class="Value">{$form.form_buy_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">�����Ҹ�</td>
        <td class="Value">{$form.form_ware_name.html}</td>
        <td class="Title_Blue">ľ����</td>
        <td class="Value">{$form.form_direct_name.html}</td>
        <td class="Title_Blue">ȯ��ô����</td>
        <td class="Value">{$form.form_oc_staff_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">����ô����</td>
        <td class="Value">{$form.form_c_staff_name.html}</td>
        <td class="Title_Blue">����</td>
        <td class="Value" colspan="3">{$form.form_note.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" align="right" width="100%">
    <tr>
        <td class="Title_Blue" width="100" align="center"><b>��ȴ���</b></td>
        <td class="Value" align="right">{$form.form_buy_total.html}</td>
        <td class="Title_Blue" width="80" align="center"><b>������</b></td>
        <td class="Value" align="right">{$form.form_buy_tax.html}</td>
        <td class="Title_Blue" width="80" align="center"><b>�ǹ����</b></td>
        <td class="Value" align="right">{$form.form_buy_money.html}</td>
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
{$form.hidden}
<table align="center" width="100%">
    <tr>
        <td>

{* ʬ���ǧ���Τ� *}
{if $var.division_flg == "true"}
<table class="List_Table" border="1" align="center" width="400">
    <tr style="font-weight: bold;" align="center">
        <td class="Title_Purple">ʬ����</td>
        <td class="Title_Purple">ʬ���ʧ��</td>
        <td class="Title_Purple">ʬ���ʧ���</td>
    </tr>
    {foreach from=$form.form_pay_date item=item key=i}
    <tr>
        <td class="value" align="right">{$i+1}</td>
        <td class="value" align="center">{$form.form_pay_date[$i].html}</td>
        <td class="value" align="right">{$form.form_pay_amount[$i].html}</td>
    </tr>
    {/foreach}
</table>

<table width="400" align="center">
    <tr>
        <td align="right">{$form.return_button.html}</td>
    </tr>
</table>

{* ʬ��������Τ� *}
{else}

<table align="center">
    <tr>
        <td>
            <table class="List_Table" border="1" width="500" align="left">
                <tr>
                    <td class="Title_Purple" align="center" width="100"><b>��ʧ������<font color="#ff0000">��</font></b></td>
                    <td class="Value">��ʧ���Ρ�{$form.form_pay_m.html} ���顡��� {$form.form_pay_d.html}</td>
                    <td class="Title_Purple" align="center" width="80"><b>ʬ����<font color="red">��</font></b></td>
                    <td class="Value">{$form.form_division_num.html}</td>
                </tr>
            </table>
        </td>
        <td>
            <table> 
                <tr>    
                    <td>{if $var.division_comp_flg != true}����{$form.form_conf_button.html}����{$form.return_button.html}{/if}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{if $var.division_set_flg === true}
        </td>
    </tr>
    <tr>
        <td align="center">

<br>
<table>
    <tr>
        <td>
            <table class="List_Table" border="1" align="center" width="400">
                <tr style="font-weight: bold;" align="center">
                    <td class="Title_Purple">ʬ����</td>
                    <td class="Title_Purple">ʬ���ʧ��</td>
                    <td class="Title_Purple">ʬ���ʧ���<font color="red">��</font></td>
                </tr>
                {foreach from=$form.form_split_pay_amount item=item key=i}
                <tr>
                    <td class="value" align="right">{$i+1}</td>
                    <td class="value" align="center">{$form.form_pay_date[$i].html}</td>
                    <td class="value" align="right">{$form.form_split_pay_amount[$i].html}</td>
                </tr>
                {/foreach}
            </table>
        </td>
    </tr>
    {if $var.division_comp_flg != true}
    <tr>
        <td align="right">{if $var.division_set_flg === true}����{$form.add_button.html}{/if}</td>
    </tr>
    {/if}
    {if $var.division_comp_flg == true}
    <tr>
        <td align="right">{$form.ok_button.html}����{$form.return_button.html}</td>
    </tr>
    {/if}
</table>
{/if}
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
