<?php
/********************
 * ȯ���
 *
 *
 * �ѹ�����
 *   2006/07/06 (kaji)
 *     ��shop_gid��ʤ���
 *
 ********************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/11��06-065��������watanabe-k��GET���ͥ����å����ɲ�
 * ��2006/11/11��06-066��������watanabe-k��GET���ͥ����å����ɲ�
 * ��2006/11/11��06-068��������watanabe-k��GET���ͥ����å����ɲ�
 * ��2007/01/31��      ��������watanabe-k�������ֹ��ɽ������褦�˽���
 *
 */


//�Ķ�����ե�����
require_once("ENV_local.php");
require(FPDF_DIR);

// �ڡ��������ȥ�
$page_title = "ȯ������";

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);


/****************************/
//�����ѿ�����
/****************************/
$ord_id     = $_GET["ord_id"];
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
Get_Id_Check3($ord_id);

$format_flg = ($ord_id == null) ? true : false;


/****************************/
// ȯ���ȯ�ԺѤˤ���
/****************************/
if($format_flg != true){
    Db_Query($db_con, "BEGIN;");
    $sql    = "UPDATE t_order_h SET ord_sheet_flg = 't' WHERE ord_id = $ord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, $sql);
        exit;
    }
    Db_Query($db_con, "COMMIT;");
}

    /****************************/
    // ȯ��񥳥��ȥǡ�������
    /****************************/
    $sql    = "SELECT ";
    $sql   .= "   o_memo1_1, ";                     // ȯ��񥳥��ȡ�͹�أ���
    $sql   .= "   o_memo1_2, ";                     // ȯ��񥳥��ȡ�͹�أ���
    $sql   .= "   o_memo2, ";                       // ȯ��񥳥���2
    $sql   .= "   o_memo3, ";                       // ȯ��񥳥���3
    $sql   .= "   o_memo4, ";                       // ȯ��񥳥���4
    $sql   .= "   o_memo5, ";                       // ȯ��񥳥���5
    $sql   .= "   o_memo6, ";                       // ȯ��񥳥���6
    $sql   .= "   o_memo7, ";                       // ȯ��񥳥���7
    $sql   .= "   o_memo8, ";                       // ȯ��񥳥���8
    $sql   .= "   o_memo9, ";                       // ȯ��񥳥���9
    $sql   .= "   o_memo10, ";                      // ȯ��񥳥���10
    $sql   .= "   o_memo11, ";                      // ȯ��񥳥���11
    $sql   .= "   o_memo12 ";                       // ȯ��񥳥���12
    $sql   .= "FROM ";
    $sql   .= "   t_order_sheet ";
    $sql   .= "WHERE ";
//    $sql   .= "   shop_id = $shop_id ";
    $sql   .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql   .= ";";
    $res    = Db_Query($db_con, $sql);
    $o_memo = Get_Data($res, 2);

