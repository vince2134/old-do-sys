{$var.html_header}

<script language="javascript">
{$var.order_delete}
{$var.hidden_submit}
 </script>

<body bgcolor="#D8D0C8" {$var.javascript}>
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
{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.err_renew_slip.error != null}
    <li>{$form.err_renew_slip.error}<br>
{/if}

{if $form.form_c_staff.error != null}
    <li>{$form.form_c_staff.error}<br>
{/if}
{if $form.form_buy_day.error != null}
    <li>{$form.form_buy_day.error}<br>
{/if}
{if $form.form_multi_staff.error != null}
    <li>{$form.form_multi_staff.error}<br>
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}<br>
{/if}
{if $form.form_buy_amount.error != null}
    <li>{$form.form_buy_amount.error}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>{$html.html_s}</td>
    </tr>
</table>
<br>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>代行売上・紹介売上は仕入金額を確定する根拠となる値です。</li>
</span>
{if $var.post_flg == true && $var.err_flg != true}

<table>
    <tr>
        <td>
{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_cd"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_client_name"}<br>
        </td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_slip"}</td>
        <td class="Title_Blue">
            {Make_Sort_Link_Tpl form=$form f_name="sl_buy_day"}<br>
            <br style="font-size: 4px;">
            {Make_Sort_Link_Tpl form=$form f_name="sl_input_day"}<br>
        </td>
        <td class="Title_Blue">仕入金額<br>(税抜)</td>
        <td class="Title_Blue">消費税額</td>
        <td class="Title_Blue">仕入金額<br>(税込)</td>
        <td class="Title_Act">代行売上</td>
        <td class="Title_Act">紹介売上</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_no"}</td>
        <td class="Title_Blue">{Make_Sort_Link_Tpl form=$form f_name="sl_ord_day"}</td>
        <td class="Title_Blue">取引区分</td>
        <td class="Title_Blue">分割回数</td>
        <td class="Title_Blue">日次更新</td>
        <td class="Title_Blue">削除</td>
    </tr>
    <tr class="Result3">
        <td><b>合計</b></td>
        <td></td>
        <td align="right">{$var.row_count}件</td>
        <td></td>
{*
        <td align="right">{$var.sum1}</td>
        <td align="right">{$var.sum2}</td>
        <td align="right">{$var.sum3}</td>
        <td align="right">{$var.sum4}</td>
        <td align="right">{$var.sum5}</td>
*}
        <td align="right">{$var.gross_notax_amount}<br>{$var.minus_notax_amount}<br>{$var.sum1}<br></td>
        <td align="right">{$var.gross_tax_amount}<br>{$var.minus_tax_amount}<br>{$var.sum2}<br></td>
        <td align="right">{$var.gross_ontax_amount}<br>{$var.minus_ontax_amount}<br>{$var.sum3}<br></td>
        <td align="right">{$var.gross_act_amount}<br>{$var.minus_act_amount}<br>{$var.sum4}<br></td>
        <td align="right">{$var.gross_intro_amount}<br>{$var.minus_intro_amount}<br>{$var.sum5}<br></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
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
        <td>{$row[$j][0]}<br>{$row[$j][1]}</td>
        <td align="center">
            {if $row[$j][11] == 't' || $row[$j][18] == 't'}
                <a href="1-3-205.php?buy_id={$row[$j][2]}">{$row[$j][3]}</a>
            {elseif $row[$j][11] == 'f' && $row[$j][17] == '1'}
                <a href="1-3-201.php?buy_id={$row[$j][2]}">{$row[$j][3]}</a>
            {elseif $row[$j][11] == 'f' && $row[$j][17] == '2'}
                <a href="1-3-207.php?buy_id={$row[$j][2]}">{$row[$j][3]}</a>
            {/if}
        </td>
        <td align="center">{$row[$j][4]}<br>{$row[$j][16]|date_format:"%Y-%m-%d"}</td>
        <td align="right">
            {if $row[$j][6] < 0 }<font color="#ff0000">{$row[$j][6]}</font>
            {else $row[$j][6] < 0 }{$row[$j][6]}</font>{/if}
        </td>
        <td align="right">
            {if $row[$j][7] < 0}<font color="#ff0000">{$row[$j][7]}</font>
            {else}{$row[$j][7]}{/if}
        </td>
        <td align="right">
            {if $row[$j][8] < 0}<font color="#ff0000">{$row[$j][8]}</font>
            {else}{$row[$j][8]}{/if}
        </td>
        <td align="right">
            {if $row[$j][19] < 0}<font color="#ff0000">{$row[$j][19]}</font>
            {else}{$row[$j][19]}{/if}
        </td>
        <td align="right">
            {if $row[$j][20] < 0}<font color="#ff0000">{$row[$j][20]}</font>
            {else}{$row[$j][20]}{/if}
        </td>
        <td align="center"><a href="1-3-103.php?ord_id={$row[$j][9]}">{$row[$j][10]}</a></td>
        <td>{$row[$j][13]}</td>
        <td align="left">{$row[$j][5]}</td>
        {if $row[$j][5] == "割賦仕入"}
        <td align="right"><a href="1-3-206.php?buy_id={$row[$j][2]}&division_flg=true">{$row[$j][14]}回</a></td>
        {else}
        <td></td>
        {/if}
        <td align="center">
            {$row[$j][15]}
        </td>
        <td align="center">
        {* 日次更新前か強制完了していない場合のみ削除可 *}
        {* かつ、自動で起きた仕入じゃない *}
            {if $row[$j][18] == "f" && (($row[$j][11] == 'f' && $row[$j][10] != NULL) || ($row[$j][11] == 'f' && $row[$j][10] == NULL))}
                {if $var.auth == "w"}
                <a href="#" onClick="Order_Delete{$j}('data_delete_flg','buy_h_id','{$row[$j][2]}','hdn_del_enter_date','{$row[$j][16]}');">削除</a>
                {/if}
            {/if}
        </td>
        </tr>
    {/foreach}
    <tr class="Result3">
        <td><b>合計</b></td>
        <td></td>
        <td align="right">{$var.row_count}件</td>
        <td></td>
{*
        <td align="right">{$var.sum1}</td>
        <td align="right">{$var.sum2}</td>
        <td align="right">{$var.sum3}</td>
        <td align="right">{$var.sum4}</td>
        <td align="right">{$var.sum5}</td>
*}
        <td align="right">{$var.gross_notax_amount}<br>{$var.minus_notax_amount}<br>{$var.sum1}<br></td>
        <td align="right">{$var.gross_tax_amount}<br>{$var.minus_tax_amount}<br>{$var.sum2}<br></td>
        <td align="right">{$var.gross_ontax_amount}<br>{$var.minus_ontax_amount}<br>{$var.sum3}<br></td>
        <td align="right">{$var.gross_act_amount}<br>{$var.minus_act_amount}<br>{$var.sum4}<br></td>
        <td align="right">{$var.gross_intro_amount}<br>{$var.minus_intro_amount}<br>{$var.sum5}<br></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
        <td><b></b></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="500" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
