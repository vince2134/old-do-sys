<?php /* Smarty version 2.6.14, created on 2007-03-27 15:17:14
         compiled from 1-1-119.php.tpl */ ?>
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

<table width="600">
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">�ڸ������</span><br>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-250.php',Array('f_customer[code1]','f_customer[code2]','f_customer[name]'),500,450);">������</a></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_customer']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-220.php',Array('f_claim[code1]','f_claim[code2]','f_claim[name]'),500,450);">������</a></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_claim']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ô����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_select1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-210.php',Array('f_goods1','t_goods1'),500,450);">����</a></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_goods1']['html']; ?>
����<?php echo $this->_tpl_vars['form']['t_goods1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ñ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_code_c1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����</td>
        <td class="Value">
            <table>
                <tr>
                    <td rowspan="8"><?php echo $this->_tpl_vars['form']['form_round_div_1']['html']; ?>
</td>
                    <td><font color="#555555">
                        &nbsp;����ʤ�<br>
                        (1)&nbsp;<?php echo $this->_tpl_vars['form']['form_abcd_week1']['html']; ?>
&nbsp;��&nbsp;<?php echo $this->_tpl_vars['form']['form_week_rday1']['html']; ?>
&nbsp;����<br>
                        (2)&nbsp;���<?php echo $this->_tpl_vars['form']['form_rday1']['html']; ?>
��<br>
                        (3)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_week1']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_week_rday2']['html']; ?>
&nbsp;����<br>
                        (4)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day4_1']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_mon4_1']['html']; ?>
&nbsp;���������&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_week2']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_day4_1']['html']; ?>
&nbsp;����<br>
                        (5)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day5_1']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_mon5_1']['html']; ?>
&nbsp;�������&nbsp;<?php echo $this->_tpl_vars['form']['form_f_cale_day5_1']['html']; ?>
&nbsp;��<br>
                        (6)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day6_1']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_week_num6_1']['html']; ?>
&nbsp;��������&nbsp;<?php echo $this->_tpl_vars['form']['f_cale_day6_1']['html']; ?>
&nbsp;����<br>
                        (7)&nbsp;��§��
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['button']['hyouji']['html']; ?>
����<?php echo $this->_tpl_vars['form']['button']['kuria']['html']; ?>
</td>
    </tr>
    <tr>
        <td align="center"><img src="../../../image/yajirusi.png"></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">���ѹ����ܡ�</span><br>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">������</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">���ô����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_select2']['html']; ?>
</td>   
    </tr>
    <tr>
        <td class="Title_Purple"><a href="#" onClick="return Open_SubWin('../dialog/1-0-210.php',Array('f_goods2','t_goods2'),500,450);">����</a></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_goods2']['html']; ?>
����<?php echo $this->_tpl_vars['form']['t_goods2']['html']; ?>
</td>
    </tr>
    
    <tr>
        <td class="Title_Purple">���ñ��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_code_c2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����</td>
        <td class="Value">
            <table>
                <tr>
                    <td rowspan="8"><?php echo $this->_tpl_vars['form']['form_round_div_2']['html']; ?>
</td>
                    <td><font color="#555555">
                        &nbsp;�ѹ����ʤ�<br>
                        (1)&nbsp;<?php echo $this->_tpl_vars['form']['form_abcd_week2']['html']; ?>
&nbsp;��&nbsp;<?php echo $this->_tpl_vars['form']['form_week_rday3']['html']; ?>
&nbsp;����<br>
                        (2)&nbsp;���<?php echo $this->_tpl_vars['form']['form_rday1']['html']; ?>
��<br>
                        (3)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_week3']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_week_rday3']['html']; ?>
&nbsp;����<br>
                        (4)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day4_2']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_mon4_2']['html']; ?>
&nbsp;���������&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_week3']['html']; ?>
&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_day4_2']['html']; ?>
&nbsp;����<br>
                        (5)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day5_2']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_cale_mon5_2']['html']; ?>
&nbsp;�������&nbsp;<?php echo $this->_tpl_vars['form']['form_f_cale_day5_2']['html']; ?>
&nbsp;��<br>
                        (6)&nbsp;�����&nbsp;<?php echo $this->_tpl_vars['form']['form_stand_day6_2']['html']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['form']['form_week_num6_2']['html']; ?>
&nbsp;��������&nbsp;<?php echo $this->_tpl_vars['form']['f_cale_day6_2']['html']; ?>
&nbsp;����<br>
                        (7)&nbsp;<a href="#" onClick="return Open_Dialog('1-1-105.php','1000','730');">��§��</a>(�ǽ���:2005-03-31)
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['change2']['html']; ?>
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

��<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>��
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">FC/������</td>
        <td class="Title_Purple">������</td>
        <td class="Title_Purple">���ô����</td>
        <td class="Title_Purple">����</td>
        <td class="Title_Purple">���ñ��</td>
        <td class="Title_Purple">�����</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td>000000-0001</a><br><a href="1-1-123.php">������ҡ�����˥ƥ�</a></td>
        <td>������A</td>
        <td>ô����A</td>
        <td>����A</td>
        <td align="right">100.00</td>
        <td>A��������</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td>000000-0002</a><br><a href="1-1-123.php">����˥ƥ����</a></td>
        <td>������B</td>
        <td>ô����B</td>
        <td>����B</td>
        <td align="right">100.00</td>
        <td>A��������</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td>000000-0003</a><br><a href="1-1-123.php">���˥��꡼���Ե�</a></td>
        <td>������C</td>
        <td>ô����C</td>
        <td>����C</td>
        <td align="right">100.00</td>
        <td>3�������3��</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td>000000-0004</a><br><a href="1-1-123.php">����˥ƥ��̴���</a></td>
        <td>������D</td>
        <td>ô����D</td>
        <td>����D</td>
        <td align="right">100.00</td>
        <td>������</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td>000000-0005</a><br><a href="1-1-123.php">���ܥ��꡼�󥢥å�</a></td>
        <td>������E</td>
        <td>ô����E</td>
        <td>����E</td>
        <td align="right">100.00</td>
        <td>E��������</td>
    </tr>
        <tr class="Result1">
        <td align="right">6</td>
        <td>000001-0000</a><br><a href="1-1-123.php">�������</a></td>
        <td>������F</td>
        <td>ô����F</td>
        <td>����F</td>
        <td align="right">100.00</td>
        <td>2��������������</td>
    </tr>
        <tr class="Result1">
        <td align="right">7</td>
        <td>000002-0000</a><br><a href="1-1-123.php">����˥ƥ��꡼��</a></td>
        <td>������G</td>
        <td>ô����G</td>
        <td>����G</td>
        <td align="right">100.00</td>
        <td>��§��</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['modoru']['html']; ?>
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
