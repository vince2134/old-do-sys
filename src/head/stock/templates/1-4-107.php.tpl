{$var.html_header}

<body bgcolor="#D8D0C8" >
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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $form.err_illegal_verify.error != null}
    <li>{$form.err_illegal_verify.error}<br>
{/if}
{if $var.goods_error0 != null}
    <li>{$var.goods_error0}<br>
{/if}
{if $var.goods_error1 != null}
    <li>{$var.goods_error1}<br>
{/if}
{if $var.goods_error2 != null}
    <li>{$var.goods_error2}<br>
{/if}
{if $var.goods_error3 != null}
    <li>{$var.goods_error3}<br>
{/if}
{if $form.form_move_day.error != null}
    <li>{$form.form_move_day.error}<br>
{/if}
</ul>
</span>
{*--------------- ��å������� e n d ---------------*}

{* ��Ͽ��λ��å����� *} 
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.insert_msg != null}
    <li>{$var.insert_msg}<br>
{/if}
<li>����˴ط��ʤ���ư�ξ��˻��Ѥ��Ʋ�������
{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow" width="100">��ư��<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_move_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">��ư���Ҹ�</td>
        <td class="Value">{$form.form_org_move.html}
        {if $var.warning1 != null}
            <font color="#ff0000"><b>{$var.warning1}</b></font>
        {/if}
        </td>
    </tr>
    <tr>
        <td class="Title_Yellow" width="100">��ư���Ҹ�</td>
        <td class="Value">{$form.form_move.html}
        {if $var.warning2 != null}
            <font color="#ff0000"><b>{$var.warning2}</b></font>
        {/if}
        </td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_set_button.html}��{$form.form_show_button.html}</td>
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
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">���ʥ�����<font color="#ff0000">��</font><br>����̾</td>
        <td class="Title_Yellow" colspan="2">��ư��</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow" colspan="2">��ư��</td>
        <td class="Title_Yellow" rowspan="2">��<br>��{$form.add_row_link.html}��</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">�Ҹ�̾<font color="#ff0000">��</font></td>
        <td class="Title_Yellow">�߸˿�<br>�ʰ�������</td>
        <td class="Title_Yellow">��ư��<font color="#ff0000">��</font></td>
        <td class="Title_Yellow">ñ��</td>
        <td class="Title_Yellow">�Ҹ�̾<font color="#ff0000">��</font></td>
        <td class="Title_Yellow">�߸˿�<br>�ʰ�������</td>
    </tr>
    {$var.html}
</table>

<A NAME="foot"></A>
<table border="0" width="100%">
    <tr>
        <td><font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font></td>
        <td align="right">{$form.form_move_button.html}</td>
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
