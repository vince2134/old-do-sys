
{$var.html_header}
<script language="javascript">{$var.code_value} </script>

<body bgcolor="#D8D0C8">
<form name="referer" method="post">
{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            {*- 画面タイトル開始 -*} {$var.page_header} {*- 画面タイトル終了 -*}
        </td>
    </tr>

    <tr align="center">
    
        {*--------------------- 画面表示開始 --------------------*}
        <td valign="top">

            <table border="0">
                <tr>
                    <td>
</form>
{*--------------------- 画面表示1開始 --------------------*}
{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}
<form {$form.attributes}>
<table width=450>
    <tr>
        <td align="right">
            {if $smarty.get.goods_id != null}
                {$form.back_button.html}
                {$form.next_button.html}
            {/if}
        </td> 
   </tr>
</table>
<table border="0">
<tr valign="top">
<td>
<table class="Data_Table" border="1" width="350" align="left">
{if $smarty.session.group_kind == '2'}
    <tr>
        <td class="Title_Purple"><b>状態</b></td>
        <td class="Value">{$form.form_state_type.html}</td>
    </tr>
{/if}
    <tr>
        <td class="Title_Purple" width="100"><b>構成品コード</b></td>
        <td class="Value">{$form.form_goods_cd.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>構成品名</b></td>
        <td class="Value">{$form.form_goods_name.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>略称</b></td>
        <td class="Value">{$form.form_goods_cname.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>単位</b></td>
        <td class="Value">{$form.form_unit.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>課税区分</b></td>
        <td class="Value">{$form.form_tax_div.html}</td>
    </tr>

    <tr>
        <td class="Title_Purple" width="100"><b>品名変更</b></td>
        <td class="Value">{$form.form_name_change.html}</td>
    </tr>

</table>

<table class="Data_Table" border="1" width="290">
    {foreach from=$form.form_rank_price item=item key=i name=price}
    <tr>
        <td class="Title_Purple" width="110"><b>{$form.form_rank_price[$i].label}</b></td>

        <td class="Value" align="right">{$form.form_rank_price[$i].html}</td>
    </tr>   
    {/foreach}
</table>

<tr valign="top">

<table width="450">
    <tr>
        <td align="left">
        </td>
    </tr>
</table>
</td>
</tr>

{*-******************** 画面表示1終了 *******************-*}

                    </td>
                </tr>

                <tr>
                    <td>

{*--------------------- 画面表示2開始 --------------------*}
<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple"><b>No.</b></td>
        <td class="Title_Purple"><b>商品コード</b></td>
        <td class="Title_Purple"><b>商品名</b></td>
        <td class="Title_Purple"><b>仕入単価</b></td>
        <td class="Title_Purple"><b>数量</b></td>
        <td class="Title_Purple"><b>仕入金額</b></td>
    </tr>
{$var.html}
{$form.hidden}

{*-******************** 画面表示2終了 *******************-*}

                    </td>
                </tr>
            </table>
        </td>
        {*-******************** 画面表示終了 *******************-*}

    </tr>
</table>

{*-******************* 外枠終了 ********************-*}

{$var.html_footer}
