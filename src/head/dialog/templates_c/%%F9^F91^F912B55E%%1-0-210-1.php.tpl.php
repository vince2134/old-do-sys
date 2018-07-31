<?php /* Smarty version 2.6.14, created on 2010-03-10 15:48:18
         compiled from 1-0-210-1.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%">

        <td valign="top">
            <table>
                <tr>
                    <td>



<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table>
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
°°°°<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<?php if ($_POST['form_show_button'] == "…Ω°°º®"): ?>

        </td>
    </tr>
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">æ¶… •≥°º•…<br>æ¶… Ãæ</td>
        <td class="Title_Purple">Œ¨æŒ</td>
        <td class="Title_Purple">¿Ω… ∂Ë ¨</td>
        <td class="Title_Purple">£Õ∂Ë ¨</td>
        <td class="Title_Purple">¬∞¿≠∂Ë ¨</td>
    </tr>

        <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['items']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['j'] == 0): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
<br>
        <?php elseif ($this->_tpl_vars['j'] == 1): ?>
        <?php echo $this->_tpl_vars['item']; ?>
</a></td>
        <?php elseif ($this->_tpl_vars['j'] == 2): ?>
        <td><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 3): ?>
        <td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 4): ?>
        <td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php elseif ($this->_tpl_vars['j'] == 5): ?>
        <td align="center"><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <?php endforeach; endif; unset($_from); ?>

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