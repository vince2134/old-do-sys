<?php /* Smarty version 2.6.14, created on 2009-11-02 14:08:31
         compiled from 1-2-203.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['order_delete']; ?>

<?php echo $this->_tpl_vars['var']['javascript']; ?>

</script>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_sale_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_staff']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_sale_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_day']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_sale_amount']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_sale_amount']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_installment_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_installment_day']['error']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['var']['del_error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['del_error_msg']; ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['var']['output_error_msg'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['output_error_msg']; ?>

<?php endif; ?>
</span>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_s']; ?>
</td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['post_flg'] == true && $this->_tpl_vars['var']['err_flg'] != true): ?>

<table>
    <tr>
        <td>
            <?php echo $this->_tpl_vars['html']['html_page']; ?>

            <?php echo $this->_tpl_vars['html']['html_p']; ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo $this->_tpl_vars['html']['html_g']; ?>

        </td>
    </tr>
    <tr>
        <td>
            <?php echo $this->_tpl_vars['html']['html_page2']; ?>

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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
