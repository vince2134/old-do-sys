<?php /* Smarty version 2.6.14, created on 2010-01-08 15:29:05
         compiled from 1-2-408.php.tpl */ ?>
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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table>
    <tr>
        <td align="center">

<?php if ($_GET['err'] == null): ?>
<span style="color: red;">※ブラウザの戻るボタンは使用せずに、OKボタンをクリックして下さい。</span>
<br><br><br>
<span style="font: bold 16px;">入金完了しました。</span>
<br><br>
<?php elseif ($_GET['err'] == '1'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>伝票が削除されているため、変更できません。<br>
</ul>
</span>
<?php endif; ?>

<table width="100%">
    <tr>
        <td align="center"><?php echo $this->_tpl_vars['form']['form_ok_btn']['html']; ?>
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
