<?php
/*******************************************/
//�ѹ�����
//  ��2006/03/17��
//  ��shop_id��client_id���ѹ� 
//   (2006/07/27)
//  ����������Ĺ�������
/*   2007-10-02  watanabe-k   �ǥ��쥯�ȥ깽�����ѹ���ȼ�����ѥ����ѹ�
/*   2010-09-04  aoyama-n     ��˥塼�����ѹ�
/*   2010-09-04  aoyama-n     �֥����ƥ�����פ�ֻĹ�������פ��ѹ�
/*******************************************/
$page_title='FC��˥塼';

//�Ķ�����ե�����
require_once("ENV_local.php");

//���å���󳫻�
#session_start();

//DB����³
$conn = Db_Connect();

//�ǡ�������
$client_name = htmlspecialchars($_SESSION["fc_client_name"]);
$staff_name  = htmlspecialchars($_SESSION["staff_name"]);
$shop_name   = htmlspecialchars($_SESSION["fc_shop_name"]);
$shop_id     = $_SESSION["client_id"];

//ľ��Ƚ��
$rank_cd  = $_SESSION["rank_cd"];
$sql  = "SELECT group_kind FROM t_rank WHERE rank_cd = '$rank_cd';";
$result = Db_Query($conn, $sql);
$group_kind = pg_fetch_result($result, 0,0);


if($_SESSION["sys_flg"] != "t") {
	$menu_link = "";
}
else {
    $menu_link = "<table><tr><td>";
    $menu_link .= "<a href='".TOP_PAGE_H."'><img src='".IMAGE_DIR."Head_off.gif' border='0'></a><br>";
    $menu_link .= "<img src='".IMAGE_DIR."FC_on.gif' border='0'>";
    $menu_link .= "</td></tr></table>";
}

//����饤��ȯ���ǡ�����̤��ǧ�Υǡ��������ä����ϡ�
//�ܥ���ο����ѹ����롣
$sql  = "SELECT\n";
$sql .= "   COUNT(ord_id)\n";
$sql .= " FROM\n";
$sql .= "   t_order_h\n";
$sql .= " WHERE\n";
$sql .= "   shop_id = $shop_id\n";
$sql .= "   AND\n";
$sql .= "   ord_stat = '1'\n";
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$total_count = pg_fetch_result($result, 0,0);
//�ǡ��������뤫
if($total_count != 0){
    //¸�ߤ������ϡ��ֲ���
    $online_order_img = "2_1_4-2.gif";
}else{
    //¸�ߤ��ʤ����ϡ��Ĳ���
    $online_order_img = "2_1_4.gif";
}

// ��԰�����ǡ�����̵ͭ�ˤ����԰���ܥ�����ڤ��ؤ�
$sql  = "SELECT \n";
$sql .= "    contract_id \n";
$sql .= "FROM \n";
$sql .= "    t_contract \n";
$sql .= "WHERE \n";
$sql .= "    trust_id = ".$_SESSION["client_id"]." \n";
$sql .= "AND \n";
$sql .= "    contract_div = '2' \n";
$sql .= "AND\n";
$sql .= "    request_state = '1' \n";
$sql .= ";";
$res  = Db_Query($conn, $sql);
$img_6_1_16 = (pg_num_rows($res) > 0) ? "6_1_16-2.gif" : "6_1_16.gif";

//***************************/
//ɽ�������˥塼����
/****************************/
$select_menu = $_POST["select_menu"];

