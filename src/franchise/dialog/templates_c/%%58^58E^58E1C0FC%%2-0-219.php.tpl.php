<?php /* Smarty version 2.6.9, created on 2006-09-01 17:16:53
         compiled from 2-0-219.php.tpl */ ?>
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

        <tr align="left" valign="right">
        <td>
            <table>
                <tr>
                    <td>



<table width="300">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="120" style="font-weight: bold;">
    <tr>
        <td class="Title_Purple">巡回担当コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text8']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">巡回担当</td>
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
        <td class="Title_Purple">巡回担当コード</td>
        <td class="Title_Purple">巡回担当</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td><a href="#" onClick="returnValue=Array('0001','巡回担当A');window.close();">0001</a></td>
        <td>巡回担当A</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td><a href="#" onClick="returnValue=Array('0002','巡回担当B');window.close();">0002</a></td>
        <td>巡回担当B</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td><a href="#" onClick="returnValue=Array('0003','巡回担当C');window.close();">0003</a></td>
        <td>巡回担当C</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td><a href="#" onClick="returnValue=Array('0004','巡回担当D');window.close();">0004</a></td>
        <td>巡回担当D</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td><a href="#" onClick="returnValue=Array('0005','巡回担当E');window.close();">0005</a></td>
        <td>巡回担当E</td>
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