/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($format_flg != true){
    /****************************/
    // ���������������
    /****************************/
    $sql    = "SELECT ps_stat FROM t_order_h WHERE t_order_h.ord_id = $ord_id AND shop_id = $shop_id AND ord_stat IS NULL;";
    $res    = Db_Query($db_con, $sql);
    Get_Id_Check($res);
    $stat   = pg_fetch_result($res, 0, 0);

    /****************************/
    // ȯ���ʼ��ҡ˾������
    /****************************/
    // ����������ξ��
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   my_client_name, ";              // ȯ���ʼ��ҡ�̾
        $sql .= "   my_client_name2 ";              // ȯ���ʼ��ҡ�̾��
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // �����������ξ��
    }else{
        $sql  = "SELECT ";
        $sql .= "   shop_name, ";                   // ȯ���ʼ��ҡ�̾
        $sql .= "   shop_name2 ";                   // ȯ���ʼ��ҡ�̾��
        $sql .= "FROM ";
        $sql .= "   t_client ";
        $sql .= "WHERE ";
        $sql .= "   t_client.client_id = $_SESSION[client_id] ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $my_data = pg_fetch_array($res, 0);

    /****************************/
    // ȯ����������
    /****************************/
    // ����������ξ��
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   client_name, ";                 // ������̾
        $sql .= "   client_name2, ";                // ������̾��
        $sql .= "   client_post_no1, ";             // ������͹���ֹ�
        $sql .= "   client_post_no2, ";             // ������͹���ֹ棲
        $sql .= "   client_address1, ";             // �����轻�꣱
        $sql .= "   client_address2, ";             // �����轻�ꣲ
        $sql .= "   client_address3, ";             // �����轻�ꣳ
        $sql .= "   client_charger1, ";             // �����褴ô����
        $sql .= "   client_tel ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // �����������ξ��
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_client.client_name, ";        // ������̾
        $sql .= "   t_client.client_name2, ";       // ������̾��
        $sql .= "   t_client.post_no1, ";           // ������͹���ֹ棱
        $sql .= "   t_client.post_no2, ";           // ������͹���ֹ棲
        $sql .= "   t_client.address1, ";           // �����轻�꣱
        $sql .= "   t_client.address2, ";           // �����轻�ꣲ
        $sql .= "   t_client.address3, ";           // �����轻�ꣳ
        $sql .= "   t_client.charger1 ";            // �����褴ô����
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_client ";
        $sql .= "   ON t_order_h.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $client_data = pg_fetch_array($res, 0);

    /****************************/
    // ľ����������
    /****************************/
    // ����������ξ��
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   direct_name, ";                 // ľ����̾
        $sql .= "   direct_name2, ";                // ľ����̾��
        $sql .= "   direct_post_no1, ";             // ľ����͹���ֹ棱
        $sql .= "   direct_post_no2, ";             // ľ����͹���ֹ棲
        $sql .= "   direct_address1, ";             // ľ���轻�꣱
        $sql .= "   direct_address2, ";             // ľ���轻�ꣲ
        $sql .= "   direct_address3, ";             // ľ���轻�ꣳ
        $sql .= "   direct_tel ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // �����������ξ��
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_direct.direct_name, ";        // ľ����̾
        $sql .= "   t_direct.direct_name2, ";       // ľ����̾��
        $sql .= "   t_direct.post_no1, ";           // ľ����͹���ֹ棱
        $sql .= "   t_direct.post_no2, ";           // ľ����͹���ֹ棲
        $sql .= "   t_direct.address1, ";           // ľ���轻�꣱
        $sql .= "   t_direct.address2, ";           // ľ���轻�ꣲ
        $sql .= "   t_direct.address3 ";            // ľ���轻�ꣳ
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_direct ";
        $sql .= "   ON t_order_h.direct_id = t_direct.direct_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res    = Db_Query($db_con, $sql);
    $direct_data = @pg_fetch_array($res, 0);

    /****************************/
    // ȯ��������
    /****************************/
    // ����������ξ��
//    if ($stat == "4"){
        $sql  = "SELECT ";
        $sql .= "   ord_no, ";                          // ȯ��No.
        $sql .= "   to_char(ord_time, 'yyyy-mm-dd'), "; // ȯ����
        $sql .= "   arrival_day, ";                     // ����ͽ����
        $sql .= "   hope_day, ";                        // ��˾Ǽ��
        $sql .= "   note_your, ";                       // �̿����ȯ���谸��
        $sql .= "   c_staff_name ";                     // ȯ���ʼ��ҡ�ô����
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "WHERE ";
        $sql .= "   ord_id = $ord_id ";
        $sql .= ";";
/*
    // �����������ξ��
    }else{
        $sql  = "SELECT ";
        $sql .= "   t_order_h.ord_no, ";
        $sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd'), ";
        $sql .= "   t_order_h.arrival_day, ";
        $sql .= "   t_order_h.hope_day, ";
        $sql .= "   t_order_h.note_your, ";
        $sql .= "   t_staff.staff_name ";
        $sql .= "FROM ";
        $sql .= "   t_order_h ";
        $sql .= "   INNER JOIN t_staff ";
        $sql .= "   ON t_order_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "   t_order_h.ord_id = $ord_id ";
        $sql .= ";";
    }
*/
    $res  = Db_Query($db_con, $sql);
    $ord_h_data = pg_fetch_array($res, 0);

    // ���դ���ڤ�
    $order_day["y"]   = substr($ord_h_data[1], 0, 4);
    $order_day["m"]   = substr($ord_h_data[1], 5, 2);
    $order_day["d"]   = substr($ord_h_data[1], 8, 2);
    $arrival_day["y"] = substr($ord_h_data[2], 0, 4);
    $arrival_day["m"] = substr($ord_h_data[2], 5, 2);
    $arrival_day["d"] = substr($ord_h_data[2], 8, 2);
    $hope_day["y"]    = substr($ord_h_data[3], 0, 4);
    $hope_day["m"]    = substr($ord_h_data[3], 5, 2);
    $hope_day["d"]    = substr($ord_h_data[3], 8, 2);

    /****************************/
    // ȯ���ʾ������
    /****************************/
    $sql  = "SELECT ";
//    $sql .= "    t_goods.goods_cd, ";     // ���ʥ�����
    $sql .= "    t_order_d.goods_cd, ";     // ���ʥ�����
    $sql .= "    t_order_d.goods_name, ";   // ����̾
//    $sql .= ($stat == "4") ? " t_order_d.goods_cname, " : "t_goods.goods_cname, ";  // ����̾ά��
    $sql .= "    t_order_d.goods_cname, ";  // ����̾ά��
//    $sql .= "    t_goods.in_num, ";       // ����
    $sql .= "    t_order_d.in_num, ";       // ����
    $sql .= "    t_order_d.num ";           // ȯ���
    $sql .= "FROM ";
    $sql .= "    t_order_d ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_order_h\n";
    $sql .= "    ON t_order_d.ord_id = t_order_h.ord_id ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_goods\n";
    $sql .= "    ON t_order_d.goods_id = t_goods.goods_id ";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_goods_info\n";
    $sql .= "    ON t_goods_info.goods_id = t_goods.goods_id ";
    $sql .= "WHERE ";
    $sql .= "    t_order_d.ord_id = $ord_id ";
    $sql .= "AND ";
    $sql .= "    t_order_h.shop_id = $shop_id ";
    $sql .= "AND ";
//    $sql .= "   t_goods_info.shop_id = $_SESSION[client_id] ";
    $sql .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "    t_order_d.line ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $ord_data = Get_Data($res,2);

    $order_count    = count($ord_data);
    $page_num       = ceil($order_count / 15);

}else{
    $order_data_num = 1;
//    $order_count = "";
    $order_count = 1;
    $page_num = ceil($order_count / 15);
}


