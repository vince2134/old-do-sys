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
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
                <tr>
                    <td>

{*+++++++++++++++ 画面表示２ begin +++++++++++++++*}
<table width="100%">
    <tr>
        <td>

{if $var.state == "henkouirai"}<span style="font: bold 15px; color: #555555;">変更前</span><br>{/if}
<table class="Data_Table" border="1" width="50%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップ担当者</td>
        <td class="Value">FC担当者</td>
    </tr>
    <tr>
        <td class="Title_Purple">お客様名</td>
        <td class="Value">バブ日立ソフト</td>
    </tr>
    <tr>
        <td class="Title_Purple">お客様TEL</td>
        <td class="Value">045-xxx-xxxx</td>
    </tr>
    <tr>
        <td class="Title_Purple">お客様住所</td>
        <td class="Value">〒123-4567</td>
    </tr>
    <tr>
        <td class="Title_Purple">レンタル申込日</td>
        <td class="Value">2006-04-01</td>
    </tr>
</table>
<br><br>

<table class="Data_Table" border="1" width="50%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">レンタル出荷日</td>
        <td class="Value">2006-04-02</td>
    </tr>
    <tr>
        <td class="Title_Purple">本部担当者</td>
        <td class="Value">本部担当者</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"></td>
    </tr>
</table>
<br><br>

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">レンタル状況</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">シリアル</td>
        <td class="Title_Purple">レンタル単価<br>ユーザ提供単価</td>
        <td class="Title_Purple">レンタル金額<br>ユーザ提供金額</td>
        <td class="Title_Purple">変更</td>
        <td class="Title_Purple">解約</td>
        <td class="Title_Purple">レンタル変更・解約日</td>
    </tr>
{foreach key=i from=$disp_goods_data item=item}
    <tr class="{$disp_goods_data[$i][0]}">
        <td align="center">{$disp_goods_data[$i][1]}</td>
        <td>{$disp_goods_data[$i][2]}</td>
        <td>{$disp_goods_data[$i][3]}</td>
        <td align="right">{$disp_goods_data[$i][4]}</td>
        <td>{$disp_goods_data[$i][5]}</td>
        <td align="right">{$disp_goods_data[$i][6][0]}<br>{$disp_goods_data[$i][6][1]}</td>
        <td align="right">{$disp_goods_data[$i][7][0]}<br>{$disp_goods_data[$i][7][1]}</td>
        <td>{$disp_goods_data[$i][8]}</td>
        {if $i != 3}
        <td align="center">{$form.form_check1.html}</td>
        {else}
        <td></td>
        {/if}
        <td align="center">{$form.day[$i].html}</td>
    </tr>
{/foreach}
</table>

<table align="right">
    <tr>
        <td>
            {$form.form_kaiyaku_button.html}　{$form.form_back_button.html}
        </td>
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
