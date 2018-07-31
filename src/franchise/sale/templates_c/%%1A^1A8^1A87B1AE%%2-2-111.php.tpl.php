<?php /* Smarty version 2.6.14, created on 2010-02-20 16:11:54
         compiled from 2-2-111.php.tpl */ ?>

<?php echo $this->_tpl_vars['var']['html_header']; ?>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<table border="0" width="100%" height="90%" class="M_Table">

    <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top">
             <?php echo $this->_tpl_vars['var']['page_header']; ?>
         </td>
    </tr>

    <tr align="left">
        <td valign="top">
        
            <table>
                <tr>
                    <td>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
        <?php if ($this->_tpl_vars['form']['form_round_day']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_round_day']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_multi_staff']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_multi_staff']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_not_multi_staff']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_not_multi_staff']['error']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['var']['form_num_mess'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['form_num_mess']; ?>
<br>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['form']['form_round_staff']['error'] != null): ?>
        <li><?php echo $this->_tpl_vars['form']['form_round_staff']['error']; ?>

    <?php endif; ?>
</span>
 
<span style="color: #0000FF; font-weight: bold; line-height: 130%;">
    <?php if ($this->_tpl_vars['var']['done_mess'] != null): ?>
        <li><?php echo $this->_tpl_vars['var']['done_mess']; ?>
<br>
    <?php endif; ?>
</span>


<?php echo $this->_tpl_vars['html']['html_s']; ?>


<br style="font-size: 4px;">

<table class="Table_Search">
<col width="115px" style="font-weight: bold;">
<col width="300px">
<col width="115px" style="font-weight: bold;">
<col width="300px">
    <tr>
        <td class="Td_Search_3">除外巡回担当者<br>（複数選択）</td>
        <td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['form_not_multi_staff']['html']; ?>
<br> 例）0001,0002</td>
        <td class="Td_Search_3"><b>集計区分</b></td>
        <td class="Td_Search_3"><?php echo $this->_tpl_vars['form']['form_count_radio']['html']; ?>
</td>
    </tr>
</table>

<table width='100%'>
    <tr>
        <td align='right'>
            <?php echo $this->_tpl_vars['form']['form_display']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['form_clear']['html']; ?>

        </td>
    </tr>
</table>

                    <br>
                    </td>
                </tr>


                <tr>
                    <td align="left" valign="top">

<?php echo $this->_tpl_vars['var']['html_sum_table']; ?>

<div style="page-break-before: always;"></div>
<?php echo $this->_tpl_vars['var']['html']; ?>

<br>
<?php echo $this->_tpl_vars['form']['hidden']; ?>



                    </td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>

    
