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

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>ショップ名</b></td>
        <td class="Value">アメニティ東陽</td>
        <td class="Title_Purple" width="80"><b>取引区分</b></td>
        <td class="Value">掛売上</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="750">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">運送業者</td>
        <td class="Value" colspan="3">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先</td>
        <td class="Value">{$form.form_direct_select.html}</td>
        <td class="Title_Purple">出荷倉庫</td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">担当者</td>
        <td class="Value" colspan="3">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="3">{$form.form_note_your.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">出荷日</td>
        <td class="Value" colspan="3">

            <table border="0">
                <tr>
                    <td rowspan="3">{$form.form_round_div.html}</td>
                    <td>
                        <font color="#555555">
                        (1) 基準日 {$form.form_stand_day1.html}<br>
                        (2) 基準日 {$form.form_stand_day2.html}
                        </font>
                    <td valign="bottom">
                        <font color="#555555">
                        ： {$form.form_rmonth.html} ヶ月周期の {$form.form_day.html}<br>
                        ： {$form.form_rweek.html} 週間周期の {$form.form_week.html} 曜日
                        </font>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示３ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">商品コード<font color="#ff0000">※</font></td>
        <td class="Title_Purple">商品名<font color="#ff0000">※</font></td>
        <td class="Title_Purple">数量<font color="#ff0000">※</font></td>
        <td class="Title_Purple">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Purple">原価金額<br>売上金額</td>
        <td class="Title_Purple">行削除</td>
    </tr>
    <tr class="Result1">
        <td align="center">1</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result2">
        <td align="center">2</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
    <tr class="Result1">
        <td align="center">3</td>
        <td>{$form.form_goods_cd.html}</td>
        <td>{$form.form_goods_name.html}</td>
        <td align="right">{$form.form_num.html}</td>
        <td align="right">{$form.form_genkatanka.html}<br>{$form.form_uriagetanka.html}</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">削除</a></td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td>{$form.add_row_link.html}</td>
    <td align="right">
        <table class="List_Table" border="1">
            <tr>
                <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
                <td class="Value" align="right">{$form.form_sale_total.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
                <td class="Value" align="right">{$form.form_sale_tax.html}</td>
                <td class="Title_Pink" align="center" width="80"><b>税込合計</b></td>
                <td class="Value" align="right">{$form.form_sale_money.html}</td>
            </tr>
        </table>
    </td>
    <td align="right">{$form.form_sum_btn.html}</td>
    </tr>
    <tr>
        <td>
            <font color="#ff0000"><b>※は必須入力です</b></font>
        </td>
        <td align="right" colspan="2">
            {$form.entry_button.html}　　{$form.return_button.html}
        </td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示３ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
