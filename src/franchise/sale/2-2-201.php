<?php
/**
 *
 * �����ɼȯ��
 *
 * �ѹ�����
 *  ��2006/05/29�����ô���Ԥ����ꤹ��褦���ѹ�
 *  ��2006/06/07�˸��߸˿�ɽ�����ѹ�
 *   (2006/06/20) �����鵯�����Ƥ��������ѹ��Ǥ��ʤ��Х�����
 *
 *   (2006/07/10) attach_gid��ʤ���
 *   (2006/07/31) �����Ǥη׻���ˡ���ѹ�
 *
 *   (2006/08/07) ����������Ϥ�FC�����ɼ�Ѥ��ѹ�(kaji)
 *      �������ʬ�־��ʡפǸ���
 *      ���Ԥ��ɲá�����ϥʥ�
 *      �������ƥ��ϥʥ�
 *
 *   (2006/08/10) ñ������Ф��ѹ���watanabe-k��
 *      ���߸�ñ�����Ķ�ñ���ʸ���ñ����
 *      ���Ķ�ñ����ɸ����������ñ����
 *
 *   (2006/08/12) ����������watanabe-k��
 *      �����׾���������������
 *      ��������    ������������
 *      ���Ҹ�      �����ܽв��Ҹ�
 *
 *   (2006/08/18) yamato���ͤ��ѹ�(kaji)
 *      ���������ʬ�פ�֥����ӥ��פ����ϲ�ǽ��
 *      ��������̾��ά�Τ�ɽ��
 *      ������ɼȯ�Գ�ǧ���̤ءפȤ����ܥ���ϡֳ�ǧ���̤ءפ��ѹ�
 *      ����Ͽ�����ɼ��ɬ��ȯ�ԤȤϸ¤�ʤ����������θ���뤳�ȡ�
 *
 *   (2006/08/19) ���ѹ�(kaji)
 *      ��������λ���̤���ɼȯ�Ԥ���ܥ����Ĥ���
 *
 *   (2006/08/22) ���ѹ�(kaji)
 *      �������ӥ��������ƥ�ΰ����ե饰���켰��Ĥ���
 *      ���ˤȤ�ʤäƥ��顼�����å����ѹ�
 *      ����ɼ�ֹ�κ��֤���֥ơ��֥뤫���������褦���ѹ�
 *
 *   (2006/08/23) ���ѹ�(kaji)
 *      ���ѹ�����������������ɼ������������Ͽ���ϼ����̤�
 *
 *   (2006/08/26) �Զ���к��ʲ���(kaji)
 *      ����ʣ���顼�ե饰����������褦���ѹ�
 *      �����ս꤫��===�פˤ��ơ�������ˤ��Ƚ�ꤷ�ʤ��褦���ѹ�
 *
 *   (2006/08/31) �Х����� (kaji)
 *      ��ľ�Ĥξ��Ϻ߸˿����פ���
 *
 *   (2006/09/01) (kaji)
 *      �����顼�����å���ư��Ƥ��ʤ��ä��ս����
 *      ����ɼ����������ʬ��̾������̾�������ˤ���Ͽ����褦��
 *
 *   (2006/09/05) (kaji)
 *      ���������ν������ɲ�
 *
 *   (2006/09/06) (kaji)
 *      �������ʬ�Υ��쥯�ȥܥå����Ρ����ʡס��Ͱ����פ��֤�
 *
 *   (2006/09/11) (kaji)
 *      �����ٲ�����freeze�����ɲ�
 *
 *   (2006/09/20) (kaji)
 *      �����׾������������������������������դ������å������ɲ�
 *
 *   (2006/09/25) (kaji)
 *      ����׶�ۤη׻���������β��Ƕ�ʬ�ǤϤʤ�����ʬ�β��Ƕ�ʬ��ȤäƤ����Τ���
 *
 *   (2006/09/26) (kaji)
 *      ���ѹ�������������ơ��֥�ξä�˺���ɲ�
 *
 *   (2006/09/30) (kaji)
 *      �������������������������դ����Ϥ��줿���Υ��顼��å������ѹ�
 *
 *   (2006/10/23) (kaji)
 *     �������ʤ���Ͽ�Ǥ���褦��
 *     ����Ͽ��λ������ܥ������Ͽ������ɼ���ѹ����̤����ܤ���褦��
 *     �������衢�����ɼ������ľ���衢�����ȼԤ��ѹ���ǽ��
 *     ����̾����̾2��DB����Ͽ˺�콤��
 *     ��GET��񤭴����Ƥ⤪��ʤ褦��
 *     ��¸�ߤ��ʤ�����CD���ϻ��Υ����ƥ���������å��ν����
 *     �����Ϥ��줿�̤�˹��ֹ����Ͽ��ɽ��
 *     ���Ҹ��ѹ����κ߸˿��׻���������
 *     �����׾������������˥����ƥ೫���������å��ɲ�
 *     �����˥�������
 *     �����顼�����å������顼��å������򤴤ä����ѹ�
 *     �������ƥ�ʤ��ξ��˥����ӥ��β��Ƕ�ʬ��Ȥ��褦���ѹ�
 *
 *   (2006/10/24) (kaji)
 *     ����ǧ���̤ǹԿ��Υ롼�ץ����󥿤�����ϳ�줷�Ƥ��Τ���
 *   (2006/11/16) (suzuki)
 *     �������ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��ä���ɽ�����ʤ��褦�˽���
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/09      03-009      kajioka-h   �����ɼ���Ϥ��ѿ����ѹ�
 *                  03-013      kajioka-h   ��ɼ�ѹ�������ɼ�������Ƥʤ��������å������ɲ�
 *                  03-044      kajioka-h   ��ɼ�ѹ�����������������Ƥʤ��������å������ɲ�
 *  2006-12-12      03-056      suzuki      �Ͱ��ξ��ϼ�ʧ������Ͽ���ʤ�
 *  2006-12-16      ssl-0087    kajioka-h   ¾�Υ���åפξ��ʤ����ϤǤ��Ƥ����Х�����
 *  2007-02-06      B0702-003   ��          GET����ID�������������å��ɲ�
 *  2007/02/21      ��˾6-1     kajioka-h   ��������Ͽ�Ǥ���褦�ˤ���
 *  2007/03/02      ��˾6-2     kajioka-h   �����ʡ����ξ��ʡ��Ҳ����������Ͽ��ǽ��
 *                  ��˾6-3     kajioka-h   �����ƥ�̾��������ʾ���ʬ��ܾ���̾�ˡפȡ�ά�Ρ�ɽ����
 *                  ��˾5-2     kajioka-h   �����μ�ʧ������ֽв��Ҹˢ�ô�����Ҹˢ�������פȤ���ή��ˡ�function/trade_fc.fnc ���
 *  2007/03/06      xx-xxx      kajioka-h   ľ���衢�����ȼԤ���
 *  2007/03/08      B0702-014   kajioka-h   ���ʤ���̾�ѹ��ԲĢ��ѹ��Ĥ��Ѥ����ݤˡ��ե����ब��̾�ѹ���ǽ�ˤʤ�ʤ�
 *  2007/03/09      xx-xxx      kajioka-h   ���������ϻ��������ʬ�򤽤�������Υޥ����μ����ʬ�����򤹤�褦���ѹ�
 *  2007/03/30      �׷�6-1     kajioka-h   �����ɼ�����μ����ʬ�ϡֳ����סֳ����ʡסֳ��Ͱ��פ�OK
 *  2007/04/05      ����¾25    kajioka-h   ��������Ҳ����������λ���������Υ����å������ɲ�
 *                  xx-xxx      kajioka-h   ô���ԤΥ��쥯�Ȥ�߿���Υ����å��������ѹ�
 *  2007/04/09      ��˾1-4     kajioka-h   �Ҳ�������λ����ѹ�
 *  2007/04/11      ��˾1-4     kajioka-h   �Ҳ�������Υ饸���ܥ��󤬷���ޥ����ȹ�äƤ��ʤ��ä��Τ���
 *  2007/04/12      B0702-036   kajioka-h   ���ե饤��������ϻ��˷���������å��Υ����ꥨ�顼���Ф�Τ���
 *  2007/05/01      �ʤ�        fukuda      ������Ρ־��֡פ���Ϥ���褦����
 *  2007/05/05      B0702-049   kajioka-h   �����ӥ��������ƥ�Ȥ⤢����ˡ������ƥ�β��Ƕ�ʬ��ͥ�褹��褦�˽���
 *  2007/05/08      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/09      B0702-050   kajioka-h   ���ե饤����Ԥο�����Ͽ����������ʸ���ˤ������ȥ����ꥨ�顼�ˤʤ�Τ���
 *  2007/05/17      xx-xxx      kajioka-h   ͽ��ǡ������١�ͽ��ǡ��������������ɼ�����������ɼ�ǥ쥤�����Ȥ��碌��
 *  2007/05/23      xx-xxx      kajioka-h   �����ɼ�Ǥ⸽������ǽ�ˤʤä�
 *  2007/05/29      B0702-059   kajioka-h   �إå��ζ�ۤ�ɽ�����ۤʤ�Х�����
 *  2007/06/07      xx-xxx      kajioka-h   ������λ��ͤ������ѹ��ˤʤä���
 *  2007/06/11      ����¾14    kajioka-h   �����⡢�ԥ��ꥢ
 *  2007/06/20      xx-xxx      kajioka-h   ��ɼʣ��
 *  2007/06/29      B0702-066   kajioka-h   �����Ͱ����������ʤ������ɼ�ξ������⤬�ޥ��ʥ��ˤʤäƤ��ʤ��Х�����
 *  2007-07-12                  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *  2007/08/21                  kajioka-h   �Ҳ��������ȯ�������硢�����ʬ�ֳ���פ����Ǥ��ʤ��褦�˽���
 *  2007/08/29                  kajioka-h   �����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ���ˤ���
 *  2009/09/08                  aoyama-n    �Ͱ���ǽ�ɲ�
 *  2009/09/08                  aoyama-n    �����ʤ����ξ��ʤ���̾�ѹ��ե饰��о��ߥ�����
 *  2009/09/18                  hashimoto-y �Ͱ����ʵڤӼ����ʬ�����ʡ��Ͱ��ξ����ֻ�ɽ��
 *  2009/09/28      �ʤ�        hashimoto-y �����ʬ�����Ͱ������ѻ�
 *  2009/12/22                  aoyama-n    ��Ψ��TaxRate���饹�������
 *
 */
/*
 * @author      
 * @version     
 *
 */

$page_title = "�����ɼȯ��";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�����ʬ�δؿ�
require_once(PATH ."function/trade_fc.fnc");

//�����ʡ���ưPOST������δؿ�
require_once(INCLUDE_DIR ."function_keiyaku.inc");

//���顼��å������γ����ե�����
require_once(INCLUDE_DIR ."error_msg_list.inc");


//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³
$db_con = Db_Connect();
//���������ξ�������������к�
//$db_con = (strpos($_SERVER["PHP_SELF"], "demo") !== false) ? Db_Connect() : Db_Connect("amenity_kaji_make");
//echo "<font color=red style=\"font-family: 'HGS�Խ���';\"><b>�Խ���ˤĤ���<s>���ޤ�</s>��Ͽ�Ǥ��ޤ���</b></font>";


// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// GET����ID�������������å�
if (Get_Id_Check_Db($db_con, $_GET["sale_id"], "sale_id", "t_sale_h", "num") == false && $_GET["sale_id"] != null){
    Header("Location: ../top.php");
    exit;
}


/*****************************/ 
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null){
    Set_Rtn_Page("sale");
}


/****************************/
//�����ѿ�����
/****************************/
$shop_id     = $_POST["hdn_cclient_id"];
$intro_account_id   = $_POST["hdn_intro_account_id"];
$client_h_id = $_SESSION["client_id"];
//$rank_cd     = $_SESSION["rank_cd"];
$e_staff_id  = $_SESSION["staff_id"];
$group_kind  = $_SESSION["group_kind"];
$sale_id     = $_GET["sale_id"];     //���ID
Get_Id_Check3($sale_id);
//$aord_id     = $_GET["aord_id"];     //����ID
$done_flg    = $_GET["done_flg"];     //��Ͽ��λ�ե饰
$slip_del_flg = $_GET["slip_del_flg"];  //��ɼ����ե饰
$hand_slip_flg = true;                  //�����ɼ�ե饰

//���ID��hidden�ˤ���ݻ�����
if($_GET["sale_id"] != NULL){
    if($_GET["slip_copy"] != "true"){
        $set_id_data["hdn_sale_id"] = $sale_id;
        $form->setConstants($set_id_data);
    }
}else{
    $sale_id = $_POST["hdn_sale_id"];
}

//����ʬ
$contract_div = ($_POST["daiko_check"] == "1" || $_POST["daiko_check"] == null) ? "1" : $_POST["daiko_check"];
//print_array($contract_div, "����ʬ");


$error_flg = false;


#2009-12-22 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($client_h_id);


/****************************/
// ���������Ѥ�
/****************************/

//GET��renew_flg�����������ɽ���˾�硢�ޤ������������Ѥξ��freeze�����
if($_GET["renew_flg"] == "true"){
    $renew_flg = "true";
}elseif($sale_id != null){
    $sql  = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $sale_id AND ";
    $sql .= ($_SESSION["group_kind"] == "2") ? "shop_id IN (".Rank_Sql().");" : "shop_id = ".$_SESSION["client_id"].";";
    $result = Db_Query($db_con, $sql);
    //Get_Id_Check($result);
    if(pg_num_rows($result) != 0){
        if(pg_fetch_result($result, 0, "renew_flg") == "t"){
            $renew_flg = "true";
            if($_POST["hdn_comp_button"] == "�ϡ���"){
                $slip_renew_mess = $h_mess[50];
                $error_flg = true;
            }
        }else{
            $renew_flg = "false";
        }
    }else{
        $renew_flg = "false";
    }
}else{
    $renew_flg = "false";
}

if($renew_flg == "true"){
    $form->freeze();
}


/****************************/
//�������
/****************************/
//ɽ���Կ�
//if($_POST["max_row"] != null){
//    $max_row = $_POST["max_row"];
//}else{
    $max_row = 5;
//}
//�����褬���ꤵ��Ƥ��뤫
//if($_POST["hdn_client_id"] == null || $_POST["hdn_ware_id"] == null){
if($_POST["hdn_client_id"] == null){
    $warning = "����������򤷤Ƥ���������";

}else{
    $warning = null;
    $client_id    = $_POST["hdn_client_id"];
    $ware_id      = $_POST["hdn_ware_id"];
    $coax         = $_POST["hdn_coax"];
    $tax_franct   = $_POST["hdn_tax_franct"];
    //$attach_gid   = $_POST["attach_gid"];
    $client_shop_id = $_POST["client_shop_id"];
    $client_name  = $_POST["form_client"]["name"];

}


//����ѹ�Ƚ��
if($sale_id != NULL && $client_id == NULL && $done_flg != "true"){
    //���إå�����SQL
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.sale_no, ";       //0
    $sql .= "    t_sale_h.client_id, ";     //1
    $sql .= "    t_sale_h.client_cd1, ";    //2
    $sql .= "    t_sale_h.client_cd2, ";    //3
    //$sql .= "    t_sale_h.client_name, ";
    $sql .= "    t_client.client_cname, ";  //4
    $sql .= "    t_sale_h.sale_day, ";      //5
    $sql .= "    t_sale_h.claim_day, ";     //6
    $sql .= "    t_sale_h.ware_id, ";       //7
    $sql .= "    t_sale_h.trade_id, ";      //8
    $sql .= "    t_sale_h.green_flg, ";     //9
    $sql .= "    t_sale_h.trans_id, ";      //10
    $sql .= "    t_sale_staff.staff_id, ";  //11
    $sql .= "    t_sale_h.direct_id, ";     //12
    $sql .= "    t_sale_h.note, ";          //13
    $sql .= "    t_sale_h.shop_id, ";       //14
    $sql .= "    t_sale_h.claim_id, ";      //15
    $sql .= "    t_sale_h.claim_div, ";     //16
    $sql .= "    t_sale_h.enter_day, ";     //17
    $sql .= "    t_sale_h.act_id, ";        //18 ��Լ�ID
    $sql .= "    t_sale_h.act_cd1, ";       //19 ��Լ�CD1
    $sql .= "    t_sale_h.act_cd2, ";       //20 ��Լ�CD2
    $sql .= "    t_sale_h.act_name1, ";     //21 ��Լ�̾1
    $sql .= "    t_sale_h.act_name2, ";     //22 ��Լ�̾2
    $sql .= "    t_sale_h.act_cname, ";     //23 ��Լ�̾��ά�Ρ�
    $sql .= "    t_sale_h.act_request_rate, ";  //24 ��԰������ʡ��
    $sql .= "    t_sale_h.contract_div, ";  //25 �����ʬ
    $sql .= "    t_sale_h.intro_account_id, ";  //26 �Ҳ��ID
    $sql .= "    t_sale_h.intro_ac_name, ";     //27 �Ҳ��̾��ά�Ρ�
    $sql .= "    t_sale_h.intro_ac_cd1, ";      //28 �Ҳ��̾CD1
    $sql .= "    t_sale_h.intro_ac_cd2, ";      //29 �Ҳ��̾CD2
    $sql .= "    t_sale_h.intro_ac_div, ";      //30 �Ҳ�����ʬ
    $sql .= "    t_sale_h.intro_ac_price, ";    //31 �Ҳ���ñ��
    $sql .= "    t_sale_h.intro_ac_rate, ";     //32 �Ҳ���Ψ
    $sql .= "    t_sale_h.act_div, ";           //33 �������ʬ
    $sql .= "    t_sale_h.act_request_price, "; //34 ������ʸ���ۡ�
    $sql .= "    t_sale_h.net_amount, ";        //35 ����ۡ���ȴ��
    $sql .= "    t_sale_h.tax_amount, ";        //36 �����ǳ�
    $sql .= "    t_sale_h.advance_offset_totalamount ";     //37 �������껦�۹��

    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    //$sql .= "    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "    LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "    t_sale_h.shop_id = ".$_SESSION["client_id"]." ";
    }
    $sql .= "    AND ";
    $sql .= "    t_sale_h.sale_id = $sale_id;";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);

    //GET�ǡ���Ƚ��
    Get_Id_Check($result);
    $h_data_list = Get_Data($result, 2);