/*****************************/
//��˥塼���
/*****************************/
//--------------------��˥塼�����--------------------
if($select_menu == '0'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_off.gif' border='0'></a>"
    );
}elseif($select_menu == '1'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_off.gif' border='0'></a>"
    );
}elseif($select_menu == '2'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_off.gif' border='0'></a>"
    );
}elseif($select_menu == '3'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_off.gif' border='0'></a>"
    );
}elseif($select_menu == '4'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_off.gif' border='0'></a>"
    );
}elseif($select_menu == '5'){
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_off.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_on.gif' border='0'></a>"
    );
}else{
    $l_menu = array(
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','0')><img src='".IMAGE_DIR."main_menu/1_sale_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','1')><img src='".IMAGE_DIR."main_menu/2_buy_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','2')><img src='".IMAGE_DIR."main_menu/3_stock_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','3')><img src='".IMAGE_DIR."main_menu/4_update_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','4')><img src='".IMAGE_DIR."main_menu/5_data_output_on.gif' border='0'></a>",
        "<a href='#' onClick=Button_Submit('select_menu','$_SERVER[PHP_SELF]','5')><img src='".IMAGE_DIR."main_menu/6_master_on.gif' border='0'></a>"
    );
}

//--------------------��˥塼�����--------------------
//��������
$m_menu[0] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/1_7.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/1_3.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/1_4.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/1_5.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/1_6.gif'>",
);

//����������
$m_menu[1] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/2_1.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/2_2.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/2_3.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/2_4.gif'>",
);

//���߸˴���
$m_menu[2] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/3_1.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/3_2.gif'>",
);

//������
$m_menu[3] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/4_1.gif'>",
);

//���ǡ�������
$m_menu[4] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/5_1.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/5_2.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/5_3.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/5_4.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/5_5.gif'>",
);

//���ޥ�������
#2010-09-04 aoyama-n
$m_menu[5] = array(
    "<img border='0' src='".IMAGE_DIR."main_menu/6_1.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/6_1.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/6_2.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/6_3.gif'>",
    "<img border='0' src='".IMAGE_DIR."main_menu/6_5.gif'>",
);

//widthsize
$m_width[0]= "150";     //������
$m_width[1]= "187";     //��������
$m_width[2]= "375";     //�߸˴���
$m_width[3]= "750";     //����
$m_width[4]= "150";     //�ǡ�������
$m_width[5]= "150";     //�ޥ�������

//--------------------��˥塼������--------------------
//��������        
//ͽ����
//ľ�Ĥξ��
//if($group_kind == 2){
$s_menu[0][0] = array(
        //array("sale/2-2-101-2.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_3.gif'>"),
        array("sale/2-2-101-2.php","<img border='0' src='".IMAGE_DIR."main_menu/1_7_1.gif'>"),
        //array("sale/2-2-102-2.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_4.gif'>"),
        //array("sale/2-2-104.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_5.gif'>"),
        //array("sale/2-2-105.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_6.gif'>"),
        //array("sale/2-2-108.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_7.gif'>"),
        //array("sale/2-2-109.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_8.gif'>"),
        //array("sale/2-2-113.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_10.gif'>"),
        array("sale/2-2-113.php","<img border='0' src='".IMAGE_DIR."main_menu/1_7_2.gif'>"),
		//array("sale/2-2-111.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_9.gif'>"),
        array("sale/2-2-118.php","<img border='0' src='".IMAGE_DIR."main_menu/1_7_5.gif'>"),
        array("sale/2-2-206.php","<img border='0' src='".IMAGE_DIR."main_menu/1_7_3.gif'>"),
        array("sale/2-2-209.php","<img border='0' src='".IMAGE_DIR."main_menu/1_7_4.gif'>"),
		//array("system/2-1-237.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_18.gif'>"),
);
/*
//ľ�İʳ�
}else{
$s_menu[0][0] = array(
        array("sale/2-2-101-2.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_3.gif'>"),
        array("sale/2-2-102-2.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_4.gif'>"),
        //array("sale/2-2-104.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_5.gif'>"),
        //array("sale/2-2-105.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_6.gif'>"),
        //array("sale/2-2-108.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_7.gif'>"),
        //array("sale/2-2-109.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_8.gif'>"),
        array("sale/2-2-113.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_10.gif'>"),
		array("sale/2-2-111.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_9.gif'>"),
        array("sale/2-2-204.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_2.gif'>"),
		array("system/2-1-238.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_17.gif'>"),
);
}
*/

