<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

extract($_POST);


//������***********************************/
$l_up_dir = "tmp/"; //������¦�Ǥ���¸��
/******************************************/

if($_POST[submit] == "�С�Ͽ"){

        // �ե����륢�åץ���
        $File_Upload = File_Upload("l_file", $l_up_dir, "$l_file_name");

		//���åץ��ɤ��줿�ե������EUC-JP���Ѵ�
		File_Mb_Convert("$l_up_dir"."$l_file_name");


        if(!$File_Upload)exit;

        //�ơ��֥��field�������
        pg_query("BEGIN;");
        $sql         = "SELECT * from $l_db_tname where false;";
        $result      = pg_query($sql);
        $field_count = pg_num_fields($result);


        //
        $fp = fopen("$l_up_dir"."$l_file_name","r");
        if($field_count == 0 ){
                echo "�ơ��֥�������0�Ǥ�";
                exit;
        }

        //����ǡ�������
        if($_POST["l_db_tname"] == "t_g_goods" || $_POST["l_db_tname"] == "t_product"){
            $colum  = ",''";
            $colum .= ",'t'";
            $colum .= ",1";
            $field_count = 2;
        }


        //�ԥ롼��
            $j=1;
        while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
                $sql  = "INSERT INTO $l_db_tname $column_name";
                $sql .= "VALUES ( ".$j.",";

                for ($i=0; $i<$field_count; $i++){
                #for ($i=0; $i<11; $i++){

                    //���ܤ��ɲä���
                    if($i != 0){
                            $sql .= ",";
                    }
                    
                    //��Ͽ�ǡ������ɲ�
					if ($insert_data[$i] != ""){
						$insert_data[$i] = pg_escape_string ($insert_data[$i]);
                		$sql .= "'$insert_data[$i]'";

					//�ǡ�����̵������NULL����Ͽ
					}
                   /* else{
						$sql .= "NULL";
					}*/

                }

                $sql .= $colum.");";
                echo "$sql"."<br>";
                $result      = pg_query($sql);

            $j=$j+1;
        }
    pg_query("COMMIT;");
}


//�����
$def_data = array(
    "l_db_name"   => "amenity",
    "l_db_tname"  => "t_parts",
    "l_file_name" => "test.txt",
    "l_ifs"       => ",",
);
$form->setDefaults($def_data);


//�ե��������
$sql = "SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY schemaname;";
$result = Db_Query($db_con,$sql);
$num = pg_num_rows($result);
for($i = 0; $i < $num; $i++){
    $select_a[pg_fetch_result($result, $i,0)] = pg_fetch_result($result, $i , 0);
}
$form->addElement("text","l_file_name","��¸�ե�����̾");
$form->addElement("text","l_db_name","DB̾");
$form->addElement("select","l_db_tname","�ơ��֥�̾",$select_a);
$form->addElement("file","l_file","CSV�ե�����");
$form->addElement("text","l_ifs","���ڤ�ʸ��");
$form->addElement("submit","submit","�С�Ͽ");

$form->display();

?>