//print_array($h_data_list);

    //���ǡ�������SQL
    $sql  = "SELECT \n";
    $sql .= "    t_sale_d.sale_d_id, \n";   //0 ���ǡ���ID
    $sql .= "    t_sale_d.sale_id, \n";     //1 ���ID
    $sql .= "    t_sale_d.goods_id, \n";    //2 �����ƥ�ID
    $sql .= "    t_sale_d.goods_cd, \n";    //3 �����ƥ�CD
    $sql .= "    t_sale_d.goods_name, \n";  //4 �����ƥ�̾��ά�Ρ�
    //(2006-08-31) ľ�Ĥξ��Ϻ߸˿����פ���
    //$sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, \n";
/*
    $sql .= "    CASE t_goods.stock_manage \n";
    $sql .= "        WHEN 1 THEN \n";
    $sql .= "            COALESCE( \n";
    $sql .= "                ( \n";
    $sql .= "                    SELECT \n";
    $sql .= "                        SUM(t_stock.stock_num) \n";
    $sql .= "                    FROM \n";
    $sql .= "                        t_stock \n";
    $sql .= "                        INNER JOIN t_sale_h ON t_sale_h.ware_id = t_stock.ware_id \n";
    $sql .= "                        INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
    $sql .= "                    WHERE \n";
    $sql .= "                        t_stock.goods_id = t_sale_d.goods_id \n";
    $sql .= "                        AND \n";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "                        t_stock.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "                        t_stock.shop_id = $_SESSION[client_id] \n";
    }
    $sql .= "                        AND \n";
    $sql .= "                        t_sale_h.sale_id = $sale_id \n";
    $sql .= "                    GROUP BY \n";
    $sql .= "                        t_stock.ware_id \n";
    $sql .= "                ), 0 \n";
    $sql .= "            ) \n";
    $sql .= "    END AS stock_num, \n";     //5
*/
    $sql .= "    NULL, \n";                 //5��̤���ѡ�
    $sql .= "    t_sale_d.num, \n";         //6 ����
    $sql .= "    t_sale_d.tax_div, \n";     //7 ���Ƕ�ʬ
    $sql .= "    t_sale_d.cost_price, \n";  //8 �Ķȸ���
    $sql .= "    t_sale_d.sale_price, \n";  //9 ���ñ��
    $sql .= "    t_sale_d.cost_amount, \n"; //10 �������
    $sql .= "    t_sale_d.sale_amount, \n"; //11 �����
    $sql .= "    t_goods.name_change, \n";  //12 ��̾�ѹ�
    //(2006-08-18) �������ʬ�פ�֥����ӥ��פ����ϲ�ǽ��
    $sql .= "    t_sale_d.sale_div_cd, \n"; //13 �����ʬ
    $sql .= "    t_sale_d.serv_id, \n";     //14 �����ӥ�ID
    $sql .= "    t_sale_d.serv_cd, \n";     //15 �����ӥ�CD
    $sql .= "    t_sale_d.serv_name, \n";   //16 �����ӥ�̾
    //(2006-08-21) �����ӥ������ʰ��������å��ܥå������켰�����å��ܥå����ɲ�
    $sql .= "    t_sale_d.serv_print_flg, \n";  //17 �����ӥ������ե饰
    $sql .= "    t_sale_d.goods_print_flg, \n"; //18 �����ƥ�����ե饰
    $sql .= "    t_sale_d.set_flg, \n";     //19 �켰�ե饰
    $sql .= "    t_sale_d.line, \n";        //20 ���ֹ�
    $sql .= "    t_sale_d.official_goods_name, \n"; //21 �����ƥ�̾��������
    $sql .= "    t_sale_d.egoods_id, \n";   //22 ������ID
    $sql .= "    t_sale_d.egoods_cd, \n";   //23 ������CD
    $sql .= "    t_sale_d.egoods_name, \n"; //24 ������̾
    $sql .= "    t_sale_d.egoods_num, \n";  //25 �����ʿ�
    $sql .= "    t_goods2.name_change, \n"; //26 ������̾�ѹ�
    $sql .= "    t_sale_d.rgoods_id, \n";   //27 ���ξ���ID
    $sql .= "    t_sale_d.rgoods_cd, \n";   //28 ���ξ���CD
    $sql .= "    t_sale_d.rgoods_name, \n"; //29 ���ξ���̾
    $sql .= "    t_sale_d.rgoods_num, \n";  //30 ���ξ��ʿ�
    $sql .= "    t_goods3.name_change, \n"; //31 ���ξ���̾�ѹ�
    $sql .= "    t_sale_d.account_price, \n";   //32 ����ñ��
    $sql .= "    t_sale_d.account_rate, \n";    //33 ����Ψ
    $sql .= "    t_sale_d.advance_flg, \n";             //34 �����껦�ե饰
    //aoyama-n 2009-09-8
    #$sql .= "    t_sale_d.advance_offset_amount \n";    //35 �����껦��
    $sql .= "    t_sale_d.advance_offset_amount, \n";    //35 �����껦��
    $sql .= "    t_goods.discount_flg \n";               //36 �Ͱ��ե饰

    $sql .= "FROM \n";
    $sql .= "    t_sale_d \n";
    $sql .= "    LEFT JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id \n";
    //aoyama-n 2009-09-08
    //�����ʤ����ξ��ʤ���̾�ѹ��ե饰��о��ߥ�����
    #$sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_sale_d.goods_id = t_goods2.goods_id \n";
    #$sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_sale_d.goods_id = t_goods3.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods2 ON t_sale_d.egoods_id = t_goods2.goods_id \n";
    $sql .= "    LEFT JOIN t_goods AS t_goods3 ON t_sale_d.rgoods_id = t_goods3.goods_id \n";
/*
    $sql .= "    LEFT JOIN t_stock ON t_sale_d.goods_id = t_stock.goods_id \n";
    $sql .= "        AND t_stock.ware_id = ".$h_data_list[0][7]." \n";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "        AND t_stock.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "        AND t_stock.shop_id = $_SESSION[client_id] \n";
    }
*/
    $sql .= "WHERE \n";
    $sql .= "    sale_id = $sale_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "    t_sale_d.line \n";
    $sql .= ";\n";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $data_list = Get_Data($result, 2);

    //������ξ�������
    $sql  = "SELECT";
    $sql .= "   t_client.client_id,";
    $sql .= "   t_client.coax,";
    $sql .= "   t_client.tax_franct,";
    $sql .= "   t_client_info.cclient_shop ";
    $sql .= " FROM";
    $sql .= "   t_client";
    $sql .= "   INNER JOIN t_client_info ON t_client_info.client_id = t_client.client_id ";
    $sql .= " WHERE";
    $sql .= "   t_client.client_id = ".$h_data_list[0][1];
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $client_list = Get_Data($result, 2);

    /****************************/
    //�ե�������ͤ�����
    /****************************/
    $sale_money = NULL;                        //���ʤ������
    $tax_div    = NULL;                        //���Ƕ�ʬ

    //�إå�������
    $update_goods_data["form_sale_no"]                  = $h_data_list[0][0];       //��ɼ�ֹ�

    $update_goods_data["form_client"]["cd1"]            = $h_data_list[0][2];       //�����襳���ɣ�
    $update_goods_data["form_client"]["cd2"]            = $h_data_list[0][3];       //�����襳���ɣ�
    $update_goods_data["form_client"]["name"]           = $h_data_list[0][4];       //������̾

    //���׾�����ǯ������ʬ����
    $ex_sale_day = explode('-',$h_data_list[0][5]);
    $update_goods_data["form_delivery_day"]["y"]        = $ex_sale_day[0];          //���׾���
    $update_goods_data["form_delivery_day"]["m"]        = $ex_sale_day[1];
    $update_goods_data["form_delivery_day"]["d"]        = $ex_sale_day[2];

    //��������ǯ������ʬ����
    $ex_claim_day = explode('-',$h_data_list[0][6]);
    $update_goods_data["form_request_day"]["y"]         = $ex_claim_day[0];         //������
    $update_goods_data["form_request_day"]["m"]         = $ex_claim_day[1];
    $update_goods_data["form_request_day"]["d"]         = $ex_claim_day[2];

    $update_goods_data["form_ware_select"]              = $h_data_list[0][7];       //�в��Ҹ�
    $update_goods_data["hdn_ware_id"]                   = $h_data_list[0][7];       //�в��Ҹ�
    $update_goods_data["trade_sale_select"]             = $h_data_list[0][8];       //�����ʬ
    $update_goods_data["form_ac_staff_select"]          = $h_data_list[0][11];      //���ô����
    $update_goods_data["form_direct_select"]            = $h_data_list[0][12];      //ľ����
    $update_goods_data["form_note"]                     = $h_data_list[0][13];      //����

    $update_goods_data["hdn_cclient_id"]                = $h_data_list[0][14];      //ô����ŹID
    $update_goods_data["form_claim"]                    = $h_data_list[0][15].",".$h_data_list[0][16];  //������

    $update_goods_data["hdn_enter_day"]                 = $h_data_list[0][17];      //��Ͽ��

    $contract_div = ($_POST["daiko_check"] != null) ? $contract_div : $h_data_list[0][25];  //�����ʬ
    $update_goods_data["daiko_check"]                   = $contract_div;
    $act_id                                             = $h_data_list[0][18];      //��Լ�ID
    $update_goods_data["hdn_daiko_id"]                  = $act_id;
    $update_goods_data["form_daiko"]["cd1"]             = $h_data_list[0][19];      //��Լ�CD1
    $update_goods_data["form_daiko"]["cd2"]             = $h_data_list[0][20];      //��Լ�CD2
    $update_goods_data["form_daiko"]["name"]            = $h_data_list[0][23];      //��Լ�̾��ά�Ρ�
    $update_goods_data["act_div[]"]                     = $h_data_list[0][33];      //�������ʬ
    $update_goods_data["act_request_rate"]              = $h_data_list[0][24];      //��԰������ʡ��
    $update_goods_data["act_request_price"]             = $h_data_list[0][34];      //��԰������ʸ���ۡ�

    //����褬�����硢�����Τޤ���ʬ�����
    if($act_id != null){
        $sql = "SELECT coax FROM t_client WHERE client_id = $act_id;";
        $result = Db_Query($db_con, $sql);
        $daiko_coax = pg_fetch_result($result, 0, "coax");
        $update_goods_data["hdn_daiko_coax"] = $daiko_coax;
    }


    $intro_account_id                                   = $h_data_list[0][26];      //�Ҳ��ID
    $update_goods_data["hdn_intro_account_id"]          = $intro_account_id;
    $update_goods_data["intro_ac_div[]"]                = $h_data_list[0][30];      //�Ҳ�����ʬ
    $update_goods_data["intro_ac_price"]                = $h_data_list[0][31];      //�Ҳ����ñ��
    $update_goods_data["intro_ac_rate"]                 = $h_data_list[0][32];      //�Ҳ����Ψ


    //�ǡ�������
    $loop_num = count($data_list);
    for($i=0; $i<$loop_num; $i++){
    //for($i=0;$i<5;$i++){
        $update_line = $data_list[$i][20];

        //���¶�ʬ�ν���ͤ����ꤷ�ʤ�������
        $aprice_array[] = $update_line;

        //(2006-08-18) �������ʬ�פ�֥����ӥ��פ����ϲ�ǽ��
        $update_goods_data["form_divide"][$update_line]             = $data_list[$i][13];       //�����ʬ

        $update_goods_data["form_serv"][$update_line]               = $data_list[$i][14];       //�����ӥ�ID
        $update_goods_data["form_print_flg1"][$update_line]         = ($data_list[$i][17] == "t") ? "1" : "";   //�����ӥ������ե饰

        $update_goods_data["hdn_goods_id1"][$update_line]           = $data_list[$i][2];        //�����ƥ�ID
        $update_goods_data["hdn_name_change1"][$update_line]        = $data_list[$i][12];       //��̾�ѹ��ե饰
        $hdn_name_change[1][$update_line]                           = $data_list[$i][12];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
        $update_goods_data["form_goods_cd1"][$update_line]          = $data_list[$i][3];        //�����ƥ�CD
        $update_goods_data["form_goods_name1"][$update_line]        = $data_list[$i][4];        //�����ƥ�̾��ά�Ρ�
        $update_goods_data["form_goods_num1"][$update_line]         = $data_list[$i][6];        //�����ƥ��
        $update_goods_data["form_print_flg2"][$update_line]         = ($data_list[$i][18] == "t") ? "1" : "";   //�����ƥ�����ե饰
        $update_goods_data["official_goods_name"][$update_line]     = $data_list[$i][21];       //�����ƥ�̾��������

        //$update_goods_data["form_stock_num"][$update_line]          = $data_list[$i][5];        //���߸˿�
        $update_goods_data["hdn_tax_div"][$update_line]             = $data_list[$i][7];        //���Ƕ�ʬ
        $update_goods_data["form_issiki"][$update_line]             = ($data_list[$i][19] == "t") ? "1" : "";   //�켰

        //����ñ�����������Ⱦ�������ʬ����
        $cost_mprice = explode('.', $data_list[$i][8]);
        $update_goods_data["form_trade_price"][$update_line]["1"]   = $cost_mprice[0];          //����ñ��
        $update_goods_data["form_trade_price"][$update_line]["2"]   = ($cost_mprice[1] != null)? $cost_mprice[1] : '00';     
        $update_goods_data["form_trade_amount"][$update_line]       = number_format($data_list[$i][10]);    //�������

        //���ñ�����������Ⱦ�������ʬ����
        $sale_mprice = explode('.', $data_list[$i][9]);
        $update_goods_data["form_sale_price"][$update_line]["1"]    = $sale_mprice[0];          //���ñ��
        $update_goods_data["form_sale_price"][$update_line]["2"]    = ($sale_mprice[1] != null)? $sale_mprice[1] : '00';
        $update_goods_data["form_sale_amount"][$update_line]        = number_format($data_list[$i][11]);    //�����

        $update_goods_data["hdn_goods_id3"][$update_line]           = $data_list[$i][22];       //������ID
        $update_goods_data["hdn_name_change3"][$update_line]        = $data_list[$i][26];       //������̾�ѹ��ե饰
        $hdn_name_change[3][$update_line]                           = $data_list[$i][26];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
        $update_goods_data["form_goods_cd3"][$update_line]          = $data_list[$i][23];       //������CD
        $update_goods_data["form_goods_name3"][$update_line]        = $data_list[$i][24];       //������̾
        $update_goods_data["form_goods_num3"][$update_line]         = $data_list[$i][25];       //�����ʿ�

        $update_goods_data["hdn_goods_id2"][$update_line]           = $data_list[$i][27];       //���ξ���ID
        $update_goods_data["hdn_name_change2"][$update_line]        = $data_list[$i][31];       //���ξ���̾�ѹ��ե饰
        $hdn_name_change[2][$update_line]                           = $data_list[$i][31];       //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
        $update_goods_data["form_goods_cd2"][$update_line]          = $data_list[$i][28];       //���ξ���CD
        $update_goods_data["form_goods_name2"][$update_line]        = $data_list[$i][29];       //���ξ���̾
        $update_goods_data["form_goods_num2"][$update_line]         = $data_list[$i][30];       //���ξ��ʿ�

        //�Ҳ���
        if($intro_account_id != null){
            //����ñ������ξ��ϡָ���ۡ�
            if($data_list[$i][32] != null && $data_list[$i][33] == null){
                $update_goods_data["form_aprice_div"][$update_line] = "2";
                $update_goods_data["form_account_price"][$update_line] = $data_list[$i][32];
            //����Ψ����ξ��ϡ����Ρ�
            }elseif($data_list[$i][32] == null && $data_list[$i][33] != null){
                $update_goods_data["form_aprice_div"][$update_line] = "3";
                $update_goods_data["form_account_rate"][$update_line] = $data_list[$i][33];
            //����ñ��������Ψ�Ȥ���ξ��ϡ֤ʤ���
            }else{
                $update_goods_data["form_aprice_div"][$update_line] = "1";
            }
        //�Ҳ�Ԥ��ʤ����ϡ֤ʤ���
        }else{
            $update_goods_data["form_aprice_div"][$update_line] = "1";
        }

        $update_goods_data["form_ad_offset_radio"][$update_line]    = $data_list[$i][34];       //�����껦�ե饰
        $update_goods_data["form_ad_offset_amount"][$update_line]   = $data_list[$i][35];       //�����껦��
        //aoyama-n 2009-09-08
        $update_goods_data["hdn_discount_flg"][$update_line]        = $data_list[$i][36];       //�Ͱ��ե饰


        $sale_money[]   = $data_list[$i][11];  //����۹��
        $tax_div[]      = $data_list[$i][7];  //���Ƕ�ʬ
    }

    //�������������
    $client_id      = $client_list[0][0];        //������ID
    $coax           = $client_list[0][1];        //�ݤ��ʬ�ʶ�ۡ�
    $tax_franct     = $client_list[0][2];        //ü����ʬ�ʾ����ǡ�
    //$client_shop_id = $client_list[0][3];        //������Υ���å�ID
    $client_shop_id = $h_data_list[0][14];       //������Υ���å�ID
    $warning = null;
    $update_goods_data["hdn_client_id"]       = $client_id;
    $update_goods_data["hdn_coax"]            = $coax;
    $update_goods_data["hdn_tax_franct"]      = $tax_franct;
    $update_goods_data["client_shop_id"]      = $client_shop_id;

