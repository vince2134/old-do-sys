{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">


		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- ����ɽ��1���� --------------------->

<table width='450'>
    <tr>
        <td align='left'>
            {$form.form_button.close_button.html}
        </td>
    </tr>
</table>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>
<br>
<!---------------------- ����ɽ��2���� --------------------->
{$form.hidden}
<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple"><b>�����襳����<br>������̾</b></td>
		<td class="Title_Purple"><b>�϶�</b></td>
		<td class="Title_Purple" width="80"><b>����</b></td>
	</tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
		<td align="right">
            ��  {$j+1}
        </td>           	
		<td align="left">
			{$row[$j][0]}-{$row[$j][1]}<br>
			{$row[$j][2]}</td>
		</td>
        <td align="center">{$row[$j][3]}</td>
        <td align="center">
        {if $row[$j][4] == 1}
        	�����
        {else if}
        	����ٻ���
        {/if}
        </td>
	</tr>
    {/foreach}
</table>
<!--******************** ����ɽ��2��λ *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->
</body>
</html>
	

