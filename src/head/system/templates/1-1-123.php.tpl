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
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>����å�̾</b></td>
        <td class="Value">����˥ƥ�����</td>
        <td class="Title_Purple" width="80"><b>�����ʬ</b></td>
        <td class="Value">�����</td>
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

<span style="font: bold 15px; color: #555555;">�������</span>��{$form.form_btn_add_keiyaku.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�в���</td>
        <td class="Title_Purple">ô����</td>
        <td class="Title_Purple">ľ����</td>
        <td class="Title_Purple">�����ȼ�</td>
        <td class="Title_Purple">�в��Ҹ�</td>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">����ñ��<br>���ñ��</td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">������<br>����</td>
        <td class="Title_Purple">����</td>
    </tr>
{foreach key=i from=$disp_data1 item=item}
{foreach key=j from=$item[7] item=goods name=count}
    <tr class="{$item[1]}">
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="center"><a href="1-1-104.php?contract_id={$item[0]}">{$i+1}</a></td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[2]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[3]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[4]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[5]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[6]}</td>
        {/if}
        <td>{$goods[0]}</td>
        <td>{$goods[1]}</td>
        <td align="right">{$goods[2]}</td>
        <td align="right">{$goods[3][0]}<br>{$goods[3][1]}</td>
        <td align="right">{$goods[4][0]}<br>{$goods[4][1]}</td>
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="right">{$item[8][0]}<br>{$item[8][1]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[9]}</td>
        {/if}
    </tr>
{/foreach}
{/foreach}
</table>
<br>

<span style="font: bold 15px; color: #555555;">��󥿥����</span>��{$form.form_btn_add_rental.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">��󥿥볫����</td>
        <td class="Title_Purple">������̾</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">��<br>����</td>
        <td class="Title_Purple">��󥿥뿽����</td>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        <td class="Title_Purple">���ꥢ��</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">��󥿥���</td>
        <td class="Title_Purple">��󥿥���</td>
        <td class="Title_Purple">����</td>
    </tr>
{foreach key=i from=$disp_data2 item=item}
{foreach key=j from=$item[9] item=goods name=count}
    <tr class="{$item[1]}">
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="center"><a href="1-1-141.php?rental_id={$item[0]}">{$i+1}</a></td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[2]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[3]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[4]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{if {$item[5] != null}��{/if}{$item[5]}<br>{$item[6]}<br>{$item[7]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[8]}</td>
        {/if}
        <td>{$goods[0]}</td>
        <td>{$goods[1]}</td>
        <td>{if $goods[2] != null}{foreach key=k from=$goods[2] item=serial}{$serial}<br>{/foreach}{/if}</td>
        <td align="right">{$goods[3]}</td>
        <td align="right">{$goods[4]}</td>
        <td align="right">{$goods[5]}</td>
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}">{$item[10]}</td>
        {/if}
    </tr>
{/foreach}
{/foreach}
</table>
<br>

<span style="font: bold 15px; color: #555555;">���������</span>��{$form.form_btn_add_hoken.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">�Ϳ�</td>
        <td class="Title_Purple">ñ��</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">���</td>
        <td class="Title_Purple">����</td>
    </tr>
    {foreach key=i from=$disp_data3[0] item=insurance name=count}
    <tr class="{$insurance[1]}">
        <td align="center"><a href="./1-1-131.php?insurance_id={$insurance[0]}">{$i+1}</a></td>
        <td>{$insurance[2]}</td>
        <td align="right">{$insurance[3]}</td>
        <td align="right">{$insurance[4]}</td>
        <td align="right">{$insurance[5]}</td>
        {if $i == 0}
        <td class="Result1" rowspan="{$smarty.foreach.count.total}" align="right">{$disp_data3[1]}</td>
        <td class="Result1" rowspan="{$smarty.foreach.count.total}">{$disp_data3[2]}</td>
        {/if}
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
