<?php /* Smarty version 2.6.9, created on 2006-08-09 17:28:53
         compiled from Smarty_QuickForm_sample.php.tpl */ ?>
<html>
<head>
    <title>sample</title>
</head>
<body>

<?php echo $this->_tpl_vars['form']['nick_name']['label'];  echo $this->_tpl_vars['form']['nick_name']['html']; ?>

<hr>
    ���ѥ�����
    <table border="1" width="650">
    <tr bgcolor="red">
        <td>No.</td>
        <td>̾��</td>
        <td>ǯ��</td>
        <td>�����</td>
    </tr>
        <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['data'][$this->_tpl_vars['i']][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['data'][$this->_tpl_vars['i']][1]; ?>
������</td>
        <td><?php echo $this->_tpl_vars['data'][$this->_tpl_vars['i']][2]; ?>
��������</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <br>
    ���ѥ�����2    
    <table border="1" width="650">
    <tr bgcolor="blue">
        <td>No.</td>
        <td>̾��</td> 
        <td>ǯ��</td> 
        <td>�����</td> 
    </tr>   
        <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr>    
        <td><?php echo $this->_tpl_vars['i']+1; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][0]; ?>
</td>
        <td><?php echo $this->_tpl_vars['item'][1]; ?>
������</td> 
        <td><?php echo $this->_tpl_vars['item'][2]; ?>
��������</td> 
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <br>
    ���ѥ�����3
    <table border="1" width="650">
    <tr bgcolor="green">
        <td>No.</td>
        <td>̾��</td>
        <td>ǯ��</td>
        <td>�����</td>
    </tr>   
        
        <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
    <tr>
        <td><?php echo $this->_tpl_vars['i']+1; ?>
</td>
                <?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['items']):
?>
            <?php if ($this->_tpl_vars['j'] == 0): ?>  
                <td><?php echo $this->_tpl_vars['items']; ?>
</td>
            <?php elseif ($this->_tpl_vars['j'] == 1): ?>
                <td><?php echo $this->_tpl_vars['items']; ?>
������</td>
            <?php else: ?>
                <td><?php echo $this->_tpl_vars['items']; ?>
��������</td>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>   
    <?php endforeach; endif; unset($_from); ?>
    </table>
</body>
</html>