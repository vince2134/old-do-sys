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
{* エラーメッセージ *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{* 2009-10-17 aoyama-n *}
{if $form.form_start_day.error != null}
    <li>{$form.form_start_day.error}<br>
{/if}
{if $form.form_end_day.error != null}
    <li>{$form.form_end_day.error}<br>
{/if}
</ul>
</span>

{* 日次更新完了メッセージ *} 
{if $var.renew_msg != null}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>{$var.renew_msg}<br>
</ul>
</span>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table width="500">
    <tr>    
        <td>    

<table class="Data_Table" border="1" width="500">
<col width="100" style="font-weight: bold;">
<col>
    {* 支店明細時（初期表示） *}
    {if $smarty.get.id == null}
    <tr>
        <td class="Title_Green">集計期間</td> 
        {* 2009-10-17 aoyama-n *}
        {* <td class="Value">{$print.monthly_renew_day} 〜 {$form.form_end_day.html}</td> *}
        <td class="Value">{$form.form_start_day.html} 〜 {$form.form_end_day.html}</td>
    </tr>   
    {* 担当者明細時 *}
    {elseif $smarty.get.id != null && $smarty.get.id != "0"}
    <tr>
        <td class="Title_Green">集計期間</td> 
        <td class="Value">{$print.monthly_renew_day} 〜 {$print.end_day}</td>
    </tr>   
    {* 代行明細時 *}
    {elseif $smarty.get.id == "0"}
    <tr>
        <td class="Title_Green">集計期間</td> 
        <td class="Value">{$print.monthly_renew_day} 〜 {$print.end_day}</td>
    </tr>   
    {/if}
</table>

<table width="500">
    <tr>
        <td>{$form.form_renew_button.html}</td>
        <td align="right">{$form.form_show_button.html}　{$form.form_clear_button.html}</td>
    </tr>   
</table>
{* 2009-10-17 aoyama-n *}
{* <table> *}
{*    <tr> *}   
{*        <td style="color: #0000ff; font-weight: bold;">対象となる伝票は、前回月次締日より後の日次更新未実施の伝票です。</li></td> *}
{*   </tr> *}  
{* </table> *}

        </tr>   
    </td>   
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

{if $var.err_flg != true}

<table width="100%">
<tr>
<td>

{* 日次/月次累計 *}
{$html.html_t}<br>

</td>
<td align="right" valign="middle">

</td>
</tr>
<tr>
<td colspan="2">

{* 明細 *}
<table class="List_Table" border="1" width="100%">
<col width="30">
<col width="100">
<col>
<col width="0">
<col width="100">
<col width="0">
<col width="100">
<col width="0">
<col width="100">
<col width="100">
<col width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green" rowspan="2">No.</td>
        <td class="Title_Green" rowspan="2">取扱区分</td>
        <td class="Title_Green" rowspan="2">販売区分</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green">日次未実施累計</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green">日次実施済累計</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green" colspan="3">合計</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">金額</td>
        <td class="Title_Green">金額</td>
        <td class="Title_Green">明細件数</td>
        <td class="Title_Green">原価</td>
        <td class="Title_Green">金額</td>
    </tr>
{$html.html_m}
</table>

{/if}

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
