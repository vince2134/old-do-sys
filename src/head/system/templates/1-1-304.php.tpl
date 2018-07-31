
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
{* ¥¨¥é¡¼¥á¥Ã¥»¡¼¥¸½ÐÎÏ *} 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
{if $var.error_fax_msg != null}<li>{$var.error_fax_msg}<br>{/if}
{if $var.error_tel_msg != null}<li>{$var.error_tel_msg}<br>{/if}</span><br>
<font size="+0.5"><b>¢¨­¡¤ËFAXÈÖ¹æ¡¢­¢¤ËÅÅÏÃÈÖ¹æ¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤</b></font><br>
<font size="+0.5"><b>¢¨­£¡Á­¨¤Ë¥³¥á¥ó¥È¤òÆþÎÏ¤·¤Æ¤¯¤À¤µ¤¤</b></font>
<table class='List_Table' border='0' width='740' height='1085' background="../../../image/order.png">
<tr>
	<td valign="bottom" height='135'>
		<table width='550' align="right">
		<tr><td>
		<font color='#ff0000'>
		­¡ {$form.o_memo1.html}<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top">
		<table width='680' align="right">
		<tr><td>
		<font color='#ff0000'>
		­¢ {$form.o_memo2.html}<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top" height='370'>
		<table width='450'>
		<tr><td>
		<font color='#ff0000'>
		­£ {$form.o_memo3.html}<br>
		­¤ {$form.o_memo4.html}<br>
		­¥ {$form.o_memo5.html}<br>
		­¦ {$form.o_memo6.html}<br>
		­§ {$form.o_memo7.html}<br>
		­¨ {$form.o_memo8.html}<br>
		</font>
		</td></tr>
		</table>
	</td>
</tr>
</table>
	</td>
</tr>

<table width='740'>
	<tr>
		<td align="right">{$form.new_button.html}¡¡¡¡{$form.order_button.html}</td>
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
	


	
