<?php
$page_title = "ȯ������";

/***********�ѹ�����(2006/4/4)****************/
//������ñ��Ⱦ�ѿ��������å����ʸ�ѹ�
//�����ʽ�ʣ�����å����ʸ�ѹ�
//��t_order_d��INSERT���ξ���ɲ�
/**********************************************/
/***********�ѹ�����(2006/5/17)****************/
//���ɲá���������ʥ��������Ϥκݤˡ����������뤷�ʤ����ѹ�
//��ȯ����˥ե꡼���������̤�ɽ�����ơ�������DB����Ͽ���ѹ�
//������Ԥϡ����顼Ƚ�ꤷ�ʤ��褦���ѹ�
//���ɲå�󥯤�ܥ�����ѹ�
//����Ͽ������ܥ��󤫤����ܤ������ˡ�ȯ������ѹ���ǽ�ˤ���
/**********************************************/
/***********�ѹ�����(2006/5/25)****************/
//���ե꡼���������̤ˡ���ǧ��å�������ɽ��
//��������󥯤˥ե���������������ʤ��褦���ѹ�
/**********************************************/
/***********�ѹ�����(2006/07/07)***************/
//kaji
//��shop_gid��ʤ���
/**********************************************/
/***********�ѹ�����(2006/07/07)***************/
//koji
//��ȯ�������ѹ���ǽ���ѹ�
/**********************************************/
/***********�ѹ�����(2006/07/31)***************/
//watanabe-k
//�������Ǥη׻���ˡ�ѹ�
/**********************************************/
/***********�ѹ�����(2006/08/07)***************/
//watanabe-k
//��������ȯ����������ȯ����������Ͽ���ʤ��Х��ν���
/**********************************************/
/***********�ѹ�����(2006/09/20)***************/
// fukuda-sss
//�����½�������
/**********************************************/
/***********�ѹ�����(2006/10/12)***************/
// watanabe-k
//��ά����Ͽ
/**********************************************/
/*�ѹ�����***************
 *   2006/12/01 (suzuki)
 *     ��������۷׻������ѹ�
 *     ���������ѹ����˾��ʽ����
*************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/17��06-007��������watanabe-k��ȯ�����ϲ��̤Ǿ���̾��֥�󥯤ˤ���ȯ����Ԥ��ȡ־��ʤ���Ĥ����򤵤�Ƥ��ޤ���פȥ�å��������Ǥ롣
 * ��2006/10/18��06-016��������watanabe-k���߸˾Ȳ�ȯ�����Ϥز������ܤ��ƾ��ν��ɽ�������򤷤Ƥ������ʤ�ɽ������Ƥ��ʤ��Х��ν�����
 * ��2006/10/18��06-014��������watanabe-k��ȯ�����ϲ��̤�������FC��ʸ�����ۤʤ�Х��ν���
 * ��2006/10/18��06-017��������watanabe-k��ȯ�����ϲ��̤Ǳ����ȼԤ����򤷤�ȯ����Ԥ���SQL���顼��ɽ�������Х��ν���
 * ��2006/10/18��06-018��������watanabe-k�������ʾ��ʥ����ɤ����Ϥ��Ƥ⥨�顼��å�������ɽ������ʤ��Х��ν���
 * ��2006/10/18��06-019��������watanabe-k�������ʻ���ñ�������Ϥ��Ƥ⥨�顼��å�������ɽ������ʤ��Х��ν���
 * ��2006/10/18��06-022��������watanabe-k��ȯ�����Υ��顼��å�������������FC�ǰۤʤ�Х��ν���
 * ��2006/10/18��06-032��������watanabe-k�������ƥ೫���������������ȯ�����Ǥ��Ƥ��ޤ��Х��ν���
 * ��2006/10/18��06-033��������watanabe-k����ۤξ������ʲ���֥�󥯤ˤ���ȯ������ȥ��顼��ɽ�������Х��ν���
 * ��2006/10/18  06-024        watanabe-k  Ʊ��������Ԥ��ȥ��顼�ˤʤ�Х��ν���
 * ��2006/10/18  06-039        watanabe-k  URL����SQL���顼��ɽ�������Х��ν���
 * ��2006/10/19  06-041        watanabe-k  ���ʥ����ɤ��������Ϥ����ե����������ư���ʤ��ޤ�ȯ����ǧ���̤إܥ���򥯥�å�����ȡ���ǧ���̤����ܤ��Ƥ��ޤ���
 * ��2006/10/19  06-045        watanabe-k  �����襳���ɤ��������Ϥ����ե����������ư���ʤ��ޤ�ȯ����ǧ���̤إܥ���򥯥�å�����ȡ���ǧ���̤����ܤ��Ƥ��ޤ���
 * ��2006/11/11  06-092        watanabe-k  ����̾��ɽ��������Ƥ��ʤ��Х��ν���
 * ��2006/11/11  06-097        watanabe-k  �����ѹ����ȯ�����ѹ��Ǥ��Ƥ��ޤ��Х��ν���
 * ��2006/11/11  wat-0134      watanabe-k  ���ɽ�����������٤�¹Ԥ����Х��ν���
 * ��2007/01/31                watanabe-k  ȯ�����ľ����������ֹ��Ĥ��褦�˽���
 * ��2007/02/06                watanabe-k  ȯ������ɽ�����ʤ��褦�˽��� 
 *   2007/02/21                watanabe-k  ���ɽ�����Ҹˤ�����Ҹˤ��ѹ�  
 *   2007/02/27                morita-d    ����̾������̾��ɽ������褦�˽���  
 *   2007/03/13                watanabe-k   ���ʤν�ʣ���򥨥顼�����Ū��ɽ������褦�˽���
 *   2007/04/06                watanabe-k  ��ä��줿ȯ���������Ͽ����ȥ����ꥨ�顼��ɽ�������Х��ν���
 *   2007/05/18                watanabe-k  ľ����Υץ������������ե���Ȥ˽���
 *   2007/07/13                watanabe-k  �������ηٹ�ɽ�������Х��ν��� 
 *   2007/08/01                watanabe-k  �ܵҶ�ʬ�����ɤ��ü�ξ���FC���Ф���ȯ���Ǥ��������ʤ���Ѥ��Τ��ˤ���褦�˽��� 
 * 	 2009/06/17	����No.13	   aizawa-m	   �߸˾Ȳ�Υ����Ȥ�Ʊ�������ѹ�
 *				�������ޤ�	   aizawa-m	   ���ֻ̡�����ۡפΥǥե���Ȥ�0�ǽ��Ϥ���褦���ѹ�
 *   2009/09/07                aoyama-n    �Ͱ���ǽ�ɲ�
 *   2009/09/07                aoyama-n    �вٲ�ǽ����θ�����ϻ���SQL���顼����
 *   2009/09/07                aoyama-n    �вٲ�ǽ����θ�����ϻ��Ǿ���̾�˾���ʬ�बɽ������ʤ��Զ�罤��
 *   2009/09/15                hashimoto-y ���ʤ��Ͱ������ֻ�ɽ���˽���
 *   2009/10/12                hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   2009/12/21                aoyama-n    ��Ψ��TaxRate���饹�������
 */

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_buy.inc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"], null, "onSubmit=return confirm(true)");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("ord");
}

/****************************/
//�����ѿ�����
/****************************/
//$shop_gid = $_SESSION["shop_gid"];
$shop_id    = $_SESSION["client_id"];
$rank_cd    = $_SESSION["rank_cd"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];

//�ܵҶ�ʬ���ü�ξ��
if($rank_cd == '0055'){
    $furein_flg = true;
}


//����ID
if(count($_GET["order_goods_id"]) > 0){
    $get_goods_id = $_GET["order_goods_id"];
    Get_Id_Check3($_GET["order_goods_id"]);
    $get_flg = true;
}

//����ID�����򤵤�Ƥ���Ȥ��������å�
//if($_POST["hdn_goods_id"][$i] != NULL){
if(count($_POST["hdn_goods_id"]) > 0){
    $goods_id = $_POST["hdn_goods_id"];
}
//ȯ��ID�����
$order_id = $_POST["hdn_order_id"];
if($_GET["ord_id"] != null){
    $order_id = $_GET["ord_id"];
    Get_Id_Check3($_GET["ord_id"]);
    $update_flg = true;
}

//�оݾ���
if($_GET["target_goods"] != NULL){
    Get_Id_Check3($_GET["target_goods"]);
    $set_id_data["hdn_target"] = $_GET["target_goods"];
    $get_target_goods = $_GET["target_goods"];
    $form->setConstants($set_id_data);
}else{
    $get_target_goods = $_POST["hdn_target"];
}
/*
//������FCȽ��
if($get_target_goods == 1){
    $head_flg = 't';
}else{
    $head_flg = 'f';
}
$head_fc_data["head_flg"] = $head_flg;
$form->setConstants($head_fc_data);
*/
//�вٲ�ǽ����
if($_GET["designated_date"] != NULL){
    Get_Id_Check3($_GET["designated_date"]);
    $set_id_data["hdn_design"] = $get_designated_date;
    $form->setConstants($set_id_data);
}else{
    $get_designated_date = $_POST["hdn_design"];
}
/****************************/
//�������
/****************************/

#2009-12-21 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

//ɽ���Կ�
if($_POST["max_row"] != null){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}

//���ɽ�������ѹ�
$form_position = "<body bgcolor=\"#D8D0C8\">";

//����Կ�
$del_history[] = null;

//�����褬���ꤵ��Ƥ��뤫
if($_POST["hdn_client_id"] == null || $_POST["hdn_client_id"] == ""){
    $warning = "����������򤷤Ƥ���������";
}elseif($_POST["hdn_client_id"] != null){
    $client_search_flg = true;

    $head_flg = $_POST["head_flg"];

    if($head_flg == 't'){
        $message = "�������ʤΤ����ϲ�ǽ�Ǥ���";
    //�ܵҶ�ʬ�����ɤ��ü�ξ��
    }elseif($furein_flg === true){
        $message = "���ʤ����ϲ�ǽ�Ǥ���";
    }else{
        $message = "�������ʰʳ������ϲ�ǽ�Ǥ���";
    }

    $client_id  = $_POST["hdn_client_id"];
    $head_flg   = $_POST["head_flg"];
    $coax       = $_POST["hdn_coax"];
    $tax_franct = $_POST["hdn_tax_franct"];
}

//��ʬ�ξ����ǳۤ����
#2009-12-21 aoyama-n
#$sql  = "SELECT";
#$sql .= "   tax_rate_n";
#$sql .= " FROM";
#$sql .= "   t_client";
#$sql .= " WHERE";
#$sql .= "   client_id = $shop_id";
#$sql .= ";";

#$result = Db_Query($conn, $sql);
#$tax_rate = pg_fetch_result($result,0,0);
#$rate  = bcdiv($tax_rate,100,2);                //������Ψ

/****************************/
//�Ժ������
/****************************/
if($_POST["del_row"] != NULL){
    $now_form = null;
    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
    //��������Կ�
    $del_num     = count($del_history)-1;
}

/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+5;

    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);

}

/***************************/
//���������
/***************************/
//�вٲ�ǽ��
$def_data["form_designated_date"] = 7;

//ô����
$def_data["form_staff"] = $staff_id;

//�����ʬ
$def_data["form_trade"] = 21;

//ȯ����
$def_data["form_order_day"]["y"] = date("Y");
$def_data["form_order_day"]["m"] = date("m");
$def_data["form_order_day"]["d"] = date("d");

//��ư���֤�ȯ���ֹ����
$sql  = "SELECT";
$sql .= "   MAX(ord_no)";
$sql .= " FROM";
$sql .= "   t_order_h";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$order_no = pg_fetch_result($result, 0 ,0);
$order_no = $order_no +1;
$order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

$def_data["form_order_no"] = $order_no;

//�Ҹ�
/*
$sql  = "SELECT";
$sql .= "   ware_id";
$sql .= " FROM";
$sql .= "   t_client";
$sql .= " WHERE";
$sql .= "   client_id = $shop_id";
$sql .= ";";
$result = Db_Query($conn, $sql);
$def_ware_id = pg_fetch_result($result ,0,0);
*/
$def_ware_id = Get_ware_id($conn, Get_Branch_Id($conn));
$def_data["form_ware"] = $def_ware_id;

$form->setDefaults($def_data);

//��ê����󥯤��ͤ򥻥å�&�߸˴����ե饰����
$const_data["form_stock_num"] = $_POST["hdn_stock_num"];

$form->setConstants($const_data);