//�����
$s_menu[0][1] = array(
        array("sale/2-2-201.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_9.gif'>"),
        //array("sale/2-2-206.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_3.gif'>"),
        array("sale/2-2-207.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_4.gif'>"),
        array("sale/2-2-210.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_10.gif'>"),
        //array("sale/2-2-209.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_5.gif'>"),
        //array("sale/2-2-212.php","<img border='0' src='".IMAGE_DIR."main_menu/1_3_6.gif'>"),
);

//�������
$s_menu[0][2] = array(
        array("sale/2-2-301.php","<img border='0' src='".IMAGE_DIR."main_menu/1_4_1.gif'>"),
        //array("sale/2-2-302.php","<img border='0' src='".IMAGE_DIR."main_menu/1_4_2.gif'>"),
        //array("sale/2-2-306.php","<img border='0' src='".IMAGE_DIR."main_menu/1_4_3.gif'>"),
);

//�������
$s_menu[0][3] = array(
        //array("sale/2-2-401.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_1.gif'>"),
        array("sale/2-2-402.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_2.gif'>"),
        array("sale/2-2-403.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_3.gif'>"),
        array("sale/2-2-411.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_5.gif'>"),
        array("sale/2-2-412.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_6.gif'>"),
        array("sale/2-2-414.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_7.gif'>"),
        array("sale/2-2-415.php","<img border='0' src='".IMAGE_DIR."main_menu/1_5_8.gif'>"),
);

//���Ӵ���
$s_menu[0][4] = array(
        array("sale/2-2-501.php","<img border='0' src='".IMAGE_DIR."main_menu/1_6_1.gif'>"),
        array("sale/2-2-503.php","<img border='0' src='".IMAGE_DIR."main_menu/1_6_2.gif'>"),
);

//����������
//ȯ�����
$s_menu[1][0] = array(
        array("buy/2-3-101.php","<img border='0' src='".IMAGE_DIR."main_menu/2_1_1.gif'>"),
        array("buy/2-3-102.php","<img border='0' src='".IMAGE_DIR."main_menu/2_1_3.gif'>"),
        array("buy/2-3-104.php","<img border='0' src='".IMAGE_DIR."main_menu/$online_order_img'>"),
        array("buy/2-3-106.php","<img border='0' src='".IMAGE_DIR."main_menu/2_1_5.gif'>"),
		array("system/2-1-142.php","<img border='0' src='".IMAGE_DIR."main_menu/1_1_14.gif'>"),
);

//�������
$s_menu[1][1] = array(
        array("buy/2-3-201.php","<img border='0' src='".IMAGE_DIR."main_menu/2_2_2.gif'>"),
        array("buy/2-3-202.php","<img border='0' src='".IMAGE_DIR."main_menu/2_2_3.gif'>"),
);

//��ʧ����
$s_menu[1][2] = array(
		array("buy/2-3-307.php","<img border='0' src='".IMAGE_DIR."main_menu/2_3_5.gif'>"),
        //array("buy/2-3-301.php","<img border='0' src='".IMAGE_DIR."main_menu/2_3_4.gif'>"),
        array("buy/2-3-302.php","<img border='0' src='".IMAGE_DIR."main_menu/2_3_2.gif'>"),
        array("buy/2-3-303.php","<img border='0' src='".IMAGE_DIR."main_menu/2_3_3.gif'>"),
);

//���Ӵ���
$s_menu[1][3] = array(
        array("buy/2-3-401.php","<img border='0' src='".IMAGE_DIR."main_menu/2_4_1.gif'>"),
        array("buy/2-3-403.php","<img border='0' src='".IMAGE_DIR."main_menu/2_4_2.gif'>"),
);

//���߸˴���
//�߸˼��
$s_menu[2][0] = array(
        array("stock/2-4-101.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_1.gif'>"),
//        array("stock/2-4-105.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_2.gif'>"),
        array("stock/2-4-107.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_3.gif'>"),
//        array("stock/2-4-109.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_4.gif'>"),
);