/*
    //���ߤξ�����Ψ
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    //$sql .= "    client_id = $shop_id;";
    $sql .= "    client_id = $client_shop_id;";
    $result = Db_Query($db_con, $sql); 
    $tax_num = pg_fetch_result($result, 0,0);

    $total_money = Total_Amount($sale_money, $tax_div,$coax,$tax_franct,$tax_num,$client_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
*/

    $sale_money = number_format($h_data_list[0][35]);
    $tax_money  = number_format($h_data_list[0][36]);
    $st_money   = number_format($h_data_list[0][35] + $h_data_list[0][36]);
    $advance_offset_totalamount = ($h_data_list[0][37] == null) ? "" : number_format($h_data_list[0][37]);
    //�Ȳ���̡����������ѡ�����ɽ�����ˤǤϤ�����ɼ��ȯ������������ϻĹ�˴ޤ�ʤ�
    if($renew_flg == "true" || $_GET["slip_copy"] == "true"){
        $ad_rest_price = number_format(Advance_Offset_Claim($db_con, $h_data_list[0][5], $client_id, $h_data_list[0][16]));
    }else{
        $ad_rest_price = number_format(Advance_Offset_Claim($db_con, $h_data_list[0][5], $client_id, $h_data_list[0][16], $sale_id));
    }

    //�ե�������ͥ��å�
    $update_goods_data["form_sale_total"]      = $sale_money;
    $update_goods_data["form_sale_tax"]        = $tax_money;
    $update_goods_data["form_sale_money"]      = $st_money;
    $update_goods_data["form_ad_offset_total"] = $advance_offset_totalamount;
    $update_goods_data["form_ad_rest_price"]   = $ad_rest_price;
    $update_goods_data["sum_button_flg"]       = "";

    //������Ͽ�ե饰
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "false";
        $form->setDefaults(array("hdn_new_entry" => "false"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

//print_array($update_goods_data, "update_goods_data");
    //$form->setConstants($update_goods_data);
    $form->setDefaults($update_goods_data);

/*
    //ɽ���Կ�
    if($_POST["max_row"] != NULL){
        $max_row = $_POST["max_row"];
    }else{
        //����ǡ����ο�
        $max_row = count($data_list);
    }
*/
    $max_row = 5;

}else{
    //��ư���֤���ɼ�ֹ����
    //ľ�Ĥξ��
    if($_SESSION["group_kind"] == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FC�ξ��
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = ".$_SESSION["client_id"].";";
    }

/*
    $sql  = "SELECT";
    $sql .= "   MAX(sale_no)";
    //$sql .= "   MAX(ord_no)";
    $sql .= " FROM";
    $sql .= "   t_sale_h";
    //$sql .= "   t_aorder_h";
    $sql .= " WHERE";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    shop_id IN (".Rank_Sql().") ";
    }else{
        $sql .= "    shop_id = $shop_id";
    }
    $sql .= ";";
*/
    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;

    //ô����
    $def_data["form_ac_staff_select"] = $e_staff_id;
    //$def_data["form_staff_select"] = $e_staff_id;
    //�����ʬ
    $def_data["trade_sale_select"] = 11;

    //���׾���
    $def_data["form_delivery_day"]["y"] = date("Y");
    $def_data["form_delivery_day"]["m"] = date("m");
    $def_data["form_delivery_day"]["d"] = date("d");

    //������
    $def_data["form_request_day"]["y"] = date("Y");
    $def_data["form_request_day"]["m"] = date("m");
    $def_data["form_request_day"]["d"] = date("d");

    //�в��Ҹ�
/*
    $sql  = "SELECT";
    $sql .= "   ware_id ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = ";
    $sql .= ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
    $sql .= ";";
*/
    //������桼����ô����Ź�ε����Ҹˤ����
    $sql  = "SELECT \n";
    $sql .= "    t_branch.bases_ware_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_branch \n";
    $sql .= "    INNER JOIN t_part ON t_branch.branch_id = t_part.branch_id \n";
    $sql .= "    INNER JOIN t_attach ON t_part.part_id = t_attach.part_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_attach.staff_id = ".$_SESSION["staff_id"]." \n";
    $sql .= ";";

    $result = Db_Query($db_con,$sql);
    $def_ware_id = pg_fetch_result($result,0,0);

    $def_data["form_ware_select"] = $def_ware_id;
    $def_data["hdn_ware_id"]      = $def_ware_id;

    //������Ͽ�ե饰
    if($_POST["hdn_new_entry"] == null){
        $new_entry = "true";
        $form->setDefaults(array("hdn_new_entry" => "true"));
    }else{
        $new_entry = $_POST["hdn_new_entry"];
    }

    //�Ҳ�����ʬ
    $def_data["intro_ac_div[]"] = ($_POST["intro_ac_div"][0] != null) ? $_POST["intro_ac_div"][0] : "1" ;

    //�������ʬ
    $def_data["act_div[]"] = ($_POST["act_div"][0] != null) ? $_POST["act_div"][0] : "1" ;

    //������
    //�饸���ܥ��������������
    $aprice_array = array();


    //ɽ���Կ�
    //if($_POST["max_row"] != NULL){
    //    $max_row = $_POST["max_row"];
    //}else{
        $max_row = 5;
    //}

}

//�ǡ�����̵�����¶�ʬ�������껦�ե饰�ν��������
for($i=1;$i<=5;$i++){
    if(!in_array($i, $aprice_array)) {
        //�ʤ�
        $def_data["form_aprice_div[$i]"] = "1";
        $def_data["form_ad_offset_radio"][$i] = "1";
    }
}


//ʣ���ɲäξ�硢��������ɼ�ֹ�����
if($_GET["slip_copy"] == "true"){
    //��ư���֤���ɼ�ֹ����
    //ľ�Ĥξ��
    if($_SESSION["group_kind"] == "2"){
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
    //FC�ξ��
    }else{
        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = ".$_SESSION["client_id"].";";
    }

    $result = Db_Query($db_con, $sql);
    $sale_no = pg_fetch_result($result, 0 ,0);
    $sale_no = $sale_no +1;
    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

    $def_data["form_sale_no"] = $sale_no;

    $sale_id = "";
}


$form->setDefaults($def_data);


//���ɽ�������ѹ�
$form_potision = "<body bgcolor=\"#D8D0C8\">";

//����Կ�
$del_history[] = NULL; 

/****************************/
//�Կ��ɲý���
/****************************/
/*
if($_POST["add_row_flg"]==true){
    if($_POST["max_row"] == NULL){
        //����ͤ�POST��̵���١�
        $max_row = 10;
    }else{
        //����Ԥˡ��ܣ�����
        $max_row = $_POST["max_row"]+5;
    }
    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}
*/

/****************************/
//�Ժ������
/****************************/
/*
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
    //��������Կ�
    $del_num     = count($del_history)-1;
}
*/

//***************************/
//����Կ���hidden�˥��å�
/****************************/
/*
$max_row_data["max_row"] = $max_row;
$form->setConstants($max_row_data);
*/


/****************************/
//�ԥ��ꥢ����
/****************************/
/*
if($_POST["clear_line"] != ""){
    Clear_Line_Data2($form, $_POST["clear_line"]);
}
*/


/****************************/
//�����襳�������Ͻ���
/****************************/
if($_POST["client_search_flg"] == true && $done_flg != "true"){
    $client_cd1         = $_POST["form_client"]["cd1"];       //�����襳����1
    $client_cd2         = $_POST["form_client"]["cd2"];       //�����襳����2

    //������ξ�������
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id, \n";               // 0
    $sql .= "    t_client.shop_id, \n";                 // 1
    $sql .= "    t_client.client_cname, \n";            // 2
    $sql .= "    t_client.coax, \n";                    // 3
    $sql .= "    t_client.tax_franct, \n";              // 4
    $sql .= "    t_client.rank_cd, \n";                 // 5
    $sql .= "    t_client_info.cclient_shop, \n";       // 6
    $sql .= "    t_client_info.intro_account_id, \n";   // 7
    $sql .= "    t_info_account.client_cname, \n";      // 8
    $sql .= "    t_client.trade_id \n";                 // 9 �����ʬ
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "    LEFT JOIN t_client AS t_info_account ON t_client_info.intro_account_id = t_info_account.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$client_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$client_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '1' \n";
    $sql .= "    AND \n";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    t_client.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "   t_client.shop_id = ".$_SESSION["client_id"]." \n";
    }
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //�����ǡ���������
    if($num == 1){
        $client_id      = pg_fetch_result($result, 0,0);        //������ID
        $client_shop_id = pg_fetch_result($result, 0,1);        //������Υ���å�ID
        $client_name    = pg_fetch_result($result, 0,2);        //������̾��ά�Ρ�
        $coax           = pg_fetch_result($result, 0,3);        //�ݤ��ʬ�ʾ��ʡ�
        $tax_franct     = pg_fetch_result($result, 0,4);        //ü����ʬ�ʾ����ǡ�
        //$rank_cd        = pg_fetch_result($result, 0,5);        //�ܵҶ�ʬ������
        $shop_id        = pg_fetch_result($result, 0,6);        //ô����Ź
        $intro_account_id   = pg_fetch_result($result, 0,7);    //�Ҳ������ID
        $client_ac_name = pg_fetch_result($result, 0,8);        //�Ҳ������̾

        //���������ǡ�����ե�����˥��å�
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = $client_id;
        $client_data["client_shop_id"]      = $client_shop_id;
        $client_data["form_client"]["name"] = $client_name;
        $client_data["hdn_coax"]            = $coax;
        $client_data["hdn_tax_franct"]      = $tax_franct;
        //$client_data["hdn_rank_cd"]         = $rank_cd;
        $client_data["hdn_cclient_id"]      = $shop_id;
        $client_data["hdn_intro_account_id"]    = ($intro_account_id != null) ? $intro_account_id : "";
        $client_data["form_intro_account_name"] = ($intro_account_id != null) ? $client_ac_name : "";

        //�в��Ҹˤ����򤵤�Ƥ����顢�ٹ���ɽ��
        if($_POST["form_ware_select"] != NULL){
            $warning = null;
        }

        $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ
        $client_data["trade_sale_select"]   = pg_fetch_result($result, 0, 9);   //�����ʬ


        //------------------------------------//
        // �ƹԤζ�ۤ�������Τޤ��ǺƷ׻� //
        //------------------------------------//
        //$cost_money  = NULL;    //���ʤθ������
        $sale_money  = NULL;    //���ʤ������
        $tax_div_arr = NULL;    //���Ƕ�ʬ

        for($i = 1; $i <= $max_row; $i++){
            //�����ӥ����ޤ��ϥ����ƥब���Ϥ���Ƥ���ԤΤ߼���
            if($_POST["form_serv"][$i] != null || $_POST["hdn_goods_id1"][$i] != null){

                //���̤���ξ�硢ñ���߿��̡���
                if($_POST["form_goods_num1"][$i] != null){
                    $price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                //���̤ʤ��ξ�硢��ۡ�0
                }else{
                    $price = 0;
                }
                //������ۤ�ޤ��
                if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
                    //���ҽ�󡢤ޤ�����Ԥ���������褬���ꤵ��Ƥʤ�����������Τޤ���ʬ
                    $price = Coax_Col($coax, $price);
                }elseif($_POST["hdn_daiko_id"] != null){
                    //�����ɼ�ǡ�����褬���ꤵ��Ƥ�����������Τޤ���ʬ
                    $price = Coax_Col($_POST["hdn_daiko_coax"], $price);
                }

                $client_data["form_trade_amount"][$i] = number_format($price);  //������ۥե������ɽ��
                //$cost_money[] = $price;


                //���ñ����������ۤ�׻�
                if($_POST["form_issiki"][$i] != null){
                    //�켰�˥����å��������硢ñ���ߣ�����
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                }elseif($_POST["form_goods_num1"][$i] != null){
                    //�켰�ʤ������̤���ξ�硢ñ���߿��̡���
                    $price = $_POST["form_sale_price"][$i][1].".".$_POST["form_sale_price"][$i][2];
                    $price = $price * $_POST["form_goods_num1"][$i];
                }else{
                    //�켰�ʤ������̤ʤ��ξ�硢��ۡ�0
                    $price = 0;
                }
                //����ۤ�ޤ��
                $price = Coax_Col($coax, $price);

                $client_data["form_sale_amount"][$i] = number_format($price);   //����ۥե������ɽ��
                $sale_money[] = $price;


                //�����ƥब���Ϥ���Ƥ�����ϥ����ƥ�β��Ƕ�ʬ�����
                if($_POST["hdn_goods_id1"][$i] != null){
                    $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                //�����ƥब�ʤ����ϥ����ӥ��β��Ƕ�ʬ�����
                }else{
                    $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                }

                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);    //���Ƕ�ʬ������ˤĤ��
            }
        }

        #2009-12-22 aoyama-n
        #$tax_num = Get_Tax_Rate($db_con, $shop_id);     //������Ρʵ��ô����Ź�ξ�����Ψ�����

        #2009-12-22 aoyama-n
        $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

/*
        //���ҽ�󡢤ޤ�����Ԥ���������褬���ꤵ��Ƥʤ���硢������������δݤ�Ǥޤ��
        if($contract_div == "1" || $_POST["hdn_daiko_id"] == null){
            $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

        //��Ԥξ�硢�����������δݤ�Ǥޤ��
        }else{
            $total_money = Total_Amount($cost_money, $tax_div_arr, $_POST["hdn_daiko_coax"], $tax_franct, $tax_num, $client_id, $db_con);
        }
        $cost_money  = $total_money[0];     //������ۡ���ȴ��
*/

        $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
        $sale_money  = $total_money[0];     //����ۡ���ȴ��
        $sale_tax    = $total_money[1];     //�����ǳ�

        //�ե�������ͥ��å�
        $client_data["form_sale_total"]   = number_format($sale_money);
        $client_data["form_sale_tax"]     = number_format($sale_tax);
        $client_data["form_sale_money"]   = number_format($sale_money + $sale_tax);
        //$client_data["form_ad_offset_total"] = $ad_offset_total;

    }else{
        //$warning = "������Ƚв��Ҹ����򤷤Ƥ���������";
        $warning = "����������򤷤Ƥ���������";
        $client_data["client_search_flg"]   = "";
        $client_data["hdn_client_id"]       = "";
        $client_data["client_shop_id"]      = "";
        $client_data["form_client"]["name"] = "";
        $client_data["hdn_coax"]            = "";
        $client_data["hdn_tax_franct"]      = "";
        //$client_data["hdn_rank_cd"]         = "";
        $client_data["hdn_cclient_id"]      = "";
        $client_data["hdn_intro_account_id"]    = "";
        $intro_account_id                   = "";
        $client_data["form_intro_account_name"] = "";
        $client_id                          = null;      //������ID

        $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ
        $client_data["trade_sale_select"]   = 11;       //�����ʬ

    }
/*
    //�������Ϥ��줿�ͤ�����
    for($i = 1; $i <= $max_row; $i++){
        //����ǡ���
        $client_data["hdn_tax_div"][$i]             = "";
        //$client_data["form_sale_num"][$i]          = "";
        $client_data["form_goods_num1"][$i]         = "";
        $client_data["form_trade_price"]["$i"]["1"] = "";
        $client_data["form_trade_price"]["$i"]["2"] = "";
        $client_data["form_trade_amount"][$i]       = "";
        $client_data["form_sale_price"]["$i"]["1"]  = "";
        $client_data["form_sale_price"]["$i"]["2"]  = "";
        $client_data["form_sale_amount"][$i]        = "";
        //$client_data["form_aorder_num"][$i]        = "";
        $client_data["form_divide"][$i]             = "";
        $client_data["form_serv"][$i]               = "";
        //$client_data["form_stock_num"][$i]         = "";
        $client_data["form_issiki"][$i]             = "";
        $client_data["form_print_flg1"][$i]         = "";
        $client_data["form_print_flg2"][$i]         = "";

        for($j=1;$j<=3;$j++){
            $client_data["hdn_goods_id".$j][$i]         = "";
            $client_data["form_goods_cd".$j][$i]        = "";
            $client_data["form_goods_name".$j][$i]      = "";
            $client_data["hdn_name_change".$j][$i]      = "";
            $client_data["form_goods_num".$j][$i]       = "";
        }
        $client_data["official_goods_name"][$i]     = "";
        $client_data["form_aprice_div"][$i]         = "1";
        $client_data["form_account_price"][$i]      = "";
        $client_data["form_account_rate"][$i]       = "";
        $client_data["form_ad_offset_radio"][$i]    = "1";
        $client_data["form_ad_offset_amount"][$i]   = "";
    }
    $client_data["del_row"]             = "";        //������ֹ�
    $client_data["max_row"]             = "";        //�Կ�
    $client_data["form_sale_total"]     = "";        //��ȴ���
    $client_data["form_sale_tax"]       = "";        //������
    $client_data["form_sale_money"]     = "";        //�ǹ����
    $client_data["show_button_flg"]     = "";        //ɽ���ܥ���

    $client_data["form_ad_offset_total"]= "";       //�������껦�۹��
*/
    $client_data["form_ad_rest_price"]  = "";       //������Ĺ�

    $client_data["daiko_check"]         = $contract_div;    //��Զ�ʬ

    $form->setConstants($client_data);

}