$stock_num = $_POST["hdn_stock_num"];
$stock_manage = $_POST["hdn_stock_manage"];
$name_change = $_POST["hdn_name_change"];
/****************************/
//�ѹ��ե饰��true�ξ��
/****************************/
//if($update_flg == true){
if($update_flg == true && $_POST["hdn_first_set"] == null){
    //ȯ���إå��������
    $sql  = "SELECT";
    $sql .= "   t_order_h.ord_no,";
    $sql .= "   to_date(t_order_h.ord_time,'YYYY-MM-DD'),";
    $sql .= "   t_order_h.hope_day,";
    $sql .= "   t_order_h.arrival_day,";
    $sql .= "   t_order_h.green_flg,";
    $sql .= "   t_order_h.trans_id,";
    $sql .= "   t_client.client_id,";
    $sql .= "   t_client.client_cd1,";
    $sql .= "   t_client.client_cname,";
    $sql .= "   t_client.coax,";
    $sql .= "   t_client.tax_franct,";
    $sql .= "   t_client.head_flg,";
    $sql .= "   t_order_h.direct_id,";
    $sql .= "   t_order_h.ware_id,";
    $sql .= "   t_order_h.trade_id,";
    $sql .= "   t_order_h.c_staff_id,";
    $sql .= "   t_order_h.note_your,";
    $sql .= "   t_order_h.ord_stat,";
    $sql .= "   to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') AS send_date,";
    $sql .= "   t_order_h.enter_day";
    $sql .= " FROM ";
    $sql .= "   t_order_h";
    $sql .= "   INNER JOIN t_client";
    $sql .= "   ON t_order_h.client_id = t_client.client_id";
    $sql .= " WHERE";
    $sql .= "   ord_id = $order_id";
    $sql .= "   AND";
    $sql .= "   t_order_h.shop_id = $shop_id";
    $sql .= "   AND";
    $sql .= "   (ord_stat = '3' OR (ord_stat IS NULL AND ps_stat = '1'))";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $update_data = pg_fetch_array($result, 0);

    //�����ե饰Ƚ��
    if($update_data[11] == 't'){
        $message = "�������ʤΤ������ǽ�Ǥ���";
        $head_flg = 't';
    }else{
        $message = "�������ʰʳ��������ǽ�Ǥ���";
        $head_flg = 'f';
    }

    //����������ե饰
    $client_search_flg = true;
    $warning           = null;

    //��������
    $update_order_day       = explode('-',$update_data[1]);
    $update_hope_day        = explode('-',$update_data[2]);
    $update_arrival_day     = explode('-',$update_data[3]);

    //������ID
    $client_id = $update_data[6];

    //�ǡ������å�
    $set_update_data["form_order_no"]           = $update_data[0];              //ȯ���ֹ�
    $set_update_data["form_order_day"]["y"]     = $update_order_day[0];         //ȯ������ǯ��
    $set_update_data["form_order_day"]["m"]     = $update_order_day[1];         //ȯ�����ʷ��
    $set_update_data["form_order_day"]["d"]     = $update_order_day[2];         //ȯ����������
    $set_update_data["form_hope_day"]["y"]      = $update_hope_day[0];          //��˾Ǽ����ǯ��
    $set_update_data["form_hope_day"]["m"]      = $update_hope_day[1];          //��˾Ǽ���ʷ��
    $set_update_data["form_hope_day"]["d"]      = $update_hope_day[2];          //��˾Ǽ��������
    $set_update_data["form_arrival_day"]["y"]   = $update_arrival_day[0];       //����ͽ������ǯ��
    $set_update_data["form_arrival_day"]["m"]   = $update_arrival_day[1];       //����ͽ�����ʷ��
    $set_update_data["form_arrival_day"]["d"]   = $update_arrival_day[2];       //����ͽ����������
    if($head_flg == 't'){
        $set_update_data["form_trans"]          = ($update_data[4] == 't')? 1 : null;              //���꡼�����ȼ�
    }else{
        $set_update_data["form_trans"]          = $update_data[5];              //�����ȼ�
    }
    $set_update_data["hdn_client_id"]           = $update_data[6];              //������ID
    $set_update_data["form_client"]["cd"]       = $update_data[7];              //�����襳����
    $set_update_data["form_client"]["name"]     = $update_data[8];              //������̾
    $set_update_data["hdn_coax"]                = $update_data[9];              //��ۡʴݤ��ʬ��
    $set_update_data["hdn_tax_franct"]          = $update_data[10];             //������ü��
    $set_update_data["head_flg"]                = $update_data[11];             //�����ե饰
    $set_update_data["form_direct"]             = $update_data[12];             //ľ����
    $set_update_data["form_ware"]               = $update_data[13];             //�Ҹ�
    $set_update_data["form_trade"]              = $update_data[14];             //�����ʬ
    $set_update_data["form_staff"]              = $update_data[15];             //ô����
    $set_update_data["form_note_your"]            = $update_data[16];             //�̿���ʻ����谸��
    $set_update_data["hdn_order_id"]            = $order_id;
    //$set_update_data["form_send_date"]          = $update_data["send_date"];
    $set_update_data["hdn_ord_enter_day"]       = $update_data["enter_day"];    //��Ͽ��

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "   coax,";
    $sql .= "   tax_franct";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $coax = pg_fetch_result($result, 0,0 );
    $tax_franct = pg_fetch_result($result, 0, 1);

    //ȯ���ǡ����������
    $sql  = "SELECT ";
    $sql .= "   t_goods.goods_id,";
    $sql .= "   t_goods.name_change,";
    #2009-10-12 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";
    $sql .= "   t_goods_info.stock_manage,";

    $sql .= "   t_order_d.goods_cd,";
    $sql .= "   t_order_d.goods_name,";
    #2009-10-12 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num, ";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num, ";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";

    $sql .= "   END AS allowance_total,";
    $sql .= "   COALESCE(t_stock.stock_num,0)";
    $sql .= "   + COALESCE(t_stock_io.order_num,0)";
    $sql .= "   - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,";
    $sql .= "   t_order_d.num,";
    $sql .= "   t_order_d.buy_price,";
    $sql .= "   t_order_d.tax_div,";
    $sql .= "   t_order_d.buy_amount,";
    //aoyama-n 2009-09-07
    #$sql .= "   t_goods.in_num";
    $sql .= "   t_goods.in_num,";
    $sql .= "   t_goods.discount_flg";
    $sql .= " FROM ";
    $sql .= "   t_order_d";
    $sql .= "   INNER JOIN ";
    $sql .= "   t_order_h";
    $sql .= "   ON t_order_d.ord_id = t_order_h.ord_id ";
    $sql .= "   INNER JOIN ";
    $sql .= "   t_goods ";
    $sql .= "   ON t_order_d.goods_id = t_goods.goods_id";
    $sql .= "   LEFT JOIN ";

    //�߸˿�
    $sql .= "   (SELECT ";
    $sql .= "   t_stock.goods_id,";
    $sql .= "   SUM(t_stock.stock_num)AS stock_num, ";
    $sql .= "   SUM(t_stock.rstock_num)AS rstock_num";
    $sql .= "   FROM t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id";
    $sql .= "   WHERE t_stock.shop_id = $shop_id";
    $sql .= "   AND t_ware.count_flg = 't'";
    $sql .= "   GROUP BY t_stock.goods_id";
    $sql .= "   )AS t_stock ";
    $sql .= "   ON t_order_d.goods_id = t_stock.goods_id";
    $sql .= "   LEFT JOIN";

    //ȯ���Ŀ�
    $sql .= "   (SELECT t_stock_hand.goods_id,";
    $sql .= "   SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num ";
    $sql .= "   FROM t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
    $sql .= "   WHERE t_stock_hand.work_div = 3 ";
    $sql .= "   AND t_stock_hand.shop_id =  $shop_id";
    $sql .= "   AND t_ware.count_flg = 't'";
    $sql .= "   AND  t_stock_hand.work_day <= (CURRENT_DATE + 7)";      
    $sql .= "   GROUP BY t_stock_hand.goods_id";
    $sql .= "   ) AS t_stock_io";
    $sql .= "   ON t_order_d.goods_id=t_stock_io.goods_id";

    $sql .= "   LEFT JOIN";

    //������
    $sql .= "   (SELECT t_stock_hand.goods_id,";
    $sql .= "   SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num";
    $sql .= "   FROM t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
    $sql .= "   WHERE t_stock_hand.work_div = 1";
    $sql .= "   AND t_stock_hand.shop_id =  $shop_id";
    $sql .= "   AND t_ware.count_flg = 't'";
    $sql .= "   AND  t_stock_hand.work_day <= (CURRENT_DATE + 7)";
    $sql .= "   GROUP BY t_stock_hand.goods_id";
    $sql .= "   ) AS t_allowance_io";
    $sql .= "   ON t_order_d.goods_id = t_allowance_io.goods_id";
    #2009-10-12 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

    $sql .= " WHERE";
    $sql .= "   t_order_d.ord_id = $order_id";
    $sql .= "   AND";
    $sql .= "   t_order_h.shop_id = $shop_id";
    #2009-10-12 hashimoto-y
    $sql .= "   AND ";
    $sql .= "   t_goods_info.shop_id = $shop_id ";

    $sql .= " ORDER BY t_order_d.line";
    $sql .= ";";


    $result                 = Db_Query($conn, $sql);
    $num                    = pg_num_rows($result);
    for($i = 0; $i < $num; $i++){
        $update_goods_data[]    = pg_fetch_array($result,$i,PGSQL_NUM);
    }

    if($max_row < $num){
        $max_row = $num;
    }

    for($i = 0; $i < $num; $i++){
        //����ñ�����������Ⱦ�������ʬ����
        $price_data = explode('.', $update_goods_data[$i][10]);

        $goods_id[$i] = $update_goods_data[$i][0];

        //���ʤΥǡ�����ե�����˥��å�
        $set_update_data["hdn_goods_id"][$i]            = $update_goods_data[$i][0];        //����ID
        $goods_id[$i]                                   = $update_goods_data[$i][0];
        $set_update_data["hdn_name_change"][$i]         = $update_goods_data[$i][1];        //��̾�ѹ�
        $name_change[$i]                                = $update_goods_data[$i][1];
        $set_update_data["hdn_stock_manage"][$i]        = $update_goods_data[$i][2];        //�߸˴���
        $stock_manage[$i]                               = $update_goods_data[$i][2];        //�߸˴���
        $set_update_data["form_goods_cd"][$i]           = $update_goods_data[$i][3];        //���ʥ�����
        $set_update_data["form_goods_name"][$i]         = $update_goods_data[$i][4];        //����̾
        $set_update_data["form_stock_num"][$i]          = $update_goods_data[$i][5];        //��ê��
        $set_update_data["hdn_stock_num"][$i]           = $update_goods_data[$i][5];        //��ê����hidden�ѡ�
        $stock_num[$i]                                  = $update_goods_data[$i][5];        //��ê��
        $set_update_data["form_rorder_num"][$i]         = ($update_goods_data[$i][6] != null)? $update_goods_data[$i][6] : '0';        //ȯ���Ѥ߿�
        $set_update_data["form_rstock_num"][$i]         = ($update_goods_data[$i][7] != null)? $update_goods_data[$i][7] : '-';        //������
        $set_update_data["form_designated_num"][$i]     = $update_goods_data[$i][8];        //�вٲ�ǽ��
        $set_update_data["form_order_num"][$i]          = $update_goods_data[$i][9];        //ȯ����
        $set_update_data["form_buy_price"][$i]["i"]     = $price_data[0];                    //����ñ������������
        $set_update_data["form_buy_price"][$i]["d"]     = ($price_data[1] != null)? $price_data[1] : "00";    //����ñ���ʾ�������
        $set_update_data["hdn_tax_div"][$i]             = $update_goods_data[$i][11];       //���Ƕ�ʬ
        $set_update_data["form_buy_amount"][$i]         = number_format($update_goods_data[$i][12]);       //�������
        $set_update_data["form_in_num"][$i]             = $update_goods_data[$i][13];
        //aoyama-n 2009-09-07
        $set_update_data["hdn_discount_flg"][$i]        = $update_goods_data[$i][14];       //�Ͱ��ե饰

        //if($update_goods_data[$i][9]%$update_goods_data[$i][13] == 0){
        //������$update_goods_data[$i][13]�ˤǳ��ʤ��Ȥ��Ͻ������̤�ʤ��褦��(kaji)
        if(($update_goods_data[$i][9]%$update_goods_data[$i][13] == 0) && ($update_goods_data[$i][13] != 0 && $update_goods_data[$i][13] != null)){
	        $set_update_data["form_order_in_num"][$i]   = $update_goods_data[$i][9]/$update_goods_data[$i][13];
        }

        //������ۤ����
        $buy_amount[$i] = $update_goods_data[$i][12];
        
        //���Ƕ�ʬ
        $tax_div[$i] = $update_goods_data[$i][11];
    }       

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($update_data[1]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);
        
    $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

    $set_update_data["form_buy_money"]   = $total_amount_data[0];
    $set_update_data["form_tax_money"]   = $total_amount_data[1];
    $set_update_data["form_total_money"] = $total_amount_data[2];

    $form->setConstants($set_update_data);

/****************************/
//ȯ���ٹ𡢺߸˾Ȳ񤫤������
/****************************/
}elseif($get_flg == true  && $client_id == null){
    //�оݾ��ʤ������ξ��
    if($get_target_goods == '1'){
        $sql  = "SELECT";   
        $sql .= "   client_id,";
        $sql .= "   client_cd1,";
        $sql .= "   client_cname,";
        $sql .= "   coax,";
        $sql .= "   tax_franct";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
        //$sql .= "   shop_gid = $shop_gid";
        if($_SESSION[group_kind] == "2"){
            $sql .= "   shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   shop_id = $_SESSION[client_id]";
        }

        $sql .= "   AND";
        $sql .= "   head_flg = 't'";
        $sql .= "   AND";
        $sql .= "   client_div = '2'";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $client_data = pg_fetch_array($result, 0, PGSQL_NUM);

        $client_id = $client_data[0];
        $set_get_data["hdn_client_id"]       = $client_data[0];       //������ID
        $set_get_data["form_client"]["cd"]   = $client_data[1];       //�����襳����
        $set_get_data["form_client"]["name"] = $client_data[2];       //������̾
        $set_get_data["hdn_coax"]            = $client_data[3];       //�ݤ��ʬ
        $coax                                = $client_data[3];       //�ݤ��ʬ
        $set_get_data["hdn_tax_franct"]      = $client_data[4];       //ü����ʬ
        $tax_franct                          = $client_data[4];
        $set_get_data["form_order_day"]["y"] = date("Y");
        $set_get_data["form_order_day"]["m"] = date("m");
        $set_get_data["form_order_day"]["d"] = date("d");

        $head_flg = 't';

        $warning = null;

        $client_search_flg = true;
    }

    //���ʤΥǡ��������
    //GET�Ǽ�������ȯ������ID
    $ary_get_goods_id = implode(',',$get_goods_id); 

    $sql  = "SELECT";
    $sql .= "   t_goods.goods_id,";
    $sql .= "   t_goods.name_change,";
    #2009-10-12 hashimoto-y
    #$sql .= "   t_goods.stock_manage,";
    $sql .= "   t_goods_info.stock_manage,";

    $sql .= "   t_goods.goods_cd,";
    $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
    #2009-10-12 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
    #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,";
    $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0)\n";

    $sql .= "    END AS allowance_total,";
    $sql .= "   COALESCE(t_stock.stock_num,0)";
    $sql .= "    + COALESCE(t_stock_io.order_num,0)";
    $sql .= "    - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,";
    $sql .= "   t_price.r_price,";
    $sql .= "   t_goods.tax_div,";
    //aoyama-n 2009-09-07
    #$sql .= "   t_goods.in_num";
    $sql .= "   t_goods.in_num,";
    $sql .= "   t_goods.discount_flg";
    $sql .= " FROM";
    $sql .= "   t_goods ";
    $sql .= "     INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "       INNER JOIN";
    $sql .= "   t_price";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id";
    $sql .= "       LEFT JOIN";

    //�߸˿�
    $sql .= "   (SELECT";
    $sql .= "   t_stock.goods_id,";
    $sql .= "       SUM(t_stock.stock_num)AS stock_num, ";
    $sql .= "       SUM(t_stock.rstock_num)AS rstock_num";
    $sql .= "   FROM";
    $sql .= "       t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id";
    $sql .= "   WHERE";
    $sql .= "       t_stock.shop_id = $shop_id";
    $sql .= "       AND";
    $sql .= "       t_ware.count_flg = 't'";
    $sql .= "   GROUP BY t_stock.goods_id";
    $sql .= "   )AS t_stock";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id";

    $sql .= "       LEFT JOIN ";

    //ȯ����
    $sql .= "   (SELECT";
    $sql .= "       t_stock_hand.goods_id,";
    $sql .= "   SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num";
    $sql .= "   FROM";
    $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
    $sql .= "   WHERE t_stock_hand.work_div = 3 ";
    $sql .= "       AND";
    $sql .= "       t_stock_hand.shop_id =  $shop_id";
    $sql .= "       AND";
    $sql .= "       t_ware.count_flg = 't'";
    $sql .= "       AND";
    $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + 7)";
    $sql .= "   GROUP BY t_stock_hand.goods_id";
    $sql .= "   ) AS t_stock_io";
    $sql .= "   ON t_goods.goods_id=t_stock_io.goods_id";

    $sql .= "       LEFT JOIN ";

    //������
    $sql .= "   (SELECT";
    $sql .= "        t_stock_hand.goods_id,";
    $sql .= "        SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num";
    $sql .= "   FROM";
    $sql .= "        t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id";
    $sql .= "   WHERE";
    $sql .= "        t_stock_hand.work_div = 1";
    $sql .= "        AND";
    $sql .= "        t_stock_hand.shop_id = $shop_id";
    $sql .= "        AND";
    $sql .= "        t_ware.count_flg = 't'";
    $sql .= "        AND";
    $sql .= "        t_stock_hand.work_day <= (CURRENT_DATE + 7)";
    $sql .= "   GROUP BY t_stock_hand.goods_id";
    $sql .= "   ) AS t_allowance_io";
    $sql .= "   ON t_goods.goods_id = t_allowance_io.goods_id";

	//-- 2009/06/17 ����No.13 �ɲ�
	// �����Ⱦ���Ʊ���ˤ��뤿�ᡢINNER JOIN���ɲ�
	$sql .= "	INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n"
		 .	"	INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";	
	//-------

    #2009-10-12 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

    $sql .= " WHERE";
    $sql .= "   t_goods.goods_id IN($ary_get_goods_id)";

    #2009-10-12 hashimoto-y
    $sql .= "   AND ";
    $sql .= "   t_goods_info.shop_id = $shop_id ";

    if($get_target_goods == '1'){
        $sql .= "   AND";
        $sql .= "   t_goods.public_flg = 't'";
        $sql .= "   AND";
        $sql .= "   t_price.rank_cd = '$rank_cd'";
    }elseif($get_target_goods == '2'){
        $sql .= "   AND";
        if($_SESSION[group_kind] == "2"){
            $sql .= "   t_goods.shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   t_goods.shop_id = $_SESSION[client_id]";
        }
        $sql .= "   AND";
        $sql .= "   t_price.rank_cd = '1'";
        $sql .= "   AND";
        if($_SESSION[group_kind] == "2"){
            $sql .= "   t_price.shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   t_price.shop_id = $_SESSION[client_id]";
        }

    }
	//-- 2009/06/17 ����No.13 �ɲ�
	// �������ɲ�(�߸˾Ȳ��Ʊ�����)
	$sql.=	" ORDER BY \n"
		.	"	t_g_goods.g_goods_cd, \n"
		.	"	t_product.product_cd, \n"
		.	"	t_g_product.g_product_id, \n"
		.	"	t_goods.goods_cd, \n"
		.	"	t_goods.attri_div \n";
	//------

    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $get_data_num = pg_num_rows($result);
    for($i = 0; $i < $get_data_num; $i++){
        $get_data[] = pg_fetch_array($result, $i, PGSQL_NUM);
    }

    if($max_row < $get_data_num){
        $max_row = $get_data_num;
    }

    for($i = 0; $i < $get_data_num; $i++){
        $price = $get_data[$i][9];

        //����ñ�����������Ⱦ�������ʬ����
        $price_data = explode('.', $price);

        $goods_id[$i] = $get_data[$i][0];

        $set_get_data["hdn_goods_id"][$i]           = $get_data[$i][0];
        $set_get_data["hdn_name_change"][$i]        = $get_data[$i][1];
        $name_change[$i]                            = $get_data[$i][1];
        $set_get_data["hdn_stock_manage"][$i]       = $get_data[$i][2];
        $stock_manage[$i]                           = $get_data[$i][2];

        if($client_id == null){
            $set_get_data["form_goods_cd"][$i]          = $get_data[$i][3];
        }else{
            $set_get_data["form_goods_cd"][$i]      = $get_data[$i][3];
        }

        $set_get_data["form_goods_name"][$i]        = $get_data[$i][4];
        $set_get_data["form_stock_num"][$i]         = $get_data[$i][5];
        $set_get_data["hdn_stock_num"][$i]          = $get_data[$i][5];
        $stock_num[$i]                              = $get_data[$i][5];
        $set_get_data["form_rorder_num"][$i]        = $get_data[$i][6];
        $set_get_data["form_rstock_num"][$i]        = $get_data[$i][7];
        $set_get_data["form_designated_num"][$i]    = $get_data[$i][8];
        $set_get_data["form_buy_price"][$i]["i"]    = $price_data[0];
        $set_get_data["form_buy_price"][$i]["d"]    = ($price_data[1] != null)? $price_data[1] : '00';
        $set_get_data["hdn_tax_div"][$i]            = $get_data[$i][10];
        $set_get_data["form_in_num"][$i]            = $get_data[$i][11];

        //aoyama-n 2009-09-07
        $set_get_data["hdn_discount_flg"][$i]       = $get_data[$i][12];

		//-- 2009/06/17 �������ޤ� �ɲ�
		// ������ۤΥǥե���Ȥ�0�ǥ��å�
		$set_get_data["form_buy_amount"][$i] = 0;
    }

    //�����ե饰��hidden�˥��å�
    if($get_target_goods == '1'){
        $set_get_data["head_flg"] = 't';
    }else{
        $set_get_data["head_flg"] = 'f';
    }
    
    $set_get_data["form_designated_date"] = $_GET["designated_date"];

    $form->setConstants($set_get_data);
}

