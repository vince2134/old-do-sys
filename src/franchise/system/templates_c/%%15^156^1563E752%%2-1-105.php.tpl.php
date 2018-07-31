<?php /* Smarty version 2.6.14, created on 2010-03-09 15:48:01
         compiled from 2-1-105.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%" class="M_table">

    	<tr align="center" height="60">
		<td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
	</tr>
    
    	<tr align="center" valign="top">
		<td>
			<table>
				<tr>
					<td>



<table>
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['calendar']; ?>
</td></tr></table><br>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
	<tr>
		<td><?php echo $this->_tpl_vars['form']['set']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['back']['html']; ?>
</td>
	</tr>
</table>

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
