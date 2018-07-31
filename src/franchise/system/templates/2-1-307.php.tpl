{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

{*+++++++++++++++ ³°ÏÈ begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ¥Ø¥Ã¥ÀÎà begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ¥Ø¥Ã¥ÀÎà e n d ---------------*}

    {*+++++++++++++++ ¥³¥ó¥Æ¥ó¥ÄÉô begin +++++++++++++++*}
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ ¥á¥Ã¥»¡¼¥¸Îà£± begin +++++++++++++++*}
{* ÅÐÏ¿¡¦ÊÑ¹¹´°Î»¥á¥Ã¥»¡¼¥¸½ÐÎÏ *}
{if $var.comp_msg != null}
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>{$var.comp_msg}</li><br>
    </span><br>
{/if}

{if $var.commit_flg != true}
    <span style="font-weight: bold; color: #555555;">¢¨¸½ºß¡¢°Ê²¼¤ÎÈ¯¹Ô¸µ¤¬ÅÐÏ¿ºÑ¤ß¤Ç¤¹¡£</span>
{else}
    <span style="font-weight: bold; color: #0000ff;">°õ»ú¥Ñ¥¿¡¼¥ó¤òÅÐÏ¿¤·¤Þ¤·¤¿¡£</span>
{/if}
{*--------------- ¥á¥Ã¥»¡¼¥¸Îà£± e n d ---------------*}

{*+++++++++++++++ ²èÌÌÉ½¼¨£± begin +++++++++++++++*}
{$form.hidden}

<table width="950">
    <tr>
        <td>

{if $var.commit_flg != true}
    <table width="100%">
        <tr valign="bottom">
            <td>{$form.pattern_select.html}¡¡{$form.preview_button.html}¡¡¡¡{$form.change_button.html}¡¡¡¡{$form.clear_button.html}</td>
        </tr>
    </table>
{else}
<br>¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡{$form.ok_button.html}
{/if}

        </td>
    </tr>
</table>

<hr>
{*--------------- ²èÌÌÉ½¼¨£± e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ¥á¥Ã¥»¡¼¥¸Îà£² begin +++++++++++++++*}
{* ÅÐÏ¿¡¦ÊÑ¹¹´°Î»¥á¥Ã¥»¡¼¥¸½ÐÎÏ *}
{if $var.qf_err_flg == true}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.pattern_name.error != null}
        <li>{$form.pattern_name.error}</li><br>
    {/if}
    </span>
{/if}
{*--------------- ¥á¥Ã¥»¡¼¥¸Îà£² e n d ---------------*}
{if $smarty.post.form_new_flg != true && $smarty.post.form_update_flg != true || $var.pattern_err != null}

    {$form.form_new_button.html}

{else}

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">¥Ñ¥¿¡¼¥óÌ¾<font color="#ff0000">¢¨</font></td>
        <td class="Value">{$form.pattern_name.html}</td>
    </tr>
</table>

{if $var.commit_flg != true}
<br>
<span style="font-weight: bold; color: #ff0000;">°Ê²¼¤Î¹àÌÜ¤òÀßÄê¤·¤Æ²¼¤µ¤¤¡£</span><br>
<table style="font-weight: bold; color: #555555;">
<col span="3" width="130">
    <tr>
        <td>­¡ ²ñ¼ÒÌ¾</td><td>­¢ ÂåÉ½¼ÔÌ¾</td><td>­£ ½»½ê</td>
    </tr>
    <tr>
        <td>­¤ TEL¡¦FAX</td><td>­¥¡Á­¬ ¼è°ú¶ä¹Ô</td><td>­­ ¥³¥á¥ó¥È</td>
    </tr>
</table>
{/if}

        </td>
    </tr>
</table>
<br>

{/if}
{*--------------- ²èÌÌÉ½¼¨£² a n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ²èÌÌÉ½¼¨£³ begin +++++++++++++++*}
{if $smarty.post.form_new_flg != true && $smarty.post.form_update_flg != true || $var.pattern_err != null}

{else}

<table>
    <tr>
        <td>

<table class="List_Table" width="930" height="680" cellpadding="0"><tr><td class="Value">
{*<table width="100%" height="100%" style="background: url(../../../image/request.PNG) no-repeat fixed 30% 50%;">*}
<table width="100%" height="100%" style="background: url(../../../image/seikyusyo_fc.png) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
        {* ¼ÒÌ¾Åù *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 75px; left: 550px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000;">
                        ­¡{$form.c_memo1.html} {$form.font_size_select_0.html}<br>
                        ­¢{$form.c_memo2.html} {$form.font_size_select_1.html}<br>
                        ­£{$form.c_memo3.html} {$form.font_size_select_2.html}<br>
                        ­¤{$form.c_memo4.html} {$form.font_size_select_3.html}
                    </td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 125px; left: 600px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <span style="font: bold 15px;">
                        {$form.c_memo1.html}<br>
                        </span>
                        <span style="font-size: 11px;">
                        {$form.c_memo2.html}<br>
                        {$form.c_memo3.html}<br>
                        {$form.c_memo4.html}
                        </span>
                    </td>
                </tr>
            </table>
        {/if}
        {* ¼è°ú¶ä¹Ô *}
        {if $var.commit_flg != true}
            <table style="position: relative; top: 480px; left: 15px;">
                <tr style="color: #ff0000;">
                    <td>
                        ­¥{$form.c_memo5.html}¡¡­¦{$form.c_memo6.html}<br>
                        ­§{$form.c_memo7.html}¡¡­¨{$form.c_memo8.html}<br>
                        ­©{$form.c_memo9.html}¡¡­ª{$form.c_memo10.html}<br>
                        ­«{$form.c_memo11.html}¡¡­¬{$form.c_memo12.html}<br>
                        ­­{$form.c_memo13.html}
                    </td>
                </tr>
            </table>
        {else}
            <table style="position: relative; top: 530px; left: 50px;">
                <tr>
                    <td span style="font-size: 11px;">
                        {$form.c_memo5.html}¡¡¡¡{$form.c_memo6.html}<br>
                        {$form.c_memo7.html}¡¡¡¡{$form.c_memo8.html}<br>
                        {$form.c_memo9.html}¡¡¡¡{$form.c_memo10.html}<br>
                        {$form.c_memo11.html}¡¡¡¡{$form.c_memo12.html}<br>
                        {$form.c_memo13.html}
                    </td>
                </tr>
            </table>
        {/if}
        </td>
    </tr>
</table>
</tr></td></table>
<br>

{if $var.commit_flg != true}
<table align="right">
    <tr>
        <td>{$form.new_button.html}</td>
    </tr>
</table>
{/if}

{/if}

        </td>
    </tr>
<table>
{*--------------- ²èÌÌÉ½¼¨£² e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ¥³¥ó¥Æ¥ó¥ÄÉô e n d ---------------*}

</table>
{*--------------- ³°ÏÈ e n d ---------------*}

{$var.html_footer}
