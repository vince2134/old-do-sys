<?php /* Smarty version 2.6.14, created on 2010-05-20 15:02:20
         compiled from 2-3-308.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>

<SCRIPT LANGUAGE='javascript' SRC='estimate.js'></SCRIPT>
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
            <td class='Title_Pink'>������</td>
            <td class='Value' colspan='3'>
                <?php echo $this->_tpl_vars['pay_data'][10]; ?>
-<?php echo $this->_tpl_vars['pay_data'][11]; ?>
��<?php echo $this->_tpl_vars['pay_data'][9]; ?>
</td>
        </tr>
        <tr>
            <td class='Title_Pink'>��������</td>
            <td class='Value'><?php echo $this->_tpl_vars['close_day']; ?>
</td>                
            <td class='Title_Pink'>��ʧͽ����</td>
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
    <td class='Title_Pink' align='CENTER'><b>�����ʧ�Ĺ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʧ��</b></td>
    <td class='Title_Pink' align='CENTER'><b>���ۻĹ��</b></td>
    <td class='Title_Pink' align='CENTER'><b>���������</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ǳ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�ǹ�������</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʧ�Ĺ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>����λ�ʧ��</b></td>
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
    <td class='Title_Pink' align='CENTER'><b>����</b></td>
    <td class='Title_Pink' align='CENTER'><b>��ɼ�ֹ�</b></td>
    <td class='Title_Pink' align='CENTER'><b>�����ʬ</b></td>
    <td class='Title_Pink' align='CENTER' width='300'><b>����̾</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>����</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>ñ��</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>���</b></td>
    <td class='Title_Pink' align='CENTER' width='40'><b>�Ƕ�ʬ</b></td>
    <td class='Title_Pink' align='CENTER' width='80'><b>�����ƥ�</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>��ʧ</b></td>
    <td class='Title_Pink' align='CENTER' width='60'><b>�Ĺ�</b></td>
</tr>
<tr class='Result1'>
    <td></td>
    <td></td>
    <td></td>
    <td align='RIGHT'>����</td>
    <td></td>
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
    <td align='CENTER'><?php echo $this->_tpl_vars['data'][9]; ?>
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
        <td align='RIGHT'>�����Ƕ��</td>
        <td></td>
        <td></td>
        <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][4]; ?>
</td>         <td></td>
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
        <td align='RIGHT'></td> 
    </tr>
<?php endif; ?>
    <tr class='Result1'>
        <td></td>
        <td></td>
        <td></td>
        <td align='RIGHT'>��</td>
        <td></td>
        <td></td>
        <td align='RIGHT'><?php echo $this->_tpl_vars['pay_data'][5]; ?>
</td>         <td></td>
        <td></td>
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
