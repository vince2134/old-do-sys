{*
 *
 * ���Ķ����ӡ�������FC�ˡ�template��
 *
 *
 * ����
 *
 *  ����        ô����          ����
 *  2007-11-17  fukuda          ��������
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

<table width="100%">
    <tr style="color: #555555;">
        <td align="right"><b>���Ϸ���</b> {$form.form_output_type.html}</td>
    </tr>
</table>

<table class="Data_Table" border="1" width="100%">
{* ������ *}
{if $smarty.session.group_kind === "1"}
<col width="120px" class="bold">
{* FC�� *}
{else}
<col width=" 80px" class="bold">
{/if}
<col width="300px">
<col width=" 80px" class="bold">
<col width="300px">
    <tr>
        <td class="Title_Gray">���״���<span class="required">��</span></td>
        <td class="Value" colspan="3">{$form.form_trade_ym_s.html} ���� {$form.form_trade_ym_e.html}</td>
    </tr>
    <tr>
        {* ������ *}
        {if $smarty.session.group_kind === "1"}
        <td class="Title_Gray">����åס�����</td>
        <td class="Value" colspan="3">{$form.form_shop_part.html}</td>
        {* FC�� *}
        {else}
        <td class="Title_Gray">����</td>
        <td class="Value">{$form.form_part.html}</td>
        <td class="Title_Gray">ô����</td>
        <td class="Value">{$form.form_staff.html}</td>
        {/if}
    </tr>
    <tr>
        <td class="Title_Gray">����Ψ</td>
        <td class="Value">{$form.form_margin.html}</td>
        <td class="Title_Gray">ɽ���о�</td>
        <td class="Value">{$form.form_out_range.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td class="required">����ɬ�����ϤǤ�</td>
        <td align="right">{$form.form_display.html}����{$form.form_clear.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

<br />
{*--------------- ����ɽ���� e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}

{* ɽ���ܥ��󲡲��� *}
{if $out_flg === "true"}

<table width="100%">
    <tr>
        <td>

            {* ������ǽ�ξ��ϡ����򤵤줿����å�̾����Ϥ��� *}
            {if $smarty.session.group_kind === "1"}
            <span style="font: bold 15px; color: #555555;">{$shop_data|escape}</span><br />
            {/if}

            <table class="List_Table" border="1" width="100%">

    {********** �ơ��֥�إå� �������� **********}

                <tr class="bold" align="center">
                    <td class="Title_Gray">No.</td>
                    <td class="Title_Gray">����</td>
                    <td class="Title_Gray">ô����</td>
                    <td class="Title_Gray"></td>
                    {* ǯ��ɽ�� *}
                    {foreach key=i from=$disp_head item=ym}
                    <td class="Title_Gray">{$ym}</td>
                    {/foreach}
                    <td class="Title_Gray">����</td>
                    <td class="Title_Gray">��ʿ��</td>
                </tr>

    {********** �ơ��֥�إå� �����ޤ� **********}

    {********** �ơ��֥�ǡ��� �������� **********}

    {* �ۤ��ۤ��롼�� *}
    {foreach key=i from=$disp_data item=item name=data}

        {********** ��׹����� �������� **********}

            {* �������Ǥ��ǽ�ޤ��ϡ��Ǹ�ξ�� *}
            {if $smarty.foreach.data.first OR $smarty.foreach.data.last}

                {* �롼�פ��������顢1�����������last�ѿ��˳�Ǽ
                   ����Σ����ܤ˹�פ����äƤʤ��ΤǺǽ��Ԥ򻲾Ȥ��뤿�� *}
                {assign var="last" value=`$smarty.foreach.data.total-1`}

                <tr class="Result4">
                    <td align="center" class="bold">���</td>
                    <td align="center" class="bold">{$disp_data[$last].total_count}����</td>
                    <td></td>
                    <td class="bold">
                        �����<br />
                        �����׳�<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        ����Ψ<br />
                        {/if}
                    </td>

                {* �Ҥȷ�ʬ���ĥ롼�� �����ꤵ�줿����ʬ�Τ߽��Ϥ��� *}
                {foreach key=j from=$disp_data[$last].total_net_amount item=money}
                    <td align="right">
                        {$disp_data[$last].total_net_amount[$j]|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].total_arari_gaku[$j]|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].total_arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>
                {/foreach}

                {* ���� *}
                    <td align="right">
                        {$disp_data[$last].sum_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].sum_arari_gaku|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                {* ��ʿ�� *}
                    <td align="right">
                        {$disp_data[$last].ave_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$last].ave_arari_gaku|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$last].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                </tr>

            {/if}

        {********** ��׹����� �����ޤ� **********}

        {********** ���١����׹����� �������� **********}

            {* ���١ʺǽ��ԤǤʤ��ܾ��ץե饰�����ͤξ��� *}
            {if $smarty.foreach.data.last !== true && ($disp_data[$i].sub_flg === "1" || $disp_data[$i].sub_flg === "2")}

                {if $disp_data[$i].sub_flg is not even}
                <tr class="Result1">
                {else}
                <tr class="Result2">
                {/if}
                {* �Ԥ裱���ܤξ��Ϥۤ������Ϥ��� *}
                {if $disp_data[$i].rowspan !== null}
                    <td align="right" rowspan="{$disp_data[$i].rowspan}">{$disp_data[$i].no}</td>
                    <td rowspan="{$disp_data[$i].rowspan}">
                        {$disp_data[$i].cd}<br />
                        {$disp_data[$i].name|escape}<br />
                    </td>
                {/if}
                    <td>
                        {$disp_data[$i].cd2}<br />
                        {$disp_data[$i].name2|escape}<br />
                    </td>
                    <td class="bold">
                        �����<br />
                        �����׳�<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        ����Ψ<br />
                        {/if}
                    </td>

            {* ���סʺǽ��ԤǤʤ��ܾ��ץե饰��true�ξ��� *}
            {elseif $smarty.foreach.data.last !== true && $disp_data[$i].sub_flg === "true"}

                <tr class="Result3">
                    <td align="center" class="bold">����</td>
                    <td class="bold">
                        �����<br />
                        �����׳�<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        ����Ψ<br />
                        {/if}
                    </td>

            {/if}


            {* �ǽ��ԤǤʤ���� *}
            {if $smarty.foreach.data.last !== true}

                {* �Ҥȷ�ʬ���ĥ롼�� �����ꤵ�줿����ʬ�Τ߽��Ϥ��� *}
                {foreach key=j from=$disp_data[$i].net_amount item=money}
                    <td align="right">
                        {$disp_data[$i].net_amount[$j]|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].arari_gaku[$j]|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].arari_rate[$j]|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>
                {/foreach}

                {* ���� *}
                    <td align="right">
                        {$disp_data[$i].sum_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].sum_arari_gaku|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].sum_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                {* ��ʿ�� *}
                    <td align="right">
                        {$disp_data[$i].ave_net_amount|Plug_Minus_Numformat}<br />
                        {$disp_data[$i].ave_arari_gaku|Plug_Minus_Numformat}<br />
                        {* ����Ψ��ɽ�������� *}
                        {if $smarty.post.form_margin === "1"}
                        {$disp_data[$i].ave_arari_rate|Plug_Minus_Numformat:0:true|Plug_Unit_Add:"%"}<br />
                        {/if}
                    </td>

                </tr>

            {/if}

        {********** ���١����׹����� �����ޤ� **********}

    {/foreach}

    {********** �ơ��֥�ǡ��� �����ޤ� **********}

{/if}

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

