<?php
/********************
 * �в�ͽ������
 *
 *
 * �ѹ�����
 *    2006/07/11 (kaji)
 *      ���в�ͽ������Ⱦ�ѥ����å����ɲ�
 *    2006/07/31 (watanabe-k)
 *      �������Ǥη׻����ѹ�
 *    2006/08/07(watanabe-k)
 *      ��FCȯ���ֹ椬ȯ����Τ�ΤȰ㤦�ͤ�ɽ������Ƥ���Х����� 
 *    2006/08/08(watanabe-k)
 *      ��FCȯ�����ñ����ɽ������褦���ѹ�
 *      ��FCȯ�����ñ���ȥޥ���ñ�����ۤʤ���ϥХå��ο����֤�ɽ������褦�ѹ�
 *    2006/08/10(watanabe-k)
 *      �������ѥ�������Ͽ�������ɲ�
 ********************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/30��08-008��������watanabe-k  �в�ͽ��������˳���ȯ��ǡ�������ä����в�ͽ�����Ϥ�λ����ȼ�����ɼ����������Ƥ���Х��ν���
 * ��2006/10/30��08-026��������watanabe-k  �����襳���ɤ�ɽ������Ƥ��ʤ��Х��ν���
 * ��2006/10/30��08-027��������watanabe-k  �̿����������ǲ��Ԥ�ͭ���ˤʤäƤ��ʤ��Х��ν�����
 * ��2006/10/30��08-028��������watanabe-k  �в�ͽ�����ϲ��̤ǡ�����������������դǽв�ͽ���������Ϥ��줿�ݡ������å��ε�ư�����������Х��ν���
 * ��2006/10/31��08-029��������watanabe-k  �в�ͽ������a06-10-25�����Ϥ������Υ��顼��å������������ǤϤʤ��Х��ν���
 * ��2006/10/31��08-030��������watanabe-k  ʬǼ�в�ͽ������106-10-26�����Ϥ������Υ��顼��å������������ǤϤʤ��Х��ν���
 * ��2006/10/31��08-031��������watanabe-k  �в�ͽ���ǧ���̤ǡ��вٲ�����вٿ������������ɽ������Ƥ���Х��ν���
 * ��2006/11/03��      ��������watanabe-k  ���꡼�����ԼԤ����򤷤��ݤˡ������ȼԤ�ɬ�����Ϥˤʤ�ʤ��Х��ν���
 * ��2006/11/03��08-063��������watanabe-k  ������̾�Υ��˥��������Ǥ��Ƥ��ʤ��Х��ν���
 * ��2006/11/03��08-064��������watanabe-k  �̿�����������ˤΥ��˥��������Ǥ��Ƥ��ʤ��Х��ν���
 * ��2006/11/03��08-075��������watanabe-k  Get�����å��ɲ�
 * ��2006/11/03��08-076��������watanabe-k  Get�����å��ɲ�
 * ��2006/11/03��08-077��������watanabe-k  Get�����å��ɲ�
 * ��2006/11/09��08-123��������suzuki      �̿�������������Ԥ�ɽ�������褦�˽���
 * ��2006/11/09��08-140��������suzuki      ľ���衦�����ȼԤ�ά�Τ���Ͽ
 * ��2006/11/09��08-144��������suzuki      ���꡼�����Υ����å��ܥå��������������褦�˽���
 * ��2006/11/09��08-124��������watanabe-k  ʬǼ����������ʬǼ�в�ͽ���������Ϥ��в�ͽ������NULL����Ͽ����ȥ����ƥ೫�����ѤΥ��顼��å�������ɽ�������          
 * ��2006/11/09��08-149��������watanabe-k  �̿���������谸�ˤ�ʸ���������å����Ԥ��ʤ��Х��ν���      
 * ��2006/11/29��scl_104-2[����]��suzuki   ����̾�Ⱦ���CD���б����Ȥ��褦�˽���          
 * ��2006/12/01����            watanabe-k  ��۷׻���Ǥ�����ٷ׻��ؿ�����Ѥ���褦�˽���          
 * ��2006/12/20����            watanabe-k  Ʊ���˼����Ԥä����ˣԣϣв��̤����ܤ���Х��ν���         
 * ��2007/01/07����            watanabe-k  ����ñ����2��ʥ�С��ե����ޥåȤ��Ƥ����Τ�1�٤˽���         
 * ��2007/02/07����            watanabe-k  ���̥����ȥ���ѹ�         
 *   2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2007/03/08                 fukuda-s    DB��Ͽ��������̾�����˥��������줿���֤���Ͽ������Զ��ν���
 *   2007/03/13                watanabe-k  �����ʬ��ǥե���Ȥ����򤹤�褦���ѹ�
 *   2007/05/14                watanabe-k  �������Ĥ��褦�˽���
 *   2007/07/17                kajioka-h   ��ê����ȯ��ѿ���2��number_format���Ƥ����Τ���
 *   2007/07/18                kajioka-h   ��������֤�����Ƚ���number_format�Ѥߤο��ͤǰ��������Ƥ����Τ���
 *                                         ����¾���ƥ�ץ졼��¦��htmlspecialchars��number_format���ʤ��褦���ѹ�
 *   2007/07/20                watanabe-k  �вٿ�������Ͽ�Ǥ��ʤ��褦�˽���
 *   2007/07/31                watanabe-k  7��31���ΤȤ��в�ͽ������7��1���ˤʤ�Х��ν���
 *   2009/10/13                hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   2009/12/21                aoyama-n    ��Ψ��TaxRate���饹�������
 *   2010/01/20                aoyama-n    ��������0��ᤵ��Ƥ��ʤ����դ����Ϥ���ȼ���إå���INSERTʸ��SQL���顼�Ȥʤ�Х�����
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "�в�ͽ�����ֿ�����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//SESSION�������
/****************************/
$s_client_id = $_SESSION[client_id];
$staff_id = $_SESSION[staff_id];
//$s_shop_gid = $_SESSION[shop_gid];

/****************************/
//����Ƚ��
/****************************/
Get_Id_Check3($_GET["ord_id"]);
$g_ord_id = $_GET["ord_id"];

Get_Id_Check2($g_ord_id);

if(isset($_GET["ord_id"])){
    $new_flg = false;
}else{
    $new_flg = true;
}

/****************************/
//����Ƚ��
/****************************/
if($_POST["button"]["entry"] == "��Ͽ���ֿ���ǧ���̤�" || $_POST["button"]["alert_ok"] == "�ٹ��̵�뤷����Ͽ" || $_POST["comp_button"] == "��Ͽ���ֿ�OK"){
    $add_button_flg = true;


    /*******************************/
    //��������������Ͽ�Ѥߤ������å�
    /*******************************/
/*
    $sql  = "SELECT\n";
    $sql .= "   COUNT(ord_id) \n";
    $sql .= "FROM"; 
    $sql .= "   t_order_h \n";
    $sql .= "WHERE\n";
    $sql .= "   ord_stat = '2'\n";
    $sql .= "   AND\n";
    $sql .= "   ord_id = $g_ord_id\n";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
    if($update_check_flg === false){ 

        /*******************************/
        //������������ȯ��ǡ�����¸�ߤ�����å�
        /*******************************/
/*
        $sql  = "SELECT\n";
        $sql .= "   COUNT(ord_id) \n";
        $sql .= "FROM"; 
        $sql .= "   t_order_h \n";
        $sql .= "WHERE\n";
        $sql .= "   ord_stat = '1'\n";
        $sql .= "   AND\n";
        $sql .= "   ord_id = $g_ord_id\n";
        $sql .= ";"; 

        $result = Db_Query($db_con, $sql);
        $update_check_flg = (pg_fetch_result($result, 0,0 ) > 0)? true : false;
        if($update_check_flg === false){ 
            header("Location: ./1-2-108.php?del_flg=true");
            exit;
        }       
    }else{
        header("Location: ../top.php");
        exit;
    } 
*/ 

    /*********************************/
    //����ǡ�����Ͽ����ȯ���ơ������γ�ǧ��Ԥ�
    /*********************************/
    $sql  = "SELECT \n";
    $sql .= "   ord_stat \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "WHERE \n";
    $sql .= "   ord_id = $g_ord_id\n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $ord_stat = pg_fetch_result($result, 0,0);

    //��Ͽ����ȯ�����ä���Ƥ������
    if($ord_stat == '3'){
        header("Location: ./1-2-108.php?del_flg=true");
        exit;
    //�������˴�λ���Ƥ�����
    }elseif($ord_stat == '2'){
        header("Location: ./1-2-108.php?add_flg=true");
        exit;
    }

}else{
    $add_button_flg = false;
}


/****************************/
//�ǥե����������
/****************************/
//���ܽв��Ҹˤ����
$sql  = "SELECT";
$sql .= "   ware_id ";
$sql .= "FROM";
$sql .= "   t_client ";
$sql .= "WHERE";
$sql .= "   client_id = $s_client_id";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$def_ware_id = pg_fetch_result($result, 0,0);

