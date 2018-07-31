<?php /* Smarty version 2.6.14, created on 2009-12-16 16:34:09
         compiled from 2-5-105.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['form_start_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_start_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_end_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_end_day']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['form']['form_branch']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_branch']['error']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<?php if ($this->_tpl_vars['var']['renew_msg'] != null): ?>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li><?php echo $this->_tpl_vars['var']['renew_msg']; ?>
<br>
</ul>
</span>
<?php endif; ?>

<?php if ($this->_tpl_vars['print']['err_not_renew'] != null): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li><?php echo $this->_tpl_vars['print']['err_not_renew']; ?>
<br>
</ul>
</span>
<?php endif; ?>

<table width="500">
    <tr>    
        <td>    

<table class="Data_Table" border="1" width="500">
<col width="100" style="font-weight: bold;">
<col>
        <?php if ($_GET['id'] == null): ?>
    <tr>
        <td class="Title_Green">½¸·×´ü´Ö</td> 
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_start_day']['html']; ?>
 ¡Á <?php echo $this->_tpl_vars['form']['form_end_day']['html']; ?>
</td>
    </tr>   
    <tr>
        <td class="Title_Green">»ÙÅ¹</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_branch']['html']; ?>
</td>
    </tr>
        <?php elseif ($_GET['id'] != null && $_GET['id'] != '0'): ?>
    <tr>
        <td class="Title_Green">½¸·×´ü´Ö</td> 
                <td class="Value"><?php echo $this->_tpl_vars['print']['start_day']; ?>
 ¡Á <?php echo $this->_tpl_vars['print']['end_day']; ?>
</td>
    </tr>   
    <tr>
        <td class="Title_Green">»ÙÅ¹</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_branch']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">Ã´Åö¼Ô</td> 
        <td class="Value"><?php echo $this->_tpl_vars['print']['staff_name']; ?>
</td>
    </tr>
        <?php elseif ($_GET['id'] == '0'): ?>
    <tr>
        <td class="Title_Green">½¸·×´ü´Ö</td> 
                <td class="Value"><?php echo $this->_tpl_vars['print']['start_day']; ?>
 ¡Á <?php echo $this->_tpl_vars['print']['end_day']; ?>
</td>
    </tr>   
    <tr>
        <td class="Title_Green">»ÙÅ¹</td> 
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_branch']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>

<table width="500">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_renew_button']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>   
</table>

   
  

        </tr>   
    </td>   
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<table width="100%">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>

<table width="100%">
<tr>
<td>

<?php echo $this->_tpl_vars['html']['html_t']; ?>
<br>

</td>
<td align="right" valign="middle">

<?php if ($_GET['id'] == null): ?>
    <div><?php echo $this->_tpl_vars['form']['form_list_button']['html']; ?>
</div><br>
<?php elseif ($_GET['id'] != null): ?>
    <div align="right"><?php echo $this->_tpl_vars['form']['form_return_button']['html']; ?>
</div>
<?php endif; ?>

</td>
</tr>
<tr>
<td colspan="2">

<table class="List_Table" border="1" width="100%">
<col width="30">
<col width="100">
<col>
<col width="0">
<col width="100">
<col width="0">
<col width="100">
<col width="0">
<col width="100">
<col width="100">
<col width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green" rowspan="2">No.</td>
        <td class="Title_Green" rowspan="2">¼è°·¶èÊ¬</td>
        <td class="Title_Green" rowspan="2">ÈÎÇä¶èÊ¬</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green">Æü¼¡Ì¤¼Â»ÜÎß·×</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green">Æü¼¡¼Â»ÜºÑÎß·×</td>
        <td class="Title_Green" rowspan="2"></td>
        <td class="Title_Green" colspan="3">¹ç·×</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">¶â³Û</td>
        <td class="Title_Green">¶â³Û</td>
        <td class="Title_Green">ÌÀºÙ·ï¿ô</td>
        <td class="Title_Green">¸¶²Á</td>
        <td class="Title_Green">¶â³Û</td>
    </tr>
<?php echo $this->_tpl_vars['html']['html_m']; ?>

</table>

</td>
</tr>
</table>

<?php endif; ?>

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
