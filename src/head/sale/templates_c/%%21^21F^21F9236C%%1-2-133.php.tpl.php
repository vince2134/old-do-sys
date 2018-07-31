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

<!-- 画面遷移元判定 -->
<?php if ($_GET['sinsei_msg'] != NULL): ?>
	<!-- 申請取消ボタン押下 -->
	<span style="font: bold;"><font size="+1">申請取消完了しました。<br><br></font></span>
<?php elseif ($_GET['kaiyaku_msg'] != NULL): ?>
	<!-- 解約取消ボタン押下 -->
	<span style="font: bold;"><font size="+1">解約取消完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 6 && $_GET['online_flg'] == 't'): ?>
	<!-- 新規申請中 -->
	<span style="font: bold;"><font size="+1">承認完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 't'): ?>
	<!-- 契約済・解約済 -->
	<span style="font: bold;"><font size="+1">変更完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 3 && $_GET['online_flg'] == 't'): ?>
	<!-- 解約申請 -->
	<span style="font: bold;"><font size="+1">解約承認・実施完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 4): ?>
	<!-- 解約予定(オンライン・オフライン) -->
	<span style="font: bold;"><font size="+1">解約取消完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 1 && $_GET['online_flg'] == 'f'): ?>
	<!-- 新規申請中(オフライン) -->
	<span style="font: bold;"><font size="+1">登録完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 'f' && $_GET['edit_flg'] == false): ?>
	<!-- 契約済・解約済(オフライン) -->
	<span style="font: bold;"><font size="+1">解約完了しました。<br><br></font></span>
<?php elseif ($_GET['disp_stat'] == 2 && $_GET['online_flg'] == 'f'): ?>
	<!-- 変更(オフライン) -->
	<span style="font: bold;"><font size="+1">変更完了しました。<br><br></font></span>
<?php endif; ?>
<table width="100%">
    <tr>
        <td align="right">
		<!-- 申請取消ボタン押下時にはデータが無い為、変更画面ボタン非表示 -->
		<?php if ($_GET['sinsei_msg'] == NULL): ?>
			<?php echo $this->_tpl_vars['form']['input_btn']['html']; ?>
　　
		<?php endif; ?>
		<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['aord_btn']['html']; ?>
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
