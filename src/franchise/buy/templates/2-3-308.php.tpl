{$var.html_header}
<SCRIPT LANGUAGE='javascript' SRC='estimate.js'></SCRIPT>
<BODY>
<form {$form.attributes}>

{$form.javascript}
{$form.hidden}
{*+++++++++++++++ ���� begin +++++++++++++++*}
<table width='100%' height='90%' class='M_table' border='0'>

    {*+++++++++++++++ �إå��� begin +++++++++++++++*}
    <tr align='center' height='60'>
        <td width='100%' colspan='2' valign='top'>{$var.page_header}</td>
    </tr>
    {*--------------- �إå��� e n d ---------------*}

    {*+++++++++++++++ ����ƥ���� begin +++++++++++++++*}
    <tr align='center' valign='top'>
        <td>
            <table>
                <tr>
                    <td>
<br>
{*+++++++++++++++ ��å������� begin +++++++++++++++*}
{*--------------- ��å������� e n d ---------------*}
<table width='600' border='0'>
    <tr>
        <td align='CENTER'>
{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
    <table class='Data_Table' border='1' width='100%'>
    <col width='100' style='font-weight: bold'>
    <col >
    <col width='100' style='font-weight: bold'>
        <tr>
            <td class='Title_Pink'>������</td>
            <td class='Value' colspan='3'>
                {$pay_data[10]}-{$pay_data[11]}��{$pay_data[9]}</td>
        </tr>
        <tr>
            <td class='Title_Pink'>��������</td>
            <td class='Value'>{$close_day}</td>                
            <td class='Title_Pink'>��ʧͽ����</td>
            <td class='Value'>{$pay_data[8]}</td>                
        </tr>
    </table>
{*--------------- ����ɽ���� e n d ---------------*}
        </td>
    </tr>
</table>
<br>
                    </td>
                </tr>
                <tr>
                    <td>

<table width='100%' border='0'>
    <tr>
        <td align='CENTER'>
{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table class='List_Table' width='100%' border='1'>
    <tr>
    <td class='Title_Pink' align='CENTER'><b>�����ʧ�Ĺ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʧ��</b></td>
    <td class='Title_Pink' align='CENTER'><b>���ۻĹ��</b></td>
    <td class='Title_Pink' align='CENTER'><b>���������</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ǳ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�ǹ�������</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʧ�Ĺ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>����λ�ʧ��</b></td>
    </tr>
    <tr>
            <td class='Value' align='RIGHT'>{$pay_data[0]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[1]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[2]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[3]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[4]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[5]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[6]}</td>                
            <td class='Value' align='RIGHT'>{$pay_data[7]}</td>                
    </tr>
</table>
<br>
<br>
{*----- �����ǡ��� -----*}
<table class='List_Table' width='100%' border='1'>
<tr>
    <td class='Title_Pink' align='CENTER'><b>����</b></td>
    <td class='Title_Pink' align='CENTER'><b>��ɼ�ֹ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʬ</b></td>
    <td class='Title_Pink' align='CENTER' width='300'><b>����̾</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>����</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>ñ��</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>���</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>�Ƕ�ʬ</b></td>
    <td class='Title_Pink' align='CENTER' width='80'><b>�����ƥ�</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>��ʧ</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>�Ĺ�</b></td>
</tr>
{* -----�����۳ۡ�----- *}
<tr class='Result1'>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>����</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>{$pay_data[0]}</td> {*--������ݻĹ�--*}
</tr>
{*---   ���٥ǡ���ɽ��������  ---*}
{foreach from=$detail_data key='row' item='data' name='list' }
<tr class='Result1'>
    <td align='CENTER'>{$data[0]}</td>
    <td align='CENTER'>{$data[1]}</td>
    <td >{$data[2]}</td>
    <td >{$data[3]}</td>
    <td align='RIGHT'>{$data[4]}</td>
    <td align='RIGHT'>{$data[5]}</td>
    <td align='RIGHT'>{$data[6]}</td>
    <td align='CENTER'>{$data[7]}</td>
    <td align='CENTER'>{$data[9]}</td>
    <td align='RIGHT'>{$data[8]}</td>
    <td align='RIGHT'></td>
</tr>
{/foreach}
{* ----������ñ�̤�������ñ�̡פξ�硡---- *}
{if $tax_div == '1' }
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>�����Ƕ��</td>
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[4]}</td> {*--�����ǳ�--*}
        <td></td>
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
    </tr>
{/if}
{* -----���ס�----- *}
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>��</td>
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[5]}</td> {*--���������(�ǹ�)--*}
        <td></td>
        <td></td>
        <td align='RIGHT'>{$pay_data[1]}</td> {*--�����ʧ��--*}
        <td align='RIGHT'>{$pay_data[6]}</td> {*--������ݻĹ�--*}
    </tr>
</table>
{*--------------- ����ɽ���� e n d ---------------*}
        </td>
    </tr>
    <tr>
        <td align='RIGHT'>{$form.btn_back.html}</td>
    </tr>
</table>
        </td>
    </tr>
</table>
        </td>
    </tr>
{*--------------- ����ƥ���� e n d ---------------*}
</table>
</form>
{*--------------- ���� e n d ---------------*}
{$var.html_footer}
