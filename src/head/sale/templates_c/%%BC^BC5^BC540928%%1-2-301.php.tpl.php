<?php /* Smarty version 2.6.14, created on 2009-12-08 19:14:40
         compiled from 1-2-301.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

<?php echo $this->_tpl_vars['var']['contract']; ?>

<?php echo $this->_tpl_vars['var']['js']; ?>

</script>


<body bgcolor="#D8D0C8" onLoad="Text_Disabled('<?php echo $_POST['form_slipout_type'][0]; ?>
')">
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['form']['form_claim_day1']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_claim_day1']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_claim_day2']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_claim_day2']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_claim']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_claim']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['form']['form_year_month']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_year_month']['error']; ?>
<br>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['var']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['error']; ?>
<br>
    <?php endif; ?>
    <ul>    
    <?php $_from = $this->_tpl_vars['sale_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['i'] == 0): ?>
        <li>°Ê²¼¤ÎÇä¾åÅÁÉ¼¤ÏÆü¼¡¹¹¿·¤µ¤ì¤Æ¤¤¤Ê¤¤¤¿¤áÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¼ºÇÔ¤·¤Þ¤·¤¿¡£<br>
        <?php endif; ?>   
        <?php echo $this->_tpl_vars['item']; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
    <?php $_from = $this->_tpl_vars['pay_err']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['i'] == 0): ?>
        <li>°Ê²¼¤ÎÆþ¶âÅÁÉ¼¤ÏÆü¼¡¹¹¿·¤µ¤ì¤Æ¤¤¤Ê¤¤¤¿¤áÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¼ºÇÔ¤·¤Þ¤·¤¿¡£<br>
        <?php endif; ?>   
        <?php echo $this->_tpl_vars['item']; ?>
<br>
    <?php endforeach; endif; unset($_from); ?>
    </ul>   
</span>   

<table width="100%">
    <tr>
        <td>
        <div class="note">
        ÀÁµá¥Ç¡¼¥¿¤ÎºîÀ®¤Ë¤Ä¤¤¤Æ<br>
        ¡¡­¡ÀÁµá½ñ¤ò¹¹¿·¸å¤ÏºÆºîÀ®¤µ¤ì¤Þ¤»¤ó¡£<br>
        ¡¡­¢ÀÁµáÄùÆü¹¹¿·Á°¤ÎÀÁµá¥Ç¡¼¥¿¤ÏÊÑ¹¹²ÄÇ½¤Ç¤¹¡£Ã¢¤·¡¢ÀÁµáºîÀ®ºÑ¤Î¥Ç¡¼¥¿¤òºï½ü¤·¤ÆºîÀ®²ÄÇ½¤Ç¤¹¡£<br>
        <div><p>
<table width="500" >
    <tr>
        <td align="left" colspan="2"><?php echo $this->_tpl_vars['form']['form_slipout_type'][0]['html']; ?>
</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        »ØÄê¤·¤¿ÄùÆü¤ÎÆÀ°ÕÀè¤ËÂÐ¤·¤Æ¡¢ÀÁµá½ñ¤òºîÀ®¤·¤Þ¤¹
        <table class="Data_Table" border="1" width="300">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink">ÀÁµáÄùÆü<font color="#ff0000">¢¨</font></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day1']['html']; ?>
</td>
            </tr>
        </table>
        </td>
    </tr>
</table>
        </td>
    </tr>
    <tr>
        <td>

<table width="660" >
    <tr>
        <td align="left" colspan="2"><?php echo $this->_tpl_vars['form']['form_slipout_type'][1]['html']; ?>
</td>
    </tr>
    <tr>
        <td width="100"></td>
        <td>
        »ØÄê¤·¤¿ÆÀ°ÕÀè¤ËÂÐ¤·¤Æ¡¢»ØÄê¤·¤¿ÀÁµáÄùÆü¤Þ¤Ç¤ÎÀÁµá½ñ¤òºîÀ®¤·¤Þ¤¹
        <table class="Data_Table" border="1" width="450">
        <col width="100" style="font-weight:bold;">
        <col>
            <tr>
                <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['form_claim_link']['html']; ?>
<font color="#ff0000">¢¨</font></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim']['html']; ?>
</td>
            </tr>
            <tr>
                <td class="Title_Pink">ÀÁµáÄùÆü<font color="#ff0000">¢¨</font></td>
                <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_day2']['html']; ?>
</td>
            </tr>
        </table>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td><font color="#ff0000"><b>¢¨¤ÏÉ¬¿ÜÆþÎÏ¤Ç¤¹</b></font></td>
        <td align="right"><?php echo $this->_tpl_vars['form']['form_create_button']['html']; ?>
</td>
    </tr>
</table>
        

        </td>
    </tr>
</table>
<br><br>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="350" align="center">
    <tr>
        <td>

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Pink">No.</td>
        <td class="Title_Pink">ÄùÆü</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['var']['last_date']; ?>
</td>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['var']['now_date']; ?>
</td>
    </tr>
    <?php $_from = $this->_tpl_vars['page_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr class="Result1">        <td align="right"><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['page_data'][$this->_tpl_vars['i']][0]; ?>
</td>
        <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][1] == null): ?>
        <td align="center">¡ß</td>
        <?php else: ?>
        <td align="center">¡û</td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['page_data'][$this->_tpl_vars['i']][2] == null): ?>
        <td align="center">¡ß</td>
        <?php else: ?>
        <td align="center">¡û</td>
        <?php endif; ?>
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
</table>
<br>
¡û¡§°ì³çºîÀ®ºÑ¡¡¡¡¡ß¡§°ì³çºîÀ®Ì¤
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
