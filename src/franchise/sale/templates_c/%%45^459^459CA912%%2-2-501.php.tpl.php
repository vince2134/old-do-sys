<?php /* Smarty version 2.6.14, created on 2010-01-19 18:06:42
         compiled from 2-2-501.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-2-501.php.tpl', 187, false),)), $this); ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
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
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['form_input_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_input_day']['error']; ?>

<?php endif;  if ($this->_tpl_vars['form']['form_balance_this']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_balance_this']['error']; ?>

<?php endif; ?>
</ul>
</span>


<table width="700">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col width="220">
<col width="110" style="font-weight: bold;">
<col>
        <tr>
        <td class="Title_Pink">対象月<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_input_day']['html']; ?>
</td>
        <td class="Title_Pink">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_display_num']['html']; ?>
</td>
    </tr>

        <tr>
<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>
        <td class="Title_Pink"><?php if ($_SESSION['group_kind'] == '1'): ?>FC・取引先<?php else: ?>得意先<?php endif; ?></td>
        <td class="Value" colspan="3">
            <?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>

                        <?php if ($_SESSION['group_kind'] == '1'): ?>
            <br><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>

            <?php endif; ?>
        </td>
        <?php if ($_SESSION['group_kind'] != '1'): ?>
    </tr>
        <tr>
        <td class="Title_Pink">グループ</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_client_gr_name']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_client_gr']['html']; ?>
</td>
    <?php endif;  else: ?>
        <td class="Title_Pink"><?php if ($_SESSION['group_kind'] == '1'): ?>FC・取引先<?php else: ?>仕入先<?php endif; ?></td>
        <td class="Value" colspan="3">
            <?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>

                        <?php if ($_SESSION['group_kind'] == '1'): ?>
            <br><?php echo $this->_tpl_vars['form']['form_rank']['html']; ?>

            <?php endif; ?>
        </td>
<?php endif; ?>
    </tr>

        <tr>
        <td class="Title_Pink">当月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>売<?php else: ?>買<?php endif; ?>掛残高<br>(税込)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_balance_this']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_balance_radio']['html']; ?>
<br></td>
        <td class="Title_Pink">取引状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>

<?php if ($this->_tpl_vars['var']['trade_div'] == 'buy' && $this->_tpl_vars['var']['group_kind'] == '1'): ?>
        <tr>
        <td class="Title_Pink">FC・取引先区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_supplier_div']['html']; ?>
</td>
    </tr>
<?php endif; ?>

        <tr>
        <td class="Title_Pink">取引区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
    </tr>

</table>

<table width="100%">
    <tr>
        <td align="left"><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_display_button']['html']; ?>
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

<?php if ($this->_tpl_vars['var']['err_flg'] != true): ?>

<table width="100%">
    <tr>
        <td>

<?php if ($_POST != null): ?>

<span style="font: bold 15px; color: #555555;">【対象月：<?php echo $this->_tpl_vars['var']['input_day']; ?>
】</span><br>
<?php echo $this->_tpl_vars['var']['html_page']; ?>


<?php if ($this->_tpl_vars['var']['data_list_count'] != 0): ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink"><?php if ($_SESSION['group_kind'] == '1'): ?>FC・取引先<?php elseif ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>得意先<?php else: ?>仕入先<?php endif; ?></td>
        <td class="Title_Pink">前月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>売<?php else: ?>買<?php endif; ?>掛残高</td>
        <td class="Title_Pink">当月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>売上<?php else: ?>仕入<?php endif; ?>額</td>
        <td class="Title_Pink">消費税</td>
        <td class="Title_Pink">当月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>売上<?php else: ?>仕入<?php endif; ?>額(税込)</td>
        <td class="Title_Pink">当月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>入金<?php else: ?>支払<?php endif; ?>額</td>
        <td class="Title_Pink">手数料</td>
        <td class="Title_Pink">調整額</td>
        <td class="Title_Pink">割賦残高</td>
                <td class="Title_Pink">当月<?php if ($this->_tpl_vars['var']['trade_div'] == 'sale'): ?>売<?php else: ?>買<?php endif; ?>掛残高</td>
    </tr>

    <tr class="Result3" align="center" height="30px">
        <td>合計</td>
        <td><?php if ($this->_tpl_vars['var']['data_list_count'] != null):  echo $this->_tpl_vars['var']['data_list_count']; ?>
社<?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][8]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][9]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['total_money'][11]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['total_money'][12] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['total_money'][12])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['i']%2 == 0): ?>
    <tr class="Result1">
    <?php else: ?>
    <tr class="Result2">
    <?php endif; ?>
        <td align="right"><?php echo $this->_tpl_vars['item'][16]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0];  if ($this->_tpl_vars['item'][14] != '2'): ?>-<?php echo $this->_tpl_vars['item'][1];  endif; ?><br><?php echo $this->_tpl_vars['item'][2]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][8]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][9]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['item'][11]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['item'][12]; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>

    <tr class="Result3" align="center" height="30px">
        <td>合計</td>
        <td><?php if ($this->_tpl_vars['var']['data_list_count'] != null):  echo $this->_tpl_vars['var']['data_list_count']; ?>
社<?php endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][3]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][4]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][5]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][6]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][7]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][8]; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['total_money'][9]; ?>
</td>
                <td align="right"><?php echo $this->_tpl_vars['total_money'][11]; ?>
</td>
        <td align="right"<?php if ($this->_tpl_vars['total_money'][12] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['total_money'][12])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<?php endif;  endif; ?>
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
