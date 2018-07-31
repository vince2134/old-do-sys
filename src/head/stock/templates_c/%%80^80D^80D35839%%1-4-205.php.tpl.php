<?php /* Smarty version 2.6.14, created on 2010-04-05 15:54:58
         compiled from 1-4-205.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['var']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
<?php endif; ?>
</span>

<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Yellow">調査表番号</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_invent_no']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ex_day']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">
【棚卸日：
<?php if ($this->_tpl_vars['var']['error'] == null && ( $this->_tpl_vars['var']['ex_start'] != NULL || $this->_tpl_vars['var']['ex_end'] != NULL )): ?>
    <?php echo $this->_tpl_vars['var']['ex_start']; ?>
 〜 <?php echo $this->_tpl_vars['var']['ex_end']; ?>

<?php else: ?>
    指定無し
<?php endif; ?>
】
</span>
<br>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">No.</td>
        <td class="Title_Yellow">棚卸日</td>
        <td class="Title_Yellow">調査表番号</td>
        <td class="Title_Yellow">棚卸一覧表</td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
        <?php if ($this->_tpl_vars['j'] == 0 || $this->_tpl_vars['j']%2 == 0): ?>
        <tr class="Result1">
    <?php else: ?>
                <tr class="Result2">
    <?php endif; ?>
        <td align="right">
        <?php if ($_POST['form_show_button'] == "表　示"): ?>
            <?php echo $this->_tpl_vars['j']+1; ?>

        <?php elseif ($_POST['f_page1'] != null): ?>
            <?php echo $_POST['f_page1']*100+$this->_tpl_vars['j']-99; ?>

        <?php else: ?>
            <?php echo $this->_tpl_vars['j']+1; ?>

        <?php endif; ?>
        </td>
                <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
                <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
</td>
                <td align="center"><a href="1-4-208.php?invent_no=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
">表示</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
