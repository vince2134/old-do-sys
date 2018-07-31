<?php /* Smarty version 2.6.14, created on 2010-05-12 22:22:10
         compiled from 1-1-107.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['js']; ?>

 </script>

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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="650">
<col width="140" style="font-weight: bold;">
<col>
<col width="140" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_cd']['html']; ?>
</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">スタッフ種別</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_staff_kind']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ネットワーク証ID</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_cd']['html']; ?>
</td>
        <td class="Title_Purple">スタッフ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">担当者コード</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_charge_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">役職</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_position']['html']; ?>
</td>
        <td class="Title_Purple">職種</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_job_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">在職識別</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">トイレ診断士資格</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_toilet_license']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">取得資格</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_license']['html']; ?>
</td>
    </tr>
</table>

        </td>
        <td valign="bottom">

<table class="Data_Table" border="1" width="200">
    <tr>
        <td class="Title_Purple" width="80"><b>出力形式</b></td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td colspan="2" align="right"><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
    </tr>
</table>
<br>

                    </td>
                </tr>

                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['display_flg'] == true): ?>
<table width="100%">
    <tr>
        <td>

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" rowspan="2">No.</td>
        <td class="Title_Purple" rowspan="2">ショップコード<br>ショップ名</td>
        <td class="Title_Purple" rowspan="2">担当者<br>コード</td>
        <td class="Title_Purple" rowspan="2">本部</td>
        <td class="Title_Purple" rowspan="2">ネットワーク証ID<br>スタッフ名</td>
        <td class="Title_Purple" rowspan="2">役職</td>
        <td class="Title_Purple" rowspan="2">支店</td>
        <td class="Title_Purple" rowspan="2">所属部署</td>
        <td class="Title_Purple" rowspan="2">職種</td>
        <td class="Title_Purple" rowspan="2">在職識別</td>
        <td class="Title_Purple" rowspan="2">トイレ診断士資格</td>
        <td class="Title_Purple" rowspan="2">取得資格</td>
        <td class="Title_Purple">ネットワーク証</td>
    </tr>
    <tr>
        <td class="Title_Purple" align="center"><b>発行日:<?php echo $this->_tpl_vars['form']['form_issue_date']['html']; ?>
</b></td>
    </tr>
    <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
    <tr class="<?php echo $this->_tpl_vars['tr'][$this->_tpl_vars['j']]; ?>
">
        <td align="right"><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][1] != null): ?>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][1]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][2]; ?>

        <?php else: ?>
        <td>
        <?php endif; ?>
        <br><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][0]; ?>
</td>
        <td>
        <?php if ($this->_tpl_vars['row'][$this->_tpl_vars['j']][6] != null): ?>
            <?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][6]; ?>
-<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][7]; ?>

        <?php endif; ?>
        <br><a href="1-1-109.php?staff_id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][8]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][10]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][15]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][9]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][11]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][12]; ?>
</td>
        <td align="center"><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][13]; ?>
</td>
        <td><?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][14]; ?>
</td>
        <td align="center"><a href="javascript:Print_Link('<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['j']][5]; ?>
')">印刷</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
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
