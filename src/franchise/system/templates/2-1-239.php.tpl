{$var.html_header}

<body class="bgimg_purple">
<form name="dateForm" method="post">
{$form.hidden}

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

{$form.hidden}

<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="3">��<br>No.</td>
        <td class="Title_Purple" rowspan="3">������</td>
		<td class="Title_Purple" rowspan="3">������</td>
		<td class="Title_Purple" rowspan="3">��԰�����<br>(��ȴ)</td>
		<td class="Title_Purple" rowspan="3">��������</td>
        <td class="Title_Purple" rowspan="3">��ϩ</td>
        <td class="Title_Purple" colspan="10">�������</td>
        <td class="Title_Purple" rowspan="3">�����<br>�ʴ������</td>
        <td class="Title_Purple" rowspan="3">���ô��<br>������</td>
        <td class="Title_Purple" rowspan="3">����</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">�����ʬ</td>
        <td class="Title_Purple">�����ӥ�̾</td>
        <td class="Title_Purple">�����ƥ�</td>
        <td class="Title_Purple" rowspan="2">����</td>
        <td class="Title_Purple" colspan="2">���</td>
        <td class="Title_Purple" colspan="2">������</td>
        <td class="Title_Purple" colspan="2">���ξ���</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">�Ķȸ���<br>���ñ��</td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">̾��</td>
        <td class="Title_Purple">����</td>
    </tr>
{foreach from=$disp_data key=i item=item}
    {*�Ԥο�����*}
	{if $disp_data.$i[19] == 1}
		{*������Υǡ���*}
		<tr class="Result6">
    {elseif $disp_data.$i[100] == true}
        <tr class="Result2">
    {else}
        <tr class="Result1">
    {/if}
    {* ����ܤ��������ѹ��������˰ʲ��ι�ɽ�� *}
    {if $disp_data.$i[101] != NULL}
        {* ��No. *}
        <td align="right" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[0]}</td>
        {* ������ *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[1]}</td>
		{* ������ *}
        <td align="center" rowspan="{$disp_data.$i[101]}"><a href="#" onClick="javascript:return Submit_Page2('./2-1-240.php?&client_id={$disp_data.$i[35]}&contract_id={$disp_data.$i[34]}');">{$disp_data.$i[37]}</a></td>
		{* ������ *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[18]}</td>
		{* �������� *}
		{if $disp_data.$i[19] == 1}
			<td align="center" rowspan="{$disp_data.$i[101]}">������</td>
		{else}
			<td align="center" rowspan="{$disp_data.$i[101]}">������</td>
		{/if}
        {* ��ϩ *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[2]}</td>
    {* �ǡ�����¸�ߤ��ʤ���� *}
    {elseif $var.early_flg == true}
        {* ��No. *}
        <td align="right">��</td>
        {* ������*}
        <td align="center">��</td>
		{* ������*}
        <td align="center">��</td>
		{* ������*}
        <td align="center">��</td>
		{* ��������*}
        <td align="center">��</td>
        {* ��ϩ *}
        <td align="center">��</td>
    {/if}


    {* 2009-09-22 hashimoto-y �Ͱ����ե饰*}
    {if $disp_data.$i[43] === 't'}
        {* �����ʬ *}
        <td align="center" style="color: red">{$disp_data.$i[3]}</td>
        {* �����ӥ�̾�������ӥ����� *}
        <td align="left" style="color: red">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>
        {* �����ƥࡦ�����ƥ���� *}
        <td align="left" style="color: red">{$disp_data.$i[6]}{$disp_data.$i[7]}</td>
        {* ���� *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center" style="color: red">�켰<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center" style="color: red">�켰</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right" style="color: red">{$disp_data.$i[9]}</td>
        {/if}
        {* �Ķȸ��������ñ�� *}
        <td align="right" style="color: red">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>
        {* �Ķȶ�ۡ������ *}
        <td align="right" style="color: red">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>
        {* ������ *}
        <td align="left" style="color: red">{$disp_data.$i[14]}</td>
        {* �����ʿ��� *}
        <td align="right" style="color: red">{$disp_data.$i[15]}</td>
        {* ���ξ��� *}
        <td align="left" style="color: red">{$disp_data.$i[16]}</td>
        {* ���ξ��ʿ��� *}
        <td align="right" style="color: red">{$disp_data.$i[17]}</td>
    {else}
        {* �����ʬ *}
        <td align="center">{$disp_data.$i[3]}</td>
        {* �����ӥ�̾�������ӥ����� *}
        <td align="left">{$disp_data.$i[4]} {$disp_data.$i[5]}</td>
        {* �����ƥࡦ�����ƥ���� *}
        <td align="left">{$disp_data.$i[6]}{$disp_data.$i[7]}</td>
        {* ���� *}
        {if $disp_data.$i[8] == 't' && $disp_data.$i[9] != NULL}
            <td align="center">�켰<br>{$disp_data.$i[9]}</td>
        {elseif $disp_data.$i[8] == 't' && $disp_data.$i[9] == NULL}
            <td align="center">�켰</td>
        {elseif $disp_data.$i[8] != 't' && $disp_data.$i[9] != NULL}
            <td align="right">{$disp_data.$i[9]}</td>
        {/if}
        {* �Ķȸ��������ñ�� *}
        <td align="right">{$disp_data.$i[10]}<br>{$disp_data.$i[11]}</td>
        {* �Ķȶ�ۡ������ *}
        <td align="right">{$disp_data.$i[12]}<br>{$disp_data.$i[13]}</td>
        {* ������ *}
        <td align="left">{$disp_data.$i[14]}</td>
        {* �����ʿ��� *}
        <td align="right">{$disp_data.$i[15]}</td>
        {* ���ξ��� *}
        <td align="left">{$disp_data.$i[16]}</td>
        {* ���ξ��ʿ��� *}
        <td align="right">{$disp_data.$i[17]}</td>
    {/if}


    {* ����ܤ��������ѹ��������˰ʲ��ι�ɽ�� *}
    {if $disp_data.$i[101] != NULL}
        {* ����� *}
        <td align="center" rowspan="{$disp_data.$i[101]}">{$round_data[$i]}</td>
        {* ���ô�������Ψ *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[29]}{$disp_data.$i[30]}{$disp_data.$i[31]}{$disp_data.$i[32]}</td>
        {* ���� *}
        <td align="left" rowspan="{$disp_data.$i[101]}">{$disp_data.$i[33]}</td>
    {* �ǡ�����¸�ߤ��ʤ���� *}
    {elseif $var.early_flg == true}
        {* ����� *}
        <td align="center">��</td>
        {* ���ô�������Ψ *}
        <td align="left">��</td>
        {* ���� *}
        <td align="left">��</td>
    {/if}
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>
            {* ͽ�����٤������ܤ����������ܥ���ɽ�� *}
            {if $smarty.get.get_flg != NULL}
                ����{$form.form_back.html}</td>
            {/if}
        </td>
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
