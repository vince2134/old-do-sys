<?php
$page_title = "�����ӥ��ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/******************************/
//CSV���ϥܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"]==true){
    /** CSV����SQL **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //�����ӥ�������
    $sql .= "serv_name,";              //�����ӥ�̾
	$sql .= "CASE tax_div ";           //���Ƕ�ʬ
	$sql .= "    WHEN '1' THEN '����'";
	$sql .= "    WHEN '2' THEN '����'";
	$sql .= "    WHEN '3' THEN '�����'";
    $sql .= "END,";
	$sql .= "note ";                   //����
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "OR ";
    $sql .= "public_flg = true ";
    $sql .= " AND";
    $sql .= " accept_flg = '1'";
    $sql .= "ORDER BY ";
    $sql .= "serv_cd;";

    $result = Db_Query($db_con,$sql);

    //CSV�ǡ�������
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //�����ӥ�������
        $serv_data[$i][0] = $data_list[0];
        //�����ӥ�̾
        $serv_data[$i][1] = $data_list[1];
        //���Ƕ�ʬ
        $serv_data[$i][2] = $data_list[2];
		//����
        $serv_data[$i][3] = $data_list[3];
        $i++;
    }

    //CSV�ե�����̾
    $csv_file_name = "�����ӥ��ޥ���".date("Ymd").".csv";
    //CSV�إå�����
    $csv_header = array(
        "�����ӥ�������", 
        "�����ӥ�̾",
		"���Ƕ�ʬ",
        "����"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($serv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;    
}

/****************************/
//�������
/****************************/
//CSV����
$form->addElement("button","csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

//CSV���ϥܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "csv_button_flg");

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** �����ӥ��ޥ�������SQL���� **/
$sql = "SELECT ";
$sql .= "serv_id,";                //�����ӥ�ID
$sql .= "serv_cd,";                //�����ӥ�������
$sql .= "serv_name,";              //�����ӥ�̾
$sql .= "CASE tax_div ";           //���Ƕ�ʬ
$sql .= "    WHEN '1' THEN '����'";
$sql .= "    WHEN '2' THEN '����'";
$sql .= "    WHEN '3' THEN '�����'";
$sql .= "END,";
$sql .= "note ";                   //����
$sql .= "FROM ";
$sql .= "t_serv ";
$sql .= "WHERE ";
$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$sql .= "OR ";
$sql .= "public_flg = true ";
$sql .= " AND";
$sql .= " accept_flg = '1'";
$sql .= "ORDER BY ";
$sql .= "serv_cd;";

$result = Db_Query($db_con,$sql);
//���������(�إå���)
$total_count = pg_num_rows($result);

//�ԥǡ������ʤ����
$row = Get_Data($result);

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'total_count'   => "$total_count",
));
$smarty->assign('row',$row);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