/****************************/
//�вٲ�ǽ������
/****************************/
if($_POST["recomp_flg"] == true){
    //���ʤ�����Ƚ��
    for($i = 0; $i < $max_row; $i++){
        if($_POST["hdn_goods_id"][$i] != null){
            $goods_input_flg = true;
        }
        $ary_goods_id[] = $_POST["hdn_goods_id"][$i];
    }

    //���ʤ����Ϥ���Ƥ�����
    if($goods_input_flg == true){

        //�вٲ�ǽ��
        $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;

        //�����ʳ������Ϥ���Ƥ�����
        if(!ereg("^[0-9]+$", $designated_date)){
            $designated_date = 0;
        }

        //ɽ������Ƥ����ʬ�롼��
        for($i = 0; $i < $max_row; $i++){
            //�ܵҶ�ʬ�����ɤ����ü�פξ��
            //�ϡ��ɥ����ǥ���
            if($furein_flg === true && $ary_goods_id[$i] != null){
                $designated_data[] = Get_Rank_Goods ($conn, $designated_date, $ary_goods_id[$i]);
            //�̾�
            }elseif($ary_goods_id[$i] != null){
                $sql  = "SELECT\n ";
                $sql .= "   t_goods.goods_id,\n";
                $sql .= "   t_goods.name_change,\n";
                #2009-10-12 hashimoto-y
                #$sql .= "   t_goods.stock_manage,\n";
                $sql .= "   t_goods_info.stock_manage,\n";

                $sql .= "   t_goods.goods_cd,\n";
                //aoyama-n 2009-09-07
                //����̾�˾���ʬ�बɽ������ʤ��Զ��
                #$sql .= "   t_goods.goods_name,\n";
                $sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";    //����̾
                #2009-10-12 hashimoto-y
                #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
                #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
                #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) END AS allowance_total,\n";
                $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
                $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
                $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) END AS allowance_total,\n";

                //aoyama-n 2009-09-07
                //���ڥ�ߥ�
                #$sql .= "   COALESCE(t_stock.stock_num,0) + COALESCE(t_stock_io.order_num,0) - COALESCE(t_allwance_io.allowance_io_num,0) AS stock_total\n";
                $sql .= "   COALESCE(t_stock.stock_num,0) + COALESCE(t_stock_io.order_num,0) - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total\n";
                $sql .= " FROM\n";
                $sql .= "   t_goods \n";
                $sql .= "   INNER JOIN\n"; 
                $sql .= "   t_price\n";
                $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
                //aoyama-n 2009-09-07
                //����̾�˾���ʬ�बɽ������ʤ��Զ��
                $sql .= "   INNER JOIN\n"; 
                $sql .= "   t_g_product\n";
                $sql .= "   ON t_goods.g_product_id = t_g_product.g_product_id\n";

                $sql .= "   LEFT JOIN\n";

                $sql .= "   (SELECT\n";
                $sql .= "   t_stock.goods_id,\n";
                $sql .= "   SUM(t_stock.stock_num)AS stock_num,\n ";
                $sql .= "   SUM(t_stock.rstock_num)AS rstock_num\n";
                $sql .= "   FROM t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id\n";
                $sql .= "   WHERE t_stock.shop_id =  $shop_id\n";
                $sql .= "   AND t_ware.count_flg = 't'\n";
                $sql .= "   GROUP BY t_stock.goods_id\n";
                $sql .= "   )AS t_stock\n";
                $sql .= "   ON t_goods.goods_id = t_stock.goods_id\n";

                $sql .= "   LEFT JOIN \n";

                $sql .= "   (SELECT t_stock_hand.goods_id,\n";
                $sql .= "   SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
                $sql .= "   FROM t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
                $sql .= "   WHERE t_stock_hand.work_div = 3 \n";
                $sql .= "   AND t_stock_hand.shop_id =  $shop_id\n";
                $sql .= "   AND t_ware.count_flg = 't'\n";
                $sql .= "   AND  t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
                $sql .= "   GROUP BY t_stock_hand.goods_id\n";
                $sql .= "   ) AS t_stock_io\n";
                $sql .= "   ON t_goods.goods_id=t_stock_io.goods_id\n";

                $sql .= "   LEFT JOIN \n";

                $sql .= "   (SELECT t_stock_hand.goods_id,\n";
                $sql .= "   SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
                $sql .= "   FROM t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
                $sql .= "   WHERE t_stock_hand.work_div = 1\n";
                $sql .= "   AND t_stock_hand.shop_id = $shop_id\n";
                $sql .= "   AND t_ware.count_flg = 't'\n";
                $sql .= "   AND  t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
                $sql .= "   GROUP BY t_stock_hand.goods_id\n";
                $sql .= "   ) AS t_allowance_io\n";
                $sql .= "   ON t_goods.goods_id = t_allowance_io.goods_id\n";
                #2009-10-12 hashimoto-y
                $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

                $sql .= " WHERE\n";
                $sql .= "   t_goods.goods_id = $ary_goods_id[$i]\n";

                #2009-10-12 hashimoto-y
                $sql .= "   AND ";
                $sql .= "   t_goods_info.shop_id = $shop_id ";

                if($head_flg == 't'){
                    $sql .= "   AND\n";
                    $sql .= "   t_goods.public_flg = 't'\n";
                    $sql .= "   AND\n";
                    $sql .= "   t_price.rank_cd = '$rank_cd'\n";
                }elseif($head_flg == 'f'){
                    $sql .= "   AND\n";
                    $sql .= "   t_goods.public_flg = 'f'\n";
                    $sql .= "   AND\n";
                    if($_SESSION[group_kind] == "2"){
                        $sql .= "   t_goods.shop_id IN (".Rank_Sql().")\n ";
                    }else{
                        $sql .= "   t_goods.shop_id = $_SESSION[client_id]\n";
                    }

                    $sql .= "   AND\n";
                    $sql .= "   t_price.rank_cd = '1'\n";
                    $sql .= "   AND\n";
                    if($_SESSION[group_kind] == "2"){
                        $sql .= "   t_price.shop_id IN (".Rank_Sql().")\n ";
                    }else{
                        $sql .= "   t_price.shop_id = $_SESSION[client_id]\n";
                    }

                }

                $sql .= ";\n";
                $result = Db_Query($conn, $sql);
                $data_num = pg_num_rows($result);
                $designated_data[] = pg_fetch_array($result, 0, PGSQL_NUM);
            }
        }

        for($i = 0; $i < count($designated_data); $i++){

            $goods_id[$i] = $designated_data[$i][0];

            //������ľ�����ǡ�����ե�����˥��å�
            $set_designated_data["hdn_goods_id"][$i]         = $designated_data[$i][0];                 //����ID
            $set_designated_data["hdn_name_change"][$i]      = $designated_data[$i][1];                 //��̾�ѹ�
            $set_designated_data["hdn_stock_manage"][$i]     = $designated_data[$i][2];                 //�߸˴���
            $stock_manage[$i]                                = $designated_data[$i][2];                 //�߸˴���
            $set_designated_data["form_goods_cd"][$i]        = $designated_data[$i][3];                 //���ʥ�����
            $set_designated_data["form_goods_name"][$i]      = $designated_data[$i][4];                 //ȯ����
            $set_designated_data["form_stock_num"][$i]       = $designated_data[$i][5];                 //��ê��
            $set_designated_data["hdn_stock_num"][$i]        = $designated_data[$i][5];                 //��ê��(hiddn��)
            $stock_num[$i]                                   = $designated_data[$i][5];                 //��ê��(hiddn��)
            $set_designated_data["form_rorder_num"][$i]      = $designated_data[$i][6];   //������
            $set_designated_data["form_rstock_num"][$i]      = $designated_data[$i][7];                 //ȯ���ѿ�
            $set_designated_data["form_designated_num"][$i]  = $designated_data[$i][8];                 //�вٲ�ǽ��
            $set_designated_data["goods_search_row"]         = "";
        }
    }

    //�вٲ�ǽ�����ϥե饰�˶���򥻥å�
    $set_designated_data["recomp_flg"] = "";

    $form->setConstants($set_designated_data);

