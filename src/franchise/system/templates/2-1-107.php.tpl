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
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="700">
<col width="140" style="font-weight: bold;">
<col width="140">
<col width="140"style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value">{$form.form_client_cd.html}</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value">{$form.form_client_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">ネットワーク証ID</td>
        <td class="Value">{$form.form_staff_cd.html}</td>
        <td class="Title_Purple">スタッフ名</td>
        <td class="Value">{$form.form_staff_name.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">担当者コード</td>
        <td class="Value">{$form.form_charge_cd.html}</td>
        <td class="Title_Purple">支店・所属部署</td>
        <td class="Value">{$form.form_part.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">役職</td>
        <td class="Value">{$form.form_position.html}</td>
        <td class="Title_Purple">職種</td>
        <td class="Value">{$form.form_job_type.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">在職識別</td>
        <td class="Value" colspan="3">{$form.form_state.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">トイレ診断士資格</td>
        <td class="Value" colspan="3">{$form.form_toilet_license.html}</td>
    </tr>
    <tr>
        <td class="Title_Purple">取得資格</td>
        <td class="Value" colspan="3">{$form.form_license.html}</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value" colspan="3">{$form.form_output_type.html}</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2">

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
{if $var.display_flg == true}

<table width="100%">
    <tr>
        <td>

全<b>{$var.total_count}</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ショップコード<br>ショップ名</td>
        <td class="Title_Purple">担当者<br>コード</td>
        <td class="Title_Purple">ネットワーク証ID<br>スタッフ名</td>
        <td class="Title_Purple">役職</td>
        <td class="Title_Purple">支店</td>
        <td class="Title_Purple">所属部署</td>
        <td class="Title_Purple">職種</td>
        <td class="Title_Purple">在職識別</td>
        <td class="Title_Purple">トイレ診断士資格</td>
        <td class="Title_Purple">取得資格</td>
    </tr>
    {foreach key=j from=$row item=items}
    <tr class="{$tr[$j]}">
        <td align="right">{$j+1}</td>
        {if $row[$j][1] != null}
        <td>{$row[$j][0]}-{$row[$j][1]}</a>
        {else}
        <td>
        {/if}
        <br>{$row[$j][2]}</td>
        <td>{$row[$j][3]}</td>
        <td>
        {if $row[$j][5] != null}
            {$row[$j][5]}-{$row[$j][6]}
        {/if}
        <br><a href="2-1-108.php?staff_id={$row[$j][4]}">{$row[$j][7]}</a></td>
        <td>{$row[$j][9]}</td>
        <td>{$row[$j][14]}</td>
        <td>{$row[$j][8]}</td>
        <td>{$row[$j][10]}</td>
        <td align="center">{$row[$j][11]}</td>
        <td align="center">{$row[$j][12]}</td>
        <td>{$row[$j][13]}</td>
    </tr>
    {/foreach}
</table>
{$form.hidden}
        </td>
    </tr>
</table>

{/if}
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
