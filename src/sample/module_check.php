<?php
//�������ե�����Υ��ƥå׿��򥫥���Ȥ���
$h_dir[0]   = "head";
$h_dir[1]   = "franchise";

$d_dir[0]   = "/dialog";
$d_dir[1]   = "/system";
$d_dir[2]   = "/sale";
$d_dir[3]   = "/buy";
$d_dir[4]   = "/stock";
$d_dir[5]   = "/renew";
$d_dir[6]   = "/analysis";

//�ǡ����ο�
$d_color = array(
    "#99CCFF",
    "#CC99FF",
    "#FF99CC",
    "#CCFFFF",
    "#FFCC99",
    "#CCFFCC",
    "#C0C0C0"
);

//�إå��ο�
$h_color = array(
    "#3366FF",
    "#800080",
    "#FF0000",
    "#33CCCC",
    "#FF9900",
    "#339966",
    "#333333"
);

//��פο�
$t_color = array(
    "#00CCFF",
    "#993366",
    "#FF00FF",
    "#00FFFF",
    "#FFCC00",
    "#00FF00",
    "#969696"
);

//�����
$big_subject[0] = "0-1<br>����¾";
$big_subject[1] = "0-2<br>�̥�����ɥ�";
$big_subject[2] = "1-1<br>�ޥ���<br>����";
$big_subject[3] = "1-2<br>�ޥ���<br>����";
$big_subject[4] = "1-3<br>�����ƥ�<br>����";
$big_subject[5] = "1-4<br>Ģɼ<br>����";
$big_subject[6] = "2-1<br>����<br>���";
$big_subject[7] = "2-2<br>���<br>���";
$big_subject[8] = "2-3<br>����<br>����";
$big_subject[9] = "2-4<br>����<br>����";
$big_subject[10] = "2-5<br>����<br>����";
$big_subject[11] = "3-1<br>ȯ��<br>���";
$big_subject[12] = "3-2<br>����<br>���";
$big_subject[13] = "3-3<br>��ʧ<br>����";
$big_subject[14] = "3-4<br>����<br>����";
$big_subject[15] = "4-1<br>�߸�<br>���";
$big_subject[16] = "4-2<br>ê��<br>����";
$big_subject[17] = "5-1<br>����<br>����";
$big_subject[18] = "6-1<br>����<br>����";
$big_subject[19] = "6-2<br>����<br>����<br>������";
$big_subject[20] = "6-3<br>CSV<br>����";

//��˥塼���Ȥ�����ܿ�
$big_sub_num = array(2,4,5,4,2,1,3);


//ɽ���������
$h_subject = array(
    "0����������",
    "1���ޥ���",
    "2��������",
    "3����������",
    "4���߸˴���",
    "5������������",
    "6���ǡ�������"
);

//FC�ξ��
if($_GET["flg"] == '2'){
    $h_dir= $h_dir[1];
    $flg = '1';
    $send = "�����⥸�塼�������";
    $color= "#329932";
    $subject = "�ƣå⥸�塼�����";

    $PDF[1] = array(
        "2-1-102",
        "2-1-110",
        "2-1-124",
    ); 

    $PDF[2] = array(
        "2-2-103",
        "2-2-115",
        "2-2-110",
        "2-2-112",
        "2-2-114",
        "2-2-205",
        "2-2-208",
        "2-2-210",
        "2-2-213",
        "2-2-303",
        "2-2-305",
        "2-2-406",
        "2-2-502",
        "2-2-504",
    );

    $PDF[3] = array(
        "2-3-105",
        "2-3-107",
        "2-3-203",
        "2-3-306",
        "2-3-402",
        "2-3-404",
    );

    $PDF[4] = array(
        "2-4-102",
        "2-4-106",
        "2-4-110",
        "2-4-112",
        "2-4-202",
        "2-4-207",
        "2-4-209",
    );

    $PDF[5] = array(
        "2-5-106",
        "2-5-108",
    );

    $PDF[6] = array(
        "2-6-136",
        "2-6-138",
        "2-6-144",
        "2-6-152",
    );
        
//�����ξ��
}else{
    $h_dir = $h_dir[0];
    $flg = '2';
    $send = "�ƣå⥸�塼�������";
    $subject = "�����⥸�塼�����";
    $color = "#245EDC";
//    //rowspan
//    $row_span = array(4,10,21,26,5,5,9,6,6,5,4,7,4,5,4,13,8,9,23,5,3);


    $PDF[1] = array(
        "1-1-102",
        "1-1-110",
        "1-1-114",
        "1-1-111",
        "1-1-108",
        "1-1-124"
    );

    $PDF[2] = array(
        "1-2-109",
        "1-2-205",
        "1-2-206",
        "1-2-207",
        "1-2-303",
        "1-2-305",
        "1-2-406",
        "1-2-502",
        "1-2-504"
    );

    $PDF[3] = array(
        "1-3-105",
        "1-3-107",
        "1-3-203",
        "1-3-306",
        "1-3-402",
        "1-3-404"
    );

    $PDF[4] = array(
        "1-4-102",
        "1-4-106",
        "1-4-111",
        "1-4-113",
        "1-4-202",
        "1-4-207",
        "1-4-209"
    );

    $PDF[5] = array(
        "1-5-106",
        "1-5-108"
    );

    $PDF[6] = array(
        "1-6-134",
        "1-6-136",
        "1-6-144",
        "1-6-202"
    );
}

