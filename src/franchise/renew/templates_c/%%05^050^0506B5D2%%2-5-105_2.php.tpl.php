<?php /* Smarty version 2.6.9, created on 2006-12-28 15:02:24
         compiled from 2-5-105_2.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>

    <?php if ($this->_tpl_vars['form']['form_end_day']['error'] != null): ?>
        <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <li><?php echo $this->_tpl_vars['form']['form_end_day']['error']; ?>
<br>
        </span>
    <?php endif; ?>

<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Green">���Ϸ���</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_output_radio']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">���״���</td>
        <td class="Value"><?php echo $this->_tpl_vars['var']['update_time']; ?>
 �� <?php echo $this->_tpl_vars['form']['form_end_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Green">ô����</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr align="right">
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td style="color: #0000ff; font-weight: bold;"><li>�оݤȤʤ���ɼ�ϡ����������������������̤�»ܤ���ɼ�Ǥ���</li></td>
    </tr>
</table>

        </tr>
    </td>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">����塦�����</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">ô����̾</td>
        <td colspan="8" class="Title_Green">�����߷�</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">��߷�</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">��<br>���</td>
        <td class="Title_Green">���<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>�����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">��<br>���</td>
        <td class="Title_Green">���<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">����<br>�����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>���</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_1']; ?>

</table>
<br><br>

<span style="font: bold 15px; color: #555555;">�ڻ�������ʧ��</span>
<table class="List_Table" border="1" width="1300">
    <tr align="center" style="font-weight: bold;">
        <td rowspan="2" class="Title_Green">ô����̾</td>
        <td colspan="8" class="Title_Green">�����߷�</td>
        <td rowspan="2" class="Title_Green"></td>
        <td colspan="8" class="Title_Green">��߷�</td>
    </tr>
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">��<br>����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">��ʧ<br>�����</td>
        <td class="Title_Green">��ʧ<br>���</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>����</td>
        <td class="Title_Green">��<br>����</td>
        <td class="Title_Green">����<br>���</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">����<br>��ʧ</td>
        <td class="Title_Green">��ʧ<br>�����</td>
        <td class="Title_Green">��ʧ<br>���</td>
        <td class="Title_Green">����<br>���</td>
    </tr>
    <?php echo $this->_tpl_vars['var']['html_2']; ?>

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
