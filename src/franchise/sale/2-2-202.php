<?php
/**
 *
 * �����ɼ��������
 *
 * 1.0.0 (2006/08/30) ��������
 * 1.1.0 (2006/09/11) ��ǧ������ freeze����
 * 1.1.1 (2006/09/20) (kaji)
 *   ����������������������������դ������å������ɲ�
 * 1.1.2 (2006/09/30) (kaji)
 *   ���������������������������������Ϥ��줿���Υ��顼��å������ѹ�
 * 1.1.3 (2006/11/16) (suzuki)
 *   �������ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��ä���ɽ�����ʤ��褦�˽���
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.3 (2006/11/16)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/10      03-015      kajioka-h   ������̾��;�פʥ��˥������󥰤��ä�
 *                  03-016      kajioka-h   �Ҳ�����0�ΤȤ��ϻ����򵯤��ʤ��褦��
 *  2006/11/11      03-026      kajioka-h   �ѹ���ľ���������������줿���˥��顼�ˤ���������ɲ�
 *                  03-025      kajioka-h   �ѹ���ľ��������ä��줿���˥��顼�ˤ���������ɲ�
 *                  03-051      kajioka-h   �������Ρֱߡס�%�פ򳥿��ˡ�;�פ�<br>��ʤ���
 *  2006-11-29      scl_308-8-4 suzuki      �����ɼ�ΤȤ��˰켰�������ɽ�������褦�˽���
 *  2006-12-10      03-090      suzuki      �����ʤξ��ʥ�����ɽ������褦�˽���
 *  2006-12-11      03-068      suzuki      ����������ǡ������ä��줿�饨�顼ɽ������褦�˽���
 *  2007/03/05      ��˾6-2     kajioka-h   �����ʡ����ξ��ʡ��Ҳ����������Ͽ��ǽ��
 *  2007/03/08      B0702-015   kajioka-h   ���ʤ���̾�ѹ��ԲĢ��ѹ��Ĥ��Ѥ����ݤˡ��ե����ब��̾�ѹ���ǽ�ˤʤ�ʤ��Х�����
 *  2007/04/05      ����¾25    kajioka-h   �Ҳ����������λ���������Υ����å������ɲ�
 *  2007/04/09      ��˾1-4     kajioka-h   �Ҳ�������λ����ѹ�
 *  2007/04/11      ��˾1-4     kajioka-h   �Ҳ�������Υ饸���ܥ��󤬷���ޥ����ȹ�äƤ��ʤ��ä��Τ���
 *  2007/04/13      ����¾      kajioka-h   ���������ע���ͽ�������פ�ɽ���ѹ�
 *  2007/05/17      xx-xxx      kajioka-h   ͽ��ǡ������١�ͽ��ǡ��������������ɼ�����������ɼ�ǥ쥤�����Ȥ��碌��
 *  2007/06/05      xx-xxx      kajioka-h   ͽ�����ľ�������Ͽ�Ǥ���褦�ˤ�����
 *  2007/06/16      ����¾14    kajioka-h   ������
 *  2007/06/18      B0702-062   kajioka-h   �Ҳ�������������η���������������������å�ϳ�����
 *  2007-07-12                  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *  2007/07/17      B0702-072   kajioka-h   �Ҳ�����褢��ǾҲ��������ȯ�����ʤ����˥��顼�ˤʤ�Х�����
 *  2007/08/01      B0702-075   kajioka-h   �Ҳ�������ʤ�������Ҳ������������ѹ��������˥��顼�ˤʤ�Х�����
 *  2008/01/19                  watanabe-k  ���������ۤζ����Х�����trust_net_amount => act_request_amount���ѹ�
 *  2009/09/26                  hashimoto-y �Ͱ����ʤ����򤷤������ֻ�ɽ��
 *  2009/12/22                  aoyama-n    ��Ψ��TaxRate���饹�������
 *  2010/07/06                  watanabe-k  ���ǡ����ؤ���Ͽ������ǡ������ʬ���ͤ�''�ǰϤ��褦�˽���
 *
 */

$page_title = "�����ɼ";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

//echo "<font color=red style=\"font-family: 'HG�ϱѳюΎߎ��̎���';\"><b>�Խ���ˤĤ�����Ͽ�Ǥ��ޤ���</b></font>";

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//���顼��å��������
/****************************/
require_once(INCLUDE_DIR."error_msg_list.inc");

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

//�����ʬ�δؿ�
require_once(PATH ."function/trade_fc.fnc");


/****************************/
// �����ѿ�����
/****************************/

//���ID
if($_GET["sale_id"] == null){
    $sale_id = $_POST["hdn_sale_id"];
}else{
    $sale_id = $_GET["sale_id"];
}
//ľ��󥯤����ܤ��Ƥ������ˤϡ�TOP�����Ф�
Get_Id_Check2($sale_id);

//����Ƚ��
Get_ID_Check3($sale_id);

$con_data["hdn_sale_id"] = $sale_id;
$shop_id    = $_SESSION["client_id"];  //��������桼��ID
$client_h_id = $_SESSION["client_id"];  //��������桼��ID
$staff_id   = $_SESSION["staff_id"];   //���������ID

$group_kind = $_SESSION["group_kind"];  //���롼�׼���

$plan_sale_flg = true;                  //�����ɼ�������˥ե饰


#2009-12-22 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);


//select����������
//require_once(PATH."include/select_part.php");
/*
//���
$form->addElement("button","form_make_button","���","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//������
$form->addElement("button","form_revision_button","������","onClick=\"javascript:Referer('2-2-202.php')\"");
//ȯ����
$form->addElement("button","form_public_button","ȯ����","onClick=\"javascript:Referer('2-2-203.php')\"");
*/

//������Ƚ��
$sql  = "SELECT confirm_flg FROM t_aorder_h WHERE aord_id = $sale_id;";
$result = Db_Query($db_con, $sql);
$check_data = Get_Data($result);
if($check_data[0][0] == "f"){
    $error_msg14 = "��ɼ�������ä���Ƥ���١��ѹ��Ǥ��ޤ���";
    $check_error_flg = true;
    //������������ܥܥ���
//    $form->addElement("button","disp_btn","O��K","onClick=\"location.href='".FC_DIR."sale/2-2-207.php'\"");
    $form->addElement("button","disp_btn","�ϡ���", "onClick=\"location.href='2-2-207.php?search=1'\"");
}