/****************************/
//���ʥ���������
/****************************/
}elseif($_POST["goods_search_row"] != null){

    $search_row = $_POST["goods_search_row"];

    $designated_date = ($_POST["form_designated_date"] != null)? $_POST["form_designated_date"] : 0;
    if(!ereg("^[0-9]+$", $designated_date)){
        $designated_date = 0;
    }


    //�ܵҶ�ʬ���ü�ξ��
    //�ϡ��ɥ����ǥ���
    if($furein_flg === true){
        $goods_data = Get_Rank_Goods ($conn, $designated_date, null, $_POST["form_goods_cd"][$search_row]);

        //�����쥳���ɤʤ�
        if($goods_data === false){
            $data_num = 0;
        }else{
            $data_num = count($goods_data);   
        }

    //�̾�
    }else{

        $sql  = "SELECT\n";
        $sql .= "   t_goods.goods_id,\n";
        $sql .= "   t_goods.name_change,\n";
        #2009-10-12 hashimoto-y
        #$sql .= "   t_goods.stock_manage,\n";
        $sql .= "   t_goods_info.stock_manage,\n";

        $sql .= "   t_goods.goods_cd,\n";
		$sql .= "   (t_g_product.g_product_name || ' ' || t_goods.goods_name) AS goods_name, \n";  //����̾��������
        #2009-10-12 hashimoto-y
        #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
        #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
        #$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) END AS allowance_total,\n";
        $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS rack_num,\n";
        $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock_io.order_num,0) END AS on_order_num,\n";
        $sql .= "   CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_allowance_io.allowance_io_num,0) END AS allowance_total,\n";

        $sql .= "   COALESCE(t_stock.stock_num,0) + COALESCE(t_stock_io.order_num,0) - COALESCE(t_allowance_io.allowance_io_num,0) AS stock_total,\n";
        $sql .= "   t_price.r_price,\n";
        $sql .= "   t_goods.tax_div,\n";
        //aoyama-n 2009-09-07
        #$sql .= "   t_goods.in_num\n";
        $sql .= "   t_goods.in_num,\n";
        $sql .= "   t_goods.discount_flg\n";
        $sql .= " FROM\n";

        $sql .= "   t_goods INNER JOIN  t_price ON t_goods.goods_id = t_price.goods_id\n";
	    $sql .= "       INNER JOIN  t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
        $sql .= "       LEFT JOIN\n";

        //�߸˿�
        $sql .= "   (SELECT\n";
        $sql .= "       t_stock.goods_id,\n";
        $sql .= "       SUM(t_stock.stock_num)AS stock_num,\n";
        $sql .= "       SUM(t_stock.rstock_num)AS rstock_num\n";
        $sql .= "       FROM\n";
        $sql .= "            t_stock INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id\n";
        $sql .= "       WHERE\n";
        $sql .= "            t_stock.shop_id =  $shop_id\n";
        $sql .= "            AND\n";
        $sql .= "            t_ware.count_flg = 't'\n";
        $sql .= "       GROUP BY t_stock.goods_id\n";
        $sql .= "   )AS t_stock ON t_goods.goods_id = t_stock.goods_id\n";

        $sql .= "       LEFT JOIN\n";

        //ȯ���ѿ�
        $sql .= "   (SELECT\n";
        $sql .= "       t_stock_hand.goods_id,\n";
        $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN 1 WHEN 2 THEN -1 END ) AS order_num\n";
        $sql .= "   FROM\n";
        $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
        $sql .= "   WHERE\n";
        $sql .= "       t_stock_hand.work_div = 3\n";
        $sql .= "       AND\n";
        $sql .= "       t_stock_hand.shop_id = $shop_id\n";
        $sql .= "       AND\n";
        $sql .= "       t_ware.count_flg = 't'\n";
        $sql .= "       AND\n";
        $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
        $sql .= "   GROUP BY t_stock_hand.goods_id\n";
        $sql .= "   ) AS t_stock_io ON t_goods.goods_id=t_stock_io.goods_id\n";

        $sql .= "       LEFT JOIN\n";

        //������
        $sql .= "   (SELECT\n";
        $sql .= "       t_stock_hand.goods_id,\n";
        $sql .= "       SUM(t_stock_hand.num * CASE t_stock_hand.io_div WHEN 1 THEN -1 WHEN 2 THEN 1 END ) AS allowance_io_num\n";
        $sql .= "   FROM\n";
        $sql .= "       t_stock_hand INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id\n";
        $sql .= "   WHERE\n";
        $sql .= "       t_stock_hand.work_div = 1\n";
        $sql .= "       AND\n";
        $sql .= "       t_stock_hand.shop_id = $shop_id\n";
        $sql .= "       AND\n";
        $sql .= "       t_ware.count_flg = 't'\n";
        $sql .= "       AND\n";
        $sql .= "       t_stock_hand.work_day <= (CURRENT_DATE + $designated_date)\n";
        $sql .= "   GROUP BY t_stock_hand.goods_id\n";
        $sql .= "   ) AS t_allowance_io ON t_goods.goods_id = t_allowance_io.goods_id\n";

        #2009-10-12 hashimoto-y
        $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

        $sql .= " WHERE \n";
        $sql .= "       t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."'\n";
        $sql .= "       AND\n";
        $sql .= "       t_goods.accept_flg = '1'\n";
        $sql .= "       AND\n";

        #2009-10-12 hashimoto-y
        $sql .= "       t_goods_info.shop_id = $shop_id ";
        $sql .= "       AND ";

        $sql .= ($group_kind == '2') ? " t_goods.state IN (1,3)\n" : " t_goods.state = '1'\n";

 
        //����������������ꤵ��Ƥ�����
        if($head_flg == 't'){
            $sql .= "       AND \n";
            $sql .= "       t_goods.public_flg = 't' \n";
            $sql .= "       AND \n";
            $sql .= "       t_price.rank_cd = '$rank_cd'\n";
        //������������ʳ������ꤵ��Ƥ�����
        }elseif($head_flg ==  'f'){
            $sql .= "       AND \n";
            $sql .= "       t_goods.public_flg = 'f' \n";
            $sql .= "       AND \n";
            if($_SESSION[group_kind] == "2"){
                $sql .= "     t_goods.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "     t_goods.shop_id = $_SESSION[client_id]\n";
            }

            $sql .= "       AND\n";
            $sql .= "       t_price.rank_cd = '1'\n";
            $sql .= "       AND \n";
            if($_SESSION[group_kind] == "2"){
                $sql .= "     t_price.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "     t_price.shop_id = $_SESSION[client_id]\n";
            }
        }

        $sql .= ";\n";            

        $result = Db_Query($conn, $sql);

        $data_num = pg_num_rows($result);
        $goods_data = pg_fetch_array($result);
    }

    if($data_num > 0){

        $price = $goods_data[9];

        //����ñ�����������Ⱦ�������ʬ����
        $price_data = explode('.', $price);

        //������ۡ���ȴ�ˤ򻻽�
        $buy_amount= null;
        if($_POST["form_order_num"][$search_row] != null){
            //������ۡ���ȴ����
            $buy_amount = bcmul($price, $_POST["form_order_num"][$search_row],2);
            $buy_amount = Coax_Col($coax, $buy_amount);
        }
        //��̾�ѹ�
        $name_change[$search_row] = $goods_data[1];

        $goods_id[$search_row] = $goods_data[0];

        //���ʥǡ���
        $set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];              //����ID
        $set_goods_data["hdn_name_change"][$search_row]      = $goods_data[1];              //��̾�ѹ�
        $set_goods_data["hdn_stock_manage"][$search_row]     = $goods_data[2];              //�߸˴���
        $stock_manage[$search_row]                           = $goods_data[2];              //�߸˴���
        $set_goods_data["form_goods_cd"][$search_row]        = $goods_data[3];              //���ʥ�����
        $set_goods_data["form_goods_name"][$search_row]      = $goods_data[4];              //ȯ����
        $set_goods_data["form_stock_num"][$search_row]       = $goods_data[5];              //��ê��
        $set_goods_data["hdn_stock_num"][$search_row]        = $goods_data[5];              //��ê��(hiddn��)
        $stock_num[$search_row]                              = $goods_data[5];              //��ê��
        $set_goods_data["form_rorder_num"][$search_row]      = ($goods_data[6] != null)? $goods_data[6] : '0';              //������
        $set_goods_data["form_rstock_num"][$search_row]      = ($goods_data[7] != null)? $goods_data[7] : '-';              //ȯ���ѿ�
        $set_goods_data["form_designated_num"][$search_row]  = $goods_data[8];              //�вٲ�ǽ��
        $set_goods_data["form_buy_price"][$search_row]["i"]  = $price_data[0];              //����ñ������������
        $set_goods_data["form_buy_price"][$search_row]["d"]  = ($price_data[1] != null)? $price_data[1] : '00';             //����ñ���ʾ�������
        $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[10];             //���Ƕ�ʬ
        $set_goods_data["form_buy_amount"][$search_row]      = number_format($buy_amount);    //������ۡ���ȴ����
        $set_goods_data["goods_search_row"]                  = "";
        $set_goods_data["hdn_order_id"]                      = $_POST["hdn_order_id"];
        $set_goods_data["form_in_num"][$search_row]          = $goods_data["in_num"];
        //aoyama-n 2009-09-07
        $set_goods_data["hdn_discount_flg"][$search_row]     = $goods_data["discount_flg"]; //�Ͱ��ե饰  

    //���ʥ����ɤ��������ͤ����Ϥ��줿���
    }else{
        //���ʥǡ���
        $set_goods_data["hdn_goods_id"][$search_row]         = "";              //����ID
        $set_goods_data["hdn_name_change"][$search_row]      = "";              //��̾�ѹ�
        $set_goods_data["hdn_stock_manage"][$search_row]     = "";              //�߸˴���
        $set_goods_data["form_goods_name"][$search_row]      = "";              //ȯ����
        $set_goods_data["form_stock_num"][$search_row]       = "";              //��ê��
        $set_goods_data["hdn_stock_num"][$search_row]        = "";              //��ê��(hiddn��)
        $set_goods_data["form_rstock_num"][$search_row]      = "";              //ȯ���ѿ�
        $set_goods_data["form_rorder_num"][$search_row]      = "";              //������
        $set_goods_data["form_designated_num"][$search_row]  = "";              //�вٲ�ǽ��
        $set_goods_data["form_buy_price"][$search_row]["i"]  = "";              //����ñ������������
        $set_goods_data["form_buy_price"][$search_row]["d"]  = "";              //����ñ���ʾ�������
        $set_goods_data["hdn_tax_div"][$search_row]          = "";              //���Ƕ�ʬ
        $set_goods_data["form_order_in_num"][$search_row]    = "";              //ȯ����
        $set_goods_data["form_buy_amount"][$search_row]      = "";              //������ۡ���ȴ����
        $set_goods_data["goods_search_row"]                  = "";
        $set_goods_data["form_in_num"][$search_row]          = "";
        //aoyama-n 2009-09-07
        $set_goods_data["hdn_discount_flg"][$search_row]     = "";              //�Ͱ��ե饰
        $stock_num[$search_row]                              = null;
        $goods_id[$search_row]                               = null;
        $name_change[$search_row]                            = null;
        $stock_manage[$search_row]                           = null;
        
    }
    $set_goods_data["conf_button_flg"] = ""; 
    $form->setConstants($set_goods_data);

