{$form.javascript}
{$var.html_header}
<script language="javascript">
{$var.js_data}
</script>

<style TYPE="text/css">
<!--
td.top              {ldelim}border-top: 1px solid #999999;{rdelim}
td.bottom           {ldelim}border-bottom: 1px solid #999999;{rdelim}
td.left             {ldelim}border-left: 1px solid #999999;{rdelim}
td.top_left         {ldelim}border-top: 1px solid #999999; border-left: 1px solid #999999;{rdelim}
td.left_bottom      {ldelim}border-left: 1px solid #999999; border-bottom: 1px solid #999999;{rdelim}
td.top_left_bottom  {ldelim}border-top: 1px solid #999999; border-left: 1px solid #999999; border-bottom: 1px solid #999999;{rdelim}
-->
</style>

<body bgcolor="#D8D0C8" style="overflow-x:hidden">
<form name="dateForm" method="post">

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

{*+++++++++++++++ ���顼��å����� begin +++++++++++++++*}

{*--------------- ���顼��å����� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
{$form.hidden}

<table>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ô���ԥ�����</td>
        <td class="Value">{$var.charge_cd}</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����å�̾</td>
        <td class="Value">{$var.staff_name}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">������¤���Ϳ����</td>
        <td class="Value">{$form.permit_delete.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="3">

<table class="Data_Table" border="1" width="450">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">��ǧ���¤���Ϳ����</td>
        <td class="Value">{$form.permit_accept.html}</td>
    </tr>
</table>
<br>
{*--------------- ����ɽ���� e n d ---------------*}

        </td>
    </tr>
    <tr>
        <td valign="top">

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table class="Data_Table" bgcolor="#ffffff">
<col width="17" style="font: bold 15px;">
<col width="17" style="font: bold;">
<col width="17" style="font: bold;">
<col width="180">
<col width="35" align="center">
<col width="35" align="center">
    <tr bgcolor="#555555" style="color: #ffffff; font-weight: bold;">
        <td class="bottom" colspan="4"></td>
        <td class="bottom">ɽ��</td>
        <td class="bottom">����</td>
    </tr>
    <tr bgcolor="#b0b0f0">
        <td class="top" colspan="4">����</td>
        <td class="bottom">{$form.permit.h.0.0.0.r.html}</td>
        <td class="bottom">{$form.permit.h.0.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#b0b0f0" rowspan="120"></td>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">������</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.1.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.1.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="21"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">����饤�����</td>
        <td>{$form.permit.h.1.1.1.r.html}</td>
        <td>{$form.permit.h.1.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">����</td>
        <td class="bottom">{$form.permit.h.1.1.2.r.html}</td>
        <td class="bottom">{$form.permit.h.1.1.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�������������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">�����ƥ�����</td>
        <td>{$form.permit.h.1.2.1.r.html}</td>
        <td>{$form.permit.h.1.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��󥿥�������</td>
        <td>{$form.permit.h.1.2.2.r.html}</td>
        <td>{$form.permit.h.1.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�ݸ�������</td>
        <td>{$form.permit.h.1.2.3.r.html}</td>
        <td>{$form.permit.h.1.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">��Ի�������</td>
        <td class="bottom">{$form.permit.h.1.2.4.r.html}</td>
        <td class="bottom">{$form.permit.h.1.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">�������</td>
        <td class="bottom">{$form.permit.h.1.3.1.r.html}</td>
        <td class="bottom">{$form.permit.h.1.3.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">����ǡ�������</td>
        <td>{$form.permit.h.1.4.1.r.html}</td>
        <td>{$form.permit.h.1.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�������ȯ��</td>
        <td>{$form.permit.h.1.4.2.r.html}</td>
        <td>{$form.permit.h.1.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">����Ȳ�</td>
        <td class="bottom">{$form.permit.h.1.4.3.r.html}</td>
        <td class="bottom">{$form.permit.h.1.4.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">���ͽ�����</td>
        <td>{$form.permit.h.1.5.1.r.html}</td>
        <td>{$form.permit.h.1.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��������</td>
        <td>{$form.permit.h.1.5.2.r.html}</td>
        <td>{$form.permit.h.1.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">����Ȳ�</td>
        <td class="bottom">{$form.permit.h.1.5.3.r.html}</td>
        <td class="bottom">{$form.permit.h.1.5.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">���Ӵ���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.6.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.1.6.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">��ݻĹ����</td>
        <td>{$form.permit.h.1.6.1.r.html}</td>
        <td>{$form.permit.h.1.6.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����踵Ģ</td>
        <td class="bottom">{$form.permit.h.1.6.2.r.html}</td>
        <td class="bottom">{$form.permit.h.1.6.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">��������</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.2.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.2.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="10"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">ȯ����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">ȯ�����ٹ�ꥹ��</td>
        <td>{$form.permit.h.2.1.1.r.html}</td>
        <td>{$form.permit.h.2.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">ȯ��</td>
        <td class="bottom">{$form.permit.h.2.1.2.r.html}</td>
        <td class="bottom">{$form.permit.h.2.1.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">����</td>
        <td class="bottom">{$form.permit.h.2.2.1.r.html}</td>
        <td class="bottom">{$form.permit.h.2.2.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">��ʧ����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom"></td>
        <td class="top_left_bottom">��ʧ</td>
        <td class="bottom">{$form.permit.h.2.3.1.r.html}</td>
        <td class="bottom">{$form.permit.h.2.3.1.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">���Ӵ���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.2.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">��ݻĹ����</td>
        <td>{$form.permit.h.2.4.1.r.html}</td>
        <td>{$form.permit.h.2.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����踵Ģ</td>
        <td class="bottom">{$form.permit.h.2.4.2.r.html}</td>
        <td class="bottom">{$form.permit.h.2.4.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">�߸˴���</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.3.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.3.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="11"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�߸˼��</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="7"></td>
        <td class="top_left">�߸˾Ȳ�</td>
        <td>{$form.permit.h.3.1.1.r.html}</td>
        <td>{$form.permit.h.3.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�߸˼�ʧ�Ȳ�</td>
        <td>{$form.permit.h.3.1.2.r.html}</td>
        <td>{$form.permit.h.3.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�߸˰�ư����</td>
        <td>{$form.permit.h.3.1.3.r.html}</td>
        <td>{$form.permit.h.3.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">��α�߸˰���</td>
        <td>{$form.permit.h.3.1.4.r.html}</td>
        <td>{$form.permit.h.3.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">�߸�Ĵ��</td>
        <td>{$form.permit.h.3.1.5.r.html}</td>
        <td>{$form.permit.h.3.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">������Ω</td>
        <td>{$form.permit.h.3.1.6.r.html}</td>
        <td>{$form.permit.h.3.1.6.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">���ʥ��롼������</td>
        <td class="bottom">{$form.permit.h.3.1.7.r.html}</td>
        <td class="bottom">{$form.permit.h.3.1.7.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">ê������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.3.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">ê��Ĵ��</td>
        <td>{$form.permit.h.3.2.1.r.html}</td>
        <td>{$form.permit.h.3.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">ê�����Ӱ���</td>
        <td class="bottom">{$form.permit.h.3.2.2.r.html}</td>
        <td class="bottom">{$form.permit.h.3.2.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">����</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.4.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.4.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="7"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">��������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.4.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.4.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="6"></td>
        <td class="top_left">�ѥå�ɽ</td>
        <td>{$form.permit.h.4.1.1.r.html}</td>
        <td>{$form.permit.h.4.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">���ڥ졼�����Ͼ���</td>
        <td>{$form.permit.h.4.1.2.r.html}</td>
        <td>{$form.permit.h.4.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">������������</td>
        <td>{$form.permit.h.4.1.3.r.html}</td>
        <td>{$form.permit.h.4.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">���ṹ������</td>
        <td>{$form.permit.h.4.1.4.r.html}</td>
        <td>{$form.permit.h.4.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">ê����������</td>
        <td>{$form.permit.h.4.1.5.r.html}</td>
        <td>{$form.permit.h.4.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">���������</td>
        <td class="bottom">{$form.permit.h.4.1.6.r.html}</td>
        <td class="bottom">{$form.permit.h.4.1.6.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">�ǡ�������</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.5.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.5.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="28"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">���׾���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">�������</td>
        <td>{$form.permit.h.5.1.1.r.html}</td>
        <td>{$form.permit.h.5.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��������</td>
        <td>{$form.permit.h.5.1.2.r.html}</td>
        <td>{$form.permit.h.5.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�����̷�������</td>
        <td>{$form.permit.h.5.1.3.r.html}</td>
        <td>{$form.permit.h.5.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">�������̷�������</td>
        <td>{$form.permit.h.5.1.4.r.html}</td>
        <td>{$form.permit.h.5.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">����۰���</td>
        <td class="bottom">{$form.permit.h.5.1.5.r.html}</td>
        <td class="bottom">{$form.permit.h.5.1.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="8"></td>
        <td class="top_left">��������</td>
        <td>{$form.permit.h.5.2.1.r.html}</td>
        <td>{$form.permit.h.5.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�����ӥ���</td>
        <td>{$form.permit.h.5.2.2.r.html}</td>
        <td>{$form.permit.h.5.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.h.5.2.3.r.html}</td>
        <td>{$form.permit.h.5.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">�������̾�����</td>
        <td>{$form.permit.h.5.2.4.r.html}</td>
        <td>{$form.permit.h.5.2.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">ô�����̾�����</td>
        <td>{$form.permit.h.5.2.5.r.html}</td>
        <td>{$form.permit.h.5.2.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">�϶��̾�����</td>
        <td>{$form.permit.h.5.2.6.r.html}</td>
        <td>{$form.permit.h.5.2.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">�ȼ�����������</td>
        <td>{$form.permit.h.5.2.7.r.html}</td>
        <td>{$form.permit.h.5.2.7.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�ȼ��̾�����</td>
        <td class="bottom">{$form.permit.h.5.2.8.r.html}</td>
        <td class="bottom">{$form.permit.h.5.2.8.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">ABCʬ��</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">FC��</td>
        <td>{$form.permit.h.5.3.1.r.html}</td>
        <td>{$form.permit.h.5.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��������</td>
        <td>{$form.permit.h.5.3.2.r.html}</td>
        <td>{$form.permit.h.5.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC�̾�����</td>
        <td>{$form.permit.h.5.3.3.r.html}</td>
        <td>{$form.permit.h.5.3.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">�ȼ���</td>
        <td>{$form.permit.h.5.3.4.r.html}</td>
        <td>{$form.permit.h.5.3.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">ô�����̾�����</td>
        <td class="bottom">{$form.permit.h.5.3.5.r.html}</td>
        <td class="bottom">{$form.permit.h.5.3.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�������</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="2"></td>
        <td class="top_left">��������</td>
        <td>{$form.permit.h.5.4.1.r.html}</td>
        <td>{$form.permit.h.5.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�������̾�����</td>
        <td class="bottom">{$form.permit.h.5.4.2.r.html}</td>
        <td class="bottom">{$form.permit.h.5.4.2.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">CSV����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.5.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="3"></td>
        <td class="top_left">�ޥ����ǡ���</td>
        <td>{$form.permit.h.5.5.1.r.html}</td>
        <td>{$form.permit.h.5.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">���ӥǡ���</td>
        <td>{$form.permit.h.5.5.2.r.html}</td>
        <td>{$form.permit.h.5.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�ޥ�������</td>
        <td class="bottom">{$form.permit.h.5.5.3.r.html}</td>
        <td class="bottom">{$form.permit.h.5.5.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c7c7f0" class="top_left" colspan="3">�ޥ���������</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.6.0.0.r.html}</td>
        <td bgcolor="#c7c7f0" class="bottom">{$form.permit.h.6.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#c0c0f0" class="left_bottom" rowspan="37"></td>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">���������ޥ���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.1.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">�ȼ�</td>
        <td>{$form.permit.h.6.1.1.r.html}</td>
        <td>{$form.permit.h.6.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.h.6.1.2.r.html}</td>
        <td>{$form.permit.h.6.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.h.6.1.3.r.html}</td>
        <td>{$form.permit.h.6.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����ӥ�</td>
        <td class="bottom">{$form.permit.h.6.1.4.r.html}</td>
        <td class="bottom">{$form.permit.h.6.1.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">������ͭ�ޥ���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.2.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="4"></td>
        <td class="top_left">�����å�</td>
        <td>{$form.permit.h.6.2.1.r.html}</td>
        <td>{$form.permit.h.6.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.h.6.2.2.r.html}</td>
        <td>{$form.permit.h.6.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�Ͷ�ʬ</td>
        <td>{$form.permit.h.6.2.3.r.html}</td>
        <td>{$form.permit.h.6.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">���ʶ�ʬ</td>
        <td class="bottom">{$form.permit.h.6.2.4.r.html}</td>
        <td class="bottom">{$form.permit.h.6.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">���̥ޥ���</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.3.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="14"></td>
        <td class="top_left">����</td>
        <td>{$form.permit.h.6.3.1.r.html}</td>
        <td>{$form.permit.h.6.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�Ҹ�</td>
        <td>{$form.permit.h.6.3.2.r.html}</td>
        <td>{$form.permit.h.6.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�϶�</td>
        <td>{$form.permit.h.6.3.3.r.html}</td>
        <td>{$form.permit.h.6.3.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">���</td>
        <td>{$form.permit.h.6.3.4.r.html}</td>
        <td>{$form.permit.h.6.3.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">��¤��</td>
        <td>{$form.permit.h.6.3.5.r.html}</td>
        <td>{$form.permit.h.6.3.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.h.6.3.6.r.html}</td>
        <td>{$form.permit.h.6.3.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC��ʬ</td>
        <td>{$form.permit.h.6.3.7.r.html}</td>
        <td>{$form.permit.h.6.3.7.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC���롼��</td>
        <td>{$form.permit.h.6.3.8.r.html}</td>
        <td>{$form.permit.h.6.3.8.w.html}</td>
    </tr>
    <tr>
        <td class="left">FC</td>
        <td>{$form.permit.h.6.3.9.r.html}</td>
        <td>{$form.permit.h.6.3.9.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.h.6.3.10.r.html}</td>
        <td>{$form.permit.h.6.3.10.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.h.6.3.11.r.html}</td>
        <td>{$form.permit.h.6.3.11.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.h.6.3.12.r.html}</td>
        <td>{$form.permit.h.6.3.12.w.html}</td>
    </tr>
    <tr>
        <td class="left">ľ����</td>
        <td>{$form.permit.h.6.3.13.r.html}</td>
        <td>{$form.permit.h.6.3.13.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����ȼ�</td>
        <td class="bottom">{$form.permit.h.6.3.14.r.html}</td>
        <td class="bottom">{$form.permit.h.6.3.14.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">Ģɼ����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.4.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">ȯ��񥳥���</td>
        <td>{$form.permit.h.6.4.1.r.html}</td>
        <td>{$form.permit.h.6.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��ʸ��ե����ޥå�</td>
        <td>{$form.permit.h.6.4.2.r.html}</td>
        <td>{$form.permit.h.6.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�����</td>
        <td>{$form.permit.h.6.4.3.r.html}</td>
        <td>{$form.permit.h.6.4.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">�����ɼ</td>
        <td>{$form.permit.h.6.4.4.r.html}</td>
        <td>{$form.permit.h.6.4.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">Ǽ�ʽ�</td>
        <td class="bottom">{$form.permit.h.6.4.5.r.html}</td>
        <td class="bottom">{$form.permit.h.6.4.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="top_left" colspan="2">�����ƥ�����</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.5.0.r.html}</td>
        <td bgcolor="#e0e0f0" class="bottom">{$form.permit.h.6.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e0e0f0" class="left_bottom" rowspan="5"></td>
        <td class="top_left">�����ץ�ե�����</td>
        <td>{$form.permit.h.6.5.1.r.html}</td>
        <td>{$form.permit.h.6.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��ݻĹ�������</td>
        <td>{$form.permit.h.6.5.2.r.html}</td>
        <td>{$form.permit.h.6.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">��ݻĹ�������</td>
        <td>{$form.permit.h.6.5.3.r.html}</td>
        <td>{$form.permit.h.6.5.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">����Ĺ�������</td>
        <td>{$form.permit.h.6.5.4.r.html}</td>
        <td>{$form.permit.h.6.5.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">�ѥ�����ѹ�</td>
        <td class="bottom">{$form.permit.h.6.5.5.r.html}</td>
        <td class="bottom">{$form.permit.h.6.5.5.w.html}</td>
    </tr>
</table>

        </td>
        <td width="10"></td>
        <td valign="top">

<table class="Data_Table" bgcolor="#ffffff">
<col width="17" style="font: bold 15px;">
<col width="17" style="font: bold;">
<col width="17" style="font: bold;">
<col width="180">
<col width="35" align="center">
<col width="35" align="center">
    <tr bgcolor="#555555" style="color: #ffffff; font-weight: bold;">
        <td class="bottom" colspan="4"></td>
        <td class="bottom">ɽ��</td>
        <td class="bottom">����</td>
    </tr>
    <tr bgcolor="#e5b0f0">
        <td class="top" colspan="4">�ƣ�</td>
        <td class="bottom">{$form.permit.f.0.0.0.r.html}</td>
        <td class="bottom">{$form.permit.f.0.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#e5b0f0" rowspan="33"></td>
        <td bgcolor="#f0c7f0" class="top_left" colspan="3">�ޥ���������</td>
        <td bgcolor="#f0c7f0" class="bottom">{$form.permit.f.1.0.0.r.html}</td>
        <td bgcolor="#f0c7f0" class="bottom">{$form.permit.f.1.0.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#f0c7f0" class="left_bottom" rowspan="32"></td>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">���̥ޥ���</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.1.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.1.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="11"></td>
        <td class="top_left">����</td>
        <td>{$form.permit.f.1.1.1.r.html}</td>
        <td>{$form.permit.f.1.1.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�Ҹ�</td>
        <td>{$form.permit.f.1.1.2.r.html}</td>
        <td>{$form.permit.f.1.1.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�϶�</td>
        <td>{$form.permit.f.1.1.3.r.html}</td>
        <td>{$form.permit.f.1.1.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">���</td>
        <td>{$form.permit.f.1.1.4.r.html}</td>
        <td>{$form.permit.f.1.1.4.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.f.1.1.5.r.html}</td>
        <td>{$form.permit.f.1.1.5.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.f.1.1.6.r.html}</td>
        <td>{$form.permit.f.1.1.6.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.f.1.1.7.r.html}</td>
        <td>{$form.permit.f.1.1.7.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.f.1.1.8.r.html}</td>
        <td>{$form.permit.f.1.1.8.w.html}</td>
    </tr>
    <tr>
        <td class="left">������</td>
        <td>{$form.permit.f.1.1.9.r.html}</td>
        <td>{$form.permit.f.1.1.9.w.html}</td>
    </tr>
    <tr>
        <td class="left">ľ����</td>
        <td>{$form.permit.f.1.1.10.r.html}</td>
        <td>{$form.permit.f.1.1.10.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����ȼ�</td>
        <td class="bottom">{$form.permit.f.1.1.11.r.html}</td>
        <td class="bottom">{$form.permit.f.1.1.11.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">������ͭ�ޥ���</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.2.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.2.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="4"></td>
        <td class="top_left">�����å�</td>
        <td>{$form.permit.f.1.2.1.r.html}</td>
        <td>{$form.permit.f.1.2.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.f.1.2.2.r.html}</td>
        <td>{$form.permit.f.1.2.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">�Ͷ�ʬ</td>
        <td>{$form.permit.f.1.2.3.r.html}</td>
        <td>{$form.permit.f.1.2.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">���ʶ�ʬ</td>
        <td class="bottom">{$form.permit.f.1.2.4.r.html}</td>
        <td class="bottom">{$form.permit.f.1.2.4.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">Ģɼ����</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.3.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.3.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="3"></td>
        <td class="top_left">ȯ��񥳥���</td>
        <td>{$form.permit.f.1.3.1.r.html}</td>
        <td>{$form.permit.f.1.3.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">�����</td>
        <td>{$form.permit.f.1.3.2.r.html}</td>
        <td>{$form.permit.f.1.3.2.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�����ɼ</td>
        <td class="bottom">{$form.permit.f.1.3.3.r.html}</td>
        <td class="bottom">{$form.permit.f.1.3.3.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">�����ƥ�����</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.4.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.4.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="5"></td>
        <td class="top_left">���ҥץ�ե�����</td>
        <td>{$form.permit.f.1.4.1.r.html}</td>
        <td>{$form.permit.f.1.4.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">��ݻĹ�������</td>
        <td>{$form.permit.f.1.4.2.r.html}</td>
        <td>{$form.permit.f.1.4.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">��ݻĹ�������</td>
        <td>{$form.permit.f.1.4.3.r.html}</td>
        <td>{$form.permit.f.1.4.3.w.html}</td>
    </tr>
    <tr>
        <td class="left">����Ĺ�������</td>
        <td>{$form.permit.f.1.4.4.r.html}</td>
        <td>{$form.permit.f.1.4.4.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">�ѥ�����ѹ�</td>
        <td class="bottom">{$form.permit.f.1.4.5.r.html}</td>
        <td class="bottom">{$form.permit.f.1.4.5.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="top_left" colspan="2">���������ޥ���</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.5.0.r.html}</td>
        <td bgcolor="#ffdfff" class="bottom">{$form.permit.f.1.5.0.w.html}</td>
    </tr>
    <tr>
        <td bgcolor="#ffdfff" class="left_bottom" rowspan="4"></td>
        <td class="top_left">�ȼ�</td>
        <td>{$form.permit.f.1.5.1.r.html}</td>
        <td>{$form.permit.f.1.5.1.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.f.1.5.2.r.html}</td>
        <td>{$form.permit.f.1.5.2.w.html}</td>
    </tr>
    <tr>
        <td class="left">����</td>
        <td>{$form.permit.f.1.5.3.r.html}</td>
        <td>{$form.permit.f.1.5.3.w.html}</td>
    </tr>
    <tr>
        <td class="left_bottom">��塦�����Ѱ���</td>
        <td class="bottom">{$form.permit.f.1.5.4.r.html}</td>
        <td class="bottom">{$form.permit.f.1.5.4.w.html}</td>
    </tr>
</table>

    <tr>
        <td colspan="3" align="right">{$form.form_set_button.html}����{$form.form_print_button.html}����{$form.form_return_button.html}</td>
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
