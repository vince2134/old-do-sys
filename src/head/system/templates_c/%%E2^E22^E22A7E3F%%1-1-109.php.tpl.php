<?php /* Smarty version 2.6.14, created on 2009-12-25 11:03:05
         compiled from 1-1-109.php.tpl */ ?>
<?php echo $this->_tpl_vars['form']['javascript']; ?>

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
<?php if ($this->_tpl_vars['form']['form_cshop']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_cshop']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_staff_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_staff_cd']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_charge_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_charge_cd']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_staff_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_staff_name']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_staff_ascii']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_staff_ascii']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_birth_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_birth_day']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_join_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_join_day']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_part']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_part']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_retire_day']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_retire_day']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_photo_ref']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_photo_ref']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_license']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_license']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_note']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_note']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_login_id']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_login_id']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_password1']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_password1']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['permit_error']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['permit_error']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['var']['staff_del_restrict_msg'] != null): ?><li><?php echo $this->_tpl_vars['var']['staff_del_restrict_msg']; ?>
<br><?php endif; ?>
</span>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="750">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right">
            <?php if ($_GET['staff_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td>
    </tr>
</table>

<span style="font-size: 15px; color: #555555; font-weight: bold;">�ڽ�°��</span>
<?php if ($this->_tpl_vars['var']['warning'] != null): ?><br><font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning']; ?>
</b></font><?php endif;  if ($this->_tpl_vars['var']['warning2'] != null): ?><br><font color="#ff0000"><b><?php echo $this->_tpl_vars['var']['warning2']; ?>
</b></font><?php endif; ?>

<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����åռ���</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_kind']['html']; ?>
</td>
    </tr>
     
    <?php if ($_POST['form_staff_kind'] == '3' || $_POST['form_staff_kind'] == '4' || $this->_tpl_vars['var']['cshop_head_flg'] == 'true' || $this->_tpl_vars['var']['only_head_flg'] == 'true'): ?>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cshop_head']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
     
    <?php if ($_POST['form_staff_kind'] != '3' && $this->_tpl_vars['var']['only_head_flg'] != 'true'): ?>
    <tr>
        <td class="Title_Purple">����å�̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_cshop']['html']; ?>
</td>
    </tr>
    <?php endif; ?>
</table>
<br>

<span style="font-size: 15px; color: #555555; font-weight: bold;">�ڥ����åվ����</span>
<table class="Data_Table" border="1" width="50%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Type">�߿�����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state']['html']; ?>
</td>
    </tr>
</table>
<br>

<table class="Data_Table" border="1" width="100%" border=1>
<col width="150" style="font-weight: bold;">
<col>
<col width="200">
    <tr>
        <td class="Title_Purple">�ͥåȥ����ID</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_cd']['html']; ?>
</td>
        <td class="Title_Purple" align="center"><b>�����̿�</b></td>
    </tr>
    <tr>
        <td class="Title_Purple">�����å�̾<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_name']['html']; ?>
</td>
        <td class="Value" rowspan="8" align="center">
            <table width="120" height="140" align="center" style="background-image: url(1-1-110.php?staff_id=<?php echo $this->_tpl_vars['var']['staff_id']; ?>
);background-repeat:no-repeat; margin-bottom: -3px; margin-top: -1px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td><img src="../../../image/frame.PNG" width="120" height="140" border="0"></td>
                </tr>
                <tr height="5"><td></td></tr>
            </table>

            <table align="center">
                <tr>
                    <td style="color: #555555;">
                        <?php if ($this->_tpl_vars['var']['freeze_flg'] != true):  echo $this->_tpl_vars['form']['form_photo_ref']['html']; ?>
<br><?php endif; ?>
                        &nbsp;<?php echo $this->_tpl_vars['form']['form_photo_del']['html']; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">�����å�̾<br>(�եꥬ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_read']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�����å�̾<br>(���޻�)<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_ascii']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_sex']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��ǯ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_birth_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�࿦��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_retire_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_study']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ȥ�����ǻλ��<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_toilet_license']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ô���ԥ�����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charge_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����ǯ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_join_day']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ѷ���<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_employ_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">��°����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_part']['html']; ?>
��<?php echo $this->_tpl_vars['form']['form_section']['html']; ?>
��</td> 
    </tr>
    <tr>
        <td class="Title_Purple">��</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_position']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">����<font color="#ff0000">��</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_job_type']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">���ô����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_round_staff']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�������</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_license']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><b><font color="#ff0000">����ɬ�����ϤǤ�</font></b></td>
    </tr>
</table>
<br>

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">���������� <?php echo $this->_tpl_vars['form']['form_login_info']['html']; ?>
</span>
<span style="color: #ff0000; font-weight: bold;">��<?php echo $this->_tpl_vars['var']['login_info_msg']; ?>
</span><br>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">������ID</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_login_id']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">�ѥ����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_password1']['html']; ?>

            <span style="color: #ff0000; font-weight: bold;">
            <?php if ($this->_tpl_vars['var']['password_msg'] != null):  echo $this->_tpl_vars['var']['password_msg'];  endif; ?>
            </span>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">�ѥ����<br>(��ǧ��)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_password2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php if ($this->_tpl_vars['var']['select_staff_kind'] != null):  echo $this->_tpl_vars['form']['form_permit_link']['html'];  else: ?>����<?php endif; ?></a></td>
        <td class="Value"><?php if ($this->_tpl_vars['var']['permit_set_msg'] != null):  echo $this->_tpl_vars['var']['permit_set_msg'];  endif; ?></td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><?php if ($_GET['staff_id'] != null):  echo $this->_tpl_vars['form']['del_button']['html'];  endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
��<?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</form>
</table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
