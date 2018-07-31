<?php /* Smarty version 2.6.14, created on 2010-04-05 15:59:32
         compiled from 1-1-205.php.tpl */ ?>
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

 
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['message'] != null && $this->_tpl_vars['form']['form_btype_cd']['error'] == null && $this->_tpl_vars['form']['form_btype_name']['error'] == null): ?>
        <li><?php echo $this->_tpl_vars['var']['message']; ?>
<br>
    <?php endif; ?>
    </span>
          <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_btype_cd']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype_cd']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_btype_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_btype_name']['error']; ?>
<br>
    <?php endif; ?>
    </span> 

<table width="600">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col width="80" style="font-weight: bold;">
<col>
<?php echo $this->_tpl_vars['form']['hidden']; ?>

    <tr>
        <td class="Title_Purple" rowspan="4">大分類業種</td>
        <td class="Title_Purple">コード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">名称<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype_note']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">承認</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td>
            <b><font color="#ff0000">※は必須入力です</font></b>
        </td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_entry_button']['html']; ?>
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

<table width="100%">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td>全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件　<?php echo $this->_tpl_vars['form']['form_csv_button']['html']; ?>
</td>
    </tr>
</table>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" colspan="4">大分類業種</td>
        <td class="Title_Purple" colspan="4">小分類業種</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">承認</td>
        <td class="Title_Purple">コード</td>
        <td class="Title_Purple">名称</td>
        <td class="Title_Purple">備考</td>
        <td class="Title_Purple">承認</td>
    </tr>
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class=<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['i']]; ?>
>
        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
</td>
        <td><a href="?lbtype_id=<?php echo $this->_tpl_vars['item'][0]; ?>
#input_form"><?php echo $this->_tpl_vars['item'][2]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <?php if ($this->_tpl_vars['item'][7] == '1'): ?>
        <td align="center">○</td>
        <?php elseif ($this->_tpl_vars['item'][7] == '2'): ?>
        <td align="center"><font color="red">×</font></td>
        <?php else: ?>
        <td></td>
        <?php endif; ?>
        <td><?php echo $this->_tpl_vars['item'][4]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['item'][5]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][6]; ?>
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
