{$var.html_header}

<script>
{$var.javascript}
</script>
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
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value">{$form.form_shop_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップ名/社名</td>
        <td class="Value">{$form.form_shop_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC・取引先区分</td>
        <td class="Value">{$form.form_rank_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value">{$form.form_area_1.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先コード</td>
        <td class="Value">{$form.form_claim_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求先名</td>
        <td class="Value">{$form.form_claim_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">担当者</td>
        <td class="Value">{$form.form_staff_1.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value">{$form.form_tel.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="350">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right">{$form.form_button.show_button.html}　　{$form.form_button.clear_button.html}</td>
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

{if $var.display_flg == true}

<table width="100%">
    <tr>
        <td>

全<b>{$var.match_count}</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" valign="bottom" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_shop_name"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_rank"}</td>
        <td class="Title_Purple"> {Make_Sort_Link_Tpl form=$form f_name="sl_area"}</td>
        <td class="Title_Purple">
            {Make_Sort_Link_Tpl form=$form f_name="sl_claim_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_claim_name"}<br>
        </td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_staff"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_tel"}</td>
        <td class="Title_Purple">{Make_Sort_Link_Tpl form=$form f_name="sl_day"}</td>
        <td class="Title_Purple">状　態</td>
        <td class="Title_Purple">{$form.label_check_all.html}</td>
{*
        <td class="Title_Purple">{$form.form_shop_all.html}</td>
        <td class="Title_Purple">{$form.form_staff_all.html}</td>
        <td class="Title_Purple">{$form.form_input_all.html}</td>
        <td class="Title_Purple">契約内容</td>
*}
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
        <td align="right">
            {if $smarty.post.f_page1 != null}
                {$smarty.post.f_page1*10+$j-9}
            {else if}
            　  {$j+1}
            {/if}
        </td>               
        <td>
            {$row[$j][1]}-{$row[$j][2]}<br>
            <a href="1-1-103.php?client_id={$row[$j][0]}">{$row[$j][3]}</a></td>
        </td>
        <td>{$row[$j][4]}</td>
        <td align="center">{$row[$j][5]}</td>
        <td align="center">{$row[$j][6]}</td>
        <td>{$row[$j][7]}-{$row[$j][8]}<br>{$row[$j][9]}</td>
        <td align="center">{$row[$j][10]}</td>
        <td>{$row[$j][12]}</td>
        <td align="center">{$row[$j][13]}</td>
        <td align="center">
        {if $row[$j][11] == 1}
            取引中
        {else if}
            解約・休止中
        {/if}
        </td>
        <td align="center">{$form.form_label_check[$j].html}</td>
{*
        <td align="center">{$form.form_shop_check[$j].html}</td>
        <td align="center">{$form.form_staff_check[$j].html}</td>
        <td align="center"><input type="checkbox" name="form_input_check[{$j}]" value="{$row[$j][0]}"></td>    
        <td align="center"><a href="1-1-123.php?client_id={$row[$j][0]}">変更</a></td>
*}
    </tr>
    {/foreach}
    <tr class="Result2">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center" colspan="2">{$form.form_label_button.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>

{/if}
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