//�Ҳ�Ԥ�FC�������褫Ƚ��
if($intro_account_id != null){
    $sql = "SELECT client_cd1, client_cd2, client_cname, client_div FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    //������ξ�硢�Ҳ��CD1�Τ�
    if(pg_fetch_result($result, 0, "client_div") == "2"){
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }else{
        $ac_name = pg_fetch_result($result, 0, "client_cd1")."-".pg_fetch_result($result, 0, "client_cd2")."<br>".htmlspecialchars(pg_fetch_result($result, 0, "client_cname"));
    }
//�Ҳ�Ԥ��ʤ����
}else{
    $ac_name = "̵��";
    $con_data2["intro_ac_div[]"] = 1;
}


/****************************/
//����������
/****************************/
$daiko_cd1 = $_POST["form_daiko"]["cd1"];   //��ԥ�����1
$daiko_cd2 = $_POST["form_daiko"]["cd2"];   //��ԥ�����2

//������������orPOST�˥����ɤ�������
if($_POST["daiko_search_flg"] == true && $contract_div != "1" && $done_flg != "true"){

    //������ξ�������
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_id \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_cd1 = '$daiko_cd1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_cd2 = '$daiko_cd2' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.client_div = '3' \n";
    $sql .= "    AND \n";
    $sql .= "    t_client.state = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_rank.group_kind = '3' \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    $num = pg_num_rows($result);
    //�����ǡ���������
    if($num == 1){
        //�ǡ�������
        $act_id = pg_fetch_result($result, 0, 0);     //������ID
        $con_data2["hdn_daiko_id"] = $act_id;

        //�����ξ�������
        $sql  = "SELECT \n";
        $sql .= "    t_client.client_cname, \n";
        $sql .= "    t_client.client_cd1, \n";
        $sql .= "    t_client.client_cd2, \n";
        $sql .= "    t_client.coax \n";
        $sql .= "FROM \n";
        $sql .= "    t_client \n";
        $sql .= "WHERE \n";
        $sql .= "    t_client.client_id = $act_id \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        $data_list = Get_Data($result, 2);

        $daiko_cname    = $data_list[0][0];        //��̾
        $daiko_cd1      = $data_list[0][1];        //���CD1
        $daiko_cd2      = $data_list[0][2];        //���CD2
        $daiko_coax     = $data_list[0][3];        //��Ԥδݤ��ʬ

        //POST�����ѹ�
        $con_data2["form_daiko"]["cd1"]  = $daiko_cd1;
        $con_data2["form_daiko"]["cd2"]  = $daiko_cd2;
        $con_data2["form_daiko"]["name"] = $daiko_cname;
        $con_data2["hdn_daiko_coax"]     = $daiko_coax;
        $con_data2["daiko_search_flg"]   = "";


        //������Τޤ���ʬ�ǱĶȶ�ۤ�Ʒ׻�
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //��۷׻�����Ƚ��
                if($_POST["form_goods_num1"][$i] != null){
                //���̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);

                //���̡ߤξ�硢ñ���ߣ�
                }else{
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($daiko_coax, $t_amount);
                }

                //��׶�ۥե�����˥��å�
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }


    //����褬¸�ߤ��ʤ���硢POST��������
    }else{
        $con_data2["hdn_daiko_id"]       = "";
        $con_data2["form_daiko"]["cd1"]  = "";
        $con_data2["form_daiko"]["cd2"]  = "";
        $con_data2["form_daiko"]["name"] = "";
        $con_data2["hdn_daiko_coax"]     = "";
        $con_data2["daiko_search_flg"]   = "";


        //������Τޤ���ʬ�ǱĶȶ�ۤ�Ʒ׻�
        for($i=1; $i<=$max_row; $i++){

            if($_POST["form_trade_price"][$i][1] != null || $_POST["form_trade_price"][$i][2] != null){
                $t_price = $_POST["form_trade_price"][$i][1].".".$_POST["form_trade_price"][$i][2];

                //��۷׻�����Ƚ��
                if($_POST["form_goods_num1"][$i] != null){
                //���̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, $_POST["form_goods_num1"][$i], 2);
                    $t_amount = Coax_Col($coax, $t_amount);

/*
                //���̡ߤξ�硢ñ���ߣ�
                }else{
                    //�Ķȶ��
                    $t_amount = bcmul($t_price, 1, 2);
                    $t_amount = Coax_Col($coax, $t_amount);
                }
*/
                //���̡ߤξ�硢0
                }else{
                    $t_amount = 0;
                }

                //��׶�ۥե�����˥��å�
                $con_data2["form_trade_amount"][$i] = number_format($t_amount);

            }
        }
    }

//�������Ϥ��Ƥ�����
}elseif($_POST["hdn_daiko_id"] != null && $contract_div != "1" && $done_flg != "true"){
    $act_id = $_POST["hdn_daiko_id"];
    $daiko_coax = $_POST["hdn_daiko_coax"];

//�������Ϥ��Ƥ��뤱�ɼ��ҽ��ξ��
}elseif($_POST["hdn_daiko_id"] != null && $contract_div == "1" && $done_flg != "true"){
    $act_id = null;
    $daiko_coax = null;
}



/****************************/
//�в��Ҹ�����
/****************************/
/*
//if($_POST["stock_search_flg"] == true && $done_flg != "true"){
if($_POST["stock_search_flg"] == true && $contract_div != "1" && $done_flg != "true"){

    $ware_id = $_POST["form_ware_select"];   //�в��Ҹ�

    //���ʤ����İʾ����򤵤�Ƥ���н�������
    if($ware_id != NULL){

        for($i = 1; $i <= $max_row; $i++){
$j=1;
            $goods_id = $_POST["hdn_goods_id".$j][$i];

            if($goods_id != NULL){
                $sql  = "SELECT \n";
                $sql .= "    COALESCE(t_stock.stock_num, 0) AS stock_num, \n";
                $sql .= "    t_goods.stock_manage \n";
                $sql .= "FROM \n";
                $sql .= "    t_goods \n";
                $sql .= "    LEFT JOIN \n";
                $sql .= "        ( \n";
                $sql .= "            SELECT \n";
                $sql .= "                goods_id, \n";
                $sql .= "                SUM(stock_num) AS stock_num \n";
                $sql .= "            FROM \n";
                $sql .= "                t_stock \n";
                $sql .= "            WHERE \n";
                if($_SESSION["group_kind"] == "2"){
                    $sql .= "                shop_id IN (".Rank_Sql().") \n";
                }else{
                    $sql .= "                shop_id = ".$_SESSION["client_id"]." \n";
                }
                $sql .= "                AND \n";
                $sql .= "                ware_id = $ware_id \n";
                $sql .= "                AND \n";
                $sql .= "                goods_id = $goods_id \n";
                $sql .= "            GROUP BY \n";
                $sql .= "                goods_id \n";
                $sql .= "        ) AS t_stock ON t_goods.goods_id = t_stock.goods_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_goods.goods_id = $goods_id \n";
                $sql .= ";\n";
//print_array($sql, "�߸˿�");

                $result         = Db_Query($db_con, $sql);

                if(pg_fetch_result($result, 0, "stock_manage") == "1"){
                    $set_stock_data["form_stock_num"][$i] = pg_fetch_result($result, 0, "stock_num");
                }else{
                    $set_stock_data["form_stock_num"][$i] = "";
                }
            }

        }

        //�����褬���򤵤�Ƥ����顢�ٹ���ɽ��
        if($_POST["hdn_client_id"] != NULL){
            $warning = null;
        }
    }else{
        $warning = "������Ƚв��Ҹˤ����򤷤Ƥ���������";
        for($i = 1; $i <= $max_row; $i++){
            $set_stock_data["form_stock_num"][$i] = "";
        }
    }
    
    $set_stock_data["hdn_ware_id"]         = $ware_id;  
    $set_stock_data["stock_search_flg"]    = "";
    $set_stock_data["show_button_flg"]     = "";        //ɽ���ܥ���
    $form->setConstants($set_stock_data);

}
*/


/****************************/
// ô���ԥ��쥯������
/****************************/
if($_POST["hdn_staff_ware"] == true){
    $staff_bases_ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $_POST["form_ac_staff_select"]));    //�����åդε����Ҹ�

    $set_staff_ware["form_ware_select"] = $staff_bases_ware_id; //�в��Ҹˤ�ô���Ԥε����Ҹˤˤ���
    $set_staff_ware["hdn_staff_ware"]   = "";                   //�����åդΥ��쥯�����򤵤줿�ե饰�����

    $form->setConstants($set_staff_ware);
}


