<?php /* Smarty version 2.6.9, created on 2006-09-21 09:21:00
         compiled from 1-1-104.php.tpl */ ?>
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table>
    <tr>
        <td>

<table class="Data_Table" border="1" height="35">
    <tr>
        <td class="Title_Purple" width="90"><b>����å�̾</b></td>
        <td class="Value">����˥ƥ�����</td>
        <td class="Title_Purple" width="80"><b>�����ʬ</b></td>
        <td class="Value">�����</td>
    </tr>
</table>

        </td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="750">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="80" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����ȼ�</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_trans_check']['html'];  echo $this->_tpl_vars['form']['form_trans_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ľ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_select']['html']; ?>
</td>
        <td class="Title_Purple">�в��Ҹ�</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_ware_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ô����</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�̿���<br>�������谸��</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_note_your']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�в���</td>
        <td class="Value" colspan="3">

            <table border="0">
                <tr>
                    <td rowspan="3"><?php echo $this->_tpl_vars['form']['form_round_div']['html']; ?>
</td>
                    <td>
                        <font color="#555555">
                        (1) ����� <?php echo $this->_tpl_vars['form']['form_stand_day1']['html']; ?>
<br>
                        (2) ����� <?php echo $this->_tpl_vars['form']['form_stand_day2']['html']; ?>

                        </font>
                    <td valign="bottom">
                        <font color="#555555">
                        �� <?php echo $this->_tpl_vars['form']['form_rmonth']['html']; ?>
 ��������� <?php echo $this->_tpl_vars['form']['form_day']['html']; ?>
<br>
                        �� <?php echo $this->_tpl_vars['form']['form_rweek']['html']; ?>
 ���ּ����� <?php echo $this->_tpl_vars['form']['form_week']['html']; ?>
 ����
                        </font>
                    </td>
                </tr>
            </table>

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

<table class="Data_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">���ʥ�����<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����̾<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Title_Purple">����ñ��<font color="#ff0000">��</font><br>���ñ��<font color="#ff0000">��</font></td>
        <td class="Title_Purple">�������<br>�����</td>
        <td class="Title_Purple">�Ժ��</td>
    </tr>
    <tr class="Result1">
        <td align="center">1</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_num']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_genkatanka']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_uriagetanka']['html']; ?>
</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result2">
        <td align="center">2</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_num']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_genkatanka']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_uriagetanka']['html']; ?>
</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
    <tr class="Result1">
        <td align="center">3</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
        <td><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_num']['html']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_genkatanka']['html']; ?>
<br><?php echo $this->_tpl_vars['form']['form_uriagetanka']['html']; ?>
</td>
        <td align="right"><br></td>
        <td align="center"><a href="#">���</a></td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['add_row_link']['html']; ?>
</td>
    <td align="right">
        <table class="List_Table" border="1">
            <tr>
                <td class="Title_Pink" align="center" width="80"><b>��ȴ���</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_total']['html']; ?>
</td>
                <td class="Title_Pink" align="center" width="80"><b>������</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_tax']['html']; ?>
</td>
                <td class="Title_Pink" align="center" width="80"><b>�ǹ����</b></td>
                <td class="Value" align="right"><?php echo $this->_tpl_vars['form']['form_sale_money']['html']; ?>
</td>
            </tr>
        </table>
    </td>
    <td align="right"><?php echo $this->_tpl_vars['form']['form_sum_btn']['html']; ?>
</td>
    </tr>
    <tr>
        <td>
            <font color="#ff0000"><b>����ɬ�����ϤǤ�</b></font>
        </td>
        <td align="right" colspan="2">
            <?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>

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
