<?php /* Smarty version 2.6.9, created on 2006-09-16 13:49:34
         compiled from 109_test.php.tpl */ ?>
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
   

        </td>
    </tr>
    <tr>
        <td>

<span style="font: bold 15px; color: #555555;">ログイン情報を <?php echo $this->_tpl_vars['form']['form_login_info']['html']; ?>
</span>
<span style="color: #ff0000; font-weight: bold;">　<?php echo $this->_tpl_vars['var']['login_info_msg']; ?>
</span><br>
<table class="Data_Table" border="1" width="100%">
<col width="150" style="font-weight: bold;">
<col>
    
    <tr>
        <td class="Title_Purple">パスワード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_password1']['html']; ?>

            <span style="color: #ff0000; font-weight: bold;">
            <?php if ($this->_tpl_vars['var']['password_msg'] != null):  echo $this->_tpl_vars['var']['password_msg'];  endif; ?>
            </span>
        </td>
    </tr>
    <tr>
        <td class="Title_Purple">パスワード<br>(確認用)</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_password2']['html']; ?>
</td>
    </tr>
   
</table>

<table width="100%">
    <tr>
        <td><?php if ($_GET['staff_id'] != null):  echo $this->_tpl_vars['form']['del_button']['html'];  endif; ?></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['comp_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
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
