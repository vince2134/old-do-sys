{$var.html_header}
<script language="javascript">
{$var.js}
{$var.code_value}
</script>

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
        <td valign="top">
            <table>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{if $smarty.get.goods_id != null}
<table width="100%">
    <tr>
        <td>

<table align="right">
    <tr>
        <td>{$form.back_button.html}　{$form.next_button.html}</td> 
   </tr>
</table>

        </td>
    </tr>
</table>
{/if}
{*--------------- 画面表示１ e n d ---------------*}


{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table>
    <tr valign="top">
        <td>

<span style="font: bold 15px; color: #555555;">【構成内容】</span>

{*+++++++++++++++ メッセージ類２ begin +++++++++++++++*}
{* エラーメッセージ出力 *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.form_goods_cd.error != null}
        <li>{$form.form_goods_cd.error}<br>
    {/if}
    {if $form.form_goods_name.error != null}
        <li>{$form.form_goods_name.error}<br>
    {/if}
    {if $form.form_goods_cname.error != null}
        <li>{$form.form_goods_cname.error}<br>
    {/if}
    {if $form.form_price[0].error != null}
        <li>{$form.form_price[0].error}
    {/if}
    {if $form.form_price[1].error != null}
        <li>{$form.form_price[1].error}
    {/if}
    </span>
{*--------------- メッセージ類２ e n d ---------------*}

<table class="Data_Table" border="1" width="400" align="left">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value">{$form.form_state_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">構成品コード<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_goods_cd.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">構成品名<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">単位</td>
        <td class="Value">{$form.form_unit.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">課税区分</td>
        <td class="Value">{$form.form_tax_div.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">品名変更</td>
        <td class="Value">{$form.form_name_change.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">承認</td>
        <td class="Value">{$form.form_accept.html}</td>
    </tr>
</table>

<table class="Data_Table" border="1" width="300">
    {foreach from=$form.form_rank_price item=item key=i name=price}
    <tr>
        <td class="Title_Purple" width="110"><b>{$form.form_rank_price[$i].label}</b></td>
        <td class="Value" align="right">{$form.form_rank_price[$i].html}</td>
        {if $i == 0 && $smarty.get.goods_id == null && $var.freeze_flg != true}
        <td class="Value" rowspan="{$smarty.foreach.price.total}">{$form.form_total_button.html}</td>
        {/if}
    </tr>
    {/foreach}
</table>

        </td>
    </tr>
    <tr valign="top">
        <td>

<table>
    <tr>
        <td align="left"><b><font color="#ff0000">※は必須入力です</font></b></td>
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
{$form.hidden}
<table width="100%">
    <tr valign="top">
        <td>

<span style="font: bold 15px; color: #555555;">【構成内容】</span>

{*+++++++++++++++ メッセージ類２ begin +++++++++++++++*}
{* エラーメッセージ出力 *}
     <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    {if $form.price_err.error != null}
        <li>{$form.price_err.error}
    {/if}
    {if $form.parts_goods_err.error != null}
        <li>{$form.parts_goods_err.error}
    {/if}
    {if $form.count_err.error != null}
        <li>{$form.count_err.error}
    {/if}
    </span>
{*--------------- メッセージ類２ e n d ---------------*}

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">仕入単価</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">仕入金額</td>
    {if $var.freeze_flg != true && $smarty.get.goods_id == null}
        <td class="Title_Purple">行(<a href="#" onClick="javascript:Button_Submit_1('add_flg', '#', 'true')">追加</a>)</td>
    {/if}
    </tr>
    {$var.html}
</table>

<table align="right">
    <tr>
        <td>{$form.form_entry_button.html}　　{$form.form_back_button.html} </td>
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
