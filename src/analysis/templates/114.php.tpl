{*
 *
 * ô������ABCʬ�ϡ�������FC�ˡ�template��
 *
 *
 * ����
 *
 *  ����        ô����          ����
 *  2007-11-23  fukuda          ��������
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
                <col width="100px" class="bold">
                <col width="600px">
                <tr>
                    <td class="Title_Gray">���״���<span class="required">��</span></td>
                    <td class="Value" colspan="3">{$form.form_trade_ym_s.html} ���� {$form.form_trade_ym_e_abc.html}</td>
                </tr>
                {* FC��ǽ�� *}
                {if $smarty.session.group_kind !== "1"}
                <tr>
                    <td class="Title_Gray">��°�ܻ�Ź</td>
                    <td class="Value" colspan="3">{$form.form_branch.html}</td>
                </tr>
                <tr>
                    <td class="Title_Gray">����</td>
                    <td class="Value" colspan="3">{$form.form_part.html}</td>
                </tr>
                {/if}
                <tr>
                    <td class="Title_Gray">ɽ���о�</td>
                    <td class="Value">{$form.form_out_range.html}</td>
                </tr>
                {* ������ǽ�� *}
                {if $smarty.session.group_kind === "1"}
                <tr>
                    <td class="Title_Gray">����о�</td>
                    <td class="Value" colspan="3">{$form.form_out_abstract.html}</td>
                </tr>
                {/if}
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
                    <td class="Title_Gray">���</td>
                    <td class="Title_Gray">ô����</td>
                    <td class="Title_Gray">�����</td>
                    <td class="Title_Gray">������</td>
                    <td class="Title_Gray">���Ѷ��</td>
                    <td class="Title_Gray">���ѹ�����</td>
                    <td class="Title_Gray">��ʬ</td>
                </tr>
    {********** �ơ��֥�إå� �����ޤ� **********}

    {********** �ơ��֥�ǡ��� �������� **********}

        {* ô������롼�� *}
        {foreach key=i from=$disp_data item=item name=data}

            {* ��׹Ի����ѤΥ��� *}
            {assign var="last" value=`$smarty.foreach.data.total-1`}

            {* ��׹� - �������Ǥ��ǽ�ޤ��ϺǸ�ξ�� *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}
                <tr class="Result3">
                    <td align="center" class="bold">���</td>
                    <td align="center" class="bold">{$disp_data[$last].count|Plug_Minus_Numformat}��</td>
                    <td align="right">{$disp_data[$last].sum_sale|Plug_Minus_Numformat}</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center"></td>
                </tr>
            {/if}

            {* ���ٹ� - �������ǤκǸ�ιԤǤʤ���� *}
            {if $smarty.foreach.data.last != true}
                <tr class="{cycle values="Result1, Result2"}">
                    <td align="right">{$disp_data[$i].no}</td>
                    <td>{$disp_data[$i].cd}<br />{$disp_data[$i].name|escape}<br /></td>
                    <td align="right">{$disp_data[$i].net_amount|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].sale_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                    <td align="right">{$disp_data[$i].accumulated_sale|Plug_Minus_Numformat}</td>
                    <td align="right">{$disp_data[$i].accumulated_rate|Plug_Minus_Numformat:2:true|Plug_Unit_Add:"%"}</td>
                {* ��ʬ - rowspan �Ѥ��ͤ������� *}
                {if $disp_data[$i].rank != null}
                    {* A, B, C ��˶�ʬ���طʿ����դ��Ƥߤ� *}
<!-- aizawa-m �طʿ��ѹ��Τ��ᥳ����
                    {if $disp_data[$i].rank == "A"}{assign var="abc_bgcolor" value="#a8d3ff"}{/if}
                    {if $disp_data[$i].rank == "B"}{assign var="abc_bgcolor" value="#ffffa8"}{/if}
                    {if $disp_data[$i].rank == "C"}{assign var="abc_bgcolor" value="#ffa8d3"}{/if}
                    <td bgcolor="{$abc_bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
-->
                    <td bgcolor="{$disp_data[$i].bgcolor}" align="center" rowspan="{$disp_data[$i].span}">
                        {$disp_data[$i].rank}<br />
                        {$disp_data[$i].rank_rate}<br />
                    </td>
                {/if}
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

