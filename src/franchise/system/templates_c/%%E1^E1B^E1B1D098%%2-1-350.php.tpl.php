<?php /* Smarty version 2.6.14, created on 2010-04-05 16:39:46
         compiled from 2-1-350.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%" class="M_table">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
	<tr align="center" valign="top">
		<td>
			<table>
				<tr>
					<td>
						<table>


												<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
						<?php if ($this->_tpl_vars['var']['fin_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['fin_msg']; ?>
<br><?php endif; ?>
						</span>
					    <tr>
					        <td>
							<?php echo $this->_tpl_vars['var']['calendar']; ?>

							</td>
						</tr>
						</table><br>

				        </td>
				    </tr>
					<tr>
						<td align="right" width="900"><?php echo $this->_tpl_vars['form']['form_set']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>
　　</form><form name="clear" METHOD="POST"><input type="submit" name="form_all_clear" value="全クリア"></form></td>
					</tr>
				</table>
				</td>
				</tr>
			</table>
		</td>
	</tr>

</table>

</body>
</html>	