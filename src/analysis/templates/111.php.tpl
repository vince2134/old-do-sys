{*
 *
 * FC�̾�����ABCʬ�ϡ�template��
 *
 *
 * ����
 *
 *  ����        ô����          ����
 *  2007-12-01  fukuda          ��������
 *
 *}

{$var.html_header}

<style TYPE="text/css">
<!--
.required {ldelim}
    font-weight: bold;
    color: #ff0000;
    {rdelim}
.bold {ldelim}
    font-weight: bold;
    {rdelim}
-->
</style>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ ���� begin +++++++++++++++*}
<table height="90%" class="M_Table">

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align="center" height="60">
        <td colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{* ���顼��å����� *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{foreach from=$form.errors item=message}
    <li>{$message}<br />
{/foreach}
</span>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

            {* ���Ϸ��� *}
            <table width="100%">
                <tr style="color: #555555;">
                    <td align="right"><b>���Ϸ���</b> {$form.form_output_type.html}</td>
                </tr>
            </table>

            {* �����ơ��֥� *}
            <table class="Data_Table" border="1" width="100%">
                <col width="120px" class="bold">
                <col width="250px">
                <col width=" 80px" class="bold">
                <col width="250px">
                <tr>
                    <td class="Title_Gray">���״���<span class="required">��</span></td>
                    <td class="Value" colspan="3">{$form.form_trade_ym_s.html} ���� {$form.form_trade_ym_e_abc.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">FC��������ʬ</td>
                    <td class="Value" colspan="3">{$form.form_rank.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">�Ͷ�ʬ</td>
                    <td class="Value">{$form.form_g_goods.html}</td>
                    <td class="Title_Gray">������ʬ</td>
                    <td class="Value">{$form.form_product.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">����ʬ��</td>
                    <td class="Value">{$form.form_g_product.html}</td>
                    <td class="Title_Gray">ɽ���о�</td>
                    <td class="Value">{$form.form_out_range.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">����о�</td>
                    <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
                </tr>
            </table>

            {* ɽ���ܥ���Ȥ� *}
            <table width="100%">
                <tr>
                    <td class="required">����ɬ�����ϤǤ�</td>
                    <td align="right">{$form.form_display.html}����{$form.form_clear.html}</td>
                </tr>
            </table>

        </td>
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{* ���ϥե饰true�� *}
{if $out_flg === true}

<table width="100%">
    <tr>
        <td>

            <table class="List_Table" border="1" width="100%">

    {********** �ơ��֥�إå� �������� **********}
                <tr class="bold" align="center">
                    <td class="Title_Gray">No.</td>
                    <td class="Title_Gray">FC�������</td>
                    <td class="Title_Gray">FC��������ʬ</td>
                    <td class="Title_Gray">���</td>
                    <td class="Title_Gray">����</td>
                    <td class="Title_Gray">�����</td>
                    <td class="Title_Gray">������</td>
                    <td class="Title_Gray">���Ѷ��</td>
                    <td class="Title_Gray">���ѹ�����</td>
                    <td class="Title_Gray">��ʬ</td>
                </tr>
    {********** �ơ��֥�إå� �����ޤ� **********}

    {********** �ơ��֥�ǡ��� �������� **********}

        {* FC��롼�� *}
        {foreach key=i from=$disp_data item=item name=data}

            {* ��׹Ի����ѤΥ��� *}
            {assign var="last" value=`$smarty.foreach.data.total-1`}

            {* ��׹� - �������Ǥ��ǽ�ޤ��ϺǸ�ξ�� *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
                <tr class="Result4">
                    <td align="right" class="bold">���</td>
                    <td align="center" class="bold">{$disp_data[$last].count|Plug_Minus_Numformat}Ź��</td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center"></td>
                </tr>
            {/if}

            {* ���ٹ� - �Ǹ�ιԤǤʤ��ܾ��׹ԤǤʤ���� *}
            {if $smarty.foreach.data.last != true && $disp_data[$i].sub_flg !== "true"}

                {if $disp_data[$i].sub_flg is not even}
                <tr class="Result1">
                {else}
                <tr class="Result2">
                {/if}

                    {* �������1����(hoge_rowspan����)�ξ�� *}
                    {if $disp_data[$i].hoge_rowspan !== null}
                        <td align="center" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].hoge_no}<br>
                        </td>
                        <td align="left" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].cd}<br>
                        {$disp_data[$i].name}<br>
                        </td>
                        <td align="left" rowspan="{$disp_data[$i].hoge_rowspan}" bgcolor="#FFFFFF">
                        {$disp_data[$i].rank_cd}<br>
                        {$disp_data[$i].rank_name}<br>
                        </td>
                    {/if}

                    <td align="right">{$disp_data[$i].piyo_no}</td>
                    <td>{$disp_data[$i].cd2}<br />{$disp_data[$i].name2|escape}<br /></td>
                    <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    {* ��ʬ - rowspan �Ѥ��ͤ������� *}
                    {if $disp_data[$i].rank != null}
                    <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
                        {$disp_data[$i].rank}<br />
                        {$disp_data[$i].rank_rate}<br />
                    </td>
                    {/if}
                </tr>

            {/if}

            {* ���׹� - �Ǹ�ιԤǤʤ������ٹԤǤʤ���� *}
            {if $smarty.foreach.data.last != true && $disp_data[$i].sub_flg === "true"}

                    <tr class="Result3">
                        <td></td>
                        <td align="center" class="bold">����</td>
                        <td align="right">{$disp_data[$i].accumulated_sale_hoge|Plug_Minus_Numformat}</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td></td>
                    </tr>

            {/if}

        {/foreach}

    {********** �ơ��֥�ǡ��� �����ޤ� **********}

            </table>

        </td>
    </tr>
</table>

{/if}
{********************* ����ɽ��2��λ ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* ����ɽ����λ ********************}

    </tr>
</table>
{******************** ���Ƚ�λ *********************}

{$var.html_footer}