<col width="100" align="center" style="font-weight: bold;">
<col width="100" align="right">
    <tr class="Result1">
        <td class="Title_Pink">買掛金額</td> 
        <td align="right"{if $var.kake_nuki_amount < 0} style="color: #ff0000;"{/if}>{$var.kake_nuki_amount}</td>
        <td class="Title_Pink">買掛消費税</td> 
        <td align="right"{if $var.kake_tax_amount < 0} style="color: #ff0000;"{/if}>{$var.kake_tax_amount}</td>
        <td class="Title_Pink">買掛合計</td> 
        <td align="right"{if $var.kake_komi_amount < 0} style="color: #ff0000;"{/if}>{$var.kake_komi_amount}</td>
    </tr>   
    <tr class="Result1">
        <td class="Title_Pink">現金金額</td> 
        <td align="right"{if $var.genkin_nuki_amount < 0} style="color: #ff0000;"{/if}>{$var.genkin_nuki_amount}</td>
        <td class="Title_Pink">現金消費税</td> 
        <td align="right"{if $var.genkin_tax_amount < 0} style="color: #ff0000;"{/if}>{$var.genkin_tax_amount}</td>
        <td class="Title_Pink">現金合計</td> 
        <td align="right"{if $var.genkin_komi_amount < 0} style="color: #ff0000;"{/if}>{$var.genkin_komi_amount}</td>
    </tr>   
    <tr class="Result1">
        <td class="Title_Pink">税抜合計</td>
        <td align="right"{if $var.total_nuki_amount < 0} style="color: #ff0000;"{/if}>{$var.total_nuki_amount}</td>
        <td class="Title_Pink">消費税合計</td> 
        <td align="right"{if $var.total_tax_amount < 0} style="color: #ff0000;"{/if}>{$var.total_tax_amount}</td>
        <td class="Title_Pink">税込合計</td> 
        <td align="right"{if $var.total_komi_amount < 0} style="color: #ff0000;"{/if}>{$var.total_komi_amount}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

{$var.html_page2}

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
