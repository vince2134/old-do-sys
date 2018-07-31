<?php /* Smarty version 2.6.9, created on 2006-09-12 16:04:03
         compiled from 1-1-106.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

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

 
<?php if ($this->_tpl_vars['var']['auth_r_msg'] != null): ?>
    <span style="color: #ff0000; font-weight: bold; line-height: 130%;">
    <li><?php echo $this->_tpl_vars['var']['auth_r_msg']; ?>
</li>
    </span><br>
<?php endif; ?>

<table width="450">
    <tr>    
        <td> 

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col width="60" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" colspan="2">Á°²óÀÁµá³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple" rowspan="4">º£²óÀÁµá³Û</td>
        <td class="Title_Purple">Æþ¶â³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">Ä´À°³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">Çä¾å³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">¾ÃÈñÀÇ</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>
    </tr>
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="153" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">Á°·îÇä³Ý»Ä</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">¸½ºßÇä³Ý»Ä</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>   
    </tr>   
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="90" style="font-weight: bold;">
<col width="60" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple" rowspan="7">Åö·î¼ÂÀÓ</td>
        <td class="Title_Purple">ÁíÇä¾å</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">ÊÖÉÊ³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">ÃÍ°ú³Û</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">½ãÇä¾å</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">¾ÃÈñÀÇ</td>
        <td class="Value"</td>
    </tr>
    <tr>
        <td class="Title_Purple">ÁÆÍø±×</td>
        <td class="Value"></td>
    </tr>
    <tr>
        <td class="Title_Purple">Æþ¶â³Û</td>
        <td class="Value"></td>
    </tr>
</table>

        </td>
    </tr>
</table>

                    </td>
                </tr>
                <tr>
                    <td>

<table width="100%">
    <tr>
        <td>

<table class="Data_Table" border="1" width="100%">
<col width="153" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">ºÇ¿·Çä¾åÆü</td>
        <td class="Value"></td>
    </tr>
</table>

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