//�����ä���Ƥ���ʹ߽������ʤ�
if($check_error_flg == false){

    /****************************/
    // ���������Ѥ�
    /****************************/

    $error_flg = false;

    //GET��renew_flg�����������ɽ���˾�硢�ޤ������������Ѥξ��freeze�����
    if($_GET["renew_flg"] == "true"){
        $renew_flg = true;
    }else{
        $sql  = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $sale_id AND ";
        $sql .= ($group_kind == "2") ? "shop_id IN (".Rank_Sql().");" : "shop_id = $shop_id;";
        $result = Db_Query($db_con, $sql);
        
        if(pg_num_rows($result) == 0){
            if(isset($_POST["form_claim"]) == false){
                Get_ID_Check($result);
            }
            $renew_flg = true;
            $concurrent_err_flg = true;
        }else{
            $renew_flg = (pg_fetch_result($result, 0, "renew_flg") == "t") ? true : false;
            //������������Ƥ��ơ��ѹ��ܥ��󤬲�����Ƥ�����ϥ��顼ɽ��
            if($renew_flg && $_POST["entry_flg"] == "true"){
                $slip_renew_mess = $h_mess[50];
                $concurrent_err_flg = true;
                $error_flg = true;
            }
        }
    }


    /****************************/
    // ��ư�ǵ��������������夫��FC�Τߡ�
    /****************************/

    if($group_kind != "2"){
        $sql  = "SELECT COUNT(sale_id) FROM t_sale_h WHERE sale_id = $sale_id AND contract_div = '2' AND shop_id = $shop_id;";
        $result = Db_Query($db_con, $sql);
        $renew_flg = (pg_fetch_result($result, 0, 0) == 1) ? true : $renew_flg;
    }

    if($group_kind == "2"){
        //��Ԥξ���ľ�Ĥ�ե꡼��
        $sql  = "SELECT COUNT(sale_id) FROM t_sale_h WHERE sale_id = $sale_id AND contract_div != '1' AND shop_id IN (".Rank_Sql().");";
        $result = Db_Query($db_con, $sql);
        $renew_flg = (pg_fetch_result($result, 0, 0) == 1) ? true : $renew_flg;


        //ľ�Ĥǡ��Ҳ���¤����ꡢ�Ҳ���¤�FC�ǡ����λ�����������������������Ƥ���ȥե꡼��
        $sql  = "SELECT \n";
        $sql .= "    t_sale_h.intro_account_id, \n";
        $sql .= "    t_client.client_div, \n";
        $sql .= "    t_buy_h.renew_flg \n";
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";
        $sql .= "    LEFT JOIN t_client ON t_sale_h.intro_account_id = t_client.client_id \n";
        $sql .= "    LEFT JOIN t_buy_h ON t_sale_h.sale_id = t_buy_h.intro_sale_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_sale_h.sale_id = $sale_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        if( pg_fetch_result($result, 0, "intro_account_id") != null && 
            pg_fetch_result($result, 0, "client_div") == "3" && 
            pg_fetch_result($result, 0, "renew_flg") == "t" 
        ){
            $renew_flg = true;
        }
    }

    //������������Ƥ��� or ��ư���ξ��ϥե꡼��
    if($renew_flg){
        $form->freeze();
    }



    //����ID�ʲ��ˡ�
    //$aord_id = "hand_slip";

    /****************************/
    // ���إå����ǡ�������
    /****************************/

    if(true){
    //if(isset($_POST["form_claim"]) == false || $concurrent_err_flg != true){
        //���إå������ô����
        $sql  = "SELECT \n";
        $sql .= "    t_sale_h.sale_no, \n";         //0
        $sql .= "    t_sale_h.aord_id, \n";         //1
        $sql .= "    t_sale_h.sale_day, \n";        //2
        $sql .= "    t_sale_h.claim_day, \n";       //3
        //$sql .= "    t_trade.trade_name, \n";
        $sql .= "    t_sale_h.trade_id, \n";        //4
        $sql .= "    t_sale_h.client_id, \n";       //5
        $sql .= "    t_sale_h.c_shop_name, \n";     //6
        $sql .= "    t_sale_h.c_shop_name2, \n";    //7
        $sql .= "    t_sale_h.client_cd1, \n";      //8
        $sql .= "    t_sale_h.client_cd2, \n";      //9
        $sql .= "    t_sale_h.client_cname, \n";    //10
        $sql .= "    t_sale_h.claim_id, \n";        //11
        $sql .= "    t_sale_h.intro_account_id, \n";    //12
        $sql .= "    t_sale_h.intro_ac_name, \n";   //13
        $sql .= "    t_sale_h.ware_id, \n";         //14
        $sql .= "    t_sale_h.ware_name, \n";       //15
        $sql .= "    t_sale_staff0.staff_id AS staff_id0, \n";      //16
        $sql .= "    t_sale_staff0.staff_name AS staff_name0, \n";  //17
        $sql .= "    t_sale_staff0.sale_rate AS sale_rate0, \n";    //18
        $sql .= "    t_sale_staff1.staff_id AS staff_id1, \n";      //19
        $sql .= "    t_sale_staff1.staff_name AS staff_name1, \n";  //20
        $sql .= "    t_sale_staff1.sale_rate AS sale_rate1, \n";    //21
        $sql .= "    t_sale_staff2.staff_id AS staff_id2, \n";      //22
        $sql .= "    t_sale_staff2.staff_name AS staff_name2, \n";  //23
        $sql .= "    t_sale_staff2.sale_rate AS sale_rate2, \n";    //24
        $sql .= "    t_sale_staff3.staff_id AS staff_id3, \n";      //25
        $sql .= "    t_sale_staff3.staff_name AS staff_name3, \n";  //26
        $sql .= "    t_sale_staff3.sale_rate AS sale_rate3, \n";    //27
        $sql .= "    t_sale_h.cost_amount, \n";     //28
        $sql .= "    t_sale_h.net_amount, \n";      //29
        $sql .= "    t_sale_h.tax_amount, \n";      //30
        $sql .= "    t_sale_h.note, \n";            //31
        $sql .= "    t_sale_h.slip_flg, \n";        //32
        $sql .= "    t_sale_h.slip_out, \n";        //33
        $sql .= "    t_sale_h.act_id, \n";          //34
        $sql .= "    t_sale_h.intro_ac_price, \n";  //35
        $sql .= "    t_sale_h.intro_ac_rate, \n";   //36
        $sql .= "    t_sale_h.contract_div, \n";    //37
        $sql .= "    t_sale_h.intro_amount, \n";    //38
        $sql .= "    t_sale_h.act_request_flg, \n"; //39
        $sql .= "    t_sale_h.route, \n";           //40
        $sql .= "    t_sale_h.reason_cor, \n";      //41
        $sql .= "    t_client.coax, \n";            //42
        $sql .= "    t_sale_h.round_form, \n";      //43
        $sql .= "    t_sale_h.claim_div, \n";       //44
        $sql .= "    t_sale_h.shop_id, \n";         //45
        $sql .= "    t_sale_h.intro_ac_cd1, \n";    //46
        $sql .= "    t_sale_h.intro_ac_cd2, \n";    //47
        $sql .= "    t_sale_h.intro_ac_div, \n";    //48
        $sql .= "    t_sale_h.act_cd1, \n";         //49
        $sql .= "    t_sale_h.act_cd2, \n";         //50
        $sql .= "    t_sale_h.act_cname, \n";       //51
        $sql .= "    t_sale_h.act_div, \n";         //52
        $sql .= "    t_sale_h.act_request_price, \n";   //53
        $sql .= "    t_sale_h.act_request_rate, \n";    //54
        $sql .= "    t_sale_h.hand_plan_flg, \n";       //55 ͽ����ե饰
        $sql .= "    t_sale_h.direct_id, \n";           //56 ľ����ID
        $sql .= "    t_sale_h.advance_offset_totalamount \n";   //57 �����껦�۹��

        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";
        $sql .= "    INNER JOIN t_client ON t_sale_h.client_id = t_client.client_id \n";
        //$sql .= "    INNER JOIN t_trade ON t_sale_h.trade_id = t_trade.trade_id \n";
        $sql .= "    LEFT JOIN t_sale_staff AS t_sale_staff0 \n";
        $sql .= "        ON t_sale_h.sale_id = t_sale_staff0.sale_id \n";
        $sql .= "        AND t_sale_staff0.staff_div = '0' \n";
        $sql .= "    LEFT JOIN t_sale_staff AS t_sale_staff1 \n";
        $sql .= "        ON t_sale_h.sale_id = t_sale_staff1.sale_id \n";
        $sql .= "        AND t_sale_staff1.staff_div = '1' \n";
        $sql .= "    LEFT JOIN t_sale_staff AS t_sale_staff2 \n";
        $sql .= "        ON t_sale_h.sale_id = t_sale_staff2.sale_id \n";
        $sql .= "        AND t_sale_staff2.staff_div = '2' \n";
        $sql .= "    LEFT JOIN t_sale_staff AS t_sale_staff3 \n";
        $sql .= "        ON t_sale_h.sale_id = t_sale_staff3.sale_id \n";
        $sql .= "        AND t_sale_staff3.staff_div = '3' \n";
        $sql .= "WHERE \n";
        $sql .= "    t_sale_h.sale_id = $sale_id \n";
        $sql .= "    AND \n";
        if($_SESSION["group_kind"] == "2"){
            $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") \n";
        }else{
            $sql .= "    t_sale_h.shop_id = $shop_id \n";
        }
        $sql .= ";\n";
/*
echo "���إå���";
print_array($sql);
*/

        $result = Db_Query($db_con, $sql);
        Get_Id_Check($result);
        if($result == false){
            exit();
        }

        $data_list = Get_Data($result, 2);
//print_array($data_list);

        $sale_no                                = $data_list[0][0];                              //��ɼ�ֹ�

        $deli_day                               = explode('-',$data_list[0][2]);                 //ͽ������
        $con_data["form_delivery_day"]["y"]     = $deli_day[0];
        $con_data["form_delivery_day"]["m"]     = $deli_day[1];
        $con_data["form_delivery_day"]["d"]     = $deli_day[2];
        $req_day                                = explode('-',$data_list[0][3]);                 //������
        $con_data["form_request_day"]["y"]      = $req_day[0];
        $con_data["form_request_day"]["m"]      = $req_day[1];
        $con_data["form_request_day"]["d"]      = $req_day[2];
        $con_data["trade_aord"]                 = $data_list[0][4];                              //�����ʬ
        $data_list[0][40]                       = str_pad($data_list[0][40], 4, 0, STR_POS_LEFT);   //��ϩ
        $con_data["form_route_load"][1]         = substr($data_list[0][40],0,2);
        $con_data["form_route_load"][2]         = substr($data_list[0][40],2,2);
        $client_id                              = $data_list[0][5];                             //������ID
        //$shop_name                              = $data_list[0][6];                             //����å�̾
        //$shop_name2                             = $data_list[0][7];                             //����å�̾2
        //$client_cd                              = $data_list[0][8]."-".$data_list[0][9];        //������CD
        $con_data["form_client"]["cd1"]         = $data_list[0][8];                             //������CD1
        $con_data["form_client"]["cd2"]         = $data_list[0][9];                             //������CD1
        $con_data["form_client"]["name"]        = $data_list[0][10];          //������̾��ά�Ρ�

        $con_data["form_claim"]                 = $data_list[0][11].",".$data_list[0][44];      //������ID���������ʬ

        $con_data["form_ac_id"]                 = $data_list[0][12];                            //�Ҳ��ID
        $intro_account_id                       = $data_list[0][12];                            //����������Ƚ��ǻ���

        //$con_data["form_ac_name"]               = $data_list[0][13];                            //�Ҳ��̾
        $intro_ac_div                           = $data_list[0][48];                            //�Ҳ���¶�ʬ
        $con_data["intro_ac_div[]"]             = $intro_ac_div;                                //�Ҳ���¶�ʬ
        $con_data["intro_ac_price"]             = $data_list[0][35];                            //�Ҳ����ñ��
        $con_data["intro_ac_rate"]              = $data_list[0][36];                            //�Ҳ����Ψ

        //�Ҳ�Ԥ�FC�������褫Ƚ��
        if($intro_account_id != null){
            $sql = "SELECT client_div FROM t_client WHERE client_id = $intro_account_id;";
            $result = Db_Query($db_con, $sql);
            //������ξ�硢�Ҳ��CD1�Τ�
            if(pg_fetch_result($result, 0, "client_div") == "2"){
                $ac_name = $data_list[0][46]."<br>".htmlspecialchars($data_list[0][13]);
            }else{
                $ac_name = $data_list[0][46]."-".$data_list[0][47]."<br>".htmlspecialchars($data_list[0][13]);
            }
        //�Ҳ�Ԥ��ʤ����
        }else{
            $ac_name = "̵��";
            $con_data2["intro_ac_div[]"] = 1;
        }


        //$con_data["form_ware_id"]               = $data_list[0][14];                            //�в��Ҹ�ID
        //$con_data["form_ware_name"]             = $data_list[0][15];                            //�в��Ҹ�̾
        $ware_name                              = htmlspecialchars($data_list[0][15]);           //�в��Ҹ�̾

        $con_data["form_c_staff_id1"]           = $data_list[0][16];                             //ô���ԣ�
        $con_data["form_sale_rate1"]            = $data_list[0][18];                             //���Ψ��
        $con_data["form_c_staff_id2"]           = $data_list[0][19];                             //ô���ԣ�
        $con_data["form_sale_rate2"]            = $data_list[0][21];                             //���Ψ��
        $con_data["form_c_staff_id3"]           = $data_list[0][22];                             //ô���ԣ�
        $con_data["form_sale_rate3"]            = $data_list[0][24];                             //���Ψ��
        $con_data["form_c_staff_id4"]           = $data_list[0][25];                             //ô���ԣ�
        $con_data["form_sale_rate4"]            = $data_list[0][27];                             //���Ψ��

        $money                                  = $data_list[0][29];                             //����ۡ���ȴ��
        $tax_money                              = $data_list[0][30];                             //������
        $total_money                            = $money + $tax_money;                           //��ɼ���
        //$money = number_format($money);
        //$tax_money = number_format($tax_money);
        //$total_money = number_format($total_money);
        $con_data["form_sale_total"]            = number_format($money);
        $con_data["form_sale_tax"]              = number_format($tax_money);
        $con_data["form_sale_money"]            = number_format($total_money);


        //�Ȳ���̡����������ѡ�����ɽ�����ˤǤϤ�����ɼ��ȯ������������ϻĹ�˴ޤ�ʤ�
        if($renew_flg){
            $ad_rest_price                      = Advance_Offset_Claim($db_con, $data_list[0][2], $data_list[0][5], $data_list[0][44]);
        }else{
            $ad_rest_price                      = Advance_Offset_Claim($db_con, $data_list[0][2], $data_list[0][5], $data_list[0][44], $sale_id);
        }
        $con_data["form_ad_rest_price"]         = number_format($ad_rest_price);
        $con_data["form_ad_offset_total"]       = ($data_list[0][57] != null) ? number_format($data_list[0][57]) : "";      //�����껦�۹��

        $con_data["form_note"]                  = $data_list[0][31];                             //����
        $con_data["form_reason"]                = $data_list[0][41];                             //������ͳ

        //������ID��hidden�ˤ���ݻ�����
        if($client_id != NULL){
            $con_data["hdn_client_id"] = $client_id;
        }else{
            $client_id = $_POST["hdn_client_id"];
        }

        //��԰���������Ƚ��
        if($data_list[0][22] != NULL){
            $trust_rate                             = $data_list[0][22];
        }else{
            $trust_rate                             = '0';
        }
        $con_data2["hdn_trust_rate"]            = $trust_rate;                                   //hidden���ݻ�

        $contract_div                           = $data_list[0][37];                             //�����ʬ
        $con_data2["hdn_contract_div"]          = $contract_div;                                 //hidden���ݻ�

/*
        //ľ��¦���������ɼ�����������硢�Ķȸ����������Բ�
        if($contract_div != '1' && $group_kind != 3){
            $form_load = "onLoad=\"daiko_checked();\"";
        }
*/
        $act_id                                 = $data_list[0][24];                                //�����ID
        if($contract_div != "1" && $group_kind == "2"){
            $con_data["form_act_cd"]            = $data_list[0][49]." - ".$data_list[0][50];        //�����CD
            $con_data["form_act_name"]          = $data_list[0][51];                                //�����̾��ά�Ρ�

#watanabe-k
#            $sql = "SELECT trust_net_amount FROM t_aorder_h WHERE aord_id = ".$data_list[0][1].";";
            $sql = "SELECT act_request_price, trust_net_amount FROM t_aorder_h WHERE aord_id = ".$data_list[0][1].";";
            $result = Db_Query($db_con, $sql);

            //������
            if($data_list[0][52] == "1"){
                $con_data["form_act_price"] = "ȯ�����ʤ�";
            }elseif($data_list[0][52] == "2"){
                $con_data["form_act_price"] = number_format(pg_fetch_result($result, 0, 0))."�ʸ���ۡ�";
            }elseif($data_list[0][52] == "3"){
                $con_data["form_act_price"] = number_format(pg_fetch_result($result, 0, 1))."������".$data_list[0][54]."���";
            }
        }

        $coax                                   = $data_list[0][42];                                //�ޤ���ʬ

        $con_data["hdn_h_intro_ac_price"]       = $data_list[0][35];                                //�Ҳ�����ñ���ˡʥإå���
        $con_data["hdn_h_intro_ac_rate"]        = $data_list[0][36];                                //�Ҳ�����Ψ�ˡʥإå���
        $round_form                             = $data_list[0][43];                                //�������ʸ����

        $shop_id                                = $data_list[0][45];                                //ô����Ź

        $hand_plan_flg                          = ($data_list[0][55] == "t") ? true : false;        //ͽ����ե饰
        $con_data["form_direct_select"]         = $data_list[0][56];                                //ľ����ID


        //----------------//
        // ���ǡ�������
        //----------------//
        $sql  = "SELECT \n";
        $sql .= "    t_sale_d.sale_d_id, \n";           //0
        $sql .= "    t_sale_d.sale_id, \n";             //1
        $sql .= "    t_sale_d.line, \n";                //2
        $sql .= "    t_sale_d.sale_div_cd, \n";         //3
        $sql .= "    t_sale_d.serv_print_flg, \n";      //4
        $sql .= "    t_sale_d.serv_id, \n";             //5
        $sql .= "    t_sale_d.serv_cd, \n";             //6
        $sql .= "    t_sale_d.serv_name, \n";           //7
        $sql .= "    t_sale_d.set_flg, \n";             //8
        $sql .= "    t_sale_d.goods_print_flg, \n";     //9
        $sql .= "    t_sale_d.goods_id, \n";            //10
        $sql .= "    t_sale_d.goods_cd, \n";            //11
        //$sql .= "    t_sale_d.g_product_name, \n";
        $sql .= "    t_sale_d.goods_name, \n";          //12
        $sql .= "    t_item.name_change AS goods_name_change, \n";  //13
        $sql .= "    t_sale_d.num, \n";                 //14
        $sql .= "    t_sale_d.unit, \n";                //15
        $sql .= "    t_sale_d.tax_div, \n";             //16
        $sql .= "    t_sale_d.buy_price, \n";           //17
        $sql .= "    t_sale_d.cost_price, \n";          //18
        $sql .= "    t_sale_d.sale_price, \n";          //19
        $sql .= "    t_sale_d.buy_amount, \n";          //20
        $sql .= "    t_sale_d.cost_amount, \n";         //21
        $sql .= "    t_sale_d.sale_amount, \n";         //22
        $sql .= "    t_sale_d.rgoods_id, \n";           //23
        $sql .= "    t_sale_d.rgoods_cd, \n";           //24
        $sql .= "    t_sale_d.rgoods_name, \n";         //25
        $sql .= "    t_body.name_change AS rgoods_name_change, \n"; //26
        $sql .= "    t_sale_d.rgoods_num, \n";          //27
        $sql .= "    t_sale_d.egoods_id, \n";           //28
        $sql .= "    t_sale_d.egoods_cd, \n";           //29
        $sql .= "    t_sale_d.egoods_name, \n";         //30
        $sql .= "    t_expend.name_change AS egoods_name_change, \n";   //31
        $sql .= "    t_sale_d.egoods_num, \n";          //32
        $sql .= "    t_sale_d.aord_d_id, \n";           //33
        $sql .= "    t_sale_d.contract_id, \n";         //34
        $sql .= "    t_sale_d.account_price, \n";       //35
        $sql .= "    t_sale_d.account_rate, \n";        //36
        $sql .= "    t_sale_d.official_goods_name, \n"; //37
        $sql .= "    t_sale_d.advance_flg, \n";         //38
        #2009-09-26 hashimoto-y
        #$sql .= "    t_sale_d.advance_offset_amount \n";//39
        $sql .= "    t_sale_d.advance_offset_amount, \n";//39
        $sql .= "    t_item.discount_flg  \n";//40

        $sql .= "FROM \n";
        $sql .= "    t_sale_d \n";
        $sql .= "    LEFT JOIN t_goods AS t_item ON t_item.goods_id = t_sale_d.goods_id \n";
        $sql .= "    LEFT JOIN t_goods AS t_body ON t_body.goods_id = t_sale_d.rgoods_id \n";
        $sql .= "    LEFT JOIN t_goods AS t_expend ON t_expend.goods_id = t_sale_d.egoods_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_sale_d.sale_id = $sale_id \n";
        $sql .= "ORDER BY \n";
        $sql .= "    t_sale_d.line \n";
        $sql .= ";";
/*
echo "���ǡ�����";
print_array($sql);
*/

        $result = Db_Query($db_con, $sql);
        if($result == false){
            exit();
        }
        $sale_d_count = pg_num_rows($result);

        $sub_data = Get_Data($result, 2);
//print_array($sub_data);


        //����ID�˳�������ǡ�����¸�ߤ��뤫
        for($s=0;$s<$sale_d_count;$s++){
            $search_line = $sub_data[$s][2];        //���ֹ�
            //���¶�ʬ�ν���ͤ����ꤷ�ʤ�������
            $aprice_array[] = $search_line;

            $sale_d_id = $sub_data[$s][0];          //���ǡ���ID
            $con_data["hdn_aord_d_id"][$search_line]                = $sub_data[$s][0]; //���ǡ���ID

            $con_data["form_divide"][$search_line]                  = $sub_data[$s][3];   //�����ʬ

            $con_data["form_print_flg1"][$search_line] = ($sub_data[$s][4] == 't') ? "1" : "";  //�����ӥ������ե饰
            $con_data["form_serv"][$search_line]                    = $sub_data[$s][5];    //�����ӥ�

            $con_data["form_print_flg2"][$search_line] = ($sub_data[$s][9] == 't') ? "1" : "";  //�����ƥ���ɼ�����ե饰
            $con_data["hdn_goods_id1"][$search_line]                = $sub_data[$s][10];  //�����ƥ�ID
            $con_data["form_goods_cd1"][$search_line]               = $sub_data[$s][11];  //�����ƥ�CD
            $con_data["hdn_name_change1"][$search_line]             = $sub_data[$s][13];  //�����ƥ���̾�ѹ��ե饰
            $hdn_name_change[1][$search_line]                       = $sub_data[$s][13];  //POST�������˥����ƥ�̾���ѹ��Բ�Ƚ���Ԥʤ���
            $con_data["form_goods_name1"][$search_line]             = $sub_data[$s][12];  //�����ƥ�̾��ά�Ρ�
            $con_data["form_goods_num1"][$search_line]              = $sub_data[$s][14];  //�����ƥ��
            $con_data["official_goods_name"][$search_line]          = $sub_data[$s][37];  //�����ƥ�̾��������

            //�����ʬ����ԤΤ߷����ѹ�
            if($contract_div != '1'){
                $con_data["form_issiki"][$search_line] = ($sub_data[$s][8] == 't') ? "�켰" : "";   //�켰�ե饰
            }else{
                $con_data["form_issiki"][$search_line] = ($sub_data[$s][8] == 't') ? "1" : "";      //�켰�ե饰
            }

            $cost_price = explode('.', $sub_data[$s][18]);                                //�Ķȸ���
            $con_data["form_trade_price"][$search_line]["1"] = $cost_price[0];
            $con_data["form_trade_price"][$search_line]["2"] = ($cost_price[1] != null) ? $cost_price[1] : '00';

            $sale_price = explode('.', $sub_data[$s][19]);                                //���ñ��
            $con_data["form_sale_price"][$search_line]["1"] = $sale_price[0];
            $con_data["form_sale_price"][$search_line]["2"] = ($sale_price[1] != null) ? $sale_price[1] : '00';

            $con_data["form_trade_amount"][$search_line]    = number_format($sub_data[$s][21]);  //�Ķȶ��
            $con_data["form_sale_amount"][$search_line]     = number_format($sub_data[$s][22]);  //�����

            $con_data["hdn_goods_id2"][$search_line]                = $sub_data[$s][23];    //����ID
            $con_data["form_goods_cd2"][$search_line]               = $sub_data[$s][24];    //����CD
            $con_data["hdn_name_change2"][$search_line]             = $sub_data[$s][26];    //������̾�ѹ��ե饰
            $hdn_name_change[2][$search_line]                       = $sub_data[$s][26];    //POST������������̾���ѹ��Բ�Ƚ���Ԥʤ���
            $con_data["form_goods_name2"][$search_line]             = $sub_data[$s][25];    //����̾
            $con_data["form_goods_num2"][$search_line]              = $sub_data[$s][27];    //���ο�

            $con_data["hdn_goods_id3"][$search_line]                = $sub_data[$s][28];    //������ID
            $con_data["form_goods_cd3"][$search_line]               = $sub_data[$s][29];    //������CD
            $con_data["hdn_name_change3"][$search_line]             = $sub_data[$s][31];    //��������̾�ѹ��ե饰
            $hdn_name_change[3][$search_line]                       = $sub_data[$s][31];    //POST�������˾�����̾���ѹ��Բ�Ƚ���Ԥʤ���
            $con_data["form_goods_name3"][$search_line]             = $sub_data[$s][30];    //������̾
            $con_data["form_goods_num3"][$search_line]              = $sub_data[$s][32];    //�����ʿ�

            //����ñ��
            if($sub_data[$s][35] != NULL){
                //��
                $con_data["form_account_price"][$search_line]       = $sub_data[$s][35];    //����ñ��
                $con_data["form_aprice_div[$search_line]"] = 2;
            }else if($sub_data[$s][36] != NULL){
                //Ψ
                $con_data["form_account_rate"][$search_line]        = $sub_data[$s][36];    //����Ψ
                $con_data["form_aprice_div[$search_line]"] = 3;
            }else{
                //�ʤ�
                $con_data["form_aprice_div[$search_line]"] = 1;
            }

            $con_data["form_ad_offset_radio"][$search_line]         = $sub_data[$s][38];    //�����껦�ե饰
            $con_data["form_ad_offset_amount"][$search_line]        = $sub_data[$s][39];    //�����껦��

            #2009-09-26 hashimoto-y
            $con_data["hdn_discount_flg"][$search_line]             = $sub_data[$s][40];    //�Ͱ����ե饰

            $sub_data[$s][27] = $sale_d_id;
            //$arr_sale_d_id[$search_line] = $sale_d_id;

            /****************************/
            //�����ơ��֥�
            /****************************/
/*
            $sql  = "SELECT ";
            $sql .= "    aord_d_id, ";                //�����ǡ���ID
            $sql .= "    line ";                      //�Կ�
            $sql .= "FROM ";
            $sql .= "    t_aorder_d ";
            $sql .= "WHERE ";
            $sql .= "    aord_d_id = ".$sub_data[$s][27].";";
            $result = Db_Query($db_con, $sql);
            $id_data = Get_Data($result);
*/
/*
            //����ID�˳�������������ƥǡ�����¸�ߤ��뤫
            //for($c=0;$c<count($id_data);$c++){
            $sql  = "SELECT ";
            $sql .= "    t_sale_detail.line,";          //��0
            $sql .= "    t_sale_detail.goods_id,";      //����ID1
            $sql .= "    t_sale_detail.goods_cd,";      //����CD2
            $sql .= "    t_goods.name_change,";           //��̾�ѹ�3
            $sql .= "    t_sale_detail.goods_name,";    //����̾4
            $sql .= "    t_sale_detail.num,";           //����5
            //�Ķȸ���Ƚ��
            //if($contract_div != '1' && $group_kind == 3){
            //    //�ƣ�¦����Ԥ������������
            //    $sql .= "    t_sale_detail.trust_trade_price,";  //�Ķȸ���(������)
            //}else{
            //    //�̾���ɼ
                $sql .= "    t_sale_detail.trade_price,";        //�Ķȸ���6
            //}
            $sql .= "    t_sale_detail.sale_price,";    //���ñ��7
            //�Ķȶ��Ƚ��
            //if($contract_div != '1' && $group_kind == 3){
            //    //�ƣ�¦����Ԥ������������
            //    $sql .= "    t_sale_detail.trust_trade_amount,"; //�Ķȶ��(������)
            //}else{
            //    //�̾���ɼ
                $sql .= "    t_sale_detail.trade_amount,";       //�Ķȶ��8
            //}
            $sql .= "    t_sale_detail.sale_amount ";   //�����9
            $sql .= "FROM ";
            $sql .= "    t_sale_detail ";
            $sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_sale_detail.goods_id ";
            $sql .= "WHERE ";
            $sql .= "    t_sale_detail.sale_d_id = ".$sale_d_id.";";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                $arr_sale_d_id[$search_line] = $sale_d_id;
            }
            $detail_data = Get_Data($result, 2);

            //������Ͽ�ι��ֹ�
            //$search_row = $id_data[$c][1];
            $search_row = $search_line;

            //��������ID�˳�������ǡ�����¸�ߤ��뤫
            for($d=0;$d<count($detail_data);$d++){
                $search_line2 = $detail_data[$d][0];                                  //���������
                $con_data["hdn_bgoods_id"][$search_row][$search_line2]      = $detail_data[$d][1]; //����ID
                $con_data["break_goods_cd"][$search_row][$search_line2]     = $detail_data[$d][2]; //����CD
                $con_data["hdn_bname_change"][$search_row][$search_line2]   = $detail_data[$d][3]; //��̾�ѹ�
                $con_data["break_goods_name"][$search_row][$search_line2]   = $detail_data[$d][4]; //����̾
                $con_data["break_goods_num"][$search_row][$search_line2]    = $detail_data[$d][5]; //����

                $t_price = explode('.', $detail_data[$d][6]);
                $con_data["break_trade_price"][$search_row][$search_line2]["1"] = $t_price[0];     //�Ķȸ���
                $con_data["break_trade_price"][$search_row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : ($t_price[0] != null)? '00' : '';

                $s_price = explode('.', $detail_data[$d][7]);
                $con_data["break_sale_price"][$search_row][$search_line2]["1"] = $s_price[0];     //���ñ��
                $con_data["break_sale_price"][$search_row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';

                $con_data["break_trade_amount"][$search_row][$search_line2] = number_format($detail_data[$d][8]); //�Ķȶ��
                $con_data["break_sale_amount"][$search_row][$search_line2]  = number_format($detail_data[$d][9]); //�����
            }
//    }
*/

            //��������ID��hidden�ˤ���ݻ�����
            $contract_id = $sub_data[$s][28];
            if($contract_id != NULL){
                $con_data2["hdn_contract_id"] = $contract_id;
                
            }else{
                $contract_id = $_POST["hdn_contract_id"];
            }
        }

        //�ǡ�����̵�����¶�ʬ�ν��������
        for($a=1;$a<=5;$a++){
            if(!in_array($a,$aprice_array)) {
                //�ʤ�
                $con_data["form_aprice_div[$a]"] = 1;
                $con_data["form_ad_offset_radio[$a]"] = 1;
            }
        }


        $form->setDefaults($con_data);

    }


    /****************************/
    //���ʥ���������
    /****************************/
    if($_POST["goods_search_row"] != null){

        //���ʥ����ɼ��̾���
        $row_data = $_POST["goods_search_row"];
        //���ʥǡ�������������
        $search_row = substr($row_data,0,1);
        //���ʥǡ��������������
        $search_line = substr($row_data,1,1);

        //�̾ﾦ�ʡ������ʤλҼ���SQL
        $sql  = " SELECT";
        $sql .= "     t_goods.goods_id,";                      //����ID
        $sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰
        $sql .= "     t_goods.goods_cd,";                      //���ʥ�����
        $sql .= "     t_goods.goods_cname,";                   //ά��
        $sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ��
        $sql .= "     sale_price.r_price AS sale_price, ";     //���ñ��
        $sql .= "     t_goods.compose_flg, ";                  //�����ʥե饰
        $sql .= "     CASE \n";
        $sql .= "         WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
        $sql .= "         ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
        #2009-09-26 hashimoto-y
        #$sql .= "     END \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
        $sql .= "     END, \n";                                 //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
        $sql .= "     t_goods.discount_flg \n";                //�Ͱ��ե饰

        $sql .= " FROM";
        $sql .= "     t_goods ";
        $sql .= "     LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";

        $sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
        $sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

        $sql .= " WHERE";
        $sql .= "     t_goods.goods_cd = '".$_POST["form_goods_cd".$search_line][$search_row]."' ";
        $sql .= " AND ";
        $sql .= "     t_goods.compose_flg = 'f' ";
        $sql .= " AND ";
        $sql .= "     initial_cost.rank_cd = '2' ";
        $sql .= " AND ";
        $sql .= "     sale_price.rank_cd = '4'";
        $sql .= " AND ";
    //watanabe-k �ѹ�
        $sql .= "     t_goods.accept_flg = '1'";
        $sql .= " AND";
        //ľ��Ƚ��
        if($_SESSION["group_kind"] == "2"){
            //ľ��
            $sql .= "     t_goods.state IN (1,3)";
        }else{
            //FC
            $sql .= "     t_goods.state = 1";
        }
        $sql .= " AND";

        //ľ��Ƚ��
        if($_SESSION["group_kind"] == "2"){
            //ľ��
            $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
        }else{
            //FC
            $sql .= "     initial_cost.shop_id = $client_h_id  \n";
        }
        $sql .= " AND  \n";
        //ľ��Ƚ��
        if($_SESSION[group_kind] == "2"){
            //ľ��
            $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")) \n";
        }else{
            //FC
            $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id) \n";
        }

        //���ξ��ʰʳ��Ϲ����ʥǡ��������
        if($search_line != 2){
            //�����ʤοƼ���SQL
            $sql .= "UNION ";
            $sql .= " SELECT";
            $sql .= "     t_goods.goods_id,";                      //����ID
            $sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰
            $sql .= "     t_goods.goods_cd,";                      //���ʥ�����
            $sql .= "     t_goods.goods_cname,";                   //ά��
            $sql .= "     NULL,";
            $sql .= "     NULL,";
            $sql .= "     t_goods.compose_flg, ";                  //�����ʥե饰
            $sql .= "     CASE \n";
            $sql .= "         WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
            $sql .= "         ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
            #2009-09-26 hashimoto-y
            #$sql .= "     END \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
            $sql .= "     END, \n";                    //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
            $sql .= "     NULL ";
            $sql .= " FROM";
            $sql .= "     t_goods ";
            $sql .= "     LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
            $sql .= " WHERE";
            $sql .= "     t_goods.goods_cd = '".$_POST["form_goods_cd".$search_line][$search_row]."' ";
            $sql .= " AND ";
            $sql .= "     t_goods.compose_flg = 't' ";
    //watanabe-k���ѹ�
            $sql .= " AND ";
            $sql .= "     t_goods.accept_flg = '1'";
            $sql .= " AND ";
            //ľ��Ƚ��
            if($_SESSION["group_kind"] == "2"){
                //ľ��
                $sql .= "     t_goods.state IN (1,3)";
            }else{
                //FC
                $sql .= "     t_goods.state = 1";
            }

        }

        $result = Db_Query($db_con, $sql.";");
        $data_num = pg_num_rows($result);
        //�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
        if($data_num == 1){
            $goods_data = pg_fetch_array($result);

            $con_data2["hdn_goods_id".$search_line][$search_row]         = $goods_data[0];   //����ID

            $con_data2["hdn_name_change".$search_line][$search_row]      = $goods_data[1];   //��̾�ѹ��ե饰
            $hdn_name_change[$search_line][$search_row]                  = $goods_data[1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���
            $_POST["hdn_name_change".$search_line][$search_row]          = $goods_data[1];   //�����ѹ�����hidden��Ƚ�ꤷ�ʤ�����

            $con_data2["form_goods_cd".$search_line][$search_row]        = $goods_data[2];   //����CD
            $con_data2["form_goods_name".$search_line][$search_row]      = $goods_data[3];   //����̾��ά�Ρ�

            //�����ܤξ��ʤ����׻�����
            if($search_line == 1){

                #2009-09-26 hashimoto-y
                $con_data2["hdn_discount_flg"][$search_row]          = $goods_data[8];   //�Ͱ����ե饰

                //������Ƚ��
                if($goods_data[6] == 'f'){
                    //�����ʤǤϤʤ�

                    //����ñ�����������Ⱦ�������ʬ����
                    $cost_price = explode('.', $goods_data[4]);
                    $con_data2["form_trade_price"][$search_row]["1"] = $cost_price[0];  //�Ķ�ñ��
                    $con_data2["form_trade_price"][$search_row]["2"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

                    //���ñ�����������Ⱦ�������ʬ����
                    $sale_price = explode('.', $goods_data[5]);
                    $con_data2["form_sale_price"][$search_row]["1"] = $sale_price[0];  //���ñ��
                    $con_data2["form_sale_price"][$search_row]["2"] = ($sale_price[1] != null)? $sale_price[1] : '00';

                    //��۷׻�����Ƚ��
                    if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] != null){
                    //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($goods_data[4], $_POST["form_goods_num1"][$search_row],2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($goods_data[5], 1,2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    
                        $con_data2["form_trade_amount"][$search_row]    = number_format($cost_amount);
                        $con_data2["form_sale_amount"][$search_row]     = number_format($sale_amount);
                    //�켰�������̡ߤξ�硢ñ���ߣ�
                    }else if($_POST["form_goods_num1"][$search_row] == null && $_POST["form_issiki"][$search_row] != null){
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($goods_data[4],1,2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($goods_data[5],1,2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    
                        $con_data2["form_trade_amount"][$search_row]    = number_format($cost_amount);
                        $con_data2["form_sale_amount"][$search_row]     = number_format($sale_amount);
                    //�켰�ߡ����̡��ξ�硢ñ���߿���
                    }else if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] == null){
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($goods_data[4], $_POST["form_goods_num1"][$search_row],2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($goods_data[5], $_POST["form_goods_num1"][$search_row],2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    
                        $con_data2["form_trade_amount"][$search_row]    = number_format($cost_amount);
                        $con_data2["form_sale_amount"][$search_row]     = number_format($sale_amount);
                    }
                }else{
                    //������

                    //�����ʤλҤξ��ʾ������
                    $sql  = "SELECT ";
                    $sql .= "    parts_goods_id ";                       //������ID
                    $sql .= "FROM ";
                    $sql .= "    t_compose ";
                    $sql .= "WHERE ";
                    $sql .= "    goods_id = ".$goods_data[0].";";
                    $result = Db_Query($db_con, $sql);
                    $goods_parts = Get_Data($result);

                    //�ƹ����ʤ�ñ������
                    $com_c_price = 0;     //�����ʿƤαĶȸ���
                    $com_s_price = 0;     //�����ʿƤ����ñ��

                    for($i=0;$i<count($goods_parts);$i++){
                        $sql  = " SELECT ";
                        $sql .= "     t_compose.count,";                       //����
                        $sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ��
                        $sql .= "     sale_price.r_price AS sale_price  ";     //���ñ��
                                         
                        $sql .= " FROM";
                        $sql .= "     t_compose ";

                        $sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                        $sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
                        $sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

                        $sql .= " WHERE";
                        $sql .= "     t_compose.goods_id = ".$goods_data[0];
                        $sql .= " AND ";
                        $sql .= "     t_compose.parts_goods_id = ".$goods_parts[$i][0];
                        $sql .= " AND ";
                        $sql .= "     initial_cost.rank_cd = '2' ";
                        $sql .= " AND ";
                        $sql .= "     sale_price.rank_cd = '4'";
                        $sql .= " AND ";
                        //ľ��Ƚ��
                        if($_SESSION["group_kind"] == "2"){
                            //ľ��
                            $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
                        }else{
                            //FC
                            $sql .= "     initial_cost.shop_id = $client_h_id  \n";
                        }
                        $sql .= " AND  \n";
                        //ľ��Ƚ��
                        if($_SESSION["group_kind"] == "2"){
                            //ľ��
                            $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")); \n";
                        }else{
                            //FC
                            $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id); \n";
                        }
                        $result = Db_Query($db_con, $sql);
                        $com_data = Get_Data($result);
                        //�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ���Ƚ��
                        if($com_data == NULL){
                            $reset_goods_flg = true;   //���Ϥ��줿���ʾ���򥯥ꥢ
                        }

                        //�����ʿƤαĶ�ñ���׻�������ɲ�(�Ҥο��̡߻ҤαĶȸ���)
                        $com_cp_amount = bcmul($com_data[0][0],$com_data[0][1],2);
                        $com_cp_amount = Coax_Col($coax, $com_cp_amount);
                        $com_c_price = $com_c_price + $com_cp_amount;
                        //�����ʿƤ����ñ���׻�������ɲ�(�Ҥο��̡߻Ҥ����ñ��)
                        $com_sp_amount = bcmul($com_data[0][0],$com_data[0][2],2);
                        $com_sp_amount = Coax_Col($coax, $com_sp_amount);
                        $com_s_price = $com_s_price + $com_sp_amount;
                    }

                    //����ñ�����������Ⱦ�������ʬ����
                    $com_cost_price = explode('.', $com_c_price);
                    $con_data2["form_trade_price"][$search_row]["1"] = $com_cost_price[0];  //�Ķ�ñ��
                    $con_data2["form_trade_price"][$search_row]["2"] = ($com_cost_price[1] != null)? $com_cost_price[1] : '00';     

                    //���ñ�����������Ⱦ�������ʬ����
                    $com_sale_price = explode('.', $com_s_price);
                    $con_data2["form_sale_price"][$search_row]["1"] = $com_sale_price[0];  //���ñ��
                    $con_data2["form_sale_price"][$search_row]["2"] = ($com_sale_price[1] != null)? $com_sale_price[1] : '00';

                    //�����ʿƤζ�۷׻�����Ƚ��
                    if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] != null){
                    //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($com_c_price, $_POST["form_goods_num1"][$search_row],2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($com_s_price, 1,2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    //�켰�������̡ߤξ�硢ñ���ߣ�
                    }else if($_POST["form_goods_num1"][$search_row] == null && $_POST["form_issiki"][$search_row] != null){
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($com_c_price,1,2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($com_s_price,1,2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    //�켰�ߡ����̡��ξ�硢ñ���߿���
                    }else if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] == null){
                        //�Ķȶ�۷׻�
                        $cost_amount = bcmul($com_c_price, $_POST["form_goods_num1"][$search_row],2);
                        $cost_amount = Coax_Col($coax, $cost_amount);
                        //����۷׻�
                        $sale_amount = bcmul($com_s_price, $_POST["form_goods_num1"][$search_row],2);
                        $sale_amount = Coax_Col($coax, $sale_amount);
                    }
                    $con_data2["form_trade_amount"][$search_row]    = number_format($cost_amount);
                    $con_data2["form_sale_amount"][$search_row]     = number_format($sale_amount);
                }
                $con_data2["official_goods_name"][$search_row]  = $goods_data[7];   //����̾��������

            }else{
                //�󡦻����ܤξ���
                
                //�����ʤλҤξ��ʾ������
                $sql  = "SELECT ";
                $sql .= "    parts_goods_id ";                       //������ID
                $sql .= "FROM ";
                $sql .= "    t_compose ";
                $sql .= "WHERE ";
                $sql .= "    goods_id = ".$goods_data[0].";";
                $result = Db_Query($db_con, $sql);
                $goods_parts = Get_Data($result);

                for($i=0;$i<count($goods_parts);$i++){
                    $sql  = " SELECT ";
                    $sql .= "     t_compose.count,";                       //����
                    $sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ��
                    $sql .= "     sale_price.r_price AS sale_price  ";     //���ñ��
                                     
                    $sql .= " FROM";
                    $sql .= "     t_compose ";

                    $sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                    $sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
                    $sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

                    $sql .= " WHERE";
                    $sql .= "     t_compose.goods_id = ".$goods_data[0];
                    $sql .= " AND ";
                    $sql .= "     t_compose.parts_goods_id = ".$goods_parts[$i][0];
                    $sql .= " AND ";
                    $sql .= "     initial_cost.rank_cd = '2' ";
                    $sql .= " AND ";
                    $sql .= "     sale_price.rank_cd = '4'";
                    $sql .= " AND ";
                    //ľ��Ƚ��
                    if($_SESSION[group_kind] == "2"){
                        //ľ��
                        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
                    }else{
                        //FC
                        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
                    }
                    $sql .= " AND  \n";
                    //ľ��Ƚ��
                    if($_SESSION["group_kind"] == "2"){
                        //ľ��
                        $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")); \n";
                        }else{
                            //FC
                            $sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id); \n";
                    }
                    $result = Db_Query($db_con, $sql);
                    $com_data = Get_Data($result);
                    //�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ���Ƚ��
                    if($com_data == NULL){
                        $reset_goods_flg = true;   //���Ϥ��줿���ʾ���򥯥ꥢ
                    }
                }
            }
            
            //�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��Ȥ������ʾ��󥯥ꥢ
            if($reset_goods_flg == true){
                //�ǡ�����̵�����ϡ������
                $con_data2["hdn_goods_id".$search_line][$search_row]         = "";
                $con_data2["hdn_name_change".$search_line][$search_row]      = "";
                $con_data2["form_goods_cd".$search_line][$search_row]        = "";
                $con_data2["form_goods_name".$search_line][$search_row]      = "";
                $con_data2["form_goods_num".$search_line][$search_row]       = "";

                //�����λ�ɸ
                $sline = $search_line+1;
                $con_data2["form_print_flg".$sline][$search_row]      = "";

                //��۽�����ϡ������ƥ���ξ��Τ�
                if($search_line == 1){
                    $con_data2["form_trade_price"][$search_row]["1"] = "";
                    $con_data2["form_trade_price"][$search_row]["2"] = "";
                    $con_data2["form_trade_amount"][$search_row]     = "";
                    $con_data2["form_sale_price"][$search_row]["1"] = "";
                    $con_data2["form_sale_price"][$search_row]["2"] = "";
                    $con_data2["form_sale_amount"][$search_row]     = "";

                    $con_data2["official_goods_name"][$search_row]  = "";
                }
            }
        }else{
            //�ǡ�����̵�����ϡ������
            $con_data2["hdn_goods_id".$search_line][$search_row]         = "";
            $con_data2["hdn_name_change".$search_line][$search_row]      = "";
            $con_data2["form_goods_cd".$search_line][$search_row]        = "";
            $con_data2["form_goods_name".$search_line][$search_row]      = "";
            $con_data2["form_goods_num".$search_line][$search_row]       = "";

            //�����λ�ɸ
            $sline = $search_line+1;
            $con_data2["form_print_flg".$sline][$search_row]      = "";

            //��۽�����ϡ������ƥ���ξ��Τ�
            if($search_line == 1){
                $con_data2["form_trade_price"][$search_row]["1"] = "";
                $con_data2["form_trade_price"][$search_row]["2"] = "";
                $con_data2["form_trade_amount"][$search_row]     = "";
                $con_data2["form_sale_price"][$search_row]["1"] = "";
                $con_data2["form_sale_price"][$search_row]["2"] = "";
                $con_data2["form_sale_amount"][$search_row]     = "";

                $con_data2["official_goods_name"][$search_row]  = "";
            }
            #2009-09-26 hashimoto-y
            $con_data2["hdn_discount_flg"][$search_row]  = "";
        }
        $con_data2["goods_search_row"]                  = "";

    }


    /****************************/
    //���ꥢ�ܥ��󡢥��ꥢ��󥯲�������
    /****************************/
    //if($_POST["clear_flg"] == true){
    if($_POST["clear_flg"] == true || $_POST["clear_line"] != ""){

        if($_POST["clear_line"] != ""){
            $min = $_POST["clear_line"];
            $max = $_POST["clear_line"];
        }else{
            $min = 1;
            $max = 5;
        }

        //����������ƽ����
        for($c=$min;$c<=$max;$c++){

            for($f=1;$f<=3;$f++){
                $con_data2["form_print_flg".$f][$c]      = "";
                $con_data2["hdn_goods_id".$f][$c]        = "";
                $con_data2["hdn_name_change".$f][$c]     = "";
                $con_data2["form_goods_cd".$f][$c]       = "";
                $con_data2["form_goods_name".$f][$c]     = "";
                $con_data2["form_goods_num".$f][$c]      = "";
            }
            $con_data2["form_serv"][$c]             = "";
            $con_data2["form_divide"][$c]           = "";
            $con_data2["form_issiki"][$c]           = "";
            $con_data2["official_goods_name"][$c]   = "";
            $con_data2["form_trade_price"][$c]["1"] = "";
            $con_data2["form_trade_price"][$c]["2"] = "";
            $con_data2["form_trade_amount"][$c]     = "";
            $con_data2["form_sale_price"][$c]["1"]  = "";
            $con_data2["form_sale_price"][$c]["2"]  = "";
            $con_data2["form_sale_amount"][$c]      = "";
            $con_data2["form_account_price"][$c]    = "";
            $con_data2["form_account_rate"][$c]     = "";
            $con_data2["form_aprice_div[$c]"]       = 1;
            $con_data2["form_ad_offset_radio[$c]"]  = 1;
            $con_data2["form_ad_offset_amount[$c]"] = "";

            #2009-09-26 hashimoto-y
            $con_data2["hdn_discount_flg"][$c]             = "";

/*
            for($j=1;$j<=5;$j++){
                $con_data2["break_goods_cd"][$c][$j] = "";
                $con_data2["break_goods_name"][$c][$j] = "";
                $con_data2["break_goods_num"][$c][$j] = "";
                $con_data2["hdn_bgoods_id"][$c][$j] = "";
                $con_data2["hdn_bname_change"][$c][$j] = "";
                $con_data2["break_trade_price"][$c][$j][1] = "";
                $con_data2["break_trade_price"][$c][$j][2] = "";
                $con_data2["break_trade_amount"][$c][$j] = "";
                $con_data2["break_sale_price"][$c][$j][1] = "";
                $con_data2["break_sale_price"][$c][$j][2] = "";
                $con_data2["break_sale_amount"][$c][$j] = "";
            }
*/
        }
        
        $post_flg2 = true;               //���¶�ʬ�򡢽��������ե饰
        $con_data2["clear_flg"] = "";    //���ꥢ�ܥ��󲡲��ե饰
        $con_data2["clear_line"] = "";   //���ꥢ��󥯹��ֹ�
    }



    /****************************/
    // �ե�����ѡ������
    /****************************/

    #2009-09-26 hashimoto-y
    #plan_data.inc�����ǡ��������Υե饰���Ϥ�
    $plan_edit_flg = 't';
    $plan_edit_goods_data = $con_data2;


    //�����ޥ���������(���ե���������)
    require_once(INCLUDE_DIR."plan_data.inc");

    //if($flg == 'add'){

    //�ܵ�̾
    $form_client[] =& $form->createElement(
                "text","cd1","",
                "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
                 onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\"
                 onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
                );
    $form_client[] =& $form->createElement("static","","","-");
    $form_client[] =& $form->createElement(
                "text","cd2","",
                "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
                 onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
                );
    $form_client[] =& $form->createElement(
                "text","name","",
                "size=\"34\" $g_text_readonly"
                );
    $freeze_form_client = $form->addGroup($form_client, "form_client", "");
    $freeze_form_client->freeze();


    //��Ͽ�ܥ���
    $form->addElement("button","entry_button","�С�Ͽ","onClick=\"return Dialogue_2('��Ͽ���ޤ���','".$_SERVER["PHP_SELF"]."',true,'entry_flg');\" $disabled");

    //���ܥ���
    if($renew_flg){
        $form->addElement("button","form_back_btn","�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("sale")."'\"");
    }else{
        $form->addElement("button","form_back_btn","�ᡡ��", "onClick=\"location.href='2-2-207.php?search=1'\"");
    }

    //�ϣ˥ܥ���
    $form->addElement("button","form_ok_btn","�ϡ���", "onClick=\"location.href='2-2-207.php?search=1'\"");


    //ľ��¦�������ɼ�ξ�硢��ԼԤ�ɽ��
    if($group_kind == "2" && $contract_div != "1"){
        $form->addElement("text", "form_act_cd");
        $form->addElement("text", "form_act_name");
        $form->addElement("text", "form_act_price");

        $freeze_data = array("form_act_cd", "form_act_name", "form_act_price");
        $form->freeze($freeze_data);
    }


    /****************************/
    //hidden��ͽ���������������
    /****************************/

    //hidden
    $form->addElement("hidden", "hdn_sale_id");           //���ID
    $form->addElement("hidden", "entry_flg");           //��Ͽ�ܥ��󲡲��ե饰
    //$form->addElement("hidden", "client_search_flg");   //�����踡���ե饰

    //$form->addElement("hidden", "hdn_page_title", $page_title); //�ڡ��������ȥ�

    $form->addElement("hidden", "form_ac_id");           //�Ҳ��ID
    $form->addElement("hidden", "hdn_h_intro_ac_price");           //�Ҳ�����ñ���ˡʥإå���
    $form->addElement("hidden", "hdn_h_intro_ac_rate");           //�Ҳ�����Ψ�ˡʥإå���


    /****************************/
    //������ξ�������
    /****************************/
    $sql  = "SELECT";
    $sql .= "   t_client.coax, ";
    $sql .= "   t_client.trade_id,";
    $sql .= "   t_client.tax_franct,";
    $sql .= "   t_client.slip_out ";
    //$sql .= "   t_client.intro_ac_price,";
    //$sql .= "   t_client.intro_ac_rate ";
    $sql .= " FROM";
    $sql .= "   t_client ";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql); 
    Get_Id_Check($result);
    $data_list = Get_Data($result);

    $coax           = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�
    //$trade_id       = $data_list[0][1];        //���������
    $tax_franct     = $data_list[0][2];        //�����ǡ�ü����ʬ��
    //$slip_out       = $data_list[0][3];        //��ɼ����
    //$intro_ac_price = $data_list[0][4];        //�Ҳ������
    //$intro_ac_rate  = $data_list[0][5];        //�Ҳ����Ψ


    /****************************/
    //��������桼�������������
    /****************************/
    $sql  = "SELECT";
    $sql .= "   t_ware.ware_name,";
    $sql .= "   t_ware.ware_id,";
    #2009-12-22 aoyama-n
    #$sql .= "   t_client.tax_rate_n,";
    $sql .= "   NULL,";
    $sql .= "   t_client.rank_cd ";
    $sql .= " FROM";
    $sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_h_id";
    $sql .= ";";
    //echo "��������桼�����������$sql<br>";
    $result = Db_Query($db_con, $sql); 
    Get_Id_Check($result);
    $data_list = Get_Data($result);

    //$ware_name      = $data_list[0][0];        //���ʽв��Ҹ�̾
    //$ware_id        = $data_list[0][1];        //�в��Ҹ�ID
    #2009-12-22 aoyama-n
    #$tax_num        = $data_list[0][2];        //������(����)
    $rank_cd        = $data_list[0][3];        //�ܵҶ�ʬCD



    /****************************/
    //�����⽸�ץܥ��󲡲�����
    /****************************/
    //if($_POST["ad_sum_button_flg"] == true || $_POST["correction_flg"] == "true"){
    if($_POST["ad_sum_button_flg"] == true || $_POST["correction_flg"] == "true" || $_POST["entry_flg"] == true || $_POST["warn_ad_flg"] != null){

        //������
        //��ɬ�ܥ����å�
        //$form->addGroupRule("form_delivery_day", $h_mess[26], "required");
        $form->addGroupRule("form_delivery_day", array(
            "y" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
            "m" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
            "d" => array(array("ͽ������ �����Ϥ��Ƥ���������", "required")),
        ));
        //���ͥ����å�
        $form->addGroupRule("form_delivery_day", array(
            "y" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
            "m" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
            "d" => array(array($h_mess[35], "regex", "/^[0-9]+$/")),
        ));

        if($form->validate()){
            //�����������å�
            if(!checkdate((int)$_POST["form_delivery_day"]["m"], (int)$_POST["form_delivery_day"]["d"], (int)$_POST["form_delivery_day"]["y"])){
                $form->setElementError("form_delivery_day", $h_mess[35]);
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
    //POST�ǡ������������顼�����å�(addRule)�ʤ�
    /****************************/
    require_once(INCLUDE_DIR."fc_sale_post_bfr.inc");


    /****************************/
    //��Ͽ�ܥ��󲡲�
    /****************************/
    if($_POST["entry_flg"] == true || $_POST["warn_ad_flg"] != null){

        //�Ҳ����ID�Ȥ��μ�����ʬ�����
        if($_POST["form_ac_id"] != null){
            $sql  = "SELECT \n";
            $sql .= "    client_div \n";
            $sql .= "FROM \n";
            $sql .= "    t_client \n";
            $sql .= "WHERE \n";
            $sql .= "    client_id = ".$_POST["form_ac_id"]." \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            $intro_account_id = $_POST["form_ac_id"];                       //�Ҳ������ID
            $intro_client_div = pg_fetch_result($result, 0, "client_div");  //�Ҳ������μ�����ʬ
        }else{
            $intro_account_id = null;       //�Ҳ������ID
            $intro_client_div = null;       //�Ҳ������μ�����ʬ
        }


        //������client_id�����
        $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
        $result = Db_Query($db_con, $sql);
        $head_id = pg_fetch_result($result, 0, "client_id");        //������client_id


        /****************************/
        //���顼�����å�(PHP)��������Ƚ��ؿ��ʤ�
        /****************************/
        require_once(INCLUDE_DIR."fc_sale_post_atr.inc");


        //������ʼ�áˤ���Ƥ��ʤ���硢�����ǾҲ����λ�����������������Ƥ��ʤ��������å�
        if($error_msg14 == null){
            //ľ�Ĥξ�硢�Ҳ���������������������������Ƥ���ȥ��顼
            if($intro_account_id != null && $group_kind == "2"){
                $sql = "SELECT renew_flg FROM t_buy_h WHERE intro_sale_id = $sale_id;";
                $result = Db_Query($db_con, $sql);
                if(pg_num_rows($result) != 0){
                    if(pg_fetch_result($result, 0, 0) == "t"){
                        $error_flg = true;
                        $buy_err_mess = "�Ҳ������";

                        //OK�ܥ���
                        $form->addElement("button","disp_btn","�ϡ���", "onClick=\"location.href='2-2-207.php?search=1'\"");
                    }
                }
            }
        }


        $con_data2["entry_flg"] = "";   //��Ͽ�ܥ��󲡲��ե饰�����


        #2009-09-26 hashimoto-y
        //���Ͱ�����������μ����ʬ�����å����Ͱ������ʤϻ����Բġ�
        #$trade_sale = $_POST["trade_aord"];
        #if(($trade_sale == '13' || $trade_sale == '14' || $trade_sale == '63' || $trade_sale == '64') && (in_array('t', $_POST[hdn_discount_flg]))){
        #    $form->setElementError("trade_sale_select", $h_mess[79]);
        #}


        //���Ƕ�ʬ������ñ��
        for($i=1,$goods_item_tax_div=array();$i<=5;$i++){
            if($serv_id[$i] == null && $goods_item_id[$i] == null){
                //�����ӥ��������ƥ�ξ���ʤ�����null
                //$goods_item_tax_div[$i] = null;
            }elseif($goods_item_id[$i] != null){
                //�����ƥब������ϥ����ƥ�β��Ƕ�ʬ
                $sql = "SELECT tax_div FROM t_goods WHERE goods_id = ".$goods_item_id[$i].";";
                $result = Db_Query($db_con, $sql);
                $goods_item_tax_div[$i] = pg_fetch_result($result, 0, 0);
            }else{
                //�����ӥ������ξ��ϥ����ӥ��β��Ƕ�ʬ
                $sql = "SELECT tax_div FROM t_serv WHERE serv_id = ".$serv_id[$i].";";
                $result = Db_Query($db_con, $sql);
                $goods_item_tax_div[$i] = pg_fetch_result($result, 0, 0);
            }
        }


        //�Ķȶ�ۤ�����ͤ�ľ��
        $i=0;
        foreach($trade_amount as $value){
            $trade_amount2[$i] = $value;
            $i++;
        }

        //����ۤ�����ͤ�ľ��
        $i=0;
        foreach($sale_amount as $value){
            $sale_amount2[$i] = $value;
            $i++;
        }

        //���Ƕ�ʬ������ͤ�ľ��
        $i=0;
        foreach($goods_item_tax_div as $value){
            $goods_item_tax_div2[$i] = $value;
            $i++;
        }

        #2009-12-22 aoyama-n
        $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
        $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

        //�Ķȶ�ۤι�׽���
        $total_money = Total_Amount($trade_amount2, $goods_item_tax_div2, $coax, $tax_franct, $tax_num, $client_id, $db_con);
        $cost_money  = $total_money[0];

        //����ۡ������ǳۤι�׽���
        $total_money = Total_Amount($sale_amount2, $goods_item_tax_div2, $coax, $tax_franct, $tax_num, $client_id, $db_con);
        $sale_money  = $total_money[0];
        $sale_tax    = $total_money[1];


        //������ۤΥ����å�
        if($ad_offset_flg){

            //��ɼ��ס��ǹ��ˤ�������껦�۹�פ��礭����硢�ٹ��ɽ��
            if(($sale_money + $sale_tax) < $ad_offset_total_amount && $_POST["warn_ad_flg"] == null){
                $ad_total_warn_mess = $h_mess[78];

                // ̵���ѥܥ���
                $form->addElement("button", "form_ad_warn", "�ٹ��̵�뤷������",
                    "onClick=\"javascript:Button_Submit('warn_ad_flg', '".$_SERVER["REQUEST_URI"]."', true);\" $disabled"
                );
                $form->addElement("hidden", "warn_ad_flg");

            }

            //�ֳ����פξ��
            if($trade_aord == "11"){
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
        if($error_flg == false && $ad_total_warn_mess == null){

            Db_Query($db_con, "BEGIN;");


            //���إå�����
            $sql  = "UPDATE \n";
            $sql .= "    t_sale_h \n";
            $sql .= "SET \n";
            $sql .= "    sale_day = '$delivery_day', \n";
            $sql .= "    claim_day = '$request_day', \n";
            $sql .= "    trade_id = $trade_aord, \n";
            $sql .= "    claim_id= $claim_id, \n";
            $sql .= "    claim_div = '$claim_div', \n";
            $sql .= "    cost_amount = $cost_money, \n";
            $sql .= "    net_amount = $sale_money, \n";
            $sql .= "    tax_amount = $sale_tax, \n";
            $sql .= "    note = '$note', \n";
            $sql .= "    reason_cor = '$reason', \n";
            $sql .= "    route = $route, \n";
            if($ad_offset_flg == true){                     //�����껦�۹��
                $sql .= "    advance_offset_totalamount = $ad_offset_total_amount, ";
            }else{
                $sql .= "    advance_offset_totalamount = null, ";
            }
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
                $sql .= "    d_fax = (SELECT fax FROM t_direct WHERE direct_id = $direct_id) ";
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
                $sql .= "    d_fax = null ";
            }

            $sql .= "WHERE \n";
            $sql .= "    sale_id = $sale_id \n";
            $sql .= ";\n";
/*
echo "���إå�";
print_array($sql);
*/

            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }


            //�����ô���ԥơ��֥���
            $sql = "DELETE FROM t_sale_staff WHERE sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //���ǡ����ơ��֥���
            //  ������������и��ʡ��߸˼�ʧ������γƥơ��֥��������ޤ�
            $sql = "DELETE FROM t_sale_d WHERE sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //�������ơ��֥���
            $sql = "DELETE FROM t_installment_sales WHERE sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //����ơ��֥���
            $sql = "DELETE FROM t_payin_h WHERE sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }

            //�����ơ��֥����ʾҲ�����
            $sql = "DELETE FROM t_buy_h WHERE intro_sale_id = $sale_id;";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                $result = Db_Query($db_con, "ROLLBACK;");
                exit();
            }


            /****************************/
            //���ô���ԥơ��֥���Ͽ
            /****************************/
            //�����ʬ���̾�or�ƣäΤ���Ͽ
            for($c=0;$c<=3;$c++){
                //�����åդ����ꤵ��Ƥ��뤫Ƚ��
                if($staff_check[$c] != NULL){
                    //������
                    $sql = "SELECT staff_name FROM t_staff WHERE staff_id = ".$staff_check[$c].";";
                    $result = Db_Query($db_con, $sql);
                    $staff_data = Get_Data($result, 3);

                    $sql  = "INSERT INTO t_sale_staff ( ";
                    $sql .= "    sale_id, ";
                    $sql .= "    staff_div, ";
                    $sql .= "    staff_id, ";
                    $sql .= "    sale_rate, ";
                    $sql .= "    staff_name ";
                    $sql .= ") VALUES ( ";
                    $sql .= "    $sale_id, ";                   //���ID
                    $sql .= "    '$c', ";                       //���ô���Լ���
                    $sql .= "    ".$staff_check[$c].", ";       //���ô����ID
                    //���Ψ����Ƚ��
                    if($staff_rate[$c] != NULL){
                        $sql .= "    ".$staff_rate[$c].", ";    //���Ψ
                    }else{
                        $sql .= "    NULL, ";
                    }
                    $sql .= "    '".$staff_data[0][0]."' ";     //ô����̾
                    $sql .= ");";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }
            }


            //���ǡ�������Ͽ
            for($i=1;$i<=5;$i++){
                //�����ӥ��ޤ��ϥ����ƥब���ꤵ��Ƥ����硢���ǡ�������Ͽ
                if($serv_id[$i] != null || $goods_item_id[$i] != null){
                    //���ǡ���ID����
                    $microtime = NULL;
                    $microtime = explode(" ",microtime());
                    $sale_d_id = $microtime[1].substr("$microtime[0]", 2, 5);

                    $sql  = "INSERT INTO \n";
                    $sql .= "    t_sale_d \n";
                    $sql .= "( \n";
                    $sql .= "    sale_d_id, \n";
                    $sql .= "    sale_id, \n";
                    $sql .= "    sale_div_cd, \n";
                    if($serv_id[$i] != null){
                        $sql .= "    serv_print_flg, \n";
                        $sql .= "    serv_id, \n";
                        $sql .= "    serv_cd, \n";
                        $sql .= "    serv_name, \n";
                    }
                    $sql .= "    set_flg, \n";
                    if($goods_item_id[$i] != null){
                        $sql .= "    goods_print_flg, \n";
                        $sql .= "    goods_id, \n";
                        $sql .= "    goods_cd, \n";
                        $sql .= "    g_product_name, \n";
                        $sql .= "    official_goods_name, \n";
                        $sql .= "    goods_name, \n";
                        $sql .= "    unit, \n";
                    }
                    if($goods_item_num[$i] != null){
                        $sql .= "    num, \n";
                    }
                    $sql .= "    tax_div, \n";
                    $sql .= "    buy_price, \n";
                    $sql .= "    buy_amount, \n";
                    $sql .= "    cost_price, \n";
                    $sql .= "    sale_price, \n";
                    $sql .= "    cost_amount, \n";
                    $sql .= "    sale_amount, \n";
                    if($goods_body_id[$i] != null){
                        $sql .= "    rgoods_id, \n";
                        $sql .= "    rgoods_cd, \n";
                        $sql .= "    rgoods_name, \n";
                        $sql .= "    rgoods_num, \n";
                    }
                    if($goods_expend_id[$i] != null){
                        $sql .= "    egoods_id, \n";
                        $sql .= "    egoods_cd, \n";
                        $sql .= "    egoods_name, \n";
                        $sql .= "    egoods_num, \n";
                    }
                    $sql .= "    account_price, \n";
                    $sql .= "    account_rate, \n";
                    $sql .= "    advance_flg, \n";
                    $sql .= "    advance_offset_amount, \n";
                    $sql .= "    line \n";
                    $sql .= ") VALUES ( \n";
                    $sql .= "    $sale_d_id, \n";
                    $sql .= "    $sale_id, \n";
					# 2010-07-06 watanabe-k
                    $sql .= "    '$divide[$i]', \n";
                    if($serv_id[$i] != null){
                        $sql .= "    $slip_flg[$i], \n";
                        $sql .= "    $serv_id[$i], \n";
                        $sql .= "    (SELECT serv_cd FROM t_serv WHERE serv_id = $serv_id[$i]), \n";
                        $sql .= "    (SELECT serv_name FROM t_serv WHERE serv_id = $serv_id[$i]), \n";
                    }
                    $sql .= "    $set_flg[$i], \n";
                    if($goods_item_id[$i] != null){
                        $sql .= "    $goods_item_flg[$i], \n";
                        $sql .= "    $goods_item_id[$i], \n";
                        $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_item_id[$i]), \n";
                        $sql .= "    (SELECT g_product_name FROM t_g_product WHERE g_product_id = (SELECT g_product_id FROM t_goods WHERE goods_id = $goods_item_id[$i])), \n";
                        $sql .= "    '".$official_goods_name[$i]."', \n";
                        $sql .= "    '$goods_item_name[$i]', \n";
                        $sql .= "    (SELECT unit FROM t_goods WHERE goods_id = $goods_item_id[$i]), \n";
                    }
                    if($goods_item_num[$i] != null){
                        $sql .= "    $goods_item_num[$i], \n";
                    }
                    $sql .= "    $goods_item_tax_div[$i], \n";

                    //����ñ�������
                    //�����ƥब���Ϥ���Ƥ��硢�����ƥ�κ߸�ñ���������
                    if($goods_item_id[$i] != null){
                        $compose_flg_sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$i].";";
                        $result = Db_Query($db_con, $compose_flg_sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                        $compose_flg = pg_fetch_result($result, 0, "compose_flg");  //�����ʥե饰

                        //�����ʤξ�硢�Ҥ�ñ�����פ���
                        if($compose_flg == "t"){
                            $buy_price_arr = Compose_price($db_con, $shop_id, $goods_item_id[$i]);
                            $buy_price = $buy_price_arr[2];     //����ñ���ʺ߸�ñ����
                        //�����ʤ���ʤ���硢DB����ñ�������
                        }else{
                            $buy_price_sql  = "SELECT \n";
                            $buy_price_sql .= "    t_price.r_price \n";
                            $buy_price_sql .= "FROM \n";
                            $buy_price_sql .= "    t_price \n";
                            $buy_price_sql .= "WHERE \n";
                            $buy_price_sql .= "    t_price.goods_id = ".$goods_item_id[$i]." \n";
                            $buy_price_sql .= "    AND \n";
                            $buy_price_sql .= "    t_price.rank_cd = '3' \n";   //�߸�ñ��
                            $buy_price_sql .= "    AND \n";
                            if($group_kind == "2"){
                                $buy_price_sql .= "    t_price.shop_id IN (".Rank_Sql().") \n";
                            }else{
                                $buy_price_sql .= "    t_price.shop_id = $shop_id \n";
                            }
                            $buy_price_sql .= ";";
                            $result = Db_Query($db_con, $buy_price_sql);
                            if($result === false){
                                Db_Query($db_con, "ROLLBACK;");
                                exit;
                            }
                            $buy_price = pg_fetch_result($result, 0, 0);    //����ñ���ʺ߸�ñ����
                        }
                        if($goods_item_num[$i] != null){
                            $buy_amount = Coax_Col($coax, bcmul($buy_price, $goods_item_num[$i], 2));
                        }else{
                            $buy_amount = Coax_Col($coax, $buy_price);
                        }
                    //�����ƥब�ʤ���硢����ñ������פ����ñ������ۤ������
                    }else{
                        $buy_price = $trade_price[$i];
                        $buy_amount = $trade_amount[$i];
                    }

                    $sql .= "    $buy_price, \n";
                    $sql .= "    $buy_amount, \n";
                    $sql .= "    $trade_price[$i], \n";
                    $sql .= "    $sale_price[$i], \n";
                    $sql .= "    $trade_amount[$i], \n";
                    $sql .= "    $sale_amount[$i], \n";
                    if($goods_body_id[$i] != null){
                        $sql .= "    $goods_body_id[$i], \n";
                        $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_body_id[$i]), \n";
                        $sql .= "    '$goods_body_name[$i]', \n";
                        $sql .= "    $goods_body_num[$i], \n";
                    }
                    if($goods_expend_id[$i] != null){
                        $sql .= "    $goods_expend_id[$i], \n";
                        $sql .= "    (SELECT goods_cd FROM t_goods WHERE goods_id = $goods_expend_id[$i]), \n";
                        $sql .= "    '$goods_expend_name[$i]', \n";
                        $sql .= "    $goods_expend_num[$i], \n";
                    }
                    $sql .= "    $ac_price[$i], \n";
                    $sql .= "    '".$ac_rate[$i]."', \n";
                    $sql .= "    '".$ad_flg[$i]."', \n";
                    $sql .= ($ad_flg[$i] != "1") ? "    ".$ad_offset_amount[$i].", \n" : "    NULL, \n";
                    $sql .= "    $i \n";
                    $sql .= ") \n";
                    $sql .= ";\n";
/*
echo "���ǡ���SQL";
print_array($sql);
*/

                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }


                    /****************************/
                    //�и��ʥơ��֥���Ͽ
                    /****************************/

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
                                $sql .= "    $sale_d_id,";                     //�����ǡ���ID
                                $sql .= "    $ship,";                          //����ID
                                $sql .= "    '".$goods_ship_id[$ship][0]."',"; //����̾
                                $sql .= "    ".$goods_ship_id[$ship][1].",";   //����
                                $sql .= "    '".$ship_data[0][0]."'";          //����CD
                                $sql .= "    );";
                                $result = Db_Query($db_con, $sql);
/*
echo "�и���";
print_array($sql);
*/

                                if($result === false){
                                    Db_Query($db_con, "ROLLBACK;");
                                    exit;
                                }

                            }
                        }
                    }
                    //�и�����Ͽ��������
                    $goods_ship_id = NULL;
                }
            }


            //����ͽ��вٰ����Ǻ߸˰�ư�Ѥξ�硢�в��Ҹˤ�ô���ԥᥤ���ô���Ҹˤˤ���
            $sql  = "SELECT \n";
            $sql .= "    t_aorder_h.move_flg \n";
            $sql .= "FROM \n";
            $sql .= "    t_sale_h \n";
            $sql .= "    INNER JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
            $sql .= "WHERE \n";
            $sql .= "    t_sale_h.sale_id = $sale_id \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
            if(pg_fetch_result($result, 0, "move_flg") == "t"){
                //�ᥤ���ô���Ҹ�ID
                $staff_ware_id = Get_Staff_Ware_Id($db_con, $staff_check[0]);

                $sql  = "UPDATE \n";
                $sql .= "    t_sale_h \n";
                $sql .= "SET \n";
                $sql .= "    ware_id = ".$staff_ware_id.", \n";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ".$staff_ware_id.") \n";
                $sql .= "WHERE \n";
                $sql .= "    sale_id = $sale_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }


            //�Ҳ���´�Ϣ�򹹿�
            $sql  = "UPDATE \n";
            $sql .= "    t_sale_h \n";
            $sql .= "SET \n";
            $sql .= ($intro_ac_price != null) ? "    intro_ac_price = $intro_ac_price, \n" : "    intro_ac_price = null, \n";
            $sql .= ($intro_ac_rate != null)  ? "    intro_ac_rate = '$intro_ac_rate', \n" : "    intro_ac_rate = null, \n";
            $sql .= "    intro_ac_div = '$intro_ac_div' \n";
            $sql .= "WHERE \n";
            $sql .= "    sale_id = $sale_id \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //�Ҳ�������򹹿�
            if($intro_account_id != null && $intro_ac_div != "1"){
                //�Ҳ����׻�
                $intro_amount = FC_Intro_Amount_Calc($db_con, "sale", $sale_id);
                if($intro_amount === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }else{
                $intro_amount = null;
            }

            $sql  = "UPDATE \n";
            $sql .= "    t_sale_h \n";
            $sql .= "SET \n";
            $sql .= ($intro_amount !== null) ? "    intro_amount = $intro_amount \n" : "    intro_amount = null \n";
            $sql .= "WHERE \n";
            $sql .= "    sale_id = $sale_id \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //�Ҳ������ȯ�����ʤ�����ʤ�������0����ʤ���硢�Ҳ����λ����򵯤���
            if($intro_ac_div != "1" && $intro_amount > 0){
                $result = FC_Intro_Buy_Query($db_con, $sale_id, $intro_account_id);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }


            /****************************/
            //��ʧ�ơ��֥����Ͽ�ؿ�
            /****************************/
            $result = FC_Trade_Query($db_con, $sale_id);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }else{
                Db_Query($db_con, "COMMIT;");
                header("Location: ".FC_DIR."sale/2-2-207.php?search=1");
                exit;
            }


        }

    }
}