/****************************/
//�����襳�������Ͻ���
/****************************/
}elseif($_POST["client_search_flg"] == true){

    //POST����
    $client_cd = $_POST["form_client"]["cd"];       //�����襳����

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "   client_id,";
    $sql .= "   client_cname,";
    $sql .= "   coax,";
    $sql .= "   tax_franct,";
    $sql .= "   head_flg,";
    $sql .= "   trade_id ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   client_cd1 = '$client_cd'";
    $sql .= "   AND";
    $sql .= "   client_div = '2'";
    $sql .= "   AND";
    //$sql .= "   shop_gid = '$shop_gid'";
    if($_SESSION[group_kind] == "2"){
        $sql .= "   shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "   shop_id = $_SESSION[client_id]";
    }

    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    if($num != 0){

        $client_id      = pg_fetch_result($result, 0,0);
        $client_name    = pg_fetch_result($result, 0,1);
        $coax           = pg_fetch_result($result, 0,2);        //�ݤ��ʬ�ʾ��ʡ�
        $tax_franct     = pg_fetch_result($result, 0,3);        //ü����ʬ�ʾ����ǡ�
        $head_flg       = pg_fetch_result($result, 0,4);        //�����ե饰
        $trade_id       = pg_fetch_result($result, 0,5);        //�����ʬ

        //���������ǡ�����hidden���å�
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["head_flg"]            = $head_flg;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        $client_data["form_trade"]          = $trade_id;

        //�����ե饰�����ͤ��֣��ע֣͡�פޤ��ϡ֣�ע֣͡��פˤʤä���硢���Ϥ���Ƥ������ʾ�������ƥ��ꥢ
        if($head_flg != $_POST["head_flg"]){
	        //�߸˴���������
            $stock_manage = null;

            //��̾�ѹ�������
            $name_change = null;

	        //���ʾ�������ƥ��ꥢ
            for($i = 0; $i < $max_row; $i++){
                $client_data["hdn_goods_id"][$i]         = "";
                $client_data["form_goods_cd"][$i]        = "";
                $client_data["form_goods_name"][$i]      = "";
                $client_data["hdn_name_change"][$i]      = "";
                $client_data["form_rorder_num"][$i]      = "";
                $client_data["form_rstock_num"][$i]      = "";
                $client_data["hdn_stock_num"][$i]        = "";
                $client_data["hdn_stock_manage"][$i]     = "";
                $client_data["form_stock_num"][$i]       = "";
                $client_data["form_designated_num"][$i]  = "";
                $client_data["form_order_num"][$i]       = "";
                $client_data["form_buy_price"][$i]["i"]  = "";
                $client_data["form_buy_price"][$i]["d"]  = "";
                $client_data["hdn_tax_div"][$i]          = "";
                $client_data["form_buy_amount"][$i]      = "";
                $client_data["form_in_num"][$i]          = "";        
                $client_data["form_order_in_num"][$i]    = "";        
                //aoyama-n 2009-09-07
                $client_data["hdn_discount_flg"][$i]     = "";        

                $stock_num[$i]                           = null;
                $goods_id[$i]                            = null;
                $name_change[$i]                         = null;
                $stock_manage[$i]                        = null;

            	$max_row = 5;
	            $client_data["max_row"]            = 5;
            }
            
        }

        //��å���������
        if($head_flg == 't'){
            $message = "�������ʤΤ����ϲ�ǽ�Ǥ���";

        }elseif($furein_flg === true){
            $message = "���ʤ����ϲ�ǽ�Ǥ���";
        }else{
            $message = "�������ʰʳ������ϲ�ǽ�Ǥ���";
        }
        $client_search_flg = true;

        $warning = null;
    }else{
        $warning = "���������ꤷ�Ƥ���������";
        //�߸˴���������
        $stock_manage = null;
        $name_change  = null;

        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
        $client_data["form_client"]["name"] = "";
        $client_data["head_flg"]            = "";
        $client_data["hdn_ord_id"]          = $_POST["hdn_ord_id"];

        $client_search_flg = "";
    }

	$client_data["del_row"]            = "";
	$client_data["max_row"]            = 5;
	$client_data["form_buy_money"]     = "";
    $client_data["form_tax_money"]     = "";
    $client_data["form_total_money"]   = "";
	//����Կ�
    unset($del_history);
    $del_history[] = NULL;
	$del_row = NULL;

    $client_data["conf_button_flg"] = "";
    $form->setConstants($client_data);
}
//***************************/
//����Կ���hidden�˥��å�
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

