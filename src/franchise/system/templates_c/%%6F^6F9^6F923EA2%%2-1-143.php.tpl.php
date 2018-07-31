<?php /* Smarty version 2.6.14, created on 2010-06-16 10:40:49
         compiled from 2-1-143.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

<!-- ²èÌÌÁ«°Ü¸µÈ½Äê -->
<?php if ($this->_tpl_vars['var']['disp_stat'] == 1 || $this->_tpl_vars['var']['disp_stat'] == 5 || $this->_tpl_vars['var']['disp_stat'] == 6): ?>
	<!-- ¥ì¥ó¥¿¥ëIDÌµ¤·¡¦¼è¾ÃºÑ¡¦¿·µ¬¿½ÀÁÃæ -->
	<span style="font: bold;"><font size="+1">ÅÐÏ¿´°Î»¤·¤Þ¤·¤¿¡£<br><br></font></span>
<?php elseif (( $this->_tpl_vars['var']['disp_stat'] == 2 && $this->_tpl_vars['var']['stat_flg'] == false ) || $this->_tpl_vars['var']['online_flg'] == 'f'): ?>
	<!-- ·ÀÌóºÑ¡¦²òÌóºÑ(²òÌóºÑ¤Î¤ß) -->
	<span style="font: bold;"><font size="+1">ÊÑ¹¹´°Î»¤·¤Þ¤·¤¿¡£<br><br></font></span>
<?php else: ?>
	<!-- ·ÀÌóºÑ¡¦²òÌóºÑ¡¡²òÌó¿½ÀÁ¡¡²òÌóÍ½Äê -->
	<span style="font: bold;"><font size="+1">²òÌó¿½ÀÁ´°Î»¤·¤Þ¤·¤¿¡£<br><br></font></span>
<?php endif; ?>
<table width="100%">
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['input_btn']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['disp_btn']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['con_btn']['html']; ?>
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
