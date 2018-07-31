{$var.html_header}

<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form {$form.attributes}>

<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">


		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- 画面表示1開始 --------------------->

<table width='450'>
    <tr>
        <td align='left'>
            {$form.form_button.close_button.html}
        </td>
    </tr>
</table>
<!--******************** 画面表示1終了 *******************-->

					</td>
				</tr>

				<tr>
					<td>
<br>
<!---------------------- 画面表示2開始 --------------------->
{$form.hidden}
<table class="List_Table" border="1" width="450">
	<tr align="center">
		<td class="Title_Purple" width="30"><b>No.</b></td>
		<td class="Title_Purple"><b>得意先コード<br>得意先名</b></td>
		<td class="Title_Purple"><b>地区</b></td>
		<td class="Title_Purple" width="80"><b>状態</b></td>
	</tr>
    {foreach key=j from=$row item=items}
    <tr class="Result1"> 
		<td align="right">
            　  {$j+1}
        </td>           	
		<td align="left">
			{$row[$j][0]}-{$row[$j][1]}<br>
			{$row[$j][2]}</td>
		</td>
        <td align="center">{$row[$j][3]}</td>
        <td align="center">
        {if $row[$j][4] == 1}
        	取引中
        {else if}
        	取引休止中
        {/if}
        </td>
	</tr>
    {/foreach}
</table>
<!--******************** 画面表示2終了 *******************-->

					</td>
				</tr>
			</table>
		</td>
		<!--******************** 画面表示終了 *******************-->

	</tr>
</table>
<!--******************* 外枠終了 ********************-->
</body>
</html>
	