/****************************/
//�ե��������
/****************************/
//ȯ����
$form->addElement(
        "text","form_send_date","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�вٲ�ǽ��
$form->addElement(
    "text","form_designated_date","",
    "size=\"4\" maxLength=\"4\" 
    $g_form_option 
    style=\"text-align: right; $g_form_style \"
    onChange=\"javascript:Button_Submit('recomp_flg','#','true')\"
    "
);

//ȯ���ֹ�
$form->addElement(
    "text","form_order_no","",
    "style=\"color : #000000; 
    border : #ffffff 1px solid; 
    background-color: #ffffff; 
    text-align: left\" readonly'"
);

//ȯ����
if($head_flg == 't'){
    //�꡼�ɥ���꡼�����Ƥ��ޤ���(����᤹)
    $form_order_day[] = $form->createElement(
        "text","y","",
        "size=\"4\" maxLength=\"4\"
        style=\"$g_form_style \"
        onkeyup=\"changeText(this.form,'form_order_day[y]','form_order_day[m]',4)\" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form_order_day[] = $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
        style=\"$g_form_style \"
        onkeyup=\"changeText(this.form, 'form_order_day[m]','form_order_day[d]',2)\" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form_order_day[] = $form->createElement(
        "text","d","",
        "size=\"2\" maxLength=\"2\"
        style=\"$g_form_style \" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form->addGroup( $form_order_day,"form_order_day","","-");
}else{
    $form_order_day[] = $form->createElement(
        "text","y","",
        "size=\"4\" maxLength=\"4\"
        style=\"$g_form_style \"
        onkeyup=\"changeText(this.form,'form_order_day[y]','form_order_day[m]',4)\" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form_order_day[] = $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
        style=\"$g_form_style \"
        onkeyup=\"changeText(this.form, 'form_order_day[m]','form_order_day[d]',2)\" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form_order_day[] = $form->createElement(
        "text","d","",
        "size=\"2\" maxLength=\"2\"
        style=\"$g_form_style \" 
        onFocus=\"onForm_today(this,this.form,'form_order_day[y]','form_order_day[m]','form_order_day[d]')\"
        onBlur=\"blurForm(this)\""
    );
    $form->addGroup( $form_order_day,"form_order_day","","-");
}

//��˾Ǽ��
$form_hope_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_hope_day[y]','form_hope_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_hope_day[] = $form->createElement(
    "text","m","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onkeyup=\"changeText(this.form,'form_hope_day[m]','form_hope_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_hope_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_hope_day[y]','form_hope_day[m]','form_hope_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_hope_day,"form_hope_day","","-");

//���꡼�����ȼ�
if($head_flg == 't'){
    $form->addElement('checkbox', 'form_trans', '���꡼�����', '<b>���꡼�����</b>��');
}elseif($head_flg == 'f'){
    $select_value = Select_Get($conn,"trans");
    $form->addElement("select", "form_trans",'', $select_value, $g_form_option_select);
}

//������
$form_client[] = $form->createElement(
    "text","cd","",
    "size=\"7\" maxLength=\"6\" 
    style=\"$g_form_style \" 
    onChange=\"javascript:Button_Submit('client_search_flg','#','true')\" 
    $g_form_option"
);
$form_client[] = $form->createElement(
    "text","name","",
    "size=\"34\" $g_text_readonly");
$form->addGroup( $form_client, "form_client", "");

//ľ����
$select_value = Select_Get($conn,'direct');
$form->addElement('select', 'form_direct', "", $select_value,"class=\"Tohaba\"".$g_form_option_select);

//�����Ҹ�
/*
$where  = " WHERE";
$where .= "  shop_id = $shop_id";
$where .= "  AND";
$where .= "  nondisp_flg = 'f'";
$select_value = Select_Get($conn,'ware', $where);
*/
$select_value = Select_Get($conn,'ware',"WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$form->addElement('select', 'form_ware', '', $select_value,$g_form_option_select);

//�����ʬ
$select_value = Select_Get($conn,'trade_ord');
$form->addElement('select', 'form_trade', '', $select_value,$g_form_option_select);

//ô����
$select_value = Select_Get($conn,'staff',null,true);
$form->addElement('select', 'form_staff', '', $select_value,$g_form_option_select);

//�̿���ʻ����谸��
$form->addElement("textarea","form_note_your",""," rows=\"2\" cols=\"75\" $g_form_option_area");


//�������(���)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_tax_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//������ۡ��ǹ����)
$form->addElement(
        "text","form_total_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #000000; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//hidden
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "client_search_flg");   //�����襳�������ϥե饰
$form->addElement("hidden", "head_flg");            //�����ե饰
$form->addElement("hidden", "hdn_client_id");       //������ID
$form->addElement("hidden", "goods_search_row");     //���ʥ��������Ϲ�
$form->addElement("hidden", "recomp_flg");          //�вٲ�ǽ���ե饰
$form->addElement("hidden", "hdn_coax");            //�ݤ��ʬ
$form->addElement("hidden", "hdn_tax_franct");      //ü����ʬ
$form->addElement("hidden", "hdn_order_id");        //��ǧ�ܥ��󲡲��ե饰
$form->addElement("hidden", "sum_button_flg");      //��ץܥ��󲡲��ե饰
$form->addElement("hidden", "hdn_design");          //�вٲ�ǽ����
$form->addElement("hidden", "hdn_target");          //�оݾ���
$form->addElement("hidden", "goods_cd_form");       //���ʥ�����
$form->addElement("hidden", "hdn_ord_enter_day");   //���ʥ�����
$form->addElement("hidden", "hdn_first_set", "1");  //���ɽ���ե饰

//ȯ���İ���
$form->addElement("button","ord_button","ȯ���İ���","onClick=\"javascript:Referer('2-3-106.php')\"");
//���ϡ��ѹ�
$form->addElement("button","new_button","������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�Ȳ�
$form->addElement("button","change_button","�Ȳ��ѹ�","onClick=\"javascript:Referer('2-3-104.php')\"");


#2009-09-15 hashimoto-y
for($i = 0; $i < $max_row; $i++){
    if(!in_array("$i", $del_history)){
        $form->addElement("hidden","hdn_discount_flg[$i]");
    }
}


/****************************/
//��ץܥ��󲡲�����
/****************************/
if(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_order_button"] == "ȯ����ǧ���̤�") && $_POST["client_search_flg"] == false){
    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];
    //������������ˤ��롣
    $del_history = explode(",", $del_row);

    $buy_data   = $_POST["form_buy_amount"];  //�������
    $price_data = NULL;                        //���ʤλ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

    //������ۤι���ͷ׻�
    for($i=0;$i<$max_row;$i++){
        if($buy_data[$i] != "" && !in_array("$i", $del_history)){
            $price_data[] = $buy_data[$i];
            $tax_div[]    = $_POST["hdn_tax_div"][$i];
        }
    }

    #2009-12-21 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_order_day"]["y"]."-".$_POST["form_order_day"]["m"]."-".$_POST["form_order_day"]["d"]);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

    $data = Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);

    if($_POST["sum_button_flg"] == true){
    $height = $max_row * 100;
    }

    //�ե�������ͥ��å�
    $money_data["form_buy_money"]   = number_format($data[0]);
    $money_data["form_tax_money"]   = number_format($data[1]);
    $money_data["form_total_money"] = number_format($data[2]);
    $money_data["sum_button_flg"]   = "";
    $form->setConstants($money_data);
}

/****************************/
//�ܥ��󲡲�����
/****************************/
if($_POST["form_order_button"] == "ȯ����ǧ���̤�" || $_POST["comp_button"] == "����饤��ȯ��OK" || $_POST["comp_button"] == "���ե饤��ȯ��OK" || $_POST["order_button"] == "����饤��ȯ��OK��ȯ�������" || $_POST["order_button"] == "���ե饤��ȯ��OK��ȯ�������"){

    /******************************/
    //�롼�����
    /******************************/
    //������
    //ɬ�ܥ����å�
    $form->addGroupRule('form_client', array(
            'cd' => array(
                    array('�����������襳���ɤ����Ϥ��Ƥ���������', 'required')
            ),      
            'name' => array(
                    array('�����������襳���ɤ����Ϥ��Ƥ���������','required')
            )       
    ));

    //�вٲ�ǽ��
    $form->addRule("form_designated_date","ȯ���ѿ��Ȱ��������θ����������Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

    //ȯ����
    //�����ʳ�
    if($head_flg != 't'){
        //��ɬ�ܥ����å�
        $form->addGroupRule('form_order_day', array(
            'y' => array(
                    array('������ȯ���������Ϥ��Ƥ���������', 'required'),
                    array('������ȯ���������Ϥ��Ƥ���������', 'numeric')
            ),      
            'm' => array(
                    array('������ȯ���������Ϥ��Ƥ���������','required'),
                    array('������ȯ���������Ϥ��Ƥ���������', 'numeric')
            ),       
            'd' => array(
                    array('������ȯ���������Ϥ��Ƥ���������','required'),
                    array('������ȯ���������Ϥ��Ƥ���������', 'numeric')
            )       
        ));
    }

    //��˾Ǽ��
    //��Ⱦ�ѥ����å�
    $form->addGroupRule('form_hope_day', array(
            'y' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������', 'numeric')
            ),      
            'm' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������','numeric')
            ),       
            'd' => array(
                    array('��������˾Ǽ�������Ϥ��Ƥ���������','numeric')
            )
    ));

    //�����Ҹ�
    //��ɬ�ܥ����å�
    $form->addRule("form_ware","�����Ҹˤ����򤷤Ƥ���������","required");

    //�����ʬ
    //��ɬ�ܥ����å�
    $form->addRule("form_trade","�����ʬ�����򤷤Ƥ���������","required");

    //ô����
    //��ɬ�ܥ����å�
    $form->addRule("form_staff","ô���Ԥ����򤷤Ƥ���������","required");


    //�̿���ʻ����谸��
    //��ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note_your","�̿���ʻ����谸�ˤ�95ʸ������Ǥ���","mb_maxlength","95");

    /*****************************/
    //POST����
    /*****************************/
    $designated_date    = $_POST["form_designated_date"];                                   //�вٲ�ǽ��
    $order_no           = $_POST["form_order_no"];                                          //ȯ���ֹ�
    $order_day["y"]     = $_POST["form_order_day"]["y"];                                    //ȯ������ǯ��
    $order_day["m"]     = $_POST["form_order_day"]["m"];                                    //ȯ�����ʷ��
    $order_day["d"]     = $_POST["form_order_day"]["d"];                                    //ȯ����������

    $hope_day["y"]      = $_POST["form_hope_day"]["y"];                                     //��˾Ǽ����ǯ��
    $hope_day["m"]      = $_POST["form_hope_day"]["m"];                                     //��˾Ǽ���ʷ��
    $hope_day["d"]      = $_POST["form_hope_day"]["d"];                                     //��˾Ǽ��������
    $arrival_day["y"]   = $_POST["form_arrival_day"]["y"];                                  //����ͽ������ǯ��
    $arrival_day["m"]   = $_POST["form_arrival_day"]["m"];                                  //����ͽ�����ʷ��
    $arrival_day["d"]   = $_POST["form_arrival_day"]["d"];                                  //����ͽ����������

    if($head_flg == 't'){
        $trans_flg      = ($_POST["form_trans"] != null)? 't' : 'f';                        //���꡼�����ȼ�
        $trans          = null;
    }elseif($head_flg == 'f'){
        $trans          = ($_POST["form_trans"] != null)? $_POST["form_trans"] : null;    //�����ȼ�
        if($trans != null){
            $sql  = "SELECT";
            $sql .= "   green_trans";
            $sql .= " FROM";
            $sql .= "   t_trans";
            $sql .= " WHERE";
            $sql .= "   trans_id = $trans";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $trans_flg = pg_fetch_result($result ,0,0);
        }else{
            $trans_flg = 'f';
        }
    }

    $client_id          = $_POST["hdn_client_id"];                                          //������
    $direct             = $_POST["form_direct"];  //ľ����
    $staff              = $_POST["form_staff"];                                             //ô����    
    $ware               = $_POST["form_ware"];                                              //�Ҹ�
    $trade              = $_POST["form_trade"];                                             //�����ʬ
    $note_your          = $_POST["form_note_your"];                                           //�̿���ʻ����谸��
    $client_cd          = $_POST["form_client"]["cd"];

    //����������å�
    $sql  = "SELECT";
    $sql .= "   COUNT(client_id) ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= "   AND";
    $sql .= "   client_cd1 = '$client_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $client_num = pg_fetch_result($result, 0, 0);

    if($client_num != 1){
        $form->setElementError("form_client", "���������������� ȯ����ǧ���̤إܥ��� <br>��������ޤ�����������ľ���Ƥ���������");
    }elseif($client_cd != null){ 

        //����ꥹ�Ȥ����
        $del_row = $_POST["del_row"];
        //������������ˤ��롣
        $del_history = explode(",", $del_row);

        //�ͤ�����å�����ؿ�
        $check_data = Row_Data_Check(
                                 $_POST[hdn_goods_id],                          //����ID
                                 $_POST[form_goods_cd],                         //���ʥ�����
                                 $_POST[form_goods_name],                       //����̾
                                 $_POST[form_order_num],                        //ȯ����
                                 $_POST[form_buy_price],                        //����ñ��
                                 str_replace(',','',$_POST[form_buy_amount]),   //�������
                                 $_POST[hdn_tax_div],                           //���Ƕ�ʬ
                                 $del_history,                                  //�Ժ������
                                 $max_row,                                      //����Կ�
                                 'ord',                                          //��ʬ
                                 //aoyama-n 2009-09-07
                                 #$conn
                                 $conn,
                                 null,
                                 null,
                                 null,
                                 null,
                                 $_POST[hdn_discount_flg]                       //�Ͱ��ե饰
                                  );

        //�ѿ������
        $goods_id   = null;
        $goods_cd   = null;
        $goods_name = null;
        $order_num  = null;
        $buy_price  = null;
        $buy_amount = null;
        $tax_div    = null;

        //���顼�����ä����
        if($check_data[0] === true){
            //���ʤ���Ĥ����򤵤�Ƥ��ʤ����
            $form->setElementError("form_buy_money",$check_data[1]);
            //���������ʥ����ɤ����Ϥ���Ƥ��ʤ����
            $goods_err = $check_data[2];
            //ȯ�����Ȼ���ñ�������Ϥ����뤫
            $price_num_err = $check_data[3];
            //ȯ����Ⱦ�ѿ��������å�
            $num_err = $check_data[4];
            //ñ��Ⱦ�ѥ����å�
            $price_err = $check_data[5];

            $err_flg = true;

        //���顼���ʤ��ä����
        }else{

            //��Ͽ�оݥǡ������ѿ��˥��å�
            $goods_id   = $check_data[1][goods_id];
            $goods_cd   = $check_data[1][goods_cd];
            $goods_name = $check_data[1][goods_name];
            $order_num  = $check_data[1][num];
            $buy_price  = $check_data[1][price];
            $buy_amount = $check_data[1][amount];
            $tax_div    = $check_data[1][tax_div];
            $def_line   = $check_data[1][def_line];
        }
    }

    /******************************/
    //PHP�ǥ����å�
    /******************************/

    if($head_flg != 't'){
        //ȯ�������������������å�
        if(!checkdate((int)$order_day["m"], (int)$order_day["d"], (int)$order_day["y"])){
            $form->setElementError("form_order_day", "ȯ���������դ������ǤϤ���ޤ���");
        }else{
            //�����ƥ೫���������å�
            //ȯ����
            $order_day_err   = Sys_Start_Date_Chk($order_day["y"], $order_day["m"], $order_day["d"], "ȯ����");
            if($order_day_err != Null){
                $form->setElementError("form_order_day", $order_day_err);
            }
        }
    }

    //��˾Ǽ�������å�
    if($hope_day["m"] != null || $hope_day["d"] != null || $hope_day["y"] != null){
        $hope_day_input_flg = true;
    }
    if(!checkdate((int)$hope_day["m"], (int)$hope_day["d"], (int)$hope_day["y"]) && $hope_day_input_flg == true){
        $form->setElementError("form_hope_day", "��˾Ǽ�������դ������ǤϤ���ޤ���");
    }else{
        //��˾Ǽ��
        $hope_day_err    = Sys_Start_Date_Chk($hope_day["y"], $hope_day["m"], $hope_day["d"], "��˾Ǽ��");
        if($hope_day_err != null){
            $form->setElementError("form_hope_day", $hope_day_err);
        }
    }

    //����ͽ���������å�
    if($arrival_day["m"] != null || $arrival_day["d"] != null || $arrival_day["y"] != null){
        $arrival_day_input_flg = true;
    }

    if(!checkdate((int)$arrival_day["m"], (int)$arrival_day["d"], (int)$arrival_day["y"]) && $arrival_day_input_flg == true){
        $form->setElementError("form_arrival_day", "����ͽ���������դ������ǤϤ���ޤ���");
    }else{
        //����ͽ����
        $arrival_day_err = Sys_Start_Date_Chk($arrival_day["y"], $arrival_day["m"], $arrival_day["d"], "����ͽ����");
        if($arrival_day_err != null){
            $form->setElementError("form_arrival_day", $arrival_day_err);
        }
    }

/*
    //���ʥ����å�
    //���ʽ�ʣ�����å�
    for($i = 0; $i < count($goods_id); $i++){
        for($j = 0; $j < count($goods_id); $j++){
            if($goods_id[$i] != null && $goods_id[$j] != null && $i != $j && $goods_id[$i] == $goods_id[$j]){
				$goods_twice = "Ʊ�����ʤ�ʣ�����򤵤�Ƥ��ޤ���";
            }
        }
    }
*/
    //���ʥ����å�
    //���ʽ�ʣ�����å�
    $goods_count = count($goods_id);
    for($i = 0; $i < $goods_count; $i++){

        //���˥����å��Ѥߤξ��ʤξ��ώ������̎�
        if(@in_array($goods_id[$i], $checked_goods_id)){
            continue;
        }

        //�����å��оݤȤʤ뾦��
        $err_goods_cd = $goods_cd[$i];
        $mst_line = $def_line[$i];

        for($j = $i+1; $j < $goods_count; $j++){
            //���ʤ�Ʊ�����
            if($goods_id[$i] == $goods_id[$j]) {
                $duplicate_line .= ", ".($def_line[$j]);
            }
        }
        $checked_goods_id[] = $goods_id[$i];    //�����å��Ѥ߾���

        if($duplicate_line != null){
            $duplicate_goods_err[] =  "���ʥ����ɡ�".$err_goods_cd."�ξ��ʤ�ʣ�����򤵤�Ƥ��ޤ���(".$mst_line.$duplicate_line."����)";
        }

        $err_goods_cd   = null;
        $mst_line       = null;
        $duplicate_line = null;
    }

    /**************************/
    //�͸���
    /**************************/    
    if($err_flg != true &&  $form->validate()){

        /***************************/
        //��Ͽ�ܥ��󲡲�����
        /***************************/
        if($_POST["comp_button"] == "����饤��ȯ��OK" || $_POST["comp_button"] == "���ե饤��ȯ��OK" || $_POST["order_button"] == "����饤��ȯ��OK��ȯ�������" || $_POST["order_button"] == "���ե饤��ȯ��OK��ȯ�������"){
            //ȯ���إå�����Ͽ

            //��������
            //����ͽ����
            if($arrival_day["y"] != null){
                $arrival_date = $arrival_day['y']."-".$arrival_day['m']."-".$arrival_day['d'];
            }

            //��˾Ǽ��
            if($hope_day["y"] != null){
                $hope_date = $hope_day['y']."-".$hope_day['m']."-".$hope_day['d'];        
            }

            //ȯ����
            $order_date = $order_day['y']."-".$order_day['m']."-".$order_day['d'];

            #2009-12-21 aoyama-n
            $tax_rate_obj->setTaxRateDay($order_date);
            $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);

            //��ȴ��ס������Ƕ�ۤ򻻽�
            for($i = 0; $i < count($goods_name); $i++){
                $total_amount_data = Total_Amount($buy_amount, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $conn);
            }

            Db_Query($conn, "BEGIN;");

            //�ѹ�
            //ȯ���إå��ơ��֥�����Ƥ��ѹ�
            if($order_id != null){
                //ȯ�����������Ƥ��ʤ������ǧ
                $update_check_flg = Update_Check($conn, "t_order_h", "ord_id", $order_id, $_POST["hdn_ord_enter_day"]);
                //���˺������Ƥ������
                if($update_check_flg === false){
                    header("Location: ./2-3-103.php?ord_id=$order_id&offline_flg=true&output_flg=delete");
                    exit;
                }

                //��������λ����Ƥ��ʤ������ǧ
                $finish_check_flg = Finish_Check($conn, "t_order_h", "ord_id", $order_id);
                //���˴�λ���Ƥ������
                if($finish_check_flg === false){
                    header("Location: ./2-3-103.php?ord_id=$order_id&offline_flg=true&output_flg=finish");
                    exit;
                }       

                $insert_sql  = "UPDATE t_order_h SET";
                $insert_sql .= "    ord_no = '$order_no',";         //ȯ���ֹ�
                $insert_sql .= "    client_id = $client_id,";       //������ID
                $insert_sql .= ($direct != null) ? " direct_id = $direct," : " direct_id = NULL, ";          //ľ����ID
                $insert_sql .= "    trade_id = $trade,";            //�����ʬ
                $insert_sql .= "    green_flg = '$trans_flg',";     //���꡼��ե饰

//                //������ȯ��������
//                if($head_flg == 't'){
//                    $insert_sql .= "    ord_time = now(),";         //ȯ������
//                //�������ȯ��������
//                }elseif($head_flg == 'f'){
//                    $insert_sql .= "    ord_time = '$order_date',"; //ȯ������
                //�������Ф���ȯ�����������Ͽ���λ��֤���Ͽ
                $insert_sql .= ($head_flg == 't' ) ? "ord_time = CURRENT_TIMESTAMP, \n" : "ord_time = '$order_date',\n " ;
//                }
        
                //������ȯ��������
                if($head_flg == 'f'){
                    $insert_sql .= ($trans != null) ? " trans_id = $trans," : "trans_id = NULL, ";        //�����ȼ�ID
                }
                //�������ȯ��������
                if($hope_day["y"] != null){
                    $insert_sql .= "    hope_day = '$hope_date',";  //��˾Ǽ��
                }

                $insert_sql .= "    note_your = '$note_your',";         //�̿���
                $insert_sql .= "    c_staff_id = $staff,";          //ô����ID
                $insert_sql .= "    ware_id = $ware,";              //�Ҹ�ID    
                $insert_sql .= "    ord_staff_id = $staff_id,";     //ȯ����ID

                //������ȯ��������
                if($head_flg == 't'){
                    $insert_sql .= "    ord_stat = '1',";           //ȯ������
                //�������ȯ��������
                }elseif($head_flg == 'f'){
                    $insert_sql .= "    ord_stat = NULL,";
                }

                $insert_sql .= "    net_amount = $total_amount_data[0],";    //��ȴ���
                $insert_sql .= "    tax_amount = $total_amount_data[1],";    //�����ǳ�
                $insert_sql .= "    ps_stat = '1',";                         //��������
                $insert_sql .= "    client_cd1      = (SELECT client_cd1   FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_name     = (SELECT client_name  FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_name2    = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_cname    = (SELECT client_cname FROM t_client WHERE client_id = $client_id),";
                $insert_sql .= "    client_post_no1 = (SELECT post_no1     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_post_no2 = (SELECT post_no2     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_address1 = (SELECT address1     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_address2 = (SELECT address2     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_address3 = (SELECT address3     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_charger1 = (SELECT charger1     FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= "    client_tel      = (SELECT tel          FROM t_client WHERE client_id = $client_id), ";
                $insert_sql .= ($direct != null) ? " direct_name     = (SELECT direct_name  FROM t_direct WHERE direct_id = $direct), " : " direct_name     = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_name2    = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct), " : " direct_name2    = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_cname    = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct), " : " direct_cname    = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_post_no1 = (SELECT post_no1     FROM t_direct WHERE direct_id = $direct), " : " direct_post_no1 = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_post_no2 = (SELECT post_no2     FROM t_direct WHERE direct_id = $direct), " : " direct_post_no2 = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_address1 = (SELECT address1     FROM t_direct WHERE direct_id = $direct), " : " direct_address1 = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_address2 = (SELECT address2     FROM t_direct WHERE direct_id = $direct), " : " direct_address2 = NULL, ";
                $insert_sql .= ($direct != null) ? " direct_address3 = (SELECT address3     FROM t_direct WHERE direct_id = $direct), " : " direct_address3 = NULL,  ";
                $insert_sql .= ($direct != null) ? " direct_tel      = (SELECT tel          FROM t_direct WHERE direct_id = $direct), " : " direct_tel      = NULL,  ";
                $insert_sql .= "    ware_name       = (SELECT ware_name FROM t_ware WHERE ware_id = $ware), ";
                $insert_sql .= ($head_flg == "f" && $trans != null) ? " trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans), " : " trans_name = NULL, ";
                $insert_sql .= "    c_staff_name    = (SELECT staff_name   FROM t_staff  WHERE staff_id = $staff), ";
                $insert_sql .= "    ord_staff_name  = (SELECT staff_name   FROM t_staff  WHERE staff_id = $staff_id), ";
                $insert_sql .= "    my_client_cd1   = (SELECT client_cd1   FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_client_cd2   = (SELECT client_cd2   FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_client_name  = (SELECT client_name  FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_client_cname = (SELECT client_cname FROM t_client WHERE client_id = $shop_id),";
                $insert_sql .= "    my_shop_name    = (SELECT shop_name    FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_shop_name2   = (SELECT shop_name2   FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_post_no1     = (SELECT post_no1     FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_post_no2     = (SELECT post_no2     FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_address1     = (SELECT address1     FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_address2     = (SELECT address2     FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    my_address3     = (SELECT address3     FROM t_client WHERE client_id = $shop_id), ";
                $insert_sql .= "    change_day      = CURRENT_TIMESTAMP ";
                $insert_sql .= " WHERE";
                $insert_sql .= "    ord_id = $order_id";            //ȯ��ID
                $insert_sql .= ";";

                $result = Db_Query($conn, $insert_sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

                //ȯ���ǡ�������
                $insert_sql  = "DELETE FROM";
                $insert_sql .= "    t_order_d";
                $insert_sql .= " WHERE";
                $insert_sql .= "    ord_id = $order_id";
                $insert_sql .= ";";

                $result = Db_Query($conn, $insert_sql );
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }

            //������Ͽ
            }else{
                $insert_sql  = "INSERT INTO t_order_h (\n";
                $insert_sql .= "    ord_id,\n";                       //ȯ��ID
                $insert_sql .= "    ord_no,\n";                       //ȯ���ֹ�
                $insert_sql .= "    client_id,\n";                    //������ID
                $insert_sql .= ($direct != null) ? " direct_id,\n " : null;                    //ľ����ID
                $insert_sql .= "    trade_id,\n ";                     //�����ʬ
                $insert_sql .= "    green_flg,\n";                    //���꡼��ե饰
                $insert_sql .= ($head_flg == 'f' && $trans != null) ? " trans_id,\n " : null;                 //�����ȼ�ID
                $insert_sql .= "    ord_time,\n";
                $insert_sql .= ($hope_day["y"] != null) ? " hope_day,\n " : null;     //��˾Ǽ��
                $insert_sql .= "    note_your,\n";                      //�̿���
                $insert_sql .= "    c_staff_id,\n";                   //ô����ID
                $insert_sql .= "    ware_id,\n";                      //�Ҹ�ID
                $insert_sql .= "    ord_staff_id,\n";                 //ȯ����ID
                $insert_sql .= "    ps_stat,\n";                      //��������
                $insert_sql .= "    ord_stat,\n";                     //ȯ������
                $insert_sql .= "    net_amount,\n";                   //��ȴ���
                $insert_sql .= "    tax_amount,\n";                   //�����ǳ�
                $insert_sql .= "    shop_id,\n ";                      //����å�ID
                //$insert_sql .= "    shop_gid";                      //FC���롼��ID
                $insert_sql .= "    client_cd1,\n ";
                $insert_sql .= "    client_name,\n ";
                $insert_sql .= "    client_name2,\n ";
                $insert_sql .= "    client_post_no1,\n ";
                $insert_sql .= "    client_post_no2,\n ";
                $insert_sql .= "    client_address1,\n ";
                $insert_sql .= "    client_address2,\n ";
                $insert_sql .= "    client_address3,\n ";
                $insert_sql .= "    client_charger1,\n ";
                $insert_sql .= "    client_tel, \n";
                if ($direct != null){
                    $insert_sql .= "    direct_name,\n ";
                    $insert_sql .= "    direct_name2,\n ";
                    $insert_sql .= "    direct_cname,\n ";
                    $insert_sql .= "    direct_post_no1,\n ";
                    $insert_sql .= "    direct_post_no2,\n ";
                    $insert_sql .= "    direct_address1,\n ";
                    $insert_sql .= "    direct_address2,\n ";
                    $insert_sql .= "    direct_address3,\n ";
                    $insert_sql .= "    direct_tel,\n";
                }
                $insert_sql .= "    ware_name,\n ";
                $insert_sql .= ($head_flg == "f" && $trans != null) ? " trans_name,\n " : null;
                $insert_sql .= "    c_staff_name,\n ";
                $insert_sql .= "    ord_staff_name,\n ";
                $insert_sql .= "    send_date,\n";
                $insert_sql .= "    client_cname,\n";
                $insert_sql .= "    my_client_cd1,\n";
                $insert_sql .= "    my_client_cd2,\n";
                $insert_sql .= "    my_client_name,\n ";
                $insert_sql .= "    my_client_name2,\n ";
                $insert_sql .= "    my_shop_name,\n";
                $insert_sql .= "    my_shop_name2,\n";
                $insert_sql .= "    my_client_cname,\n";
                $insert_sql .= "    my_post_no1,\n ";
                $insert_sql .= "    my_post_no2,\n ";
                $insert_sql .= "    my_address1,\n ";
                $insert_sql .= "    my_address2,\n ";
                $insert_sql .= "    my_address3 \n";
                $insert_sql .= " )VALUES(\n";
                $insert_sql .= "    (SELECT COALESCE(MAX(ord_id), 0)+1 FROM t_order_h),\n";
                $insert_sql .= "    '$order_no',\n";
                $insert_sql .= "    $client_id,\n";
                $insert_sql .= ($direct != null) ? " $direct,\n " : null;
                $insert_sql .= "    '$trade',\n";
                $insert_sql .= "    '$trans_flg',\n";
                $insert_sql .= ($head_flg == 'f' && $trans != null) ? " $trans, \n" : null;
                $insert_sql .= ($head_flg == 't' ) ? "CURRENT_TIMESTAMP, \n" : "'$order_date',\n " ;
//                $insert_sql .= "    '$order_date',\n";
                $insert_sql .= ($hope_day["y"] != null) ? " '$hope_date',\n " : null;
                $insert_sql .= "    '$note_your',\n";
                $insert_sql .= "    $staff,\n";
                $insert_sql .= "    $ware,\n";
                $insert_sql .= "    $staff_id,\n";
                $insert_sql .= "    '1',\n";

                if($head_flg == 't'){
                    $insert_sql .= "    '1',\n";
                }else{
                    $insert_sql .= "    NULL,\n";
                }
                $insert_sql .= "    $total_amount_data[0],\n";
                $insert_sql .= "    $total_amount_data[1],\n";
                //$insert_sql .= "    $shop_gid";
                $insert_sql .= "    $shop_id,\n ";
                $insert_sql .= "    (SELECT client_cd1      FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT client_name     FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT client_name2    FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT post_no1        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT post_no2        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT address1        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT address2        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT address3        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT charger1        FROM t_client WHERE client_id = $client_id),\n ";
                $insert_sql .= "    (SELECT tel             FROM t_client WHERE client_id = $client_id),\n ";
                if ($direct != null){
                    $insert_sql .= "    (SELECT direct_name  FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT post_no1     FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT post_no2     FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT address1     FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT address2     FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT address3     FROM t_direct WHERE direct_id = $direct),\n ";
                    $insert_sql .= "    (SELECT tel          FROM t_direct WHERE direct_id = $direct),\n ";
                }
                $insert_sql .= "    (SELECT ware_name  FROM t_ware WHERE ware_id = $ware),\n ";
                if($head_flg == 'f'){
                    $insert_sql .= ($trans != null) ? " (SELECT trans_name FROM t_trans WHERE trans_id = $trans),\n " : null;
                }
                $insert_sql .= "    (SELECT staff_name      FROM t_staff  WHERE staff_id = $staff),\n ";
                $insert_sql .= "    (SELECT staff_name      FROM t_staff  WHERE staff_id = $staff_id),\n ";
                $insert_sql .= "    NOW(),\n";
                $insert_sql .= "    (SELECT client_cname    FROM t_client WHERE client_id = $client_id),\n";
                $insert_sql .= "    (SELECT client_cd1      FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT client_cd2      FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT client_name     FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT client_name2    FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT shop_name       FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT shop_name2      FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT client_cname    FROM t_client WHERE client_id = $shop_id),\n";
                $insert_sql .= "    (SELECT post_no1        FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT post_no2        FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT address1        FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT address2        FROM t_client WHERE client_id = $shop_id),\n ";
                $insert_sql .= "    (SELECT address3        FROM t_client WHERE client_id = $shop_id) \n ";
                $insert_sql .= ");\n";

                $result = Db_Query($conn, $insert_sql);
                
                if($result === false){
                    $err_message = pg_last_error();
                    $err_format = "t_order_h_ord_no_key";

                    Db_Query($conn, "ROLLBACK;");
                    //ȯ��NO����ʣ�������           
 
                    if((strstr($err_message, $err_format) != false)){ 
                        $error = "Ʊ����ȯ����Ԥä����ᡢȯ��NO����ʣ���ޤ������⤦����ȯ���򤷤Ʋ�������";
 
                        //����ȯ��NO���������
                        $sql  = "SELECT ";
                        $sql .= "   MAX(ord_no)";
                        $sql .= " FROM";
                        $sql .= "   t_order_h";
                        $sql .= " WHERE";
                        $sql .= "   shop_id = $shop_id";
                        $sql .= ";";

                        $result = Db_Query($conn, $sql);
                        $order_no = pg_fetch_result($result, 0 ,0);
                        $order_no = $order_no +1;
                        $order_no = str_pad($order_no, 8, 0, STR_PAD_LEFT);

                        $err_data["form_order_no"] = $order_no;

                        $form->setConstants($err_data);

                        $duplicate_err = true;
                    }else{
                        exit;
                    }
                }
            }

            if($duplicate_err != true){
                //ȯ���ǡ�����Ͽ
                for($i = 0; $i < count($goods_id); $i++){
                    //����ɲ�
                    //���ʤ�¸�ߤ������
                    if($goods_id[$i] != null){
                        //��
                        $line = $i + 1;

                        /***************************************/
                        //���������ȴ�������ǡ������ǹ�פ򻻽�
                        /***************************************/
                        $price = $buy_price[$i]["i"].".".$buy_price[$i]["d"];         //����ñ��

                        /*********************/
                        //�������
                        /*********************/
                        $buy_amount = bcmul($price, $order_num[$i],2);  
						$buy_amount = Coax_Col($coax, $buy_amount);      
//                      $data = Total_Amount($buy_amount, $tax_div[$i], $coax, $tax_franct, $tax_rate);
//                      $tax_price   = $data[1];

                        $insert_sql  = "INSERT INTO t_order_d (";
                        $insert_sql .= "    ord_d_id,";
                        $insert_sql .= "    ord_id,";
                        $insert_sql .= "    line,";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    goods_name,";
                        $insert_sql .= "    num,";
                        $insert_sql .= "    tax_div,";
                        $insert_sql .= "    buy_price,";
                        $insert_sql .= "    buy_amount,";
//                      $insert_sql .= "    tax_amount";
                        $insert_sql .= "    goods_cd ";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    (SELECT COALESCE(MAX(ord_d_id), 0)+1 FROM t_order_d),";  
                        $insert_sql .= "    (SELECT";
                        $insert_sql .= "         ord_id";
                        $insert_sql .= "     FROM";
                        $insert_sql .= "        t_order_h";
                        $insert_sql .= "     WHERE";
                        $insert_sql .= "        ord_no = '$order_no'";
                        $insert_sql .= "        AND";
                        $insert_sql .= "        shop_id = $shop_id";
                        $insert_sql .= "    ),";
                        $insert_sql .= "    '$line',";
                        $insert_sql .= "    $goods_id[$i],";
                        $insert_sql .= "    '$goods_name[$i]',"; 
                        $insert_sql .= "    '$order_num[$i]',";
                        $insert_sql .= "    '$tax_div[$i]',";
                        $insert_sql .= "    $price,";
                        $insert_sql .= "    $buy_amount,";
//                      $insert_sql .= "    $tax_price";
                        $insert_sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_id[$i]) ";
                        $insert_sql .= ");";
                        $result = Db_Query($conn, $insert_sql);

                        //���Ԥ������ϥ�����Хå�
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }
                    }
                }

                for($i = 0; $i < count($goods_id); $i++){
        
                    $line = $i + 1;
//�����ʤ����߸˼���ʧ���ơ��֥����Ͽ
//                    if($stock_manage_flg[$i] == '1'){
                        //����ʧ���ơ��֥����Ͽ
                        $insert_sql  = " INSERT INTO t_stock_hand (";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    enter_day,";
                        $insert_sql .= "    work_day,";
                        $insert_sql .= "    work_div,";
                        $insert_sql .= "    client_id,";
                        $insert_sql .= "    ware_id,";
                        $insert_sql .= "    io_div,";
                        $insert_sql .= "    num,";
                        $insert_sql .= "    slip_no,";
                        $insert_sql .= "    ord_d_id,";
                        $insert_sql .= "    staff_id,";
                        $insert_sql .= "    shop_id,";
                        $insert_sql .= "    client_cname ";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    $goods_id[$i],";
                        $insert_sql .= "    NOW(),";
                        $insert_sql .= ($head_flg == 't' ) ? "CURRENT_TIMESTAMP, \n" : "'$order_date',\n " ;
//                        $insert_sql .= "    '".$order_day["y"]."-".$order_day["m"]."-".$order_day["d"]."',";
                        $insert_sql .= "    '3',";
                        $insert_sql .= "    $client_id,";
                        $insert_sql .= "    $ware,";
                        $insert_sql .= "    '1',";
                        $insert_sql .= "    $order_num[$i],";
                        $insert_sql .= "    '$order_no',";
                        $insert_sql .= "    (SELECT";
                        $insert_sql .= "        ord_d_id";
                        $insert_sql .= "    FROM";
                        $insert_sql .= "        t_order_d";
                        $insert_sql .= "    WHERE";
                        $insert_sql .= "        line = $line";
                        $insert_sql .= "        AND";
                        $insert_sql .= "        ord_id = (SELECT";
                        $insert_sql .= "                    ord_id";
                        $insert_sql .= "                 FROM";
                        $insert_sql .= "                    t_order_h";
                        $insert_sql .= "                 WHERE";
                        $insert_sql .= "                    ord_no = '$order_no'";
                        $insert_sql .= "                    AND";
                        $insert_sql .= "                    shop_id = $shop_id";
                        $insert_sql .= "                )";
                        $insert_sql .= "    ),";
                        $insert_sql .= "    $staff_id,";
                        $insert_sql .= "    $shop_id,";
                        $insert_sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id)";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }
//                    }
                }

                //ȯ����ǧ���Ϥ�ȯ��ID����
                $select_sql  = "SELECT ";
                $select_sql .= "    ord_id ";
                $select_sql .= "FROM ";
                $select_sql .= "    t_order_h ";
                $select_sql .= "WHERE ";
                $select_sql .= "    ord_no = '$order_no'";
                $select_sql .= "AND ";
                $select_sql .= "    shop_id = $shop_id;";
                $result = Db_Query($conn, $select_sql);
                $order_id = pg_fetch_result($result,0,0);

                Db_Query($conn, "COMMIT;");

                if($head_flg == 't'){
                    if($_POST["order_button"] == "����饤��ȯ��OK��ȯ�������" || $_POST["order_button"] == "���ե饤��ȯ��OK��ȯ�������"){
                        //��������ȯ�������
                        header("Location: ./2-3-103.php?ord_id=$order_id&online_flg=true&output_flg=true");
                    }else{
                        //��������ȯ��������ʤ�
                        header("Location: ./2-3-103.php?ord_id=$order_id&online_flg=true");
                    }
                }else{
                    if($_POST["order_button"] == "����饤��ȯ��OK��ȯ�������" || $_POST["order_button"] == "���ե饤��ȯ��OK��ȯ�������"){
                        //FC����ȯ�������
                        header("Location: ./2-3-103.php?ord_id=$order_id&offline_flg=true&output_flg=true");
                    }else{
                        //FC����ȯ��������ʤ�
                        header("Location: ./2-3-103.php?ord_id=$order_id&offline_flg=true");
                    } 
                }
            }
        }else{
            //��Ͽ��ǧ���̤�ɽ���ե饰
            $freeze_flg = true;
        }
    }
}

