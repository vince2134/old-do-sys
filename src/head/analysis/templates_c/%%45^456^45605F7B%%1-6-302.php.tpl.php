<?php /* Smarty version 2.6.14, created on 2007-02-22 20:32:12
         compiled from 1-6-302.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form name="dateForm" method="post">

<table width="100%" height="90%" class="M_Table">

        <tr align="center" height="60">
        <td width="100%" colspan="2" valign="top"><?php echo $this->_tpl_vars['var']['page_header']; ?>
</td>
    </tr>
    
        <tr align="center" valign="top">
        <td>
            <table>
                <tr>
                    <td>



<table width="300">
    <td>
        <tr>

<table class="List_Table" border="1" width="100%">
<col style="font-weight: bold;">
<col align="center">
    <tr style="font-weight: bold;">
        <td class="Title_Gray" align="center">実績データ一覧</td>
        <td class="Title_Gray">CSV出力</td>
    </tr>
    <tr class="Result3">
        <td>売上推移</td>
        <td class="Value"></td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">FC別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh26']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh27']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">サービス別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh28']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">担当者別/商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh30']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">地区別/商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh31']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">業種別/FC別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh32']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">業種別/商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh33']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td>ABC分析</td>
        <td class="Value"></td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">FC別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh34']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">FC別/商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh35']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td>仕入推移</td>
        <td class="Value"></td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">仕入先別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh36']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td bgcolor="#EBEBEB" style="padding-left: 40px;">仕入先別/商品別</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh37']['html']; ?>
</td>
    </tr>
    <tr class="Result3">
        <td>契約営業成績</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['button']['csvh38']['html']; ?>
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
