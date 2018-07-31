{$var.html_header}
<script language="javascript">
{$var.code_value}
{$var.contract}
{$var.js}
</script>


<body bgcolor="#D8D0C8" onLoad="Text_Disabled('{$smarty.post.form_slipout_type[0]}')">
<form {$form.attributes}>
{$form.hidden}
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
{* ¥¨¥é¡¼¥á¥Ã¥»¡¼¥¸½ÐÎÏ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_branch_id.error != null}
        <li>{$form.form_branch_id.error}<br>
    {/if}
    {if $form.form_claim_day1.error != null}
        <li>{$form.form_claim_day1.error}<br>
    {/if}
    {if $form.form_claim_day2.error != null}
        <li>{$form.form_claim_day2.error}<br>
    {/if}
    {if $form.form_claim.error != null}
        <li>{$form.form_claim.error}<br>
    {/if}
    {if $form.form_year_month.error != null}
        <li>{$form.form_year_month.error}<br>
    {/if}
    {if $var.error != null}
        <li>{$var.error}<br>
    {/if}
    <ul>
    {foreach from=$sale_err key=i item=item}
        {if $i == 0}
        <li>°Ê²¼¤ÎÇä¾åÅÁÉ¼¤ÏÆü¼¡¹¹¿·¤µ¤ì¤Æ¤¤¤Ê¤¤¤¿¤áÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¼ºÇÔ¤·¤Þ¤·¤¿¡£<br>
        {/if}
        {$item}<br>
    {/foreach}
    {foreach from=$pay_err key=i item=item}
        {if $i == 0}
        <li>°Ê²¼¤ÎÆþ¶âÅÁÉ¼¤ÏÆü¼¡¹¹¿·¤µ¤ì¤Æ¤¤¤Ê¤¤¤¿¤áÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¼ºÇÔ¤·¤Þ¤·¤¿¡£<br>
        {/if}
        {$item}<br>
    {/foreach}
    {foreach from=$advance_err key=i item=item}
        {if $i == 0}
        <li>°Ê²¼¤ÎÁ°¼õ¶âÅÁÉ¼¤Ï³ÎÄê¤µ¤ì¤Æ¤¤¤Ê¤¤¤¿¤áÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¼ºÇÔ¤·¤Þ¤·¤¿¡£<br>
        {/if}
        {$item}<br>
    {/foreach}
    </ul>
</span>   
{*--------------- ¥á¥Ã¥»¡¼¥¸Îà e n d ---------------*}

{*+++++++++++++++ ²èÌÌÉ½¼¨£± begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>
        <div class="note">
        ÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¤Ä¤¤¤Æ<br>
        ¡¡­¡ÀÁµá½ñ¤ò¹¹¿·¸å¤ÏºÆºîÀ®¤µ¤ì¤Þ¤»¤ó¡£<br>
        ¡¡­¢ÀÁµáÄùÆü¹¹¿·Á°¤ÎÀÁµá¥Ç¡¼¥¿¤ÏÊÑ¹¹²ÄÇ½¤Ç¤¹¡£Ã¢¤·¡¢ÀÁµáºîÀ®ºÑ¤Î¥Ç¡¼¥¿¤òºï½ü¤·¤ÆºîÀ®²ÄÇ½¤Ç¤¹¡£<br>
        <div><p>
<table width="500" >
    <tr>
        <td align="left" colspan="2">{$form.form_slipout_type[0].html}</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        »ØÄê¤·¤¿ÄùÆü¤ÎÆÀ°ÕÀè¤ËÂÐ¤·¤Æ¡¢ÀÁµá½ñ¤òºîÀ®¤·¤Þ¤¹
        <table class="Data_Table" border="1" width="300">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">ËÜ»ÙÅ¹<font color="#ff0000">¢¨</font></td>
                <td class="Value">{$form.form_branch_id.html}</td>
            </tr>
            <tr>
                <td class="Title_Pink">ÀÁµáÄùÆü<font color="#ff0000">¢¨</font></td>
                <td class="Value">{$form.form_claim_day1.html}</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>

<table width="660" >
    <tr>
        <td align="left" colspan="2">{$form.form_slipout_type[1].html}</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        »ØÄê¤·¤¿ÆÀ°ÕÀè¤ËÂÐ¤·¤Æ¡¢»ØÄê¤·¤¿ÀÁµáÄùÆü¤Þ¤Ç¤ÎÀÁµá½ñ¤òºîÀ®¤·¤Þ¤¹
        <table class="Data_Table" border="1" width="450">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">{$form.form_claim_link.html}<font color="#ff0000">¢¨</font></td>
                <td class="Value">{$form.form_claim.html}</td>
            </tr>
            <tr>
                <td class="Title_Pink">ÀÁµáÄùÆü<font color="#ff0000">¢¨</font></td>
                {*<td class="Value">{$form.form_claim_day2.html}¡¡¡Ê{$form.form_year_month.html}¡Ë</td>*}
                <td class="Value">{$form.form_claim_day2.html}</td>
            </tr>
        </table>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>¢¨¤ÏÉ¬¿ÜÆþÎÏ¤Ç¤¹</b></font></td>
        <td align="right">{$form.form_create_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- ²èÌÌÉ½¼¨£± e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ ²èÌÌÉ½¼¨£² begin +++++++++++++++*}
<table width="450" align="center">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink" rowspan="2" width="30">ÄùÆü</td>
        <td class="Title_Pink" colspan="{$page_data.colspan}">{$var.last_date}</td>
        <td class="Title_Pink" colspan="{$page_data.colspan}">{$var.now_date}</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        {foreach from=$page_data.cd item=item key=i}
            <td class="Title_Pink">{$page_data[$item].name}</td>
        {/foreach}
        {foreach from=$page_data.cd item=item key=i}
            <td class="Title_Pink">{$page_data[$item].name}</td>
        {/foreach}
    </tr>

    {foreach from=$page_data.close_day item=item key =i}
    <tr class="Result1">
        <td align="right">{$item}</td>
        {foreach from=$page_data.cd item=items key=j}
            {if $page_data[$items].data.$item.last != null}
            <td align="center">{$page_data[$items].data.$item.last}</td>
            {else}
            <td align="center">-</td>
            {/if}
        {/foreach}
        {foreach from=$page_data.cd item=items key=j}
            {if $page_data[$items].data.$item.last != null}
            <td align="center">{$page_data[$items].data.$item.now}</td>
            {else}
            <td align="center">-</td>
            {/if}
        {/foreach}
    </tr> 
    {/foreach}    
</table>
<br>
¡û¡§°ì³çºîÀ®ºÑ¡¡¡¡¡ß¡§°ì³çºîÀ®Ì¤¡¡¡¡¡Ý¡§ÂÐ¾ÝÄùÆü¤ÎÀÁµáÀèÌµ¤·
        </td>
    </tr>
</table>
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