//ê������
$s_menu[2][1] = array(
        array("stock/2-4-201.php","<img border='0' src='".IMAGE_DIR."main_menu/3_2_1.gif'>"),
//        array("stock/2-4-205.php","<img border='0' src='".IMAGE_DIR."main_menu/3_2_2.gif'>"),
        array("stock/2-4-108.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_8.gif'>"),
//        array("stock/2-4-111.php","<img border='0' src='".IMAGE_DIR."main_menu/3_1_9.gif'>"),
);

//������
//��������
$s_menu[3][0] = array(
        array("renew/2-5-105.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_1.gif'>"),
        array("renew/2-5-107.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_2.gif'>"),
        array("renew/2-5-101.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_3.gif'>"),
        //array("renew/2-5-103.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_4.gif'>"),
        array("renew/2-5-104.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_5.gif'>"),
        array("renew/2-5-102.php","<img border='0' src='".IMAGE_DIR."main_menu/4_1_6.gif'>"),
);

//���ǡ�������
//���׾���
$s_menu[4][0] = array(
        array(ANALYSIS_DIR."franchise/2-6-132.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_1.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-131.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_2.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-137.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_3.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-135.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_4.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-151.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_5.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-153.php","<img border='0' src='".IMAGE_DIR."main_menu/5_1_7.gif'>"),
);

//�����
$s_menu[4][1] = array(
        array(ANALYSIS_DIR."franchise/2-6-103.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_1.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-100.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_2.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-101.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_3.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-108.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_5.gif'>"),
        //array(ANALYSIS_DIR."franchise/2-6-104.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_9.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-106.php","<img border='0' src='".IMAGE_DIR."main_menu/5_2_7.gif'>"),
);

//ABCʬ��
$s_menu[4][2] = array(
        array(ANALYSIS_DIR."franchise/2-6-112.php","<img border='0' src='".IMAGE_DIR."main_menu/5_3_1.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-110.php","<img border='0' src='".IMAGE_DIR."main_menu/5_3_2.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-114.php","<img border='0' src='".IMAGE_DIR."main_menu/5_3_4.gif'>"),
);

//�������
$s_menu[4][3] = array(
        array(ANALYSIS_DIR."franchise/2-6-122.php","<img border='0' src='".IMAGE_DIR."main_menu/5_4_1.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-121.php","<img border='0' src='".IMAGE_DIR."main_menu/5_4_2.gif'>"),
);

//CSV����
$s_menu[4][4] = array(
        array(ANALYSIS_DIR."franchise/2-6-201.php","<img border='0' src='".IMAGE_DIR."main_menu/5_5_1.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-202.php","<img border='0' src='".IMAGE_DIR."main_menu/5_5_2.gif'>"),
        array(ANALYSIS_DIR."franchise/2-6-203.php","<img border='0' src='".IMAGE_DIR."main_menu/5_5_3.gif'>"),
);

//���ޥ�������
//���̥ޥ���

