
{$var.html_header}
<script language="javascript">{$var.code_value} </script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {*- ���̥����ȥ볫�� -*} {$var.page_header} {*- ���̥����ȥ뽪λ -*}
        </td>
    </tr>

    <tr align="center">
    
        {*--------------------- ����ɽ������ --------------------*}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>
</form>
{*--------------------- ����ɽ��1���� --------------------*}
{* ɽ�����¤Τ߻��Υ�å����� *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
<form {$form.attributes}>
<table width=450>
    <tr>
        <td align="right">
            {if $smarty.get.goods_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>
<table border="0">
<tr valign="top">
<td>
<table class="Data_Table" border="1" width="350" align="left">
{if $smarty.session.group_kind == '2'}
    <tr>
        <td class="Title_Purple"><b>����</b></td>
        <td class="Value">{$form.form_state_type.html}</td>
    </tr>
{/if}
    <tr>
        <td class="Title_Purple" width="100"><b>�����ʥ�����</b></td>
        <td class="Value">{$form.form_goods_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>������̾</b></td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>ά��</b></td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>ñ��</b></td>
        <td class="Value">{$form.form_unit.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>���Ƕ�ʬ</b></td>
        <td class="Value">{$form.form_tax_div.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>��̾�ѹ�</b></td>
        <td class="Value">{$form.form_name_change.html}</td>
    </tr>

</table>

<table class="Data_Table" border="1" width="290">
    {foreach from=$form.form_rank_price item=item key=i name=price}
    <tr>
        <td class="Title_Purple" width="110"><b>{$form.form_rank_price[$i].label}</b></td>

        <td class="Value" align="right">{$form.form_rank_price[$i].html}</td>
    </tr>   
    {/foreach}
</table>

<tr valign="top">

<table width="450">
    <tr>
        <td align="left">
        </td>
    </tr>
</table>
</td>
</tr>

{*-******************** ����ɽ��1��λ *******************-*}

                    </td>
                </tr>

                <tr>
                    <td>

{*--------------------- ����ɽ��2���� --------------------*}
<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple"><b>No.</b></td>
        <td class="Title_Purple"><b>���ʥ�����</b></td>
        <td class="Title_Purple"><b>����̾</b></td>
        <td class="Title_Purple"><b>����ñ��</b></td>
        <td class="Title_Purple"><b>����</b></td>
        <td class="Title_Purple"><b>�������</b></td>
    </tr>
{$var.html}
{$form.hidden}

{*-******************** ����ɽ��2��λ *******************-*}

                    </td>
                </tr>
            </table>
        </td>
        {*-******************** ����ɽ����λ *******************-*}

    </tr>
</table>

{*-******************* ���Ƚ�λ ********************-*}

{$var.html_footer}
