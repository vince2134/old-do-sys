{* -------------------------------------------------------------------
 * @Program         1-4-204.php.tpl
 *                  2-4-204.php.tpl
 * @fnc.Overview    棚卸入力
 * @author          kajioka-h <kajioka-h@bhsk.co.jp>
 * @Cng.Tracking    #3: 2007/01/23
 * ---------------------------------------------------------------- *}

{$var.html_header}
{$var.html_js}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
{if $var.price_error_mess != null}
    <li>{$var.price_error_mess}
{/if}
{if $var.tstock_error_mess != null}
    <li>{$var.tstock_error_mess}
{/if}
{if $var.staff_error_mess != null}
    <li>{$var.staff_error_mess}
{/if}
{if $var.cause_error_mess != null}
    <li>{$var.cause_error_mess}
{/if}
{if $var.db_unique_error_mess != null}
    <li>{$var.db_unique_error_mess}
{/if}
{if $var.unique_error_mess != null}
    <li>{$var.unique_error_mess}
{/if}
{if $var.injustice_error_mess != null}
    <li>{$var.injustice_error_mess}
{/if}
{if $var.staff_line_err != null}
    <li>{$var.staff_line_err}<br>
{/if}
{if $var.staff_select_err != null}
    <li>{$var.staff_select_err}<br>
{/if}
{if $var.renew_err_mess != null}
    <li>{$var.renew_err_mess}<br>
{/if}
{if $var.remake_err_mess != null}
    <li>{$var.remake_err_mess}<br>
{/if}
</ul>
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="400">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">棚卸調査表番号</td>
        <td class="Value">{$var.invent_no}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Value">{$var.expected_day}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">倉庫</td>
        <td class="Value">{$var.ware_name}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象商品</td>
        <td class="Value">{$var.target_goods}</td>
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

<table class="Data_Table" width="500">
<col width="120" style="font-weight: bold;">
    <tr>
        <td rowspan="2" class="Title_Yellow">棚卸実施者</td>
        <td class="Value">{$form.form_staff_set.html}</td>
    </tr>
    <tr>
        <td class="Value">{$form.form_line.html}　　　{$form.form_conf_button.html}</td>
    </tr>
</table>

        </td>
        <td align="right" valign="bottom">{if $var.add_flg == "false"}{$form.form_add_button.html}{if $form.f_page1.html != null}&nbsp;|&nbsp;{$form.f_page1.html}{/if}{else}{$form.form_input_button.html}{/if}</td>

    </tr>
</table>
{*--------------- 画面表示２ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示３ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
{* <table class="List_Table" border="1" style="table-layout: fixed"> *}
    <tr align="center" height="30" style="font-weight: bold;">
        <td class="Title_Yellow" width="25">No.</td>
        <td class="Title_Yellow" width="150" nowrap>商品分類</td>
        <td class="Title_Yellow" width="380">商品コード<br>商品名</td>
        <td class="Title_Yellow" width="50" nowrap>単位</td>
        <td class="Title_Yellow" width="100">在庫単価<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="75">帳簿数<br>実柵数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="75">差異</td>
        <td class="Title_Yellow" width="160">棚卸実施者<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" width="105">差異原因</td>
{if $var.target_goods != "在庫数0" && $var.add_flg == "true"}
        <td class="Title_Yellow" width="45" nowrap>行<br>(<a href="#" onClick="javascript:Button_Submit_1('add_row_flg', '#', 'true')">追加</a>)
</td>
{/if}
    </tr>

{*--- 棚卸入力一覧 ---*}
{* {$var.html} *}

{foreach key=i from=$disp_data item=item}
{* {if $disp_data[0]%2 != 0} *}
<tr class="Result1">
{* {else} *}
{* <tr class="Result2"> *}
{* {/if} *}

{* 行番号 *}
{* <td align="right">{$item[0]}</td> *}
<td align="right">{$item}</td>

{* 商品分類 *}
{* <td>{$form.form_g_product_name[$item].html}</td> *}
<td>{$form.form_g_product_name[$i].html}</td>

{* 商品CD、商品名 *}
{*
<td>{$form.form_goods_cd[$item].html}{if $var.add_flg == "true"}({$form.form_search[$item].html}){/if}<br>
{$form.form_goods_name[$item].html}</td>
*}
<td>{$form.form_goods_cd[$i].html}{if $var.add_flg == "true"}({$form.form_search[$i].html}){/if}<br>
{$form.form_goods_name[$i].html}</td>

{* 単位 *}
{* <td>{$form.form_unit[$item].html}</td> *}
<td>{$form.form_unit[$i].html}</td>

{* 在庫単価 *}
{* <td>{$form.form_price[$item].i.html}.{$form.form_price[$item].d.html}</td> *}
<td>{$form.form_price[$i].i.html}.{$form.form_price[$i].d.html}</td>

{* 帳簿数、実棚数 *}
{* <td>{$form.form_stock_num[$item].html}<br>{$form.form_tstock_num[$item].html}</td> *}
<td>{$form.form_stock_num[$i].html}<br>{$form.form_tstock_num[$i].html}</td>

{* 差異 *}
{* <td>{$form.form_diff_num[$item].html}</td> *}
<td>{$form.form_diff_num[$i].html}</td>

{* 棚卸実施者 *}
{* <td>{$form.form_staff[$item].html}</td> *}
<td>{$form.form_staff[$i].html}</td>

{* 差異原因 *}
{* <td>{$form.form_cause[$item].html}</td> *}
<td>{$form.form_cause[$i].html}</td>

{* 削除 *}
{* {if $disp_data[$item][5] == "t" && $var.add_flg == "true"} *}
{if $var.add_flg == "true"}
{* <td align="center">{$form.add_row_del[$item].html}</td> *}
<td align="center">{$form.add_row_del[$i].html}</td>
{/if}

</tr>
{/foreach}

{$form.hidden}
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">
        {* {if $var.renew_err_mess == null && $var.remake_err_mess == null && $var.sess_err_mess == null}{$form.form_entry_button.html}　　{$form.form_temp_button.html}　　{/if}{$form.form_back_button.html} *}

        {if $var.renew_err_mess == null && $var.remake_err_mess == null}{if $var.add_flg == "false"}{$form.form_entry_back.html}　　{$form.form_entry_next.html}　　{/if}{if $form.form_entry_add_button.html}{$form.form_entry_add_button.html}　　{/if}{$form.form_entry_button.html}　　{/if}{$form.form_back_button.html}
        </td>
    </tr>
</table>

<table width="100%">
    <tr><td align="right" valign="middle">{if $var.add_flg == "false"}{$form.form_add_button.html}{if $form.f_page2.html}&nbsp;|&nbsp;{$form.f_page2.html}{/if}{else}{$form.form_input_button.html}{/if}</td></tr>
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