//�⥸�塼���������
$file_name = "./module_".$h_dir.".xls";

$file = fopen($file_name, "r");

//�ե�����򳫤�
while($file_data = fgets($file, "1000") ){
    $file_data = trim($file_data);

    $module = explode('-', $file_data);

    if(substr_count($file_data, '#') != 0){
        $file_data = str_replace('#','', $file_data);
        $uncount_flg = true;
    }
    
    //��������
    if($module[1] == '0'){
    $module_name[0][] = $file_data;

        if($uncount_flg != true){
            $m_name[0][0][] = "../".$h_dir.$d_dir[0]."/".$file_data.".php";
            $m_name[0][1][] = "../".$h_dir.$d_dir[0]."/templates/".$file_data.".php.tpl";
        }else{
            $m_name[0][0][] = "-";
            $m_name[0][1][] = "-";
        }
    //�ޥ�������
    }elseif($module[1] == '1'){
        $module_name[1][] = $file_data;

        if($uncount_flg != true){
            $m_name[1][0][] = "../".$h_dir.$d_dir[1]."/".$file_data.".php";

            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[1])){
                $m_name[1][1][] = "../".$h_dir.$d_dir[1]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[1][1][] = "-";
            }
        }else{
            $m_name[1][0][] = "-";
            $m_name[1][1][] = "-";
        }
    //������
    }elseif($module[1] == '2'){
        $module_name[2][] = $file_data;

        if($uncount_flg != true){
            $m_name[2][0][] = "../".$h_dir.$d_dir[2]."/".$file_data.".php";
            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[2])){
                $m_name[2][1][] = "../".$h_dir.$d_dir[2]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[2][1][] = "-";
            }
        }else{
            $m_name[2][0][] = "-";
            $m_name[2][1][] = "-";
        }

    //��������
    }elseif($module[1] == '3'){
        $module_name[3][] = $file_data;

        if($uncount_flg != true){
            $m_name[3][0][] = "../".$h_dir.$d_dir[3]."/".$file_data.".php";
            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[3])){
                $m_name[3][1][] = "../".$h_dir.$d_dir[3]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[3][1][] = "-";
            }
        }else{
            $m_name[3][0][] = "-";
            $m_name[3][1][] = "-";
        }

    //�߸˴���
    }elseif($module[1] == '4'){
        $module_name[4][] = $file_data;

        if($uncount_flg != true){
            $m_name[4][0][] = "../".$h_dir.$d_dir[4]."/".$file_data.".php";
            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[4])){
                $m_name[4][1][] = "../".$h_dir.$d_dir[4]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[4][1][] = "-";
            }
        }else{
            $m_name[4][0][] = "-";
            $m_name[4][1][] = "-";
        }

    //��������
    }elseif($module[1] == '5'){
        $module_name[5][] = $file_data;

        if($uncount_flg != true){
            $m_name[5][0][] = "../".$h_dir.$d_dir[5]."/".$file_data.".php";
            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[5])){
                $m_name[5][1][] = "../".$h_dir.$d_dir[5]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[5][1][] = "-";
            }
        }else{
            $m_name[5][0][] = "-";
            $m_name[5][1][] = "-";
        }

    //���׾���
    }elseif($module[1] == '6'){
        $module_name[6][] = $file_data;

        if($uncount_flg != true){
            $m_name[6][0][] = "../".$h_dir.$d_dir[6]."/".$file_data.".php";
            //Ģɼ����ʤ����
            if(!in_array($file_data, $PDF[6])){
                $m_name[6][1][] = "../".$h_dir.$d_dir[6]."/templates/".$file_data.".php.tpl";
            }else{
                $m_name[6][1][] = "-";
            }
        }else{
            $m_name[6][0][] = "-";
            $m_name[6][1][] = "-";
        }
    }
    $uncount_flg = null;
}