//���롼�׼���Ƚ��
if($group_kind == '2'){
	//ľ��
	$s_menu[5][0] = array(
        #2010-09-04 aoyama-n
        array("system/2-1-301.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_1.gif'>"),
        array("system/2-1-350.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_6.gif'>"),

        array("system/2-1-203.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_2.gif'>"),
        array("system/2-1-200.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_20.gif'>"),
        array("system/2-1-201.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_1.gif'>"),
        array("system/2-1-213.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_3.gif'>"),
        array("system/2-1-207.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_4.gif'>"),
        array("system/2-1-107.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_1.gif'>"),
        array("system/2-1-302.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_5.gif'>"),
        //array("system/2-1-227.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_5.gif'>"),
        array("system/2-1-219.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_13.gif'>"),
        array("system/2-1-225.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_14.gif'>"),
    #2010-09-04 aoyama-n
	);
	$s_menu[5][1] = array(
        array("system/2-1-215.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_12.gif'>"),
		array("system/2-1-113.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_19.gif'>"),
        #2010-04-06 hashimoto-y
        #array("system/2-1-103.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_10.gif'>"),
        array("system/2-1-101.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_10.gif'>"),
        array("system/2-1-111.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_11.gif'>"),
	);
}else{
	//�ƣ�(��԰��ꡦ������ʼ������ѡ�ɽ��)
	$s_menu[5][0] = array(
        #2010-09-04 aoyama-n
        array("system/2-1-301.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_1.gif'>"),
        array("system/2-1-350.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_6.gif'>"),

        array("system/2-1-203.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_2.gif'>"),
        array("system/2-1-200.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_20.gif'>"),
        array("system/2-1-201.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_1.gif'>"),
        array("system/2-1-213.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_3.gif'>"),
        array("system/2-1-207.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_4.gif'>"),
        array("system/2-1-107.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_1.gif'>"),
        array("system/2-1-302.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_5.gif'>"),
        //array("system/2-1-227.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_5.gif'>"),
        array("system/2-1-219.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_13.gif'>"),
        array("system/2-1-225.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_14.gif'>"),
        array("system/2-1-239.php","<img border='0' src='".IMAGE_DIR."main_menu/".$img_6_1_16."'>"),
    #2010-09-04 aoyama-n
	);
	$s_menu[5][1] = array(
        array("system/2-1-215.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_12.gif'>"),
		array("system/2-1-113.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_19.gif'>"),
        #2010-04-06 hashimoto-y
        #array("system/2-1-103.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_10.gif'>"),
        array("system/2-1-101.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_10.gif'>"),
		array("system/2-1-111.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_11.gif'>"),
	);
}

//������ͭ�ޥ���
#2010-09-04 aoyama-n
#$s_menu[5][1] = array(
$s_menu[5][2] = array(
        array("system/2-1-211.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_3.gif'>"),
        array("system/2-1-209.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_4.gif'>"),
        array("system/2-1-241.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_6.gif'>"),
        array("system/2-1-220.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_2.gif'>"),
);
#2010-09-04 aoyama-n
/**********
//Ģɼ����
$s_menu[5][2] = array(
        array("system/2-1-303.php","<img border='0' src='".IMAGE_DIR."main_menu/6_3_1.gif'>"),
        array("system/2-1-308.php","<img border='0' src='".IMAGE_DIR."main_menu/6_5_4.gif'>"),
        array("system/2-1-307.php","<img border='0' src='".IMAGE_DIR."main_menu/6_3_2.gif'>"),
);

//�����ƥ�����
$s_menu[5][3] = array(
        array("system/2-1-301.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_1.gif'>"),
        array("system/2-1-350.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_6.gif'>"),
        array("system/2-1-304.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_2.gif'>"),
        array("system/2-1-305.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_3.gif'>"),
        array("system/2-1-306.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_4.gif'>"),
);
*********/

//Ģɼ���ꡦ�Ĺ�������
$s_menu[5][3] = array(
        array("system/2-1-303.php","<img border='0' src='".IMAGE_DIR."main_menu/6_3_1.gif'>"),
        array("system/2-1-308.php","<img border='0' src='".IMAGE_DIR."main_menu/6_5_4.gif'>"),
        array("system/2-1-307.php","<img border='0' src='".IMAGE_DIR."main_menu/6_3_2.gif'>"),
        array(" "," "),
        array(" "," "),
        array(" ","<img border='0' src='".IMAGE_DIR."main_menu/6_4.gif'>"),
        array("system/2-1-304.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_2.gif'>"),
        array("system/2-1-305.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_3.gif'>"),
        array("system/2-1-306.php","<img border='0' src='".IMAGE_DIR."main_menu/6_4_4.gif'>"),
);

