<?php /* Smarty version 2.6.14, created on 2009-12-25 18:57:12
         compiled from 2-0-103.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8" onLoad="Form_Set(); Onload_Focus();">

<script language="javascript">
<?php echo $this->_tpl_vars['html']['js']; ?>

</script>

<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>
<?php echo $this->_tpl_vars['form']['hidden']; ?>


<table width="100%" height="90%">

        <tr valign="top">
        <td>
            <table>
                <tr>
                    <td>

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['err_client_cd1']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['err_client_cd1']['error']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<table width="500">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="160" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">表示件数</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_range']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">検索方法</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_method']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード 上6桁<font color="#ff0000;" id="required">※</font></td>
        <td class="Value"><span id="method1"></span></td>
    </tr>
    <tr>
        <td class="Title_Purple">得意先コード 下4桁</td>
        <td class="Value"><span id="method2"></span></td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['show_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['clear_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['close_button']['html']; ?>
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

<?php echo $this->_tpl_vars['html']['html_page']; ?>

<?php echo $this->_tpl_vars['html']['html_l']; ?>

<?php echo $this->_tpl_vars['html']['html_page2']; ?>


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
