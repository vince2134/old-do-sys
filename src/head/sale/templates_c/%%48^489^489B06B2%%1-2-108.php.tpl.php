<?php /* Smarty version 2.6.14, created on 2010-01-14 15:40:46
         compiled from 1-2-108.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


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

        <?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
    	<tr align="center" valign="top" height="160">
	<?php else: ?>
		<tr align="center" valign="top">
	<?php endif; ?>
        <td>
            <table>

<!-- ��Ͽ��ǧ��å�����ɽ�� -->
<?php if ($this->_tpl_vars['var']['freeze_flg'] == true): ?>
	        <tr>
                <td>
	<span style="font: bold;"><font size="+1">����λ���ޤ�����<br><br>
	</font></span>
	<table width="100%">
	    <tr>
	        <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
	    </tr>
	</table>
			   </td>
           </tr> 
<?php else: ?>
     
    <?php echo $this->_tpl_vars['var']['html']; ?>

                <tr>
                    <td>

                    <?php if ($_GET['del_flg'] == true): ?>
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>ȯ�����ä��줿���ᡢ��Ͽ�Ǥ��ޤ���Ǥ�����</li>
                        </span>
                    <?php endif; ?>
                    <?php if ($_GET['aord_del_flg'] == true): ?>
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>����������줿���ᡢ�����å���λ�Ǥ��ޤ���Ǥ�����</li>
                        </span>
                    <?php endif; ?>
                    <?php if ($_GET['add_del_flg'] == true): ?>
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>����������줿���ᡢ�ѹ��Ǥ��ޤ���Ǥ�����</li>
                        </span>
                    <?php endif; ?>
                    <?php if ($_GET['add_flg'] == true): ?>
                        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
                        <li>���˼�����Ͽ�ϴ�λ���Ƥ��ޤ���</li>
                        </span>
                    <?php endif; ?>
                        <table width="100%">
                        <tr>
                            <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
</td>
                        </tr>
                        </table>
                    </td>
                </tr> 
<?php endif; ?>               
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
