<?php /* Smarty version 2.6.9, created on 2006-09-16 10:22:46
         compiled from 2-5-111.php.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '2-5-111.php.tpl', 65, false),)), $this); ?>
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



<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="500">
    <tr>
        <td class="Title_Green" width="80"><b>集計期間</b></td>
        <td class="Value"><?php if ($this->_tpl_vars['var']['daily_update_time'] != null):  echo $this->_tpl_vars['var']['daily_update_time'];  else: ?>未実施<?php endif; ?> 〜 <?php if ($this->_tpl_vars['var']['end_day'] != null):  echo $this->_tpl_vars['var']['end_day'];  else:  echo $this->_tpl_vars['var']['now'];  endif; ?><br>（最終日次更新日付 〜 <?php if ($this->_tpl_vars['var']['end_day'] != null): ?>指定日付<?php else: ?>現在日付<?php endif; ?>）</td>
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

<table class="Data_Table" border="1">
<col width="100" style="font-weight: bold;">
<col width="100">
<col width="100" style="font-weight: bold;">
<col width="100">
    <tr>
        <td class="Title_Green">担当者</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['disp_staff_data'][1]; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">【売上合計】</td>
        <td class="Value" align="right"<?php if ($this->_tpl_vars['disp_staff_data'][2] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_staff_data'][2])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        <td class="Title_Green">【入金合計】</td>
        <td class="Value" align="right"<?php if ($this->_tpl_vars['disp_staff_data'][3] < 0): ?> style="color: #ff0000;"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['disp_staff_data'][3])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
</table>
<br>

<table class="List_Table" border="1" width="100%">
<col width="30">
<col width="100">
<col>
<col width="100">
<col width="100">
<col width="100">
<col width="0">
<col width="100">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">No.</td>
        <td class="Title_Green">取扱区分</td>
        <td class="Title_Green">販売区分</td>
        <td class="Title_Green">明細件数</td>
        <td class="Title_Green">原価</td>
        <td class="Title_Green">金額</td>
        <td class="Title_Green"></td>
        <td class="Title_Green">金額月次累計</td>
    </tr>
<?php echo $this->_tpl_vars['var']['html']; ?>

</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_return_button']['html']; ?>
</td>
    </tr>
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
