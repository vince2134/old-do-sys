{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_client_name.focus();">
<form {$form.attributes}>

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%">

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="250" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value">{$form.form_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先名／フリガナ</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先名</td>
        <td class="Value">{$form.form_claim_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">銀行カナ</td>
        <td class="Value">{$form.form_bank_kana.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">振込名義</td>
        <td class="Value">{$form.form_account_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_id.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示順</td>
        <td class="Value">{$form.form_turn.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.form_button.show_button.html}　　{$form.form_button.close_button.html}</td>
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
<table class="List_Table" border="1" width="500">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先コード<br>得意先名</td>
        <td class="Title_Purple">略称</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">状態</td>
    </tr>
    {foreach key=j from=$row_html item=items}
    <tr class="Result1"> 
        <td align="right" width="30">
            {if $smarty.post.form_show_page != 2 && $smarty.post.f_page1 != ""}
                {$smarty.post.f_page1*100+$j-99}
            {else if}
            　  {$j+1}  
            {/if}   
        </td>               
        <td width="200">
            {$row_html[$j][0]}-{$row_html[$j][1]}<br>
            {if $row_html[$j][5] == 'true'}
				<!-- 親判定 -->
				{if $var.display == 5}
					<!-- 契約マスタ -->
					<a href="#" onClick="returnValue=Array('{$row_js[$j][0]}','{$row_js[$j][1]}','{$row_js[$j][3]}',true);window.close();">{$row_html[$j][2]}</a>
				{elseif $var.display == 'true'}
					<!-- 入金入力 -->
					<a href="#" onClick="returnValue=Array('{$row_js[$j][0]}','{$row_js[$j][1]}','{$row_js[$j][3]}',true,{$row_js[$j][6]});window.close();">{$row_html[$j][2]}</a>
				{else}
            		<a href="#" onClick="returnValue=Array('{$row_js[$j][0]}','{$row_js[$j][1]}','{$row_js[$j][3]}');window.close();">{$row_html[$j][2]}</a>
				{/if}
            {else}
            {$row_html[$j][2]}
            {/if}
        </td>
        </td>
        <td>{$row_html[$j][3]}</td>
        <td align="center">{$row_html[$j][4]}</td>
        <td align="center">{$row_html[$j][7]}</td>
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