/****************************/
// setConstants�ʤ�
/****************************/
$form->setConstants($con_data2);


//�ե����ब�ե꡼�����Ƥ뤫
$freeze_flg = $form->isFrozen();

#2009-09-26 hashimoto-y
if($renew_flg === true){
    #echo "freeze";
    $num = 5;
    $toSmarty_discount_flg = array();
    for ($i=1; $i<=$num; $i++){
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        if($hdn_discount_flg === 't'){
            $toSmarty_discount_flg[$i] = 't';
        }else{
            $toSmarty_discount_flg[$i] = 'f';

        }
    }
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
//$page_menu = Create_Menu_f('sale','2');


/****************************/
//javascript
/****************************/

//�켰�˥����å����դ�����硢��۷׻�����
$java_sheet   = "function Set_num(row,coax) {\n";
$java_sheet  .= "    Mult_double2('form_goods_num1['+row+']','form_sale_price['+row+'][1]','form_sale_price['+row+'][2]','form_sale_amount['+row+']','form_trade_price['+row+'][1]','form_trade_price['+row+'][2]','form_trade_amount['+row+']','form_issiki['+row+']',coax);\n";
$java_sheet  .= " }\n\n";

/*
//�����
$java_sheet  .= <<<DAIKO

//���ʥ����������ؿ�
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,place,head_flg)
{
    //���������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

        //�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
        if(head_flg != 1){
            //����饤�󡦥��ե饤�����
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
        }else{
            //�̾�
            rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
        }

        if(typeof(rtnarr) != "undefined"){
            for(i=0;i<arr.length;i++){
                dateForm.elements[arr[i]].value=rtnarr[i];
            }
        }

        //����ޥ����ξ��ϲ��̤Υ�����submit����
        if(display==6 || display==7){
            var next = '#'+place;
            document.dateForm.action=next;
            document.dateForm.submit();
        }

    }

    return false;
}

DAIKO;

*/


//plan_data.inc��JS���ɲ�
$java_sheet .= $plan_data_js;


/****************************/
//���̥إå�������
/****************************/
//�ե�����롼�׿�
//$count = ($renew_flg == true) ? count($arr_sale_d_id) : 5;
$count = 5;
for($i=1;$i<=$count;$i++){
    //$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");
    $loop_num[$i] = $i;
}

//���顼�롼�׿�1
$error_loop_num1 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�2
$error_loop_num2 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�3
$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");


/****************************/
//���̥إå�������
/****************************/
/*
$page_title .= "������".$form->_elements[$form->_elementIndex[form_make_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_revision_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[form_public_button]]->toHtml();
*/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
//$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);
$smarty->assign('error_loop_num1',$error_loop_num1);
$smarty->assign('error_loop_num2',$error_loop_num2);
$smarty->assign('error_loop_num3',$error_loop_num3);
$smarty->assign('error_msg4',$error_msg4);
$smarty->assign('error_msg5',$error_msg5);
$smarty->assign('error_msg6',$error_msg6);
$smarty->assign('error_msg7',$error_msg7);
$smarty->assign('error_msg8',$error_msg8);

$smarty->assign('error_msg10',$error_msg10);
$smarty->assign('error_msg11',$error_msg11);
$smarty->assign('error_msg13',$error_msg13);

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'java_sheet'    => "$java_sheet",

    //'flg'           => "$flg",
    //'last_day'      => "$last_day",
    'error_flg'     => $error_flg,
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_msg14'   => "$error_msg14",
    'ac_name'       => "$ac_name",
    //'return_flg'    => "$return_flg",
    //'get_flg'       => "$get_flg",
    'client_id'     => "$client_id",
    //'form_load'     => "$form_load",
    'ware_name'     => "$ware_name",
    //'trade_error_flg' => "$trade_error_flg",
    //'client_cd'     => "$client_cd ",
    //'client_name'   => "$client_name ",
    //'money'         => "$money",
    //'tax_money'     => "$tax_money",
    //'total_money'   => "$total_money",
    'ord_no'        => "$sale_no",
    'round_form'    => "$round_form",
    'renew_flg'     => $renew_flg,
    'sale_id'       => $sale_id,
    'sale_d_id'     => $arr_sale_d_id,
    'concurrent_err_flg'    => $concurrent_err_flg,
    'slip_renew_mess'       => $slip_renew_mess,
    'buy_err_mess'  => "$buy_err_mess",
    'ad_total_warn_mess'    => "$ad_total_warn_mess",
    'contract_div'  => "$contract_div",
    'freeze_flg'    => $freeze_flg,
    'hand_plan_flg' => $hand_plan_flg,
));

#2009-09-26 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));


//print_array($_POST);
//print_array($_SESSION);


?>