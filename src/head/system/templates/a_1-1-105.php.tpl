
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<!--------------------- ���ȳ��� ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="left">

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table border="0"  width="100%" cellspacing='0'>
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->
{$var.calendar}

<br>
<table align="center" width='880'>
	<tr>
		<td align="right">{$form.button.set4.html}����{$form.button.close.html}</td>
	</tr>
</table>

<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>
					</td>
				</tr>

			</table>

		</td>
<!--******************** ����ɽ����λ *******************-->

	</tr>
</table>
<!--******************* ���Ƚ�λ ********************-->

{$var.html_footer}
	

