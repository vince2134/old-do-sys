<?php /* Smarty version 2.6.14, created on 2010-05-22 16:10:04
         compiled from 2-2-413.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%" class="M_table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table height="100%">
                <tr>
                    <td>


<table>
    <tr>
        <td valign="middle">

<?php if ($_GET['ps'] == '1'): ?>
<span style="font: bold 16px;">登録完了しました。</span><br><br>
<?php elseif ($_GET['ps'] == '2'): ?>
<span style="font: bold 16px;">変更完了しました。</span><br><br>
<?php elseif ($_GET['err'] == '1'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>伝票が削除されているため、変更できません。<br>
</ul>
</span>
<?php elseif ($_GET['err'] == '2'): ?>
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
    <li>前受金確定処理が行われたため、変更できません。<br>
</ul>
</span>
<?php endif; ?>

<table width="100%">
    <tr>
        <td align="right"><?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
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
