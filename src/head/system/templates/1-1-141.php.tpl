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
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" height="35" width="450">
    <tr>
        <td class="Title_Purple" width="130"><b>����å�̾</b></td>
        <td class="Value">{$form.form_fshop_select.html}</td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">����ô����</td>
        <td class="Value">{$form.form_shinsei_tantou_select.html}</td>
        <td class="Title_Purple">���ô����</td>
        <td class="Value">{$form.form_junkai_tantou_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾</td>
        <td class="Value">{$form.form_name.html}</td>
        <td class="Title_Purple">������TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����ͽ���</td>
        <td class="Value" colspan="3">{$form.form_post.html}<br>{$form.form_address1.html}<br>{$form.form_address2.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">��󥿥뿽����</td>
        <td class="Value" colspan="3">{$form.form_moushikomi_date.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��󥿥�в���</td>
        <td class="Value">{$form.form_syukka_date.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����ô����</td>
        <td class="Value">{$form.form_honbu_tantou_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value">{$form.form_note.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value">2006ǯ {$form.form_seikyu_month_select.html} ���{if $form.form_seikyu_date_static.html != null}����� {$form.form_seikyu_date_static.html}{/if}</td>
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

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">���ʥ�����</td>
        <td class="Title_Purple">����̾</td>
        {if $var.state != null}<td class="Title_Purple">����</td>{/if}
        <td class="Title_Purple">����</td>
        {if $var.state == "non_req" && $var.fshop_network == "off"}<td class="Title_Purple">����</td>{/if}
        {if $var.state == "non_req" && $var.fshop_network == "off"}<td class="Title_Purple">�����</td>{/if}
        {if $var.state == "chg_req"}<td class="Title_Purple">��������</td>{/if}
        {if $var.state == "non_req" || $var.state == "chg_req"}<td class="Title_Purple">������</td>{/if}
        <td class="Title_Purple">���ꥢ��</td>
        <td class="Title_Purple">��󥿥�ñ��<br>�����������</td>
        <td class="Title_Purple">�桼����ñ��<br>�������������</td>
    </tr>
{* ������Ͽ���ʥ��ե饤��� *}
    {if $var.state == null}
    {foreach key=i from=$disp_goods_data item=goods}
    <tr class="{$goods[0]}">
        <td align="right">{$i+1}</td>
        <td>{$form.form_goods_cd[$i].html}</td>
        <td>{$form.form_goods_name[$i].html}</td>
        <td align="right">{$form.form_goods_num[$i].html}</td>
        <td>{foreach key=j from=$goods[4] item=serial}{if $serial != ""}{$form.form_serial[$i][$j].html}<br>{/if}{/foreach}</td>
        <td align="right">{$form.form_rental_price[$i].html}<br>{$form.form_rental_amount[$i].html}</td>
        <td align="right">{$form.form_user_price[$i].html}<br>{$form.form_user_amount[$i].html}</td>
    </tr>
    {/foreach}
    {/if}
{* ��������ʥ��ե饤��� *}
    {if $var.state == "non_req" && $var.fshop_network == "off"}
    {foreach key=i from=$disp_goods_data item=goods}
    {foreach key=j from=$goods[4] item=serial_item name=serial_item_count}
    <tr class="{$goods[0]}">
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$i+1}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[1]}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[2]}</td>
        {/if}
        <td align="center"{if $serial_item[0] == "������"} style="color: #0000ff;"{/if}>{$serial_item[0]}</td>
        <td align="right">{$serial_item[1]}</td>
        <td align="center">{$form.form_kaiyaku_check[$i][$j].html}</td>
        <td align="right">{$form.form_kaiyaku_num[$i][$j].html}</td>
        <td align="center">{$serial_item[2]}</td>
        <td>{if $serial_item[3] != "-"}{$form.form_serial[$i][$j].html}{else}{$serial_item[3]}{/if}</td>
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$form.form_rental_price[$i].html}<br>{$goods[5][1]}</td>
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$form.form_user_price[$i].html}<br>{$goods[6][1]}</td>
        {/if}
    </tr>
    {/foreach}
    {/foreach}
    {/if}
{* �����������ʥ���饤��� *}
    {if $var.state == "new_req"}
    {foreach key=i from=$disp_goods_data item=goods}
    {foreach key=j from=$goods[3] item=serial_item name=serial_item_count}
    <tr class="{$goods[0]}">
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$i+1}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[1]}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[2]}</td>
        {/if}
        <td align="center" style="color: #0000ff;">��������</td>
        <td align="right">{$serial_item[0]}</td>
        <td>{if $serial_item[1] != "-"}{$form.form_serial[$i][$j].html}{else}{$serial_item[1]}{/if}</td>
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$form.form_rental_price[$i].html}<br>{$goods[4][1]}</td>
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[5][0]}<br>{$goods[5][1]}</td>
        {/if}
    </tr>
    {/foreach}
    {/foreach}
    {/if}
{* ��������ʥ���饤��� *}
    {if $var.state == "non_req" && $var.fshop_network == "on"}
    {foreach key=i from=$disp_goods_data item=goods}
    {foreach key=j from=$goods[4] item=serial_item name=serial_item_count}
    <tr class="{$goods[0]}">
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$i+1}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[1]}</td>
        {/if}
        <td>{$form.form_goods_name[$i].html}</td>
        <td align="center"{if $serial_item[0] == "������"} style="color: #0000ff;"{/if}>{$serial_item[0]}</td>
        <td align="right">{$serial_item[1]}</td>
        <td align="center">{$serial_item[2]}</td>
        <td>{if $serial_item[0] == "�����" || $serial_item[3] == "-"}{$serial_item[3]}{else}{$form.form_serial[$i][$j].html}{/if}</td>
        {if $j == 0 || $j >= $goods[3]}
        <td align="right"{if $j == 0} rowspan="{$goods[3]}"{/if}>{if $j == 0}{$form.form_rental_price[$i].html}<br>{$goods[5][1]}{/if}</td>
        <td align="right"{if $j == 0} rowspan="{$goods[3]}"{/if}>{if $j == 0}{$goods[6][0]}<br>{$goods[6][1]}{/if}</td>
        {/if}
    </tr>
    {/foreach}
    {/foreach}
    {/if}
{* ���������ʥ���饤��� *}
    {if $var.state == "chg_req"}
    {foreach key=i from=$disp_goods_data item=goods}
    {foreach key=j from=$goods[4] item=serial_item name=serial_item_count}
    <tr class="{$goods[0]}">
        {if $j == 0}
        <td align="right" rowspan="{$smarty.foreach.serial_item_count.total}">{$i+1}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[1]}</td>
        <td rowspan="{$smarty.foreach.serial_item_count.total}">{$goods[2]}</td>
        {/if}
        <td align="center"{if $serial_item[0] == "������"} style="color: #0000ff;"{elseif $serial_item[0] == "������"} style="color: #ff0000;"{/if}>{$serial_item[0]}</td>
        <td align="right">{$serial_item[1]}</td>
        <td align="right" style="color: #ff0000;">{$serial_item[2]}</td>
        <td align="center">{$serial_item[3]}</td>
        <td>{if $serial_item[0] == "�����" || $serial_item[4] == "-"}{$serial_item[4]}{else}{$form.form_serial[$i][$j].html}{/if}</td>
        {if $j == 0 || $j >= $goods[3]}
        <td align="right"{if $j == 0} rowspan="{$goods[3]}"{/if}>{if $j == 0}{$form.form_rental_price[$i].html}<br>{$goods[5][1]}{/if}</td>
        <td align="right"{if $j == 0} rowspan="{$goods[3]}"{/if}>{if $j == 0}{$goods[6][0]}<br>{$goods[6][1]}{/if}</td>
        {/if}
    </tr>
    {/foreach}
    {/foreach}
    {/if}
</table>

<table align="right">
    <tr>
        <td>{if $var.state == null}{$form.form_add_button.html}����{elseif $var.state == "non_req" && $var.fshop_network == "off"}{$form.form_chg_off_button.html}����{elseif $var.state == "new_req"}{$form.form_new_accept_button.html}����{elseif $var.state == "non_req" && $var.fshop_network == "on"}{$form.form_chg_on_button.html}����{elseif $var.state == "chg_req"}{$form.form_chg_accept_button.html}����{/if}{$form.form_back_button.html}</td>
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
