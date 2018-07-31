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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_msg != null}
    <li>{$var.error_msg}
{/if}
{if $var.error_msg2 != null}
    <li>{$var.error_msg2}
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">伝票番号</td>
        <td class="Value" >{$form.form_slip_no.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">配送日</td>
        <td class="Value" >{$form.form_ord_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">巡回担当者</td>
        <td class="Value" >{$form.form_staff.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_show_button.html}　　{$form.form_clear_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{$form.hidden}

<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">伝票番号</td>
		<td class="Title_Pink">配送日</td>
		<td class="Title_Pink">得意先</td>
        <td class="Title_Pink">取引区分</td>
        <td class="Title_Pink">金額</td>
        <td class="Title_Pink">巡回担当者</td>
    </tr>
    {foreach key=j from=$page_data item=item}
    <tr class="Result1">
		{*No.*}
        <td align="right">
        {if $smarty.post.form_show_button == "表　示"}
                {$j+1}
            {elseif $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*100+$j-99}
            {else}
                {$j+1}
        {/if}
        </td>
		{*伝票番号*}
        <td align="left"><a href="2-2-106.php?aord_id[0]={$item[1]}">{$item[0]}</a></td>
		{*配送日*}
        <td align="center">{$item[2]}</td>
		{*得意先名*}
		<td align="left">{$item[3]}</td>
        {*取引区分*}
        {if $item[4] == '11'}
        <td align="center">掛売上</td>
        {elseif $item[4] == '13'}
        <td align="center">掛返品</td> 
        {elseif $item[4] == '14'}
        <td align="center">掛値引</td> 
        {elseif $item[4] == '61'}
        <td align="center">現金売上</td> 
        {elseif $item[4] == '63'}
        <td align="center">現金返品</td> 
        {elseif $item[4] == '64'}
        <td align="center">現金値引</td> 
        {/if} 
		{*金額*}
        <td align="right">{$item[5]}</td>
		{*巡回担当者*}
        <td align="left">{$item[6]}{$item[7]}{$item[8]}{$item[9]}</td>
    </tr>
    {/foreach}
</table>
{$var.html_page2}

        </td>
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
