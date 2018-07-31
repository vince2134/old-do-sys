<?php
$page_title = "������Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

//��Ͽ�ܥ���
$form->addElement("submit","form_insert","�С�Ͽ");

/****************************/
//������׻�����
/****************************/
$client_h_id = $_SESSION["client_id"];  //������桼��ID
$cal_array = Cal_range($db_con,$client_h_id);

$start_day = $cal_array[0];   //�оݳ��ϴ���
$end_day = $cal_array[1];     //�оݽ�λ����
$cal_peri = $cal_array[2];    //��������ɽ������
print $end_day."<br>";
/****************************/
//�������ID��������
/****************************/
if($_POST["form_insert"] == "�С�Ͽ"){
	$sql  = "SELECT DISTINCT ";
	$sql .= "    client_id ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "ORDER BY ";
	$sql .= "    client_id ";
	$sql .= "LIMIT 300 OFFSET 0;";  
	//$sql .= "LIMIT 300 OFFSET 300;"; 
	//$sql .= "LIMIT 300 OFFSET 600;";   
	//$sql .= "LIMIT 300 OFFSET 900;"; 
	//$sql .= "LIMIT 300 OFFSET 1200;";  
	//$sql .= "LIMIT 300 OFFSET 1500;";  
	//$sql .= "LIMIT 300 OFFSET 1800;";
	//$sql .= "LIMIT 300 OFFSET 2100;";  
	 
	$result = Db_Query($db_con, $sql); 

	Db_Query($db_con, "BEGIN;");
	Db_Query($db_con, "LOCK TABLE t_aorder_h IN EXCLUSIVE MODE;");
	$i = 0;
	while($client_list = pg_fetch_array($result)){
		/****************************/
		//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
		/****************************/
		Aorder_Query($db_con,$client_h_id,$client_list[0],$start_day,$end_day);

		//�ե�����˥�������(������ID)
		$fp = fopen("update_log.txt","a");
		fputs($fp,$client_list[0]."\n");
		fclose($fp);
		
		$i++;
	}
	Db_Query($db_con, "COMMIT;");

	print $sql;
}

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'     => "$html_header",
	'html_footer'     => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
