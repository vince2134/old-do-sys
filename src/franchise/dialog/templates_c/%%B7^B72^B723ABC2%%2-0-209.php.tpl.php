<?php /* Smarty version 2.6.9, created on 2006-09-01 17:09:21
         compiled from 2-0-209.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
</head>

<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

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
    <tr>
        <td class="Title_Purple">直送先コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text4']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">直送先名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text20']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text10']['html']; ?>
</td>
    </tr>
</table>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['kuria']['html']; ?>
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
        <td class="Title_Purple">直送先コード</td>
        <td class="Title_Purple">直送先名</td>
        <td class="Title_Purple">略称</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td><a href="#" onClick="returnValue=Array('0001','直送先A');window.close();">0001</a></td>
        <td>直送先A</td>
        <td>直送A</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td><a href="#" onClick="returnValue=Array('0002','直送先B');window.close();">0002</a></td>
        <td>直送先B</td>
        <td>直送B</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td><a href="#" onClick="returnValue=Array('0003','直送先C');window.close();">0003</a></td>
        <td>直送先C</td>
        <td>直送C</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td><a href="#" onClick="returnValue=Array('0004','直送先D');window.close();">0004</a></td>
        <td>直送先D</td>
        <td>直送D</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td><a href="#" onClick="returnValue=Array('0005','直送先E');window.close();">0005</a></td>
        <td>直送先E</td>
        <td>直送E</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['close']['html']; ?>
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