/****************************/
//���ʺ���
/****************************/
if($done_flg != "true"){

    //�����ʬ
    $select_value = Select_Get($db_con,'trade_sale');
    $trade_form=$form->addElement('select', 'trade_sale_select', '���쥯�ȥܥå���', null, $g_form_option_select);
    //���ʡ��Ͱ����ο����ѹ�
    $select_value_key = array_keys($select_value);
    for($i = 0; $i < count($select_value); $i++){
        if($select_value_key[$i] == 13 || $select_value_key[$i] == 14 || $select_value_key[$i] == 63 || $select_value_key[$i] == 64){
            $color= "style=color:red";
        }else{
            $color="";
        }
        #2009-09-28 hashimoto-y
        #�����ʬ�����Ͱ�����ɽ�����ʤ����ڤ��ᤷ�ξ��ˤϤ�����ifʸ�򳰤���
        if( $renew_flg == "true" ){
            $trade_form->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
        }elseif( $select_value_key[$i] != 14 && $select_value_key[$i] != 64 ){
            $trade_form->addOption($select_value[$select_value_key[$i]], $select_value_key[$i],$color);
        }
    }

    //���ô����ô����
    $select_value_staff = Select_Get($db_con,'cstaff');
    $form->addElement('select', 'form_ac_staff_select', '���쥯�ȥܥå���', $select_value_staff, 
        "onChange=\"javascript:Button_Submit('hdn_staff_ware','#','true');\""
    );

    //hidden
    $form->addElement("hidden", "hdn_sale_id");         //���ID


}else{

    //�����ɼ���Ϸ��������
    $sql  = "SELECT slip_out FROM t_sale_h WHERE sale_id = $sale_id AND ";
    $sql .= ($_SESSION["group_kind"] == "2") ? "shop_id IN (".Rank_Sql().") " : "shop_id = ".$_SESSION["client_id"]." ";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $disable_slip_out = (pg_fetch_result($result, 0, "slip_out") == "2") ? "disabled" : "";

    //�����ʬ��ʬ��ξ�硢ʬ��������̤ؤΥܥ����ɽ��
    $installment_button = ($_GET["installment_flg"] != "15") ? "disabled" : "" ;

    //ʬ���������
    $form->addElement("button", "slip_bill_button", "ʬ������", "
        onClick=\"location.href='2-2-214.php?sale_id=".$sale_id."'\"
        $installment_button
    ");

    //ʬ���������
    $form->addElement("submit", "ok_slip_bill_button", "��ɼ��ȯ�Ԥ���ʬ������", "
        onClick=\"Post_book_vote('./2-2-205.php','2-2-214.php?sale_id=".$sale_id."');\"
        $installment_button $disable_slip_out
    ");


    //OK�ܥ���
    $form->addElement("button", "ok_button", "����λ", "onClick=\"location.href='".Make_Rtn_Page("sale")."'\"");
    //OK��ɼ�ܥ���
    $form->addElement("submit", "ok_slip_button", "��ɼ��ȯ�Ԥ��ƴ�λ", "
        onClick=\"Post_book_vote('./2-2-205.php','".Make_Rtn_Page("sale")."');\"
        $disable_slip_out
    ");
    //���
    $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-207.php?search=1'\"");

    //�����ɼ���Ϥ�hidden
    $form->addElement("hidden", "output_id_array[0]", "$sale_id");
    $form->addElement("hidden", "form_slip_check[0]", "1");

}


/****************************/
//��ץܥ��󲡲�����
/****************************/
//if($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || $_POST["form_sale_btn"] == "����ǧ���̤�"){
if(($_POST["sum_button_flg"] == true || $_POST["del_row"] != "" || ($_POST["form_sale_btn"] == "��ǧ���̤�" && $client_id != null)) && $done_flg != "true"){
/*
    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];
    //������������ˤ��롣
    $del_history = explode(",", $del_row);
*/
    $sale_data   = $_POST["form_sale_amount"];  //�����
    $sale_money  = NULL;                        //���ʤ������
    $tax_div_arr = NULL;                        //���Ƕ�ʬ
    $ad_offset_total = null;                    //�����껦�۹��

    //for($i=0;$i<$max_row;$i++){
    for($i=1;$i<=5;$i++){
        //����ۤι���ͷ׻�
        if($sale_data[$i] != "" && !in_array("$i", $del_history)){
            $sale_money[] = $sale_data[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
				$tax_div_arr[] = "1";
				$tax_div[$i]   = "1";
			}elseif($_POST["hdn_goods_id1"][$i] == null){
				$sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
			}else{
				$sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
			    $result = Db_Query($db_con, $sql);
			    $tax_div_arr[] = pg_fetch_result($result, 0, 0);
			    $tax_div[$i]   = pg_fetch_result($result, 0, 0);
				//$tax_div_arr[] = $_POST["hdn_tax_div"][$i];
				//$tax_div[$i]   = $_POST["hdn_tax_div"][$i];
			}
        }

        //�����껦�۹�׷׻�
        if($_POST["form_ad_offset_radio"][$i] == "2"){
            $ad_offset_total += $_POST["form_ad_offset_amount"][$i];
        }
    }

    //���ߤξ�����Ψ
    #2009-12-22 aoyama-n
    #$sql  = "SELECT ";
    #$sql .= "    tax_rate_n ";
    #$sql .= "FROM ";
    #$sql .= "    t_client ";
    #$sql .= "WHERE ";
    //$sql .= "    client_id = $client_id;";
    #$sql .= "    client_id = ";
    #$sql .= ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
    #$result = Db_Query($db_con, $sql);
    #$tax_num = pg_fetch_result($result, 0,0);

    #2009-12-22 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    $total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_id, $db_con);
    //$total_money = Total_Amount($sale_money, $tax_div_arr,$coax,$tax_franct,$tax_num,$client_shop_id, $db_con);

    $sale_money = number_format($total_money[0]);
    $tax_money  = number_format($total_money[1]);
    $st_money   = number_format($total_money[2]);
    $ad_offset_total = ($ad_offset_total !== null) ? number_format($ad_offset_total) : null;

    if($_POST["sum_button_flg"] == true){
        //���ɽ�������ѹ�
        $height = $max_row * 30;
        $form_potision = "<body bgcolor=\"#D8D0C8\" onLoad=\"form_potision($height);\">";
    }

    //�ե�������ͥ��å�
    $money_data["form_sale_total"]   = $sale_money;
    $money_data["form_sale_tax"]     = $tax_money;
    $money_data["form_sale_money"]   = $st_money;
    $money_data["form_ad_offset_total"] = $ad_offset_total;
    $money_data["sum_button_flg"]    = "";
    $form->setConstants($money_data);
}


/****************************/
//���ʥ���������
/****************************/
if($_POST["goods_search_row"] != null && $done_flg != "true"){

    //���ʥ����ɼ��̾���
    $row_data = $_POST["goods_search_row"];
    //���ʥǡ�������������
    $search_row = substr($row_data,0,1);
    //���ʥǡ��������������
    $search_line = substr($row_data,1,1);


    //$attach_gid   = $_POST["attach_gid"];         //������ν�°���롼��
    $client_shop_id = $_POST["client_shop_id"];   //������Υ���å�ID
    //$rank_cd      = $_POST["hdn_rank_cd"];        //������θܵҶ�ʬ
    $ware_id      = $_POST["form_ware_select"];   //�в��Ҹ�

    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_id, \n";      //����ID 0
    $sql .= "   t_goods.name_change, \n";   //��̾�ѹ� 1
    $sql .= "   t_goods.goods_cd, \n";      //����CD 2
    $sql .= "   t_goods.goods_cname, \n";   //����̾��ά�Ρ� 3
    $sql .= "   initial_cost.r_price AS initial_price, \n"; //�Ķȸ��� 4
    $sql .= "   sale_price.r_price AS sale_price, \n";      //���ñ����ɸ���5
    $sql .= "   t_goods.tax_div, \n";       //���Ƕ�ʬ 6
    //$sql .= "   CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num, \n";  //�߸˿� 7
    $sql .= "   null, \n";                  //̤���� 7
    $sql .= "   null, \n";                  //̤���� 8
    $sql .= "   t_goods.compose_flg, \n";   //�����ʥե饰 9
    $sql .= "   CASE \n";
    $sql .= "       WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
    $sql .= "       ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    //aoyama-n 2009-09-08
    #$sql .= "   END \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 10
    $sql .= "   END, \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 10
    $sql .= "   t_goods.discount_flg \n";    //�Ͱ��ե饰 11

    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    $sql .= "   LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "   LEFT JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id \n";
    //$sql .= "   INNER JOIN t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id \n";
    $sql .= "        AND initial_cost.rank_cd = '2' \n";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    AND initial_cost.shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "    AND initial_cost.shop_id = ".$_SESSION["client_id"]." \n";
    }

    $sql .= "   LEFT JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n";
    //$sql .= "   INNER JOIN t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id \n";
    $sql .= "        AND sale_price.rank_cd = '4' \n";
/*
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( SELECT \n";
    $sql .= "       goods_id, \n";
    $sql .= "       SUM(stock_num) AS stock_num \n";
    $sql .= "    FROM \n";
    $sql .= "        t_stock \n";
    $sql .= "    WHERE \n";
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    shop_id IN (".Rank_Sql().") \n";
    }else{
        $sql .= "    shop_id = ".$_SESSION["client_id"]." \n";
    }
    //����ʬ�����ҽ��ξ��Τ��Ҹ˻���
    if($contract_div == "1"){
        $sql .= "        AND \n";
        $sql .= "        ware_id = $ware_id \n";
    }
    $sql .= "    GROUP BY t_stock.goods_id \n"; 
    $sql .= "   ) AS t_stock \n";
    $sql .= "   ON t_goods.goods_id = t_stock.goods_id \n";
*/
    $sql .= "WHERE \n";
    $sql .= "    t_goods.goods_cd = '".$_POST["form_goods_cd".$search_line][$search_row]."' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods.accept_flg = '1' \n";

    //ľ�Ĥξ��ϡ�ͭ����ľ�ĤΤ�ͭ���ǡ��������ʡ�ľ�ľ��ʤ����
    if($_SESSION["group_kind"] == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.state IN (1,3) \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id IN (".Rank_Sql().") \n";
        $sql .= "    ) \n ";
    //FC�ξ��ϡ�ͭ���ǡ��������ʡ�FC���ʤ����
    }else{
        $sql .= "    AND \n";
        $sql .= "    t_goods.state = 1 \n";
        $sql .= "    AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_goods.public_flg = true \n";
        $sql .= "        OR \n";
        $sql .= "        t_goods.shop_id = ".$_SESSION["client_id"]." \n";
        $sql .= "    ) \n ";
    }

    //���ξ��ʤϹ����ʤϥ���
    if($search_line == "2"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.compose_flg = 'f' \n";
    }
/*
    $sql .= " AND ";
    $sql .= "       initial_cost.rank_cd = '1' ";
    $sql .= " AND ";
    $sql .= "       sale_price.rank_cd = '$rank_cd'";
*/
    //��Զ�ʬ����Ԥξ����������ʤΤ�ɽ��
    if($contract_div != "1"){
        $sql .= "    AND \n";
        $sql .= "    t_goods.public_flg = true \n";
    }
    $sql .= ";";
//print_array($sql, "��������");
    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

    //�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
    if($data_num == 1){
        $goods_data = Get_Data($result, 2);

        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = $goods_data[0][0];    //����ID

        $set_goods_data["hdn_name_change".$search_line][$search_row]    = $goods_data[0][1];    //��̾�ѹ��ե饰
        $hdn_name_change[$search_line][$search_row]                     = $goods_data[0][1];    //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
        $_POST["hdn_name_change".$search_line][$search_row]             = $goods_data[0][1];    //�����ѹ�����hidden��Ƚ�ꤷ�ʤ�����

        $set_goods_data["form_goods_cd".$search_line][$search_row]      = $goods_data[0][2];    //����CD
        $set_goods_data["form_goods_name".$search_line][$search_row]    = $goods_data[0][3];    //����̾

        $reset_goods_flg = false;   //���������ϻ��Υե�����ꥻ�åȥե饰

        //�����ʤξ�硢�Ҥ�ñ�����פ�����Τ������ʤ�ñ���ˤʤ�
        if($goods_data[0][9] == "t"){
            $shop_id = ($shop_id != null) ? $shop_id : $_SESSION["client_id"];
            $array_price = Compose_price($db_con, $shop_id, $goods_data[0][0]);
			//�����ʤλҤ�ñ������Ƚ��
			if($array_price == false){
				$reset_goods_flg = true;   //���Ϥ��줿���ʾ���򥯥ꥢ
			}else{
                $goods_data[0][4] = $array_price[0];    //����
                $goods_data[0][5] = $array_price[1];    //���
            }

        //�����ʤ���ʤ���硢ñ����null�ʤ�ե�����ꥻ�å�
        }elseif($goods_data[0][4] == null || $goods_data[0][5] == null){
            $reset_goods_flg = true;
        }

        //�����ʥ��顼����ʤ����
        if($reset_goods_flg == false){
            //�����ƥ����ϻ��Τ�ñ������۷׻�����������̾�������
            if($search_line == "1"){
                //��Զ�ʬ�����Ҥξ���DB���顢��Ԥξ������ñ������԰������򤫤�����Τ򸶲�ñ���������
                //if($contract_div == "1"){
                //��Զ�ʬ�����ҡ��ޤ�����԰��������ʡ�˰ʳ��ξ���DB���顢��Ԥǡʡ�ˤξ������ñ���ˡʡ�ˤ򤫤�����Τ򸶲�ñ���������
                if($contract_div != "1" && $_POST["act_div"]["0"] == "3"){
                    //��԰����������Ϥ���Ƥ��ʤ�����0�ˤ����
                    if($_POST["act_request_rate"] == null){
                        $cost_price = 0;
                    }else{
                        $cost_price = bcmul($goods_data[0][5], bcdiv($_POST["act_request_rate"], 100, 2), 2);
                    }

                }else{
                    $cost_price = $goods_data[0][4];
                }

                //����ñ�����������Ⱦ�������ʬ����
                $arr_cost_price = explode('.', $cost_price);
                $set_goods_data["form_trade_price"][$search_row]["1"] = $arr_cost_price[0];  //����ñ��
                $set_goods_data["form_trade_price"][$search_row]["2"] = ($arr_cost_price[1] != null)? $arr_cost_price[1] : '00';

                //���ñ�����������Ⱦ�������ʬ����
                $sale_price = $goods_data[0][5];
                $arr_sale_price = explode('.', $sale_price);
                $set_goods_data["form_sale_price"][$search_row]["1"] = $arr_sale_price[0];  //���ñ��
                $set_goods_data["form_sale_price"][$search_row]["2"] = ($arr_sale_price[1] != null)? $arr_sale_price[1] : '00';

                $set_goods_data["hdn_tax_div"][$search_row]          = $goods_data[0][6]; //���Ƕ�ʬ

/*
        //��Զ�ʬ�����ҽ��ξ��Τ߸��߸˿�ɽ��
        if($contract_div == "1"){
            $set_goods_data["form_stock_num"][$search_row]       = $goods_data[0][7]; //���߸˿�
        }
*/

                //��۷׻�����Ƚ��
                //if($_POST["form_issiki"][$search_row] != null && $_POST["form_sale_num"][$search_row] != null){
                if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] != null){
                //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                    //�Ķȶ��
                    //�����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ��
                    //���켰���ΤȤ����ñ��������׳ۤǡ�����ñ�������ñ����������������׳ۡ��������Ḷ����׳�
                    //����äơ����̣��Ƿ׻����Ƹ���ñ���Ḷ����׳ۤ���Ͽ
                    if($contract_div != "1" && $_POST["act_div"][0] == "3"){
                        $trade_amount = bcmul($cost_price, 1, 2);
                    //����ʳ���ñ���߿���
                    }else{
                        $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    }
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //�켰�������̡ߤξ�硢ñ���ߣ�
                //}else if($_POST["form_issiki"][$search_row] != null && $_POST["form_sale_num"][$search_row] == null){
                }else if($_POST["form_issiki"][$search_row] != null && $_POST["form_goods_num1"][$search_row] == null){
                    //�Ķȶ��
                    $trade_amount = bcmul($cost_price, 1,2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    $sale_amount = bcmul($sale_price, 1,2);
                    $sale_amount = Coax_Col($coax, $sale_amount);

                //�켰�ߡ����̡��ξ�硢ñ���߿���
                //}else if($_POST["form_issiki"][$search_row] == null && $_POST["form_sale_num"][$search_row] != null){
                }else if($_POST["form_issiki"][$search_row] == null && $_POST["form_goods_num1"][$search_row] != null){
                    //�Ķȶ��
                    //$trade_amount = bcmul($cost_price, $_POST["form_sale_num"][$search_row],2);
                    $trade_amount = bcmul($cost_price, $_POST["form_goods_num1"][$search_row],2);
                    if($contract_div == "1"){
                        $trade_amount = Coax_Col($coax, $trade_amount);
                    }else{
                        $trade_amount = Coax_Col($daiko_coax, $trade_amount);
                    }

                    //�����
                    //$sale_amount = bcmul($sale_price, $_POST["form_sale_num"][$search_row],2);
                    $sale_amount = bcmul($sale_price, $_POST["form_goods_num1"][$search_row],2);
                    $sale_amount = Coax_Col($coax, $sale_amount);
                }

                $set_goods_data["form_trade_amount"][$search_row]   = number_format($trade_amount);
                $set_goods_data["form_sale_amount"][$search_row]    = number_format($sale_amount);


                //����̾�������ˤ������
                $set_goods_data["official_goods_name"][$search_row] = $goods_data[0][10];

                //aoyama-n 2009-09-08
                //�Ͱ��ե饰
                $set_goods_data["hdn_discount_flg"][$search_row] = $goods_data[0][11];


            }//�����ƥ����ϻ��Τ߶�۷׻������

		//�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��Ȥ������ʾ��󥯥ꥢ
		//if($reset_goods_flg == true){
		}else{
	        //$no_goods_flg                                        = true;     //�������뾦�ʤ�̵����Хǡ�����ɽ�����ʤ�
	        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
	        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
	        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
	        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
	        //$set_goods_data["form_sale_num"][$search_row]        = "";
	        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
            //�����ƥ����ϻ��ϸ�������塢�����ե饰�����Ƕ�ʬ������
            if($search_line == "1"){
    	        $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
	            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
	            $set_goods_data["form_trade_amount"][$search_row]       = "";
	            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
    	        $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
	            $set_goods_data["form_sale_amount"][$search_row]        = "";
	            $set_goods_data["form_print_flg2"][$search_row]         = "";
	            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            }
	        //$set_goods_data["form_stock_num"][$search_row]       = "";
		}
    }else{
        //�ǡ�����̵�����ϡ������
        //$no_goods_flg                                        = true;     //�������뾦�ʤ�̵����Хǡ�����ɽ�����ʤ�
        $set_goods_data["hdn_goods_id".$search_line][$search_row]       = "";
        $set_goods_data["hdn_name_change".$search_line][$search_row]    = "";
        $set_goods_data["form_goods_cd".$search_line][$search_row]      = "";
        $set_goods_data["form_goods_name".$search_line][$search_row]    = "";
        //$set_goods_data["form_sale_num"][$search_row]        = "";
        $set_goods_data["form_goods_num".$search_line][$search_row]     = "";
        //�����ƥ����ϻ��ϸ�������塢�����ե饰�����Ƕ�ʬ�������ƥ�����̾������
        if($search_line == "1"){
            $set_goods_data["form_trade_price"][$search_row]["1"]   = "";
            $set_goods_data["form_trade_price"][$search_row]["2"]   = "";
            $set_goods_data["form_trade_amount"][$search_row]       = "";
            $set_goods_data["form_sale_price"][$search_row]["1"]    = "";
            $set_goods_data["form_sale_price"][$search_row]["2"]    = "";
            $set_goods_data["form_sale_amount"][$search_row]        = "";
            $set_goods_data["form_print_flg2"][$search_row]         = "";
            $set_goods_data["hdn_tax_div"][$search_row]             = "";
            $set_goods_data["official_goods_name"][$search_row]     = "";
            //aoyama-n 2009-09-08
            $set_goods_data["hdn_discount_flg"][$search_row]        = "";
        }
        //$set_goods_data["form_stock_num"][$search_row]       = "";
    }
    $set_goods_data["goods_search_row"] = "";
    $form->setConstants($set_goods_data);
}


/****************************/
//���ʺ����ʲ��ѡ�
/****************************/


//���ʴ�Ϣ
require_once(INCLUDE_DIR ."plan_data.inc");

//���
require_once(INCLUDE_DIR ."fc_hand_daiko.inc");



//���ֹ楫����
$row_num = 1;


/****************************/
//�����⽸�ץܥ��󲡲�����
/****************************/
if(
    ($_POST["ad_sum_button_flg"] == true || $_POST["del_row"] != "" || 
        (
            ($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ���") && $client_id != null
        )
    ) && $done_flg != "true"
){

    //������
    //��ɬ�ܥ����å�
    //$form->addGroupRule("form_delivery_day", $h_mess[26], "required");
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array("���׾��� �����Ϥ��Ƥ���������", "required")),
        "m" => array(array("���׾��� �����Ϥ��Ƥ���������", "required")),
        "d" => array(array("���׾��� �����Ϥ��Ƥ���������", "required")),
    ));
    //���ͥ����å�
    $form->addGroupRule("form_delivery_day", array(
        "y" => array(array($h_mess[26], "regex", "/^[0-9]+$/")),
        "m" => array(array($h_mess[26], "regex", "/^[0-9]+$/")),
        "d" => array(array($h_mess[26], "regex", "/^[0-9]+$/")),
    ));

    if($form->validate()){
        //�����������å�
        if(!checkdate((int)$_POST["form_delivery_day"]["m"], (int)$_POST["form_delivery_day"]["d"], (int)$_POST["form_delivery_day"]["y"])){
            $form->setElementError("form_delivery_day", $h_mess[26]);
        }
    }

    $error_flg = (count($form->_errors) > 0) ? true : false;


    //���顼���ʤ���硢�Ĺ⽸��
    if($error_flg == false){
        $count_day  = str_pad($_POST["form_delivery_day"]["y"], 4, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["m"], 2, 0, STR_PAD_LEFT);
        $count_day .= "-";
        $count_day .= str_pad($_POST["form_delivery_day"]["d"], 2, 0, STR_PAD_LEFT);

        $claim_data = $_POST["form_claim"];     //������,�������ʬ
        $c_data = explode(',', $claim_data);

        $ad_rest_price  = Advance_Offset_Claim($db_con, $count_day, $client_id, $c_data[1], $sale_id);
        $ad_rest_price2 = Numformat_Ortho($ad_rest_price, 0, true);

    //���顼�ξ�硢���򥻥å�
    }else{
        $ad_rest_price2 = "";

    }

    $con_data2["form_ad_rest_price"]    = $ad_rest_price2;
    $con_data2["ad_sum_button_flg"]     = "";

}


/****************************/
//�ԥ��ꥢ����
/****************************/
if($_POST["clear_line"] != ""){
    Clear_Line_Data2($form, $_POST["clear_line"]);
}


