<?php /* Smarty version 2.6.9, created on 2006-01-12 13:23:14
         compiled from sub_window.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_blue.png">
<form name="dateForm" method="post">

<!--------------------- ���ȳ��� ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- ���̥����ȥ볫�� --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- ���̥����ȥ뽪λ -->
		</td>
	</tr>

	<tr align="left">
		<td width="18%" valign="top" lowspan="2">
			<!-- ��˥塼���� --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- ��˥塼��λ -->
		</td>

		<!---------------------- ����ɽ������ --------------------->
		<td valign="top">

			<table border=0  width="100%">
				<tr>
					<td>


<!---------------------- ����ɽ��1���� --------------------->

<table  class="Data_Table" border="1" width="650" >

	<tr>
		<td class="Title_Blue" width="100"><b>��ʧ�ǡ������</b></td>
		<td class="Value">
			<input type="file" size="40">����<?php echo $this->_tpl_vars['form']['button']['busy']['html']; ?>

		</td>
	</tr>

	<tr>
		<td class="Title_Blue" width="100"><b><a href="javascript:Sub_Window('1-0-201.php','bank','0')">���</a></b></td>
		<td class="Value"><?php echo $this->_tpl_vars['form']['f_bank']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['collective']['html']; ?>

		</td>
	</tr>



</table>
<br>
<!--******************** ����ɽ��1��λ *******************-->

					</td>
				</tr>

				<tr>
					<td>

<!---------------------- ����ɽ��2���� --------------------->

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Blue" width=""><b>NO</b></td>
		<td class="Title_Blue" width=""><b>��ʧ��<font color="#ff0000">��</font></b></td>
		<td class="Title_Blue" width=""><b>�����ʬ<font color="#ff0000">��</font></b></td>
		<td class="Title_Blue" width=""><b>���</b></td>
		<td class="Title_Blue" width="" ><b>������<font color="#ff0000">��</font></b></td>
		<td class="Title_Blue" width=""><b>��ʧ���<font color="#ff0000">��</font><br>�����</b></td>
		<td class="Title_Blue" width=""><b>�������<br>��������ֹ�</b></td>
		<td class="Title_Blue" width=""><b>����</b></td>
		<td class="Title_Blue" width=""><b>��</b>��<a href="#">�ɲ�</a>��</td>
	</tr>
	<!--1����-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_dealing1']['html']; ?>
��<a href="javascript:Sub_Window_Open('dealing1.php','dealing1')">����</a>��<br><?php echo $this->_tpl_vars['form']['t_dealing1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_bank1']['html']; ?>
��<a href="#" onClick="return Open_SubWin('1-0-201.php',Array('f_bank1','n_bank1','t_bank1'),500,500);">����</a>��<?php echo $this->_tpl_vars['form']['n_bank1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_bank1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_layer1']['html']; ?>
��<a href="javascript:Sub_Window_Open('layer1.php','layer1')">����</a>��<br><?php echo $this->_tpl_vars['form']['t_layer1']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a2']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text20']['html']; ?>
</td>
		<td align="center"><a href="javascript:dialogue('������ޤ���','#')">���</a></td>
	</tr>
	
	<tr class="Result2">
		<td align="left"><b>���</b></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><b>401,745<br>0</b></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

</table>

<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Yellow" width="" rowspan="2"><b>NO</b></td>
		<td class="Title_Yellow" width="" rowspan="2"><b>���ʥ�����<font color="#ff0000">��</font><br>����̾</b></td>
		<td class="Title_Yellow" width="" colspan="2"><b>��ư��</b></td>
		<td class="Title_Yellow" width="" colspan="2"><img src="../../../image/arrow.gif"></td>
		<td class="Title_Yellow" width="" colspan="2"><b>��ư��</b></td>
		<td class="Title_Yellow" width="" rowspan="2"><b>�ԡ�<a href="#" title="����������ɲä��ޤ���">�ɲ�</a>��</b></td>
	</tr>

	<tr align="center">
		<td class="Title_Yellow" width=""><b>�Ҹ�̾<font color="#ff0000">��</font></b></td>
		<td class="Title_Yellow" width=""><b>�߸˿�<br>�ʰ�������</b></td>
		<td class="Title_Yellow" width=""><b>��ư��<font color="#ff0000">��</font></b></td>
		<td class="Title_Yellow" width=""><b>ñ��</b></td>
		<td class="Title_Yellow" width=""><b>�Ҹ�̾<font color="#ff0000">��</font></b></td>
		<td class="Title_Yellow" width=""><b>�߸˿�<br>�ʰ�������</b></td>
	</tr>

	<!--1����-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods1_c']['html']; ?>
��<a href="#" onClick="return Open_SubWin('1-0-202.php',Array('f_goods1_c','t_goods1_b1','t_goods1_b2','f_text9','t_goods1_h1','t_goods1_b3','t_goods1_b4'),500,500,'1');">����</a>��<br>����A</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_warehouse2']['html']; ?>
��<a href="javascript:Sub_Window_Open('goods5.php','goods1')">����</a>��<br><?php echo $this->_tpl_vars['form']['t_warehouse2']['html']; ?>
</td>
		<td align="right"><?php echo $this->_tpl_vars['form']['t_goods1_b1']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_goods1_b2']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['t_goods1_h1']['html']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_warehouse3']['html']; ?>
��<a href="javascript:Sub_Window_Open('goods5.php','goods1')">����</a>��<br><?php echo $this->_tpl_vars['form']['t_warehouse3']['html']; ?>
</td>
		<td align="right"><?php echo $this->_tpl_vars['form']['t_goods1_b3']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['t_goods1_b4']['html']; ?>
</td>
		<td align="center"><a href="#" onClick="javascript:dialogue('������ޤ���','#')">���</a></td>
	</tr>
</table>
<table class="List_Table" border="1" width="100%">
	<tr align="center">
		<td class="Title_Blue" width=""><b>NO</b></td>
		<td class="Title_Blue" width=""><b>���ʥ�����<font color="#ff0000">��</font><br>����̾</b></td>
		<td class="Title_Blue" width=""><b>��ê��<br>(A)</b></td>
		<td class="Title_Blue" width=""><b>ȯ��ѿ�<br>(B)</b></td>
		<td class="Title_Blue" width=""><b>������<br>(C)</b></td>
		<td class="Title_Blue" width=""><b>�вٲ�ǽ��<br>(A+B-C)</b></td>
		<td class="Title_Blue" width=""><b>ȯ���<font color="#ff0000">��</font></b></td>
		<td class="Title_Blue" width=""><b>����ñ��<font color="#ff0000">��</font></b></td>
		<td class="Title_Blue" width=""><b>�������</b></td>
		<td class="Title_Blue" width=""><b>����ͽ����</b></td>
		<td class="Title_Blue" width=""><b>�ԡ�<a href="#">�ɲ�</a>��</b></td>
	</tr>

	<!--1����-->
	<tr class="Result1">
		<td align="right">1</td>
		<td align="left"><?php echo $this->_tpl_vars['form']['f_goods5']['html']; ?>
��<a href="#" onClick="return Open_SubWin('1-0-202.php',Array('f_goods5','t_goods5'),500,500);">����</a>��<br><?php echo $this->_tpl_vars['form']['t_goods5']['html']; ?>
</td>
		<td align="right"><a href="javascript:WindowOpen('1-3-111.php',300,150,'output2');">80</a></td>
		<td align="right">5</td>
		<td align="right">20</td>
		<td align="right">65</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_text9']['html']; ?>
</td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_code_c1']['html']; ?>
</td>
		<td align="center"></td>
		<td align="center"><?php echo $this->_tpl_vars['form']['f_date_a11']['html']; ?>
</td>
		<td align="center"><a href="javascript:dialogue('������ޤ���','#')">���</a></td>
	</tr>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
