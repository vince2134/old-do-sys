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
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="700">
    <tr>    
        <td>    
            <table class="Data_Table" border="1" width="430">
            <col width="90" style="font-weight: bold;">
            <col>   
                <tr>    
                    <td class="Title_Purple">���ʥ�����</td> 
                    <td class="Value">{$form.form_goods_cd.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">�Ͷ�ʬ</td> 
                    <td class="Value">{$form.form_g_goods.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">������ʬ</td> 
                    <td class="Value">{$form.form_product.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">����ʬ��</td> 
                    <td class="Value">{$form.form_g_product.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">����̾</td> 
                    <td class="Value">{$form.form_goods_name.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">ά��</td> 
                    <td class="Value">{$form.form_goods_cname.html}</td>
                </tr>   
            </table>
        </td>   
        <td valign="bottom">
            <table class="Data_Table" border="1" width="480">
            <col width="90" style="font-weight: bold;">
                <tr>    
                    <td class="Title_Purple">�߸˸¤���</td> 
                    <td class="Value">{$form.form_stock_only.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">����</td> 
                    <td class="Value">{$form.form_state.html}</td>
                </tr>   
                <tr>    
                    <td class="Title_Purple">���Ϸ���</td>
                    <td class="Value">{$form.form_output_type.html}</td>
                </tr>
                <tr>
                    <td class="Title_Purple">ɽ�����</td>
                    <td class="Value">{$form.form_display_num.html}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">{$form.form_show_button.html}����{$form.form_clear_button.html}</td>
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

<table class="Data_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div1" hdn_form="hdn_attri_div"}</td>
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div2" hdn_form="hdn_attri_div"}</td>
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div3" hdn_form="hdn_attri_div"}</td>
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div4" hdn_form="hdn_attri_div"}</td>
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div5" hdn_form="hdn_attri_div"}</td>
        <td class="Title_Purple" width="100">{Make_Sort_Link_Tpl form=$form f_name="nl_attri_div6" hdn_form="hdn_attri_div"}</td>
    </tr>
    <tr>
        <td class="Value" align="right">{$attri_div[0]}��</td>
        <td class="Value" align="right">{$attri_div[1]}��</td>
        <td class="Value" align="right">{$attri_div[2]}��</td>
        <td class="Value" align="right">{$attri_div[3]}��</td>
        <td class="Value" align="right">{$attri_div[4]}��</td>
        <td class="Value" align="right">{$attri_div[0]+$attri_div[1]+$attri_div[2]+$attri_div[3]+$attri_div[4]}��</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br>

{if $var.show_page == 2}
    ��<b>{$var.match_count}</b>��
{else}
    {$var.html_page}
{/if}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_goods_cd"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_g_goods"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_product"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_g_product"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_goods_name"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_goods_cname"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_attribute"}</td>
        <td class="Title_Purple">����Х�</td>
        <td class="Title_Purple">�߸���</td>
        <td class="Title_Purple">������</td>
    </tr>
        {foreach from=$page_data key=j item=item}
        {if $page_data[$j][11] == 't'}
        <tr class="Result5">
        {elseif $j%2 == 1}
		<tr class="Result2">
        {else}
		<tr class="Result1">
        {/if}
        <td align="right">
			{if $smarty.post.form_show_button == "ɽ����"}
				{*ɽ������*}
            	{$j+1}
            {elseif $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
            ��  {$j+1}
            {/if}
        </td>
		<td><a href="2-1-221.php?goods_id={$page_data[$j][1]}">{$page_data[$j][0]}</a></td>
        <td align="left">{$page_data[$j][5]}</td>
        <td align="left">{$page_data[$j][4]}</td>
		<td align="left">{$page_data[$j][9]}</td>
        <td>{$page_data[$j][2]}</td>
        <td>{$page_data[$j][3]}</td>
        <td align="center">{$page_data[$j][6]}</td>
        {if $page_data[$j][8] != null}
        <td align="center"><a href="#" onClick="window.open('{$var.url}{$page_data[$j][8]}')">ɽ��</a></td>
        {else}
        <td></td>
        {/if}
        <td align="center">{if $page_data[$j][10] == "1"}��{/if}</td>
        <td align="center">{$page_data[$j][7]}</td>
    </tr>
        {/foreach}
</table>
{if $var.show_page != 2}
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