$def_fdata = array(
    "form_designated_date"        => '7',
    "form_trade_select"           => "11",
    "form_staff_select"           => $staff_id,
    "form_def_day[year]"          => date('Y', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_def_day[month]"         => date('m', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_def_day[day]"           => date('d', mktime(0,0,0,date('m'),date('d')+1, date('Y'))),
    "form_ord_day[year]"          => date('Y'),
    "form_ord_day[month]"         => date('m'),
    "form_ord_day[day]"           => date('d'),
    "form_ware_select"            => $def_ware_id,
);
$form->setDefaults($def_fdata);

/****************************/
//���ɽ������
/****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($s_client_id);

//��ư���֤�ȯ���ֹ����
$select_sql = " SELECT";
$select_sql .= "     COALESCE( CAST(MAX(ord_no) AS int)+1,1)";
$select_sql .= "  FROM";
$select_sql .= "    t_aorder_h";
$select_sql .= "  WHERE";
$select_sql .= "    shop_id = $s_client_id";
$select_sql .= ";";
$result = Db_Query($db_con, $select_sql);
$auto_order_no = pg_fetch_result($result, 0 ,0);
if($result === false){
    Db_Query($db_con, "ROLLBACK;");
    exit;
}
$auto_order_no = str_pad($auto_order_no, 8, 0, STR_PAD_LEFT);

$defa_data["form_order_no"] = $auto_order_no;

//***************************/
//���꡼���������å�����
/****************************/
//�����å��ξ��ϡ������ȼԤΥץ��������ͤ��ѹ�����
if($_POST["trans_check_flg"] == true){
    $where  = " WHERE ";
//    $where .= "    shop_gid = $shop_gid";
    $where .= "    shop_id = $s_client_id";
    $where .= " AND";
    $where .= "    green_trans = 't'";

    //�����
    $trans_data["trans_check_flg"]   = "";
    $form->setConstants($trans_data);
}else{
    $where = "";
}


if($new_flg == false){

    //ȯ��إå��������
    $select_sql  = "SELECT \n";
    $select_sql .= "    t_order_h.hope_day,\n";
    $select_sql .= "    t_order_h.green_flg,\n";
    $select_sql .= "    t_order_h.client_id,\n";
    $select_sql .= "    t_client.client_cname,\n";
    $select_sql .= "    t_order_h.direct_id,\n";
    $select_sql .= "    t_direct.direct_cname,\n";
    $select_sql .= "    t_order_h.note_your, \n";
    $select_sql .= "    t_order_h.shop_id, \n";
//    $select_sql .= "    t_order_h.shop_id \n";
    $select_sql .= "    t_order_h.ord_no, \n";
    $select_sql .= "    t_client.coax, \n";
    $select_sql .= "    t_order_h.enter_day, \n";
    $select_sql .= "    t_client.client_cd1, \n";
    $select_sql .= "    t_client.client_cd2, \n";
    $select_sql .= "    t_order_h.net_amount, \n";
    $select_sql .= "    t_order_h.tax_amount, \n";
    $select_sql .= "    t_client.trade_id ";
    $select_sql .= "FROM\n";
    $select_sql .= "    t_order_h \n";
    $select_sql .= "    INNER JOIN \n";
    $select_sql .= "    (SELECT \n";
    $select_sql .= "        t_client.client_id,\n";
    $select_sql .= "        t_client.client_cd1,\n";
    $select_sql .= "        t_client.client_cd2,\n";
    $select_sql .= "        t_client.client_cname,\n";
    $select_sql .="         t_client.trade_id, ";
    $select_sql .= "        t_client.coax\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_client\n";
    $select_sql .= "    )AS t_client\n";
    $select_sql .= "    ON t_order_h.shop_id = t_client.client_id\n";
    $select_sql .= "    LEFT JOIN  t_direct\n";
    $select_sql .= "    ON t_order_h.direct_id = t_direct.direct_id \n";
    $select_sql .= "WHERE\n";
    $select_sql .= "    t_order_h.ord_id = $g_ord_id\n";
    $select_sql .= "    AND\n";
    $select_sql .= "    t_order_h.ord_stat IS NOT NULL\n";
    $select_sql .= "    AND\n";
    $select_sql .= "    t_order_h.ord_stat = '1'\n";
    $select_sql .= ";\n";

    //������ȯ��
    $result = Db_Query($db_con, $select_sql);

    Get_Id_Check($result);

    //�ǡ�������
    //$order_h_data = @pg_fetch_array ($result, 0);
    $order_h_data = Get_Data($result,1);

    $hope_day           = $order_h_data[0][0];         //��˾Ǽ��

	//���ɽ���Τ�����
	if(count($_POST) == 0){
		//�����å��դ��뤫Ƚ��
		if($order_h_data[0][1] == 't'){
			$con_data["form_trans_check"]  = $order_h_data[0][1];  //���꡼����ꤢ��
			$form->setConstants($con_data);
		}
	}
/*
    if($order_h_data[1] == 't'){
        $defa_data["form_trans_check"]  = '1';      //���꡼�����
    }else{
        $defa_data["form_trans_check"]  = '0';      //���꡼�����
    }
*/
//print_array($_POST);

    $client_id          = $order_h_data[0][2];         //ȯ��ơ��֥�Ǥ�������ID
    $aord_client_id     = $order_h_data[0][7];         //����Ȥ��Ƥ�������ID
    $client_name        = $order_h_data[0][3];         //������̾
    $direct_id          = $order_h_data[0][4];         //ľ����ID
    $direct_name        = $order_h_data[0][5];         //ľ����̾
    $note_my            = $order_h_data[0][6];         //�̿������������
    $def_note_my        = $order_h_data[0][6];         //�̿������������
    $fc_ord_id          = str_pad($order_h_data[0][8], 8, 0, STR_PAD_LEFT); //FCȯ���ֹ�
    $coax               = $order_h_data[0][9];         //��ۤޤ���ʬ
    $client_cd          = $order_h_data[0][11]." - ".$order_h_data[0][12];
    
    $defa_data["form_sale_total"]   = number_format($order_h_data[0][13]);
    $defa_data["form_sale_tax"]     = number_format($order_h_data[0][14]);
    $defa_data["form_sale_money"]   = number_format($order_h_data[0][13] + $order_h_data[0][14]);
    $defa_data["hdn_ord_enter_day"] = $order_h_data["10"];   //��Ͽ��
    $defa_data["form_trade_select"] = $order_h_data[0]["15"];

    $form->setDefaults($defa_data);
/*
    $select_sql  = "SELECT\n";
    $select_sql .= "     t_goods.goods_id,\n";
//    $select_sql .= "     t_goods.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_name,\n";
    $select_sql .= "     t_order_d.num,\n";
    $select_sql .= "     t_cost_price.cost_price,\n";
    $select_sql .= "     t_sale_price.sale_price,\n";
    $select_sql .= "     t_order_d.num * t_cost_price.cost_price AS cost_amount,\n";
    $select_sql .= "     t_order_d.num * t_sale_price.sale_price AS sale_amount,\n";
    $select_sql .= "     t_goods.tax_div,\n";
    $select_sql .= "     t_order_d.buy_price\n";
    $select_sql .= " FROM\n";
    $select_sql .= "     t_order_d\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     t_goods ON t_order_d.goods_id = t_goods.goods_id\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS cost_price\n";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_price\n";
    $select_sql .= "     WHERE\n";
//    $select_sql .= "         shop_gid = 1\n";
    $select_sql .= "         shop_id = 1\n";
    $select_sql .= "         AND\n";
    $select_sql .= "         t_price.rank_cd = '1'\n";
    $select_sql .= "    ) AS t_cost_price\n";
    $select_sql .= "     ON t_order_d.goods_id = t_cost_price.goods_id\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS sale_price\n ";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_client\n";
//    $select_sql .= "            INNER JOIN\n";
//    $select_sql .= "         t_shop_gr ON t_client.shop_gid = t_shop_gr.shop_gid\n";
//    $select_sql .= "            INNER JOIN\n";
//    $select_sql .= "         t_price ON t_shop_gr.rank_cd = t_price.rank_cd\n";
//    $select_sql .= "         WHERE t_client.client_id = $client_id AND t_price.shop_gid = 1";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "         t_price ON t_client.rank_cd = t_price.rank_cd\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_client.client_id = $aord_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_price.shop_id = 1";
    $select_sql .= "    ) AS t_sale_price\n";
    $select_sql .= "    ON t_order_d.goods_id = t_sale_price.goods_id\n";
    $select_sql .= " WHERE\n";
    $select_sql .= "     t_order_d.ord_id = $g_ord_id\n";
    $select_sql .= " ORDER BY t_order_d.line\n";
    $select_sql .= ";\n";
*/


    $designated_date = ($_POST["form_designated_date"] != NULL)? $_POST["form_designated_date"] : 7;

    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 7;
    }

    $select_sql  = "SELECT\n";
    $select_sql .= "     t_goods.goods_id,\n";
    $select_sql .= "     t_order_d.goods_cd,\n";
    $select_sql .= "     t_order_d.goods_name,\n";
    $select_sql .= "     t_order_d.num,\n";
    $select_sql .= "     t_cost_price.cost_price,\n";
    $select_sql .= "     t_sale_price.sale_price,\n";
    $select_sql .= "     t_order_d.num * t_cost_price.cost_price AS cost_amount,\n";
    $select_sql .= "     t_order_d.num * t_sale_price.sale_price AS sale_amount,\n";
    $select_sql .= "     t_goods.tax_div,\n";
    $select_sql .= "     t_order_d.buy_price, \n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock.stock_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS rack_num,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock_io.order_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS on_order_num,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_allowance_io.allowance_io_num, 0) AS TEXT)\n";
//    $select_sql .= "     - COALESCE(t_allowance_io.allowance_io_num,0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS allowance_total,\n";
    #2009-10-13 hashimoto-y
    #$select_sql .= "     CASE t_goods.stock_manage\n";
    $select_sql .= "     CASE t_goods_info.stock_manage\n";

    $select_sql .= "        WHEN '1' THEN CAST(COALESCE(t_stock.stock_num, 0)\n";
    $select_sql .= "                         + COALESCE(t_stock_io.order_num,0)\n";
//    $select_sql .= "                         - (COALESCE(t_stock.rstock_num, 0)\n";
    $select_sql .= "                         - COALESCE(t_allowance_io.allowance_io_num, 0) AS TEXT)\n";
    $select_sql .= "        ELSE '-'\n";
    $select_sql .= "     END AS stock_total, ";
    $select_sql .= "     t_order_d.line ";
    $select_sql .= " FROM\n";
    $select_sql .= "     t_order_d\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "     t_goods ON t_order_d.goods_id = t_goods.goods_id\n";
    $select_sql .= "        INNER JOIN\n";

    //����ñ��
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS cost_price\n";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_price\n";
    $select_sql .= "     WHERE\n";
    $select_sql .= "         shop_id = 1\n";
    $select_sql .= "         AND\n";
    $select_sql .= "         t_price.rank_cd = '1'\n";
    $select_sql .= "    ) AS t_cost_price\n";
    $select_sql .= "     ON t_order_d.goods_id = t_cost_price.goods_id\n";
    $select_sql .= "        INNER JOIN\n";

    //���ñ��
    $select_sql .= "     (SELECT\n";
    $select_sql .= "         t_price.goods_id,\n";
    $select_sql .= "         t_price.r_price AS sale_price\n ";
    $select_sql .= "     FROM\n";
    $select_sql .= "         t_client\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "         t_price ON t_client.rank_cd = t_price.rank_cd\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_client.client_id = $aord_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_price.shop_id = 1";
    $select_sql .= "    ) AS t_sale_price\n";
    $select_sql .= "    ON t_order_d.goods_id = t_sale_price.goods_id\n";
    $select_sql .= "        LEFT JOIN\n";

    //�߸˿�
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock.goods_id,\n";
    $select_sql .= "        SUM(t_stock.stock_num) AS stock_num,\n";
    $select_sql .= "        SUM(t_stock.rstock_num) AS rstock_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "    GROUP BY t_stock.goods_id\n";
    $select_sql .= "    ) AS t_stock\n";
    $select_sql .= "    ON t_order_d.goods_id = t_stock.goods_id\n";

    $select_sql .= "        LEFT JOIN\n";

    //ȯ��ѿ�
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock_hand.goods_id,\n";
    $select_sql .= "        SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock_hand\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock_hand.work_div = 3\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "        AND\n";
//    $select_sql .= "        CURRENT_DATE <= t_stock_hand.work_day\n";
//    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "    GROUP BY t_stock_hand.goods_id\n";
    $select_sql .= "    ) AS t_stock_io\n";
    $select_sql .= "    ON t_order_d.goods_id = t_stock_io.goods_id\n";

    $select_sql .= "        LEFT JOIN\n";

    //������
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_stock_hand.goods_id,\n";
    $select_sql .= "        SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_stock_hand\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_ware\n";
    $select_sql .= "        ON t_stock_hand.ware_id = t_ware.ware_id\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "        t_stock_hand.work_div = 1\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_stock_hand.shop_id = $s_client_id\n";
    $select_sql .= "        AND\n";
    $select_sql .= "        t_ware.count_flg = 't'\n";
    $select_sql .= "        AND\n";
//    $select_sql .= "        t_stock_hand.work_day > (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "        t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
    $select_sql .= "    GROUP BY t_stock_hand.goods_id\n";
    $select_sql .= "    ) AS t_allowance_io\n";
    $select_sql .= "    ON t_order_d.goods_id = t_allowance_io.goods_id\n";
    #2009-10-13 hashimoto-y
    $select_sql .= "    INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id\n";

    $select_sql .= " WHERE\n";
    $select_sql .= "     t_order_d.ord_id = $g_ord_id\n";
    #2009-10-13 hashimoto-y
    $select_sql .= "     AND\n";
    $select_sql .= "     t_goods_info.shop_id = 1\n";

    $select_sql .= " ORDER BY t_order_d.line\n";
    $select_sql .= ";\n";

    //������ȯ��
    $result = Db_Query($db_con, $select_sql);

    $num = pg_num_rows($result);
    $order_d_data = Get_Data($result, 2);


    for($i=0;$i<$num;$i++){
        $goods_id[$i]           = $order_d_data[$i][0];         //����ID
        $aord_num[$i]           = $order_d_data[$i][3];         //�����

        $cost_price[$i]         = $order_d_data[$i][4];         //����ñ��
        $sale_price[$i]         = $order_d_data[$i][5];         //���ñ��

        $cost_amount[$i]        = bcmul($cost_price[$i], $aord_num[$i], 2); // �������
        $cost_amount[$i]        = Coax_Col($coax, $cost_amount[$i]);
        $order_d_data[$i][6]    = $cost_amount[$i];

        $sale_amount[$i]        = bcmul($sale_price[$i], $aord_num[$i], 2); // �����
        $sale_amount[$i]        = Coax_Col($coax, $sale_amount[$i]);
        $order_d_data[$i][7]    = $sale_amount[$i];

//        $cost_amount[$i]        = $order_d_data[$i][6];         //�������
//        $sale_amount[$i]        = $order_d_data[$i][7];         //�����

        $tax_div[$i]            = $order_d_data[$i][8];         //���Ƕ�ʬ

        $buy_price[$i]          = $order_d_data[$i][9];         //FCȯ��ñ��
        $buy_amount[$i]         = bcmul($buy_price[$i], $aord_num[$i], 2);  //FCȯ����
        $buy_amount[$i]         = Coax_Col($coax, $buy_amount[$i]);

        //�夫��������ѹ��������ᡢ�����ν��֤������������ʤäƤ��ޤä�����
        $order_d_data[$i][14]   = $order_d_data[$i][12];
        $order_d_data[$i][15]   = $order_d_data[$i][13];
        $order_d_data[$i][12]   = $order_d_data[$i][10];
        $order_d_data[$i][13]   = $order_d_data[$i][11];

        $order_d_data[$i][10]   = $buy_amount[$i];

        //FCȯ��ñ���ȥޥ���ñ������٤�
        //�ۤʤ���ϡ��ե饰��Ω�Ƥ�
        $order_d_data[$i][11] = ($sale_amount[$i] != $buy_amount[$i])? true : false;

        $def_data["form_forward_num"][$i][0] = $aord_num[$i];   //�вٿ�
    }
    $form->setDefaults($def_data);
/*
    if($_POST["forward_ware_flg"] == true){
        //�߸˿����
        $select_sql  = "SELECT\n";
        $select_sql .= "    t_order_d.goods_id,\n";
        $select_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
        $select_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) - COALESCE(t_allowance.allowance_num,0) END AS stock_total \n";
        $select_sql .= "FROM \n";
        $select_sql .= "    t_order_d INNER JOIN t_goods\n";
        $select_sql .= "    ON t_order_d.goods_id = t_goods.goods_id\n";
        $select_sql .= "    LEFT JOIN t_stock\n";
        $select_sql .= "    ON t_order_d.goods_id = t_stock.goods_id\n";
        $select_sql .= "    LEFT JOIN\n";
        $select_sql .= "    (SELECT \n";
        $select_sql .= "    goods_id,\n";
        $select_sql .= "    ware_id,\n";
        $select_sql .= "    SUM(num * CASE io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS allowance_num\n";
        $select_sql .= "    FROM t_stock_hand \n";
        $select_sql .= "    WHERE work_div = 1\n";
        $select_sql .= "    AND client_id =  $s_client_id\n";
        if($_POST[form_ware_select] == ""){
            $select_sql .= "    AND ware_id = null\n";
        }else{
            $select_sql .= "    AND ware_id = $_POST[form_ware_select]\n";
        }
        $select_sql .= "    AND work_day <= (CURRENT_DATE + 7)\n";
        $select_sql .= "    GROUP BY goods_id,ware_id\n";
        $select_sql .= "    ) AS t_allowance\n";
        $select_sql .= "    ON t_order_d.goods_id = t_allowance.goods_id \n";
        $select_sql .= "WHERE \n";
        $select_sql .= "    t_order_d.ord_id = $g_ord_id \n";
        $select_sql .= "AND \n";
        $select_sql .= "    t_stock.shop_id = $s_client_id \n";
        $select_sql .= "AND \n";
        if($_POST[form_ware_select] == ""){
            $select_sql .= "    t_stock.ware_id = null \n";
        }else{
            $select_sql .= "    t_stock.ware_id = $_POST[form_ware_select] \n";
        }
        $select_sql .= "ORDER BY t_order_d.line \n";
        $select_sql .= ";\n";

        //������ȯ��
        $result = pg_query($db_con, $select_sql);
        $st_num = pg_num_rows($result);
        $stock_data = Get_Data($result);

        //�º߸˿􎥰�����ǽ����null�ξ��0������
        for($i = 0;$i < $num;$i++){
            for($j = 0;$j <= $st_num;$j++){
                if($stock_data[$j][0] != $order_d_data[$i][0]){
                    $order_d_data[$i][12] = '0';
                    $order_d_data[$i][13] = '0';
                }else{
                    $order_d_data[$i][12] = $stock_data[$j][1];
                    $order_d_data[$i][13] = $stock_data[$j][2];
                    break;
                }
            }
        }
    }
*/
}

