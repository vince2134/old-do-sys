{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
{$form.hidden}
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
{if $smarty.get.sinsei_msg != NULL}
	<!-- 申請取消ボタン押下 -->
	<span style="font: bold;"><font size="+1">申請取消完了しました。<br><br></font></span>
{elseif $smarty.get.kaiyaku_msg != NULL}
	<!-- 解約取消ボタン押下 -->
	<span style="font: bold;"><font size="+1">解約取消完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 6 && $smarty.get.online_flg == 't'}
	<!-- 新規申請中 -->
	<span style="font: bold;"><font size="+1">承認完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 2 && $smarty.get.online_flg == 't'}
	<!-- 契約済・解約済 -->
	<span style="font: bold;"><font size="+1">変更完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 3 && $smarty.get.online_flg == 't'}
	<!-- 解約申請 -->
	<span style="font: bold;"><font size="+1">解約承認・実施完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 4}
	<!-- 解約予定(オンライン・オフライン) -->
	<span style="font: bold;"><font size="+1">解約取消完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 1 && $smarty.get.online_flg == 'f'}
	<!-- 新規申請中(オフライン) -->
	<span style="font: bold;"><font size="+1">登録完了しました。<br><br></font></span>
{* {elseif $smarty.get.disp_stat == 2 && $smarty.get.online_flg == 'f'} *}
{elseif $smarty.get.disp_stat == 2 && $smarty.get.online_flg == 'f' && $smarty.get.edit_flg == false}
	<!-- 契約済・解約済(オフライン) -->
	<span style="font: bold;"><font size="+1">解約完了しました。<br><br></font></span>
{elseif $smarty.get.disp_stat == 2 && $smarty.get.online_flg == 'f'}
	<!-- 変更(オフライン) -->
	<span style="font: bold;"><font size="+1">変更完了しました。<br><br></font></span>
{/if}
<table width="100%">
    <tr>
        <td align="right">
		<!-- 申請取消ボタン押下時にはデータが無い為、変更画面ボタン非表示 -->
		{if $smarty.get.sinsei_msg == NULL}
			{$form.input_btn.html}　　
		{/if}
		{$form.disp_btn.html}　　{$form.aord_btn.html}</td>
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
