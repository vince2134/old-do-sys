<?php /* Smarty version 2.6.14, created on 2009-12-28 17:08:57
         compiled from 1-2-133.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        	<tr align="center" valign="top" height="160">
        <td>
            <table>
                <tr>
                    <td>

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<!-- �������ܸ�Ƚ�� -->
<?php if ($_GET['sinsei_msg'] != NULL): ?>
	<!-- ������åܥ��󲡲� -->
	<span style="font: bold;"><font size="+1">������ô�λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['kaiyaku_msg'] != NULL): ?>
	<!-- �����åܥ��󲡲� -->
	<span style="font: bold;"><font size="+1">�����ô�λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 6 && $_GET['online_flg'] == 't'): ?>
	<!-- ���������� -->
	<span style="font: bold;"><font size="+1">��ǧ��λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 't'): ?>
	<!-- ����ѡ������ -->
	<span style="font: bold;"><font size="+1">�ѹ���λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 3 && $_GET['online_flg'] == 't'): ?>
	<!-- ������ -->
	<span style="font: bold;"><font size="+1">����ǧ���»ܴ�λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 4): ?>
	<!-- ����ͽ��(����饤�󡦥��ե饤��) -->
	<span style="font: bold;"><font size="+1">�����ô�λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 1 && $_GET['online_flg'] == 'f'): ?>
	<!-- ����������(���ե饤��) -->
	<span style="font: bold;"><font size="+1">��Ͽ��λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 'f' && $_GET['edit_flg'] == false): ?>
	<!-- ����ѡ������(���ե饤��) -->
	<span style="font: bold;"><font size="+1">����λ���ޤ�����<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 'f'): ?>
	<!-- �ѹ�(���ե饤��) -->
	<span style="font: bold;"><font size="+1">�ѹ���λ���ޤ�����<br><br></font></span>
<?php endif; ?>
<table width="100%">
    <tr>
        <td align="right">
		<!-- ������åܥ��󲡲����ˤϥǡ�����̵���١��ѹ����̥ܥ�����ɽ�� -->
		<?php if ($_GET['sinsei_msg'] == NULL): ?>
			<?php echo $this->_tpl_vars['form']['input_btn']['html']; ?>
����
		<?php endif; ?>
		<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
����<?php echo $this->_tpl_vars['form']['aord_btn']['html']; ?>
</td>
    </tr>
</table>


                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
