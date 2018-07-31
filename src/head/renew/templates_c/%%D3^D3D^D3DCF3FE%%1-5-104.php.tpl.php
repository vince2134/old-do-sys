<?php /* Smarty version 2.6.14, created on 2010-01-05 11:36:10
         compiled from 1-5-104.php.tpl */ ?>
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

<?php if ($this->_tpl_vars['var']['complete_msg'] != null): ?>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['complete_msg']; ?>
<br>
    </span><br>
<?php endif; ?>

<span style="font: bold; color: #ff0000;">
<?php if ($this->_tpl_vars['var']['exec_err_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['exec_err_mess']; ?>
</li><br>
<?php endif;  if ($this->_tpl_vars['var']['temp_err_mess'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['temp_err_mess']; ?>
</li><br>
<?php endif; ?>
</span><br>

<span style="font:bold; color: #555555;">調査中の棚卸調査表を棚卸更新します</span><br>
<span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li>棚卸更新を実施すると棚卸差異数が自動的に在庫調整されます。
</span><br><br>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">前回更新日付</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['renew_before']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['jikkou']['html']; ?>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">調査表作成日</td>
        <td class="Title_Green">更新日時</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['item'][1]; ?>
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
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