/****************************/
// PDF����
/****************************/
//if ($format_flg != true){

    $left_margin = 16;
    $top_margin = 14;

    $pdf=new MBFPDF();

    $pdf->AddMBFont(GOTHIC ,'SJIS');
    $pdf->AddMBFont(PGOTHIC,'SJIS');
    $pdf->AddMBFont(MINCHO ,'SJIS');
    $pdf->AddMBFont(PMINCHO,'SJIS');
    $pdf->AddMBFont(KOZMIN ,'SJIS');

    $pdf->SetFont(GOTHIC, 'B', 11);
    $pdf->SetAutoPageBreak(false);

    $pdf->SetLeftMargin(16);

    for($page = 1; $page <= $page_num; $page++){

        $pdf->AddPage();

        $pdf->SetFont(GOTHIC, '','10');
        $pdf->SetXY(150, 0);
//        $pdf->Cell(71.5, 10, $page.'/'.$page_num.'�ڡ���', '0', '1', 'C');
        $pdf->Cell(71.5, 20, $page.'/'.$page_num.'�ڡ���', '0', '1', 'C');
        $pdf->SetFont(GOTHIC, 'B', 11);

        $address[8] = $staff_name;                  // ȯ��ô����̾��

        $order_list[0] = "���ʎ����Ď�";                // �����̾1
        $order_list[1] = "�����ʡ�̾";              // �����̾2
        $order_list[2] = "�ێ�������";                 // �����̾3
        $order_list[3] = "ȯ�����";                // �����̾4
        $order_list[4] = "�����͡���";              // �����̾5

        // �����ȥ�
        $pdf->SetFont(GOTHIC, 'B', 15);
        $pdf->SetXY(90, $top_margin);
        $pdf->Cell(40, 5, $page_title, '0', '1', 'C');

        $pdf->SetFont(GOTHIC, 'B', 11);

        // ȯ���
        $pdf->Cell(90, 5, "ȯ��⡡".$ord_h_data[0], '0', '0', 'L');

        // ȯ����
        $pdf->Cell(96, 5, "ȯ������".$order_day["y"]." ǯ��".$order_day["m"]." �".$order_day["d"]." ��", '0', '1', 'R');

        // ȯ����
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+6);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(110, 5, "��ȯ����", '', '2', 'L');
/*
        $pdf->Cell(90, 5, "ȯ����", 'TLR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "��".$client_data[0], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "��".$client_data[1], 'LR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "�� ".$client_data[2]." - ".$client_data[3], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "��".$client_data[4], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "��".$client_data[5], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "��".$client_data[6], 'LR', '2', 'L');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 5, "����".$client_data[7], 'LR', '2', 'L');
        $pdf->Cell(90, 5, "����", 'LRB', '2', 'R');
*/
        $pdf->SetFont(GOTHIC, 'B','11');
        //������̾
        if($client_data[1] == null){
            $pdf->Cell(110, 5, "����".$client_data[0]."��������", '', '2', 'L');
            $pdf->Cell(110, 5, "", '', '2', 'L');
        }else{
            $pdf->Cell(110, 5, "����".$client_data[0], '', '2', 'L');
            $pdf->Cell(110, 5, "����".$client_data[1]."��������", '', '2', 'L');
        }

        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(110, 2, "", '', '2', 'L');
        $pdf->Cell(110, 5, "���� ".$client_data[2]." - ".$client_data[3], '', '2', 'L');
        $pdf->Cell(110, 5, "����".$client_data[4], '', '2', 'L');
        $pdf->Cell(110, 5, "����".$client_data[5], '', '2', 'L');
        $pdf->Cell(110, 5, "����".$client_data[6], '', '2', 'L');
        $pdf->Cell(110, 5, "����".$client_data[client_tel], '', '2', 'L');
        $pdf->Cell(110, 2, "", '', '2', 'L');

        // ȯ���ʼ��ҡ˾���ȯ��񥳥���
        $pdf->SetXY($left_margin+116, $top_margin+15);
        $pdf->SetFont(GOTHIC, 'B','11');
        $pdf->Cell(70, 5, $my_data[0], '0', '2', 'L');
        $pdf->Cell(70, 5, $my_data[1], '0', '2', 'L');
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(70, 2, "", '0', '2', 'L');
        $pdf->Cell(70, 5, "�� ".$o_memo[0][0]." - ".$o_memo[0][1], '0', '2', 'L');
        $pdf->Cell(70, 5, "��".$o_memo[0][2], '0', '2', 'L');
        $pdf->Cell(70, 5, "��".$o_memo[0][3], '0', '2', 'L');
        $pdf->Cell(70, 5, "��".$o_memo[0][4], '0', '2', 'L');
        $pdf->Cell(70, 5, "��".$o_memo[0][5], '0', '2', 'L');
        $pdf->Cell(70, 5, "��".$o_memo[0][6], '0', '2', 'L');
        $pdf->Cell(70, 2, "", '0', '2', 'L');
        $pdf->Cell(70, 5, "��ȯ��ô����".$ord_h_data[5], '0', '2', 'L');

        //�����ȡʾ��ʡ�
        $posY = $pdf->GetY();
