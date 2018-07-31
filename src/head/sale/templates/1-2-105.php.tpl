{$var.html_header}

<script language="javascript">
{$var.order_delete}
</script>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
{$form.hidden}

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
{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.err_saled_slip.error != null}
    <li>{$form.err_saled_slip.error}<br>
{/if}
{if $form.form_c_staff.error != null}
    <li>{$form.form_c_staff.error}<br>
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}<br>
{/if}
{if $form.form_aord_day.error != null}
    <li>{$form.form_aord_day.error}<br>
{/if}
{if $form.form_arrival_day.error != null}
    <li>{$form.form_arrival_day.error}<br>
{/if}
{if $form.form_hope_day.error != null}
    <li>{$form.form_hope_day.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>

<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<li>発注番号があるものはオンライン受注です</li>
</span>
{$var.html_page}
<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_aord_no"}</td>
        <td class="Title_Act">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_no"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_direct"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_aord_day"}</td>
        <td class="Title_Pink">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Pink">受注金額</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_hope_day"}</td>
        <td class="Title_Pink">{Make_Sort_Link_Tpl form=$form f_name="sl_arrival_day"}</td>
        <td class="Title_Pink">売上入力</td>
        <td class="Title_Pink">削除</td>
    </tr>
    {foreach key=j from=$row item=items}
    {if bcmod($j, 2) == 0}
    <tr class="Result1">
    {else}  
    <tr class="Result2">
    {/if} 
        <td align="right">
            {$var.no+$j}
        </td>
        {*オンラインかつ処理が完了していない場合*}
        {if $row[$j][11] == 't' && ($row[$j][12] == '1' || $row[$j][12] == '2')}
            <td align="center"><a href="1-2-110.php?aord_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        {*オフラインかつ処理が完了していない場合*}
        {elseif $row[$j][11] == 'f' && ($row[$j][12] == '1' || $row[$j][12] == '2')}
            <td align="center"><a href="1-2-101.php?aord_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        {*処理が完了している場合は確認に遷移*}
        {else}
            <td align="center"><a href="1-2-108.php?aord_id={$row[$j][0]}">{$row[$j][2]}</a></td>
        {/if}
        <td align="center">{$row[$j][9]}</td>
        <td>{$row[$j][18]}</td>
        <td align="center">{$row[$j][1]}</td>
        <td>{$row[$j][13]}-{$row[$j][14]}<br>{$row[$j][3]}</td>
        <td align="right">{$row[$j][4]}</td>
        <td align="center">{$row[$j][5]}</td>
        <td align="center">{$row[$j][6]}</td>
        {*オンラインかチェック済みで処理状況が１か２*}
        {if ($row[$j][12] == '1' || $row[$j][12] == '2')}
        <td align="center" class="color">
            <a href="1-2-201.php?aord_id={$row[$j][0]}">入力</a>
        </td>
        {else}
        <td align="center">
            済
        </td>
        {/if}
        <td align="center">
        {if $row[$j][12] == 1 && $var.disabled == NULL && $row[$j][17] == null}
            <a href="#" onClick="Order_Delete('data_delete_flg','aord_id_flg',{$row[$j][0]},'hdn_del_enter_date','{$row[$j][16]}');">削除</a>
        {/if}
        </td>
    </tr>
    {/foreach}
    <tr class="Result3" align="center">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.total_price}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
{$var.html_page2}

<table>
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
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
