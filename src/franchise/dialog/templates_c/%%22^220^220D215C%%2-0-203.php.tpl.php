<?php /* Smarty version 2.6.9, created on 2006-09-01 17:07:12
         compiled from 2-0-203.php.tpl */ ?>
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



<table>
    <tr>
        <td>

<table class="Data_Table" border="1" width="300">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">業種コード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text4']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">業種名</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text10']['html']; ?>
</td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['hyouji']['html']; ?>
　　<?php echo $this->_tpl_vars['form']['button']['kuria']['html']; ?>
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
        <td class="Title_Purple">業種コード</td>
        <td class="Title_Purple">業種名</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td><a href="#" onClick="returnValue=Array('00001','外食ファーストフード');window.close();">00001</a></td>
        <td>外食ファーストフード</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td><a href="#" onClick="returnValue=Array('00002','学校関係');window.close();">00002</a></td>
        <td>学校関係</td>
    </tr>
        <tr class="Result1">
        <td align="right">3</td>
        <td><a href="#" onClick="returnValue=Array('00003','医療関係');window.close();">00003</a></td>
        <td>医療関係</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td><a href="#" onClick="returnValue=Array('00004','ファミレス');window.close();">00004</a></td>
        <td>ファミレス</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td><a href="#" onClick="returnValue=Array('00005','コンビニ');window.close();">00005</a></td>
        <td>コンビニ</td>
    </tr>
</table>
<?php echo $this->_tpl_vars['var']['html_page2']; ?>


        </td>
    </tr>
    <tr>
        <td>

<table align="right">
    <tr>
        <td><?php echo $this->_tpl_vars['form']['button']['close']['html']; ?>
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