/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if(($_POST["form_sale_btn"] == "��ǧ���̤�" || $_POST["hdn_comp_button"] == "�ϡ���") && $done_flg != "true"){
    //�إå�������
    $sale_no              = $_POST["form_sale_no"];            //��ɼ�ֹ�
    $note                 = $_POST["form_note"];               //����

    $ware_id              = $_POST["form_ware_select"];        //�Ҹ�
    $trade_sale           = $_POST["trade_sale_select"];       //�����ʬ
    $ac_staff_id          = $_POST["form_ac_staff_select"];      //���ô����

    //������
    $array_tmp = explode(",", $_POST["form_claim"]);
    $claim_id  = $array_tmp[0];     //������ID
    $claim_div = $array_tmp[1];     //�������ʬ

    $array_divide = Select_Get($db_con, "divide_con");
    $array_serv = Select_Get($db_con, "serv_con");


    //������client_id�����
    $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
    $result = Db_Query($db_con, $sql);
    $head_id = pg_fetch_result($result, 0, "client_id");        //������client_id


    //POST�����Ȥ�
    require_once(INCLUDE_DIR."fc_sale_post_bfr.inc");


    //--------------------------//
    //���顼�����å�(addRule)
    //--------------------------//

    //��Ԥξ��
    if($contract_div != "1" && $act_id != null){
        //����������򵯤����ݡ���������ԼԤ˷�������äƤʤ��������å�
        if(Check_Monthly_Renew($db_con, $act_id, "2", $delivery_day_y, $delivery_day_m, $delivery_day_d, $head_id) == false){
            $form->setElementError("form_delivery_day", "���׾���".$h_mess[57]);
        }

        //����������򵯤����ݡ���������ԼԤ˻��������äƤʤ��������å�
        if(Check_Payment_Close_Day($db_con, $act_id, $request_day_y, $request_day_m, $request_day_d, $head_id) == false){
            $form->setElementError("form_request_day", "������".$h_mess[58]);
        }
    }


    //�����ʬ
    //��ɬ�ܥ����å�
    $form->addRule('trade_sale_select',$h_mess[30],'required');
    //����Ԥξ��ϡֳ����פΤ�
    //if($contract_div != "1" && $trade_sale != "11"){
    //����Ԥξ��ϡֳ����סֳ����ʡסֳ��Ͱ��פΤ�
    //if($contract_div != "1" && !($trade_sale == "11" || $trade_sale == "13" || $trade_sale == "14")){
    //����Ԥξ��ϡֳ������פ��Բ�
    if($contract_div != "1" && $trade_sale == "15"){
        $form->setElementError("trade_sale_select", $h_mess[54]);
    }

    //���Ҳ��������ȯ�����ʤ��ʳ��ξ��ϡֳ������פ��Բ�
    if($intro_ac_div != "1" && $trade_sale == "15"){
        $form->setElementError("trade_sale_select", $h_mess["54-2"]);
    }

    //aoyama-n 2009-09-08
    //���Ͱ�����������μ����ʬ�����å����Ͱ������ʤϻ����Բġ�
    if(($trade_sale == '13' || $trade_sale == '14' || $trade_sale == '63' || $trade_sale == '64') && (in_array('t', $_POST[hdn_discount_flg]))){
        $form->setElementError("trade_sale_select", $h_mess[79]);
    }

    //�Ҳ������ID��������ʬ����
    $sql  = "SELECT \n";
    $sql .= "    t_client_info.intro_account_id, \n";
    $sql .= "    t_client.client_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_client_info \n";
    $sql .= "    LEFT JOIN t_client ON t_client_info.intro_account_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client_info.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $intro_account_id = pg_fetch_result($result, 0, "intro_account_id");    //�Ҳ������ID
    $intro_client_div = pg_fetch_result($result, 0, "client_div");          //�Ҳ������μ�����ʬ


    //���顼�����å�(PHP)
    require_once(INCLUDE_DIR."fc_sale_post_atr.inc");


    //�ѹ���������줿�������å�
    if($sale_id != NULL){
        if(Update_Check($db_con, "t_sale_h", "sale_id", $sale_id, $_POST["hdn_enter_day"]) == false){
            $error_flg = true;
            //header("Location: ".$_SERVER["PHP_SELF"]."?sale_id=$sale_id&done_flg=true&slip_del_flg=true");
            //exit;
            $slip_del_flg = true;

            //OK�ܥ���
            $form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='./2-2-207.php?search=1'\"");
        }else{

            //�����������������������������Ƥ���ȥ��顼
            $sql = "SELECT renew_flg FROM t_buy_h WHERE act_sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                if(pg_fetch_result($result, 0, 0) == "t"){
                    $error_flg = true;
                    $buy_err_mess = "��̳�����";

                    //OK�ܥ���
                    $form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='./2-2-207.php?search=1'\"");
                }
            }

            //ľ�Ĥξ�硢�Ҳ���������������������������Ƥ���ȥ��顼
            $sql = "SELECT renew_flg FROM t_buy_h WHERE intro_sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                if(pg_fetch_result($result, 0, 0) == "t" && $intro_account_id != null && $group_kind == "2"){
                    $error_flg = true;
                    $buy_err_mess = "�Ҳ������";

                    //OK�ܥ���
                    $form->addElement("button","ok_button","�ϡ���","onClick=\"location.href='./2-2-207.php?search=1'\"");
                }
            }
        }
    }


    //�������ô����Ź���Ҳ���������
    $sql  = "SELECT \n";
    $sql .= "    t_client.coax, \n";
    $sql .= "    t_client.tax_franct, \n";
    $sql .= "    t_client_info.cclient_shop \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "    INNER JOIN t_client_info ON t_client.client_id = t_client_info.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "    t_client.client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $coax           = pg_fetch_result($result, 0, "coax");              //�ޤ���ʬ
    $tax_franct     = pg_fetch_result($result, 0, "tax_franct");        //������ü����ʬ
    $cclient_shop   = pg_fetch_result($result, 0, "cclient_shop");      //ô����Ź

    $cost_money  = NULL;    //���ʤθ������
    $sale_money  = NULL;    //���ʤ������
    $tax_div_arr = NULL;    //���Ƕ�ʬ

    //����ۤι���ͷ׻�
    for($i=1;$i<=5;$i++){
        if($serv_id[$i] != null || $goods_item_id[$i] != null){
            $cost_money[] = $trade_amount[$i];
            $sale_money[] = $sale_amount[$i];
            if($_POST["hdn_goods_id1"][$i] == null && $_POST["form_serv"][$i] == null){
                $tax_div_arr[] = "1";
                $tax_div[$i]   = "1";		//DB��Ͽ��
            }elseif($_POST["form_serv"][$i] != null && $_POST["hdn_goods_id1"][$i] == null){
                $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$_POST["form_serv"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);		//DB��Ͽ��
            }else{
                $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$_POST["hdn_goods_id1"][$i].";";
                $result = Db_Query($db_con, $sql);
                $tax_div_arr[] = pg_fetch_result($result, 0, 0);
                $tax_div[$i]   = pg_fetch_result($result, 0, 0);
            }
        }
    }

    //���ߤ�ô������åפξ�����Ψ
    #2009-12-22 aoyama-n
    #$sql  = "SELECT ";
    #$sql .= "    tax_rate_n ";
    #$sql .= "FROM ";
    #$sql .= "    t_client ";
    #$sql .= "WHERE ";
    #$sql .= "    client_id = $cclient_shop;";
    #$result = Db_Query($db_con, $sql); 
    #$tax_num = pg_fetch_result($result, 0, 0);

    #2009-12-22 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    //���ҽ��ξ�硢������������δݤ�Ǥޤ��
    if($contract_div == "1"){
        $total_money = Total_Amount($cost_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);

    //��Ԥξ�硢�����������δݤ�Ǥޤ��
    }else{
        $total_money = Total_Amount($cost_money, $tax_div_arr, $daiko_coax, $tax_franct, $tax_num, $client_id, $db_con);
    }
    $cost_money  = $total_money[0];     //������ۡ���ȴ��

    $total_money = Total_Amount($sale_money, $tax_div_arr, $coax, $tax_franct, $tax_num, $client_id, $db_con);
    $sale_money  = $total_money[0];     //����ۡ���ȴ��
    $sale_tax    = $total_money[1];     //�����ǳ�


    //�������ʬ���ָ���ۡס����ġ�����������ȱĶȶ�۹�פ����פ��ʤ����
    if($act_div == "2" && ($cost_money != $act_request_price)){
        $form->setElementError("act_request_price",$h_mess[68]);
    }


    //������ۤΥ����å�
    if($ad_offset_flg){

        //��ɼ��ס��ǹ��ˤ�������껦�۹�פ��礭����硢�ٹ��ɽ��
        if(($sale_money + $sale_tax) < $ad_offset_total_amount){
            $ad_total_warn_mess = $h_mess[78];
        }

        //�ֳ����פξ��
        if($trade_sale == "11"){
            //�����껦�۹�פ����ߤ�������Ĺ����礭�����ϥ��顼
            if($ad_offset_total_amount > $ad_rest_price){
                $form->setElementError("form_ad_offset_total", $h_mess[75]);
            }
        }

    }//������ۥ����å������



    $form->validate();
    $error_flg = (count($form->_errors) > 0) ? true : $error_flg;



    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    //if($form->validate() && $error_flg == false){
    if($error_flg == false){

        //��ϿȽ��
        //if($_POST["comp_button"] == "�ϡ���"){
        if($_POST["hdn_comp_button"] == "�ϡ���"){

            //���դη����ѹ�
            $sale_day   = $delivery_day;    //���׾���
            $claim_day  = $request_day;     //������

            //���ҽ��ξ�硢�в��Ҹˡ����ô���Ԥ�ô���Ҹˡˤ����
            if($contract_div == "1"){
                $sql  = "SELECT \n";
                $sql .= "    t_ware.ware_id, \n";
                $sql .= "    t_ware.ware_name \n";
                $sql .= "FROM \n";
                $sql .= "    t_attach \n";
                $sql .= "    INNER JOIN t_ware ON t_attach.ware_id = t_ware.ware_id \n";
                $sql .= "WHERE \n";
                $sql .= "    t_attach.staff_id = $ac_staff_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql); 
                $staff_ware_id      = pg_fetch_result($result, 0, "ware_id");       //ô���Ҹ�ID
                $staff_ware_name    = pg_fetch_result($result, 0, "ware_name");     //ô���Ҹ�̾
            }


            //(2006/08/26) ��ʣ���顼�����å��ѥե饰������
            $duplicate_flg = false;

            //���إå������ǡ�������Ͽ������SQL
            Db_Query($db_con, "BEGIN;");

            //�ѹ�����Ƚ��
            if($sale_id != NULL){
                //���إå����ѹ�
                $sql  = "UPDATE ";
                $sql .= "    t_sale_h ";
                $sql .= "SET ";
                $sql .= "    sale_id = $sale_id, ";
                $sql .= "    sale_no = '$sale_no', ";
                $sql .= "    sale_day = '$sale_day', ";
                $sql .= "    claim_day = '$claim_day', ";
                $sql .= "    trade_id = '$trade_sale', ";
                $sql .= "    client_id = $client_id, ";
                $sql .= "    client_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_cname = (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    slip_out = (SELECT slip_out FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_post_no1 = (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_post_no2 = (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address1 = (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address2 = (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                $sql .= "    c_address3 = (SELECT address3 FROM t_client WHERE client_id = $client_id), ";

                $sql .= "    claim_id = $claim_id, ";   //������ID
                $sql .= "    claim_div = $claim_div, "; //�������ʬ

                //ľ���褬���ꤵ��Ƥ�����
                if($direct_id != null){
                    $sql .= "    direct_id = $direct_id, ";
                    $sql .= "    direct_cd = (SELECT direct_cd FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_name = (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_name2 = (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    direct_cname = (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_post_no1 = (SELECT post_no1 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_post_no2 = (SELECT post_no2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_address1 = (SELECT address1 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_address2 = (SELECT address2 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_address3 = (SELECT address3 FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_tel = (SELECT tel FROM t_direct WHERE direct_id = $direct_id), ";
                    $sql .= "    d_fax = (SELECT fax FROM t_direct WHERE direct_id = $direct_id), ";
                }else{
                    $sql .= "    direct_id = null, ";
                    $sql .= "    direct_cd = null, ";
                    $sql .= "    direct_name = null, ";
                    $sql .= "    direct_name2 = null, ";
                    $sql .= "    direct_cname = null, ";
                    $sql .= "    d_post_no1 = null, ";
                    $sql .= "    d_post_no2 = null, ";
                    $sql .= "    d_address1 = null, ";
                    $sql .= "    d_address2 = null, ";
                    $sql .= "    d_address3 = null, ";
                    $sql .= "    d_tel = null, ";
                    $sql .= "    d_fax = null, ";
                }

/*
                //�����ȼԤ����ꤵ��Ƥ�����
                if($trans_id != null){
                    $sql .= "    trans_id = $trans_id, ";
                    $sql .= "    trans_name = (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), ";
                    $sql .= "    trans_cname = (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), ";
                }else{
                    $sql .= "    trans_id = null, ";
                    $sql .= "    trans_name = null, ";
                    $sql .= "    trans_cname = null, ";
                }

                //���꡼��ȼԤ����ꤵ��Ƥ�����
                if($trans_check != null){
                    $sql .= ($trans_check=='t') ? "green_flg = true, " : "green_flg = false, ";
                }
*/

                //���ҽ��ξ��
                //���в��Ҹ���Ͽ
                //����Ԥ����
                if($contract_div == "1"){
                    $sql .= "    ware_id = $ware_id, ";
                    $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                    $sql .= "    act_id = null, ";
                    $sql .= "    act_cd1 = null, ";
                    $sql .= "    act_cd2 = null, ";
                    $sql .= "    act_name1 = null, ";
                    $sql .= "    act_name2 = null, ";
                    $sql .= "    act_cname = null, ";
                    $sql .= "    act_div = '1', ";          //�������ʬ
                //��Ԥξ��
                //���в��Ҹˤ����
                //����Ԥ���Ͽ
                }else{
                    $sql .= "    ware_id = null, ";
                    $sql .= "    ware_name = null, ";
                    $sql .= "    act_id = $act_id, ";
                    $sql .= "    act_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), ";
                    $sql .= "    act_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), ";
                    $sql .= "    act_name1 = (SELECT client_name FROM t_client WHERE client_id = $act_id), ";
                    $sql .= "    act_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $act_id), ";
                    $sql .= "    act_cname = (SELECT client_cname FROM t_client WHERE client_id = $act_id), ";
                    $sql .= "    act_div = '$act_div', ";   //�������ʬ
                }
                if($act_request_rate != null){          //������ʡ��
                    $sql .= "    act_request_rate = '$act_request_rate', ";
                }else{
                    $sql .= "    act_request_rate = null, ";
                }
                if($act_request_price != null){         //������ʸ���ۡ�
                    $sql .= "    act_request_price = '$act_request_price', ";
                }else{
                    $sql .= "    act_request_price = null, ";
                }

                $sql .= "    e_staff_id = ".$_SESSION["staff_id"].", ";     //���ڥ졼��ID
                $sql .= "    e_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".$_SESSION["staff_id"]."), ";
                $sql .= "    cost_amount = $cost_money, ";      //������ۡ���ȴ��
                $sql .= "    net_amount = $sale_money, ";       //����ۡ���ȴ��
                $sql .= "    tax_amount = $sale_tax, ";         //�����ǳ�
                $sql .= "    note = '$note', ";                 //����
                $sql .= "    shop_id = $cclient_shop, ";        //ô������åסʥ���å�ID��
                $sql .= "    c_shop_name = (SELECT shop_name FROM t_client WHERE client_id = $cclient_shop), ";
                $sql .= "    c_shop_name2 = (SELECT shop_name2 FROM t_client WHERE client_id = $cclient_shop), ";
                $sql .= "    contract_div = '$contract_div', "; //�����ʬ
                if($ad_offset_flg == true){                     //�����껦�۹��
                    $sql .= "    advance_offset_totalamount = $ad_offset_total_amount ";
                }else{
                    $sql .= "    advance_offset_totalamount = null ";
                }
                $sql .= "WHERE ";
                $sql .= "    sale_id = $sale_id ";
                $sql .= ";";
//echo "$sql<br>";

                $result = Db_Query($db_con,$sql);
                if($result == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

                //�����ô���ơ��֥����
                $sql  = "DELETE FROM ";
                $sql .= "    t_sale_staff ";
                $sql .= "WHERE ";
                $sql .= "    sale_id = $sale_id ";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //���ǡ�������
                $sql  = "DELETE FROM";
                $sql .= "    t_sale_d";
                $sql .= " WHERE";
                $sql .= "    sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //�������ơ��֥����
                $sql  = "DELETE FROM";
                $sql .= "    t_installment_sales";
                $sql .= " WHERE";
                $sql .= "    sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //2006-09-26 ����ơ��֥�ξä�˺���ɲ�
                //����إå��ơ��֥����
                $sql  = "DELETE FROM ";
                $sql .= "    t_payin_h ";
                $sql .= " WHERE ";
                $sql .= "    sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //������λ�������
                $sql  = "DELETE FROM ";
                $sql .= "    t_buy_h ";
                $sql .= " WHERE ";
                $sql .= "    act_sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                //�Ҳ����λ�������
                $sql  = "DELETE FROM ";
                $sql .= "    t_buy_h ";
                $sql .= " WHERE ";
                $sql .= "    intro_sale_id = $sale_id";
                $sql .= ";";

                $result = Db_Query($db_con, $sql );
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }



                //�ѹ����ϴ�λ��˰��������
                $change_flg = "true";

            //������Ͽ
            }else{

                //��ư���֤���ɼ�ֹ�����ʥ����å��ѡ�
                //ľ�Ĥξ��
                if($_SESSION["group_kind"] == "2"){
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                //FC�ξ��
                }else{
                    $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                }

                $result = Db_Query($db_con, $sql);
                $chk_sale_no = pg_fetch_result($result, 0 ,0);
                $chk_sale_no = $chk_sale_no +1;
                $chk_sale_no = str_pad($chk_sale_no, 8, 0, STR_PAD_LEFT);

                if($sale_no === $chk_sale_no){

                    //�����ֹ����֥ơ��֥���Ͽ
                    if($_SESSION["group_kind"] == "2"){
                        $sql = "INSERT INTO t_aorder_no_serial (ord_no) VALUES ('$sale_no');";
                    }else{
                        $sql = "INSERT INTO t_aorder_no_serial_fc (ord_no, shop_id) VALUES ('$sale_no', $shop_id);";
                    }
                    $result = Db_Query($db_con, $sql );
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }

                    //���إå�����Ͽ
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_sale_h ";
                    $sql .= "( ";
                    $sql .= "    sale_id, ";
                    $sql .= "    sale_no, ";
                    $sql .= "    sale_day, ";
                    $sql .= "    claim_day, ";
                    $sql .= "    trade_id, ";
                    $sql .= "    client_id, ";
                    $sql .= "    client_cd1, ";
                    $sql .= "    client_cd2, ";
                    $sql .= "    client_cname, ";
                    $sql .= "    client_name, ";
                    $sql .= "    client_name2, ";
                    $sql .= "    c_post_no1, ";
                    $sql .= "    c_post_no2, ";
                    $sql .= "    c_address1, ";
                    $sql .= "    c_address2, ";
                    $sql .= "    c_address3, ";
                    $sql .= "    claim_id, ";
                    $sql .= "    claim_div, ";
                    //ľ���褬���ꤵ��Ƥ�����
                    if($direct_id != null){
                        $sql .= "    direct_id, ";
                        $sql .= "    direct_cd, ";
                        $sql .= "    direct_name, ";
                        $sql .= "    direct_name2, ";
                        $sql .= "    direct_cname, ";
                        $sql .= "    d_post_no1, ";
                        $sql .= "    d_post_no2, ";
                        $sql .= "    d_address1, ";
                        $sql .= "    d_address2, ";
                        $sql .= "    d_address3, ";
                        $sql .= "    d_tel, ";
                        $sql .= "    d_fax, ";
                    }
/*
                    //�����ȼԤ����ꤵ��Ƥ�����
                    if($trans_id != null){
                        $sql .= "    trans_id, ";
                        $sql .= "    trans_name, ";
                        $sql .= "    trans_cname, ";
                    }
                    //���꡼��ȼԤ����ꤵ��Ƥ�����
                    if($trans_check != null){
                        $sql .= "    green_flg, ";
                    }
*/
                    //���ҽ��ξ�硢�в��Ҹ���Ͽ
                    if($contract_div == "1"){
                        $sql .= "    ware_id, ";
                        $sql .= "    ware_name, ";
                    //��Ԥξ�硢��Ծ�����Ͽ
                    }else{
                        $sql .= "    act_id, ";
                        $sql .= "    act_cd1, ";
                        $sql .= "    act_cd2, ";
                        $sql .= "    act_name1, ";
                        $sql .= "    act_name2, ";
                        $sql .= "    act_cname, ";
                        $sql .= "    act_div, ";
                        $sql .= "    act_request_rate, ";
                        $sql .= "    act_request_price, ";
                    }
                    $sql .= "    e_staff_id, ";
                    $sql .= "    e_staff_name, ";
                    $sql .= "    cost_amount, ";
                    $sql .= "    net_amount, ";
                    $sql .= "    tax_amount, ";
                    $sql .= "    note, ";
                    $sql .= "    hand_slip_flg, ";
                    $sql .= "    slip_out, ";
                    $sql .= "    shop_id, ";
                    $sql .= "    c_shop_name, ";
                    $sql .= "    c_shop_name2, ";
                    $sql .= "    contract_div, ";
                    $sql .= "    advance_offset_totalamount ";

                    $sql .= ") VALUES ( ";

                    //���ID����
                    $microtime = NULL;
                    $microtime = explode(" ",microtime());
                    $sale_id   = $microtime[1].substr("$microtime[0]", 2, 5);
                    $sql .= "$sale_id, ";

                    $sql .= "    '$sale_no', ";
                    $sql .= "    '$sale_day', ";
                    $sql .= "    '$claim_day', ";
                    $sql .= "    '$trade_sale', ";
                    $sql .= "    $client_id, ";
                    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT post_no1 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT post_no2 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT address1 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT address2 FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    (SELECT address3 FROM t_client WHERE client_id = $client_id), ";

                    $sql .= "    $claim_id, ";
                    $sql .= "    $claim_div, ";

                    //ľ���褬���ꤵ��Ƥ�����
                    if($direct_id != null){
                        $sql .= "    $direct_id, ";
                        $sql .= "    (SELECT direct_cd FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_name FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_name2 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT direct_cname FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT post_no1 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT post_no2 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT address1 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT address2 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT address3 FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT tel FROM t_direct WHERE direct_id = $direct_id), ";
                        $sql .= "    (SELECT fax FROM t_direct WHERE direct_id = $direct_id), ";
                    }
/*
                    //�����ȼԤ����ꤵ��Ƥ�����
                    if($trans_id != null){
                        $sql .= "    $trans_id, ";
                        $sql .= "    (SELECT trans_name FROM t_trans WHERE trans_id = $trans_id), ";
                        $sql .= "    (SELECT trans_cname FROM t_trans WHERE trans_id = $trans_id), ";
                    }
                    //���꡼����ꤵ��Ƥ�����
                    if($trans_check != null){
                        $sql .= ($trans_check=='t') ? "true, " : "false, ";
                    }
*/
                    //���ҽ��ξ�硢�в��Ҹ���Ͽ
                    if($contract_div == "1"){
                        $sql .= "    $ware_id, ";
                        $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
                    //��Ԥξ�硢��Ծ�����Ͽ
                    }else{
                        $sql .= "    $act_id, ";
                        $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id), ";
                        $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id), ";
                        $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $act_id), ";
                        $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $act_id), ";
                        $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id), ";
                        $sql .= "    '$act_div', ";
                        $sql .= "    '$act_request_rate', ";
                        $sql .= ($act_request_price != null) ? "    $act_request_price, " : "    null, ";
                    }
                    $sql .= "    ".$_SESSION["staff_id"].", ";
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".$_SESSION["staff_id"]."), ";
                    $sql .= "    $cost_money, ";
                    $sql .= "    $sale_money, ";
                    $sql .= "    $sale_tax, ";
                    $sql .= "    '$note', ";
                    $sql .= "    true, ";
                    $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $client_id), ";
                    $sql .= "    $cclient_shop, ";
                    $sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $cclient_shop), ";
                    $sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $cclient_shop), ";
                    $sql .= "    '$contract_div', ";
                    $sql .= ($ad_offset_flg == true) ? "    $ad_offset_total_amount " : "    NULL ";

                    $sql .= ");";