//���������ޥ���
$s_menu[5][4] = array(
        array("system/2-1-231.php","<img border='0' src='".IMAGE_DIR."main_menu/6_5_1.gif'>"),
        array("system/2-1-234.php","<img border='0' src='".IMAGE_DIR."main_menu/6_5_2.gif'>"),
        array("system/2-1-233.php","<img border='0' src='".IMAGE_DIR."main_menu/6_5_3.gif'>"),
        array("system/2-1-232.php","<img border='0' src='".IMAGE_DIR."main_menu/6_2_5.gif'>"),
        array("system/2-1-229.php","<img border='0' src='".IMAGE_DIR."main_menu/6_1_7.gif'>"),
);

//�ޥ˥奢��ι�����
$manual_up_day = date("Y-m-d", filemtime(MANUAL_DIR."manual.pdf"));

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

$display = "
$html_header

<style type='text/css'>
li{
    line-height: 20px;
}
</style>



<body onload=\"deleteCookie()\">
<form name=\"dateForm\" method=\"post\">
<!---------------------- ���̥����ȥ�ơ��֥� --------------------->

<table width='100%' border='0'>
	<tr>
		<td width='300' align='left' valign='middle'>
		<font color='#555555'><b> $shop_name<br>
		$staff_name</b></font><br>
		</td>
		<td align='center'>
        <font color='#555555' size='3'><b>".$client_name."��MENU</b></font>
		</td>
		<td width='300' align='right' valign='top' width='370'>
		$menu_link
		</td>
	</tr>
</table>

<!--�ȥåץ�˥塼-->
<table width='100%'>
    <tr align='center' valign='middle' >
        <td>
        <table align='center'>
            <tr>";
            for($i = 0; $i < count($l_menu); $i++){
$display .=     "<td width='16%' align='left'>";
                    $display .= $l_menu[$i];
$display .=     "</td>";
            }
$display .=     "<input type='hidden' name='select_menu'>
            </tr>
        </table>
        </td>
    </tr>
</table>
<table width='100%' height='370'>
    <tr>
        <td height='5'><hr color='#A0A0CF'></td>
    </tr>
<tr height=\"30\" align=\"right\"><td>
<a href=\"#\" onClick=\"Button_Submit('select_menu','$_SERVER[PHP_SELF]','".$select_menu."');window.open('".MANUAL_DIR."manual.pdf','�ޥ˥奢��')\">�ޥ˥奢������������</a><br>
<font color='#555555'>�ڹ�������".$manual_up_day."��</font>
</td></tr>
    <tr valign='top'>
        <td>
        <table align='center' border=\"0\">
            <tr valign='top'>";
            for($i = 0; $i < count($m_menu[$select_menu]); $i++){
$display .=           "<td>";
$display .=           "<table align='left'  border=\"0\">";
$display .=               "<tr>";
$display .=                   "<td align='right'>".$m_menu[$select_menu][$i]."</td>";
$display .=               "</tr>";
$display .=               "<tr>";
$display .=                   "<td align='right'>";
                        for($j = 0; $j < count($s_menu[$select_menu][$i]); $j++){
                                  #2010-09-04 aoyama-n
                                  #�Ĺ�������Υ����ȥ�Τ߸���ǽ���
                                  if($select_menu == 5 && $i == 3 && $j == 5){
$display .=                           $s_menu[$select_menu][$i][$j][1];
                                  }else{
$display .=                           "<a href=".$s_menu[$select_menu][$i][$j][0].">".$s_menu[$select_menu][$i][$j][1]."</a>";
                                  }
$display .=                       "<br>";
                        }
$display .=                   "</td>";
$display .=               "</tr>";
$display .=           "</table>";
$display .=           "</td>";
            }

$display .= "      </tr>
        </table>
        </td>
    </tr> 
</table>

<table border='0' align=\"center\">
<tr><td align='center'>
	<a href='".LOGOUT_PAGE."'><img src='".IMAGE_DIR."logout.gif' border='0'></a>
</td></tr>
</table>
</form>
$html_footer


";

print $display;

?>