/****************************/
//�������
/****************************/
//ȯ���ֹ�
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #000000; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//�вٲ��
$select_page_arr = array(1,2,3,4,5,6,7,8,9,10);
for($i=0;$i<$num;$i++){

    //�вٲ��
    $form->addElement('select', 'form_forward_times['.$i.']', "�вٲ��", $select_page_arr,"onChange=\"javascript:Button_Submit('forward_num_flg','#','true', this)\"");

    //�в�ͽ����
    $form_forward_day = "";
    $form_forward_day[] =& $form->createElement(
            "text","year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
            onkeyup=\"changeText(this.form,'form_forward_day[$i][0][year]','form_forward_day[$i][0][month]',4)\" 
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form_forward_day[] =& $form->createElement(
            "text","month","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
            onkeyup=\"changeText(this.form,'form_forward_day[$i][0][month]','form_forward_day[$i][0][day]',2)\" 
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form_forward_day[] =& $form->createElement(
            "text","day","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
            onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][0]','year','month','day','form_ord_day','year','month','day')\"
            onBlur=\"blurForm(this)\""
            );
    $form->addGroup( $form_forward_day,"form_forward_day[".$i."][0]","form_forward_day","-");

    //�вٿ�
    $form->addElement(
            "text","form_forward_num[".$i."][0]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\" 
            style=\"$g_form_style;text-align: right\"
            \".$g_form_option.\""
            );
    //��ɬ�ܥ����å�
    $form->addRule("form_forward_num[".$i."][0]", "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���","required");
    $form->addRule("form_forward_num[".$i."][0]", "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���","numeric");

    if($_POST["forward_num_flg"] == true){
        $forward_number = $_POST["form_forward_times"][$i];
        for($j=1;$j<=$forward_number;$j++){
            //�в�ͽ����
            $form_forward_day = "";
            $form_forward_day[] =& $form->createElement(
                    "text","year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
                    onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][year]','form_forward_day[$i][$j][month]',4)\" 
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form_forward_day[] =& $form->createElement(
                    "text","month","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
                    onkeyup=\"changeText(this.form,'form_forward_day[$i][$j][month]','form_forward_day[$i][$j][day]',2)\" 
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form_forward_day[] =& $form->createElement(
                    "text","day","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
                    onFocus=\"Resrv_Form_NextToday(this,this.form,'form_forward_day[$i][$j]','year','month','day','form_ord_day','year','month','day')\"
                    onBlur=\"blurForm(this)\""
                    );
            $form->addGroup( $form_forward_day,"form_forward_day[".$i."][".$j."]","form_forward_day","-");

            //�вٿ�
            $form->addElement(
                    "text","form_forward_num[".$i."][".$j."]","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\" 
                    style=\"$g_form_style;text-align: right\"
                    \".$g_form_option.\""
            );
            /*
            //���в�ͽ����
            //��Ⱦ�ѿ��������å�
            $form->addGroupRule("form_forward_day[".$i."][0]", array(
                    'year' => array(
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'required'),
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'numeric')
                    ),
                    'month' => array(
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'required'),
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'numeric')
                    ),
                    'day' => array(
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'required'),
                            array('�в�ͽ������Ⱦ�ѿ��ͤΤߤǤ���', 'numeric')
                    ),
            ));
            //���вٿ�
            //��ɬ�ܥ����å�
            $form->addRule("form_forward_num[".$i."][0]", "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���","required");
            $form->addRule("form_forward_num[".$i."][0]", "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���","numeric");
            */
        }
    }
}

//�в�ͽ�����ʰ������ѡ�
$form_def_day[] =& $form->createElement(
        "text","year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_def_day[year]','form_def_day[month]',4)\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form_def_day[] =& $form->createElement(
        "text","month","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_def_day[month]','form_def_day[day]',2)\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form_def_day[] =& $form->createElement(
        "text","day","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onFocus=\"Resrv_Form_NextToday(this,this.form,'form_def_day','year','month','day','form_ord_day','year','month','day')\"
        onBlur=\"blurForm(this)\""
        );
$form->addGroup( $form_def_day,"form_def_day","form_def_day","-");

//������
$form_ord_day[] =& $form->createElement(
        "text","year","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_ord_day[year]','form_ord_day[month]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form_ord_day[] =& $form->createElement(
        "text","month","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onkeyup=\"changeText(this.form,'form_ord_day[month]','form_ord_day[day]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form_ord_day[] =& $form->createElement(
        "text","day","�ƥ����ȥե�����","size=\"1\" maxLength=\"2\" style=\"$g_form_style;\"
        onFocus=\"onForm_today(this,this.form,'form_ord_day[year]','form_ord_day[month]','form_ord_day[day]')\"
        onBlur=\"blurForm(this)\""
        );
$form->addGroup( $form_ord_day,"form_ord_day","form_ord_day","-");

//���꡼�����
$form->addElement('checkbox', 'form_trans_check', '���꡼�����', '<b>���꡼�����</b>��',"onClick=\"javascript:Link_Submit('form_trans_check','trans_check_flg','#','true')\"");

//�̿���������谸��
$form->addElement("textarea","form_note_your","�ƥ����ȥե�����","rows=\"2\" cols=\"75\" \".$g_form_option_area.\" ");

//�����ȼ�
$select_value = Select_Get($db_con,'trans',$where);
$form->addElement('select', 'form_trans_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//�Ҹ�
$select_value = Select_Get($db_con,'ware');
//$form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value,"onChange=\"javascript:Button_Submit('forward_ware_flg','#','true')\"");
$form->addElement('select', 'form_ware_select', '���쥯�ȥܥå���', $select_value);

//�����ʬ
$select_value = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'form_trade_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ô����
$select_value = Select_Get($db_con,'staff',null,true);
$form->addElement('select', 'form_staff_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//�вٲ�ǽ��
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right;$g_form_style\"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true', this)\"
    "
);

//����۹��
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #000000; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//hidden
$form->addElement("hidden","forward_ware_flg");    //�в��Ҹ�����
$form->addElement("hidden","forward_num_flg");     //�вٲ������
$form->addElement("hidden", "trans_check_flg");    //���꡼���������å��ե饰
$form->addElement("hidden", "first_page_flg", "t");    //���ɽ���ե饰
$form->addElement("hidden", "recomp_flg");          //�вٲ�ǽ���ե饰

/****************************/
//���顼�����å�(QuickForm)
/****************************/
//��������
//��ɬ�ܥ����å�
$form->addGroupRule('form_ord_day', array(
        'year' => array(
                array('�����������������Ϥ��Ƥ���������', 'required'),
                array('�����������������Ϥ��Ƥ���������', 'numeric')
        ),
        'month' => array(
                array('�����������������Ϥ��Ƥ���������', 'required'),
                array('�����������������Ϥ��Ƥ���������', 'numeric')
        ),
        'day' => array(
                array('�����������������Ϥ��Ƥ���������', 'required'),
                array('�����������������Ϥ��Ƥ���������', 'numeric')
        ),
));

//�в�ͽ����
//Ⱦ�ѥ����å�
$form->addGroupRule('form_def_day', array(
        'year' => array(
                array('�������в�ͽ���������Ϥ��Ƥ���������', 'numeric')
        ),
        'month' => array(
                array('�������в�ͽ���������Ϥ��Ƥ���������', 'numeric')
        ),
        'day' => array(
                array('�������в�ͽ���������Ϥ��Ƥ���������', 'numeric')
        ),
));
//���в��Ҹ�
//��ɬ�ܥ����å�
$form->addRule("form_ware_select", "�в��Ҹˤ����򤷤Ʋ�������","required");

//�������ʬ
//��ɬ�ܥ����å�
$form->addRule("form_trade_select", "�����ʬ�����򤷤Ʋ�������","required");

//��ô����
//��ɬ�ܥ����å�
$form->addRule("form_staff_select", "ô���Ԥ����򤷤Ʋ�������","required");

//�̿���   //��ʸ���������å�
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note_your","�̿���������谸�ˤ�50ʸ������Ǥ���","mb_maxlength","50");

/********************************/
//��׶�ۡ������ǡ���ɼ��׼���
/********************************/

//������ξ�������
$sql  = "SELECT";
$sql .= "   t_client.coax,";
$sql .= "   t_client.tax_franct";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= "   INNER JOIN t_order_h ON t_order_h.client_id = t_client.client_id";
$sql .= " WHERE";
$sql .= "    t_order_h.ord_id = $g_ord_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$client_list = Get_Data($result);

//�������������
$coax           = $client_list[0][0];        //�ݤ��ʬ�ʶ�ۡ�
$tax_franct     = $client_list[0][1];        //ü����ʬ�ʾ����ǡ�

//���ߤξ�����Ψ
#2009-12-21 aoyama-n
#$sql  = "SELECT ";
#$sql .= "    tax_rate_n ";
#$sql .= "FROM ";
#$sql .= "    t_client ";
#$sql .= "WHERE ";
#$sql .= "    client_id = $_SESSION[h_client_id];";
#$result = Db_Query($db_con, $sql); 
#$tax_num = pg_fetch_result($result, 0,0);    //���ߤξ�����

#2009-12-21 aoyama-n
$tax_rate_obj->setTaxRateDay($_POST["form_ord_day"]["year"]."-".$_POST["form_ord_day"]["month"]."-".$_POST["form_ord_day"]["day"]);
$tax_num = $tax_rate_obj->getClientTaxRate($aord_client_id);
$total_money = Total_Amount($sale_amount, $tax_div,$coax,$tax_franct,$tax_num, $client_id, $db_con);

$sale_money = number_format($total_money[0]);
$tax_money  = number_format($total_money[1]);
$st_money   = number_format($total_money[2]);

/*
    //�ե�������ͥ��å�
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $form->setConstants($money_data);
*/

//��Ͽ����
if($_POST["button"]["entry"] == "��Ͽ���ֿ���ǧ���̤�" || $_POST["button"]["alert_ok"] == "�ٹ��̵�뤷����Ͽ" || $_POST["comp_button"] == "��Ͽ���ֿ�OK"){


    $ord_no          = $_POST["form_order_no"];              //ȯ���ֹ�
    #2010-01-20 aoyama-n
    #���ߥХ���0��ᤵ��Ƥ��ʤ����դ����Ϥ���ȼ���إå���INSERTʸ��SQL���顼�Ȥʤ�
    #$ord_day         = $_POST["form_ord_day"]["year"];       //������
    #$ord_day        .= $_POST["form_ord_day"]["month"];
    #$ord_day        .= $_POST["form_ord_day"]["day"];
    $ord_day         = $_POST["form_ord_day"]["year"]."-";       //������
    $ord_day        .= $_POST["form_ord_day"]["month"]."-";
    $ord_day        .= $_POST["form_ord_day"]["day"];
    $def_day         = $_POST["form_def_day"]["year"];       //�в�ͽ����
    $def_day        .= $_POST["form_def_day"]["monty"];
    $def_day        .= $_POST["form_def_day"]["day"];
    $green           = $_POST["form_trans_check"];           //���꡼�����
    $note_your       = $_POST["form_note_your"];             //�̿���ʼ��Ұ���
    $trans_id        = $_POST["form_trans_select"];          //�����ȼ�
    $ware_id         = $_POST["form_ware_select"];           //�Ҹ�
    $trade_id        = $_POST["form_trade_select"];          //�����ʬ
    $c_staff_id      = $_POST["form_staff_select"];          //ô����
    $post_flg = true;

    /********************************/
    //���顼�����å�
    /********************************/
    //�����ȼ�
    if($green == '1'){
        $form->addRule("form_trans_select","�����ȼԤ����򤷤Ʋ�������","required");
    }

    //��������
    $aord_yy  =  str_pad($_POST["form_ord_day"]["year"], 4, 0, STR_PAD_LEFT);
    $aord_mm  =  str_pad($_POST["form_ord_day"]["month"], 2, 0, STR_PAD_LEFT);
    $aord_dd  =  str_pad($_POST["form_ord_day"]["day"], 2, 0, STR_PAD_LEFT);
    $aord_ymd = $aord_yy.$aord_mm.$aord_dd;

    if(!checkdate((int)$aord_mm, (int)$aord_dd, (int)$aord_yy)){
        $form_ord_day_err = "�����������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }else{
        $err_msge = Sys_Start_Date_Chk($aord_yy, $aord_mm, $aord_dd, "������");
        if($err_msge != null){
            $form_ord_day_err = $err_msge;
            $defd_err = true;
            $err_flg = true;
        }
    }

    //���в�ͽ����
//    $defd_yy = str_pad($_POST["form_def_day"]["year"], 4, 0, STR_PAD_LEFT);
//    $defd_mm = str_pad($_POST["form_def_day"]["month"], 2, 0, STR_PAD_LEFT);
//    $defd_dd = str_pad($_POST["form_def_day"]["day"], 2, 0, STR_PAD_LEFT);
    $defd_yy = $_POST["form_def_day"]["year"];
    $defd_mm = $_POST["form_def_day"]["month"];
    $defd_dd = $_POST["form_def_day"]["day"];
    $defd    = $defd_yy.$defd_mm.$defd_dd;

    if((!checkdate((int)$defd_mm, (int)$defd_dd, (int)$defd_yy)) && ($defd_yy != null || $defd_mm != null || $defd_dd != null)){
        $form_def_day_err = "�в�ͽ���������դ������ǤϤ���ޤ���";
        $defd_err = true;
        $err_flg = true;
    }elseif($defd_yy != null || $defd_mm != null || $defd_dd != null){

        //���������Ƚв�ͽ��������٤�
        $aord_yy = str_pad($aord_yy, '4', '0', STR_PAD_LEFT);
        $aord_mm = str_pad($aord_mm, '2', '0', STR_PAD_LEFT);
        $aord_dd = str_pad($aord_dd, '2', '0', STR_PAD_LEFT);

        $aord_ymd = $aord_yy.$aord_mm.$aord_dd;

        $defd_yy = str_pad($defd_yy, '4', '0', STR_PAD_LEFT);
        $defd_mm = str_pad($defd_mm, '2', '0', STR_PAD_LEFT);
        $defd_dd = str_pad($defd_dd, '2', '0', STR_PAD_LEFT);

        $defd = $defd_yy.$defd_mm.$defd_dd;
    
        if($aord_ymd > $defd){
            $form_def_day_err = "�в�ͽ�����ϼ������ʹߤ����դ���ꤷ�Ƥ���������";
            $defd_err = true;
            $err_flg = true;
        }

        $err_msge = Sys_Start_Date_Chk($defd_yy, $defd_mm, $defd_dd, "�в�ͽ����");
        if($err_msge != null){
            $form_def_day_err = $err_msge;
            $defd_err = true;
            $err_flg = true;
        }
    }

    //������˽в�ͽ�����˶�����Ĥξ��ϥǥե���Ȥ����դ����Ϥ���
    for($i = 0; $i< $num; $i++){
        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){
            $arv_yy = $_POST["form_forward_day"][$i][$j]["year"];
            $arv_mm = $_POST["form_forward_day"][$i][$j]["month"];
            $arv_dd = $_POST["form_forward_day"][$i][$j]["day"];
            $arv_ymd = $arv_yy.$arv_mm.$arv_dd;

            if($arv_ymd == null){
                $null_row[] = $j;
            }
        }

        //���򤬤ҤĤξ��
        if(count($null_row) == 1 && $defd_err != true){
            $row = $null_row[0];
            $_POST["form_forward_day"][$i][$row]["year"] = $defd_yy;
            $_POST["form_forward_day"][$i][$row]["month"] = $defd_mm;
            $_POST["form_forward_day"][$i][$row]["day"] = $defd_dd;

        //������İʾ�ξ��
        }elseif(count($null_row) > 1){
            $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
            $err_flg = true;
            break;
        }
        $null_row = null;
    }

    //���в�ͽ����
    //���ʿ��ʼ���˥롼��
    for($i=0;$i<$num;$i++){
        //�вٲ����������ݻ�
        $array_count[$i] = $_POST["form_forward_times"][$i];
        //�вٲ���롼��
        for($j=0;$j<=$_POST["form_forward_times"][$i];$j++){

            //���դ�NULL�Ǥʤ����0���
            if($_POST["form_forward_day"][$i][$j]["year"] != NULL){
                $_POST["form_forward_day"][$i][$j]["year"] = str_pad($_POST["form_forward_day"][$i][$j]["year"], 4, 0, STR_PAD_LEFT);
            }
            if($_POST["form_forward_day"][$i][$j]["month"] != NULL){
                $_POST["form_forward_day"][$i][$j]["month"] = str_pad($_POST["form_forward_day"][$i][$j]["month"], 2, 0, STR_PAD_LEFT);
            }
            if($_POST["form_forward_day"][$i][$j]["day"] != NULL){
                $_POST["form_forward_day"][$i][$j]["day"] = str_pad($_POST["form_forward_day"][$i][$j]["day"], 2, 0, STR_PAD_LEFT);
            }

            //�в�ͽ���� ��$yy $mm $dd ��NULL�����å������դ����������ǧ���뤿��Ԥʤ�ʤ���
            $yy  = $_POST["form_forward_day"][$i][$j]["year"];
            $mm  = $_POST["form_forward_day"][$i][$j]["month"];
            $dd  = $_POST["form_forward_day"][$i][$j]["day"];
            $ymd = $yy.$mm.$dd;

            //�в�ͽ������NULL�Ǥʤ����
            if($ymd != NULL){

                //���դ������ʾ��
                if(checkdate((int)$mm, (int)$dd, (int)$yy)){  //���㥹�Ȥ�0��NULL���Ѵ�

                    //�в�ͽ������Ⱦ�ѿ����ǤϤʤ����
                    if(!ereg("^[0-9]+$", $yy) || !ereg("^[0-9]+$", $mm) || !ereg("^[0-9]+$", $dd)){
                        $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
                        $err_flg = true;
                    }

                    //�в�ͽ��������ʣ������
                    if($all_ymd_goods[$i][$ymd] == "1"){
                        $forward_day_err = "Ʊ��ξ��ʤ�ʬǼ�в�ͽ��������ʣ���Ƥ��ޤ���";
                        $err_flg = true;
                    }else{
                        $all_ymd_goods[$i][$ymd] = 1; //����($i)�νв����˥ե饰��Ω�Ƥ�
                    }

                    //�в�ͽ�����������������ξ��
                    if($err_flg == true && $ymd < $aord_ymd){
                        $forward_day_err = "ʬǼ�в�ͽ�����ϼ������ʹߤ����դ����ꤷ�Ʋ�������";
                        $err_flg = true;
                    }

                    $err_msge = Sys_Start_Date_Chk($yy, $mm, $dd, "ʬǼ�в�ͽ����");
                    if($err_msge != null){
                    $forward_day_err = $err_msge;
                        $err_flg = true;
                    }

                //���դ������Ǥʤ����
                }else{
                    $forward_day_err = "ʬǼ�в�ͽ���������դ������ǤϤ���ޤ���";
                    $err_flg = true;
                }
            }

            //���вٿ������å�
            //��ɬ�ܥ����å�
            if($_POST["form_forward_num"][$i][$j] == null || !ereg("^[0-9]+$", $_POST["form_forward_num"][$i][$j]) || $_POST["form_forward_num"][$i][$j] == 0){
                $forward_num_err = "�вٿ���Ⱦ�ѿ��ͤΤߤǤ���";
                $err_flg = true;

            //�вٿ������Ϥ���Ƥ�����
            }else{
                //���Ϥ��줿�вٿ����
                $enter_num[$i] = $enter_num[$i]+$_POST["form_forward_num"][$i][$j];
            }
        }

        //�̾����Ͽ�ξ�����вٿ�������å�����
        if( $_POST["button"]["entry"] == "��Ͽ���ֿ���ǧ���̤�"){
            //�вٿ�������å�����
            if($aord_num[$i] < $enter_num[$i]){
                $gyou_no = $i+1;
                $alert_message .= "��No.$gyou_no ���ʤ���вٿ����������Ķ���Ƥ��ޤ���<br>";
                $alert_flg = true;
            }else if ($enter_num[$i] < $aord_num[$i]){
                $gyou_no = $i+1;
                $alert_message .= "��No.$gyou_no ���ʤ���вٿ�����������������Ƥ��ޤ���<br>";
                $alert_flg = true;
            }

            //fcȯ��ñ���ȥޥ���ñ�����ۤʤ���Ϸٹ��ɽ��
            if($order_d_data[$i][11] == true){
                $price_warning .= " No.".($i+1)." ���ʤ�FCȯ�����ۤ�����ۤ��ۤʤäƤ��ޤ���<br>";
            }
        }
    }
    /********************************/
    //��Ͽ����
    /********************************/
    //���ϥ��顼��̵�����
    if($post_flg == true && $err_flg != true){ 
        $insert_flg = true;
        $alert_output = true; //���顼��̵�����Ϸٹ��ɽ��
    }    

    //���ϥ��顼��̵�������ġ��ٹ�̵����������Ͽ�����򳫻�
    if($insert_flg == true && $alert_flg != true && $form->validate()){ 
        //���դ���
        $defd_ymd = $defd_yy."-".$defd_mm."-".$defd_dd;
        //��ϿȽ��
        if($_POST["comp_button"] == "��Ͽ���ֿ�OK"){
            /********************************/
            //�������Ͽ��ɬ�פʥǡ��������
            /********************************/
            //����ǡ�����NULL��ʸ����ˤ��֤�������
            if($trans_id == "") $trans_id = "NULL";
            if($ware_id == "") $ware_id = "NULL";
            if($direct_id == "") $direct_id = "NULL";

            //���ʿ��ʼ���˥롼��
            for($i=0;$i<$num;$i++){
                $forward_times[$i] = $_POST["form_forward_times"][$i];   //�вٲ��

                //�вٲ���롼��
                for($j=0;$j<=$forward_times[$i];$j++){

                    //�в�ͽ����
                    $f_yy  = $_POST["form_forward_day"][$i][$j]["year"];
                    $f_mm  = $_POST["form_forward_day"][$i][$j]["month"];
                    $f_dd  = $_POST["form_forward_day"][$i][$j]["day"];
                    $f_ymd = $f_yy.$f_mm.$f_dd;
                    $all_ymd[] = $f_yy.$f_mm.$f_dd; //���в�ͽ����

                    //�ѿ�̾�ѹ�
                    $goods_id     = $order_d_data[$i][0];                         //����ID
                    $forward_num  = $_POST["form_forward_num"][$i][$j];           //�вٿ�

                    //������إå���
                    $data_h[$f_ymd]["�������"][] = $order_d_data[$i][4] * $forward_num; //�������(��ɼ�׻��Ф�����)
                    $data_h[$f_ymd]["�����"][] = $order_d_data[$i][9] * $forward_num; //�����(��ɼ�׻��Ф�����)
                    $data_h[$f_ymd]["���Ƕ�ʬ"][] = $order_d_data[$i][8];

                    //������ǡ�����
                    $data_d[$f_ymd]["good_id"][]                   = $goods_id;                           //����ID
                    $data_d[$f_ymd]["line"][]                      = $i;                                  //�Կ�
                    $data_d[$f_ymd][$goods_id."-".$i][goods_name]  = addslashes($order_d_data[$i][2]);    //����̾
                    $data_d[$f_ymd][$goods_id."-".$i][num]         = $forward_num;                        //�вٿ�
                    $data_d[$f_ymd][$goods_id."-".$i][cost_price]  = $order_d_data[$i][4];                //����ñ��
                    $data_d[$f_ymd][$goods_id."-".$i][sale_price]  = $order_d_data[$i][9];                //FCȯ��ñ��
                    $data_d[$f_ymd][$goods_id."-".$i][cost_amount] = $order_d_data[$i][4] * $forward_num; //������ۡʾ��ʹ�ס�
                    $data_d[$f_ymd][$goods_id."-".$i][sale_amount] = $order_d_data[$i][9] * $forward_num; //FCȯ���ۡʾ��ʹ�ס�
                    $data_d[$f_ymd][$goods_id."-".$i][tax_div]     = $order_d_data[$i][8];                //���Ƕ�ʬ

                }
            }
            Db_Query($db_con, "BEGIN;");

            //�в�ͽ���������ʣ��������
            $all_ymd_uniq = array_unique($all_ymd);
            asort($all_ymd_uniq);
            //print_array($all_ymd_uniq);

            /********************************/
            //����إå���Ͽ
            /********************************/
            //��Ť���Ͽ�Ǥ��ʤ����뤿��ˡ�����Get����ȯ��ID�˸������ǡ�����������
            $sql  = "DELETE FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "WHERE \n";
            $sql .= "   fc_ord_id = $g_ord_id\n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, $sql);
                exit;
            }

            //�в�ͽ����(��ʣ�����)�ο���������إå�����Ͽ����
            while($fw_day = array_shift($all_ymd_uniq)){
                //��ɼ�ֹ�
                //$order_no ++; //MAX+1
//                $order_no_pad = str_pad($auto_order_no, 8, 0, STR_PAD_LEFT);
                $order_no_pad = str_pad($ord_no, 8, 0, STR_PAD_LEFT);

                //���������(�ǹ�)�����
                $cost_amount_h = array_sum($data_h["$fw_day"]["�������"]); //DB�˥����ʤ�

                //�������(�ǹ�)������ס���ȴ�ˤȡ������Ǥ�ʬ����
                $total_amount = Total_Amount($data_h["$fw_day"]["�����"], $data_h["$fw_day"]["���Ƕ�ʬ"], $coax,$tax_franct,$tax_num, $client_id, $db_con);
                $net_amount_h = $total_amount[0]; //�����
                $tax_amount_h = $total_amount[1]; //������

                //����إå��ơ��֥���Ͽ
                $insert_sql  = " INSERT INTO t_aorder_h (\n";
                $insert_sql .= "    aord_id,\n";
                $insert_sql .= "    ord_no,\n";
                $insert_sql .= "    fc_ord_id,\n";
                $insert_sql .= "    ord_time,\n";
                $insert_sql .= "    client_id,\n";
                $insert_sql .= "    direct_id,\n";
                $insert_sql .= "    trade_id,\n";
                $insert_sql .= "    green_flg,\n";
                $insert_sql .= "    trans_id,\n";
                $insert_sql .= "    hope_day,\n";
                if($defd_ymd != "--"){
                //if($defd_ymd != null || $defd_ymd != "00000000"){
                    $insert_sql .= "    def_arrival_day,\n";
                }
                $insert_sql .= "    arrival_day,\n";
                $insert_sql .= "    note_my,\n";
                $insert_sql .= "    note_your,\n";
                $insert_sql .= "    ware_id,\n";
                $insert_sql .= "    ord_staff_id,\n";
                $insert_sql .= "    ps_stat,\n";
                $insert_sql .= "    c_staff_id,\n";
                $insert_sql .= "    cost_amount,\n";
                $insert_sql .= "    net_amount,\n";
                $insert_sql .= "    tax_amount,\n";
                $insert_sql .= "    shop_id,\n";
//              $insert_sql .= "    shop_gid";
//������
                $insert_sql .= "    client_name,\n";
                $insert_sql .= "    client_name2,\n";
                $insert_sql .= "    client_cname,\n";
                $insert_sql .= "    client_cd1,\n";
                $insert_sql .= "    client_cd2,\n";
                $insert_sql .= "    direct_name,\n";
                $insert_sql .= "    direct_name2,\n";
                $insert_sql .= "    direct_cname,\n";
                $insert_sql .= "    trans_name,\n";
                $insert_sql .= "    trans_cname,\n";
                $insert_sql .= "    ware_name,\n";
                $insert_sql .= "    c_staff_name,\n";
                $insert_sql .= "    ord_staff_name, \n";    
                $insert_sql .= "    claim_id, \n";
                $insert_sql .= "    claim_div \n";
                $insert_sql .= " )values(\n";
                $insert_sql .= "    (SELECT COALESCE(MAX(aord_id), 0)+1 FROM t_aorder_h),\n";
                $insert_sql .= "    '$order_no_pad',\n";
                $insert_sql .= "    $g_ord_id,\n";
                $insert_sql .= "    '$ord_day',\n";
                $insert_sql .= "    $aord_client_id,\n";
                $insert_sql .= "    $direct_id,\n";
                $insert_sql .= "    '$trade_id',\n";
                if($green == "1"){
                    $insert_sql .= "    't',\n";
                }else{
                    $insert_sql .= "    'f',\n";
                }
                $insert_sql .= "    $trans_id,\n";
                if($hope_day == NULL){
                    $insert_sql .= "    NULL,\n";
                }else{
                    $insert_sql .= "    '$hope_day',\n";
                }
                if($defd_ymd != "--"){
                //if($defd_ymd != null || $defd_ymd != "00000000"){
                    $insert_sql .= "    '$defd_ymd',\n";
                }
                $insert_sql .= "    '$fw_day',\n";
//                $insert_sql .= "    '$def_note_my',\n";
                $insert_sql .= "    (SELECT note_your FROM t_order_h WHERE ord_id = $g_ord_id), \n";
                $insert_sql .= "    '$note_your',\n";
                $insert_sql .= "    $ware_id,\n";
                $insert_sql .= "    $staff_id,\n";
                $insert_sql .= "    '1',\n";
                $insert_sql .= "    $c_staff_id,\n";
                $insert_sql .= "    $cost_amount_h,\n";
                $insert_sql .= "    $net_amount_h,\n";
                $insert_sql .= "    $tax_amount_h,\n";
                $insert_sql .= "    $s_client_id,\n";
                $insert_sql .= "    (SELECT client_name FROM t_client WHERE client_id = $aord_client_id), \n";  //������̾������
                $insert_sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $aord_client_id), \n"; //������̾��������
                $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $aord_client_id), \n"; //ά��������
                $insert_sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $aord_client_id), \n";   //�����襳���ɣ�������
                $insert_sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $aord_client_id), \n";   //�����襳���ɣ�������
                $insert_sql .= "    (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id),\n";        //ľ����̾������
                $insert_sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), \n";      //ľ����̾��������
                $insert_sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), \n";      //ľ����(ά��)������
                $insert_sql .= "    (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), \n";           //�����ȼ�������
                $insert_sql .= "    (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), \n";          //�����ȼ�(ά��)������
                $insert_sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), \n";               //�Ҹ�ID������
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $c_staff_id),\n";          //����ô����������
                $insert_sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $staff_id),\n";             //ȯ��ô����������
                $insert_sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $aord_client_id AND claim_div = '1'), \n"; //������ID
                $insert_sql .= "    '1' \n";                                                                    //�������ʬ
