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

{* ��Ͽ���ѹ���λ��å��������� *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>
{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_bank_select.error != null}<li>{$form.form_bank_select.error}<br>{/if}
{if $form.form_b_bank_cd.error != null}<li>{$form.form_b_bank_cd.error}<br>{/if}
{if $form.form_b_bank_name.error != null}<li>{$form.form_b_bank_name.error}<br>{/if}
{if $form.form_b_bank_kana.error != null}<li>{$form.form_b_bank_kana.error}<br>{/if}
{if $form.form_bank_cname.error != null}<li>{$form.form_bank_cname.error}<br>{/if}
{if $form.form_post.error != null}<li>{$form.form_post.error}<br>{/if}
{*{if $form.form_account_no.error != null}<li>{$form.form_account_no.error}<br>{/if}*}
{if $form.form_tel.error != null}<li>{$form.form_tel.error}<br>{/if}
{if $form.form_fax.error != null}<li>{$form.form_fax.error}<br>{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">���̾</td>
        <td class="Value" colspan="3">{$form.form_bank_select.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��Ź������<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_b_bank_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��Ź̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_b_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��Ź̾<br>�ʥեꥬ�ʡ�<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_b_bank_kana.html}</td>
    </tr>
{*
    <tr>
        <td class="Title_Purple">���¼���</td>
        <td class="Value">{$form.form_account_kind.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ֹ�</td>
        <td class="Value">{$form.form_account_no.html}</td>
    </tr>
*}
    <tr>
        <td class="Title_Purple">͹���ֹ�</td>
        <td class="Value">{$form.form_post.html}����{$form.input_button.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>����1</td>
        <td class="Value">{$form.form_address1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����2</td>
        <td class="Value">{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����3</td>
        <td class="Value">{$form.form_address3.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FAX</td>
        <td class="Value">{$form.form_fax.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ɽ��</td>
        <td class="Value">{$form.form_nondisp_flg.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.entry_button.html}����{$form.clear_button.html}</td>
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
<table width="100%">
    <tr>
        <td>

��<b>{$var.total_count}</b>�{$form.csv_button.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">��ԥ�����</td>
        <td class="Title_Purple">���̾</td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">��Ź������</td>
        <td class="Title_Purple">��Ź̾</td>
        <td class="Title_Purple">��Ź̾<br>�ʥեꥬ�ʡ�</td>
        <td class="Title_Purple">��ɽ��</td>
        <td class="Title_Purple">����</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class={$tr[$j]}> 
        <td align="right">{$j+1}</td>
        <td>{$row[$j][0]}</td>
        <td>{$row[$j][1]}</td>
        <td>{$row[$j][2]}</td>
        <td>{$row[$j][4]}</td>
        <td><a href="1-1-208.php?b_bank_id={$row[$j][3]}">{$row[$j][5]}</a></td>
        <td>{$row[$j][6]}</td>
        <td align="center">{$row[$j][7]}</td>
        <td>{$row[$j][8]}</td>
    </tr>   
    {/foreach}
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
    

