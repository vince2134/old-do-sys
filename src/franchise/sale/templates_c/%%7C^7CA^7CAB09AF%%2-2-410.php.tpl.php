<?php /* Smarty version 2.6.14, created on 2010-01-08 16:17:26
         compiled from 2-2-410.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table height="100%" valign="bottm">
                <tr>
                    <td>


<table>
    <tr>
<?php if ($this->_tpl_vars['var']['err_msg'] != null): ?>
        <td><span style="font: bold 13px; color: #ff0000;"><?php echo $this->_tpl_vars['var']['err_msg']; ?>
</span><br><br></td>
<?php else: ?>
                <td align=center>
        <span style="color: red;">※ブラウザの戻るボタンは使用せずに、OKボタンをクリックして下さい。</span>
        <br><br><br>

                <span style="font: bold 16px;">入金完了しました。</span><br><br>
        </td>
<?php endif; ?>
    </tr>
    <tr>
        <td align="center"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
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