//                $insert_sql .= "    $s_shop_gid";
                $insert_sql .= " );\n";

                $result = Db_Query($db_con, $insert_sql);
/*
                $result = Db_Query($db_con, $insert_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
*/
                //ȯ���ֹ椬��ʣ�������Ϻ��ٺ��֤��ʤ���
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_h_ord_no_key";

                    Db_Query($db_con, "ROLLBACK;");
                    if(strstr($err_message, $err_format) != false){
                        $error = "Ʊ���˼����Ԥä����ᡢ����NO����ʣ���ޤ������⤦���ټ���򤷤Ʋ�������";

                        //����ȯ��NO���������
                        $sql  = "SELECT ";
                        $sql .= "   MAX(ord_no)";
                        $sql .= " FROM";
                        $sql .= "   t_aorder_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $s_client_id";
                        $sql .= ";";

                        $result = Db_Query($db_con, $sql);
                        $order_no = pg_fetch_result($result, 0 ,0);
                        $order_no = $order_no +1;
                        $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                        $set_data["form_order_no"] = $order_no;

                        $form->setConstants($set_data);

                        $duplicate_flg = true;
                        break;
                    }else{
                        exit;
                    }
                }

                //��ɼ�ֹ�
//                (int)$auto_order_no ++;
                (int)$ord_no ++;

                /********************************/
                //����ǡ�����Ͽ
                /********************************/
                $line = 0;
                //$fw_day �˽вپ���ʬ�롼�׽���
                while( $fw_goods_id = array_shift($data_d[$fw_day]["good_id"])){

                    //�вپ��ʤ����Ϲ�
                    $fw_goods_line = array_shift($data_d[$fw_day]["line"]);

                    //�����ֹ椬��ʣ�������ϰʲ��ν����ϼ¹Ԥ��ʤ�
                    if($duplicate_flg == true){
                        break;
                    }

                    $tax_div       = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][tax_div];     //���Ƕ�ʬ
                    $num           = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][num];         //�вٿ�
                    $cost_price    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][cost_price];  //����ñ��
                    $sale_price    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][sale_price];  //���ñ��
                    //print_array ($data_d);

