<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("test_form", "POST");

//DB��³
$db_con = Db_Connect("amenity");


$form->addElement("submit","regist","�Ҹ���Ͽ");


//�ƥ���FC��ID
$id_list = array(
	21399,
	21402,
	21405,
	21408,
	21363,
	21372,
	21411,
	21414,
	21417,
	21420,
	21423,
	21426,
	21429,
	21432,
	21435,
	21438,
	21441,
	21444,
	21447,
	21450,
	21348,
	21345,
	21351,
	21354,
	21357,
	21360,
	21366,
	21369,
	21375,
	21378,
	21381,
	21384,
	21387,
	21393,
	21390,
	21396
);

if ($_POST[regist] == "�Ҹ���Ͽ") {
	Db_Query($db_con, "BEGIN;");

	foreach ($id_list AS $id) {
		$sql="
			INSERT INTO 
				t_ware( 
				ware_id, 
				ware_cd, 
				ware_name, 
				own_shop_id, 
				count_flg, 
				note, 
				shop_id, 
				nondisp_flg
			)VALUES( 
				(SELECT COALESCE(MAX(ware_id), 0)+1 FROM t_ware),
				'100', 
				'�ƥ����Ҹ�', 
				$id, 
				't', 
				'', 
				$id, 
				'f'
			); 
		";

		Db_Query($db_con, $sql);
		$result_mess .= "$sql"."<br>"; 
	}
	//Db_Query($db_con, "ROLLBACK;");
	Db_Query($db_con, "COMMIT;");
}


//HTMLɽ��
echo "�ƥ����Ҹˤ���Ͽ���ޤ���";
$form->display(); 
echo "<hr>";
echo "$result_mess";

?>
