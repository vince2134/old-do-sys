{* -------------------------------------------------------------------
 * @Program         1-4-201.php.tpl
 *                  2-4-201.php.tpl
 * @fnc.Overview    棚卸調査表作成・一覧
 * @author          kajioka-h <kajioka-h@bhsk.co.jp>
 * @Cng.Tracking    #3: 2007/01/22
 * ---------------------------------------------------------------- *}

{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table border="0" width="100%" height="90%" class="M_table">

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
{if $var.err_mess != null}
    <li>{$var.err_mess}<br>
{/if}
</span>
{*--------------- メッセージ類 e n d ---------------*}

<table>
    <tr>
        <td>

{if $disp=="u"}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
    <!-- エラー表示 -->
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <!-- 棚卸日 -->
    {if $form.form_create_day.error != null}
        <li>{$form.form_create_day.error}<br>
    {/if}   
    </span> 


<table class="Data_Table" border="1" width="100%">
<col width="80" style="font-weight: bold;">
{*
    <tr>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Value" width="300">{$data1[0]}</td>
    </tr>
*}
        <tr>    
            <td class="Title_Yellow">棚卸日<font color="#ff0000">※</font></td> 
            <td class="Value" width="300">{$form.form_create_day.html}</td>
        </tr>   


    <tr>
        <td class="Title_Yellow">対象商品</td>
        <td class="Value" width="300">{$form.form_target_goods.html}</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td>{$form.create_button.html}　　{$form.clear_button.html}</td>
    </tr>
</table>

<!-- 棚卸データが0の場合のエラー表示 -->
{if $data2 != null}
<br><br><br>
<table width="100%">
    <tr>
        <td><span style="color: #0000ff; font-weight: bold; line-height: 130%;">{$data2[0]}</span></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>
{/if}

{*--------------- 画面表示１ e n d ---------------*}

{elseif $disp=="l"}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
{$form.hidden}

<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">【現在調査中の棚卸】　{$form.form_delete_button.html}</span><br>

<table class="Data_Table" border="1" width="100%">
    <tr>
        <td class="Title_Yellow" width="60"><b>棚卸日</b></td>
        <td class="Value" align="center">{$data1[0]}</td>
        <td class="Title_Yellow" width="120"><b>棚卸調査表番号</b></td>
        <td class="Value">{$data1[1]}</td>
        <td class="Title_Yellow" width="80"><b>対象商品</b></td>
        <td class="Value">{$data1[2]}</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">倉庫</td>
        <td class="Title_Yellow" colspan="2">棚卸調査表</td>
        <td class="Title_Yellow" rowspan="2">棚卸入力</td>
        <td class="Title_Yellow" rowspan="2">棚卸一覧表</td>
        <td class="Title_Yellow" rowspan="2">一時登録</td>
    </tr>
    <tr align="center">
        <td class="Title_Yellow"><b>帳票印刷</b>（<a href="{if $var.group_kind == "1"}1{else}2{/if}-4-202.php?invent_no={$data1[1]}" target="_blank">全倉庫</a>）</td>
        <td class="Title_Yellow"><b>CSV出力</b>（<a href="{if $var.group_kind == "1"}1{else}2{/if}-4-201.php?invent_no={$var.invent_no}&ware_id=all">全倉庫</a>）</td>
    </tr>
    {foreach from=$data2 item=item key=i}
    {if $data2[$i][4] == "t"}
    <tr class="Result5">
    {else}
    <tr class="Result1">
    {/if}
        <td align="right">{$i+1}</td>
        <td>{$data2[$i][2]}</td>
        <td align="center"><a href="{if $var.group_kind == "1"}1{else}2{/if}-4-202.php?invent_no={$data2[$i][0]}&ware_id={$data2[$i][1]}" target="_blank">帳票印刷</a></td>
        <td align="center"><a href="{if $var.group_kind == "1"}1{else}2{/if}-4-201.php?invent_no={$data2[$i][0]}&ware_id={$data2[$i][1]}">CSV出力</a></td>
        <td align="center"><a href="{if $var.group_kind == "1"}1{else}2{/if}-4-204.php?invent_no={$data2[$i][0]}&ware_id={$data2[$i][1]}">入力</a></td>
        {if $data2[$i][3] == 't' && $data2[$i][4] == "f"}
        <td align="center"><a href="{if $var.group_kind == "1"}1{else}2{/if}-4-208.php?invent_no={$data2[$i][0]}&ware_id={$data2[$i][1]}">表示</a></td>
        {else}
        <td></td>
        {/if}
        {if $data2[$i][4] == "t"}
        <td align="center">一時登録</a></td>
        {else}
        <td></td>
        {/if}
    </tr>
    {/foreach}
</table>
{*--------------- 画面表示１ e n d ---------------*}

{/if}

        </td>
    </tr>
</table>

                    </td>
                </tr>
            </table>
    {*--------------- コンテンツ部 e n d ---------------*}

        </td>
    </tr>
</table>
{*--------------- 外枠 e n d ---------------*}

        </td>
    </tr>
</table>

{$var.html_footer}
