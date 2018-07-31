<?php /* Smarty version 2.6.14, created on 2009-12-29 10:51:30
         compiled from 2-5-107.php.tpl */ ?>
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

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['form_count_date']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_count_date']['error']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">集計日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_count_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">集計期間<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_count_date']['html']; ?>
<br><?php echo $this->_tpl_vars['var']['info_msg']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">入力者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_e_staff_slct']['html']; ?>
</td>
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

<table width="1000">
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
