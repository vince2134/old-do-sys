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

{$var.calendar}</td></tr></table><br>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
	<tr>
		<td>{$form.set.html}　　{$form.kuria.html}　　{$form.back.html}</td>
	</tr>
</table>

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
