{$var.html_header}

<script language="javascript">
   {$var.order_delete}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{if $form.form_pay_day.error != null}
    <li>{$form.form_pay_day.error}<br>
{/if}
{if $form.form_sum_amount.error != null}
    <li>{$form.form_sum_amount.error}<br>
{/if}
{if $form.form_input_day.error != null}
    <li>{$form.form_input_day.error}<br>
{/if}
{if $form.form_account_day.error != null}
    <li>{$form.form_account_day.error}<br>
{/if}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>
{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_payout_day"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_input_day"}<br>
        </td>
        <td class="Title_Blue">�����ʬ</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_bank_name"}<br>
        </td>   
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_b_bank_name"}<br>
        </td>   
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_deposit_kind"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_account_no"}<br>
        </td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Blue">��ʧ���</td>
        <td class="Title_Blue">�����</td>
        <td class="Title_Blue">��׶��</td>
        <td class="Title_Blue">�����<br>��������ֹ�</td>
        <td class="Title_Blue">����</td>
        <td class="Title_Blue">��������</td>
        <td class="Title_Blue">���</td>
    </tr>
    <tr class="Result3" height="30px">
        <td><b>���</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {*��ʧ��۹��*}
        {if $var.sum1<0}<td align="right"><font color="#ff0000">{$var.sum1|number_format}</font></td>
        {else}<td align="right">{$var.sum1|number_format}</td>{/if}
        {*��������*}
        <td align="right">{$var.sum2|number_format}</td>
        {*����*}
        {if $var.sum3<0}<td align="right"><font color="#ff0000">{$var.sum3|number_format}</font></td>
        {else}<td align="right">{$var.sum3|number_format}</td>{/if}
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    {* �ǡ�����ɽ������ޤ�*}
    {foreach from=$row key=j item=item}
    {if bcmod($j, 2) == 0}
    <tr class="Result1">
    {else}  
    <tr class="Result2">
    {/if}
        {*NO.*}
        <td align="right">
        {if $smarty.post.form_display == "ɽ����"}
             {*ɽ������*}
             {$j+1}
        {elseif $smarty.post.f_page1 != null}
            {if $var.r == 10}
                {$smarty.post.f_page1*10+$j-9}
            {elseif $var.r == 50}
                {$smarty.post.f_page1*50+$j-49}
            {elseif $var.r == 100}
                {$smarty.post.f_page1*100+$j-99}
            {else}
                {$j+1}
            {/if}
        {else if}
                {$j+1}
            {/if}
        </td>
        {*��ʧ�ֹ�*}
        <td align="center"><a href="2-3-302.php?pay_id={$item[0]}">{$item[1]}</a></td>
        {*�������Ȼ�ʧ��*}
        <td align="center">{$item[3]}<br>{$item[2]}</td>
        {*�����ʬ*}
        <td align="center">{$item[4]}</td>
        {*��ԥ����ɤȶ��̾*}
        <td>{$item[5]}<br>{$item[6]}</td>
        {*��Ź�����ɤȻ�Ź̾*}
        <td>{$item[7]}<br>{$item[8]}</td>
        {*���¼��ܤȸ����ֹ�*}
        <td>{$item[9]}<br>{$item[10]}</td>
        {*��ʧ�����ɤȻ�ʧ��*}
        {if $item[13] != null}
            <td>{$item[12]}-{$item[13]}<br>{$item[11]}</td>
        {else}
            <td>{$item[12]}<br>{$item[11]}</td>
        {/if}        
        {*��ʧ���*}
        {if $item[14]<0}
            <td align="right"><font color="#ff0000">{$item[14]|number_format}</font></td>
        {else}
            <td align="right">{$item[14]|number_format}</td>
        {/if}
        {*�����*}
        <td align="right">{$item[15]|number_format}</td>
        {*��׶��*}
        {if $item[15] != 0}
            {if $item[16] < 0}
                <td align="right"><font color="#ff0000">{$item[16]|number_format}</font></td>
            {else}
                <td align="right">{$item[16]|number_format}</td>{/if}
        {else}
             {if $item[14]<0}
                <td align="right"><font color="#ff0000">{$item[14]|number_format}</font></td>
             {else}
                <td align="right">{$item[14]|number_format}</td>{/if}
        {/if}
        {*�����/��������ֹ�*}
        <td>{$item[21]}<br>{$item[22]}<br></td>
        {*����*}
        <td>{$item[17]}</td>
        {*��������*}
        {if $item[18]=='t'}
        <td align="center">{$item[19]}</td>
        <td></td>
        {else}
        <td align="center"></td>
        {*���*}
        <td align="center">{if $item[20] == null}{if $var.auth == "w"}<a href="#" onClick="Order_Delete('data_delete_flg','pay_h_id','{$item[0]}');">���</a>{/if}{/if}</td>
        {/if}
    </tr>
    {/foreach}
    <tr class="Result3" height="30px">
        <td><b>���</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        {*��ʧ��۹��*}
        {if $var.sum1<0}<td align="right"><font color="#ff0000">{$var.sum1|number_format}</font></td>
        {else}<td align="right">{$var.sum1|number_format}</td>{/if}
        {*��������*}
        <td align="right">{$var.sum2|number_format}</td>
        {*����*}
        {if $var.sum3<0}<td align="right"><font color="#ff0000">{$var.sum3|number_format}</font></td>
        {else}<td align="right">{$var.sum3|number_format}</td>{/if}
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
{$var.html_page2}

        </td>
    </tr>
</table>

{/if}

</form>
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
