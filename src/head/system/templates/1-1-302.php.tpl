
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> {$var.page_header} <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border="0">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->
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
</span><br>

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
<!--******************** 画面表示1終了 *******************-->

					<br>
					</td>
				</tr>
					</td>
				</tr>
			</table>
		</td>
<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->

{$var.html_footer}
	

