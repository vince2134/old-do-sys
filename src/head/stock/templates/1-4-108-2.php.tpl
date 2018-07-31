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

{* 表示権限のみ時のメッセージ *} 
{if $var.auth_r_msg != null}
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li>{$var.auth_r_msg}</li>
    </span><br>
{/if}

    {*+++++++++++++++ コンテンツ部 begin +++++++++++++++*}
		<tr align="center" valign="top" height="160">
        <td>
            <table>

				<!-- 登録確認メッセージ表示 -->
		        <tr>
	                <td>
						<span style="font: bold;">
							<font size="+1">在庫調整を完了しました。<br><br></font>
						</span>
						<table width="100%">
						    <tr>
						        <td align="right">{$form.ok_button.html}　{$form.return_button.html}</td>
						    </tr>
						</table>
				    </td>
	            </tr>
            </table>
        </td>
    </tr>
    {*--------------- コンテンツ部 e n d ---------------*}

</table>
{*--------------- 外枠 e n d ---------------*}

{$var.html_footer}
