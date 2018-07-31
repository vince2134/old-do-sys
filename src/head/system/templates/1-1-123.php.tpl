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

<span style="font: bold 15px; color: #555555;">契約情報</span>　{$form.form_btn_add_keiyaku.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">出荷日</td>
        <td class="Title_Purple">担当者</td>
        <td class="Title_Purple">直送先</td>
        <td class="Title_Purple">運送業者</td>
        <td class="Title_Purple">出荷倉庫</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">原価単価<br>売上単価</td>
        <td class="Title_Purple">原価金額<br>売上金額</td>
        <td class="Title_Purple">原価計<br>売上計</td>
        <td class="Title_Purple">備考</td>
    </tr>
{foreach key=i from=$disp_data1 item=item}
{foreach key=j from=$item[7] item=goods name=count}
    <tr class="{$item[1]}">
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="center"><a href="1-1-104.php?contract_id={$item[0]}">{$i+1}</a></td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[2]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[3]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[4]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[5]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[6]}</td>
        {/if}
        <td>{$goods[0]}</td>
        <td>{$goods[1]}</td>
        <td align="right">{$goods[2]}</td>
        <td align="right">{$goods[3][0]}<br>{$goods[3][1]}</td>
        <td align="right">{$goods[4][0]}<br>{$goods[4][1]}</td>
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="right">{$item[8][0]}<br>{$item[8][1]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[9]}</td>
        {/if}
    </tr>
{/foreach}
{/foreach}
</table>
<br>

<span style="font: bold 15px; color: #555555;">レンタル情報</span>　{$form.form_btn_add_rental.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">レンタル開始日</td>
        <td class="Title_Purple">お客様名</td>
        <td class="Title_Purple">TEL</td>
        <td class="Title_Purple">〒<br>住所</td>
        <td class="Title_Purple">レンタル申込日</td>
        <td class="Title_Purple">商品コード</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">シリアル</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">レンタル料</td>
        <td class="Title_Purple">レンタル金額</td>
        <td class="Title_Purple">備考</td>
    </tr>
{foreach key=i from=$disp_data2 item=item}
{foreach key=j from=$item[9] item=goods name=count}
    <tr class="{$item[1]}">
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}" align="center"><a href="1-1-141.php?rental_id={$item[0]}">{$i+1}</a></td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[2]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[3]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[4]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{if {$item[5] != null}〒{/if}{$item[5]}<br>{$item[6]}<br>{$item[7]}</td>
        <td rowspan="{$smarty.foreach.count.total}">{$item[8]}</td>
        {/if}
        <td>{$goods[0]}</td>
        <td>{$goods[1]}</td>
        <td>{if $goods[2] != null}{foreach key=k from=$goods[2] item=serial}{$serial}<br>{/foreach}{/if}</td>
        <td align="right">{$goods[3]}</td>
        <td align="right">{$goods[4]}</td>
        <td align="right">{$goods[5]}</td>
        {if $j == 0}
        <td rowspan="{$smarty.foreach.count.total}">{$item[10]}</td>
        {/if}
    </tr>
{/foreach}
{/foreach}
</table>
<br>

<span style="font: bold 15px; color: #555555;">取引外情報</span>　{$form.form_btn_add_hoken.html}<br>
<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">種別</td>
        <td class="Title_Purple">人数</td>
        <td class="Title_Purple">単価</td>
        <td class="Title_Purple">合計</td>
        <td class="Title_Purple">総計</td>
        <td class="Title_Purple">備考</td>
    </tr>
    {foreach key=i from=$disp_data3[0] item=insurance name=count}
    <tr class="{$insurance[1]}">
        <td align="center"><a href="./1-1-131.php?insurance_id={$insurance[0]}">{$i+1}</a></td>
        <td>{$insurance[2]}</td>
        <td align="right">{$insurance[3]}</td>
        <td align="right">{$insurance[4]}</td>
        <td align="right">{$insurance[5]}</td>
        {if $i == 0}
        <td class="Result1" rowspan="{$smarty.foreach.count.total}" align="right">{$disp_data3[1]}</td>
        <td class="Result1" rowspan="{$smarty.foreach.count.total}">{$disp_data3[2]}</td>
        {/if}
    </tr>
    {/foreach}
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
