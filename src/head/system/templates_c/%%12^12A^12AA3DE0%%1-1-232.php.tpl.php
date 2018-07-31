<?php /* Smarty version 2.6.14, created on 2010-04-05 16:04:55
         compiled from 1-1-232.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


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

 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['message'] != null && $this->_tpl_vars['form']['form_btype_cd']['error'] == null && $this->_tpl_vars['form']['form_btype_name']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['var']['message']; ?>
<br>
    <?php endif; ?>
    </span>
          <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_btype']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_btype_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_btype_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype_name']['error']; ?>
<br>
    <?php endif; ?>
    </span> 

<table class="Data_Table" border="1" width="450">
    <tr>
        <td class="Title_Purple" width="120"><b>大分類業種</b></td>
        <td class="Title_Purple" width="100"><b>コード<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="650">
    <tr>
        <td class="Title_Purple" width="120" rowspan="4"><b>小分類業種</b>
        <td class="Title_Purple" width="100"><b>コード<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple" width=""><b>名称<font color="#ff0000">※</font></b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>備考</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><b>承認</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
    </tr>
</table>

<table width='650'>
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

<table width="100%">
    <tr>
        <td>

<table border="0" width="650">
    <tr>
        <td width="50%" align="left">全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
    </tr>
</table>

<table class="List_Table" border="1" width="650">
    <tr align="center">
        <td class="Title_Purple" width="30" rowspan="2"><b>No.</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>大分類業種</b></td>
        <td class="Title_Purple" width="" colspan="4"><b>小分類業種</b></td>
    </tr>
    
    <tr align="center">
        <td class="Title_Purple" width=""><b>コード</b></td>
        <td class="Title_Purple" width=""><b>名称</b></td>
        <td class="Title_Purple" width=""><b>備考</b></td>
        <td class="Title_Purple" width=""><b>承認</b></td>
        <td class="Title_Purple" width=""><b>コード</b></td>
        <td class="Title_Purple" width=""><b>名称</b></td>
        <td class="Title_Purple" width=""><b>備考</b></td>
        <td class="Title_Purple" width=""><b>承認</b></td>
    </tr>
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class=<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
>
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td align="left"><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
        <?php if ($this->_tpl_vars['item'][7] == '1'): ?>
            <td align="center">○</td>
        <?php elseif ($this->_tpl_vars['item'][7] == '2'): ?>
            <td align="center"><font color="red">×</font></td>
        <?php else: ?>
            <td></td>
        <?php endif; ?>
        <td align="left"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td align="left"><a href="?sbtype_id=<?php echo $this->_tpl_vars['item'][3]; ?>
#input_form"><?php echo $this->_tpl_vars['item'][5]; ?>
</a></td>
        <td align="left"><?php echo $this->_tpl_vars['item'][6]; ?>
</a></td>
        <?php if ($this->_tpl_vars['item'][8] == '1'): ?>
            <td align="center">○</td>
        <?php else: ?>
            <td align="center"><font color="red">×</font></td>
        <?php endif; ?>
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
