<?php /* Smarty version 2.6.14, created on 2009-11-02 14:10:23
         compiled from 1-0-210.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="document.dateForm.form_goods_name.focus()">
<form name="dateForm" method="post">
<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width="100%" height="90%">

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>



<table width="350">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">æ¶… •≥°º•…</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">æ¶… Ãæ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">Œ¨æŒ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_goods_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">£Õ∂Ë ¨</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_goods']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">¥…Õ˝∂Ë ¨</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_product']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">æ¶…  ¨Œ‡</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_g_product']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
°°°°<?php echo $this->_tpl_vars['form']['form_close_button']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
</table>
<br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<?php echo $this->_tpl_vars['var']['html_page']; ?>

<table class="List_Table" border="1">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple" align="center">No.</td>
        <td class="Title_Purple">æ¶… •≥°º•…</td>
        <td class="Title_Purple">æ¶…  ¨Œ‡</td>
        <td class="Title_Purple">æ¶… Ãæ</td>
        <td class="Title_Purple">Œ¨æŒ</td>
        <td class="Title_Purple">¥…Õ˝∂Ë ¨</td>
        <td class="Title_Purple">£Õ∂Ë ¨</td>
        <td class="Title_Purple">¬∞¿≠∂Ë ¨</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
		<?php if ($this->_tpl_vars['var']['page_snum']-1 <= $this->_tpl_vars['j'] && $this->_tpl_vars['j'] <= $this->_tpl_vars['var']['page_enum']-1): ?>

    <tr class="Result1"> 
        <td><?php echo $this->_tpl_vars['j']+1; ?>
</td>
        <td><a href="#" onClick="returnValue=Array(<?php echo $this->_tpl_vars['return_data'][$this->_tpl_vars['j']]; ?>
);window.close();"><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][0]; ?>
</a></td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][12]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][1]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][2]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][3]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][4]; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['j']][5]; ?>
</td>
    </tr>   
		<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


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
