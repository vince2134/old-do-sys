<?php /* Smarty version 2.6.14, created on 2009-12-22 13:08:43
         compiled from 2-1-101.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script>
    <?php echo $this->_tpl_vars['var']['javascript']; ?>

</script>

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
            <table>
                <tr>
                    <td>


<table width="800">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="110" style="font-weight: bold;">
<col>
<col width="120" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output_type']['html']; ?>
</td>
        <td class="Title_Purple">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_display_num']['html']; ?>
</td>
    </tr>
    <tr>
       <td class="Title_Purple">親子区分</td>
        <td class="Value" colspan="3"><?php echo $this->_tpl_vars['form']['form_parents_div']['html']; ?>
</td>
    </tr>

    <tr>
        <td class="Title_Purple">グループ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_gr']['html']; ?>
</td>
        <td class="Title_Purple">グループ名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_gr_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
        <td class="Title_Purple">得意先名・略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_id']['html']; ?>
</td>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">巡回担当者</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_c_staff']['html']; ?>
</td>
        <td class="Title_Purple">業種</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_btype']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_state_type']['html']; ?>
</td>
        <td class="Title_Purple">取引区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_trade']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
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

<?php echo $this->_tpl_vars['html']['html_l']; ?>


                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>

<?php echo $this->_tpl_vars['var']['html_footer']; ?>
