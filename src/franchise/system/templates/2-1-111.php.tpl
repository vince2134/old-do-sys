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
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="850">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">���Ϸ���</td>
        <td class="Value">{$form.form_output_type.html}</td>
        <td class="Title_Purple">ɽ�����</td>
        <td class="Value">{$form.form_show_page.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Purple">������̾��ά��</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
{*ľ�İʳ��Υ���åפǤ�ɽ�����ʤ�*}
    {if $smarty.session.group_kind == '2'}
    <tr>
        <td class="Title_Purple">��Զȼԥ�����</td>
        <td class="Value">{$form.form_trust.html}</td>
        <td class="Title_Purple">��Զȼ�̾��ά��</td>
        <td class="Value">{$form.form_trust_name.html}</td>
    </tr>
    {/if}
    <tr>
        <td class="Title_Purple">�϶�</td>
        <td class="Value">{$form.form_area_id.html}</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">����ô����1</td>
        <td class="Value">{$form.form_c_staff_id1.html}</td>
        <td class="Title_Purple">���ô����</td>
        <td class="Value">{$form.form_con_staff.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value" colspan="3">{$form.form_state.html}</td>
{*
        <td class="Title_Purple">ɽ����</td>
        <td class="Value" colspan="3">{$form.form_turn.html}</td>
*}
    </tr>
</table>

<table width="850" >
    <tr>
        <td align="right">{$form.form_button.show_button.html}����{$form.form_button.clear_button.html}</td>
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

{if $var.display_flg == true}
<table width="100%">
    <tr>
        <td>

{*
{if $smarty.post.form_show_page == 2 && $smarty.post.form_button.show_button == "ɽ����"}
    {if $var.state_type != null}
        ������֡�����{$var.state_type}<br>��{$var.match_count}��
    {else}
        ��{$var.match_count}��
    {/if}        
{else}
    {if $var.state_type != null}
    ������֡�����{$var.state_type}
    {/if}
    {$var.html_page}
{/if}
*}

{if $smarty.post.form_show_page != 2 }
{$var.html_page}
{else}
��<b>{$var.match_count}</b>��
{/if}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Purple">ά��</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_area"}</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_staff_cd"}</td>
        <td class="Title_Purple">�������</td>
        <td class="Title_Purple">���ô����</td>
{*ľ�İʳ��Υ���åפǤ�ɽ�����ʤ�*}
    {if $smarty.session.group_kind == '2'}
        <td class="Title_Purple">����襳����<br>�����̾</td>
    {/if}
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {*ɽ���ܥ��󤬲������줿���NO��1���饫�����*}
            {if $smarty.post.form_button.show_button == "ɽ����"}
                {$j+1}
            {*��������ѹ��ˤ�äƥڡ��������ä����*}
            {elseif $var.page_change == true}
                {$smarty.post.f_page1*100+$j-199}
            {elseif $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
                {$j+1}
            {/if}
        </td>               
        <td>
            {$row[$j].client_cd1}-{$row[$j].client_cd2}<br>
            <a href="2-1-115.php?client_id={$row[$j].client_id}&get_flg=con">{$row[$j].client_name}</a></td>
        </td>
        <td>{$row[$j].client_cname}</td>
        <td>{$row[$j].area_name}</td>
        <td>{$row[$j].tel}</td>
        <td>{$row[$j].charge_cd}<br>{$row[$j].staff_name}</td>
        <td>{$row[$j].state}</td>
        <td>{$row[$j].staff2}</td>
{*ľ�İʳ��Υ���åפǤ�ɽ�����ʤ�*}
    {if $smarty.session.group_kind == '2'}
        <td>{$row[$j].trust}</td>
    {/if}
    </tr>
    {/foreach}
</table>
{if $smarty.post.form_show_page != 2 }
{$var.html_page2}
{/if}

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
