{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}


                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="350" align="center">
    <tr>
        <td>
        <table align="center">
            <tr>
                <td><b><font color="blue"><li>作成しました。</font></b><br><br></td>
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

{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
