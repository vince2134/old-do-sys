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
		<table class="Data_Table" border="1" width="450">
		    <tr align="left">
		        <td class="Title_Purple" width="120"><b>ショップ名</b></td>
		        <td class="Value">東陽</td>
		    </tr>
		    <tr align="left"">
		        <td class="Title_Purple" width="120"><b>年月</b></td>
		        <td class="Value">{$form.form_day_y.html} - {$form.form_day_m.html} 〜 {$form.form_day2_y.html} - {$form.form_day2_m.html}</td>
		    </tr>
		</table>
        </td>
    </tr>
    <tr align="right">
        <td>{$form.form_show_button.html}　{$form.form_clear_button.html}</td>
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

<table class="Data_Table" border="1" width="650">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">年月</td>
        <td class="Title_Purple">種別</td>
        <td class="Title_Purple">人数</td>
        <td class="Title_Purple">単価</td>
        <td class="Title_Purple">合計</td>
        <td class="Title_Purple">総計</td>
        <td class="Title_Purple">備考</td>
    </tr>
{foreach from=$disp_data key=i item=item}
    <tr class="{$disp_data.$i[0]}">
        <td rowspan="4" align="center">{$disp_data.$i[1]}</td>
        <td rowspan="4" align="center">{$disp_data.$i[2]}</td>
        <td align="left">{$disp_data.$i[3]}</td>
        <td align="right">{$disp_data.$i[4]}</td>
        <td align="right">{$disp_data.$i[5]}</td>
        <td align="right">{$disp_data.$i[6]}</td>
        <td rowspan="4" align="right">{$disp_data.$i[7]}</td>
        <td rowspan="4">{$disp_data.$i[8]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[9]}</td>
        <td align="right">{$disp_data.$i[10]}</td>
        <td align="right">{$disp_data.$i[11]}</td>
        <td align="right">{$disp_data.$i[12]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[13]}</td>
        <td align="right">{$disp_data.$i[14]}</td>
        <td align="right">{$disp_data.$i[15]}</td>
        <td align="right">{$disp_data.$i[16]}</td>
    </tr>
    <tr class="{$disp_data.$i[0]}">
        <td align="left">{$disp_data.$i[17]}</td>
        <td align="right">{$disp_data.$i[18]}</td>
        <td align="right">{$disp_data.$i[19]}</td>
        <td align="right">{$disp_data.$i[20]}</td>
    </tr>
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
