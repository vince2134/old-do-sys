<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/13      ban-0099    kaji        ���������
 *  2006/12/14      kaji-201    kaji        ̵���ι����ʤ�ɽ�����ʤ��褦��
 */



$page_title = "�����ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//�����ѿ�����
/****************************/
//$shop_gid = $_SESSION["client_id"];
$rank_cd = $_SESSION["rank_cd"];
$shop_id = $_SESSION["client_id"];
/****************************/
//�ե���������
/****************************/
//���Ϸ���
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup( $radio, "form_output_type", "���Ϸ���");

//�����ʥ�����
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""    );

//������̾
$form->addElement(
        "text","form_goods_name","",'size="34"
         '." $g_form_option"    );

//���ʥ�����
$form->addElement(
        "text","form_parts_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        ".$g_form_option."\""    );

//����̾
$form->addElement(
        "text","form_parts_goods_name","",'size="34"
         '." $g_form_option"    );
//�ܥ���
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement(
        "submit","form_show_button","ɽ����"    );
$form->addElement(
        "button","form_clear_button","���ꥢ",    "onClick=\"location.href='$_SERVER[PHP_SELF]'\"    ");
$form->addElement("submit","form_search_button","�����ե������ɽ��");

/****************************/
//�ǥե����������
/****************************/
$def_form= array(
    "form_output_type"   => "1",
    );
$form->setDefaults($def_form);

/****************************/
//POST����
/****************************/
if($_POST["form_show_button"] == "ɽ����"){
    $goods_cd           = $_POST["form_goods_cd"];          //�ƾ��ʥ�����
    $goods_name         = $_POST["form_goods_name"];        //�ƾ���̾
    $parts_goods_cd     = $_POST["form_parts_goods_cd"];    //�����ʥ�����
    $parts_goods_name   = $_POST["form_parts_goods_name"];  //������̾
    $output_type        = $_POST["form_output_type"];
}

/****************************/
//where_sql ����
/****************************/
if($goods_cd != null){
    $where_sql  = " AND t_goods.goods_cd LIKE '$goods_cd%'";
}

if($goods_name != null){
    $where_sql .= " AND t_goods.goods_name LIKE '%$goods_name%'";
}

/*
if($parts_goods_cd != null){
    $where_sql .= " AND t_com_goods.goods_cd LIKE '$parts_goods_cd%'";
}

if($parts_goods_name != null){
    $where_sql .= " AND t_com_goods.goods_name LIKE '%$parts_goods_name%'";
}
*/
if($parts_goods_cd != null || $parts_goods_name != null){
    $where_sql .= " AND t_compose.goods_id IN (SELECT\n";
    $where_sql .= "                                t_compose.goods_id\n";
    $where_sql .= "                            FROM\n";
    $where_sql .= "                                t_compose\n";
    $where_sql .= "                                    INNER JOIN\n";
    $where_sql .= "                                t_goods\n";
    $where_sql .= "                                ON t_compose.parts_goods_id = t_goods.goods_id\n";
    $where_sql .= "                            WHERE\n";
    $where_sql .= "                                public_flg = 't'\n";
    if($parts_goods_cd != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_cd LIKE '$parts_goods_cd%'\n";
    }
    if($parts_goods_name != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_name LIKE '%$parts_goods_name%'\n";
    }
    $where_sql .= "                            )\n";
/*    $where_sql .= " AND t_com_goods.goods_id IN (SELECT\n";
    $where_sql .= "                                 goods_id\n";
    $where_sql .= "                             FROM\n";
    $where_sql .= "                                 t_goods\n";
    $where_sql .= "                             WHERE\n";
    $where_sql .= "                                 public_flg = 't'\n";
    if($parts_goods_cd != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_cd LIKE '$parts_goods_cd%'\n";
    }
    if($parts_goods_name != null){
        $where_sql .= "                                 AND\n";
        $where_sql .= "                                 goods_name LIKE '%$parts_goods_name%'\n";
    }
    $where_sql .= "                             )\n";
*/
}

/****************************/
//SQL����
/****************************/
/*
$sql  = "SELECT\n";
$sql .= "    t_com_goods.goods_id,\n";
$sql .= "    t_com_goods.goods_cd,\n";
$sql .= "    t_com_goods.goods_name,\n";
$sql .= "    t_goods.goods_cd,\n";
$sql .= "    t_goods.goods_name,\n";
$sql .= "    t_compose.count\n";
$sql .= " FROM\n";
$sql .= "    t_goods,\n";
$sql .= "    t_goods AS t_com_goods,\n";
$sql .= "    t_compose\n";
$sql .= " WHERE\n";
$sql .= "    t_compose.parts_goods_id = t_goods.goods_id\n";
$sql .= "    AND\n";
$sql .= "    t_compose.goods_id = t_com_goods.goods_id\n";
$sql .= "    AND\n";
$sql .= "    t_com_goods.compose_flg = 't'\n";
$sql .= "    AND\n";
$sql .= "    t_com_goods.accept_flg = 1\n";
$sql .= "    AND\n";
$sql .= ($_SESSION[group_kind] == 2) ?"    t_com_goods.state IN (1,3)" : " t_com_goods.state = 1";
$sql .=      $where_sql;
$sql .= " ORDER BY t_com_goods.goods_cd, t_goods.goods_cd\n";
$sql .= ";\n";
*/

$sql  = "SELECT\n";
$sql .= "    t_goods.goods_id,\n";                  // 0 ������ID
$sql .= "    t_goods.goods_cd,\n";                  // 1 �����ʥ�����
$sql .= "    t_goods.goods_name,\n";                // 2 ������̾
$sql .= "    t_com_goods.goods_cd,\n";              // 3 ���ʥ�����
$sql .= "    t_com_goods.goods_name,\n";            // 4 ����̾
$sql .= "    t_compose.count,\n";                   // 5 ����
$sql .= "    t_price.r_price \n";                   // 6 ����ñ�����ղá���
if($output_type != null && $output_type != 1){
$sql .= ", \n";
$sql .= "    t_goods.goods_cname, \n";              // 7 ά�� 
$sql .= "    t_goods.unit, \n";                     // 8 ñ�� 
$sql .= "    CASE t_goods.tax_div \n";              // 9 ���Ƕ�ʬ 
$sql .= "       WHEN '1' THEN '����' \n";
$sql .= "       WHEN '3' THEN '�����' \n";
$sql .= "    END, \n";
$sql .= "    CASE t_goods.name_change \n";          // 10 ��̾�ѹ� 
$sql .= "       WHEN '1' THEN '�ѹ���' \n";
$sql .= "       WHEN '2' THEN '�ѹ��Բ�' \n";
$sql .= "    END, \n";
$sql .= "    t_price1.r_price AS price1, \n";        // 11 ɸ��ñ�� 
$sql .= "    t_price2.r_price AS price2, \n";       // 12 �Ķ�ñ��
$sql .= "    CASE t_goods.state \n";                // 13 ����
$sql .= "       WHEN '1' THEN 'ͭ��' \n";
$sql .= "       WHEN '2' THEN '̵��' \n";
$sql .= "       WHEN '3' THEN 'ͭ����ľ�ġ�' \n";
$sql .= "    END \n";
}
$sql .= "FROM\n";
$sql .= "    t_compose\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods\n";
$sql .= "    ON t_compose.goods_id = t_goods.goods_id\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods AS t_com_goods\n";
$sql .= "    ON t_compose.parts_goods_id = t_com_goods.goods_id\n";
$sql .= "       LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       goods_id,\n";
$sql .= "       r_price\n";
$sql .= "   FROM\n";
$sql .= "       t_price\n";
$sql .= "   WHERE\n";
$sql .= "       rank_cd = '$rank_cd'\n";
$sql .= "   ) AS t_price\n";
$sql .= "   ON t_com_goods.goods_id = t_price.goods_id \n";
if($output_type != null && $output_type != 1){
$sql .= "   LEFT JOIN (SELECT goods_id,r_price FROM t_price WHERE rank_cd = '4' ) AS t_price1 \n";
$sql .= "       ON t_price1.goods_id = t_com_goods.goods_id \n";
$sql .= "   LEFT JOIN (SELECT goods_id, r_price FROM t_price WHERE rank_cd = '2' AND ";
$sql .= ($_SESSION["group_kind"] == "2")?" shop_id IN (".Rank_Sql().") " : "shop_id = $shop_id";
$sql .= ") AS t_price2 \n";
$sql .= "       ON t_price2.goods_id = t_com_goods.goods_id \n";
}
$sql .= "WHERE\n";
$sql .= "    t_goods.accept_flg = '1'\n";
$sql .= "    AND\n";
if($_SESSION[group_kind] == 2){
    $sql .= "    t_com_goods.state IN (1, 3) \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods.state IN (1, 3) \n";
}else{
    $sql .= "    t_com_goods.state = 1 \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods.state = 1 \n";
}
$result = Db_Query($conn, $sql.";");
//print_array($sql);
$t_count = pg_num_rows($result);

$sql .=      $where_sql;
$sql .= "ORDER BY t_goods.goods_cd, t_com_goods.goods_cd\n";
$sql .= ";";


/******************************/
//�ǡ�������
/******************************/
$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
if($output_type == 1 || $output_type == null){
    $db_show_data = Get_Data($result, 1);
}else{
    $db_show_data = Get_Data($result, 2);
}

/*****************************/
//ñ����¸�ߤ��ʤ���ΤϺ��
/*****************************/
for($i = 0; $i < $total_count; $i++){
    if($db_show_data[$i][6] == null){
       $no_price[$i] = $db_show_data[$i][0]; 
    }
}

$j = 0;
for($i = 0; $i < $total_count; $i++){
    //if($no_price[$i] != $db_show_data[0]){
    if(@!in_array($db_show_data[$i][0], $no_price)){
        $show_data[$j] = $db_show_data[$i];
        $j++;
    }
}

$total_count = count($show_data);

if($output_type == 1 || $output_type == null){
    /****************************/
    //ɽ���ǡ�������
    /****************************/
    for($i = 0, $list_count = 0; $i < $total_count; $i++){
        for($j = 0; $j < $total_count; $j++){
            if($i != $j && $show_data[$i][0] == $show_data[$j][0]){
                $show_data[$j][0] = null;
                $show_data[$j][1] = null;
                $show_data[$j][2] = null;
            }
        }

        if($show_data[$i][0] != null){
            $list_count++;
        }
    }


    for($i = 0; $i < $total_count; $i++){
        if($i == 0){
            $tr[$i] = "Result1";
        }elseif($show_data[$i][0] == null){
            $tr[$i] = $tr[$i-1];
        }else{
            if($tr[$i-1] == "Result1"){
                $tr[$i] = "Result2";
            }else{
                $tr[$i] = "Result1";
            }
        }
    }
}else{
    $cnt = 0;
    $huka = 0;
    $kakaku = 0;
    $eigyo = 0;

    for($i = 0; $i < $t_count; $i++){
        if($i < (count($show_data)-1) && $show_data[$i][0] == $show_data[$i+1][0]&&$cnt < 1){
            $huka = bcmul($show_data[$i][6],$show_data[$i][5],2);
            $kakaku = bcmul($show_data[$i][11],$show_data[$i][5],2);
            $eigyo = bcmul($show_data[$i][12],$show_data[$i][5],2);
            $cnt = 0;
            for($k=$i+1;$show_data[$i][0] == $show_data[$k][0];$k++){
                $huka = bcadd(bcmul($show_data[$k][6],$show_data[$k][5],2),$huka,2);
                $kakaku = bcadd(bcmul($show_data[$k][11],$show_data[$k][5],2),$kakaku,2);
                $eigyo = bcadd(bcmul($show_data[$k][12],$show_data[$k][5],2),$eigyo,2);
                $cnt++;
            }
        }
        $csv_data[$i][0] = $show_data[$i][13];      //����
        $csv_data[$i][1] = $show_data[$i][1];       //�����ʥ�����
        $csv_data[$i][2] = $show_data[$i][2];       //������̾
        $csv_data[$i][3] = $show_data[$i][7];       //ά��
        $csv_data[$i][4] = $show_data[$i][8];       //ñ��
        $csv_data[$i][5] = $show_data[$i][9];       //���Ƕ�ʬ
        $csv_data[$i][6] = $show_data[$i][10];      //��̾�ѹ�
        $csv_data[$i][7] = $huka;                   //����ñ��
        $csv_data[$i][8] = $kakaku;                 //ɸ�����
        $csv_data[$i][9] = $eigyo;                  //�Ķ�ñ��
        $csv_data[$i][10] = $show_data[$i][3];      //���ʥ�����
        $csv_data[$i][11] = $show_data[$i][4];      //����̾
        $csv_data[$i][12] = $show_data[$i][6];      //����ñ��
        $csv_data[$i][13] = $show_data[$i][5];      //����
        $csv_data[$i][14] = bcmul($show_data[$i][6],$show_data[$i][5],2);//�������
        $cnt--;
    }
    $csv_file_name = "�����ʥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "����",
        "�����ʥ�����",
        "������̾",
        "ά��",
        "ñ��",
        "���Ƕ�ʬ",
        "��̾�ѹ�",
        "����ñ��",
        "ɸ�����",
        "�Ķ�ñ��",
        "���ʥ�����",
        "����̾",
        "����ñ��",
        "����",
        "�������",
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC"); 
    $csv_data = Make_Csv($csv_data, $csv_header);
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
//$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
/*
$sql  = "SELECT";
$sql .= "   count(t_compose.goods_id)";
$sql .= " FROM";
$sql .= "   (select goods_id from t_compose GROUP BY goods_id) AS t_compose";
$sql .= ";";
$result = Db_Query($conn, $sql);
$t_count = pg_fetch_result($result,0,0);
*/
$page_title .= "(��".$list_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
	"search_num"    => "$list_count",
));

$smarty->assign('show_data', $show_data);
$smarty->assign('tr', $tr);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
