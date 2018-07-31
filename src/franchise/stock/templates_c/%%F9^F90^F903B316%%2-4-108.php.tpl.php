<?php /* Smarty version 2.6.14, created on 2010-04-05 16:16:54
         compiled from 2-4-108.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '2-4-108.php.tpl', 57, false),)), $this); ?>
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


<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul>
<?php if ($this->_tpl_vars['form']['form_ware']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_ware']['error']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['adjust_num_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['adjust_num_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['adjust_reason_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['adjust_reason_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['adjust_date_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['adjust_date_err']; ?>
<br>
<?php endif;  if ($this->_tpl_vars['var']['goods_input_err'] != null): ?>
    <li><?php echo $this->_tpl_vars['var']['goods_input_err']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="450">
<col width="90" style="font-weight: bold;">
    <tr>
        <td class="Title_Yellow">調整日<font color="#ff0000">※</font></td>
        <!-- <td class="Value"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td> -->
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_adjust_day']['html']; ?>
 の最終在庫を調整する</td>
    </tr>
    <tr>
        <td class="Title_Yellow">対象倉庫<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware']['html']; ?>

        <td class="Title_Yellow"><b>状態</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_type']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['mst_goods_button']['html']; ?>
</td>
    <tr>
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

<?php if ($this->_tpl_vars['var']['ware_name'] != null): ?>
    <span style="font: bold 15px; color: #555555;">【<?php echo $this->_tpl_vars['var']['ware_name']; ?>
】</span>　　
    <span style="font: bold 14px; color: #0000ff;">調整した後は必ず一番下までスクロールして「実施」ボタンで処理を確定して下さい。</span><br>
<?php else: ?>
    <span style="font: bold 15px; color: #0000ff;">倉庫を選択してください。</span>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['ware_name'] != null): ?>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow" rowspan="2">No.</td>
        <td class="Title_Yellow" rowspan="2">入出区分<br>(<a href="#" onClick="javascript:Button_Submit_1('change_flg', '#', 'true')">全反転</a>)</td>
        <td class="Title_Yellow" rowspan="2">商品コード<font color="#ff0000">※</font><br>商品名</td>
        <td class="Title_Yellow">調整前</td>
        <td class="Title_Yellow" colspan="2"><img src="../../../image/arrow.gif"></td>
        <td class="Title_Yellow">調整後</td>
        <td class="Title_Yellow" rowspan="2">調整理由<font color="#ff0000">※</font></td>
        <td class="Title_Yellow" rowspan="2">調整実施<br>ボタンへ</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Yellow">在庫数<br><span style="color: #0000ff;">引当数</span></td>
        <td class="Title_Yellow">調整数<font color="#ff0000">※</font></td>
        <td class="Title_Yellow">単位</td>
        <td class="Title_Yellow">在庫数<br><span style="color: #0000ff;">引当数</span></td>
    </tr>
  <?php echo $this->_tpl_vars['var']['html']; ?>


</table>


<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>※は必須入力です</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_adjust_button']['html']; ?>
<br></td>
    </tr>       
    <tr>    
        <td colspan="2" align="left"><?php echo $this->_tpl_vars['form']['add_row_button']['html']; ?>
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
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
