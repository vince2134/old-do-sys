
{$var.html_header}

<body bgcolor="#D8D0C8">
<form {$form.attributes}>
<!--------------------- ³°ÏÈ³«»Ï ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ²èÌÌ¥¿¥¤¥È¥ë³«»Ï --> {$var.page_header} <!-- ²èÌÌ¥¿¥¤¥È¥ë½ªÎ» -->
		</td>
	</tr>

	<tr align="center">
	

		<!---------------------- ²èÌÌÉ½¼¨³«»Ï --------------------->
		<td valign="top">
		
			<table border="0">
				<tr>
					<td>

<!---------------------- ²èÌÌÉ½¼¨1³«»Ï --------------------->
{* ÅÐÏ¿¡¦ÊÑ¹¹´°Î»¥á¥Ã¥»¡¼¥¸½ÐÎÏ *}
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>
<table width='750'>
	<tr>
		<td align="left"><font size="+0.5"><b>°õ»ú¥Ñ¥¿¡¼¥ó¤òÅÐÏ¿¤·¤Þ¤·¤¿¡£</b></font>¡¡¡¡¡¡¡¡{$form.back_button.html}¡¡¡¡¡¡¡¡{$form.preview_button.html}</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
</table>
<font size="+0.5"><b>¥Ñ¥¿¡¼¥óÌ¾¡§¥Ñ¥¿¡¼¥ó£±<br>¢¨­¡¡Á­¦¤Ë¼«¼Ò¾ðÊó¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤<br>¢¨­§¤Ë¥³¥á¥ó¥È¤òÀßÄê¤·¤Æ²¼¤µ¤¤¡£¡Ê¥³¥á¥ó¥È¤ÏÁ´¥Ñ¥¿¡¼¥ó¤Ç¶¦ÄÌ¤Ç¤¹¡£¡Ë</b></font>
<table class='List_Table' border='1' width='720' height="360">
	<tr>
		<td class='Value' valign='middle'>
	   		<table align="center" valign="middle" border="0" width="740" height="350" background="../../../image/saling.png">
			<tr>
				<td valign="top" width="520" height="1" align="right" colspan="3">
					<img src="../../../image/company-rogo_small.png"><br>
				</td>
			</tr>
			<tr>
				<td valign="top" width="520" align="right" colspan="2">
				</td>
				<td valign="top" align="left" height="190">
					<font color='#ff0000' size = '1'>­¡</font>¡¡<font size = '1'>{$var.s_memo1}</font><br>
					<font color='#ff0000' size = '1'>­¢</font>¡¡<font size = '1'>{$var.s_memo2}</font><br>
					<font color='#ff0000' size = '1'>­£</font>¡¡<font size = '1'>{$var.s_memo3}</font><br>
					<font color='#ff0000' size = '1'>­¤</font>¡¡<font size = '1'>{$var.s_memo4}</font><br>
					<font color='#ff0000' size = '1'>­¥</font>¡¡<font size = '1'>{$var.s_memo5}</font><br>
					<font color='#ff0000' size = '1'>­¦</font>¡¡<font size = '1'>{$var.s_memo6}</font><br>
				</font>                            
				</td>
			</tr>
			<tr>
				<td rowspan="2">
					<font color='#ff0000'>¡¡­§</font>
				</td>
				<td height="10">
				</td>
			</tr>
			<tr>
				<td width="300" align="left">
					{$form.s_memo7.html}
				</td>
			</tr>
		</td>
	</tr>
</table>
<!--******************** ²èÌÌÉ½¼¨1½ªÎ» *******************-->

</table>
					<br>
					</td>
				</tr>
					</td>
				</tr>
			</table>
		</td>
<!--******************** ²èÌÌÉ½¼¨½ªÎ» *******************-->

	</tr>
</table>
<!--******************* ³°ÏÈ½ªÎ» ********************-->

{$var.html_footer}
	