//�ե������̤˹Կ��򽸷�
for($i = 0; $i < 7; $i++){
    $file_count[$i] = count($m_name[$i][0]);
    for($s = 0; $s < 2; $s++){
        for($j = 0; $j < $file_count[$i]; $j++){

            if($m_name[$i][$s][$j] == "-"){
                $m_count[$i][$s][$j] = "<font color=\"blue\">-</font>";
            }else{
                //�Կ�����
                $result = shell_exec("wc -l ".$m_name[$i][$s][$j]."");
                $count = explode(' ', trim($result));

                //�ե����뤴�ȤΥ��ƥå׿��������
                if($count[0] != null){
                    $m_count[$i][$s][$j] = $count[0];
                //�ե����뤬¸�ߤ��ʤ����ϡ���å�����������
                }else{
                    $m_count[$i][$s][$j] = "<font color=\"red\">nothing</font>";
                    $nothing_flg = true;
                }

                //�ǥ��쥯�ȥ���ι�פ����
                if($s == 0){
                    $dir_lall[$i] = $dir_lall[$i] + $count[0];
                }else{
                    $dir_tall[$i] = $dir_tall[$i] + $count[0];
                }
            }
        }
    }
    $all_total = $all_total + $dir_lall[$i] + $dir_tall[$i];
}

?>
<html>
<head>
<title></title>
<body onload="myGetBrowser()" style="font-size:15">
<script language="JavaScript"><!--

myID = "myCursor";                  // DIV�������դ���ID
myX = 8;            // ����������ü���龯�����餹(X��ɸ)
myY = 16;           // ����������ü���龯�����餹(Y��ɸ)

function myGetBrowser(){            // �֥饦����Ƚ�Ǥ���
   myOP = (navigator.userAgent.indexOf("Opera",0) != -1)?1:0; //OP
   myN6 = document.getElementById;  // N6 or IE
   myIE = document.all;             // IE
   myN4 = document.layers;          // N4

   if (myIE){                    // IE?
      document.onmousemove = myMoveIE;
   }
}

function myMoveIE(){ // IE�ǥޥ�����ư����
  myObj=document.all[myID].style;
  myObj.left = myX + window.event.clientX + document.body.scrollLeft + "px";
  myObj.top  = myY + window.event.clientY + document.body.scrollTop + "px";
}
// --></script>

<div id="myCursor" style="position:absolute; z-index:1;">
<table border="1" cellpadding="6" cellspacing="0">
<tr>
<td bgcolor="<?php print $color;?>">
<font color="yellow">
<?php 
print $subject; 
?>
</font>
</td>
</tr>
</table>
</div>


<?php
$rs = 0;

