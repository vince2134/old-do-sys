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
{* ��Ͽ���ѹ���λ��å��������� *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>

{* ���顼��å��������� *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_post.error != null}<li>{$form.form_post.error}<br>{/if}
</span><br>
{*--------------- ��å������� e n d ---------------*}

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table>
    <tr>
        <td>

<span style="font: bold 16px;">���������˼��Ҿ�������Ϥ��Ƥ�������</span><br>
<span style="font: bold 16px;">���������˥����Ȥ����Ϥ��Ƥ�������</span><br>

<table class="List_Table" width="903px" height="1267px" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(../../../image/hacchusho_20070616.png) no-repeat fixed;">
    <tr>    
        <td valign="top">
            {* ȯ���ʼ��ҡ˾��� *} 
            <table style="position: relative; top: 105px; left: 580px;" cellspacing="0" cellpadding="0">
                <tr>    
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>��</b>{$form.form_post.html}
                    </td>   
                </tr>   
            </table>
            <table style="position: relative; top: 105px; left: 580px;" cellspacing="0" cellpadding="0">
                <tr>    
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>��</b>{$form.o_memo2.html}<br>
                        <b>��</b>{$form.o_memo3.html}<br>
                        <b>��</b>{$form.o_memo4.html}<br>
                        <b>��</b>{$form.o_memo5.html}<br>
                        <b>��</b>{$form.o_memo6.html}
                    </td>
                </tr>
            </table>
            {* ȯ��񥳥��ȣ� *}
            <table style="position: relative; top: 150px; left: 40px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>��</b>{$form.o_memo7.html}<br>
                        <b>��</b>{$form.o_memo8.html}
                    </td>
                </tr>
            </table>
            {* ȯ��񥳥��ȣ� *}
            <table style="position: relative; top: 886px; left: 40px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>��</b>{$form.o_memo9.html}<br>
                        <b>��</b>{$form.o_memo10.html}<br>
                        <b>��</b>{$form.o_memo11.html}<br>
                        <b>��</b>{$form.o_memo12.html}<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td></tr></table>

<table align="right">
    <tr>
        <td>{$form.new_button.html}����{$form.order_button.html}</td>
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
