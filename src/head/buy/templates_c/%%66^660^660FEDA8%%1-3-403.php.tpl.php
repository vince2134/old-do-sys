<?php /* Smarty version 2.6.14, created on 2010-04-27 13:43:35
         compiled from 1-3-403.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


<body bgcolor="#D8D0C8">
<form <?php echo $this->_tpl_vars['form']['attributes']; ?>
>

<?php echo $this->_tpl_vars['form']['hidden']; ?>


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

 
<span style="color: #ff0000; font-weight: bold; line-height: 130%;">
<ul style="margin-left: 16px;">
<?php if ($this->_tpl_vars['form']['form_client']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_client']['error']; ?>
<br>
<?php endif; ?>
<?php if ($this->_tpl_vars['form']['form_count_day']['error'] != null): ?>
    <li><?php echo $this->_tpl_vars['form']['form_count_day']['error']; ?>
<br>
<?php endif; ?>
</ul>
</span>

<table>
    <tr>    
        <td>    


<table class="Data_Table" border="1" width="450">
<col width="100" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Pink"><?php echo $this->_tpl_vars['form']['form_client_link']['html']; ?>
<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_client']['html'];  echo $this->_tpl_vars['var']['rank']; ?>
</td>
    </tr>   
    <tr>    
        <td class="Title_Pink">集計期間<font color="#ff0000">※</font></td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_count_day']['html']; ?>
</td>
    </tr>   
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_output']['html']; ?>
</td>
    </tr>
</table>

<table width="400">
    <tr align="right">
        <td><?php echo $this->_tpl_vars['form']['form_show_button']['html']; ?>
　<?php echo $this->_tpl_vars['form']['form_clear_button']['html']; ?>
</td>
    </tr>   
</table>

        </td>   
        <td valign="top" style="padding-left: 20px;">

<br><br><br>
<table>
<col span="8" width="100" style="color: #525552;">
    <tr>    
        <td>21：掛仕入</td> 
        <td>23：掛返品</td> 
        <td>24：掛値引</td>
        <td>25：割賦仕入</td>
    </tr>
    <tr>
        <td>71：現金仕入</td>
        <td>73：現金返品</td>
        <td>74：現金値引</td>
        <td></td>
    </tr>
    <tr style="height: 0px;"><td colspan="4"></td></tr>
    <tr>
        <td>41：現金支払</td>
        <td>43：振込支払</td>
        <td>44：手形支払</td>
        <td>45：相殺</td>
    </tr>
    <tr>
        <td>46：支払調整</td>
        <td>47：その他支払</td>
        <td>48：手数料</td>
        <td>49：現金仕入</td>
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

<table>
    <tr>    
        <td colspan="2"><?php echo $this->_tpl_vars['html_1']; ?>
</td>
    </tr>   
    <tr>    
        <td valign="top"><?php echo $this->_tpl_vars['html_2']; ?>
</td>
    </tr> 
    <tr>
        <td colspan="2"><?php echo $this->_tpl_vars['var']['html_page'];  echo $this->_tpl_vars['html_3'];  echo $this->_tpl_vars['var']['html_page2']; ?>
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
