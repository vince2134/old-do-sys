<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/18                  kajioka-h   �֣Ͷ�ʬ�ע�����ʬ��פ�ɽ���ѹ�
 */

$page_title = "�ȼ�ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//�����ѿ�����
/****************************/
$get_btype_id = $_GET["btype_id"];

/*****************************/
//���֥������Ⱥ���
/*****************************/
//�ܥ���
//CSV�ܥ���
$form->addElement(
        "submit","form_csv_button","CSV����"
        );

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_lbtype.note,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name,";
$sql .= "   t_sbtype.note";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       lbtype_id,";
$sql .= "       lbtype_cd,";
$sql .= "       lbtype_name,";
$sql .= "       note";
$sql .= "   FROM";
$sql .= "       t_lbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_lbtype";
$sql .= "       LEFT JOIN";
$sql .= "   (SELECT";
$sql .= "       sbtype_id,";
$sql .= "       lbtype_id,";
$sql .= "       sbtype_cd,";
$sql .= "       sbtype_name,";
$sql .= "       note";
$sql .= "   FROM";
$sql .= "       t_sbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_sbtype";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= "   ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

for($i = 0 ; $i < $total_count; $i++){
    for($j = 0 ; $j < $total_count; $j++){
        if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
            $page_data[$j][0] = "";
            $page_data[$j][1] = "";
            $page_data[$j][2] = "";
        }
    }
}

for($i = 0; $i < $total_count; $i++){
    if($page_data[$i][0] == null){        $tr[$i] = $tr[$i-1];
    }else{  
        if($tr[$i-1] == "Result1"){
            $tr[$i] = "Result2";
        }else{  
            $tr[$i] = "Result1";
        }       
    }
}


$sql  = "SELECT";
$sql .= "   COUNT(sbtype_id)";
$sql .= "FROM";
$sql .= "   t_sbtype";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_fetch_result($result,0,0);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["form_csv_button"] == "CSV����"){
	$sql  = "SELECT";
	$sql .= "   t_lbtype.lbtype_cd,";
	$sql .= "   t_lbtype.lbtype_name,";
	$sql .= "   t_lbtype.note,";
	$sql .= "   t_sbtype.sbtype_cd,";
	$sql .= "   t_sbtype.sbtype_name,";
	$sql .= "   t_sbtype.note";
	$sql .= " FROM";
    $sql .= "   (SELECT";
    $sql .= "       lbtype_id,";
    $sql .= "       lbtype_cd,";
    $sql .= "       lbtype_name,";
    $sql .= "       note";
    $sql .= "   FROM";
    $sql .= "       t_lbtype";
    $sql .= "   WHERE";
    $sql .= "       accept_flg = '1'";
    $sql .= "   ) AS t_lbtype";
	$sql .= "       LEFT JOIN";
    $sql .= "   (SELECT";
    $sql .= "       lbtype_id,";
    $sql .= "       sbtype_id,";
    $sql .= "       sbtype_cd,";
    $sql .= "       sbtype_name,";
    $sql .= "       note";
    $sql .= "   FROM";
    $sql .= "       t_sbtype";
    $sql .= "   WHERE";
    $sql .= "       accept_flg = '1'";
    $sql .= "   ) AS t_sbtype";
	$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
	$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
	$sql .= ";";

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $page_data = Get_Data($result);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][1];
        $csv_page_data[$i][2] = $page_data[$i][2];
        $csv_page_data[$i][3] = $page_data[$i][3];
        $csv_page_data[$i][4] = $page_data[$i][4];
        $csv_page_data[$i][5] = $page_data[$i][5];
    }

    $csv_file_name = "�ȼ�ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "��ʬ��ȼ拾����",
        "��ʬ��ȼ�̾",
        "��ʬ������",
        "��ʬ��ȼ拾����",
        "��ʬ��ȼ�̾",
        "��ʬ������",
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


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

$smarty->assign("page_data", $page_data);
$smarty->assign("tr", $tr);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
