{$var.html_header}

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

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_close_day.error != null}
    <li>{$form.form_close_day.error}<br>
    {/if}
    {if $form.bill_day_err.error != null}
    <li>{$form.bill_day_err.error}<br>
    {/if}
    {if $form.bill_amount_err.error != null}
    <li>{$form.bill_amount_err.error}<br>
    {/if}
    {if $form.bill_all_err.error != null}
    <li>{$form.bill_all_err.error}<br>
    {/if}
    </span><br>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null}
    <li>{$var.message}<br>
    {/if}
    </span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="400">
    <tr>
        <td>

<div style="text-align: left; font: bold; color: #3300ff;">
    ���ܻĹ�������ϳ���������Ͽ�塢����γ������ˣ��������Ǥ�դ�����Ǥ��ޤ���
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ��������ʤ��˼������塢���⡢��������ʧ���ˤ���ꤷ����硢��ưŪ�˥�������ꤵ��ޤ���
</div>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����Ĺ�</td>
        <td class="Value">{$form.form_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ʬ</td>
        <td class="Value">{$form.form_trade.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_close_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ɽ�����</td>
        <td class="Value">{$form.hyoujikensuu.html}</td>
    </tr>
</table>

<br>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>    
        <td class="Title_Purple">�Ĺ�ܹ�ǯ����<font color="#ff0000">��</td></td>
        <td class="Value">{$form.form_bill_day.html}</td>
    </tr>   
</table>

<table align="right">
    <tr>    
        <td>{$form.form_show_button.html}</td>
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

{if $smarty.post.renew_flg == 1}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
{*��<b>{$var.match_count}</b>��<br>*}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">������̾</td>
        <td class="Title_Purple">������̾</td>
        <td class="Title_Purple">����Ĺ�</td>
        <td class="Title_Purple">�Ĺ�ܹ���</td>
    </tr>
{foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+$var.page_snum}</td>
        <td>{$page_data[$i][1]}<br>{$page_data[$i][2]}<br>{$page_data[$i][3]}</td>
        <td>{$page_data[$i][5]}<br>{$page_data[$i][6]}</td>
        <td align="right">{$form.form_bill_amount[$i].html}</td>
{*        <td align="center">{$form.form_bill_day[$i].html}</td>*}
        <td align="center">{$page_data[$i][10]}</td>
    </tr>
{/foreach}
    </tr>
    <tr class="Result3" align="right" style="font-weight: bold;">
        <td colspan="4">�Ĺ���</td>
        <td>{$var.total_amount|number_format}</td>
    </tr>
</table>

 {$var.html_page2}
<table align="right">
    <tr>
        <td>{$form.form_add_button.html}</td>
    </tr>
</table>

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
