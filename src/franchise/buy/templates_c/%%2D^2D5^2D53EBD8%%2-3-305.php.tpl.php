<?php /* Smarty version 2.6.14, created on 2010-02-22 15:02:40
         compiled from 2-3-305.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


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

<table align="center">
    <tr>    
        <td align="center">
            <?php if ($_GET['err'] == null): ?>
            <p style="font:bold 15px;margin-top:100px;"> 支払入力完了しました。</p>
            <?php elseif ($_GET['err'] == '1'): ?> 
            <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
            <ul style="margin-left: 16px;">
                <li>伝票が削除されているため、変更できません。<br>
            </ul>   
            </span> 
            <?php elseif ($_GET['err'] == '2'): ?> 
            <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
            <ul style="margin-left: 16px;">
                <li>日次更新処理が行われているため、変更できません。<br>
            </ul>   
            </span> 
            <?php endif; ?>   
            <?php echo $this->_tpl_vars['form']['ok_button']['html']; ?>
<br>

        </td>   
    </tr>   
</table>
<br>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
