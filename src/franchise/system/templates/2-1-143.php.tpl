{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

{*+++++++++++++++ 外枠 begin +++++++++++++++*}
<table width="100%" height="90%" class="M_table">

    {*+++++++++++++++ ヘッダ類 begin +++++++++++++++*}
    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">{$var.page_header}</td>
    </tr>
    {*--------------- ヘッダ類 e n d ---------------*}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
    	<tr align="center" valign="top" height="160">
        <td>
            <table>
                <tr>
                    <td>

{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

<!-- 画面遷移元判定 -->
{if $var.disp_stat == 1 || $var.disp_stat == 5 || $var.disp_stat == 6}
	<!-- レンタルID無し・取消済・新規申請中 -->
	<span style="font: bold;"><font size="+1">登録完了しました。<br><br></font></span>
{elseif ($var.disp_stat == 2 && $var.stat_flg == false) || $var.online_flg == "f" }
	<!-- 契約済・解約済(解約済のみ) -->
	<span style="font: bold;"><font size="+1">変更完了しました。<br><br></font></span>
{else}
	<!-- 契約済・解約済　解約申請　解約予定 -->
	<span style="font: bold;"><font size="+1">解約申請完了しました。<br><br></font></span>
{/if}
<table width="100%">
    <tr>
        <td align="right">{$form.input_btn.html}　　{$form.disp_btn.html}　　{$form.con_btn.html}</td>
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
