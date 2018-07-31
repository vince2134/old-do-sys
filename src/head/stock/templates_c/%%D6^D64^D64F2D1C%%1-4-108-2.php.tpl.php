<?php /* Smarty version 2.6.14, created on 2010-02-24 17:06:42
         compiled from 1-4-108-2.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

    		<tr align="center" valign="top" height="160">
        <td>
            <table>

				<!-- 登録確認メッセージ表示 -->
		        <tr>
	                <td>
						<span style="font: bold;">
							<font size="+1">在庫調整を完了しました。<br><br></font>
						</span>
						<table width="100%">
						    <tr>
						        <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
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
