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



            <table width="120" height="140" align="center" style="background-image: url(1-1-110.php?staff_id={$var.staff_id});background-repeat:no-repeat; margin-bottom: -3px; margin-top: -1px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td><img src="../../../image/frame.PNG" width="120" height="140" border="0"></td>
                </tr>
                <tr height="5"><td></td></tr>
            </table>
            <table align="center">
                <tr>
                    <td style="color: #555555;">
                        {if $var.freeze_flg != true}{$form.form_photo_ref.html}<br>{/if}
                        &nbsp;{$form.form_photo_del.html}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
   

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">���������� {$form.form_login_info.html}</span>
<span style="color: #ff0000; font-weight: bold;">��{$var.login_info_msg}</span><br>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    
    <tr>
        <td class="Title_Purple">�ѥ����</td>
        <td class="Value">{$form.form_password1.html}
            <span style="color: #ff0000; font-weight: bold;">
            {if $var.password_msg != null}{$var.password_msg}{/if}
            </span>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">�ѥ����<br>(��ǧ��)</td>
        <td class="Value">{$form.form_password2.html}</td>
    </tr>
   
</table>

<table width="100%">
    <tr>
        <td>{if $smarty.get.staff_id != null}{$form.del_button.html}{/if}</td>
        <td align="right">{$form.comp_button.html}��{$form.return_button.html}��{$form.entry_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</form>
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
