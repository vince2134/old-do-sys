
{$var.html_header}

<script language="javascript">
{$var.code_value} 
</script>

<body background="../../../image/back_purple.png">
 <form {$form.attributes}>

<font size="+0.5" color="#555555"><b>�ڹ��ɲá��Ժ����</b></font>
<input type="button" value="�������" onClick='javascript:location.href = "./watanabe_add_row.php"'>
<br><br>

<table class="List_Table" align="center" border="1" width="500">
	<tr align="center">
		<td class="Title_Purple" width="100"><b>NO</b></td>
		<td class="Title_Purple" width="300"><b>����̾</b></td>
		<td class="Title_Purple" width="100"><b>��(<a href="javascript:Button_Submit_1('add_row_flg', '#', 'true')">�ɲ�</a>)</b></td>
	</tr>
{$var.html}
{$form.hidden}

</table>

{$var.html_footer}
	