//��۷׻��κݤ����ٴؿ������褦����Ƥ��ʤ�
/*
                    $cost_amount   = $num * $cost_price;                          //�������
                    $sale_amount   = $num * $sale_price;                          //�����
*/
                    $cost_amount   = bcmul($num, $cost_price, 1);
                    $cost_amount   = Coax_Col($coax, $cost_amount);
                    $sale_amount   = bcmul($num, $sale_price, 1);
                    $sale_amount   = Coax_Col($coax, $sale_amount);
                    $goods_name    = $data_d[$fw_day][$fw_goods_id."-".$fw_goods_line][goods_name];  //����̾
                    $line++;       //�Կ�

                    //������
    //                $tax = Total_Amount($sale_price, $tax_div,$coax,$tax_franct,$tax_num);
                    #echo $tax[1]."<br>"; //������

                   //����ǡ����ơ��֥���Ͽ
                   $insert_sql  = " INSERT INTO t_aorder_d (";
                   $insert_sql .= "    aord_d_id,";
                   $insert_sql .= "    aord_id,";
                   $insert_sql .= "    line,";
                   $insert_sql .= "    sale_div_cd,";
                   $insert_sql .= "    goods_id,";
                   $insert_sql .= "    official_goods_name,";
                   $insert_sql .= "    num,";
                   $insert_sql .= "    tax_div,";
                   $insert_sql .= "    cost_price,";
                   $insert_sql .= "    sale_price,";
                   $insert_sql .= "    cost_amount,";
                   $insert_sql .= "    sale_amount, ";
                   $insert_sql .= "    goods_cd ";
    //               $insert_sql .= "    tax_amount";
                   $insert_sql .= " )VALUES(";
                   $insert_sql .= "    (SELECT COALESCE(MAX(aord_d_id), 0)+1 FROM t_aorder_d),";
                   $insert_sql .= "    (SELECT aord_id FROM t_aorder_h WHERE fc_ord_id = '$g_ord_id' AND arrival_day = '$fw_day'),";
                   $insert_sql .= "    $line,";
                   $insert_sql .= "    '02',";
                   $insert_sql .= "    $fw_goods_id,";
                   $insert_sql .= "    '$goods_name',";
                   //$insert_sql .= "    (SELECT goods_name FROM t_order_d WHERE ord_id = $g_ord_id AND line = $line),";
                   $insert_sql .= "    $num,";
                   $insert_sql .= "    $tax_div,";
                   $insert_sql .= "    $cost_price,";
                   $insert_sql .= "    $sale_price,";
                   $insert_sql .= "    $cost_amount,";
                   $insert_sql .= "    $sale_amount, ";
                   $insert_sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $fw_goods_id) ";
    //               $insert_sql .= "    $tax[1]";
                   $insert_sql .= " );";
                   $result = Db_Query($db_con, $insert_sql);
                   //$result = Db_Query($db_con, $insert_sql,1);

                   if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }
                    //����ǡ���ID���� 
                   $select_sql = " SELECT";
                   $select_sql .= "    t_aorder_d.aord_d_id";
                   $select_sql .= " FROM";
                   $select_sql .= "    t_aorder_h,";
                   $select_sql .= "    t_aorder_d";
                   $select_sql .= " WHERE";
                   $select_sql .= "    t_aorder_h.aord_id = t_aorder_d.aord_id";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_h.fc_ord_id = $g_ord_id";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_h.arrival_day = '$fw_day'";
                   $select_sql .= " AND";
                   $select_sql .= "    t_aorder_d.goods_id = $fw_goods_id";
                   $select_sql .= " ;";
                   $result = Db_Query($db_con, $select_sql);
                   $aord_d_id = @pg_fetch_result($result, 0 ,0);
 
                  if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }

                   //�߸˼�ʧ�ơ��֥��INSERT
                   $insert_sql = " INSERT INTO t_stock_hand(";
                   $insert_sql .= "    goods_id,";
                   $insert_sql .= "    enter_day,";
                   $insert_sql .= "    work_day,";
                   $insert_sql .= "    work_div,";
                   $insert_sql .= "    client_id,";
                   $insert_sql .= "    ware_id,";
                   $insert_sql .= "    io_div,";
                   $insert_sql .= "    num,";
                   $insert_sql .= "    slip_no,";
                   $insert_sql .= "    aord_d_id,";
                   $insert_sql .= "    shop_id,";
                   $insert_sql .= "    staff_id,";
                   $insert_sql .= "    client_cname";
                   $insert_sql .= " )values(";
                   $insert_sql .= "    $fw_goods_id,";
                   $insert_sql .= "    NOW(),";
                   $insert_sql .= "    '$ord_day',";
                   $insert_sql .= "    '1',";
                   $insert_sql .= "    $aord_client_id,";
                   $insert_sql .= "    $ware_id,";
                   $insert_sql .= "    '2',";
                   $insert_sql .= "    $num,";
                   $insert_sql .= "    '$order_no_pad',";
                   $insert_sql .= "    $aord_d_id,";
                   $insert_sql .= "    $s_client_id,";
                   $insert_sql .= "    $staff_id,";
                   $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $aord_client_id)";
                   $insert_sql .= " );";
                   $result = Db_Query($db_con, $insert_sql);
                   if($result === false){
                       Db_Query($db_con, "ROLLBACK;");
                       exit;
                   }
                }
            }

            if($duplicate_flg != true){
                //ȯ��إå��ơ��֥빹��
                $update_sql = " UPDATE t_order_h";
                $update_sql .= " SET ";
                $update_sql .= "    arrival_day = ";
                $update_sql .= " (SELECT";
                $update_sql .= "    MIN(arrival_day)";
                $update_sql .= "  FROM";
                $update_sql .= "    t_aorder_h";
                $update_sql .= "  WHERE";
                $update_sql .= "    fc_ord_id = $g_ord_id";
                $update_sql .= " ),";
                $update_sql .= "    ord_stat = '2', ";
                $update_sql .= "    trans_id = $trans_id ";
                $update_sql .= " WHERE ";
                $update_sql .= "    ord_id = '$g_ord_id'";
                $update_sql .= ";";
                $result = Db_Query($db_con, $update_sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                Db_Query($db_con, "COMMIT;");
                header("Location: ./1-2-108.php?fc_ord_id=$g_ord_id");
            }
        }else{
            //��Ͽ��ǧ���̤�ɽ���ե饰
            $comp_flg = true;
        }
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
if($comp_flg != true){

    $button[] = $form->createElement("submit","entry","��Ͽ���ֿ���ǧ���̤�","$disabled");
    $button[] = $form->createElement(
            "submit","alert_ok","�ٹ��̵�뤷����Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled"
            );
    if($_GET["return_flg"] == 1){
        $button[] = $form->createElement(
            "button","back","�ᡡ��","onClick=\"location.href='./1-2-102.php?search=1'\""
            );
    }elseif($_GET["retrun_flg"] == 2){
        $button[] = $form->createElement(
            "button","back","�ᡡ��","onClick=\"location.href='./1-2-105.php?search=1'\""
            );
    }

    $form->addGroup($button, "button", "");

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //���
    $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
    //OK
    $form->addElement("submit","comp_button","��Ͽ���ֿ�OK","$disabled");
    
    $form->freeze();
}

