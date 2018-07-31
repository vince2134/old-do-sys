<?php /* Smarty version 2.6.14, created on 2007-03-27 15:17:08
         compiled from 1-1-116.php.tpl */ ?>
<?php echo $this->_tpl_vars['var']['html_header']; ?>


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
<col width="130" style="font-weight: bold;">
<col>
    <tr>
        <td class="Title_Purple">出力形式</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_r_output2']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップコード</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_shop']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">ショップ名・略称</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_text15']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">FC・取引先区分</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_rank_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">地区</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['form_area_1']['html']; ?>
</td>
    </tr>
    <tr>
        <td class="Title_Purple">状態</td>
        <td class="Value"><?php echo $this->_tpl_vars['form']['f_radio34']['html']; ?>
</td>
    </tr>
</table>

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

全<b><?php echo $this->_tpl_vars['var']['total_count']; ?>
</b>件
<table class="List_Table" border="1" width="100%">
    <tr align="center" style="font-weight: bold;">
        <td class="Title_Purple">No.</td>
        <td class="Title_Purple">ショップ名</td>
        <td class="Title_Purple">FC・取引先区分</td>
        <td class="Title_Purple">地区</td>
        <td class="Title_Purple">状態</td>
    </tr>
        <tr class="Result1">
        <td align="right">1</td>
        <td>000000-0001</a><br><a href="1-1-123.php">アメニティ東陽</a></td>
        <td align="center">直営</td>
        <td align="center">地区A</td>
        <td align="center">取引中</td>
    </tr>
        <tr class="Result1">
        <td align="right">2</td>
        <td>000000-0002</a><br><a href="1-1-123.php">アメニティ茨城</a></td>
        <td align="center">加盟店</td>
        <td align="center">地区B</td>
        <td align="center">取引中</td>
    </tr>   
        <tr class="Result1">
        <td align="right">3</td>
        <td>000000-0003</a><br><a href="1-1-123.php">サニクリーン宇都宮</a></td>
        <td align="center">加盟店</td>
        <td align="center">地区C</td>
        <td align="center">取引中</td>
    </tr>
        <tr class="Result1">
        <td align="right">4</td>
        <td>000000-0004</a><br><a href="1-1-123.php">アメニティ北関東</a></td>
        <td align="center">加盟店</td>
        <td align="center">地区D</td>
        <td align="center">取引中</td>
    </tr>
        <tr class="Result1">
        <td align="right">5</td>
        <td>000000-0005</a><br><a href="1-1-123.php">日本クリーンアップ</a></td>
        <td align="center">協力店</td>
        <td align="center">地区E</td>
        <td align="center">取引中</td>
    </tr>
        <tr class="Result1">
        <td align="right">6</td>
        <td>000001-0000</a><br><a href="1-1-123.php">得意先Ｚ</a></td>
        <td align="center">得意先</td>
        <td align="center">地区F</td>
        <td align="center">取引中</td>
    </tr>
        <tr class="Result1">
        <td align="right">7</td>
        <td>000002-0000</a><br><a href="1-1-123.php">アメニティリース</a></td>
        <td align="center">加盟店</td>
        <td align="center">地区G</td>
        <td align="center">取引中</td>
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
