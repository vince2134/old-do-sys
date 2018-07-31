{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
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
    {if $form.f_collect_day.error != null}
        <li>{$form.f_collect_day.error}<br>
    {/if}
    {if $form.f_bill_close_day_this.error != null}
        <li>{$form.f_bill_close_day_this.error}<br>
    {/if}
    </span>

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="700" >
    <tr>
        <td>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">回収予定日</td>
        <td class="Value" colspan="3">{$form.f_collect_day.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求締日</td>
        <td class="Value" colspan="3">{$form.f_bill_close_day_this.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求先コード</td>
        <td class="Value">{$form.f_claim_cd.html}</td>
        <td class="Title_Pink">請求先名</td>
        <td class="Value">{$form.f_claim_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">銀行コード</td>
        <td class="Value">{$form.f_bank_cd.html}</td>
        <td class="Title_Pink">銀行名</td>
        <td class="Value">{$form.f_bank_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">支店コード</td>
        <td class="Value">{$form.f_branch_cd.html}</td>
        <td class="Title_Pink">支店名</td>
        <td class="Value">{$form.f_branch_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">預金種別</td>
        <td class="Value">{$form.f_account_class.html}</td>
        <td class="Title_Pink">口座番号</td>
        <td class="Value">{$form.f_bank_account.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">請求番号</td>
        <td class="Value">{$form.f_bill_no.html}</td>
        <td class="Title_Pink">集金方法</td>
        <td class="Value">{$form.f_pay_way.html}</td>
    </tr>
    <tr>
        <td class="Title_Blue">表示件数</td>
        <td class="Value" colspan="3">{$form.show_number.html}</td>
    </tr>
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
<table width="100%">
    <tr>
        <td>

{$var.html_page}
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">回収予定日</td>
        <td class="Title_Pink">請求締日</td>
        <td class="Title_Pink">請求番号</td>
        <td class="Title_Pink">請求先</td>
        <td class="Title_Pink">集金方法</td>
        <td class="Title_Pink">銀行</td>
        <td class="Title_Pink">支店</td>
        <td class="Title_Pink">預金種目<br>口座番号</td>
        <td class="Title_Pink">回収予定額</td>
        <td class="Title_Pink">入金額</td>
    </tr>
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
        <td align="center">{$row[$j][0]}<br>
        <td align="center">{$row[$j][1]}</td>
        <td align="left">{$row[$j][2]}</td>
        <td align="left">{$row[$j][3]}-{$row[$j][4]}<br>{$row[$j][5]}</td>
        <td align="left">{$row[$j][6]}</td>
        <td align="left">{$row[$j][7]}<br>{$row[$j][8]}</td>
        <td align="left">{$row[$j][9]}<br>{$row[$j][10]}</td>
        <td align="left">{$row[$j][11]}<br>{$row[$j][12]}</td>
        <td align="right">{$row[$j][13]}</td>
        <td align="right">{$row[$j][14]}</td>
    </tr>
    {/foreach}
    <tr class="Result3">
        <td>合計</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="right">{$var.sum1}</td>
        <td align="right">{$var.sum2}</td>
    </tr>
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
