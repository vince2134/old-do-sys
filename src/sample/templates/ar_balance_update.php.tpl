{$var.html_header}
<body bgcolor="#D8D0C8">
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
{$var.err_msg}
</span>
<span style="color: #000000; font-weight: bold; line-height: 130%;">
{$var.ar_fin_msg}
{$var.bill_fin_msg}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table><tr><td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">����åףɣ�</td>
        <td class="Value">{$form.form_shop_id.html}</td>
        <td class="Title_Purple">���饤����ȣɣ�</td>
        <td class="Value">{$form.form_client_id.html}</td>
    </tr>
        <td class="Title_Purple">��Ͽ��</td>
        <td class="Value">{$form.form_monthly_close_day_this.html}</td>
        <td class="Title_Purple">��ݻĹ�</td>
        <td class="Value">{$form.form_ar_balance.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����å�̾</td>
        <td class="Value">{$form.form_staff_name.html}</td>
        <td class="Title_Purple">����������</td>
        <td class="Value">{$form.form_bill_chk.html}</td>
    </tr>

</table>
{if $var.exit_flg != true}
{$var.btn_push}
{$form.exe_btn.html}
{/if}
<br>
</td></tr></table>
<br>
{$form.update_btn.html}
{$form.reset.html}
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
<table width="100%">
        <tr>
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

