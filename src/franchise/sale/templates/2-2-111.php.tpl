{* -------------------------------------------------------------------
 * @Program         2-2-111.php.tpl
 * @fnc.Overview    ����ͽ��вٰ���
 * @author          kajioka-h <kajioka-h@bhsk.co.jp>
 * @Cng.Tracking    #2: 2007/02/16
 * ---------------------------------------------------------------- *}

{$var.html_header}
<body bgcolor="#D8D0C8">
{* <form name="dateForm" method="post"> *}
<form {$form.attributes}>

{*------------------- ���ȳ��� --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* ���̥����ȥ볫�� *} {$var.page_header} {* ���̥����ȥ뽪λ *}
        </td>
    </tr>

    <tr align="left">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {* ͽ������ *}
    {if $form.form_round_day.error != null}
        <li>{$form.form_round_day.error}<br>
    {/if}
    {* ���ô���ԡ�ʣ������� *}
    {if $form.form_multi_staff.error != null}
        <li>{$form.form_multi_staff.error}<br>
    {/if}
    {* �������ô���ԡ�ʣ������� *}
    {if $form.form_not_multi_staff.error != null}
        <li>{$form.form_not_multi_staff.error}<br>
    {/if}
    {* ͽ��вٿ���Ⱦ�ѿ��ͥ����å� *}
    {if $var.form_num_mess != null}
        <li>{$var.form_num_mess}<br>
    {/if}
{*
    {if $var.charges_msg != null}
        <li>{$var.charges_msg}<br>
    {/if}
    {if $var.chargee_msg != null}
        <li>{$var.chargee_msg}<br>
    {/if}
    {if $var.decimal_msg != null}
        <li>{$var.decimal_msg}<br>
    {/if}
    {if $var.nodecimal_msg != null}
        <li>{$var.nodecimal_msg}<br>
    {/if}
*}
    {* ���ô���� *}
    {if $form.form_round_staff.error != null}
        <li>{$form.form_round_staff.error}
    {/if}
</span>
{* ��λ��å��������� *} 
<span style="color: #0000FF; font-weight: bold; line-height: 130%;">
    {if $var.done_mess != null}
        <li>{$var.done_mess}<br>
    {/if}
</span>

{*--------------- ��å������� e n d ---------------*}

{*-------------------- ����ɽ��1���� -------------------*}
{* ���̸����ե����� *}
{$html.html_s}

<br style="font-size: 4px;">

<table class="Table_Search">
<col width="115px" style="font-weight: bold;">
<col width="300px">
<col width="115px" style="font-weight: bold;">
<col width="300px">
    <tr>
        <td class="Td_Search_3">�������ô����<br>��ʣ�������</td>
        <td class="Td_Search_3">{$form.form_not_multi_staff.html}<br> ���0001,0002</td>
        <td class="Td_Search_3"><b>���׶�ʬ</b></td>
        <td class="Td_Search_3">{$form.form_count_radio.html}</td>
    </tr>
</table>

<table width='100%'>
    <tr>
        <td align='right'>
            {$form.form_display.html}����{$form.form_clear.html}
        </td>
    </tr>
</table>
{********************* ����ɽ��1��λ ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td align="left" valign="top">

{*-------------------- ����ɽ��2���� -------------------*}
{* ��ץơ��֥�ɽ�� *}
{$var.html_sum_table}
{* ���ڡ��� *}
<div style="page-break-before: always;"></div>
{* ô���Ԥ��ȤΥơ��֥�ɽ�� *}
{$var.html}
<br>
{$form.hidden}
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
    

