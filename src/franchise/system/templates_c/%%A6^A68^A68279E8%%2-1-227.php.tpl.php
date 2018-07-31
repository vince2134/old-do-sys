<?php /* Smarty version 2.6.14, created on 2007-05-07 09:06:23
         compiled from 2-1-227.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
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



<table width="400">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">½ä²óÃ´Åö¼Ô</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_staff_select']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
¡¡¡¡<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<?php if ($_POST['show_button'] != null): ?>
<table width="100%">
    <tr>
        <td>

Á´ <b><?php echo $this->_tpl_vars['var']['staff_count']; ?>
</b> ·ï<br><br><br>

<?php $_from = $this->_tpl_vars['ary_disp_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['item']):
?>
<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col style="font-weight: bold;" width="50">
<col span="7" width="100">
        <tr style="font: bold 13px;" class="Result1">
        <td rowspan="23" style="font: bold 15px;"><a href="./2-1-228.php?staff_id=<?php echo $this->_tpl_vars['item'][1][0]; ?>
"><?php echo $this->_tpl_vars['item'][1][1]; ?>
</a></b></td>
        <td colspan="9" class="Title_Purple">¡ÚABCD½µ¡Û</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">Æü</td>
        <td>·î</td>
        <td>²Ð</td>
        <td>¿å</td>
        <td>ÌÚ</td>
        <td>¶â</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">ÅÚ</td>
    </tr>
    <tr class="Result1">
        <td>A½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][0][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>B½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][0][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>C½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][0][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>D½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][0][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
        <tr>
        <td colspan="9" class="Title_Purple">¡Ú·îÎã¡ÊÆüÉÕ¡Ë¡Û</td>
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td rowspan="10" class="Value"></td>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
    </tr>
    <tr class="Result1">
        <?php $_from = $this->_tpl_vars['item'][2][1][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
    </tr>
    <tr class="Result1">
        <?php $_from = $this->_tpl_vars['item'][2][1][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>15</td>
        <td>16</td>
        <td>17</td>
        <td>18</td>
        <td>19</td>
        <td>20</td>
        <td>21</td>
    </tr>
    <tr class="Result1">
        <?php $_from = $this->_tpl_vars['item'][2][1][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr align="center" style="font-weight: bold;" bgcolor="#cccccc">
        <td>22</td>
        <td>23</td>
        <td>24</td>
        <td>25</td>
        <td>26</td>
        <td>27</td>
        <td>28</td>
    </tr>
    <tr class="Result1">
        <?php $_from = $this->_tpl_vars['item'][2][1][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr>
        <td style="font-weight: bold;" align="center" bgcolor="#cccccc">·îËö</td>
        <td rowspan="2" colspan="6"></td>
    </tr>
    <tr class="Result1">
        <td><nobr><?php echo $this->_tpl_vars['item'][2][1][4][0]; ?>
</nobr><br></td>
    </tr>
        <tr>
        <td colspan="9" class="Title_Purple">¡Ú·îÎã¡ÊÍËÆü¡Ë¡Û</td>
    </tr>
    <tr style="font-weight: bold;" align="center" bgcolor="#cccccc">
        <td></td>
        <td bgcolor="#ffbbc3" style="color: #ff0000;">Æü</td>
        <td>·î</td>
        <td>²Ð</td>
        <td>¿å</td>
        <td>ÌÚ</td>
        <td>¶â</td>
        <td bgcolor="#66ccff" style="color: #0000ff;">ÅÚ</td>
    </tr>
    <tr class="Result1">
        <td>Âè1½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][2][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>Âè2½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][2][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>Âè3½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][2][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
    <tr class="Result1">
        <td>Âè4½µ</td>
        <?php $_from = $this->_tpl_vars['item'][2][2][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j'] => $this->_tpl_vars['week']):
?>
        <?php if ($this->_tpl_vars['j'] != 0 && $this->_tpl_vars['j'] != 6): ?>
        <td><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 0): ?>
        <td bgcolor="#ffdde7"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php elseif ($this->_tpl_vars['j'] == 6): ?>
        <td bgcolor="#99ffff"><nobr><?php echo $this->_tpl_vars['week']; ?>
</nobr><br></td>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
</table>
<br><br>
<?php endforeach; endif; unset($_from); ?>

        </td>
    </tr>
</table>
<?php endif; ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
