<?php

//�������ե�����Υ��ƥå׿��򥫥���Ȥ���

$h_dir[0]   = "../head";
$h_dir[1]   = "../franchise";

$d_dir[0]   = "/analysis";
$d_dir[1]   = "/buy";
$d_dir[2]   = "/dialog";
$d_dir[3]   = "/renew";
$d_dir[4]   = "/stock";
$d_dir[5]   = "/system";
$d_dir[6]   = "/sale";

$d_name[0]  = "�ǡ�������";
$d_name[1]  = "��������";
$d_name[2]  = "��������";
$d_name[3]  = "��������";
$d_name[4]  = "�߸˴���";
$d_name[5]  = "�ޥ�������";
$d_name[6]  = "������";

/*
print "<font color=red>";
print "���ʲ��ϥ�����Ȥ��ʤ���";
print "<br></font>";

print "�������λ��������Υ��å�<br>";
print "��������FC�Υǡ������ϤΥ��å�<br>";
print "��������FC�ι��������Υ��å�<br>";
print "���ƣä��������Υ��å�<br>";
*/
print "<hr>";

//2��롼�ס�������FC��
for($s = 0; $s < 2; $s++){
    if($s == 0){
        print "������<br>";
    }else{
        print "��FC<br>";
    }
    //5��롼�סʳƥǥ��쥯�ȥ�ʬ��
    for($i = 0; $i < 7; $i++){

        print "<hr>";
        print "��".$d_name[$i]."<br><br>";

        //2��롼�סʥ��å����ƥ�ץ졼�ȡ�
        for($h = 0; $h < 2; $h++){

            //�оݤȤʤ�ǥ��쥯�ȥ�
            //���å�
            if($h == 0){
                $target_dir = $h_dir[$s].$d_dir[$i];
            //�ƥ�ץ졼��
            }elseif($h == 1){
                $target_dir = $h_dir[$s].$d_dir[$i]."/templates";
            }

            print "<b>".$target_dir."</b><br>";
//------------------------------------------------------------------------
//������Ȥ��ʤ����
//-------------------------------------------------------------------------
/*
            //�����λ��������Υ��å���̤���Τ��ᥫ����Ȥ��ʤ���
            if($s == 0 && $i == 1){ 
                print "̤����<br><br>";
                continue;

            //������FC�Ȥ�ˡ��ǡ������ϤΥ��å���̤���Τ��ᥫ����Ȥ��ʤ���
            }elseif($i == 0){
                print "̤����<br><br>";
                continue;

            //������FC�Ȥ�ˡ����������Υ��å���̤���Τ��ᤫ����Ȥ��ʤ���
            }elseif($i == 3){
                print "̤����<br><br>";
                continue;

            //FC���������Υ��å���̤���Τ��ᥫ����Ȥ��ʤ���
            }elseif($s == 1 && $i == 6){
                print "̤����<br><br>";
                continue;
            }

*/
//-------------------------------------------------------------------------

            $file = scandir($target_dir);

            //�ǥ��쥯�ȥ����¸�ߤ���ե��������롼��
            for($j = 0; $j < count($file); $j++){
                $file[$j] = trim($file[$j]);

                //�ǥ��쥯�ȥ�ξ��ϥ�����Ȥ��ʤ�
                $target_file = $target_dir."/".$file[$j];
                if(!is_dir($target_file)){
                    //���ƥå׿������
                    $line = shell_exec("wc -l $target_file");
                    $count_data = explode(' ', trim($line));
                    $count[] = $count_data[0];
                    print $file[$j]."������".$count_data[0]."<br>";
                }
            }
            //�ǥ��쥯�ȥ���Υ��ƥå׿����
            $total_count[$i][$h] = @array_sum($count);
            print "��ס�".$total_count[$i][$h];

            //�ǡ����ǥ��쥯�ȥ���Υ��ƥå׿����
            $dir_count[$i] = $total_count[$i][0] + $total_count[$i][1];

            $count = null;
            print "<br><br>";
        }
        //�إå��ǥ��쥯�ȥ���Υ��ƥå׿����
        $total_dir_count[$s] = @array_sum($dir_count);
    }

    print "<hr size=10 color=red>";
}
print "������� �� ".$total_dir_count[0];
print "<br>";
print "FC��� �� ".$total_dir_count[1];
print "<br>";
print "���� �� ".array_sum($total_dir_count);

?>
