<?php /* Smarty version 2.6.9, created on 2006-09-08 15:21:03
         compiled from 2-5-103.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="center">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

 
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_claim_day1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_claim_day1']['error']; ?>
<br>
    <?php endif; ?>   
    <?php if ($this->_tpl_vars['var']['no_target_err'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['no_target_err']; ?>
<br>
    <?php endif; ?>   
    <?php if ($this->_tpl_vars['var']['unconf_warning'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['unconf_warning']; ?>
<br>
    <?php endif; ?>   
    </span>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['update_message'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['update_message']; ?>
<br>
    <?php endif; ?>   
    </span> 

<table  class="Data_Table" border="1" width="450" >

    <tr>
        <td class="Title_Green" width="100"><b>ÀÁµá¹¹¿·Æü<font color="red">¢¨</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day1']['html']; ?>
</td>
    </tr>

</table>

<table width='450'>
    <tr>
        <td align='right'><?php echo $this->_tpl_vars['form']['form_add_button']['html']; ?>
</td>
    </tr>
</table>



                    <br>
                    </td>
                </tr>


                <tr>
                    <td>


<table class="List_Table" border="1" width="450">
    <tr align="center">
        <td class="Title_Green" width=""><b>No.</b></td>
        <td class="Title_Green" width=""><b>ÀÁµá¹¹¿·Æü</b></td>
        <td class="Title_Green" width=""><b>ÀÁµá¹¹¿·¼Â»ÜÆü»þ</b></td>
        <td class="Title_Green" width=""><b>ÀÁµá¹¹¿·¼Â»Ü¼Ô</b></td>
    </tr>

    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][0]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>

</table>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
