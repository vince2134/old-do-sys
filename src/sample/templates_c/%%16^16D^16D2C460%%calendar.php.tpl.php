<?php /* Smarty version 2.6.9, created on 2006-01-16 13:41:00
         compiled from calendar.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body background="../../../image/back_purple.png">
<form name="dateForm" method="post">
<!--------------------- 外枠開始 ---------------------->
<table border=0 width="100%" height="90%">

	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top">
			<!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
		</td>
	</tr>

	<tr align="left">
		<td width="18%" valign="top" lowspan="2">
			<!-- メニュー開始 --> <?php echo $this->_tpl_vars['var']['page_menu']; ?>
 <!-- メニュー終了 -->
		</td>

		<!---------------------- 画面表示開始 --------------------->
		<td valign="top">
		
			<table border=0  width="100%">
				<tr>
					<td>

<!---------------------- 画面表示1開始 --------------------->


<table width="100%" height="100%">
<tr>
    <td valign="middle" align="center">
    <table border="1" width="900" height="630" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=0 rules=none bgcolor="white">
    <tr>
        <td valign="top" colspan="2">
        <table width="100%" height="60" border="0" bgcolor="#333333">
        <tr>
            <td><font size="8" color="#ff0000">work</font><font size="8" color="white">recorder</td>
        </tr>
        </table>
        </td>
    </tr>
    <tr>
        <td>
        <table height="100%" border="0" width="210">
        <tr>
            <td height="50%" align="center" valign="middle">
            <form  <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
            <center><font color="#ff0000">※</font>日付を選択してください</center>
            <table width="150"border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=10 rules="none">
            </tr>
                <td><?php echo $this->_tpl_vars['form']['year']['html'];  echo $this->_tpl_vars['form']['year']['label']; ?>
</td>
                <td><?php echo $this->_tpl_vars['form']['month']['html'];  echo $this->_tpl_vars['form']['month']['label']; ?>
</td>
            </tr>
            <tr>
                <td colspan="2" height="50" align="right"><?php echo $this->_tpl_vars['form']['btn']['html']; ?>
</td>
            </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td height="50%"><b></td>
        </tr>
        </table>
        </form>
        </td>
        <td align="center" valign="middle">
        <font size="5"><b><?php echo $_SESSION['year']; ?>
年<?php echo $_SESSION['month']; ?>
月</b></font>
        <table width="650" height="400" border="1" bordercolor="#808080" bordercolordark="#808080" cellspacing=0 cellpadding=10>
        <tr height="20">
        <?php $_from = $this->_tpl_vars['youbi']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['items']):
        $this->_foreach['outer']['iteration']++;
?>
            <?php if ($this->_tpl_vars['key'] == 0): ?>
                <td align="center" bgcolor="#FF9933"><font color="#ff0000"><?php echo $this->_tpl_vars['items']; ?>
</td>
            <?php elseif ($this->_tpl_vars['key'] == 6): ?>
                <td align="center" bgcolor="#66CCFF"><font color="blue"><?php echo $this->_tpl_vars['items']; ?>
</td>
            <?php else: ?>
                <td align="center"  bgcolor="#cccccc"><?php echo $this->_tpl_vars['items']; ?>
</td>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        </tr>
        <?php $_from = $this->_tpl_vars['dd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['outer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['outer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['items']):
        $this->_foreach['outer']['iteration']++;
?>
        <tr>
            <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <?php if ($this->_tpl_vars['key'] == 0): ?>
                    <td align="left" valign="top" bgcolor="#FFFF99"><a href="" style="color: #ff0000" ><font size="4"><?php echo $this->_tpl_vars['item']; ?>
</font></a></td>
                <?php elseif ($this->_tpl_vars['key'] == 6): ?>
                    <td align="left" valign="top" bgcolor="#99FFFF"><a href="" style="color:blue"><font size="4"><?php echo $this->_tpl_vars['item']; ?>
</font></a></td>
                <?php else: ?>
                    <td align="left" valign="top" ><a href="" style="color:black"><font size="4"><?php echo $this->_tpl_vars['item']; ?>
</font></a></td>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        </td>
    </tr>
    <tr>
        <td valign="bottom" colspan="2">
        <table width="100%" height="20" border="0" bgcolor="#D3D3D3">
        <tr>
            <td>
            </td>
        </tr>
        </table>
        </td>
    </tr>
    </table>
    </td>
</tr>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

	
