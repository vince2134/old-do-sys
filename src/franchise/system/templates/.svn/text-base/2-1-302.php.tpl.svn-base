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
    <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

{*+++++++++++++++ メッセージ類 begin +++++++++++++++*}
{* 登録・変更完了メッセージ出力 *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>

{* エラーメッセージ出力 *}
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.password.error != null}<li>{$form.password.error}<br>{/if}
{if $form.password_conf.error != null}<li>{$form.password_conf.error}<br>{/if}
<!-- 現在のパスワード比較 -->
{if $var.error_msg != null}
    <li>{$var.error_msg}<br>
{/if}
{*--------------- メッセージ類 e n d ---------------*}

{*+++++++++++++++ 画面表示１ begin +++++++++++++++*}
<table class="Data_Table" border="1" width="450">
	<tr>
		<td class="Title_Purple" width="140"><b>現在のパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.password_now.html}</td>
	</tr>
	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font></b></td>
		<td class="Value">{$form.password.html}</td>
	</tr>

	<tr>
		<td class="Title_Purple" width="140"><b>新しいパスワード<font color="#ff0000">※</font><br>(確認用)</b></td>
		<td class="Value">{$form.password_conf.html}</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align="left">
            <font color="#ff0000"><b>※は必須入力です</b></font>
        </td>
		<td align="right">
			{$form.touroku.html}
		</td>
	</tr>
</table>
{*--------------- 画面表示１ e n d ---------------*}

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
