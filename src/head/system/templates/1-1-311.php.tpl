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
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������ࣱ begin +++++++++++++++*}
{if $var.pattern_err != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.pattern_err}<br>
    </span><br>
{/if}

{if $var.commit_flg != true}
    <span style="font-weight: bold; color: #555555;">�����ߡ��ʲ���ȯ�Ը�����Ͽ�ѤߤǤ���</span>
{else}
    <span style="font-weight: bold; color: #0000ff;">
        �����ѥ��������Ͽ���ޤ�����<br><br>
        �����β��̤ϼºݤΥ��᡼���Ȥϰۤʤ��ǽ��������ޤ���<br>
        ���ºݤ������ɼ�ϥץ�ӥ塼�򤴳�ǧ����������
    </span>
{/if}
{*--------------- ��å������ࣱ e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table width="950">
    <tr>
        <td>

{if $var.commit_flg != true}
    <table width="100%">
        <tr valign="bottom">
            <td>{$form.pattern_select.html}��{$form.preview_button.html}����{$form.change_button.html}����{$form.clear_button.html}</td>
        </tr>
    </table>
{else}
<br>����������������������{$form.ok_button.html}
{/if}

        </td>
    </tr>
</table>

<hr>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ��å������ࣲ begin +++++++++++++++*}
{* ��Ͽ���ѹ���λ��å��������� *}
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.pattern_name.error != null}
        <li>{$form.pattern_name.error}</li><br>
    {/if}
    {if $form.s_memo5.error != null}
        <li>{$form.s_memo5.error}</li><br>
    {/if}
    {if $form.s_memo6.error != null}
        <li>{$form.s_memo6.error}</li><br>
    {/if}
    {if $form.s_memo7.error != null}
        <li>{$form.s_memo7.error}</li><br>
    {/if}
    {if $form.s_memo8.error != null}
        <li>{$form.s_memo8.error}</li><br>
    {/if}
    {if $form.s_memo9.error != null}
        <li>{$form.s_memo9.error}</li><br>
    {/if}
    </span>
{/if}
{*--------------- ��å������ࣲ e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $smarty.post.form_new_flg != true && $smarty.post.form_update_flg != true || $var.pattern_err != null}

    {$form.form_new_button.html}

{else}

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�ѥ�����̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.pattern_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.bill_send_radio.html}</td>
    </tr>
</table>

{if $var.commit_flg != true}
<br>
<span style="font-weight: bold; color: #ff0000;">�ʲ��ι��ܤ����ꤷ�Ʋ�������</span><br>
<table style="font-weight: bold; color: #555555;">
<col span="3" width="130">
    <tr>
        <td>�� ���̾1</td><td>�� ���̾2</td><td>�� ��ɽ����</td>
    </tr>
    <tr>
        <td>�� ��ɽ��̾</td><td>�� ���ꡦTEL��FAX</td><td>�� �����ɼ������</td>
    </tr>
    <tr>
        <td>�� ������</td><td>�� Ǽ�ʽ������</td><td>�� �μ��������</td>
    </tr>
</table>
{/if}

        </td>
    </tr>
</table>
<br>

{/if}
{*--------------- ����ɽ���� a n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $smarty.post.form_new_flg != true && $smarty.post.form_update_flg != true || $var.pattern_err != null}

{else}

<table>
    <tr>
        <td>

{* �������ɼ *}
<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url({$var.path_sale_slip}) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top" width="50%">
        {* ���� *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 260px; left: 5px;">
            {*<table valign="bottom">*}
                <tr style="color: #ff0000;">
                    <td>��{$form.s_memo6.html}</td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 260px; left: 15px;">
            {*<table valign="bottom">*}
                <tr>
                    <td span style="font-size: 11px;">{$form.s_memo6.html}</td>
                </tr>
            </table>
        {/if}
        </td>
        <td align="left" valign="top">
        {* ��̾�� *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 5px; left: 45px;" cellspacing="0" cellpadding="0">
            {*<table cellspacing="0" cellpadding="0">*}
                <tr>
                    <td style="color: #ff0000;">
                        ��{$form.s_memo1.html} {$form.font_size_select_0.html}
                        ��{$form.s_memo2.html} {$form.font_size_select_1.html}<br>
                        ��{$form.s_memo3.html} {$form.font_size_select_2.html}
                        ��{$form.s_memo4.html} {$form.font_size_select_3.html}<br>
                        ��{$form.s_memo5.html} {$form.font_size_select_4.html}<br>
                    </td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 15px; left: 100px;" cellspacing="0" cellpadding="0">
            {*<table cellspacing="0" cellpadding="0" style="padding-left: 550px;">*}
                <tr>
                    <td>
                        <span style="font: bold 15px;">
                        {$form.s_memo1.html}
                        {$form.s_memo2.html}<br>
                        </span>
                        <span style="font-size: 11px;">
                        {$form.s_memo3.html}
                        {$form.s_memo4.html}<br>
                        {$form.s_memo5.html}<br>
                        </span>
                    </td>
                </tr>
            </table>
        {/if}
        </td>
    </tr>
</table>
</tr></td></table>
<br>

{* ����� *}
<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url({$var.path_claim_slip}) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
        {* ������ *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��{$form.s_memo7.html}</td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;">{$form.s_memo7.html}</td>
                </tr>
            </table>
        {/if}
        </td>
    </tr>
</table>
</td></tr></table>
<br>

{* Ǽ�ʽ� *}
<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url({$var.path_deli_slip}) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
        {* ������ *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��{$form.s_memo8.html}</td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;">{$form.s_memo8.html}</td>
                </tr>
            </table>
        {/if}
        </td>
    </tr>
</table>
</td></tr></table>
<br>

{* �μ��� *}
<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url({$var.path_receive_slip}) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
        {* ������ *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��{$form.s_memo9.html}</td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;">{$form.s_memo9.html}</td>
                </tr>
            </table>
        {/if}
        </td>
    </tr>
</table>
</td></tr></table>
<br>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">
        {if $var.commit_flg != true}{$form.new_button.html}{else}{$form.ok_button.html}{/if}</td>
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
