<?php /* Smarty version 2.6.9, created on 2006-09-11 11:11:58
         compiled from 2-5-107-2.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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



<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">最終日次更新日</td>
        <td class="Value"><?php if ($this->_tpl_vars['var']['daily_update_time'] != null):  echo $this->_tpl_vars['var']['daily_update_time'];  else: ?>未実施<?php endif; ?></td>
    </tr>
    <tr>
        <td class="Title_Green">入力者</td>
        <td class="Value"><?php $_from = $this->_tpl_vars['form']['form_e_staff']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['id']):
 echo $this->_tpl_vars['form']['form_e_staff'][$this->_tpl_vars['i']]['html']; ?>
 <?php endforeach; endif; unset($_from); ?></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html']; ?>


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
