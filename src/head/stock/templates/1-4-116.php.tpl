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
<span style="color: {$var.mesg_color}; font-weight: bold; line-height: 130%;">
{if $var.mesg != null}
<li>{$var.mesg}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{if $var.del_button_flg == false}
<table width="550">
    <tr>
        <td>

<table class="Data_Table" border="1"width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">組立管理番号</td>
        <td class="Value">{$build_goods_data[0].build_cd}</td>
        <td class="Title_Yellow">組立日</td>
        <td class="Value">{$build_goods_data[0].build_day}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">完成品コード</td>
        <td class="Value">{$build_goods_data[0].goods_cd}</td>
        <td class="Title_Yellow">完成品名</td>
        <td class="Value">{$build_goods_data[0].goods_name}</td>
    </tr>
        <td class="Title_Yellow">組立数</td>
        <td class="Value" colspan="3">{$build_goods_data[0].build_num}</td>
    <tr>
        <td class="Title_Yellow">引落倉庫</td>
        <td class="Value">{$build_goods_data[0].output_ware_name}</td>
        <td class="Title_Yellow">入庫倉庫</td>
        <td class="Value">{$build_goods_data[0].input_ware_name}</td>
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
<table width="550">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
</span>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">商品コード</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">構成数</td>
        <td class="Title_Yellow">使用数</td>
    </tr>
    {foreach from=$parts_goods_data key=i item=item}
    <tr class="Result1">
        <td align="right">{$parts_goods_data[$i].no}</td>
        <td align="left">{$parts_goods_data[$i].goods_cd}</td>
        <td align="left">{$parts_goods_data[$i].goods_name}</td>
        <td align="right">{$parts_goods_data[$i].parts_num}</td>
        <td align="right">{$parts_goods_data[$i].num}</td>
    </tr>
    {/foreach}
</table>
{/if}

<table width="100%">
    <tr>
        {if $smarty.get.new_flg == "true"}
        <td align="right">{$form.form_ok_button.html}</td>
        {else}
        <td align="right">{if $var.del_button_flg == false}{$form.form_del_button.html}　　{/if}{$form.form_back_button.html}</td>
        {/if}
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
{$form.hidden}
{$var.html_footer}
