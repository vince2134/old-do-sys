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
{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{* ���顼��å��������� *} 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_shop_gcd.error == null && $form.form_shop_gname.error == null && $form.form_rank.error == null}
        <li>{$var.message}<br>
    {/if}
    </span>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_shop_gcd.error != null}
        <li>{$form.form_shop_gcd.error}<br>
    {/if}
    {if $form.form_shop_gname.error != null}
        <li>{$form.form_shop_gname.error}<br>
    {/if}
    {if $form.form_rank.error != null}
        <li>{$form.form_rank.error}<br>
    {/if}
    </span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="450">
    <tr>
        <td>

<table class="Data_Table" border="2" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">FC���롼�ץ�����<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_shop_gcd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC���롼��̾<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_shop_gname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC��������ʬ<font color="#ff0000">��</font></td>
        <td class="Value">{$form.form_rank.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_shop_gnote.html}</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">{$form.form_entry_button.html}����{$form.form_clear_button.html}</td>
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

��<b>{$var.total_count}</b>�{$form.form_csv_button.html}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">FC���롼�ץ�����</td>
        <td class="Title_Purple">FC���롼��̾</td>
        <td class="Title_Purple">�ܼ�</td>
        <td class="Title_Purple">����åץ�����</td>
        <td class="Title_Purple">����å�̾</td>
    </tr>
    {*1����*}
{foreach from=$page_data item=item key=i}
    <tr class="Result1">
        <td align="right">{$i+1}</td>
        <td><a href=?shop_gid={$item[1]}>{$item[0]}</a></td>
        <td>{$item[5]}</a></td>
        <td align="center">{$item[2]}</td>
        <td>{$item[3]}</td>
        <td>{$item[4]}</td>
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
