<?php /* Smarty version 2.6.9, created on 2006-09-01 18:02:03
         compiled from 1-0-220.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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
<col width="110" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">�����襳����</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_cd']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">������̾</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_claim_name']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC��ʬ</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_fc_kubun_radio']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
����<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
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

<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">�����襳����</td>
        <td class="Title_Purple">������̾</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td><a href="#" onClick="returnValue=Array('000001','0001','������A');window.close();">000001-0001</a></td>
        <td>������A</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td><a href="#" onClick="returnValue=Array('000002','0002','������B');window.close();">000002-0002</a></td>
        <td>������B</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td><a href="#" onClick="returnValue=Array('000003','0003','������C');window.close();">000003-0003</a></td>
        <td>������C</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td><a href="#" onClick="returnValue=Array('000004','0004','������D');window.close();">000004-0004</a></td>
        <td>������D</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td><a href="#" onClick="returnValue=Array('000005','0005','������E');window.close();">000005-0005</a></td>
        <td>������E</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['form_close_button']['html']; ?>
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
