<?php
//�����ȥ�
$page_title = "DB��Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once("file.fnc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect("amenity");

extract($_POST);


//������***********************************/
$l_up_dir = "tmp/"; //������¦�Ǥ���¸��
/******************************************/

if($_POST[submit] == "�С�Ͽ"){

    // �ե����륢�åץ���
    $File_Upload = File_Upload("l_file", $l_up_dir, "$l_file_name");

		//���åץ��ɤ��줿�ե������EUC-JP���Ѵ�
//		File_Mb_Convert("$l_up_dir"."$l_file_name");


    if(!$File_Upload)exit;

    //�ơ��֥��field�������
    $sql         = "SELECT * from $l_db_tname where false;";
    $result      = pg_query($sql);
    $field_count = pg_num_fields($result);

    $fp = fopen("$l_up_dir"."$l_file_name","r");
    if($field_count == 0 ){
        echo "�ơ��֥�������0�Ǥ�";
        exit;
    }

    //�ԥ롼��
    $j = 1;
    while($insert_data = fgetcsv($fp, "1000", "$l_ifs") ){
/*
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = trim(pg_escape_string($insert_data[$i]));
        }
*/            
        print"�Ѵ���:";
        print_r($insert_data);
        print"<br>";

/*
 // CP51932 -> eucJP-win �Ѵ��ؿ�
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = cp51932_to_eucjpwin($insert_data[$i]);
        }

        print"�Ѵ��塧";
        print_r($insert_data);
        print"<br>";
*/
/*

        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = mb_convert_encoding_ow($insert_data[$i],"cp51932");
        }
        print_r($insert_data);
        print"<br>";

*/
/*
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = mb_convert_encoding($insert_data[$i],"UTF-8","SJIS");
            $insert_data[$i] = mb_convert_encoding($insert_data[$i],"EUC","UTF-8");
        }
        print_r($insert_data);
        print"<br>";
*/

// CP51932 -> eucJP-win �Ѵ��ؿ�
        for($i = 0; $i < count($insert_data); $i++){
            $insert_data[$i] = mb_convert_encoding($insert_data[$i],"UTF8","SJIS");
          //  $insert_data[$i] = eucjpwin_to_cp51932($insert_data[$i]);
          //  $insert_data[$i] = cp51932_to_eucjpwin($insert_data[$i]);
        }
        print_r($insert_data);
        print"<br>";

    }
    

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