//        $pdf->SetXY($left_margin+5, $posY+15);
        $pdf->SetXY($left_margin+5, $posY+4);
        $pdf->Cell(170, 5, $o_memo[0][7], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][8], '0', '1', 'L');

        // ľ����
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+3);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(90, 5, "����ľ����", 'TLR', '1', 'L');
        $pdf->SetFont(GOTHIC, 'B','9');
        $pdf->Cell(90, 2, "", 'LR', '2', 'L');
        $pdf->Cell(90, 4, "������".$direct_data[0], 'LR', '1', 'L');
        $pdf->Cell(90, 2, "������".$direct_data[1], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "", 'LR', '2', 'L');
        if ($direct_data[2] == "" && $direct_data[3] == ""){
            $pdf->Cell(90, 4, "����", 'LR', '1', 'L');
        }else{
            $pdf->Cell(90, 4, "������ ".$direct_data[2]." - ".$direct_data[3], 'LR', '1', 'L');
        }
        $pdf->Cell(90, 4, "������".$direct_data[4], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "������".$direct_data[5], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "������".$direct_data[6], 'LR', '1', 'L');
        $pdf->Cell(90, 4, "������".$direct_data[7], 'LRB', '1', 'L');

        //�̿���
        $pdf->SetXY($left_margin+93, $posY+3);
        $pdf->SetFont(GOTHIC, 'B','10');
        $pdf->Cell(93, 5, "�̿���", 'TLR', '1', 'L');
        $pdf->SetXY($left_margin+93, $posY+7);
        $pdf->SetFont(GOTHIC, 'B','9');
        $pdf->Cell(93, 2, "", 'LR', '2', 'L');
        $pdf->MultiCell(95, 4, $ord_h_data[4], '0', '2', 'L');
        $pdf->SetXY($left_margin+93, $posY+3);
        $pdf->Cell(93, 37, '', '1', '2', 'L');

        //�����ʥإå��ԡ�
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+8, $posY+3);
        $pdf->Cell(16, 8, $order_list[0], '1', '0', 'C');
        $pdf->Cell(104, 8, $order_list[1], '1', '0', 'C');
        $pdf->Cell(16, 8, $order_list[2], '1', '0', 'C');
        $pdf->Cell(16, 8, $order_list[3], '1', '0', 'C');
        $pdf->Cell(26, 8, $order_list[4], '1', '2', 'C');

        // �����ʥǡ����ԡ�
        $pdf->SetFont(GOTHIC, 'B', 9.5);
        for($i=0+(($page-1)*15); $i< 15*$page; $i++){
            $posY = $pdf->GetY();
            $pdf->SetXY($left_margin, $posY);
            $pdf->Cell(8, 5.3, str_pad($i+1, 2, "0", STR_PAD_LEFT), '1', '0', 'C');
            $pdf->Cell(16, 5.3, $ord_data[$i][0], '1', '0', 'L');
            $pdf->Cell(104, 5.3, $ord_data[$i][1]."��".$ord_data[$i][2], '1', '0', 'L');
            $pdf->Cell(16, 5.3, $ord_data[$i][3], '1', '0', 'R');
            $pdf->Cell(16, 5.3, $ord_data[$i][4], '1', '0', 'R');
            $pdf->Cell(26, 5.3, $ord_data[$i][5], '1', '2', 'L');
        }

        $pdf->SetFont(GOTHIC, 'B', 11);
        // ��˾Ǽ��
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+3);
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(21, 10, "��˾Ǽ��", '1', '0', 'C');
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(68, 10,$hope_day["y"]." ǯ��".$hope_day["m"]." �".$hope_day["d"]." ����", '1', '0', 'C');

        // ȯ����
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(21, 10, "ȯ����", '1', '0', 'C');
        $pdf->Cell(2, 10, "", '1', '0', 'C');
        $pdf->Cell(68, 10, $order_count." ��", '1', '2', 'C');

        // �����Ȳ���
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+5, $posY+3);
        $pdf->Cell(170, 5, $o_memo[0][9], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][10], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][11], '0', '2', 'L');
        $pdf->Cell(170, 5, $o_memo[0][12], '0', '2', 'L');

        // ����
        $posY = $pdf->GetY();
        $pdf->SetLineWidth(0.4);
        $pdf->Line($left_margin, $posY+3, $left_margin+185, $posY+3);
        $pdf->SetDrawColor(255);
        for($i=2;$i<190;$i=$i+3){
            $pdf->Line($left_margin+$i, $posY+3, $left_margin+$i+1, $posY+3);
        }

        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0);

        // �������
        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin, $posY+7);
        $pdf->Cell(20, 16, "�������", '1', '0', 'C');
        $pdf->MultiCell(75, 16, '', '1', '0', 'C');

        $pdf->SetXY($left_margin+95, $posY+7);
        // �в�ͽ��
        $pdf->Cell(20, 8, "�в�ͽ��", '1', '0', 'C');
        $pdf->Cell(71, 8, "����ǯ�������������", '1', '0', 'C');

        $posY = $pdf->GetY();
        $pdf->SetXY($left_margin+95, $posY+8);

        // �в�ͽ��
        $pdf->Cell(20, 8, "���ͽ��", '1', '0', 'C');
        $pdf->Cell(71, 8, "����ǯ�������������", '1', '2', 'C');

    }

//}
$pdf->Output();


?>
