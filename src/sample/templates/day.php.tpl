
{$var.html_header}

<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.f_datetime.error != null}<li>{$form.f_datetime.error}<br>{/if}
</span><br>
<font size="+1">日付取得関数</font>
<table  class="Data_Table" border="1" width="450" >
	<tr>
		<td class="Title_Purple"><b>日付入力</b></td>
		<td class="Value">{$form.f_datetime.html}</td>
		<td class="Value">{$form.t_display.html}</td>
	</tr>
</table>
<table width="450">
	<tr>
		<td align='right'>
			{$form.touroku.html}　　{$form.reset.html}
		</td>
	</tr>
</table>


{$var.html_footer}
	

