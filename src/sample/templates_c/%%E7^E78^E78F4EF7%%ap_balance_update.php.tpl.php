<?php /* Smarty version 2.6.9, created on 2007-01-04 13:17:36
         compiled from ap_balance_update.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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
<?php echo $this->_tpl_vars['var']['err_msg']; ?>

</span>
<span style="color: #000000; font-weight: bold; line-height: 130%;">
<?php echo $this->_tpl_vars['var']['ap_fin_msg']; ?>

<?php echo $this->_tpl_vars['var']['bill_fin_msg']; ?>

</span>

<table><tr><td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">¥·¥ç¥Ã¥×£É£Ä</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_shop_id']['html']; ?>
</td>
        <td class="Title_Purple">¥¯¥é¥¤¥¢¥ó¥È£É£Ä</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_id']['html']; ?>
</td>
    </tr>
        <td class="Title_Purple">ÅÐÏ¿Æü</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_monthly_close_day_this']['html']; ?>
</td>
        <td class="Title_Purple">Çä³Ý»Ä¹â</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ap_balance']['html']; ?>
</td>
    </tr>

</table>
<?php if ($this->_tpl_vars['var']['exit_flg'] != true):  echo $this->_tpl_vars['var']['btn_push']; ?>

<?php echo $this->_tpl_vars['form']['exe_btn']['html']; ?>

<?php endif; ?>
<br>
</td></tr></table>
<br>
<?php echo $this->_tpl_vars['form']['update_btn']['html']; ?>

<?php echo $this->_tpl_vars['form']['reset']['html']; ?>

<br>

                                        </td>
                                </tr>
                                <tr>
                                        <td>

<table width="100%">
    <tr>
        <td>
    <?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
        <tr>
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