print "<a href=\"./check.php\">�ܹԳ�ǧ�ġ���</a>";
print "<br>";
print "<br>";
print "<br>";
print "<a href=\"./module_check.php?flg=$flg\">$send</a>";
print "<br>";
if($nothing_flg == true){
    print "<br><b><font color=\"red\">Warning���⥸�塼������ˤϤ��뤬���ºݤˤ�¸�ߤ��ʤ��⥸�塼�뤬����ޤ���</font></b>";
}else{
    print "<br><b><font color=\"blue\">�⥸�塼������ˤ���⥸�塼�����������ޤ���</font></b>";
}
print "<br>";
print "<br>";
print "<span><b>��$subject</b></span>";
print "<br>";
print "<table border=\'1\' width=\"400\" style=\"border-style: solid; border-width: 2; border-color: #BBBBBB; border-collapse: collapse; \">";
print "    <tr bgcolor=\"#ACA899\">";
print "        <td width=\"100\">�⥸�塼��̾</td>";
print "        <td width=\"150\">Logic</td>";
print "        <td width=\"150\">Templates</td>";
print "    </tr>";
    for($i = 0; $i < 7; $i++){
        for($j = 0; $j < $file_count[$i]; $j++){
            print"<tr>\n";
            //�إå�ɽ��
            if($j == 0){
                    print"<td  bgcolor=\"$h_color[$i]\" colspan=\"3\"><b><a name=\"$i\" href=\"./module_check.php?flg=$flg#$i\" style=\"color : #FFFFFF\" title=\"$send\">".$h_subject[$i]."</b></a></td>\n";
                print"</tr>\n";
                print "<tr>\n";
                    print "<td  bgcolor=\"$d_color[$i]\">".$module_name[$i][$j]."</td>\n";
                if( ereg("[0-9]+", $m_count[$i][0][$j]) ){
                    print "<td align=\"right\">".number_format($m_count[$i][0][$j])."</td>\n";
                }elseif($m_count[$i][0][$j] == "<font color=\"blue\">-</font>"){
                    print "<td align=\"center\">".$m_count[$i][0][$j]."</td>\n";
                }else{
                    print "<td>".$m_count[$i][0][$j]."</td>\n";
                }

                if( ereg("[0-9]+", $m_count[$i][1][$j]) ){
                    print "<td align=\"right\">".number_format($m_count[$i][1][$j])."</td>\n";
                }elseif($m_count[$i][1][$j] == "<font color=\"blue\">-</font>"){
                    print "<td align=\"center\">".$m_count[$i][1][$j]."</td>\n";
                }else{
                    print "<td>".$m_count[$i][1][$j]."</td>\n";
                }
                    
                print"</tr>\n";
/*
            }elseif($j == 1 || $j == $row_span[$rs]){
                print "<td bgcolor=\"$d_color[$i]\" rowspan=\"$row_span[$rs]\">";
                print "<font color=\"white\">$big_subject[$rs]</td>";

                $rs = $rs + 1;
*/ 
            //���ɽ��
            }elseif($j == $file_count[$i]-1){
                    print"<td bgcolor=\"$t_color[$i]\" colspan=\"1\">�ǥ��쥯�ȥ��</td>";
                    print"<td bgcolor=\"$t_color[$i]\" align=\"right\">".number_format($dir_lall[$i])."</td>";
                    print"<td bgcolor=\"$t_color[$i]\" align=\"right\">".number_format($dir_tall[$i])."</td>";
                print"</tr>";
            //�ǡ���ɽ��
            }else{
                    print "<td  bgcolor=\"$d_color[$i]\">".$module_name[$i][$j]."</td>\n";
                if( ereg("[0-9]+", $m_count[$i][0][$j]) ){
                    print "<td align=\"right\">".number_format($m_count[$i][0][$j])."</td>\n";
                }elseif($m_count[$i][0][$j] == "<font color=\"blue\">-</font>"){
                    print "<td align=\"center\">".$m_count[$i][0][$j]."</td>\n";
                }else{
                    print "<td>".$m_count[$i][0][$j]."</td>\n";
                }

                if( ereg("[0-9]+", $m_count[$i][1][$j]) ){
                    print "<td align=\"right\">".number_format($m_count[$i][1][$j])."</td>\n";
                }elseif($m_count[$i][1][$j] == "<font color=\"blue\">-</font>"){
                    print "<td align=\"center\">".$m_count[$i][1][$j]."</td>\n";
                }else{
                    print "<td>".$m_count[$i][1][$j]."</td>\n";
                }
                    
                print"</tr>\n";
            }
        }
    }
print "     <tr bgcolor=\"#FF6600\">";
print "         <td>����</td>";
print "         <td colspan=\"2\" align=\"right\">".number_format($all_total)."</td>";
print "     </tr>";
print "</table>";
print "<a href=\"./module_check.php?flg=$flg\">$send</a>";
?>
</body>
</html>
