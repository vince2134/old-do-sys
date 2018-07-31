{* -------------------------------------------------------------------
 * @Program         2-2-111.php.tpl
 * @fnc.Overview    商品予定出荷一覧
 * @author          kajioka-h <kajioka-h@bhsk.co.jp>
 * @Cng.Tracking    #2: 2007/02/16
 * ---------------------------------------------------------------- *}

{$var.html_header}
<body bgcolor="#D8D0C8">
{* <form name="dateForm" method="post"> *}
<form {$form.attributes}>

{*------------------- 外枠開始 --------------------*}
<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {* 画面タイトル開始 *} {$var.page_header} {* 画面タイトル終了 *}
        </td>
    </tr>

    <tr align="left">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

{* エラーメッセージ出力 *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {* 予定巡回日 *}
    {if $form.form_round_day.error != null}
        <li>{$form.form_round_day.error}<br>
    {/if}
    {* 巡回担当者（複数選択） *}
    {if $form.form_multi_staff.error != null}
        <li>{$form.form_multi_staff.error}<br>
    {/if}
    {* 除外巡回担当者（複数選択） *}
    {if $form.form_not_multi_staff.error != null}
        <li>{$form.form_not_multi_staff.error}<br>
    {/if}
    {* 予定出荷数の半角数値チェック *}
    {if $var.form_num_mess != null}
        <li>{$var.form_num_mess}<br>
    {/if}
{*
    {if $var.charges_msg != null}
        <li>{$var.charges_msg}<br>
    {/if}
    {if $var.chargee_msg != null}
        <li>{$var.chargee_msg}<br>
    {/if}
    {if $var.decimal_msg != null}
        <li>{$var.decimal_msg}<br>
    {/if}
    {if $var.nodecimal_msg != null}
        <li>{$var.nodecimal_msg}<br>
    {/if}
*}
    {* 巡回担当者 *}
    {if $form.form_round_staff.error != null}
        <li>{$form.form_round_staff.error}
    {/if}
</span>
{* 完了メッセージ出力 *} 
<span style="color: #0000FF; font-weight: bold; line-height: 130%;">
    {if $var.done_mess != null}
        <li>{$var.done_mess}<br>
    {/if}
</span>

{*--------------- メッセージ類 e n d ---------------*}

{*-------------------- 画面表示1開始 -------------------*}
{* 共通検索フォーム *}
{$html.html_s}

<br style="font-size: 4px;">

<table class="Table_Search">
<col width="115px" style="font-weight: bold;">
<col width="300px">
<col width="115px" style="font-weight: bold;">
<col width="300px">
    <tr>
        <td class="Td_Search_3">除外巡回担当者<br>（複数選択）</td>
        <td class="Td_Search_3">{$form.form_not_multi_staff.html}<br> 例）0001,0002</td>
        <td class="Td_Search_3"><b>集計区分</b></td>
        <td class="Td_Search_3">{$form.form_count_radio.html}</td>
    </tr>
</table>

<table width='100%'>
    <tr>
        <td align='right'>
            {$form.form_display.html}　　{$form.form_clear.html}
        </td>
    </tr>
</table>
{********************* 画面表示1終了 ********************}

                    <br>
                    </td>
                </tr>


                <tr>
                    <td align="left" valign="top">

{*-------------------- 画面表示2開始 -------------------*}
{* 合計テーブル表示 *}
{$var.html_sum_table}
{* 改ページ *}
<div style="page-break-before: always;"></div>
{* 担当者ごとのテーブル表示 *}
{$var.html}
<br>
{$form.hidden}
{********************* 画面表示2終了 ********************}


                    </td>
                </tr>
            </table>
        </td>
        {********************* 画面表示終了 ********************}

    </tr>
</table>
{******************** 外枠終了 *********************}

{$var.html_footer}
    

