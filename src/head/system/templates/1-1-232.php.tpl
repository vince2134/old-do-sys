{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_Table">

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
{* 表示権限のみ時のメッセージ *} 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    {if $var.message != null && $form.form_btype_cd.error == null && $form.form_btype_name.error == null}
        <li>{$var.message}<br>
    {/if}
    </span>
     {* エラーメッセージ出力 *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_btype.error != null}
        <li>{$form.form_btype.error}<br>
    {/if}
    {if $form.form_btype_cd.error != null}
        <li>{$form.form_btype_cd.error}<br>
    {/if}
    {if $form.form_btype_name.error != null}
        <li>{$form.form_btype_name.error}<br>
    {/if}
    </span> 
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table class="Data_Table" border="1" width="450">
    <tr>
        <td class="Title_Purple" width="120"><b>大分類業種</b></td>
        <td class="Title_Purple" width="100"><b>コード<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_btype.html}</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="650">
    <tr>
        <td class="Title_Purple" width="120" rowspan="4"><b>小分類業種</b>
        <td class="Title_Purple" width="100"><b>コード<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_btype_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple" width=""><b>名称<font color="#ff0000">※</font></b></td>
        <td class="Value">{$form.form_btype_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>備考</b></td>
        <td class="Value">{$form.form_btype_note.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>承認</b></td>
        <td class="Value">{$form.form_accept.html}</td>
    </tr>
</table>

<table width='650'>
    <tr>
        <td align="left">
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        <td align="right">
            {$form.form_entry_button.html}　　{$form.form_clear_button.html}
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
<table width="100%">
    <tr>
        <td>

<table border="0" width="650">
    <tr>
        <td width="50%" align="left">全<b>{$var.total_count}</b>件　{$form.form_csv_button.html}</td>
    </tr>
</table>

<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple" width="30" rowspan="2"><b>No.</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>大分類業種</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>小分類業種</b></td>
    </tr>
    
    <tr align="center">
        <td class="Title_Purple" width=""><b>コード</b></td>
        <td class="Title_Purple" width=""><b>名称</b></td>
        <td class="Title_Purple" width=""><b>備考</b></td>
        <td class="Title_Purple" width=""><b>承認</b></td>
        <td class="Title_Purple" width=""><b>コード</b></td>
        <td class="Title_Purple" width=""><b>名称</b></td>
        <td class="Title_Purple" width=""><b>備考</b></td>
        <td class="Title_Purple" width=""><b>承認</b></td>
    </tr>
{foreach from=$page_data item=item key=i}
    <tr class={$tr[$i]}>
        <td align="right">{$i+1}</td>
        <td align="left">{$item[0]}</td>
        <td align="left">{$item[1]}</td>
        <td align="left">{$item[2]}</a></td>
        {if $item[7] == '1' }
            <td align="center">○</td>
        {elseif $item[7] == '2'}
            <td align="center"><font color="red">×</font></td>
        {else}
            <td></td>
        {/if}
        <td align="left">{$item[4]}</td>
        <td align="left"><a href="?sbtype_id={$item[3]}#input_form">{$item[5]}</a></td>
        <td align="left">{$item[6]}</a></td>
        {if $item[8] == '1'}
            <td align="center">○</td>
        {else}
            <td align="center"><font color="red">×</font></td>
        {/if}
    </tr>
{/foreach}
</table>

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
