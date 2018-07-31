<?php /* Smarty version 2.6.14, created on 2009-12-25 15:41:22
         compiled from 1-1-219.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<script language="javascript">
<?php echo $this->_tpl_vars['var']['code_value']; ?>

</script>

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

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<?php if ($this->_tpl_vars['form']['form_direct_cd']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_direct_cd']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['var']['form_direct_cd_error'] != null): ?><li><?php echo $this->_tpl_vars['var']['form_direct_cd_error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_direct_name']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_direct_name']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_direct_cname']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_direct_cname']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_post']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_post']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_address1']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_address1']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_tel']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_tel']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['form']['form_fax']['error'] != null): ?><li><?php echo $this->_tpl_vars['form']['form_fax']['error']; ?>
<br><?php endif;  if ($this->_tpl_vars['var']['form_client_error'] != null): ?><li><?php echo $this->_tpl_vars['var']['form_client_error']; ?>
<br><?php endif; ?>
</span>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="450">
    <tr>
        <td>

<table width="100%">
    <tr>
        <td align="right">
            <?php if ($_GET['direct_id'] != null): ?>
                <?php echo $this->_tpl_vars['form']['back_button']['html']; ?>

                <?php echo $this->_tpl_vars['form']['next_button']['html']; ?>

            <?php endif; ?>
        </td> 
   </tr>
</table>

<table class="Data_Table" border="1" width="100%">
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">直送先コード<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名1<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_name2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_direct_cname']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">郵便番号<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_post']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['input_button']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所1<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所2</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">住所3</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_address3']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">TEL</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_tel']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FAX</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fax']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple"><?php echo $this->_tpl_vars['form']['intro_claim_link']['html']; ?>
</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">備考</b></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_note']['html']; ?>
</td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left"><b><font color="#ff0000">※は必須入力です</font></b></td>
        <td align="right">　<?php echo $this->_tpl_vars['form']['form_back_button']['html'];  echo $this->_tpl_vars['form']['comp_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['entry_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['return_button']['html']; ?>
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
