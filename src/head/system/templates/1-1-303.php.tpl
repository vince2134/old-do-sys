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

{*+++++++++++++++ ¥á¥Ã¥»¡¼¥¸Îà begin +++++++++++++++*}
{* ÅÐÏ¿¡¦ÊÑ¹¹´°Î»¥á¥Ã¥»¡¼¥¸½ÐÎÏ *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>

{* ¥¨¥é¡¼¥á¥Ã¥»¡¼¥¸½ÐÎÏ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_post.error != null}<li>{$form.form_post.error}<br>{/if}
</span><br>
{*--------------- ¥á¥Ã¥»¡¼¥¸Îà e n d ---------------*}

{*+++++++++++++++ ²èÌÌÉ½¼¨£± begin +++++++++++++++*}
<table>
    <tr>
        <td>

<span style="font: bold 16px;">¢¨­¡¡Á­¦¤Ë¼«¼Ò¾ðÊó¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤</span><br>
<span style="font: bold 16px;">¢¨­§¡Á­¬¤Ë¥³¥á¥ó¥È¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤</span><br>

<table class="List_Table" width="903px" height="1267px" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(../../../image/hacchusho_20070616.png) no-repeat fixed;">
    <tr>    
        <td valign="top">
            {* È¯Ãí¸µ¡Ê¼«¼Ò¡Ë¾ðÊó *} 
            <table style="position: relative; top: 105px; left: 580px;" cellspacing="0" cellpadding="0">
                <tr>    
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>­¡</b>{$form.form_post.html}
                    </td>   
                </tr>   
            </table>
            <table style="position: relative; top: 105px; left: 580px;" cellspacing="0" cellpadding="0">
                <tr>    
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>­¢</b>{$form.o_memo2.html}<br>
                        <b>­£</b>{$form.o_memo3.html}<br>
                        <b>­¤</b>{$form.o_memo4.html}<br>
                        <b>­¥</b>{$form.o_memo5.html}<br>
                        <b>­¦</b>{$form.o_memo6.html}
                    </td>
                </tr>
            </table>
            {* È¯Ãí½ñ¥³¥á¥ó¥È£± *}
            <table style="position: relative; top: 150px; left: 40px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>­§</b>{$form.o_memo7.html}<br>
                        <b>­¨</b>{$form.o_memo8.html}
                    </td>
                </tr>
            </table>
            {* È¯Ãí½ñ¥³¥á¥ó¥È£² *}
            <table style="position: relative; top: 886px; left: 40px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000; font-size: 14px;">
                        <b>­©</b>{$form.o_memo9.html}<br>
                        <b>­ª</b>{$form.o_memo10.html}<br>
                        <b>­«</b>{$form.o_memo11.html}<br>
                        <b>­¬</b>{$form.o_memo12.html}<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td></tr></table>

<table align="right">
    <tr>
        <td>{$form.new_button.html}¡¡¡¡{$form.order_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- ²èÌÌÉ½¼¨£± e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- ¥³¥ó¥Æ¥ó¥ÄÉô e n d ---------------*}

</table>
{*--------------- ³°ÏÈ e n d ---------------*}

{$var.html_footer}
