<?php /* Smarty version 2.6.14, created on 2010-04-05 14:44:30
         compiled from 2-1-307.php.tpl */ ?>
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

<?php if ($this->_tpl_vars['var']['comp_msg'] != null): ?>
    <span style="color: #0000ff; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['comp_msg']; ?>
</li><br>
    </span><br>
<?php endif; ?>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
    <span style="font-weight: bold; color: #555555;">¢¨¸½ºß¡¢°Ê²¼¤ÎÈ¯¹Ô¸µ¤¬ÅÐÏ¿ºÑ¤ß¤Ç¤¹¡£</span>
<?php else: ?>
    <span style="font-weight: bold; color: #0000ff;">°õ»ú¥Ñ¥¿¡¼¥ó¤òÅÐÏ¿¤·¤Þ¤·¤¿¡£</span>
<?php endif; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="950">
    <tr>
        <td>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
    <table width="100%">
        <tr valign="bottom">
            <td><?php echo $this->_tpl_vars['form']['pattern_select']['html']; ?>
¡¡<?php echo $this->_tpl_vars['form']['preview_button']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['change_button']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
</td>
        </tr>
    </table>
<?php else: ?>
<br>¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡<?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>

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
    </span>
<?php endif;  if ($_POST['form_new_flg'] != true && $_POST['form_update_flg'] != true || $this->_tpl_vars['var']['pattern_err'] != null): ?>

    <?php echo $this->_tpl_vars['form']['form_new_button']['html']; ?>


<?php else: ?>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="350">
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">¥Ñ¥¿¡¼¥óÌ¾<font color="#ff0000">¢¨</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['pattern_name']['html']; ?>
</td>
    </tr>
</table>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
<br>
<span style="font-weight: bold; color: #ff0000;">°Ê²¼¤Î¹àÌÜ¤òÀßÄê¤·¤Æ²¼¤µ¤¤¡£</span><br>
<table style="font-weight: bold; color: #555555;">
<col span="3" width="130">
    <tr>
        <td>­¡ ²ñ¼ÒÌ¾</td><td>­¢ ÂåÉ½¼ÔÌ¾</td><td>­£ ½»½ê</td>
    </tr>
    <tr>
        <td>­¤ TEL¡¦FAX</td><td>­¥¡Á­¬ ¼è°ú¶ä¹Ô</td><td>­­ ¥³¥á¥ó¥È</td>
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

<table class="List_Table" width="930" height="680" cellpadding="0"><tr><td class="Value">
<table width="100%" height="100%" style="background: url(../../../image/seikyusyo_fc.png) no-repeat fixed 30% 50%;">
    <tr>
        <td valign="top">
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 75px; left: 550px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="color: #ff0000;">
                        ­¡<?php echo $this->_tpl_vars['form']['c_memo1']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_0']['html']; ?>
<br>
                        ­¢<?php echo $this->_tpl_vars['form']['c_memo2']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_1']['html']; ?>
<br>
                        ­£<?php echo $this->_tpl_vars['form']['c_memo3']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_2']['html']; ?>
<br>
                        ­¤<?php echo $this->_tpl_vars['form']['c_memo4']['html']; ?>
 <?php echo $this->_tpl_vars['form']['font_size_select_3']['html']; ?>

                    </td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 125px; left: 600px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <span style="font: bold 15px;">
                        <?php echo $this->_tpl_vars['form']['c_memo1']['html']; ?>
<br>
                        </span>
                        <span style="font-size: 11px;">
                        <?php echo $this->_tpl_vars['form']['c_memo2']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo3']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo4']['html']; ?>

                        </span>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
                <?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
            <table style="position: relative; top: 480px; left: 15px;">
                <tr style="color: #ff0000;">
                    <td>
                        ­¥<?php echo $this->_tpl_vars['form']['c_memo5']['html']; ?>
¡¡­¦<?php echo $this->_tpl_vars['form']['c_memo6']['html']; ?>
<br>
                        ­§<?php echo $this->_tpl_vars['form']['c_memo7']['html']; ?>
¡¡­¨<?php echo $this->_tpl_vars['form']['c_memo8']['html']; ?>
<br>
                        ­©<?php echo $this->_tpl_vars['form']['c_memo9']['html']; ?>
¡¡­ª<?php echo $this->_tpl_vars['form']['c_memo10']['html']; ?>
<br>
                        ­«<?php echo $this->_tpl_vars['form']['c_memo11']['html']; ?>
¡¡­¬<?php echo $this->_tpl_vars['form']['c_memo12']['html']; ?>
<br>
                        ­­<?php echo $this->_tpl_vars['form']['c_memo13']['html']; ?>

                    </td>
                </tr>
            </table>
        <?php else: ?>
            <table style="position: relative; top: 530px; left: 50px;">
                <tr>
                    <td span style="font-size: 11px;">
                        <?php echo $this->_tpl_vars['form']['c_memo5']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['c_memo6']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo7']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['c_memo8']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo9']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['c_memo10']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo11']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['c_memo12']['html']; ?>
<br>
                        <?php echo $this->_tpl_vars['form']['c_memo13']['html']; ?>

                    </td>
                </tr>
            </table>
        <?php endif; ?>
        </td>
    </tr>
</table>
</tr></td></table>
<br>

<?php if ($this->_tpl_vars['var']['commit_flg'] != true): ?>
<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['new_button']['html']; ?>
</td>
    </tr>
</table>
<?php endif; ?>

<?php endif; ?>

        </td>
    </tr>
<table>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
