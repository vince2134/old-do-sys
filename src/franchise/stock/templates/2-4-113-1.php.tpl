
{$var.html_header}

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%" class="M_Table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> {$var.page_header} <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="center">
		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">
		
			<table>
				<tr>
					<td>

<!---------------------- ����ɽ��1���� --------------------->
<table  class="Data_Table" border="1" width="450" >

	<tr>
		<td class="Title_Yellow" width="100"><b>�谷����</b></td>
		<td class="Value"></td>
	</tr>

	{if $smarty.session.shop_div == '1'}
		<tr>
			<td class="Title_Yellow" width="100"><b>���Ƚ�</b></td>
			<td class="Value"></td>
		</tr>
	{/if}

	<tr>
		<td class="Title_Yellow" width="100"><b>�Ҹ�</b></td>
		<td class="Value"></td>
	</tr>

	<tr>
		<td class="Title_Yellow" width="100"><b>����̾</b></td>
		<td class="Value"></td>
	</tr>

</table>

<!--******************** ����ɽ��1��λ *******************-->

					<br>
					</td>
				</tr>


				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->
{$var.html_page}

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Yellow" width=""><b>No.</b></td>
		<td class="Title_Yellow" width=""><b>��ɼ�ֹ�</b></td>
		<td class="Title_Yellow" width=""><b>�谷��</b></td>
		<td class="Title_Yellow" width=""><b>�谷��ʬ</b></td>
		<td class="Title_Yellow" width=""><b>���˿�</b></td>
		<td class="Title_Yellow" width=""><b>�и˿�</b></td>
		<td class="Title_Yellow" width=""><b>��ʧ��</b></td>
	</tr>

	<!--1����-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left">12345678</td>
		<td align="center">2005-05-31</td>
		<td align="center">����</td>
		<td align="right">3</td>
		<td align="right"></td>
		<td align="left">�����A</td>
	</tr>
	
	<!--2����-->
	<tr class="Result1">
		<td align="right">2</td>
		<td align="left">12345679</td>
		<td align="center">2005-05-31</td>
		<td align="center">���</td>
		<td align="right"></td>
		<td align="right">7</td>
		<td align="left">�����B</td>
	</tr>

	<!--3����-->
	<tr class="Result1">
		<td align="right">3</td>
		<td align="left">12345680</td>
		<td align="center">2005-05-31</td>
		<td align="center">���</td>
		<td align="right"></td>
		<td align="right">2</td>
		<td align="left">�����B</td>
	</tr>
	
	<!--4����-->
	<tr class="Result1">
		<td align="right">4</td>
		<td align="left"></td>
		<td align="center">2005-06-01</td>
		<td align="center">��Ω</td>
		<td align="right">10</td>
		<td align="right"></td>
		<td align="left"></td>
	</tr>

	<!--5����-->
	<tr class="Result1">
		<td align="right">5</td>
		<td align="left"></td>
		<td align="center">2005-06-02</td>
		<td align="center">Ĵ��</td>
		<td align="right"></td>
		<td align="right">5</td>
		<td align="left"></td>
	</tr>

	<tr class="Result3" align="center">
		<td align="left"><b>���</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>13</b></td>
		<td align="right"><b>14</b></td>
		<td></td>
	</tr>

</table>
{$var.html_page2}
<br>
<table width="100%">
	<tr><td align="right">{$form.button.modoru.html}</td></tr>
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

{$var.html_footer}
	