/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+5;

    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);

}

/*****************************/
//�ե������������ư��
/*****************************/
//�����褬���򤵤�Ƥ��ʤ�����ȯ����Ͽ��ǧ�ξ��ϥե꡼��
if($client_search_flg != true || $freeze_flg == true){
    #2009-09-15 hashimoto-y
    #$style = "color : #000000; 
    #        border : #ffffff 1px solid; 
    #        background-color: #ffffff"; 
    $style = "border : #ffffff 1px solid; 
            background-color: #ffffff"; 
    $type = "readonly";
}else{
    $type = $g_form_option;
}
//���ֹ楫����
$row_num = 1;
$i = 0;

for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ��
    if(!in_array("$i", $del_history)){

        $del_data = $del_row.",".$i;

        #2009-09-10 hashimoto-y
        //�Ͱ����ʤ����򤷤����ˤ��ֻ����ѹ�
        $font_color = "";

        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");

        #print_r($hdn_discount_flg);

        if($hdn_discount_flg === 't'){
            $font_color = "color: red; ";
        }else{
            $font_color = "color: #000000; ";
        }



        //����ID
        $form->addElement("hidden","hdn_goods_id[$i]");

        //���ʥ�����
        $form->addElement(
            "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\" 
             style=\"$font_color $style $g_form_style \" $type 
            onChange=\"return goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i ,$row_num)\""
        );

        //����̾
//        if(($_POST["hdn_name_change"][$i] == '2' || $name_change[$i] == '2') && $freeze_flg != true){
        if(($name_change[$i] == '2') && $freeze_flg != true){
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" $g_text_readonly" 
            );
        }else{
            $form->addElement(
                "text","form_goods_name[$i]","",
                "size=\"54\" maxLength=\"41\" 
                style=\"$font_color $style\" $type"
            );
        }

        //��̾�ѹ��ե饰
        $form->addElement("hidden","hdn_name_change[$i]");

        //�߸˴���
        $form->addElement("hidden","hdn_stock_manage[$i]");

        //��ê��
        if($stock_manage[$i] == 1){
            if($client_id != null){
                $form->addElement("link","form_stock_num[$i]","","#","$stock_num[$i]",
                "onClick=\"javascript:Open_mlessDialmg_g('2-3-111.php','$goods_id[$i]',$shop_id,300,160);\"");
            }else{
                $form->addElement("static","form_stock_num[$i]","","$stock_num[$i]");
            }
        }

        $form->addElement("hidden","hdn_stock_num[$i]","","");

        //ȯ���ѿ�
        $form->addElement(
            "text","form_rorder_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //������
        $form->addElement("text","form_rstock_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //�вٲ�ǽ��
        $form->addElement("text","form_designated_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //����
        $form->addElement("text","form_in_num[$i]","",
            "size=\"11\" maxLength=\"9\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" 
            readonly'"
        );

        //��ʸ����
        $form->addElement("text","form_order_in_num[$i]","",
            "size=\"6\" maxLength=\"5\" 
            onKeyup=\"in_num($i,'hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: right; $font_color $style $g_form_style \"
            $type"
        );

        //����饤��ȯ���ξ��ϸĿ��ѹ��Բ�
/*
        if($head_flg == 't'){ 
            //ȯ����
            $form->addElement("text","form_order_num[$i]","",
                "size=\"11\" maxLength=\"9\" 
                style=\"color : #000000; 
                border : #ffffff 1px solid; 
                background-color: #ffffff; 
                text-align: right\" readonly'
            ");

        }else{
*/
            //ȯ����
            $form->addElement("text","form_order_num[$i]","",
                "size=\"6\" maxLength=\"5\" 
                onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');ord_in_num($i);\"
                style=\"text-align: right; $font_color $style $g_form_style \"
                $type"
            );
//        }

        //����ñ��
        $form_buy_price[$i][] =& $form->createElement(
            "text","i","",
            "size=\"11\" maxLength=\"9\" class=\"money\"
            onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: right; $font_color $style $g_form_style \"
            $type"
        );
        $form_buy_price[$i][] =& $form->createElement("static","","",".");
        $form_buy_price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\" 
            onKeyup=\"Mult('hdn_goods_id[$i]','form_order_num[$i]','form_buy_price[$i][i]','form_buy_price[$i][d]','form_buy_amount[$i]','$coax');\"
            style=\"text-align: left; $font_color $style $g_form_style \"
            $type"
        );
        $form->addGroup( $form_buy_price[$i], "form_buy_price[$i]", "");

        //���Ƕ�ʬ
        $form->addElement("hidden","hdn_tax_div[$i]","","");

        //���(��ȴ��)
        $form->addElement(
            "text","form_buy_amount[$i]","",
            "size=\"25\" maxLength=\"18\" 
            style=\"$font_color 
            border : #ffffff 1px solid; 
            background-color: #ffffff; 
            text-align: right\" readonly'"
        );

        //aoyama-n 2009-09-07
        //�Ͱ��ե饰
        #2009-09-15 hashimoto-y
        #$form->addElement("hidden","hdn_discount_flg[$i]");


        //����¾���ʤ���Ͽ��ǧ���̤ξ�����ɽ��
        if($client_search_flg === true && $freeze_flg == false){
            //�������
            $form->addElement(
                "link","form_search[$i]","","#","����",
                "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/2-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,5,$client_id,$i,$row_num);\""
            );
            //������
            //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��
            $del_str = ($auth[0] == "w") ? "���" : null;
            if($row_num == $max_row-$del_num){
                $form->addElement(
                    "link","form_del_row[$i]","",
                    "#","<font color='#FEFEFE'>$del_str</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
                );
            //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
            }else{
                $form->addElement(
                    "link","form_del_row[$i]","",
                    "#","<font color='#FEFEFE'>$del_str</font>","TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
                );
            }
        }

        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= " <tr class=\"Result1\">";
        $html .= "  <A NAME=$row_num><td align=\"right\">$row_num</td></A>";
        $html .= "  <td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($client_search_flg === true && $freeze_flg == false){
            $html .= "      ��".$form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml()."��";
        }
        $html .= "  <br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\" width=\"80\">";

        //�߸˴���������
        if($stock_manage[$i] == 1){
            $html .=        $form->_elements[$form->_elementIndex["form_stock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rorder_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_rstock_num[$i]"]]->toHtml();
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .=        $form->_elements[$form->_elementIndex["form_designated_num[$i]"]]->toHtml();
            $html .= "  </td>";
        //�߸˴������ʤ����
        }elseif($stock_manage[$i] == 2){
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "<p style=\"$font_color\">";
            $html .= "-";
            $html .= "</p>";
            $html .= "  </td>";
        //����¾
        }else{
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
            $html .= "  <td align=\"right\">";
            $html .= "  </td>";
        }
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_in_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_order_num[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "  <td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_buy_amount[$i]"]]->toHtml();
        $html .= "  </td>";
        
        if($client_search_flg === true && $freeze_flg == false){
            $html .= "  <td class=\"Title_Add\" align=\"center\">";
            $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
            $html .= "  </td>";
        }
        $html .= " </tr>";

        //���ֹ��ܣ�
        $row_num = $row_num+1;
    }
}

