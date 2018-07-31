<?php
require_once("ENV_local.php");

$sql  = "SELECT";
$sql .= "   goods_id,";
$sql .= "   goods_cd,";
$sql .= "   goods_name";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= " ORDER BY goods_id";
$sql .= ";";

//��4��5��������������
$con2 = Db_Connect("demo_0405");
$result = Db_Query($con2, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $cd_0405[pg_fetch_result($result,$i ,0 )] = (string)pg_fetch_result($result,$i ,1 );
    $name_0405[pg_fetch_result($result,$i ,0 )] = pg_fetch_result($result,$i ,2 );
}

$sql  = "SELECT";
$sql .= "   goods_id,";
$sql .= "   goods_cd,";
$sql .= "   goods_name";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= "   AND";
$sql .= "   compose_flg != 't'";
$sql .= " ORDER BY goods_id";
$sql .= ";";

//��5��23�����ߤ�������
$con3 = Db_Connect("amenity_demo_new");
$result = Db_Query($con3, $sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $id[] = pg_fetch_result($result, $i, 0);
    $cd_0523[pg_fetch_result($result, $i, 0)] = (string)pg_fetch_result($result,$i ,1 );
    $name_0523[pg_fetch_result($result, $i, 0)] = pg_fetch_result($result,$i ,2 );
}

//���ȭ��κ�ʬ��Ф�
for($i = 0; $i < $num; $i++){
    if($cd_0405[$id[$i]] == $cd_0523[$id[$i]]){
        $messe[$i] = "�ѹ��ʤ�";
    }elseif($cd_0405[$id[$i]] == null){
        $messe[$i] = "<font color=\"blue\">�����ɲ�</font>";
    }else{
        $messe[$i] = "<font color=\"red\">�ѹ�����</font>";
    }
}


?>

<html><head><title></title></head>
<body>
<?php
print "<table border=\"1\">";
print "     <tr>";
print "         <td align=\"center\" rowspan=\"2\">No.</td>";
print "         <td align=\"center\" rowspan=\"2\">����ID</td>";
print "         <td align=\"center\" colspan=\"2\">4��5������</td>";
print "         <td align=\"center\" colspan=\"2\">5��23������</td>";
print "         <td align=\"center\" rowspan=\"2\">���</td>";
print "     </tr>";
print "     <tr>";
print "         <td align=\"center\">���ʥ�����</td>";
print "         <td align=\"center\">����̾</td>";
print "         <td align=\"center\">���ʥ�����</td>";
print "         <td align=\"center\">����̾</td>";
print "     </tr>";
$row = 1;
for($i = 0; $i < $num; $i++){
    print " <tr>";
    print "     <td align=\"right\">".$row."</td>";
    print "     <td align=\"right\">".$id[$i]."</td>";
    if($cd_0405[$id[$i]] != null){
        print "     <td>'".$cd_0405[$id[$i]]."</td>";
        print "     <td>".$name_0405[$id[$i]]."</td>";
    }else{
        print "     <td><br></td>";
        print "     <td><br></td>";
    }
    print "     <td>'".$cd_0523[$id[$i]]."</td>";
    print "     <td>".$name_0523[$id[$i]]."</td>";
    print "     <td>".$messe[$i]."</td>";
    print " </tr>";

    $row = $row+1;
}

?>
    </table>
</body>
</html>

