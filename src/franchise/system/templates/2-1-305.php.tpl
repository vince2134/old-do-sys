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
{* ���顼��å��������� *} 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_close_day.error != null}
        <li>{$form.form_close_day.error}<br>
    {/if}   
    {if $form.form_set_error.error != null}
        <li>{$form.form_set_error.error}<br>
    {/if}   
    {if $var.add_msg != null}
        <b><font color="blue"><li>{$var.add_msg}</font></b><br>
    {/if}   
    </span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="350">
    <tr>
        <td>
<div style="text-align: left; font: bold; color: #3300ff;">
    ���ܻĹ�������ϳ���������Ͽ�塢����γ������ˣ��������Ǥ�դ�����Ǥ��ޤ���
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ��������ʤ��˼������塢���⡢��������ʧ���ˤ���ꤷ����硢��ưŪ�˥�������ꤵ��ޤ���
</div>

<table border="1" class="Data_Table" width="100%">
<col width="80" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_state_radio.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�϶�</td>
        <td class="Value">{$form.form_area.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�Ĺ�����</td>
        <td class="Value">{$form.form_zandaka_radio.html}</td>
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

{if $smarty.post.show_button_flg == true}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
    <tr>
        <td class="Title_Purple" width="120"><b>�Ĺ�ܹ�ǯ����<font color="#ff0000">��</font></b></td>
        <td class="Value">{$form.form_close_day.html}</td>
    </tr>
</table>
<br>

��<b>{$var.match_count}</b>��<br>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����襳����</td>
        <td class="Title_Purple">������̾1</td>
        <td class="Title_Purple">������̾2</td>
        <td class="Title_Purple">��ݻĹ�</td>
        <td class="Title_Purple">�Ĺ�ܹ���</td>
    </tr>
    {foreach from=$show_data item=item key=i}
    {if $show_data[$i][8] == 't'}
    <tr class="Result1" style="font-weight: bold; color: blue;">
    {elseif $show_data[$i][8] == 'f'}
    <tr class="Result1" style="color: green;">
    {else}
    <tr class="Result1">
    {/if}
        <td align="right">{$i+1}</td>
        <td>{$show_data[$i][1]}-{$show_data[$i][2]}</td>
        <td>{$show_data[$i][3]}</td>
        <td>{$show_data[$i][4]}</td>
        <td align="center">{$form.form_init_cbln[$i].html}</td>
        <td>{$show_data[$i][7]}</td>
    </tr>
    {/foreach}
    <tr class="Result3" align="right" style="font-weight: bold;">
        <td colspan="4">�Ĺ���</td>
        <td>{$form.static_sum.html}</td>
        <td></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_entry_button.html}</td>
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
