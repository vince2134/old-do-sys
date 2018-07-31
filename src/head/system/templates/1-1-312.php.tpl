
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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $form.d_memo3.error != null}<li>{$form.d_memo3.error}<br>{/if}
</span>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
{if $var.comp_msg != null}<li>{$var.comp_msg}<br>{/if}
</span>
<font size="+0.5"><b>¢¨­¡¤Ë½»½ê¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤<br>¢¨­¢¤ËTEL¡¦FAX¤òÆþÎÏ¤·¤Æ²¼¤µ¤¤<br>¢¨­£¤Ë¥á¥â¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤</b></font>
<table class='List_Table' border='1' width='720' height="450">
	<tr>
	<td class='Value' valign='middle'>
    <table align="center" valign="middle" border="0" width="740" height="350" background="../../../image/delivery.png">
	<tr>
	<td valign="bottom" height="110" width="720" align="right" colspan="2"><font color='#ff0000'>
	­¡¡¡{$form.d_memo1.html}<br>
	­¢¡¡{$form.d_memo2.html}<br>
	</font>
	</td>
	</tr>
	<tr><td><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td></tr>
    <td><font color='#ff0000'>¡¡­£</font></td>
	<tr>
		<td width="365" valign="top" align="center">
		{$form.d_memo3.html}
		</td>
	</tr>
		</td>
	</tr>
</table>
</table>
<table width='740'>
	<tr>
		<td align="right">{$form.new_button.html}¡¡¡¡{$form.deli_button.html}</td>
	</tr>
</table>
<!--******************** ²èÌÌÉ½¼¨1½ªÎ» *******************-->

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
	