//echo "$sql<br>";

                    $result = Db_Query($db_con, $sql);
                    //Ʊ���¹��������
                    if($result === false){
                        $err_message = pg_last_error();
                        $err_format = "t_sale_h_sale_no_key";

                        Db_Query($db_con, "ROLLBACK;");

                        //��ɼ�ֹ椬��ʣ�������            
                        if((strstr($err_message, $err_format) !== false)){ 
                            $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";

                            //������ɼ�ֹ���������
                            //ľ�Ĥξ��
                            if($_SESSION["group_kind"] == "2"){
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                            //FC�ξ��
                            }else{
                                $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                            }

                            $result = Db_Query($db_con, $sql);
                            $sale_no = pg_fetch_result($result, 0 ,0);
                            $sale_no = $sale_no +1;
                            $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                            $err_data["form_sale_no"] = $sale_no;

                            $form->setConstants($err_data);

                            $duplicate_flg = true;
                        }else{
                            exit;
                        }
                    }
                }else{
                    Db_Query($db_con, "ROLLBACK;");

                    //��ɼ�ֹ椬��ʣ�������
                    $error = "Ʊ������Ͽ��Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦������Ͽ�򤷤Ʋ�������";

                    //������ɼ�ֹ���������
                    //ľ�Ĥξ��
                    if($_SESSION["group_kind"] == "2"){
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial;";
                    //FC�ξ��
                    }else{
                        $sql = "SELECT MAX(ord_no) FROM t_aorder_no_serial_fc WHERE shop_id = $shop_id;";
                    }

                    $result = Db_Query($db_con, $sql);
                    $sale_no = pg_fetch_result($result, 0 ,0);
                    $sale_no = $sale_no +1;
                    $sale_no = str_pad($sale_no, 8, 0, STR_PAD_LEFT);

                    $err_data["form_sale_no"] = $sale_no;

                    $form->setConstants($err_data);

                    $duplicate_flg = true;

                }//INSERT����ɼ�ֹ��ʣ��ǧ�����

            }//���إå�������Ͽ�����

            //���إå���Ͽ�����������ｪλ�������ô���ơ��֥롢���ǡ����ơ��֥����Ͽ
            if($duplicate_flg === false){

                //���ҽ��ξ��Τ߽��ô���ơ��֥���Ͽ
                if($contract_div == "1"){
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_sale_staff ";
                    $sql .= "( ";
                    $sql .= "    sale_id, ";
                    $sql .= "    staff_div, ";
                    $sql .= "    staff_id, ";
                    $sql .= "    staff_name, ";
                    $sql .= "    sale_rate ";
                    $sql .= ") VALUES ( ";
                    $sql .= "    $sale_id, ";
                    $sql .= "    '0', ";
                    $sql .= "    $ac_staff_id, ";
                    $sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = ".$ac_staff_id."), ";
                    $sql .= "    100 ";
                    $sql .= ");";
//echo "$sql<br>";

                    $result = Db_Query($db_con, $sql);
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit();
                    }
                }

                //���ǡ�����Ͽ
                for($i = 1; $i <= 5; $i++){

                    //�����ӥ����ޤ��ϥ����ƥब���Ϥ���Ƥ���ԤΤ���Ͽ
                    if($serv_id[$i] != null || $goods_item_id[$i] != null){

                        //�����ѹ�
                        $c_price = $trade_price[$i];    //�Ķȸ���
                        $s_price = $sale_price[$i];     //���ñ��

                        //���ҽ��ǡ������ƥब���Ϥ���Ƥ����硢����ñ���ʺ߸�ñ���ˤ����
                        //if($goods_item_id[$i] != null){
                        if($contract_div == "1" && $goods_item_id[$i] != null){
                            //���ʤ������ʤ��ɤ���
                            $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$i].";";
                            $result = Db_Query($db_con, $sql);
                            if($result == false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit();
                            }
                            $compose_flg = pg_fetch_result($result, 0, "compose_flg");

                            //���ʤκ߸�ñ���ʻ���ñ�������������ˤ����
                            if($compose_flg == "t"){
                                $array_price = Compose_price($db_con, $shop_id, $goods_item_id[$i]);
                                $b_price = $array_price[2];
                                $b_amount = $array_price[2] * $goods_item_num[$i];
                            }else{
                                $sql  = "SELECT ";
                                $sql .= "    r_price ";
                                $sql .= "FROM ";
                                $sql .= "    t_price ";
                                $sql .= "WHERE ";
                                $sql .= "    goods_id = ".$goods_item_id[$i]." ";
                                $sql .= "AND ";
                                if($_SESSION["group_kind"] == "2"){
                                    $sql .= "    shop_id IN (".Rank_Sql().") ";
                                }else{
                                    $sql .= "    shop_id = ".$shop_id." ";
                                }
                                $sql .= "AND ";
                                $sql .= "    rank_cd = '3' ";   //�߸�ñ��
                                $sql .= ";";

                                $result = Db_Query($db_con, $sql);
                                if($result == false){
                                    Db_Query($db_con, "ROLLBACK;");
                                    exit;
                                }
                                $b_price = pg_fetch_result($result, 0, "r_price");
                                $b_amount = $b_price * $goods_item_num[$i];
                            }
                        //�����ӥ��������ޤ�����Ԥξ��ϱĶȸ�����Ʊ����ۤ������
                        }else{
                            $b_price = $c_price;
                            $b_amount = $trade_amount[$i];
                        }

                        //���ǡ�����Ͽ
                        $sql  = "INSERT INTO ";
                        $sql .= "    t_sale_d ";
                        $sql .= "( ";
                        $sql .= "    sale_d_id, ";
                        $sql .= "    sale_id, ";
                        $sql .= "    line, ";
                        $sql .= "    sale_div_cd, ";
                        if($serv_id[$i] != null){
                            $sql .= "    serv_print_flg, ";
                            $sql .= "    serv_id, ";
                            $sql .= "    serv_cd, ";
                            $sql .= "    serv_name, ";
                        }
                        if($goods_item_id[$i] != null){
                            $sql .= "    goods_print_flg, ";
                            $sql .= "    goods_id, ";
                            $sql .= "    goods_cd, ";
                            $sql .= "    goods_name, ";
                            $sql .= "    unit, ";
                            $sql .= "    g_product_name, ";
                            $sql .= "    official_goods_name, ";
                        }
                        if($goods_item_num[$i] != null){
                            $sql .= "    num, ";
                        }
                        if($set_flg[$i] == true){
                            $sql .= "    set_flg, ";
                        }
                        //������
                        if($goods_expend_id[$i] != null){
                            $sql .= "    egoods_id, ";
                            $sql .= "    egoods_cd, ";
                            $sql .= "    egoods_name, ";
                            $sql .= "    egoods_num, ";
                        }
                        //���ξ���
                        if($goods_body_id[$i] != null){
                            $sql .= "    rgoods_id, ";
                            $sql .= "    rgoods_cd, ";
                            $sql .= "    rgoods_name, ";
                            $sql .= "    rgoods_num, ";
                        }
                        //�Ҳ���
                        if($aprice_div[$i] == "2"){
                            $sql .= "    account_price, ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    account_rate, ";
                        }
                        $sql .= "    tax_div, ";
                        $sql .= "    buy_price, ";
                        $sql .= "    cost_price, ";
                        $sql .= "    sale_price, ";
                        $sql .= "    buy_amount, ";
                        $sql .= "    cost_amount, ";
                        $sql .= "    sale_amount, ";
                        $sql .= "    advance_flg, ";
                        $sql .= "    advance_offset_amount ";

                        $sql .= ") VALUES ( ";

                        //���ǡ���ID����
                        $microtime = NULL;
                        $microtime = explode(" ",microtime());
                        $sale_d_id   = $microtime[1].substr("$microtime[0]", 2, 5);
                        $sql .= "    $sale_d_id, ";

                        $sql .= "    $sale_id, ";
                        $sql .= "    ".(string)$i.", ";
                        $sql .= "    '".$divide[$i]."', ";
                        if($serv_id[$i] != null){
                            $sql .= "    ".$slip_flg[$i].", ";
                            $sql .= "    ".$serv_id[$i].", ";
                            $sql .= "    (SELECT serv_cd FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                            $sql .= "    (SELECT serv_name FROM t_serv WHERE serv_id = ".$serv_id[$i]."), ";
                        }
                        if($goods_item_id[$i] != null){
                            $sql .= "    ".$goods_item_flg[$i].", ";    //�����ƥ�����ե饰
                            $sql .= "    ".$goods_item_id[$i].", ";     //�����ƥ�ID
                            $sql .= "    '".$goods_item_cd[$i]."', ";
                            $sql .= "    '".$goods_item_name[$i]."', ";
                            $sql .= "    (SELECT unit FROM t_goods WHERE goods_id = ".$goods_item_id[$i]."), ";
                            $sql .= "    (SELECT g_product_name FROM t_g_product WHERE g_product_id = (SELECT g_product_id FROM t_goods WHERE goods_id = ".$goods_item_id[$i].")), ";
                            //$sql .= "    (SELECT goods_name FROM t_goods WHERE goods_id = ".$goods_item_id[$i]."), ";
                            $sql .= "    '".$official_goods_name[$i]."', "; //�����ƥ�̾��������
                        }
                        if($goods_item_num[$i] != null){
                            $sql .= "    ".$goods_item_num[$i].", ";
                        }
                        if($set_flg[$i] == true){
                            $sql .= "    '".$set_flg[$i]."', ";
                        }
                        //������
                        if($goods_expend_id[$i] != null){
                            $sql .= "    ".$goods_expend_id[$i].", ";
                            $sql .= "    '".$goods_expend_cd[$i]."', ";
                            $sql .= "    '".$goods_expend_name[$i]."', ";
                            $sql .= "    ".$goods_expend_num[$i].", ";
                        }
                        //���ξ���
                        if($goods_body_id[$i] != null){
                            $sql .= "    ".$goods_body_id[$i].", ";
                            $sql .= "    '".$goods_body_cd[$i]."', ";
                            $sql .= "    '".$goods_body_name[$i]."', ";
                            $sql .= "    ".$goods_body_num[$i].", ";
                        }
                        //�Ҳ���
                        if($aprice_div[$i] == "2"){
                            $sql .= "    ".$ac_price[$i].", ";
                        }elseif($aprice_div[$i] == "3"){
                            $sql .= "    '".$ac_rate[$i]."', ";
                        }
                        $sql .= "    '".$tax_div[$i]."', ";
                        $sql .= "    $b_price, ";
                        $sql .= "    $c_price, ";
                        $sql .= "    $s_price, ";
                        $sql .= "    $b_amount, ";
                        $sql .= "    ".$trade_amount[$i].", ";
                        $sql .= "    ".$sale_amount[$i].", ";
                        $sql .= "    '".$ad_flg[$i]."', ";
                        $sql .= ($ad_flg[$i] == "2") ? "    ".$ad_offset_amount[$i]." " : "    NULL ";

                        $sql .= ");";
//echo "$sql<br>";

                        $result = Db_Query($db_con, $sql);
                        if($result == false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }


                        //�����ʬ�����꡼��or��󥿥�ξ�硢�и��ʥơ��֥�ˤ���Ͽ���ʤ�
                        if($divide[$i] != '03' && $divide[$i] != '04'){

                            //�����ʡ������ӥ������η���Ƚ��
                            if($goods_item_com[$i] != 't' && $goods_item_id[$i] != NULL){
                                //�����ƥब���Ϥ���Ƥ������

                                //Ʊ�����ʤ�Ƚ�ꡣ
                                if($goods_ship_id[$goods_item_id[$i]] == NULL){
                                    //�����ξ���

                                    //�и�����Ͽ����
                                    //����[����ID][0] = ά��
                                    //����[����ID][1] = ����
                                    $goods_ship_id[$goods_item_id[$i]][0] = $goods_item_name[$i];
                                    $goods_ship_id[$goods_item_id[$i]][1] = $goods_item_num[$i];
                                }else{
                                    //Ʊ�����ʤξ��Ͽ��̤�­��

                                    //�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
                                    $goods_ship_id[$goods_item_id[$i]][1] = $goods_ship_id[$goods_item_id[$i]][1] + $goods_item_num[$i];
                                }
                            }else{
                                //���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

                                for($d=0;$d<count($item_parts[$i]);$d++){
                                    //Ʊ�����ʤ�Ƚ�ꡣ
                                    if($goods_ship_id[$item_parts[$i][$d][0]] == NULL){
                                        //�����ξ���

                                        //�и�����Ͽ����
                                        //����[����ID][0] = ά��
                                        //����[����ID][1] = ����
                                        $goods_ship_id[$item_parts[$i][$d][0]][0] = $item_parts_cname[$i][$d];
                                        $goods_ship_id[$item_parts[$i][$d][0]][1] = $item_parts_num[$i][$d];
                                    }else{
                                        //Ʊ�����ʤξ��Ͽ��̤�­��

                                        //�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
                                        $goods_ship_id[$item_parts[$i][$d][0]][1] = $goods_ship_id[$item_parts[$i][$d][0]][1] + $item_parts_num[$i][$d];
                                    }
                                }
                            }

                            //�����ʡ������ӥ������η���Ƚ��
                            if($goods_expend_com[$i] != 't' && $goods_expend_id[$i] != NULL){
                                //�����ʤ����Ϥ���Ƥ������

                                //Ʊ�����ʤ�Ƚ�ꡣ
                                if($goods_ship_id[$goods_expend_id[$i]] == NULL){
                                    //�����ξ���

                                    //�и�����Ͽ����
                                    //����[����ID][0] = ά��
                                    //����[����ID][1] = ����
                                    $goods_ship_id[$goods_expend_id[$i]][0] = $goods_expend_name[$i];
                                    $goods_ship_id[$goods_expend_id[$i]][1] = $goods_expend_num[$i];
                                }else{
                                    //Ʊ�����ʤξ��Ͽ��̤�­��

                                    //�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
                                    $goods_ship_id[$goods_expend_id[$i]][1] = $goods_ship_id[$goods_expend_id[$i]][1] + $goods_expend_num[$i];
                                }
                            }else{
                                //���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

                                for($d=0;$d<count($expend_parts[$i]);$d++){
                                    //Ʊ�����ʤ�Ƚ�ꡣ
                                    if($goods_ship_id[$expend_parts[$i][$d][0]] == NULL){
                                        //�����ξ���

                                        //�и�����Ͽ����
                                        //����[����ID][0] = ά��
                                        //����[����ID][1] = ����
                                        $goods_ship_id[$expend_parts[$i][$d][0]][0] = $expend_parts_cname[$i][$d];
                                        $goods_ship_id[$expend_parts[$i][$d][0]][1] = $expend_parts_num[$i][$d];
                                    }else{
                                        //Ʊ�����ʤξ��Ͽ��̤�­��

                                        //�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
                                        $goods_ship_id[$expend_parts[$i][$d][0]][1] = $goods_ship_id[$expend_parts[$i][$d][0]][1] + $expend_parts_num[$i][$d];
                                    }
                                }
                            }

                            //�����ӥ������η���ʳ��ϡ��Ѱդ�������ǡ�������Ͽ
                            if($goods_item_id[$i] != NULL || $goods_expend_id[$i] != NULL){
                                //�и�����ϿSQL
                                while($goods_ship_num = each($goods_ship_id)){
                                    //ź�����ξ���ID����
                                    $ship = $goods_ship_num[0];

                                    //�����ѥ����ǡ�������
                                    $sql  = "SELECT ";
                                    $sql .= "    t_goods.goods_cd ";
                                    $sql .= "FROM ";
                                    $sql .= "    t_goods ";
                                    $sql .= "WHERE ";
                                    $sql .= "    t_goods.goods_id = $ship;";
                                    $result = Db_Query($db_con, $sql);
                                    $ship_data = Get_Data($result);

                                    $sql  = "INSERT INTO t_sale_ship ( ";
                                    $sql .= "    sale_d_id,";
                                    $sql .= "    goods_id,";
                                    $sql .= "    goods_name,";
                                    $sql .= "    num, ";
                                    $sql .= "    goods_cd ";
                                    $sql .= "    )VALUES(";
                                    $sql .= "    $sale_d_id,";                     //����ǡ���ID
                                    $sql .= "    $ship,";                          //����ID
                                    $sql .= "    '".$goods_ship_id[$ship][0]."',"; //����̾
                                    $sql .= "    ".$goods_ship_id[$ship][1].",";   //����
                                    $sql .= "    '".$ship_data[0][0]."'";          //����CD
                                    $sql .= "    );";
                                    $result = Db_Query($db_con, $sql);

                                    if($result === false){
                                        Db_Query($db_con, "ROLLBACK;");
                                        exit;
                                    }

                                }
                            }
                        }
                        //�и�����Ͽ��������
                        $goods_ship_id = NULL;

                    }//���Ϲ�Ƚ�ꤪ���

                }//���ǡ�����Ͽ�����


                //���إå��ξҲ�Դط�����Ͽ
                $sql  = "UPDATE \n";
                $sql .= "    t_sale_h \n";
                $sql .= "SET \n";
                if($intro_account_id != null){
                    $sql .= "    intro_account_id = $intro_account_id, \n";     //�Ҳ��ID
                    $sql .= "    intro_ac_name = (SELECT client_cname FROM t_client WHERE client_id = $intro_account_id), \n";  //�Ҳ��̾��ά�Ρ�
                    $sql .= "    intro_ac_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $intro_account_id), \n";     //�Ҳ��CD1
                    $sql .= "    intro_ac_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $intro_account_id), \n";     //�Ҳ��CD1
                }else{
                    $sql .= "    intro_account_id = null, \n";
                    $sql .= "    intro_ac_name = null, \n";
                    $sql .= "    intro_ac_cd1 = null, \n";
                    $sql .= "    intro_ac_cd2 = null, \n";
                }
                $sql .= "    intro_ac_div = '$intro_ac_div', \n";               //�Ҳ���¶�ʬ
                $sql .= ($intro_ac_price != null) ? "    intro_ac_price = $intro_ac_price, \n" : "    intro_ac_price = null, \n";   //�Ҳ����ñ��
                $sql .= ($intro_ac_rate != null) ? "    intro_ac_rate = $intro_ac_rate \n" : "    intro_ac_rate = null \n";    //�Ҳ����Ψ
                $sql .= "WHERE \n";
                $sql .= "    sale_id = $sale_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //������˾Ҳ�Ԥ����ꤵ��Ƥ��ơ�ȯ�����ʤ�����ʤ���硢�Ҳ��������׻�
                if($intro_account_id != null && $intro_ac_div != "1"){
                    $intro_amount = FC_Intro_Amount_Calc($db_con, "sale", $sale_id);
                }else{
                    $intro_amount = null;
                }
                //���إå��ξҲ�������Ͽ
                $sql  = "UPDATE \n";
                $sql .= "    t_sale_h \n";
                $sql .= "SET \n";
                $sql .= ($intro_amount !== null) ? "    intro_amount = $intro_amount \n" : "    intro_amount = null \n";    //�Ҳ���¶��
                $sql .= "WHERE \n";
                $sql .= "    sale_id = $sale_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit();
                }

                //�Ҳ��������
                if($intro_amount !== null && $intro_amount > 0){
                    $return = FC_Intro_Buy_Query($db_con, $sale_id, $intro_account_id);
                    if($return == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit();
                    }
                }


                //���ҽ��ϼ�ʧ����Ͽ
                if($contract_div == "1"){
                    $return = FC_Trade_Query($db_con, $sale_id);

                //��Ԥξ����������������Ͽ
                }else{
                    $return = FC_Act_Buy_Query($db_con, $sale_id, $act_id, $cclient_shop);

                    if($return != false){

                        //�����ʬ���ֳݡפǡ������껦����ξ��������������򤪤���
                        if(($trade_sale == "11" || $trade_sale == "13" || $trade_sale == "14") && $ad_offset_flg){
                            //�����ʬ����13�������ʡפޤ��ϡ�14�����Ͱ��פξ��ϥޥ��ʥ�������
                            if($trade_sale == "13" || $trade_sale == "14"){
                                $ad_offset_total_amount = $ad_offset_total_amount * (-1);
                            }

                            //����ơ��֥�ˡ������������
                            $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $cclient_shop, $ad_offset_total_amount, $claim_div);
                        }

                        //�����ʬ���ָ���פξ��ϼ�ư������򤪤���
                        if($trade_sale == "61" || $trade_sale == "63" || $trade_sale == "64"){
                            //�����ʬ����63���������ʡפޤ��ϡ�64�������Ͱ��פξ��ϥޥ��ʥ�������
                            if($trade_sale == "63" || $trade_sale == "64"){
                                $pay_amount = ($sale_money + $sale_tax) * (-1);
                            }else{
                                $pay_amount = ($sale_money + $sale_tax);
                            }

                            //����ơ��֥�ˡָ��������
                            $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $cclient_shop);
                        }
                    }

                }
                if($return == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }else{
                    Db_Query($db_con, "COMMIT;");
                    //header("Location: ./1-2-205.php?sale_id=$sale_id&input_flg=true");
                    header("Location: ".$_SERVER["PHP_SELF"]."?sale_id=$sale_id&done_flg=true&change_flg=$change_flg&installment_flg=$trade_sale");
                }

            }//���ǡ����������ԥơ��֥롢���и��ʡ��߸˼�ʧ�ơ��֥���Ͽ�����

        }else{
            //��Ͽ��ǧ����
            if($contract_div == "1"){
                //���ҽ��ξ�硢���������԰����������
                $confirm_set_data["form_daiko"] = "";
                $confirm_set_data["form_daiko_price"] = "";
            //��Ԥξ�硢�ҸˤȽв��Ҹˤ����
            }else{
                $confirm_set_data["form_ac_staff_select"] = "";
                $confirm_set_data["form_ware_select"] = "";
            }
            $form->setConstants($confirm_set_data);

            //��Ͽ��ǧ���̤�ɽ���ե饰
            $comp_flg = true;
            $form->freeze();

        }
    }else{
        //���顼���ļ���ID��̵����н����
        //if($aord_id == NULL){
            //$client_data["form_sale_btn"]       = "";        //��ǧ���̤إܥ���
            $client_data["show_button_flg"]     = "";        //ɽ���ܥ���
            $form->setConstants($client_data);
        //}
    }
}