//�ƹԤνвٿ�ʬ�����Ǥ��������
for($x=0;$x<count($array_count);$x++){
    for($j=0;$j<=$array_count[$x];$j++){
        $disp_count[$x][$j] = "a";
    }
}

//�ʥ�С��ե����ޥå���
for($i = 0; $i < count($order_d_data); $i++){
    $order_d_data[$i][2]  = htmlspecialchars($order_d_data[$i][2]);

    //���������ê�����¿����硢�������֤�����
    if($order_d_data[$i][12] < $order_d_data[$i][3]){
        $tmp  = "<font color=\"red\">";
        $tmp .= (string)number_format($order_d_data[$i][3]);
        $tmp .= "</font>";
    }else{
        $tmp  = number_format($order_d_data[$i][3]);
    }
    $order_d_data[$i][3] = $tmp;

    $order_d_data[$i][4]  = number_format($order_d_data[$i][4],2);
//    $order_d_data[$i][4]  = number_format($order_d_data[$i][4],2);
    $order_d_data[$i][5]  = number_format($order_d_data[$i][5],2);
    $order_d_data[$i][6]  = number_format($order_d_data[$i][6]);
    $order_d_data[$i][7]  = number_format($order_d_data[$i][7]);
    $order_d_data[$i][9]  = number_format($order_d_data[$i][9],2);
    $order_d_data[$i][10] = number_format($order_d_data[$i][10]);
    $order_d_data[$i][12] = My_number_format($order_d_data[$i][12]);
    $order_d_data[$i][13] = My_number_format($order_d_data[$i][13]);
    $order_d_data[$i][14] = number_format($order_d_data[$i][14]);
    $order_d_data[$i][15] = number_format($order_d_data[$i][15]);
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
$page_menu = Create_Menu_h('sale','1');
/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('row',$order_d_data);
$smarty->assign('stock',$stock_data);
$smarty->assign('num',$select_page_arr);
$smarty->assign('disp_count',$disp_count);

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'fc_ord_id'         => "$fc_ord_id",
    'hope_day'          => "$hope_day",
    'green'             => "$green",
    'client_name'       => "$client_name",
    'direct_name'       => "$direct_name",
    'note_my'           => "$note_my",
    'forward_num'       => "$forward_num",
    'num'               => "$num",
    'form_ord_day_err'  => "$form_ord_day_err",
    'forward_day_err'   => "$forward_day_err",
    'forward_num_err'   => "$forward_num_err",
    'alert_message'     => "$alert_message",
    'alert_output'      => "$alert_output",
    'form_def_day_err'  => "$form_def_day_err",
    'comp_flg'          => "$comp_flg",
    'error'             => "$error",
    'price_warning'     => "$price_warning",
    'client_cd'         => "$client_cd",
));
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

/*
print "<pre>";
print_r($_POST);
print "</pre>";
*/
?>
