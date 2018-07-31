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
<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Yellow">出力形式</td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象倉庫</td>
        <td class="Value">{$form.form_ware.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.show_button.html}　　{$form.clear_button.html}</td>
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
{$form.hidden}

<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
【棚卸日：{$var.invent_day}　棚卸調査番号：{$var.invent_no}　前回棚卸調査番号：{if $var.last_no != '0000000000'}{$var.last_no}{/if}】
</span>
<br><br>

{* 倉庫数分表示*}
{foreach key=x from=$row item=items}
    <span style="font bold 15px; color: #555555;">【{$row[$x][0][0]}】</span><br>
    <table class="List_Table" border="1" width="100%">
        <tr align="center" style="font-weight: bold;">
            <td class="Title_Yellow">No.</td>
            <td class="Title_Yellow">Ｍ区分</td>
            <td class="Title_Yellow">品名</td>
            <td class="Title_Yellow">棚卸数</td>
            <td class="Title_Yellow">棚卸単価</td>
            <td class="Title_Yellow">棚卸金額</td>
            <td class="Title_Yellow">前回在庫数</td>
            <td class="Title_Yellow">前回在庫金額</td>
            <td class="Title_Yellow">前回対比数</td>
            <td class="Title_Yellow">前回対比金額</td>
        </tr>

        {* 倉庫データ表示*}
        {foreach key=j from=$row[$x] item=items}
        
        {* データ判定 *}
        {if $row[$x][$j][1] == "Ｍ区分計"}
            {* Ｍ区分計表示 *}
            <tr class="Result2">
                <td align="right">　</td>
                <td align="left" colspan="4"><b>{$row[$x][$j][1]}</b></td>
                {if $row[$x][$j][2] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][2]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][2]}</td>
                {/if}
                <td align="left" colspan="3">　</td>
                {if $row[$x][$j][3] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][3]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][3]}</td>
                {/if}
            </tr>
        {elseif $row[$x][$j][1] == "倉庫計"}
            {* 倉庫計表示 *}
            <tr class="Result3">
                <td align="left" colspan="5"><b>{$row[$x][$j][1]}</b></td>
                {if $row[$x][$j][2] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][2]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][2]}</td>
                {/if}
                <td align="left" colspan="3">　</td>
                {if $row[$x][$j][3] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][3]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][3]}</td>
                {/if}
            </tr>
        {else}
            {* データ表示 *}
            <tr class="Result1">
                <td align="right">{$j+1}</td>
                <td align="left">{$row[$x][$j][1]}</td>
                <td align="left">{$row[$x][$j][2]}</td>
                {if $row[$x][$j][3] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][3]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][3]}</td>
                {/if}
                {if $row[$x][$j][4] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][4]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][4]}</td>
                {/if}
                {if $row[$x][$j][5] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][5]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][5]}</td>
                {/if}
                {if $row[$x][$j][6] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][6]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][6]}</td>
                {/if}
                {if $row[$x][$j][7] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][7]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][7]}</td>
                {/if}
                {if $row[$x][$j][8] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][8]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][8]}</td>
                {/if}
                {if $row[$x][$j][9] < 0}
                    <td align="right"><font color="#ff0000">{$row[$x][$j][9]}</font></td>
                {else}
                    <td align="right">{$row[$x][$j][9]}</td>
                {/if}
            </tr>
        {/if}
        {/foreach}
    </table>

        </td>
    </tr>
    <tr>
        <td>

    <table align="right">
        <tr>
            <td>{$form.form_back_button.html}</td>
        </tr>
    </table>
    <br><br>
{/foreach}

<span style="font: bold 15px; color: #555555;">【全倉庫】</span>
<span style="color: blue; font-weight: bold; line-height: 130%;">
    全倉庫の棚卸数が0の場合、棚卸単価は表示されません。
</span>
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">Ｍ区分</td>
        <td class="Title_Yellow">商品名</td>
        <td class="Title_Yellow">棚卸数</td>
        <td class="Title_Yellow">棚卸単価</td>
        <td class="Title_Yellow">棚卸金額</td>
        <td class="Title_Yellow">前回在庫数</td>
        <td class="Title_Yellow">前回在庫金額</td>
        <td class="Title_Yellow">前回対比数</td>
        <td class="Title_Yellow">前回対比金額</td>
    </tr>
    {* 倉庫データ表示*}
    {foreach key=j from=$total item=items}
    
    {* データ判定 *}
    {if $total[$j][1] == "Ｍ区分計"}
        {* Ｍ区分計表示 *}
        <tr class="Result2">
            <td align="right">　</td>
            <td align="left" colspan="4"><b>{$total[$j][1]}</b></td>
            {if $total[$j][2] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][2]}</font></td>
            {else}
                <td align="right">{$total[$j][2]}</td>
            {/if}
            <td align="left" colspan="3">　</td>
            {if $total[$j][3] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][3]}</font></td>
            {else}
                <td align="right">{$total[$j][3]}</td>
            {/if}
        </tr>
    {elseif $total[$j][1] == "倉庫計"}
        {* 倉庫計表示 *}
        <tr class="Result3">
            <td align="left" colspan="5"><b>{$total[$j][1]}</b></td>
            {if $total[$j][2] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][2]}</font></td>
            {else}
                <td align="right">{$total[$j][2]}</td>
            {/if}
            <td align="left" colspan="3">　</td>
            {if $total[$j][3] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][3]}</font></td>
            {else}
                <td align="right">{$total[$j][3]}</td>
            {/if}
        </tr>
    {else}
        {* データ表示 *}
        <tr class="Result1">
            <td align="right">{$j+1}</td>
            <td align="left">{$total[$j][0]}</td>
            <td align="left">{$total[$j][1]}</td>
            {if $total[$j][2] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][2]}</font></td>
            {else}
                <td align="right">{$total[$j][2]}</td>
            {/if}
            {if $total[$j][3] != null}
                {if $total[$j][3] < 0}
                    <td align="right"><font color="#ff0000">{$total[$j][3]}</font></td>
                {else}
                    <td align="right">{$total[$j][3]}</td>
                {/if}
            {else}
                <td align="center">-</td>
            {/if}
            {if $total[$j][4] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][4]}</font></td>
            {else}
                <td align="right">{$total[$j][4]}</td>
            {/if}
            {if $total[$j][5] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][5]}</font></td>
            {else}
                <td align="right">{$total[$j][5]}</td>
            {/if}
            {if $total[$j][6] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][6]}</font></td>
            {else}
                <td align="right">{$total[$j][6]}</td>
            {/if}
            {if $total[$j][7] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][7]}</font></td>
            {else}
                <td align="right">{$total[$j][7]}</td>
            {/if}
            {if $total[$j][8] < 0}
                <td align="right"><font color="#ff0000">{$total[$j][8]}</font></td>
            {else}
                <td align="right">{$total[$j][8]}</td>
            {/if}
        </tr>
    {/if}
    {/foreach}
</table>

<table align="right">
    <tr>
        <td>{$form.form_back_button.html}</td>
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
