<?php /* Smarty version 2.6.14, created on 2009-12-25 16:11:39
         compiled from 1-1-227.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">

<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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

    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['message'] != null && $this->_tpl_vars['form']['form_rank_cd']['error'] == null && $this->_tpl_vars['form']['form_rank_name']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['var']['message']; ?>
<br>
    <?php endif; ?>
    </span>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_rank_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_rank_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_rank_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_rank_name']['error']; ?>
<br>
    <?php endif; ?>
    </span> 

<table class="Data_Table" border="2" width="450">
<col width="110" style="font-weight: bold;">
<col width="*">

    <tr>
        <td class="Title_Purple">FC・取引先区分コード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank_cd']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple">FC・取引先区分名<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank_name']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank_note']['html']; ?>
</td>
    </tr>

</table>
<table width="450">
    <tr>
        <td align="left">
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        <td align="right">
            <?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>

                <tr>
                    <td>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table>
    <tr>
        <td width="50%" align="left">全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
    </tr>
</table>
<table class="List_Table" border="1" width=450>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">FC・取引先区分コード</td>
        <td class="Title_Purple">FC・取引先区分名</td>
        <td class="Title_Purple">備考</td>
    </tr>
        <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <tr class="Result1">
                <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
                <td align="left"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
                <td align="left"><a href="?rank_cd=<?php echo $this->_tpl_vars['item'][0]; ?>
"><?php echo $this->_tpl_vars['item'][1]; ?>
</a></td>
                <td align="left"><?php echo $this->_tpl_vars['item'][2]; ?>
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

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