//��Ͽ��ǧ���̤Ǥϡ��ʲ��Υܥ����ɽ�����ʤ�
//if($_POST["form_sale_btn"] != "��ǧ���̤�" && $_POST["comp_button"] != "�ϡ���"){
if($comp_flg != true){

    //ɽ��
/*
    if($sale_id == NULL){
        $form->addElement("button","form_show_button","ɽ����","onClick=\"javascript:Button_Submit('show_button_flg','#','true')\"");
    }
*/

    //button
    $form->addElement("submit","form_sale_btn","��ǧ���̤�", $disabled);
//    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript: location.href='".FC_DIR."sale/2-2-207.php'\"");
//    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"Submit_Page('2-2-207.php')\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='2-2-207.php?search=1'\"");

    //���
    $form->addElement("button","form_sum_btn","�硡��","onClick=\"javascript:Button_Submit('sum_button_flg','#','true')\"");

//}elseif($_POST["form_sale_btn"] == "��ǧ���̤�"){
}else{
    //��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
    //OK
    //$form->addElement("submit","comp_button","�ϡ���", $disabled);
    $form->addElement("button","comp_button","�ϡ���", "onclick=\"Double_Post_Prevent('comp_button', 'hdn_comp_button', '�ϡ���');\"");
    $form->addElement("hidden","hdn_comp_button");

    $form->addElement("button","history_back","�ᡡ��","onClick=\"javascript: history.back();\"");

    //$form->freeze();
}

//��ɼʣ��
$form->addElement("button","slip_copy_button","��ɼʣ��","onClick=\"javascript: location.href='".FC_DIR."sale/2-2-201.php?sale_id=$sale_id&slip_copy=true'\"");

//���
$form->addElement("button","return_edit_button","�ᡡ��","onClick=\"javascript: location.href='".FC_DIR."sale/2-2-201.php?sale_id=$sale_id'\"");
if ($_GET["renew_flg"] == "true"){
    $form->addElement("button","return_button","�ᡡ��","onClick=\"history.back()\"");
}else{
    $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-207.php?search=1'\"");
}


$form->setConstants($con_data2);


//�ե����ब�ե꡼�����Ƥ뤫
$freeze_flg = $form->isFrozen();

#2009-09-17 hashimoto-y
#�ֻ�ɽ���ԤΥե饰�򥻥åȤ���
if($freeze_flg == true){
    $num = 5;
    $toSmarty_discount_flg = array();
    for ($i=1; $i<=$num; $i++){
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        if($hdn_discount_flg === 't' ||
           $trade_sale_select[0] == '13' || $trade_sale_select[0] == '14' || $trade_sale_select[0] == '63' || $trade_sale_select[0] == '64'
        ){
            $toSmarty_discount_flg[$i] = 't';
        }else{
            $toSmarty_discount_flg[$i] = 'f';

        }
    }
}


/****************************/
// ������ξ��ּ���
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
//javascript
/****************************/
//�켰�˥����å����դ�����硢��۷׻�����
/*
$java_sheet   = "function Set_num(row,coax) {\n";
$java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false);\n";
$java_sheet  .= "}\n\n";
*/

//�켰�˥����å����դ�����硢��۷׻�����
$java_sheet  .= "function Set_num(row, coax, daiko_coax){\n";
//FC��ľ��Ƚ��
if($group_kind == 2){
    //ľ�Ĥϡ���������θ�����׻�
    $java_sheet  .= "    Mult_double3('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false,row,'',daiko_coax);\n";
}else{
    //�ƣäϡ����̤ΰ켰�η׻�
    $java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax,false);\n";
}
$java_sheet  .= "}\n\n";


//��԰�������å��ܥå���
$java_sheet  .= <<<DAIKO
function tegaki_daiko_checked(){

    //��԰���Ƚ��
    if(!document.dateForm.daiko_check[0].checked){
        //����饤����ԡ����ե饤�����
        //�����
        //document.dateForm.elements["form_daiko_price"].disabled = false;
        //document.dateForm.elements["form_daiko_price"].style.backgroundColor = "white";

        //�����
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = false;
        }
        document.dateForm.elements["act_request_price"].disabled = false;
        document.dateForm.elements["act_request_rate"].disabled = false;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "white";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "white";

        //������
        document.dateForm.elements["form_daiko[cd1]"].disabled = false;
        document.dateForm.elements["form_daiko[cd2]"].disabled = false;
        document.dateForm.elements["form_daiko[name]"].disabled = false;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "white";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "white";

        //�������ʬ��value�ͼ���
        num = document.forms[0].elements["act_div[]"].length;
        for (i=0;i<num;i++) {
            flag = document.forms[0].elements["act_div[]"][i].checked;
            if (flag){
                act_div = document.forms[0].elements["act_div[]"][i].value;
            }
        }

        //�Ķȸ���
        if(act_div == "3"){
            for(i=1;i<=5;i++){
                form_name = "form_trade_price["+i+"][1]";
                document.dateForm.elements[form_name].readOnly = true;
                form_name = "form_trade_price["+i+"][2]";
                document.dateForm.elements[form_name].readOnly = true;
            }
        }

        //�в��Ҹ�
        document.dateForm.elements["form_ware_select"].disabled = true;
        document.dateForm.elements["form_ware_select"].style.backgroundColor = "gainsboro";

        //���ô����
        document.dateForm.elements["form_ac_staff_select"].disabled = true;
        document.dateForm.elements["form_ac_staff_select"].style.backgroundColor = "gainsboro";

    }else{
        //�̾�

        //�����
        //document.dateForm.elements["form_daiko_price"].disabled = true;
        //document.dateForm.elements["form_daiko_price"].style.backgroundColor = "gainsboro";

        //�����
        for(i=0;i<3;i++){
            document.dateForm.elements["act_div[]"][i].disabled = true;
        }
        document.dateForm.elements["act_request_price"].disabled = true;
        document.dateForm.elements["act_request_rate"].disabled = true;
        document.dateForm.elements["act_request_price"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["act_request_rate"].style.backgroundColor = "gainsboro";

        //������
        document.dateForm.elements["form_daiko[cd1]"].disabled = true;
        document.dateForm.elements["form_daiko[cd2]"].disabled = true;
        document.dateForm.elements["form_daiko[name]"].disabled = true;
        document.dateForm.elements["form_daiko[cd1]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[cd2]"].style.backgroundColor = "gainsboro";
        document.dateForm.elements["form_daiko[name]"].style.backgroundColor = "gainsboro";

        //�Ķȸ���
        for(i=1;i<=5;i++){
            form_name = "form_trade_price["+i+"][1]";
            document.dateForm.elements[form_name].readOnly = false;
            form_name = "form_trade_price["+i+"][2]";
            document.dateForm.elements[form_name].readOnly = false;
        }

        //�в��Ҹ�
        document.dateForm.elements["form_ware_select"].disabled = false;
        document.dateForm.elements["form_ware_select"].style.backgroundColor = "white";

        //���ô����
        document.dateForm.elements["form_ac_staff_select"].disabled = false;
        document.dateForm.elements["form_ac_staff_select"].style.backgroundColor = "white";

    }
    
    return true;
}

DAIKO;


//��Ԥ�JS���ɲ�
$java_sheet .= Create_Js("daiko");

//plan_data.inc��JS���ɲ�
$java_sheet .= $plan_data_js;



/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
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
    'warning'       => "$warning",
    //'html'          => "$html",
    'form_potision' => "$form_potision",
    'error_flg'     => $error_flg,
    'duplicate_err' => "$error",
    'error_msg3'    => "$error_msg3",
    'error_msg16'   => "$error_msg16",
    //'sale_div_error' => "$sale_div_error",
    'comp_flg'      => "$comp_flg",
    'auth_r_msg'    => "$auth_r_msg",
    'done_flg'      => "$done_flg", 
    'client_id'     => "$client_id", 
    'html_js'       => "$java_sheet", 
    'renew_flg'     => "$renew_flg", 
    'new_entry'     => "$new_entry",
    'slip_del_flg'  => "$slip_del_flg",
    'slip_renew_mess' => "$slip_renew_mess",
    'ad_total_warn_mess'    => "$ad_total_warn_mess",
    'freeze_flg'    => $freeze_flg,
    'buy_err_mess'  => "$buy_err_mess",
    'ac_name'       => "$ac_name",

    'contract_div'  => "$contract_div",
    "client_state_print"    => "$client_state_print",
));

$smarty->assign('error_msg4',$error_msg4);
$smarty->assign('error_msg5',$error_msg5);

$loop_array = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");
$smarty->assign('loop_num',$loop_array);
$smarty->assign('error_loop_num1',$loop_array);

#2009-09-17 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));


//echo "<font color=red style=\"font-family: 'HGS�Խ���';\"><b>�Խ���ˤĤ������ޤ���Ͽ�Ǥ��ޤ���</b></font>";
//print_array($smarty);
//print_array ($_POST);
//print_array ($_SESSION);

?>
