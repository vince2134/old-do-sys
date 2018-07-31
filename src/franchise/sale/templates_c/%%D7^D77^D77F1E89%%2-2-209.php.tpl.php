<?php /* Smarty version 2.6.14, created on 2009-12-26 17:25:14
         compiled from 2-2-209.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_round_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_round_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_claim_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_claim_day']['error']; ?>

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
                <tr style="page-break-before: always;">
                    <td>

<table>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_page']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_1']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_2']; ?>
</td>
    </tr>
    <tr>
        <td><?php echo $this->_tpl_vars['html']['html_page2']; ?>
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