//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
if($freeze_flg != true){

    //button
    $form->addElement("submit","form_order_button","ȯ����ǧ���̤�", $disabled);
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    $form->addElement("button","form_sum_button","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#foot','true')\"");

    $form->addElement("link","form_client_link","","./2-3-102.php","ȯ����","
        onClick=\"return Open_SubWin('../dialog/2-0-208.php',Array('form_client[cd]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
    );
    //�����褬���򤵤�Ƥ��ʤ����ϥե꡼��
    //���ɲåܥ���
    if($client_search_flg === true){
        $form->addElement("button","form_add_row","���ɲ�","onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true')\"");
    }

}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //���
    $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    
    if($head_flg == 't'){
        //OK
        $form->addElement("submit","comp_button","����饤��ȯ��OK", $disabled);
        //ȯ�������
        $form->addElement("submit","order_button","����饤��ȯ��OK��ȯ�������", $disabled);
    }else{
        //OK
        $form->addElement("submit","comp_button","���ե饤��ȯ��OK", $disabled);
        //ȯ�������
        $form->addElement("submit","order_button","���ե饤��ȯ��OK��ȯ�������", $disabled);
    }
    $form->freeze();
}

/****************************/
//JavaScript
/****************************/
/****************************************************/
//���åȿ���׻�����
$js  = " function in_num(num,id,order_num,price_i,price_d,amount,coax){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_order_num\"+\"[\"+num+\"]\";\n";
$js .= "    var buy_amount = \"form_buy_amount\"+\"[\"+num+\"]\";\n";

$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var v_num = v_in_num * v_ord_in_num;\n";

$js .= "    if(isNaN(v_num) == false){\n";
$js .= "        document.dateForm.elements[ord_num].value = v_num;\n";
$js .= "    }else{\n";
$js .= "        document.dateForm.elements[ord_num].value = \"\";\n";
$js .= "    }\n";
$js .= "    Mult(id,order_num,price_i,price_d,amount,coax);\n";
$js .= "}\n";

//��ʸ���åȿ���׻�����
$js .= "function ord_in_num(num){\n";
$js .= "    var in_num = \"form_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_in_num = \"form_order_in_num\"+\"[\"+num+\"]\";\n";
$js .= "    var ord_num = \"form_order_num\"+\"[\"+num+\"]\";\n";
$js .= "    var v_in_num = document.dateForm.elements[in_num].value;\n";
$js .= "    var v_ord_in_num = document.dateForm.elements[ord_in_num].value;\n";
$js .= "    var v_ord_num = document.dateForm.elements[ord_num].value;\n";
$js .= "    var result = v_ord_num % v_in_num;\n";
$js .= "    if(result == 0){\n";
$js .= "        var res = v_ord_num / v_in_num;\n";
$js .= "        document.dateForm.elements[ord_in_num].value = res;\n";
$js .= "    }else{  \n";
$js .= "        document.dateForm.elements[ord_in_num].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";

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
$page_menu = Create_Menu_f('buy','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[ord_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html'          => "$html",
    'message'       => "$message",
    'warning'       => "$warning",
    'error'         => "$error",
    'freeze_flg'    => "$freeze_flg",
    'goods_twice'   => "$goods_twice",
    'js'            => "$js",
    'auth_r_msg'    => "$auth_r_msg",
    'update_flg'    => "$update_flg",
    'head_flg'      => "$head_flg",
));

$smarty->assign("goods_err", $goods_err);
$smarty->assign("price_num_err", $price_num_err);
$smarty->assign("num_err", $num_err);
$smarty->assign("price_err", $price_err);
$smarty->assign("duplicate_goods_err", $duplicate_goods_err);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>