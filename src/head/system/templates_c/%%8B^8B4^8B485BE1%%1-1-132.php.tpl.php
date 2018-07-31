<?php /* Smarty version 2.6.9, created on 2006-12-01 14:36:54
         compiled from 1-1-132.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

		    <!--<table>
    <tr>
        <td>

		<table class="Data_Table" border="1" width="450">
		    <tr align="left">
		        <td class="Title_Purple" width="120"><b>出力形式</b></td>
		        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
		    </tr>
		    <tr align="left">
		        <td class="Title_Purple" width="120"><b>年月</b></td>
		        <td class="Value"><?php echo $this->_tpl_vars['form']['form_day_y']['html']; ?>
 年 <?php echo $this->_tpl_vars['form']['form_day_m']['html']; ?>
 月</td>
		    </tr>
		</table>
        </td>
    </tr>
    <tr align="right">
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
</table>
<br>
		    -->

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Title_Purple">商品名</td>
        <td class="Title_Purple">数量</td>
        <td class="Title_Purple">単価</td>
        <td class="Title_Purple">合計</td>
        <td class="Title_Purple">総計</td>
        <td class="Title_Purple">備考</td>
    </tr>
<?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
">
        <td rowspan="4" align="center"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td rowspan="4" align="center"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][2]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][6]; ?>
</td>
        <td rowspan="4" align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][7]; ?>
</td>
        <td rowspan="4"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][8]; ?>
</td>
    </tr>
    <tr class="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
">
        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][9]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][10]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][11]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][12]; ?>
</td>
    </tr>
    <tr class="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
">
        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][13]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][14]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][15]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][16]; ?>
</td>
    </tr>
    <tr class="<?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][0]; ?>
">
        <td align="left"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][17]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][18]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][19]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['disp_data'][$this->_tpl_vars['i']][20]; ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_back_button']['html']; ?>
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
