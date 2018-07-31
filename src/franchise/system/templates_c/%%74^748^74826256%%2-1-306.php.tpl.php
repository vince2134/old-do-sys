<?php /* Smarty version 2.6.14, created on 2010-09-06 19:27:20
         compiled from 2-1-306.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-1-306.php.tpl', 136, false),)), $this); ?>
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

    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_close_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_close_day']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['bill_day_err']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['bill_day_err']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['bill_amount_err']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['bill_amount_err']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['bill_all_err']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['bill_all_err']['error']; ?>
<br>
    <?php endif; ?>
    </span><br>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['message'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['message']; ?>
<br>
    <?php endif; ?>
    </span><br>

<table width="450">
    <tr>
        <td>
<div style="text-align: left; font: bold; color: #3300ff;">
    ・本残高初期設定は各得意先登録後、取引の確定前に１回だけ、任意に設定できます。
</div>
<div style="text-align: left; font: bold; color: #3300ff;">
    ・本設定なしに取引（売上、入金、仕入、支払等）を確定した場合、自動的にゼロに設定されます。
</div>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">請求残高</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">取引区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">締日</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_close_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['hyoujikensuu']['html']; ?>
</td>
    </tr>
</table>

<br>

<table border="1" class="Data_Table" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>    
        <td class="Title_Purple">残高移行年月日<font color="#ff0000">※</td></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_bill_day']['html']; ?>
</td>
    </tr>   
</table>

<table align="right">
    <tr>    
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
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


<?php if ($_POST['renew_flg'] == 1): ?>
<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">得意先名</td>
        <td class="Title_Purple">請求先名</td>
        <td class="Title_Purple">請求残高</td>
        <td class="Title_Purple">残高移行日</td>
    </tr>
<?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">
        <td align="right"><?php echo $this->_tpl_vars['i']+$this->_tpl_vars['var']['page_snum']; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1]; ?>
<br><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2]; ?>
<br><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][5]; ?>
<br><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_bill_amount'][$this->_tpl_vars['i']]['html']; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][10]; ?>
</td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result3" align="right" style="font-weight: bold;">
        <td colspan="4">残高合計</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['total_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
</table>

 <?php echo $this->_tpl_vars['var']['html_page2']; ?>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_add_button']['html']; ?>
</td>
    </tr>
</table>

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
