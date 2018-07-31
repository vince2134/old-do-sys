<?php /* Smarty version 2.6.14, created on 2009-12-29 15:08:31
         compiled from 1-3-308.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<BODY>
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<?php echo $this->_tpl_vars['form']['javascript']; ?>

<?php echo $this->_tpl_vars['form']['hidden']; ?>

<table width='100%' height='90%' class='M_table' border='0'>

        <tr align='center' height='60'>
        <td width='100%' colspan='2' valign='top'><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align='center' valign='top'>
        <td>
            <table>
                <tr>
                    <td>
<br>
<table width='600' border='0'>
    <tr>
        <td align='CENTER'>
    <table class='Data_Table' border='1' width='100%'>
    <col width='100' style='font-weight: bold'>
    <col >
    <col width='100' style='font-weight: bold'>
        <tr>
            <td class='Title_Pink'>»ÅÆþÀè</td>
            <td class='Value' colspan='3'>
                <?php echo $this->_tpl_vars['pay_data'][10]; ?>
-<?php echo $this->_tpl_vars['pay_data'][11]; ?>
¡¡<?php echo $this->_tpl_vars['pay_data'][9]; ?>
</td>
        </tr>
        <tr>
            <td class='Title_Pink'>»ÅÆþÄùÆü</td>
            <td class='Value'><?php echo $this->_tpl_vars['close_day']; ?>
</td>                
            <td class='Title_Pink'>»ÙÊ§Í½ÄêÆü</td>
            <td class='Value'><?php echo $this->_tpl_vars['pay_data'][8]; ?>
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

<table width='100%' border='0'>
    <tr>
        <td align='CENTER'>
<table class='List_Table' width='100%' border='1'>
    <tr>
    <td class='Title_Pink' align='CENTER'><b>Á°²ó»ÙÊ§»Ä¹â</b></td>
    <td class='Title_Pink' align='CENTER'><b>Åö·î»ÙÊ§³Û</b></td>
    <td class='Title_Pink' align='CENTER'><b>·«±Û»Ä¹â³Û</b></td>
    <td class='Title_Pink' align='CENTER'><b>Åö·î»ÅÆþ³Û</b></td>
    <td class='Title_Pink' align='CENTER'><b>¾ÃÈñÀÇ³Û</b></td>
    <td class='Title_Pink' align='CENTER'><b>ÀÇ¹þ»ÅÆþ³Û</b></td>
    <td class='Title_Pink' align='CENTER'><b>Åö·î»ÙÊ§»Ä¹â</b></td>
    <td class='Title_Pink' align='CENTER'><b>º£²ó¤Î»ÙÊ§³Û</b></td>
    </tr>
    <tr>
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][0]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][1]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][2]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][3]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][4]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][5]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][6]; ?>
</td>                
            <td class='Value' align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][7]; ?>
</td>                
    </tr>
</table>
<br>
<br>
<table class='List_Table' width='100%' border='1'>
<tr>
    <td class='Title_Pink' align='CENTER'><b>·îÆü</b></td>
    <td class='Title_Pink' align='CENTER'><b>ÅÁÉ¼ÈÖ¹æ</b></td>
    <td class='Title_Pink' align='CENTER'><b>¼è°ú¶èÊ¬</b></td>
    <td class='Title_Pink' align='CENTER' width='300'><b>¾¦ÉÊÌ¾</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>¿ôÎÌ</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>Ã±²Á</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>¶â³Û</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>ÀÇ¶èÊ¬</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>»ÙÊ§</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>»Ä¹â</b></td>
</tr>
<tr class='Result1'>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>·«±Û</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][0]; ?>
</td> </tr>
<?php $_from = $this->_tpl_vars['detail_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row'] => $this->_tpl_vars['data']):
        $this->_foreach['list']['iteration']++;
?>
<tr class='Result1'>
    <td align='CENTER'><?php echo $this->_tpl_vars['data'][0]; ?>
</td>
    <td align='CENTER'><?php echo $this->_tpl_vars['data'][1]; ?>
</td>
    <td ><?php echo $this->_tpl_vars['data'][2]; ?>
</td>
    <td ><?php echo $this->_tpl_vars['data'][3]; ?>
</td>
    <td align='RIGHT'><?php echo $this->_tpl_vars['data'][4]; ?>
</td>
    <td align='RIGHT'><?php echo $this->_tpl_vars['data'][5]; ?>
</td>
    <td align='RIGHT'><?php echo $this->_tpl_vars['data'][6]; ?>
</td>
    <td align='CENTER'><?php echo $this->_tpl_vars['data'][7]; ?>
</td>
    <td align='RIGHT'><?php echo $this->_tpl_vars['data'][8]; ?>
</td>
    <td align='RIGHT'></td>
</tr>
<?php endforeach; endif; unset($_from);  if ($this->_tpl_vars['tax_div'] == '1'): ?>
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>¾ÃÈñÀÇ¶â³Û</td>
        <td></td>
        <td></td>
        <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][4]; ?>
</td>         <td></td>
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
    </tr>
<?php endif; ?>
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>·×</td>
        <td></td>
        <td></td>
        <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][5]; ?>
</td>         <td></td>
        <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][1]; ?>
</td>         <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][6]; ?>
</td>     </tr>
</table>
        </td>
    </tr>
    <tr>
        <td align='RIGHT'><?php echo $this->_tpl_vars['form']['btn_back']['html']; ?>
</td>
    </tr>
</table>
        </td>
    </tr>
</table>
        </td>
    </tr>
</table>
</form>
<?php echo $this->_tpl_vars['var']['html_footer']; ?>
