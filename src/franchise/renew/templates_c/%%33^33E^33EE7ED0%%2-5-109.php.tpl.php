<?php /* Smarty version 2.6.14, created on 2010-04-07 09:47:14
         compiled from 2-5-109.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

    <?php if ($this->_tpl_vars['form']['form_end_day']['error'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['form']['form_end_day']['error']; ?>
<br>
        </span>
    <?php endif; ?>

<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="500">
<col width="100" style="font-weight: bold;">
<col>
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">½¸·×´ü´Ö</td>
                        <td class="Value"><?php echo $this->_tpl_vars['html']['start_day']; ?>
 ¡Á <?php echo $this->_tpl_vars['html']['end_day']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">»ÙÅ¹</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_branch']['html']; ?>
</td>
    </tr>
</table>

<table width="500">
    <tr align="right">
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
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

<table>
    <tr>
        <td>

<div align="right"><?php echo $this->_tpl_vars['form']['form_return_button']['html']; ?>
</div>
<br>

    <?php echo $this->_tpl_vars['html']['html_d']; ?>

    <?php echo $this->_tpl_vars['html']['html_h']; ?>

    
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
