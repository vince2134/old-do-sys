{$var.html_header}
<script>{$var.javascript}</script>
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
{* エラーメッセージ出力 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{*if $form.form_order_all_check.error != null       --2007.06.14削除--- *}         
{*   <li>{$form.form_order_all_check.error*}{*<br>*}
{*/if*}

{if $form.form_close_day.error != null} {* ---2007.06.14追加--- *}
    <li>{$form.form_close_day.error}<br>
{/if}
{if $form.form_order_day.error != null}
    <li>{$form.form_order_day.error}<br>
{/if}
{if $form.form_buy_amount.error != null}
    <li>{$form.form_buy_amount.error}<br>
{/if}
{if $form.form_pay_amount.error != null}
    <li>{$form.form_pay_amount.error}<br>
{/if}

{foreach from=$err_message key=i item=item}
    <li>{$item}</li>
{/foreach}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="800">
    <tr>
        <td>
{* ---- 2006.06.14追加 ----*}
<table width="100%">
    <tr style="color: #555555;">
        <td width="60"><b>表示件数</b></td>
        <td >   {$form.form_show_num.html}
                <span style="color: #0000ff; font-weight: bold;">
                　・「仕入先」検索は名前もしくは略称です</span></td>
    </tr>
</table>
{* ---- 表示件数 END ----*}
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Td_Search_1">仕入締日</td>
        <td class="Td_Search_1">{$form.form_close_day.html}</td>
        <td class="Td_Search_1">支払予定日</td>
        <td class="Td_Search_1">{$form.form_order_day.html}</td>
    </tr>
    <tr>
        <td class="Td_Search_1">今回仕入額（税込）</td>
        <td class="Td_Search_1">{$form.form_buy_amount.html}</td>
        <td class="Td_Search_1">今回支払予定額</td>
        <td class="Td_Search_1">{$form.form_pay_amount.html}</td>
    </tr>
    <tr>
        <td class="Td_Search_1">FC・取引先区分</td>
        <td class="Td_Search_1">{$form.form_rank.html}</td>
        <td class="Td_Search_1">FC・取引先</td>
        <td class="Td_Search_1">{$form.form_client.html} {$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Td_Search_1">更新状況</td>
        <td class="Td_Search_1" colspan="3">{$form.form_update_state.html}</td>
    </tr>
{*    <tr>  2007.06.14#コメント
        <td class="Title_Blue">表示件数</td>
        <td class="Value" colspan="3">{$form.form_show_num.html*}{*</td>
    </tr>
*}
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　　{$form.clear_button.html}</td>
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
{if $var.err_flg != true}
<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    
{* ---2006.06.14追加 初期表示は表示なし---- *}
 {if $post_flg == 'true' }
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Blue">No.</td>
        <td class="Title_Blue">仕入締日</td>    {* ---2007.06.14追加 --- *}
        <td class="Title_Blue">仕入先</td>
        <td class="Title_Blue">支払予定日</td>
        <td class="Title_Blue">前回支払残</td>
        <td class="Title_Blue">支払額</td>
        <td class="Title_Blue">繰越金額</td>
        <td class="Title_Blue">今回仕入額</td>
        <td class="Title_Blue">消費税額</td>
        <td class="Title_Blue">今回仕入額（税込）</td>
        <td class="Title_Blue">今回支払残</td>
        <td class="Title_Blue">今回支払予定額</td>
        <td class="Title_Blue">支払明細{*$form.form_order_all_check.html*}</td>
        <td class="Title_Blue">{$form.payment_all_delete.html}</td>
        <td class="Title_Blue">{$form.payment_all_update.html}</td>
    </tr>
{/if}

    {foreach key=j from=$row item=items}
    {* 偶数なら色付けない *}
    {if $j==0 || $j%2==0}
        <tr class="Result1">
    {else}
        {* 奇数なら色付ける *}
        <tr class="Result2">
    {/if}
       <td align="right">
            {if $smarty.post.f_page1 != null}
		{if $var.r == 10}
                   {$smarty.post.f_page1*10+$j-9}
		{elseif $var.r == 50}
                   {$smarty.post.f_page1*50+$j-49}
		{elseif $var.r == 100}
                   {$smarty.post.f_page1*100+$j-99}
		{else}
	       　  {$j+1}
		{/if}
            {else if}
            　  {$j+1}
            {/if}
        </td>
        <td align="center">{$row[$j][13]}</td>  {* ---仕入締日 追加#2007.06.14 --- *}
	    <td align="left">{$row[$j][0]}<br>{$row[$j][12]}</td>
        <td align="center">{$row[$j][2]}</td>
        <td align="right"{if $row[$j][3] < 0} style="color: #ff0000;"{/if}>{$row[$j][3]|number_format}</td>
        <td align="right"{if $row[$j][4] < 0} style="color: #ff0000;"{/if}>{$row[$j][4]|number_format}</td>
        <td align="right"{if $row[$j][5] < 0} style="color: #ff0000;"{/if}>{$row[$j][5]|number_format}</td>
        <td align="right"{if $row[$j][6] < 0} style="color: #ff0000;"{/if}>{$row[$j][6]|number_format}</td>
        <td align="right"{if $row[$j][7] < 0} style="color: #ff0000;"{/if}>{$row[$j][7]|number_format}</td>
        <td align="right"{if $row[$j][8] < 0} style="color: #ff0000;"{/if}>{$row[$j][8]|number_format}</td>
        <td align="right"{if $row[$j][9] < 0} style="color: #ff0000;"{/if}>{$row[$j][9]|number_format}</td>
        <td align="right"{if $row[$j][10] < 0} style="color: #ff0000;"{/if}>{$row[$j][10]|number_format}</td>
        {* --- 2007.06.14#支払明細リンク追加 --- *}
        <td align="center"><a href="1-3-308.php?pay_id={$row[$j][11]}&c_id={$row[$j][14]}" target="_self">明細</a>{*$form.form_order_check[$j].html*}</td> 
        <td align="center">{$form.payment_delete[$j].html}</td>
        <td align="center">{$form.payment_update[$j].html}</td>
    </tr>
    {/foreach}
    
    {* ---2006.06.14追加 初期表示は表示なし---- *}
    {if $post_flg == 'true' }
    <tr class="Result3">
        <td><b>合計</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right"{if $var.sum1 < 0} style="color: #ff0000;"{/if}>{$var.sum1|number_format}</td>
        <td align="right"{if $var.sum2 < 0} style="color: #ff0000;"{/if}>{$var.sum2|number_format}</td>
        <td align="right"{if $var.sum3 < 0} style="color: #ff0000;"{/if}>{$var.sum3|number_format}</td>
        <td align="right"{if $var.sum4 < 0} style="color: #ff0000;"{/if}>{$var.sum4|number_format}</td>
        <td align="right"{if $var.sum5 < 0} style="color: #ff0000;"{/if}>{$var.sum5|number_format}</td>
        <td align="right"{if $var.sum6 < 0} style="color: #ff0000;"{/if}>{$var.sum6|number_format}</td>
        <td align="right"{if $var.sum7 < 0} style="color: #ff0000;"{/if}>{$var.sum7|number_format}</td>
        <td align="right"{if $var.sum8 < 0} style="color: #ff0000;"{/if}>{$var.sum8|number_format}</td>
        <td align="center"></td>
        <td align="center">{$form.cancel_button.html}</td>
        <td align="center">{$form.renew_button.html}</td>
    </tr>
    {/if}
</table>
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
