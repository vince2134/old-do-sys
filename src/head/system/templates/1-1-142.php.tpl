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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
	<tr>
        <td class="Title_Purple">���Ϸ���</td>
        <td class="Value" colspan="3">{$form.form_output_radio.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value" colspan="3">{$form.form_state_check.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��󥿥��ֹ�</td>
        <td class="Value" colspan="3">{$form.form_rental_no.html}</td>
    <tr>
        <td class="Title_Purple">����åץ�����</td>
        <td class="Value">{$form.form_shop_cd.html}</td>
        <td class="Title_Purple">����å�̾</td>
        <td class="Value">{$form.form_shop_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Value">{$form.form_goods_cd.html}</td>
        <td class="Title_Purple">����̾</td>
        <td class="Value">{$form.form_goods_name.html}</td>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}��{$form.form_clear_button.html}</td>
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
<table class="Data_Table" border="1" width="100%">
    <tr>
        <td bgcolor="#ffbbc3" width="90" align="center"><b>����å׿�</b></td>
        <td class="Value" width="*">{$head[0]}</a></td>
        <td bgcolor="#ffbbc3" width="120" align="center"><b>��󥿥����</b></td>
        <td class="Value" width="100" align="right">{$head[1]}</td>
        <td bgcolor="#ffbbc3" width="120" align="center"><b>��󥿥����</b></td>
        <td class="Value" width="100" align="right">{$head[2]}</td>
        <td bgcolor="#ffbbc3" width="140" align="center"><b>�桼�������</b></td>
        <td class="Value" width="100" align="right">{$haed[3]}</td>
    </tr>
</table>
<br><br>

{$var.html}

{foreach key=i from=$disp_data item=shop}

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Type" width="90" align="center"><b>����å�̾</b></td>
        <td class="Value" width="*">{$shop[0]}</a></td>
        <td class="Type" width="120" align="center"><b>��󥿥��׿�</b></td>
        <td class="Value" width="100" align="right">{$shop[1]}</td>
        <td class="Type" width="120" align="center"><b>��󥿥��׳�</b></td>
        <td class="Value" width="100" align="right">{$shop[2]}</td>
        <td class="Type" width="140" align="center"><b>�桼���󶡹�׳�</b></td>
        <td class="Value" width="100" align="right">{$shop[3]}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">������</td>
        <td class="Title_Purple">�в���</td>
        <td class="Title_Purple">������</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">����̾</td> 
        <td class="Title_Purple">����</td> 
        <td class="Title_Purple">���ꥢ��</td> 
        <td class="Title_Purple">��󥿥�ñ��<br>�����������</td> 
        <td class="Title_Purple">�桼����ñ��<br>�������������</td> 
        <td class="Title_Purple">����</td> 
    </tr>
    {foreach key=j from=$shop[4] item=rental}
    {foreach key=k from=$rental[2] item=rental_h_data name=rental_h_data_count}
    {foreach key=l from=$rental_h_data[3] item=goods name=goods_count}
    <tr class="{$rental[0]}">
        {if $k == 0 && $l == 0}
        <td rowspan="{$disp_count[$i][$j]}" align="center">{$j+1}</td>
        <td rowspan="{$disp_count[$i][$j]}" align="center">{$rental[1]}</td>
        {/if}
        {if $l == 0}
        <td rowspan="{$smarty.foreach.goods_count.total}" align="center">
{*            <a href="{if $rental_h_data[0] != null}./1-1-141-2.php?rental_id={$rental_h_data[0]}{else}./1-1-141.php?rental_id={$rental_h_data[0]}&state=shinkiirai{/if}">{$rental_h_data[1]}</a>*}
            <a href="./1-1-141.php?rental_h_id={$rental_h_data[0]}&state={$rental_h_data[1]}">{$rental_h_data[2]}</a>
        </td>
        {/if}
        <td align="center">{$goods[0]}</td>
        <td align="center"{if $goods[1] == "������"} style="color: #0000ff;"{elseif $goods[1] == "�����"}{else} style="color: #ff0000;"{/if}>{$goods[1]}</a></td>
        <td>{$goods[2]}</td>
        <td align="right">{$goods[3]}</td>
        <td>{$goods[4]}</td>
        <td align="right">{$goods[5][0]}<br>{$goods[5][1]}</td>
        <td align="right">{$goods[6][0]}<br>{$goods[6][1]}</td>
        <td>{$goods[7]}</td>
    </tr>
    {/foreach}
    {/foreach}
    {/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_back_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{/foreach}
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
