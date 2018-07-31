{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<font color="#0000ff"><b>・以下の在庫を移動しました。</b></font>　　{$form.form_comp_button.html}<br>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">商品コード<br>商品名</td>
        <td class="Title_Yellow" colspan="2">移動元</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow" colspan="2">移動先</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">倉庫名</td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
        <td class="Title_Yellow">移動数</td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">倉庫名</td>
        <td class="Title_Yellow">在庫数<br>（引当数）</td>
    </tr>
    {* 1行目 *}
    <tr class="Result1">
        <td align="right">1</td>
        <td>{$form.t_goods1_code.html}<br>{$form.t_goods1_name.html}</td>
        <td>{$form.form_ware_3.html}</td>
        <td align="right">{$form.t_goods1_num1.html}<br>{$form.t_goods1_num2.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td>{$form.t_goods1_unit.html}</td>
        <td>{$form.form_ware_4.html}</td>
        <td align="right">{$form.t_goods1_num3.html}<br>{$form.t_goods1_num4.html}</td>
    </tr>
    {* 2行目 *}
    <tr class="Result1">
        <td align="right">2</td>
        <td>{$form.t_goods2_code.html}<br>{$form.t_goods2_name.html}</td>
        <td>{$form.form_ware_5.html}</td>
        <td align="right">{$form.t_goods2_num1.html}<br>{$form.t_goods2_num2.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td>{$form.t_goods2_unit.html}</td>
        <td>{$form.form_ware_6.html}</td>
        <td align="right">{$form.t_goods2_num3.html}<br>{$form.t_goods2_num4.html}</td>
    </tr>
    {* 3行目 *}
    <tr class="Result1">
        <td align="right">3</td>
        <td>{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
        <td>{$form.form_ware_7.html}</td>
        <td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td>{$form.t_goods3_unit.html}</td>
        <td>{$form.form_ware_8.html}</td>
        <td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
    </tr>
    {* 4行目 *}
    <tr class="Result1">
        <td align="right">4</td>
        <td>{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
        <td>{$form.form_ware_7.html}</td>
        <td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td>{$form.t_goods3_unit.html}</td>
        <td>{$form.form_ware_8.html}</td>
        <td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
    </tr>
    {* 5行目 *}
    <tr class="Result1">
        <td align="right">5</td>
        <td>{$form.t_goods3_code.html}<br>{$form.t_goods3_name.html}</td>
        <td>{$form.form_ware_7.html}</td>
        <td align="right">{$form.t_goods3_num1.html}<br>{$form.t_goods3_num2.html}</td>
        <td align="center">{$form.f_text9.html}</td>
        <td>{$form.t_goods3_unit.html}</td>
        <td>{$form.form_ware_8.html}</td>
        <td align="right">{$form.t_goods3_num3.html}<br>{$form.t_goods3_num4.html}</td>
    </tr>
</table>

        </td>
    </tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
