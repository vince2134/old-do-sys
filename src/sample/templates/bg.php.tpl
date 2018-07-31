
{$var.html_header}

<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
{$form.hidden}
<table  class="Data_Table" border="1" width="450" >
	<tr>
		<td class="Value">入力箇所{$form.form_data.html}</td>
	</tr>
	<tr>
		<td class="Value">hiddenの値を復元{$form.form_hidden.html}</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align='right'>
			{$form.touroku.html}　{$form.clear_button.html}
		</td>
	</tr>
</table>


{$var.html_footer}
	

