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


                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ����ɽ���� begin +++++++++++++++*}
<table width="350" align="center">
    <tr>
        <td>
        <table align="center">
            <tr>
                <td><b><font color="blue"><li>�������ޤ�����</font></b><br><br></td>
            </tr>
            {if $var.warning == true}
            <tr>
                <td><b><font color="red">{$var.warning}</font></b><br><br></td>
            </tr>
            {/if}
            {foreach from="$err_msg" item=item key=i}
            <tr>
                <td><b><font color="red"><li>{$err_msg[$i]}</font></b></td>
            </tr>
            {/foreach}
            {foreach from="$err_msg2" item=item key=j}
            <tr>
                <td><b><font color="red"><li>{$err_msg2[$j]}</font></b></td>
            </tr>
            {/foreach}
            {foreach from="$err_msg3" item=item key=i}
            <tr>    
                <td><b><font color="red"><li>{$err_msg3[$i]}</font></b></td>
            </tr>   
            {/foreach}
            {foreach from="$err_msg4" item=item key=i}
            <tr>    
                <td><b><font color="red"><li>{$err_msg4[$i]}</font></b></td>
            </tr>   
            {/foreach}
        </table>
        </td>
    </tr>
</table>

<table width="100" align="center">
    <tr>
        <td align="center">{$form.form_ok_button.html}</td>
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
