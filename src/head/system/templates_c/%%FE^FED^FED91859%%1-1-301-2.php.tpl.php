<?php /* Smarty version 2.6.9, created on 2006-09-11 20:33:17
         compiled from 1-1-301-2.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<!--------------------- 外枠開始 ---------------------->
<table border="0" width="100%" height="90%" class="M_table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
            <!-- 画面タイトル開始 --> <?php echo $this->_tpl_vars['var']['page_header']; ?>
 <!-- 画面タイトル終了 -->
        </td>
    </tr>

    <tr align="center">

        <!---------------------- 画面表示開始 --------------------->
        <td valign="top">

            <table border="0">
                <tr>
                    <td>

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>
 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['file_shain']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['file_shain']['error']; ?>
<br><?php endif; ?>
</span>

<!---------------------- 画面表示1開始 --------------------->
<!--<font size="+0.5" color="#555555"><b>【自社情報】</b></font>-->
<table class="Data_Table" border="1" width="300">
<col width="125">
<col width="175">
<col width="125">
<col width="175">
    <tr>
        <td class="Title_Purple" align="center"><b>社印</b></td>
    </tr>

    <tr>
        <td class="Value" rowspan="4" colspan="2">
            <table align="center">
            <tr>
                <td align="center">
                    <table width="60" height="60" align="center" style="background-image: url(<?php echo $this->_tpl_vars['var']['path_shain']; ?>
);background-repeat:no-repeat; cellspacing="0" cellpadding="0" border="0">
                        <tr><td><br></td></tr>
                    </table>
                </td>
            </tr>
            </table>
            <table align="center">
            <tr>
                <td colspan="2"><font color="#555555">新しい社印：</font><?php echo $this->_tpl_vars['form']['file_shain']['html']; ?>
</td>
            </tr>
            </table>
            </td>
        </td>
    </tr>

</table>
<br>
<table width="300">
    <tr>
        <td align="right">
            <?php echo $this->_tpl_vars['form']['form_entry']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_cancel']['html']; ?>

        </td>
    </tr>
</table>
<!--******************** 画面表示1終了 *******************-->

                    <br>
                    </td>
                </tr>

            </table>
        </td>
        <!--******************** 画面表示終了 *******************-->

    </tr>
</table>
<!--******************* 外枠終了 ********************-->

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
