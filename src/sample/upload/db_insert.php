<?php
require "../../function/db_con.php";
$fp = fopen ("csv/KEN_ALL.CSV","r");
$count_diff = 0;//��Ͽ�ǡ�����
$count_same = 0;//��Ͽ�����ǡ�����
//CSV�Υǡ�����whileʸ
while($data = fgets($fp, 10000)) {
	//CSV�ǡ���������������
	for ($i = 0; $i < count($data); $i++) {
		list($csv[0],$csv[1],$csv[2],$csv[3],$csv[4],$csv[5],$csv[6],$csv[7],$csv[8]) = explode(",",$data); 
		
		//���󥳡��ǥ��󥰤���
		for ($i = 0; $i < 9; $i++) {
			$csv[$i] = trim($csv[$i],"\"");
			$csv[$i] = mb_convert_encoding($csv[$i],'EUC-JP','SJIS');
		}
		//�ǽ�˽ФƤ��뎢�ʎ�,��(���ΰ��֤�Ĵ�٤�
		$strpos1 = mb_strpos($csv[5],'(');
		$strpos2 = mb_strpos($csv[8],'��');
		//��(��������ʸ�����ȴ���Ф�
		if($strpos1!=false){
			$csv[5] = mb_substr($csv[5],0,$strpos1);
			$csv[5] = mb_substr($csv[5],0,54);
		}
		//���ʎ�������ʸ�����ȴ���Ф�
		if($strpos2!=false){
			$csv[8] = mb_substr($csv[8],0,$strpos2);
			$csv[8] = mb_substr($csv[8],0,14);
		}
	}
	$post_no = 0;//��ʣ����͹���ֹ�
	//��ʣ����͹���ֹ椬�ʤ��������å�
    $select_sql = "SELECT post_no FROM t_post_no WHERE post_no = '".$csv[2]."';";
    $result1 = pg_query($connect,$select_sql);
    if($result1==false){
        print "SQL���¹ԤǤ��ޤ���";
        exit;
    }else{
        $post_no = pg_num_rows($result1);
    }
	//��ʣ����͹���ֹ椬�ʤ��ä���DB����Ͽ
    if($post_no==0){
		//���ʲ��˷Ǻܤ��ʤ���玣�������Ǝ����������ގŎ��ʎގ���������Ͽ���ʤ�
		if($csv[5] == "�����˥����������ʥ��Х���"){
				$data_sql = "insert into t_post_no values('".$csv[2]."','".$csv[3].$csv[4]."','".$csv[6].$csv[7]."','');";
		}else{
				$data_sql = "insert into t_post_no values('".$csv[2]."','".$csv[3].$csv[4].$csv[5]."','".$csv[6].$csv[7]."','".$csv[8]."');";
		}
		$result = pg_query($connect,$data_sql);
		if($result == false)
		{
			print "SQL���¹ԤǤ��ޤ���";
			print $data_sql;
			print $csv[2][1];
		    exit;
		}
		$count_diff = $count_diff +1;
	//��ʣ����͹���ֹ椬���ä��饫����Ȥ���
	}else{
		$count_same = $count_same +1;
	}
}
print "��Ͽ��λ<br>";
print "��Ͽ�����ǡ�������".$count_diff."�Ǥ���<br>";
print "��Ͽ���ʤ��ä��ǡ�������".$count_same."�Ǥ���<br>";
print "��������������������������������";
print "<input type=\"submit\" value=\"�Ĥ���\" onClick=\"javascript:window.close()\">";
fclose ($fp);
?>