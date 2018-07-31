<?php /* Smarty version 2.6.9, created on 2006-12-01 11:17:11
         compiled from kaku-m_test.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
</span>

<table><tr><td>

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
        <td class="Title_Purple">担当者コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_charge_cd']['html']; ?>
</td>
        <td class="Title_Purple">スタッフ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">削除権限</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_del_compe']['html']; ?>
</td>
        <td class="Title_Purple">承認権限</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_accept_compe']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">権限付与</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_compe_invest']['html']; ?>
</td>
        <td class="Title_Purple">
<a href="#" onClick="return window.open('kaku-m_sub.php','sub','width=600, height=800,scrollbars=yes,location=no, menubar=no,left=10,top=30');">画面</a>（未対応）</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan=>在職識別</td>
        <td class="Value" colspan=3><?php echo $this->_tpl_vars['form']['form_staff_state']['html']; ?>
</td>
    </tr>


</table>
<tr><td align=right><?php echo $this->_tpl_vars['form']['show_btn']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_btn']['html']; ?>
<br></td></tr>
<tr><td align=right><br><?php echo $this->_tpl_vars['form']['csv_btn']['html']; ?>
</td></tr>
</td></tr></table>
<br>

                                        </td>
                                </tr>
                                <tr>
                                        <td>

<table width="100%">
    <tr>
        <td>
    <?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%">
        <tr>
    <?php echo $this->_tpl_vars['var']['num']; ?>
<br>
    <?php echo $this->_tpl_vars['var']['html']; ?>

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

