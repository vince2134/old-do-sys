<?php /* Smarty version 2.6.9, created on 2006-09-19 18:33:15
         compiled from 1-1-311.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

<?php if ($this->_tpl_vars['var']['pattern_err'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['pattern_err']; ?>
<br>
    </span><br>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
    <span style="font-weight: bold; color: #555555;">�����ߡ��ʲ���ȯ�Ը�����Ͽ�ѤߤǤ���</span>
<?php else: ?>
    <span style="font-weight: bold; color: #0000ff;">
        �����ѥ��������Ͽ���ޤ�����<br><br>
        �����β��̤ϼºݤΥ��᡼���Ȥϰۤʤ��ǽ��������ޤ���<br>
        ���ºݤ������ɼ�ϥץ�ӥ塼�򤴳�ǧ����������
    </span>
<?php endif; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="950">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
    <table width="100%">
        <tr valign="bottom">
            <td><?php echo $this->_tpl_vars['form']['pattern_select']['html']; ?>
��<?php echo $this->_tpl_vars['form']['preview_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['change_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
        </tr>
    </table>
<?php else: ?>
<br>����������������������<?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>

<?php endif; ?>

        </td>
    </tr>
</table>

<hr>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($this->_tpl_vars['var']['qf_err_flg'] == true): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['pattern_name']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['pattern_name']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['s_memo5']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['s_memo5']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['s_memo6']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['s_memo6']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['s_memo7']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['s_memo7']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['s_memo8']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['s_memo8']['error']; ?>
</li><br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['s_memo9']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['s_memo9']['error']; ?>
</li><br>
    <?php endif; ?>
    </span>
<?php endif; ?>

<?php if ($_POST['form_new_flg'] != true && $_POST['form_update_flg'] != true || $this->_tpl_vars['var']['pattern_err'] != null): ?>

    <?php echo $this->_tpl_vars['form']['form_new_button']['html']; ?>


<?php else: ?>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�ѥ�����̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['pattern_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['bill_send_radio']['html']; ?>
</td>
    </tr>
</table>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
<br>
<span style="font-weight: bold; color: #ff0000;">�ʲ��ι��ܤ����ꤷ�Ʋ�������</span><br>
<table style="font-weight: bold; color: #555555;">
<col span="3" width="130">
    <tr>
        <td>�� ���̾1</td><td>�� ���̾2</td><td>�� ��ɽ����</td>
    </tr>
    <tr>
        <td>�� ��ɽ��̾</td><td>�� ���ꡦTEL��FAX</td><td>�� �����ɼ������</td>
    </tr>
    <tr>
        <td>�� ������</td><td>�� Ǽ�ʽ������</td><td>�� �μ��������</td>
    </tr>
</table>
<?php endif; ?>

        </td>
    </tr>
</table>
<br>

<?php endif; ?>

                    </td>
                </tr>
                <tr>
                    <td>

<?php if ($_POST['form_new_flg'] != true && $_POST['form_update_flg'] != true || $this->_tpl_vars['var']['pattern_err'] != null): ?>

<?php else: ?>

<table>
    <tr>
        <td>

<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(<?php echo $this->_tpl_vars['var']['path_sale_slip']; ?>
) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top" width="50%">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 260px; left: 5px;">
                            <tr style="color: #ff0000;">
                    <td>��<?php echo $this->_tpl_vars['form']['s_memo6']['html']; ?>
</td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 260px; left: 15px;">
                            <tr>
                    <td span style="font-size: 11px;"><?php echo $this->_tpl_vars['form']['s_memo6']['html']; ?>
</td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
        <td align="left" valign="top">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 5px; left: 45px;" cellspacing="0" cellpadding="0">
                            <tr>
                    <td style="color: #ff0000;">
                        ��<?php echo $this->_tpl_vars['form']['s_memo1']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_0']['html']; ?>

                        ��<?php echo $this->_tpl_vars['form']['s_memo2']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_1']['html']; ?>
<br>
                        ��<?php echo $this->_tpl_vars['form']['s_memo3']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_2']['html']; ?>

                        ��<?php echo $this->_tpl_vars['form']['s_memo4']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_3']['html']; ?>
<br>
                        ��<?php echo $this->_tpl_vars['form']['s_memo5']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_4']['html']; ?>
<br>
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 15px; left: 100px;" cellspacing="0" cellpadding="0">
                            <tr>
                    <td>
                        <span style="font: bold 15px;">
                        <?php echo $this->_tpl_vars['form']['s_memo1']['html']; ?>

                        <?php echo $this->_tpl_vars['form']['s_memo2']['html']; ?>
<br>
                        </span>
                        <span style="font-size: 11px;">
                        <?php echo $this->_tpl_vars['form']['s_memo3']['html']; ?>

                        <?php echo $this->_tpl_vars['form']['s_memo4']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['s_memo5']['html']; ?>
<br>
                        </span>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
    </tr>
</table>
</tr></td></table>
<br>

<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(<?php echo $this->_tpl_vars['var']['path_claim_slip']; ?>
) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��<?php echo $this->_tpl_vars['form']['s_memo7']['html']; ?>
</td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;"><?php echo $this->_tpl_vars['form']['s_memo7']['html']; ?>
</td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
    </tr>
</table>
</td></tr></table>
<br>

<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(<?php echo $this->_tpl_vars['var']['path_deli_slip']; ?>
) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��<?php echo $this->_tpl_vars['form']['s_memo8']['html']; ?>
</td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;"><?php echo $this->_tpl_vars['form']['s_memo8']['html']; ?>
</td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
    </tr>
</table>
</td></tr></table>
<br>

<table class="List_Table" width="940" height="370" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(<?php echo $this->_tpl_vars['var']['path_receive_slip']; ?>
) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 255px; left: 5px;">
                <tr>
                    <td style="color: #ff0000;">��<?php echo $this->_tpl_vars['form']['s_memo9']['html']; ?>
</td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 260px; left: 15px;">
                <tr>
                    <td span style="font-size: 11px;"><?php echo $this->_tpl_vars['form']['s_memo9']['html']; ?>
</td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
    </tr>
</table>
</td></tr></table>
<br>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
        <td align="right">
        <?php if ($this->_tpl_vars['var']['commit_flg'] != true):  echo $this->_tpl_vars['form']['new_button']['html'];  else:  echo $this->_tpl_vars['form']['ok_button']['html'];  endif; ?></td>
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
