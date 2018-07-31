{$var.html_header}
{$var.form_potision}


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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.form_order_no.error != null}
    <li>{$form.form_order_no.error}<br>
{/if}
{if $form.form_client.error != null}
    <li>{$form.form_client.error}<br>
{/if}
{if $form.form_designated_date.error != null}
    <li>{$form.form_designated_date.error}<br>
{/if}
{if $form.form_ord_day.error != null}
    <li>{$form.form_ord_day.error}<br>
{/if}
{if $form.form_hope_day.error != null}
    <li>{$form.form_hope_day.error}<br>
{/if}
{if $form.form_arr_day.error != null}
    <li>{$form.form_arr_day.error}<br>
{/if}
{if $form.form_ware_select.error != null}
    <li>{$form.form_ware_select.error}<br>
{/if}
{if $form.trade_aord_select.error != null}
    <li>{$form.trade_aord_select.error}<br>
{/if}
{if $form.form_staff_select.error != null}
    <li>{$form.form_staff_select.error}<br>
{/if}
{if $form.form_note_client.error != null}
    <li>{$form.form_note_client.error}<br>
{/if}
{if $form.form_note_head.error != null}
    <li>{$form.form_note_head.error}<br>
{/if}
{if $form.form_sale_num.error != null}
    <li>{$form.form_sale_num.error}<br>
{/if}
{if $var.goods_error0 != null}
    <li>{$var.goods_error0}<br>
{/if}
{if $var.goods_error1 != null}
    <li>{$var.goods_error1}<br>
{/if}
{if $var.goods_error2 != null}
    <li>{$var.goods_error2}<br>
{/if}
{if $var.goods_error3 != null}
    <li>{$var.goods_error3}<br>
{/if}
{if $var.goods_error4 != null}
    <li>{$var.goods_error4}<br>
{/if}
{if $var.goods_error5 != null}
    <li>{$var.goods_error5}<br>
{/if}
{if $var.duplicate_err != null}
    <li>{$var.duplicate_err}<br>
{/if}
</span>

<!-- フリーズ画面判定 -->
{if $var.freeze_flg == true}
    <span style="font: bold;"><font size="+1">以下の内容で受注しますか？</font></span><br>
{/if}

{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1">
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink">受注番号</td>
        <td class="Value">{$form.form_order_no.html}</td>
        <td class="Title_Pink">得意先</a></td>
        <td class="Value">{$form.form_client.html}</td>
        <td class="Title_Pink">FC発注番号</td> 
        <td class="Value">{$form.form_fc_order_no.html}</td>
    </tr>

    <tr>
        <td class="Title_Pink">受注日<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ord_day.html}</td>
        <td class="Title_Pink">出荷可能数</td>
        <td class="Value">{$form.form_designated_date.html} 日後までの発注済数と引当数を考慮する</td>
        <td class="Title_Pink">取引区分<font color="#ff0000">※</font></td>
        <td class="Value">{$form.trade_aord_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">出荷予定日</td>
        <td class="Value">{$form.form_arr_day.html}</td>
        <td class="Title_Pink">直送先</td>
        <td class="Value">{$form.form_direct_name.html}</td>
        <td class="Title_Pink">出荷倉庫<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_ware_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">希望納期</td>
        <td class="Value">{$form.form_hope_day.html}</td>
        <td class="Title_Pink">運送業者</td>
        <td class="Value">{$form.form_trans_check.html}{$form.form_trans_select.html}</td>
        <td class="Title_Pink">担当者<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_staff_select.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（得意先宛）</td>
        <td class="Value" colspan="5">{$form.form_note_client.html}</td>
    </tr>
    <tr>
        <td class="Title_Pink">通信欄<br>（本部宛）</td>
        <td class="Value" colspan="5">{$form.form_note_head.html}</td>
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

{$form.hidden}
{if $var.warning != null}<font color="#ff0000">{$var.warning}</font>{/if}

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="900">
    <tr class="Result1" align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink" width="300">商品コード<font color="#ff0000">※</font><br>商品名<font color="#ff0000">※</font></td>
        <td class="Title_Pink">実棚数<br>(A)</td>
        <td class="Title_Pink">発注済数<br>(B)</td>
        <td class="Title_Pink">引当数<br>(C)</td>
        <td class="Title_Pink">出荷可能数<br>(A+B-C)</td>
        <td class="Title_Pink">受注数<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価単価<font color="#ff0000">※</font><br>売上単価<font color="#ff0000">※</font></td>
        <td class="Title_Pink">原価金額<br>売上金額</td>
    </tr>
    {$var.html}
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right">
            <table class="List_Table" border="1">
                <tr>
                    <td class="Title_Pink" align="center" width="80"><b>税抜金額</b></td>
                    <td class="Value" align="right" width="100">{$form.form_sale_total.html}</td>
                    <td class="Title_Pink" align="center" width="80"><b>消費税</b></td>
                    <td class="Value" align="right" width="100">{$form.form_sale_tax.html}</td>
                    <td class="Title_Pink" align="center" width="80"><b>税込合計</b></td>
                    <td class="Value" align="right" width="100">{$form.form_sale_money.html}</td>
                </tr>
        </table>
        </td>
        {if $var.warning == null}
        <td align="center">
            {$form.form_sum_button.html}
        </td>
        {/if}
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right">{if $var.freeze_flg != true}{$form.order_conf.html}{else}{$form.order.html}{/if}{if $var.aord_id != null}　　{$form.complete.html}{/if}</td>
    </tr>
</table>

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
