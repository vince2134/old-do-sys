<?php
/**
 *
 * ͽ��ǡ�������
 *
 *
 * �ѹ�����
 *    2006/10/13 (suzuki)
 *      �����ܸ������GET���ɲ�
 *    2006/10/26 (kaji)
 *      ��ͽ��ǡ��������ȡ���α��ɼ�ѹ�����Ρʰʲ��ν������ɲá�
 *          ��α��ͳ�����Ϥ�ɬ��
 *          ��α����ʺ���ν��ʤ��ˤˤ������
 *    2006-10-30 �������̤����ܥ��󲡲������ѹ���suzuki��
 *    2006-10-31 �Ҹ�̾�򥵥˥������󥰡�suzuki��
 *               ���������̾��\�ޡ������ɲ�
 *    2006-11-06 ����������������ɽ������ݤ˥���å�����ɤ߹��ޤʤ��褦���ѹ���suzuki��
 *   (2006/11/16) (suzuki)
 *     �������ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��ä���ɽ�����ʤ��褦�˽���
 *      �� (2006/12/01) �����ɼ�αĶȸ����ϰ�����δݤ�����(suzuki)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/09      03-019      kajioka-h   ��α����ܥ����ɽ����､��
 *  2006/11/10      03-024      kajioka-h   ��α�����ľ���������ꤵ��Ƥ��ʤ��������å��ɲ�
 *  2006/11/13      03-028      kajioka-h   �ѹ���ľ���˽����𤵤�Ƥ��ʤ��������å��ɲ�
 *  2006/12/10      02-068      suzuki      �Ķȸ��������ñ���ǡ���������������
 *  2006/12/12      03-064      suzuki      �ѹ���ľ���˽����𤵤�Ƥ��ʤ��������å��ɲ�
 *  2007/02/05      �׷�26-1    kajioka-h   �����ɼ�ξ��˿��̤��ѹ��Ǥ���褦���ѹ�
 *  2007/02/16      �׷�5-1     kajioka-h   ���ʽв�ͽ��Ǻ߸˰�ư�Ѥ�ͽ��ǡ����Ͻв��Ҹˤ�ô����(�ᥤ��)��ô���Ҹˤˤ�������ɲ�
 *  2007/03/02      ��˾6-3     kajioka-h   �����ƥ�̾��������ʾ���ʬ��ܾ���̾�ˡפȡ�ά�Ρ�ɽ����
 *  2007/03/08      B0702-016   kajioka-h   ���ʤ���̾�ѹ��ԲĢ��ѹ��Ĥ��Ѥ����ݤˡ��ե����ब��̾�ѹ���ǽ�ˤʤ�ʤ��Х�����
 *  2007/03/22      ��˾21      kajioka-h   ͽ����ɼ�����ǽ�ˤ�ꡢ��α��ɼ�ѹ��������ǽ��ʤ�����
 *  2007/03/22      ��˾21      kajioka-h   ͽ����ɼ�����ǽ�ˤ�ꡢ��α��ɼ�ѹ��������ǽ��ʤ�����
 *  2007/03/29      B0702-017   kajioka-h   �����ɼ�Υ����ƥ����0���ѹ��Ǥ��ʤ��Х�����
 *  2007/04/06      ��˾1-4     kajioka-h   �Ҳ�������λ����ѹ�
 *  2007/04/10      B0702-035   kajioka-h   �����ɼ�ǡ������إå��ζ�ۤ���������ʤ��Х�����
 *  2007/04/11      ��˾1-4     kajioka-h   �Ҳ�������Υ饸���ܥ��󤬷���ޥ����ȹ�äƤ��ʤ��ä��Τ���
 *  2007/04/13      ����¾      kajioka-h   ���������ע���ͽ�������פ�ɽ���ѹ�
 *                  B0702-037   kajioka-h   �����ɼ�����¦���ѹ�����ȾҲ���¤����ꤵ��Ƥ��ʤ����˥��顼�ˤʤ�Τ���
 *  2007/04/16      ����¾      morita-d    ��ɼ����������ɼȯ������slip_out_day�ˤ�NULL�ˤ���褦�ѹ�
 *  2007/04/26      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/17      xx-xxx      kajioka-h   ͽ��ǡ������١�ͽ��ǡ��������������ɼ�����������ɼ�ǥ쥤�����Ȥ��碌��
 *  2007/05/23      xx-xxx      kajioka-h   �����ɼ�μ����ʬ�򸽶���ѹ���ǽ�ˤ���
 *  2007/06/06      xx-xxx      kajioka-h   ������λ��ͤ������ѹ��ˤʤä���
 *  2007/06/15      ����¾14    kajioka-h   ������
 *  2007/06/27      xx-xxx      kajioka-h   ���ʥޥ���Ʊ���ե饰�ν������ɲ�
 *  2007/08/20                  kajioka-h   ͽ��ǡ��������ǥ��ե饤����ԡ�����ۤξ��˱Ķȸ������ѹ��Ǥ���褦���ѹ�
 *  2007/08/29                  kajioka-h   �����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ���ˤ���
 *  2007/11/03                  kajioka-h   ����饤����ԤǼ����褬��������ѹ���������������Ѥ��褦��
 *  2009/09/14                  aoyama-n    �Ͱ���ǽ�ɲ�
 *  2009/09/21                  hashimoto-y �Ͱ����ʤ����򤷤������ֻ�ɽ��
 *  2009/09/26                  hashimoto-y �Ͱ��ֻ�ɽ�������פʽ������
 *  2009/10/06      rev.1.3     kajioka-h   ͽ����������������2����ʾ������ȷٹ��å������ɲ�
 *  2009/12/22                  aoyama-n    ��Ψ��TaxRate���饹�������
 *
 */

$page_title = "ͽ��ǡ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB����³
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

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");


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

//���ޤ���
require_once(INCLUDE_DIR."rental.inc"); //�����Ǥ��������ؿ������Ѥ��뤿��


/****************************/
//�����ѿ�����
/****************************/
$aord_id      = $_GET["aord_id"];        //����ID
$back_display = $_GET["back_display"];   //ͽ�����٤����ܸ�
$array_id     = $_GET["aord_id_array"];  //�����������Ƥμ���ID
//���󥷥ꥢ�饤����
$array_id = stripslashes($array_id);
$array_id = urldecode($array_id);
$array_id = unserialize($array_id);

$client_h_id = $_SESSION["client_id"];  //��������桼��ID
$staff_id    = $_SESSION["staff_id"];   //���������ID
$staff_name  = $_SESSION["staff_name"]; //���������̾
$group_kind  = $_SESSION["group_kind"]; //���롼�׼���

$plan_aord_flg = true;  //ͽ��ǡ��������ե饰


//����ID��hidden�ˤ���ݻ�����
if($_GET["aord_id"] != NULL){
	$con_data2["hdn_aord_id"] = $aord_id;
}else{
	$aord_id = $_POST["hdn_aord_id"];
}

//�����������Ƥμ���ID��hidden�ˤ���ݻ�����
if($_GET["aord_id_array"] != NULL){
	//����ID���ꥢ�饤����
	$array_id2 = serialize($array_id);
	$array_id2 = urlencode($array_id2);
	$con_data2["hdn_aord_id_array"] = $array_id2;
}else{
	$array_id = $_POST["hdn_aord_id_array"];
	//���󥷥ꥢ�饤����
	$array_id = stripslashes($array_id);
	$array_id = urldecode($array_id);
	$array_id = unserialize($array_id);
}

//ͽ�����٤����ܸ���hidden�ˤ���ݻ�����
if($_GET["back_display"] != NULL){
	$con_data2["hdn_back_display"] = $back_display;
}else{
	$back_display = $_POST["hdn_back_display"];
}
//ľ��󥯤����ܤ��Ƥ������ˤϡ�TOP�����Ф�
Get_ID_Check2($aord_id);

//����Ƚ��
Get_ID_Check3($aord_id);
Get_ID_Check3($array_id);



/****************************/
//�������
/****************************/

#2009-12-22 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($client_h_id);

//�����إå���
$sql  = "SELECT ";
$sql .= "    t_aorder_h.ord_no,";                     //��ɼ�ֹ� 0
$sql .= "    t_aorder_h.ord_time,";                   //ͽ������ 1
$sql .= "    t_aorder_h.route,";                      //��ϩ 2
$sql .= "    t_aorder_h.client_cd1,";                 //������cd1 3
$sql .= "    t_aorder_h.client_cd2,";                 //������cd2 4
$sql .= "    t_aorder_h.client_cname,";               //������̾  5   
$sql .= "    t_aorder_h.trade_id,";                   //�����ʬ  6
$sql .= "    t_aorder_h.hope_day,";                   //���׾��� 7
$sql .= "    t_aorder_h.arrival_day,";                //������ 8
$sql .= "    t_staff1.staff_id,";                     //ô���ԣ�9
$sql .= "    t_staff1.sale_rate,";                    //���Ψ��10
$sql .= "    t_staff2.staff_id,";                     //ô���ԣ�11
$sql .= "    t_staff2.sale_rate,";                    //���Ψ��12
$sql .= "    t_staff3.staff_id,";                     //ô���ԣ�13
$sql .= "    t_staff3.sale_rate,";                    //���Ψ��14
$sql .= "    t_staff4.staff_id,";                     //ô���ԣ�15
$sql .= "    t_staff4.sale_rate,";                    //���Ψ��16
$sql .= "    t_aorder_h.note, ";                      //���� 17
$sql .= "    t_aorder_h.reason_cor,";                 //������ͳ 18
$sql .= "    t_aorder_h.net_amount, ";                //��ȴ��� 19
$sql .= "    t_aorder_h.tax_amount, ";                //������ 20
$sql .= "    t_client.client_id, ";                   //������ID 21

$sql .= "    t_aorder_h.act_request_rate, ";          //��԰����� 22
$sql .= "    t_aorder_h.contract_div, ";              //�����ʬ 23
$sql .= "    t_aorder_h.act_id, ";                    //�����ID 24
$sql .= "    t_aorder_h.ware_id, ";                   //�в��Ҹ�ID 25
$sql .= "    t_aorder_h.ware_name,";                  //�в��Ҹ�̾ 26
$sql .= "    t_aorder_h.claim_id || ',' || t_aorder_h.claim_div,";  //������ID,�������ʬ27
$sql .= "    t_aorder_h.round_form, ";                //������ 28
$sql .= "    t_aorder_h.trust_note, ";                 //����(������) 29
$sql .= "    t_aorder_h.del_flg, ";                     //����ե饰 30
$sql .= "    t_aorder_h.intro_account_id, ";            //�Ҳ��ID 31
$sql .= "    t_aorder_h.intro_ac_cd1, ";                //�Ҳ��CD1 32
$sql .= "    t_aorder_h.intro_ac_cd2, ";                //�Ҳ��CD2 33
$sql .= "    t_aorder_h.intro_ac_name, ";               //�Ҳ��̾ 34
$sql .= "    t_aorder_h.intro_ac_div, ";                //�Ҳ���¶�ʬ 35
$sql .= "    t_aorder_h.intro_ac_price, ";              //�Ҳ����ñ����������� 36
$sql .= "    t_aorder_h.intro_ac_rate, ";               //�Ҳ����Ψ��������� 37
$sql .= "    t_aorder_h.act_div, ";                     //�������ʬ 38
$sql .= "    t_aorder_h.act_request_price, ";           //������ʸ���ۡ�39
$sql .= "    t_aorder_h.trust_net_amount, ";            //����ۡʼ������40
$sql .= "    t_aorder_h.trust_tax_amount, ";            //�����ǳۡʼ������41
$sql .= "    t_aorder_h.act_cd1, ";                     //��Լ�CD1 42
$sql .= "    t_aorder_h.act_cd2, ";                     //��Լ�CD2 43
$sql .= "    t_aorder_h.act_name, ";                    //��Լ�̾ 44
$sql .= "    t_aorder_h.claim_div, ";                   //�������ʬ 45
$sql .= "    t_aorder_h.advance_offset_totalamount, ";  //�����껦�۹�� 46
$sql .= "    t_aorder_h.confirm_flg, ";                 //����ե饰 47
$sql .= "    t_aorder_h.trust_confirm_flg ";            //�������ѳ���ե饰 48

$sql .= "FROM ";
$sql .= "    t_aorder_h ";

$sql .= "    INNER JOIN t_client ON t_aorder_h.client_id  = t_client.client_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_aorder_staff.aord_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_aorder_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_aorder_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_aorder_staff.staff_div = '0'";
$sql .= "        )AS t_staff1 ON t_staff1.aord_id = t_aorder_h.aord_id ";
 
$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_aorder_staff.aord_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_aorder_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_aorder_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_aorder_staff.staff_div = '1'";
$sql .= "        )AS t_staff2 ON t_staff2.aord_id = t_aorder_h.aord_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_aorder_staff.aord_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_aorder_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_aorder_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_aorder_staff.staff_div = '2'";
$sql .= "        )AS t_staff3 ON t_staff3.aord_id = t_aorder_h.aord_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_aorder_staff.aord_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_aorder_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_aorder_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_aorder_staff.staff_div = '3'";
$sql .= "        )AS t_staff4 ON t_staff4.aord_id = t_aorder_h.aord_id ";

$sql .= "WHERE ";
$sql .= "    t_aorder_h.aord_id = $aord_id \n";
$sql .= "    AND \n";
$sql .= "    t_aorder_h.del_flg = false \n";
$sql .= "    AND \n";
$sql .= "    t_aorder_h.hand_plan_flg = false \n";
//������ϥ��ե饤����Ԥϸ����ʤ�
if($group_kind != "2"){
    $sql .= "    AND \n";
    $sql .= "    t_aorder_h.contract_div != '3' \n";
}
$sql .= ";";
$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);


//�ǡ����������
$result_count = pg_num_rows($result);

for($i = 0; $i < $result_count; $i++){
    $row[] = @pg_fetch_array ($result, $i,PGSQL_NUM);
}
for($i = 0; $i < $result_count; $i++){
    for($j = 0; $j < count($row[$i]); $j++){

		/*
		 * ����
		 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
		 * ��2006/10/31��02-025��������suzuki-t�����Ҹ�̾�򥵥˥������󥰤���
		 *
		*/
		//���˥�������Ƚ��
		if($j == 5 || $j == 26){
			//������̾���Ҹ�̾�Ϥ���
			$data_list[$i][$j] = htmlspecialchars($row[$i][$j]);
		}else{
			//�ʳ�
			$data_list[$i][$j] = $row[$i][$j];
		}
    }
}


$contract_div       = $data_list[0][23];    //�����ʬ
$confirm_flg        = $data_list[0][47];    //����ե饰
$trust_confirm_flg  = $data_list[0][48];    //�������ѳ���ե饰

//����Ѥϥե꡼��
if($confirm_flg == "t"){
    $form->freeze();

//̤��������Ѥ�������ͳ�������껦�۰ʳ��ե꡼���ʥ���饤����ԡ�
}elseif($trust_confirm_flg == "t" && $contract_div == "2"){
    //�إå������ɲåե꡼��
    //intro_ac_div[] �� plan_data.inc ��Ǥ�äƤޤ�
    $freeze_data = array(
        "form_delivery_day",
        "trade_aord",
        "form_request_day",
        "form_claim",
        "intro_ac_price",
        "intro_ac_rate",
        "form_note",
    );
    //�ǡ��������ɲåե꡼��
    for($i=1; $i<=5; $i++){
        array_push($freeze_data, 
            "form_issiki[$i]",
            "form_goods_num1[$i]",
            "form_goods_num2[$i]",
            "form_goods_num3[$i]"
        );
    }

    $form->freeze($freeze_data);
}


$ord_no                                 = $data_list[0][0];                              //��ɼ�ֹ�
$deli_day                               = explode('-',$data_list[0][1]);                 //ͽ������
$con_data["form_delivery_day"]["y"]     = $deli_day[0];
$con_data["form_delivery_day"]["m"]     = $deli_day[1];
$con_data["form_delivery_day"]["d"]     = $deli_day[2];
$con_data["hdn_former_deli_day"]        = $data_list[0][1];                              //rev.1.3 �ѹ�����ͽ��������hidden���ݻ�
$form->addElement("hidden", "hdn_former_deli_day");
$data_list[0][2]                        = str_pad($data_list[0][2], 4, 0, STR_POS_LEFT); //��ϩ
$con_data["form_route_load"][1]         = substr($data_list[0][2],0,2);  
$con_data["form_route_load"][2]         = substr($data_list[0][2],2,2);  
$client_cd                              = $data_list[0][3]."-".$data_list[0][4];         //������CD
$client_name = $data_list[0][5];                                                         //������̾
$con_data["trade_aord"]                 = $data_list[0][6];                              //�����ʬ
/*
$sale_day                               = explode('-',$data_list[0][7]);                 //���׾���
$con_data["form_sale_day"]["y"]         = $sale_day[0];
$con_data["form_sale_day"]["m"]         = $sale_day[1];
$con_data["form_sale_day"]["d"]         = $sale_day[2];
*/
$req_day                                = explode('-',$data_list[0][8]);                 //������
$con_data["form_request_day"]["y"]      = $req_day[0];
$con_data["form_request_day"]["m"]      = $req_day[1];
$con_data["form_request_day"]["d"]      = $req_day[2];
$con_data["form_c_staff_id1"]           = $data_list[0][9];                              //ô���ԣ�
$con_data["form_sale_rate1"]            = $data_list[0][10];                             //���Ψ��
$con_data["form_c_staff_id2"]           = $data_list[0][11];                             //ô���ԣ�
$con_data["form_sale_rate2"]            = $data_list[0][12];                             //���Ψ��
$con_data["form_c_staff_id3"]           = $data_list[0][13];                             //ô���ԣ�
$con_data["form_sale_rate3"]            = $data_list[0][14];                             //���Ψ��
$con_data["form_c_staff_id4"]           = $data_list[0][15];                             //ô���ԣ�
$con_data["form_sale_rate4"]            = $data_list[0][16];                             //���Ψ��

$con_data2["hdn_contract_div"]          = $contract_div;                                 //hidden���ݻ� 

$con_data["form_reason"]                = $data_list[0][18];                             //������ͳ

//�̾ľ��¦�����
$con_data["form_note"] = ($contract_div == "1" || $group_kind == "2") ? $data_list[0][17] : $data_list[0][29];  //����
$money                              = $data_list[0][19];                                //��ȴ���
$tax_money                          = $data_list[0][20];                                //������

$total_money                            = $money + $tax_money;                           //��ɼ���
//$money = number_format($money);
//$tax_money = number_format($tax_money);
//$total_money = number_format($total_money);
$con_data["form_sale_total"]            = number_format($money);
$con_data["form_sale_tax"]              = number_format($tax_money);
$con_data["form_sale_money"]            = number_format($total_money);

$advance_offset_totalamount         = ($data_list[0][46] != null) ? number_format($data_list[0][46]) : null;    //�����껦�۹��
$con_data["form_ad_offset_total"]   = $advance_offset_totalamount;

$client_id                              = $data_list[0][21];                             //������ID
//������ID��hidden�ˤ���ݻ�����
if($client_id != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

/*
//��԰���������Ƚ��
if($data_list[0][22] != NULL){
	$trust_rate                             = $data_list[0][22];                        
}else{
	$trust_rate                             = '0';                                       
}
$con_data2["hdn_trust_rate"]            = $trust_rate;                                   //hidden���ݻ� 
*/

/*
//ľ��¦���������ɼ�����������硢�Ķȸ����������Բ�
if($contract_div != '1' && $group_kind != 3){
    //�Ķȸ����������Բġ������껦�ե饰���ʤ��ʤ��ۥե�����������Բ�
	//$form_load = "onLoad=\"daiko_checked();\"";
}
*/

//���ҽ�󡢤ޤ���ľ��¦�������ɼ�ξ�硢�����⤬���ϤǤ���
if($contract_div == "1" || $group_kind == "2"){
    $form_load = "onLoad=\"ad_offset_radio_disable();\"";
}

$act_id                                 = $data_list[0][24];                             //�����ID
$con_data["hdn_act_id"]                 = $act_id;
$act_div                                = $data_list[0][38];                             //�������ʬ
$con_data["act_request_price"]          = $data_list[0][39];                             //������ʸ����

if($contract_div != "1"){
    //������
    $act_name = $data_list[0][42]."-".$data_list[0][43]."<br>".htmlspecialchars($data_list[0][44]);

    //������
    if($act_div == "1"){
        $act_amount = "ȯ�����ʤ�";
    }elseif($act_div == "2"){
        //$act_amount = number_format($data_list[0][40])."�ʸ���ۡ�";
        $form->addElement("text","act_request_price","��",'class="money_num" size="7" maxLength="6"'.$g_form_option);
    }elseif($act_div == "3"){
        $act_amount = number_format($data_list[0][40])."������".$data_list[0][22]."���";
    }

    //�����Τޤ���ʬ�����
    $tmp = Get_Tax_div($db_con, $act_id);
    $daiko_coax = $tmp["coax"];

}

$ware_id                                = $data_list[0][25];                             //�в��Ҹ�ID
$ware_name                              = $data_list[0][26]."��";                        //���ʽв��Ҹ�̾

$con_data["form_claim"]                 = $data_list[0][27];                             //������

$round_form                             = $data_list[0][28];                             //������

$intro_account_id                       = $data_list[0][31];                             //�Ҳ��ID
$con_data["hdn_intro_account_id"]       = $intro_account_id;
$intro_ac_cd1                           = $data_list[0][32];                             //�Ҳ��CD1
$intro_ac_cd2                           = $data_list[0][33];                             //�Ҳ��CD2
$intro_ac_name                          = $data_list[0][34];                             //�Ҳ��̾
$intro_ac_div                           = $data_list[0][35];                             //�Ҳ���¶�ʬ
$con_data["intro_ac_div[]"]             = $intro_ac_div;
$intro_ac_price                         = $data_list[0][36];                             //�Ҳ����ñ��
$con_data["intro_ac_price"]             = $intro_ac_price;
$intro_ac_rate                          = $data_list[0][37];                             //�Ҳ����Ψ
$con_data["intro_ac_rate"]              = $intro_ac_rate;

$claim_div                              = $data_list[0][45];                             //�������ʬ

$ad_rest_price                          = Advance_Offset_Claim($db_con, $data_list[0][1], $client_id, $claim_div);  //������Ĺ�
$con_data["form_ad_rest_price"]         = number_format($ad_rest_price);

//�Ҳ�Ԥ�FC�������褫Ƚ��
if($intro_account_id != null){
    $sql = "SELECT client_div FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    //������ξ�硢�Ҳ��CD1�Τ�
    if(pg_fetch_result($result, 0, "client_div") == "2"){
        $ac_name = $intro_ac_cd1."<br>".htmlspecialchars($intro_ac_name);
    }else{
        $ac_name = $intro_ac_cd1."-".$intro_ac_cd2."<br>".htmlspecialchars($intro_ac_name);
    }
//�Ҳ�Ԥ��ʤ����
}else{
    $ac_name = "̵��";
    $con_data2["intro_ac_div[]"] = 1;
}


/****************************/
//������Ƚ��
/****************************/
//FC¦�������ɼɽ��Ƚ��
if($contract_div != '1' && $group_kind == 3){
	//�ƣ�¦�������ɼ
	Injustice_check($db_con,"a_trust",$aord_id,$client_h_id);
}else{
	//�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ
	Injustice_check($db_con,"aorder",$aord_id,$client_h_id);
}

/****************************/
//�����ǡ����ơ��֥�
/****************************/
$sql  = "SELECT ";
$sql .= "    t_aorder_d.line,";            //�Կ�0
$sql .= "    t_aorder_d.sale_div_cd, ";    //�����ʬ1
$sql .= "    t_aorder_d.serv_print_flg,";  //�����ӥ������ե饰2
$sql .= "    t_aorder_d.serv_id,";         //�����ӥ�ID3

$sql .= "    t_aorder_d.goods_print_flg,"; //�����ƥ�����ե饰4
$sql .= "    t_aorder_d.goods_id,";        //�����ƥ�ID5
$sql .= "    t_aorder_d.goods_cd,";        //�����ƥ�CD6
$sql .= "    t_item.name_change,";         //�����ƥ���̾�ѹ�7
$sql .= "    t_aorder_d.goods_name,";      //�����ƥ�̾��ά�Ρ�8
$sql .= "    t_aorder_d.num,";             //�����ƥ��9

$sql .= "    t_aorder_d.set_flg,";         //�켰�ե饰10

//�Ķȸ���Ƚ��
if($contract_div != '1' && $group_kind == 3){
	//�ƣ�¦����Ԥ������������
	$sql .= "    t_aorder_d.trust_cost_price,";     //�Ķȸ���(������)11
}else{
	//�̾���ɼ��ľ�Ĥ���Ԥ�����
	$sql .= "    t_aorder_d.cost_price,";           //�Ķȸ���11
}
$sql .= "    t_aorder_d.sale_price,";       //���ñ��12
//�Ķȶ��Ƚ��
if($contract_div != '1' && $group_kind == 3){
	//�ƣ�¦����Ԥ������������
	$sql .= "    t_aorder_d.trust_cost_amount,";    //�Ķȶ��(������)13
}else{
	//�̾���ɼ��ľ�Ĥ���Ԥ�����
	$sql .= "    t_aorder_d.cost_amount,";          //�Ķȶ��13
}
$sql .= "    t_aorder_d.sale_amount,";      //�����14  

$sql .= "    t_aorder_d.rgoods_id,";       //����ID15
$sql .= "    t_aorder_d.rgoods_cd,";       //����CD16
$sql .= "    t_body.name_change,";         //������̾�ѹ�17
$sql .= "    t_aorder_d.rgoods_name,";     //����̾18
$sql .= "    t_aorder_d.rgoods_num,";      //���ο�19

$sql .= "    t_aorder_d.egoods_id,";       //������ID20
$sql .= "    t_aorder_d.egoods_cd,";       //������CD21
$sql .= "    t_expend.name_change,";       //��������̾�ѹ�22
$sql .= "    t_aorder_d.egoods_name,";     //������̾23
$sql .= "    t_aorder_d.egoods_num,";      //�����ʿ�24

$sql .= "    t_aorder_d.account_price,";   //����ñ��25
$sql .= "    t_aorder_d.account_rate, ";   //����Ψ26  
$sql .= "    t_aorder_d.aord_d_id, ";      //�����ǡ���ID27 
$sql .= "    t_aorder_d.contract_id, ";    //�������ID28 
$sql .= "    t_aorder_d.official_goods_name, ";     //�����ƥ�̾��������29
$sql .= "    t_aorder_d.advance_flg, ";             //�����껦�ե饰 30
$sql .= "    t_aorder_d.advance_offset_amount, ";   //�����껦�� 31
//aoyama-n 2009-09-14
#$sql .= "    t_aorder_d.mst_sync_flg ";             //�ޥ���Ʊ���ե饰 32
$sql .= "    t_aorder_d.mst_sync_flg, ";             //�ޥ���Ʊ���ե饰 32
$sql .= "    t_item.discount_flg ";                  //�Ͱ��ե饰 33

$sql .= "FROM ";
$sql .= "    t_aorder_d ";
$sql .= "    LEFT JOIN t_goods AS t_item ON t_item.goods_id = t_aorder_d.goods_id ";
$sql .= "    LEFT JOIN t_goods AS t_body ON t_body.goods_id = t_aorder_d.rgoods_id ";
$sql .= "    LEFT JOIN t_goods AS t_expend ON t_expend.goods_id = t_aorder_d.egoods_id ";

$sql .= "WHERE ";
$sql .= "    t_aorder_d.aord_id = $aord_id ";
$sql .= ";";
//print($sql);
$result = Db_Query($db_con, $sql);
$sub_data = Get_Data($result,2);

//����ID�˳�������ǡ�����¸�ߤ��뤫
for($s=0;$s<count($sub_data);$s++){
	$search_line = $sub_data[$s][0];   //���������
	//���¶�ʬ�ν���ͤ����ꤷ�ʤ�������
	$aprice_array[] = $search_line;

	$con_data["form_divide"][$search_line]                = $sub_data[$s][1];   //�����ʬ

	//���ɽ���Τ�����
	if($_POST["check_value_flg"] == 't'){
		//�����å��դ��뤫Ƚ��
		if($sub_data[$s][2] == 't'){
			$con_data2["form_print_flg1"][$search_line]   = $sub_data[$s][2];    //�����ӥ������ե饰
		}
	}
	$con_data["form_serv"][$search_line]                  = $sub_data[$s][3];    //�����ӥ�

	//���ɽ���Τ�����
	if($_POST["check_value_flg"] == 't'){
		//�����å��դ��뤫Ƚ��
		if($sub_data[$s][4] == 't'){
			$con_data2["form_print_flg2"][$search_line]   = $sub_data[$s][4];    //�����ƥ���ɼ�����ե饰
		}
	}
	$con_data["hdn_goods_id1"][$search_line]              = $sub_data[$s][5];    //�����ƥ�ID
	$con_data["form_goods_cd1"][$search_line]             = $sub_data[$s][6];    //�����ƥ�CD
	$con_data["hdn_name_change1"][$search_line]           = $sub_data[$s][7];    //�����ƥ���̾�ѹ��ե饰
	$hdn_name_change[1][$search_line]                     = $sub_data[$s][7];    //POST�������˥����ƥ�̾���ѹ��Բ�Ƚ���Ԥʤ���
	$con_data["form_goods_name1"][$search_line]           = $sub_data[$s][8];    //�����ƥ�̾��ά�Ρ�
	$con_data["form_goods_num1"][$search_line]            = $sub_data[$s][9];    //�����ƥ��
	$con_data["official_goods_name"][$search_line]        = $sub_data[$s][29];   //�����ƥ�̾��������
	
	//���ɽ���Τ�����
	if($_POST["check_value_flg"] == 't'){

		//�����ʬ����ԤΤ߷����ѹ�
		if($contract_div != '1'){
			//�����å��դ��뤫Ƚ��
			if($sub_data[$s][10] == 't'){
				$con_data2["form_issiki"][$search_line]       = "�켰";    //�켰�ե饰
			}
		}else{
			//�����å��դ��뤫Ƚ��
			if($sub_data[$s][10] == 't'){
				$con_data2["form_issiki"][$search_line]       = $sub_data[$s][10];    //�켰�ե饰
			}
		}
	}

	//����Ƚ��
	if($sub_data[$s][9] != NULL && $sub_data[$s][10] == 't'){
		//���̤Ȱ켰�ξ��ϡ��֤˲��Ԥ򤤤��
		$br_flg = 'true';
	}

	$cost_price = explode('.', $sub_data[$s][11]);                                //�Ķȸ���
	$con_data["form_trade_price"][$search_line]["1"] = $cost_price[0];  
	$con_data["form_trade_price"][$search_line]["2"] = ($cost_price[1] != null)? $cost_price[1] : '00';    

	$sale_price = explode('.', $sub_data[$s][12]);                                //���ñ��
	$con_data["form_sale_price"][$search_line]["1"] = $sale_price[0];  
	$con_data["form_sale_price"][$search_line]["2"] = ($sale_price[1] != null)? $sale_price[1] : '00';

	$con_data["form_trade_amount"][$search_line]    = number_format($sub_data[$s][13]);  //�Ķȶ��
	$con_data["form_sale_amount"][$search_line]     = number_format($sub_data[$s][14]);  //�����

	$con_data["hdn_goods_id2"][$search_line]              = $sub_data[$s][15];    //����ID
	$con_data["form_goods_cd2"][$search_line]             = $sub_data[$s][16];    //����CD
	$con_data["hdn_name_change2"][$search_line]           = $sub_data[$s][17];    //������̾�ѹ��ե饰
	$hdn_name_change[2][$search_line]                     = $sub_data[$s][17];    //POST������������̾���ѹ��Բ�Ƚ���Ԥʤ���
	$con_data["form_goods_name2"][$search_line]           = $sub_data[$s][18];    //����̾
	$con_data["form_goods_num2"][$search_line]            = $sub_data[$s][19];    //���ο�

	$con_data["hdn_goods_id3"][$search_line]              = $sub_data[$s][20];    //������ID
	$con_data["form_goods_cd3"][$search_line]             = $sub_data[$s][21];    //������CD
	$con_data["hdn_name_change3"][$search_line]           = $sub_data[$s][22];    //��������̾�ѹ��ե饰
	$hdn_name_change[3][$search_line]                     = $sub_data[$s][22];    //POST�������˾�����̾���ѹ��Բ�Ƚ���Ԥʤ���
	$con_data["form_goods_name3"][$search_line]           = $sub_data[$s][23];    //������̾
	$con_data["form_goods_num3"][$search_line]            = $sub_data[$s][24];    //�����ʿ�

	//����ñ��
	if($sub_data[$s][25] != NULL){
		//��
		$con_data["form_account_price"][$search_line]       = $sub_data[$s][25];  //����ñ��
		$con_data["form_aprice_div[$search_line]"] = 2;
	}else if($sub_data[$s][26] != NULL){
		//Ψ
		$con_data["form_account_rate"][$search_line]        = $sub_data[$s][26];  //����Ψ
		$con_data["form_aprice_div[$search_line]"] = 3;
	}else{
		//�ʤ�
		$con_data["form_aprice_div[$search_line]"] = 1;
	}

    //����
    $con_data["form_ad_offset_radio"][$search_line]     = $sub_data[$s][30];        //�����껦�ե饰
    $con_data["form_ad_offset_amount"][$search_line]    = $sub_data[$s][31];        //�����껦��

    $con_data["hdn_mst_sync_flg"][$search_line]         = $sub_data[$s][32];        //�ޥ���Ʊ���ե饰

    //aoyama-n 2009-09-14
    $con_data["hdn_discount_flg"][$search_line]         = $sub_data[$s][33];        //�Ͱ��ե饰


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

	//����ID�˳�������������ƥǡ�����¸�ߤ��뤫
	for($c=0;$c<count($id_data);$c++){
		$sql  = "SELECT ";
		$sql .= "    t_aorder_detail.line,";          //��
		$sql .= "    t_aorder_detail.goods_id,";      //����ID
		$sql .= "    t_aorder_detail.goods_cd,";      //����CD
		$sql .= "    t_goods.name_change,";           //��̾�ѹ�
		$sql .= "    t_aorder_detail.goods_name,";    //����̾
		$sql .= "    t_aorder_detail.num,";           //����
		//�Ķȸ������Ķ�Ƚ��
		if($contract_div != '1' && $group_kind == 3){
			//�ƣ�¦����Ԥ������������
			$sql .= "    t_aorder_detail.trust_trade_price,";  //�Ķȸ���(������)
			$sql .= "    t_aorder_detail.trust_trade_amount,"; //�Ķȶ��(������)
		}else{
			//�̾���ɼ
			$sql .= "    t_aorder_detail.trade_price,";        //�Ķȸ���
			$sql .= "    t_aorder_detail.trade_amount,";       //�Ķȶ��
		}
		$sql .= "    t_aorder_detail.sale_price,";    //���ñ��
		$sql .= "    t_aorder_detail.sale_amount ";   //�����
		$sql .= "FROM ";
		$sql .= "    t_aorder_detail ";
		$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_aorder_detail.goods_id ";
		$sql .= "WHERE ";
		$sql .= "    t_aorder_detail.aord_d_id = ".$id_data[$c][0].";";  
		$result = Db_Query($db_con, $sql);
		$detail_data = Get_Data($result,2);

		//������Ͽ�ι��ֹ�
		$search_row = $id_data[$c][1];

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

			$s_price = explode('.', $detail_data[$d][8]);
			$con_data["break_sale_price"][$search_row][$search_line2]["1"] = $s_price[0];     //���ñ��
			$con_data["break_sale_price"][$search_row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

			$con_data["break_trade_amount"][$search_row][$search_line2] = number_format($detail_data[$d][7]); //�Ķȶ��
			$con_data["break_sale_amount"][$search_row][$search_line2]  = number_format($detail_data[$d][9]); //�����
		}
	}
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
        $con_data["form_ad_offset_radio"][$a] = "1";
	}
}

$form->setDefaults($con_data);

#2009-09-18 hashimoto-y
#print_r($con_data);
#$form->setConstants($con_data);


/****************************/
//������������
/****************************/
//������ɼ��ľ�Ĥʤ�������δݤ�
$sql  = "SELECT";
$sql .= "   t_client.coax ";
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $client_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
$data_list = Get_Data($result);
$coax   = $data_list[0][0];         //�ݤ��ʬ���������

if($contract_div != '1' && $_SESSION["group_kind"] != "2"){
	//�����ɼ�����ۤδݤ�
	//���ۤ�client_id������ʳƥ���åפ�������ޥ����˼�ư����Ͽ������ġ�
	$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
	$result = Db_Query($db_con, $sql);
	$toyo_id = pg_fetch_result($result, 0, 0);
	//�ݤ��ʬ����
	$sql  = "SELECT ";
	$sql .= "   t_client.coax ";    
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $toyo_id";
	$sql .= ";";
    $result = Db_Query($db_con, $sql); 
    Get_Id_Check($result);
    $data_list = Get_Data($result);
    $toyo_coax  = $data_list[0][0];     //�ݤ��ʬ�ʼ������������ޥ����ˤ������ۡ�
}


/****************************/
//��������桼�������������
/****************************/
//������ξ�������
$sql  = "SELECT";
$sql .= "   t_client.rank_cd ";
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $client_h_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
$data_list = Get_Data($result);

$rank_cd        = $data_list[0][0];        //�ܵҶ�ʬCD

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
	$sql .= "     t_goods.goods_id,";                      //����ID 0
	$sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰 1
	$sql .= "     t_goods.goods_cd,";                      //���ʥ����� 2
	$sql .= "     t_goods.goods_cname,";                   //ά�� 3
	$sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ�� 4
	$sql .= "     sale_price.r_price AS sale_price, ";     //���ñ�� 5
	$sql .= "     t_goods.compose_flg, ";                  //�����ʥե饰 6
    $sql .= "     CASE \n";
    $sql .= "         WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
    $sql .= "         ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    #$sql .= "     END \n";                              //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
    $sql .= "     END, \n";                              //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
    $sql .= "     t_goods.discount_flg \n";              //�Ͱ��ե饰 8

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
	if($_SESSION["group_kind"] == "2"){
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
		$sql .= "     t_goods.goods_id,";                      //����ID 0
		$sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰 1
		$sql .= "     t_goods.goods_cd,";                      //���ʥ����� 2
		$sql .= "     t_goods.goods_cname,";                   //ά�� 3
		$sql .= "     NULL,";                                   // 4
		$sql .= "     NULL,";                                   // 5
		$sql .= "     t_goods.compose_flg, ";                  //�����ʥե饰 6
        $sql .= "     CASE \n";
        $sql .= "         WHEN t_g_product.g_product_name IS NULL THEN t_goods.goods_name \n";
        $sql .= "         ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
        //aoyama-n 2009-09-14
        #$sql .= "     END \n";                                 //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
        $sql .= "     END, \n";                                 //����ʬ��̾��Ⱦ���ڡܾ���̾ 7
        $sql .= "     t_goods.discount_flg \n";                 //�Ͱ��ե饰 8
		$sql .= " FROM";
		$sql .= "     t_goods ";
        $sql .= "     LEFT JOIN t_g_product ON t_goods.g_product_id = t_goods.g_product_id \n";
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

		//�����ܤξ���Ƚ��
		if($search_line == 1){
			//�����ܤξ��ʤ����׻�����

			//������Ƚ��
			if($goods_data[6] == 'f'){
				//�����ʤǤϤʤ�

				//����ñ�����������Ⱦ�������ʬ����
				$com_c_price = $goods_data[4];
		        $c_price = explode('.', $goods_data[4]);
				$con_data2["form_trade_price"][$search_row]["1"] = $c_price[0];  //�Ķ�ñ��
				$con_data2["form_trade_price"][$search_row]["2"] = ($c_price[1] != null)? $c_price[1] : '00';     

				//���ñ�����������Ⱦ�������ʬ����
				$com_s_price = $goods_data[5];
		        $s_price = explode('.', $goods_data[5]);
				$con_data2["form_sale_price"][$search_row]["1"] = $s_price[0];  //���ñ��
				$con_data2["form_sale_price"][$search_row]["2"] = ($s_price[1] != null)? $s_price[1] : '00';

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
					$sql .= " AND \n";
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
			}
/*
			//���Ƚ��
			if($_POST["hdn_contract_div"] != 1){

				//�Ķȸ��������ñ������԰�����Ψ��
				$daiko_money = $com_s_price * ($_POST["hdn_trust_rate"] / 100);

				$eigyo_money = $daiko_money;
				$con_data2["form_trade_price"][$search_row]["1"] = $eigyo_money;
				$con_data2["form_trade_price"][$search_row]["2"] = '00';

				//�Ķȶ�۷׻�����Ƚ��
				if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] != null){
				//�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�
					//�Ķȶ�۷׻�
			        $cost_amount = bcmul($eigyo_money, $_POST["form_goods_num1"][$search_row],2);
			        $cost_amount = Coax_Col($coax, $cost_amount);
				//�켰�������̡ߤξ�硢ñ���ߣ�
				}else if($_POST["form_goods_num1"][$search_row] == null && $_POST["form_issiki"][$search_row] != null){
					//�Ķȶ�۷׻�
			        $cost_amount = bcmul($eigyo_money,1,2);
			        $cost_amount = Coax_Col($coax, $cost_amount);
				//�켰�ߡ����̡��ξ�硢ñ���߿���
				}else if($_POST["form_goods_num1"][$search_row] != null && $_POST["form_issiki"][$search_row] == null){
					//�Ķȶ�۷׻�
			        $cost_amount = bcmul($eigyo_money, $_POST["form_goods_num1"][$search_row],2);
			        $cost_amount = Coax_Col($coax, $cost_amount);
				}
			}
*/
			$con_data2["form_trade_amount"][$search_row]    = number_format($cost_amount);
			$con_data2["form_sale_amount"][$search_row]     = number_format($sale_amount);

    		$con_data2["official_goods_name"][$search_row]  = $goods_data[7];   //����̾��������

            //aoyama-n 2009-09-14
    		$con_data2["hdn_discount_flg"][$search_row]     = $goods_data[8];   //�Ͱ��ե饰
		}else{
			//�󡦻����ܤξ���
			
			//������Ƚ��
			if($goods_data[6] == 't'){
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
					if($_SESSION["group_kind"] == "2"){
						//ľ��
				        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
				    }else{
						//FC
				        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
				    }
					$sql .= " AND \n";
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

            //aoyama-n 2009-09-14
		    $con_data2["hdn_discount_flg"][$search_row]     = "";
		}
	}
	$con_data2["goods_search_row"]                  = "";

}


/****************************/
//���ꥢ�ܥ��󲡲�����
/****************************/
if($_POST["clear_flg"] == true || $_POST["clear_line"] != ""){

    if($_POST["clear_flg"] == true){
        $min = 1;
        $max = 5;
    }else{
        $min = $_POST["clear_line"];
        $max = $_POST["clear_line"];
    }

	//����������ƽ����
	//for($c=1;$c<=5;$c++){
	for($c=$min; $c<=$max; $c++){

		if($contract_div == '1'){
			for($f=1;$f<=3;$f++){
				$con_data2["form_print_flg".$f][$c]      = "";
				$con_data2["hdn_goods_id".$f][$c]        = "";
				$con_data2["hdn_name_change".$f][$c]     = "";
				$con_data2["form_goods_cd".$f][$c]       = "";
				$con_data2["form_goods_name".$f][$c]     = "";
			}
			$con_data2["form_serv"][$c]             = "";
			$con_data2["form_divide"][$c]           = "";
			$con_data2["official_goods_name"][$c]   = "";
			$con_data2["form_sale_price"][$c]["1"]  = "";
			$con_data2["form_sale_price"][$c]["2"]  = "";
			$con_data2["form_sale_amount"][$c]      = "";
			$con_data2["form_account_price"][$c]    = "";
			$con_data2["form_account_rate"][$c]     = "";
			$con_data2["form_aprice_div[$c]"]       = 1;
            $con_data2["form_ad_offset_radio"][$c]  = "1";
            $con_data2["form_ad_offset_amount"][$c] = "";

            //aoyama-n 2009-09-14
            $con_data2["hdn_discount_flg"][$c]      = "f";
		}

        //���ҽ�󡢤ޤ���FC¦�������ɼ�ϡ��Ķȶ�ۤ�����
        if($contract_div == "1" || $group_kind == "3"){
            $con_data2["form_trade_price"][$c]["1"] = "";
            $con_data2["form_trade_price"][$c]["2"] = "";
            $con_data2["form_trade_amount"][$c]     = "";

		}

		$con_data2["form_issiki"][$c]           = "";
		for($f=1;$f<=3;$f++){
	        $con_data2["form_goods_num".$f][$c]     = "";
		}


/*
		for($j=1;$j<=5;$j++){
			//�����ɼ�ϡ��Ķȶ�ۤΤ߽����
			if($contract_div == '1'){
				$con_data2["break_goods_cd"][$c][$j] = "";
				$con_data2["break_goods_name"][$c][$j] = "";
				$con_data2["break_goods_num"][$c][$j] = "";
				$con_data2["hdn_bgoods_id"][$c][$j] = "";
				$con_data2["hdn_bname_change"][$c][$j] = "";
				$con_data2["break_sale_price"][$c][$j][1] = "";
				$con_data2["break_sale_price"][$c][$j][2] = "";
				$con_data2["break_sale_amount"][$c][$j] = "";
			}
			$con_data2["break_trade_price"][$c][$j][1] = "";
			$con_data2["break_trade_price"][$c][$j][2] = "";
			$con_data2["break_trade_amount"][$c][$j] = "";
		}
*/
	}

	$post_flg2 = true;               //���¶�ʬ�򡢽��������ե饰
	$con_data2["clear_flg"] = "";    //���ꥢ�ܥ��󲡲��ե饰
	$con_data2["clear_line"] = "";  //���ꥢ��󥯲����ե饰
}


/****************************/
//�������
/****************************/

#2009-09-18 hashimoto-y
#plan_data.inc��ͽ��ǡ��������Υե饰���Ϥ�
$plan_edit_flg = 't';
$plan_edit_goods_data = $con_data2;

//�����ޥ���������(���ե���������)
require_once(INCLUDE_DIR."plan_data.inc");


//̤��������Ѥ�������ͳ�������껦�۰ʳ��ե꡼���ʥ���饤����ԡ�
if($trust_confirm_flg == "t" && $contract_div == "2"){
    //�إå������ɲåե꡼��
    //intro_ac_div[] �� plan_data.inc ��Ǥ�äƤޤ�
    $freeze_data = array(
        "form_delivery_day",
        "trade_aord",
        "form_request_day",
        "form_claim",
        "intro_ac_price",
        "intro_ac_rate",
        "form_note",
    );
    //�ǡ��������ɲåե꡼��
    for($i=1; $i<=5; $i++){
        array_push($freeze_data, 
            "form_issiki[$i]",
            "form_goods_num1[$i]",
            "form_goods_num2[$i]",
            "form_goods_num3[$i]"
        );
    }

    $form->freeze($freeze_data);
}


/****************************/
//�ԥ��ꥢ����
/****************************/
/*
if($_POST["clear_line"] != ""){
    Clear_Line_Data2($form, $_POST["clear_line"]);
}
*/


/****************************/
//�����⽸�ץܥ��󲡲�����
/****************************/
if($_POST["ad_sum_button_flg"] == true || $_POST["correction_flg"] == "true"){

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

        $ad_rest_price  = Advance_Offset_Claim($db_con, $count_day, $client_id, $c_data[1]);
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
//�����إå�������
/****************************/
if($_POST["correction_flg"] == true || $_POST["warn_ad_flg"] != null){
//�����ܥ��󤬲����줿�Ȥ�

	/****************************/
    //���顼�����å�(PHP)��������Ƚ��ؿ��ʤ�
    /****************************/
    require_once(INCLUDE_DIR."fc_sale_post_atr.inc");

    /****************************/
    //Ʊ���¹�����
    //���������ѹ�����α�����ľ����
    //�����������ꤵ�줿
    //������������줿
    //�����������𤵤줿
    //���������ǧ���줿
    //���Υ����å����ơ�����Ƥ����������ѹ�����α����Բ�
    /****************************/
    $concurrent_err_flg = false;    //Ʊ���¹ԥ����å��Υ��顼�ե饰���ѹ��������ܥ����ä����ܥ����ɽ����

    $sql = "SELECT confirm_flg, trust_confirm_flg, del_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);

    $chk_confirm_flg        = pg_fetch_result($result, 0, "confirm_flg");       //����ե饰����ԤΤȤ��Ͼ�ǧ��
    $chk_trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg"); //������ե饰
    $chk_del_flg            = pg_fetch_result($result, 0, "del_flg");           //����ե饰

    //��������å�
    //���ҽ��ξ��
    if($contract_div == "1" && $chk_confirm_flg == "t"){
        $err_mess_confirm_flg = "��ɼ�������ꤵ�줿���ᡢ�����Ǥ��ޤ���";
        $error_flg = true;
        $concurrent_err_flg = true;
    //����饤����Ԥ�ľ�ġ��ޤ��ϥ��ե饤����Ԥξ��
    //}elseif((($contract_div == "2" && $group_kind == 2) || $contract_div == "3") && $chk_confirm_flg == "t"){
	}elseif(($contract_div == "2" || $contract_div == "3") && $chk_confirm_flg == "t"){
        $err_mess_confirm_flg = "��ɼ�����ǧ���줿���ᡢ�����Ǥ��ޤ���";
        $error_flg = true;
        $concurrent_err_flg = true;
    //����饤����Ԥ�FC�����������夲����FC�˾��
    //}elseif(($contract_div == "2" && $group_kind != 2) && $chk_trust_confirm_flg == "t"){
    }elseif($contract_div == "2" && $chk_trust_confirm_flg == "t" && $group_kind != "2"){
        $err_mess_confirm_flg = "��ɼ�������𤵤줿���ᡢ�����Ǥ��ޤ���";
        $error_flg = true;
        $concurrent_err_flg = true;
    }

    //�����ɼ�Υ����å�
    if($chk_del_flg == "t"){
        $del_mess = "��ɼ��������줿���ᡢ�ѹ��Ǥ��ޤ���";
        $error_flg = true;
        $concurrent_err_flg = true;
    }

    if($concurrent_err_flg){
        $form->addElement("button","slip_del_ok","�ϡ���","onClick=\"location.href='".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=$back_display'\"");
        $form->freeze();
    }


	$con_data2["correction_flg"] = "";  //�����ܥ��󲡲��ե饰�����
	$con_data2["warn_ad_flg"] = "";     //�ٹ��̵�뤷�������ܥ��󲡲��ե饰�����


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

    $tmp     = Get_Tax_div($db_con, $client_id);
    $tax_franct = $tmp["tax_franct"];                   //ü����ʬ
    #2009-12-22 aoyama-n
    #$tax_num = Get_Tax_Rate($db_con, $client_h_id);     //������Ψ

    #2009-12-22 aoyama-n
    $tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
    $tax_num = $tax_rate_obj->getClientTaxRate($client_id);

    //�Ķȶ�ۤι�׽���
    //���ҽ��ξ���������δݤ�Ƿ׻�
    if($contract_div == "1"){
        $total_money = Total_Amount($trade_amount2, $goods_item_tax_div2, $coax, $tax_franct, $tax_num, $client_id, $db_con);
    //��Ԥξ�硢������δݤ�Ƿ׻�
    }else{
        $total_money = Total_Amount($trade_amount2, $goods_item_tax_div2, $daiko_coax, $tax_franct, $tax_num, $act_id, $db_con);
    }
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

			//rev.1.3 ͽ�������ηٹ�ȶ��Ѥ��뤿�ᥳ���ȥ�����
            // ̵���ѥܥ���
            //$form->addElement("button", "form_ad_warn", "�ٹ��̵�뤷������",
            //    "onClick=\"javascript:Button_Submit('warn_ad_flg', '".$_SERVER["REQUEST_URI"]."', true);\" $disabled"
            //);
            //$form->addElement("hidden", "warn_ad_flg");

        }

    }//������ۥ����å������


    //���ե饤����ԤǸ���ۤξ�硢������۹�פȸ���ۤ��ѹ���ǽ��
    if($contract_div == "3" && $act_div == "2"){
        $act_request_price = $_POST["act_request_price"];       //������ʸ���ۡ�

        //ɬ�ܥ����å�
        $form->addRule('act_request_price', $h_mess[60], "required");
        //���ͥ����å�
        $form->addRule('act_request_price', $h_mess[60], "regex", '/^[0-9]+$/');
        //������۹�פȸ���ۤ��������������å�
        if($cost_money != $act_request_price){
            $form->setElementError("act_request_price", $h_mess[68]);
        }
    }


    $form->validate();
    $error_flg = (count($form->_errors) > 0) ? true : $error_flg;


    //rev.1.3 �ٹ�̵��ܥ��󲡲�����Ƥʤ�����2����ʾ�Υ��Ƥ��뤫�����å�
    if($error_flg == false && $_POST["warn_ad_flg"] == null){
        $b_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m - 2, $delivery_day_d, $delivery_day_y));    //2������
        $a_lump_day = date("Y-m-d", mktime(0, 0, 0, $delivery_day_m + 2, $delivery_day_d, $delivery_day_y));    //2�����
        //2����ʾ�Υ��Ƥ���
        if(($_POST["hdn_former_deli_day"] <= $b_lump_day) || ($_POST["hdn_former_deli_day"] >= $a_lump_day)){
            $warn_lump_change = "���Ϥ���ͽ��������2����ʾ�Υ��Ƥ��ޤ���";
        //�����ϰ���
        }else{
            $warn_lump_change = null;
        }
    }else{
        $warn_lump_change = null;
    }

	//rev.1.3 �����⡢ͽ�������ǻȤ��ٹ�̵��ܥ���
	if($ad_total_warn_mess != null || $warn_lump_change != null){
        // ̵���ѥܥ���
        $form->addElement("button", "form_ad_warn", "�ٹ��̵�뤷������",
            "onClick=\"javascript:Button_Submit('warn_ad_flg', '".$_SERVER["REQUEST_URI"]."', true);\" $disabled"
        );
        $form->addElement("hidden", "warn_ad_flg");
	}


    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    //if($form->validate() && $error_flg == false){
    //if($error_flg == false && $ad_total_warn_mess == null){
	//rev.1.3 ���顼����ʤ���������ٹ𤬽ФƤʤ���ͽ��������2����ʾ�Υ��Ƥ��ʤ�
    if($error_flg == false && $ad_total_warn_mess == null && $warn_lump_change == null){

        //����ͽ��вٰ����Ǻ߸˰�ư�Ѥ�ͽ��ǡ����ϡ��в��Ҹˤ�ô����(�ᥤ��)��ô���Ҹˤ��ѹ�����
        $sql = "SELECT move_flg FROM t_aorder_h WHERE aord_id = $aord_id;";
        $result = Db_Query($db_con, $sql);
        $move_flg = pg_fetch_result($result, 0, 0);     //��ư�ե饰

		Db_Query($db_con, "BEGIN");

		//�����ʬ���̾狼Ƚ��
		if($contract_div == '1'){
			//�̾�

			/****************************/
			//�����إå��������ǡ��������ô���ԡ��������и��ʡ���ʧ����������
			/****************************/
			require_once(INCLUDE_DIR."plan_data_sql.inc");

		}else{
			//�����ɼ

            /****************************/
            //�����إå���������(ľ�ġ��ƣ�ξ���Ȥ⹹���ϣ�)
            /****************************/
            //�����إå�������SQL
            $sql  = "UPDATE t_aorder_h SET \n";

            //�����褬��𤷤Ƥ���Ȱʲ��Ϲ������ʤ�
            if($trust_confirm_flg != "t"){
                $sql .= "    ord_time = '$delivery_day', \n";       //ͽ������
                $sql .= "    trade_id = $trade_aord, \n";           //�����ʬ
            }

            //ľ��Ƚ��
            if($group_kind == 2){
                //ľ��
                if($trust_confirm_flg != "t"){
                    //�����褬��𤷤Ƥ�Ȱʲ��Ϲ������ʤ�
                    $sql .= "    arrival_day = '$request_day', \n"; //������
                    $sql .= "    claim_div = '$claim_div', \n";     //�����ʬ
                    $sql .= "    claim_id = $claim_id, \n";         //������ID
                    $sql .= "    note = '$note', \n";               //����
                }
                if($ad_offset_flg){
                    $sql .= "    advance_offset_totalamount = $ad_offset_total_amount, \n"; //�����껦�۹��
                }else{
                    $sql .= "    advance_offset_totalamount = NULL, \n";
                }
                //���ե饤����ԤǸ���ۤξ�硢����ۤ򹹿�
                if($contract_div == "3" && $act_div == "2"){
                    $sql .= "    act_request_price = $act_request_price, \n";
                }
            }else{
                //FC
                $sql .= "    arrival_day = '$delivery_day', \n";    //��������ͽ��������Ʊ���ˤ����
                $sql .= "    route = $route, \n";               //��ϩ
                $sql .= "    trust_note = '$note', \n";         //����(������)
                //����ͽ��в٤ǰ�ư�Ѥξ��Ͻв��Ҹˤ��ѹ�
                if($move_flg == "t"){
                    $sql .= "    ware_id = (SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$_SESSION["client_id"]."), \n";
                    $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = ";
                    $sql .= "(SELECT ware_id FROM t_attach WHERE staff_id = ".$staff_check[0]." AND shop_id = ".$_SESSION["client_id"].")), \n";
                }
                //�����⤢��ξ�硢�����褬���Ϥ���ͽ���������������ˤ⹹��
                if($ad_offset_flg){
                    $sql .= "    arrival_day = '$delivery_day', \n";
                }
            }

            $sql .= "    reason_cor = '$reason', \n";       //������ͳ
            $sql .= "    change_flg = 't', \n";             //�������ѹ��ե饰
            $sql .= "    slip_flg = 'f', \n";               //��ɼ���ϥե饰
            $sql .= "    slip_out_day = NULL, \n";          //��ɼ������
            $sql .= "    ship_chk_cd = NULL, \n";           //�ѹ������å�������
            $sql .= "    ord_staff_id = $staff_id, \n";     //���ϼ�ID
            /*
             * ����
             * �����ա�������BɼNo.��������ô���ԡ��������ơ�
             * ��2006/10/31��02-024��������suzuki-t���������å�̾��\�ޡ����ɲ� 
             */
            $sql .= "    ord_staff_name = '".addslashes($_SESSION["staff_name"])."', \n";   //���ϼ�̾
            $sql .= "    change_day = CURRENT_TIMESTAMP \n";

            $sql .= "WHERE \n";
            $sql .= "    aord_id = $aord_id \n";
            $sql .= ";";
//print_array($sql);
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            //�ƣ�Ƚ��
            if($group_kind == 3){

				/****************************/
				//���ô���ԥơ��֥���Ͽ
				/****************************/
				$sql  = "DELETE FROM ";
				$sql .= "    t_aorder_staff ";
				$sql .= "WHERE ";
				$sql .= "    aord_id = $aord_id;";
				$result = Db_Query($db_con, $sql);
				if($result === false){
				    Db_Query($db_con, "ROLLBACK;");
				    exit;
				}

				for($c=0;$c<=3;$c++){
					//�����åդ����ꤵ��Ƥ��뤫Ƚ��
					if($staff_check[$c] != NULL){
						//������
						$sql = "SELECT staff_name FROM t_staff WHERE staff_id = ".$staff_check[$c].";";
						$result = Db_Query($db_con, $sql);
						$staff_data = Get_Data($result,3);

						$sql  = "INSERT INTO t_aorder_staff( ";
						$sql .= "    aord_id,";
						$sql .= "    staff_div,";
						$sql .= "    staff_id,";
						$sql .= "    sale_rate, ";
						$sql .= "    staff_name ";
						$sql .= "    )VALUES(";
						$sql .= "    $aord_id,";                          //����ID
						$sql .= "    '$c',";                              //���ô���Լ���
						$sql .= "    ".$staff_check[$c].",";              //���ô����ID
						//���Ψ����Ƚ��
						if($staff_rate[$c] != NULL){
							$sql .= "    ".$staff_rate[$c].",";           //���Ψ
						}else{
							$sql .= "    NULL,";
						}
						$sql .= "    '".$staff_data[0][0]."'";            //ô����̾
						$sql .= ");";
						$result = Db_Query($db_con, $sql);
						if($result === false){
						    Db_Query($db_con, "ROLLBACK");
						    exit;
						}
					}
				}
            }

			/****************************/
			//�����ǡ�������
			/****************************/
			$sale_data = NULL;
			$cost_data = NULL;
            $tax_div   = NULL;
			for($s=1;$s<=5;$s++){
                //���̡��켰����۹���
                //������Ƚ��
				//if($sale_amount[$s] != NULL){
				if($divide[$s] != NULL){
                    //�����ǡ����β��Ƕ�ʬ������ñ��������ñ�������ñ��������ñ���ʼ�����ˡ�����ñ���ʼ�����ˡ����ñ���ʼ�����ˤ����
                    $sql = "SELECT tax_div, buy_price, cost_price, sale_price, trust_buy_price, trust_cost_price, trust_sale_price FROM t_aorder_d WHERE aord_id = $aord_id AND line = $s ;";
                    $result = Db_Query($db_con, $sql);

                    $tax_div[]          = pg_fetch_result($result, 0, "tax_div");           //���Ƕ�ʬ
                    $d_buy_price        = pg_fetch_result($result, 0, "buy_price");         //����ñ��
                    $d_sale_price       = pg_fetch_result($result, 0, "sale_price");        //���ñ��
                    $d_trust_buy_price  = pg_fetch_result($result, 0, "trust_buy_price");   //����ñ���ʼ������

                    //����ñ��
                    if($group_kind == "2" && $contract_div == "3" && $act_div == "2"){
                        //ľ�Ĥǥ��ե饤����ԤǸ���ۤξ���POST����
                        $d_cost_price       = $trade_price[$s];

                        //����ñ���򸶲�ñ����Ʊ����
                        $d_buy_price        = $d_cost_price;
                    }else{
                        //����ʳ���DB����
                        $d_cost_price       = pg_fetch_result($result, 0, "cost_price");
                    }

                    //����ñ���ʼ������
                    if($group_kind == "2"){
                        //ľ�Ĥξ���DB����
                        $d_trust_cost_price = pg_fetch_result($result, 0, "trust_cost_price");
                    }else{
                        //������ξ���POST����
                        $d_trust_cost_price = $trade_price[$s];
                    }
                    //$d_trust_sale_price = pg_fetch_result($result, 0, "trust_sale_price");  //���ñ���ʼ������


                    //��۷׻�����Ƚ��
                    if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] != null){
                    //�켰�������̡��ξ�硢������ۡ��Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
                        //�������
                        $d_buy_amount = bcmul($d_buy_price, $goods_item_num[$s], 2);
                        $d_buy_amount = Coax_Col($daiko_coax, $d_buy_amount);

                        //�Ķȶ��
                        $d_cost_amount = bcmul($d_cost_price, $goods_item_num[$s], 2);
                        $d_cost_amount = Coax_Col($daiko_coax, $d_cost_amount);

                        //�����
                        $d_sale_amount = bcmul($d_sale_price, 1, 2);
                        $d_sale_amount = Coax_Col($coax, $d_sale_amount);

                    //�켰�������̡ߤξ�硢ñ���ߣ�
                    }else if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] == null){
                        //�������
                        $d_buy_amount = bcmul($d_buy_price, 1, 2);
                        $d_buy_amount = Coax_Col($daiko_coax, $d_buy_amount);

                        //�Ķȶ��
                        $d_cost_amount = bcmul($d_cost_price, 1, 2);
                        $d_cost_amount = Coax_Col($daiko_coax, $d_cost_amount);

                        //�����
                        $d_sale_amount = bcmul($d_sale_price, 1, 2);
                        $d_sale_amount = Coax_Col($coax, $d_sale_amount);

                    //�켰�ߡ����̡��ξ�硢ñ���߿���
                    }else if($set_flg[$s] == 'false' && $_POST["form_goods_num1"][$s] != null){
                        //�������
                        $d_buy_amount = bcmul($d_buy_price, $goods_item_num[$s], 2);
                        $d_buy_amount = Coax_Col($daiko_coax, $d_buy_amount);

                        //�Ķȶ��
                        $d_cost_amount = bcmul($d_cost_price, $goods_item_num[$s], 2);
                        $d_cost_amount = Coax_Col($daiko_coax, $d_cost_amount);

                        //�����
                        $d_sale_amount = bcmul($d_sale_price, $goods_item_num[$s], 2);
                        $d_sale_amount = Coax_Col($coax, $d_sale_amount);
                    }


					$sql  = "UPDATE t_aorder_d SET \n";
                    //�����ƥ����
                    if($goods_item_num[$s] != null){
                        $sql .= "    num = ".$goods_item_num[$s].", \n";
                    }else{
                        $sql .= "    num = NULL, \n";
                    }
                    //���ξ��ʿ���
                    if($goods_body_id[$s] != null){
                        $sql .= "    rgoods_num = ".$goods_body_num[$s].", \n";
                    }
                    //�����ʿ���
                    if($goods_expend_id[$s] != null){
                        $sql .= "    egoods_num = ".$goods_expend_num[$s].", \n";
                    }
                    //�켰�ե饰
                    $sql .= "    set_flg = '".$set_flg[$s]."', \n";

                    //ľ�Ĥǥ��ե饤����ԤǸ���ۤξ��ϱĶȸ���������ñ������Ͽ
                    if($group_kind == "2" && $contract_div == "3" && $act_div == "2"){
                        $sql .= "    cost_price = $d_cost_price, \n";   //����ñ��
                        $sql .= "    buy_price = $d_buy_price, \n";     //����ñ��
                    }

                    //������ξ��ϱĶȸ����ʼ�����ˤ���Ͽ
                    if($group_kind == "3"){
                        $sql .= "    trust_cost_price = $d_trust_cost_price, \n";

                    //������ξ��������껦����Ͽ
                    }else{
                        $sql .= "    advance_flg = '".$ad_flg[$s]."', \n";
                        $sql .= ($ad_flg[$s] == "2") ? "    advance_offset_amount = ".$ad_offset_amount[$s].", \n" : "    advance_offset_amount = NULL, \n";
                    }
                    $sql .= "    buy_amount = $d_buy_amount, \n";   //�������
                    $sql .= "    cost_amount = $d_cost_amount, \n"; //�Ķȶ��
                    $sql .= "    sale_amount = $d_sale_amount \n";  //�����

					$sql .= " WHERE \n";
					$sql .= "    line = $s \n";
					$sql .= " AND \n";
					$sql .= "    aord_id = $aord_id \n";
                    $sql .= ";\n";

					$result = Db_Query($db_con, $sql);
					if($result === false){
					    Db_Query($db_con, "ROLLBACK;");
					    exit;
					}

                    //�إå�����Ͽ�����۹��
                    $cost_data[] = $d_cost_amount;  //������ۡ���ȴ��
                    $sale_data[] = $d_sale_amount;  //����ۡ���ȴ��
                    //$buy_data[]  = $d_buy_amount;   //�����ǳ�

				}
			}


			/****************************/
			//�����إå��� ��� ��Ͽ����
			/****************************/
			if($sale_data != NULL){
                $sql = "SELECT tax_franct FROM t_client WHERE client_id = $client_id;";
				$result = Db_Query($db_con, $sql);
				if($result === false){
				    Db_Query($db_con, "ROLLBACK;");
				    exit;
				}
                $tax_franct = pg_fetch_result($result, 0, 0);   //������ξ�����ü����ʬ

                #2009-12-22 aoyama-n
                #$sql  = "SELECT tax_rate_n \n";
                #$sql .= "FROM t_client INNER JOIN t_aorder_h ON t_client.client_id = t_aorder_h.shop_id \n";
                #$sql .= "WHERE aord_id = $aord_id;";
				#$result = Db_Query($db_con, $sql);
				#if($result === false){
				#    Db_Query($db_con, "ROLLBACK;");
				#    exit;
				#}
                #$tax_num = pg_fetch_result($result, 0, 0);      //������ξ�����Ψ�ʸ��ߡ�

                #2009-12-22 aoyama-n
                $sql  = "SELECT shop_id \n";
                $sql .= "FROM t_aorder_h \n";
                $sql .= "WHERE aord_id = $aord_id;";
				$result = Db_Query($db_con, $sql);
				if($result === false){
				    Db_Query($db_con, "ROLLBACK;");
				    exit;
				}
                $toyo_shop_id = pg_fetch_result($result, 0, 0);      //���ۤΥ���å�ID

                #2009-12-22 aoyama-n
                //��Ψ���饹�����󥹥�������
                $act_tax_rate_obj = new TaxRate($toyo_shop_id);
                $act_tax_rate_obj->setTaxRateDay($_POST["form_delivery_day"]["y"]."-".$_POST["form_delivery_day"]["m"]."-".$_POST["form_delivery_day"]["d"]);
                $tax_num = $act_tax_rate_obj->getClientTaxRate($client_id);

				//����ۡ������ǳۤι�׽���
				$total_money  = Total_Amount($sale_data, $tax_div,$coax,$tax_franct,$tax_num,$client_id,$db_con);
				$sale_money   = $total_money[0];
                $tax_money    = $total_money[1];
				//������ۡ�DB�ˤι�׽���
				//$total_money  = Total_Amount($cost_data, $tax_div,$coax,$tax_franct,$tax_num,$client_id,$db_con);
				$total_money  = Total_Amount($cost_data, $tax_div, $daiko_coax, $tax_franct, $tax_num, $act_id, $db_con);
				$cost_money   = $total_money[0];

                //�����إå��θ�����ۡ���ȴ�ˡ�����ۡ���ȴ�ˡ������ǳۤ򹹿�
                //�Ҳ���¤򹹿�
                $sql  = "UPDATE t_aorder_h SET ";
                $sql .= "    net_amount = $sale_money, ";       //����ۡ���ȴ��
                $sql .= "    tax_amount = $tax_money, ";        //�����ǳ�
                $sql .= "    cost_amount = $cost_money, ";      //������ۡ���ȴ��
                if($intro_account_id != NULL){
                    $sql .= "    intro_account_id = $intro_account_id, ";       //�Ҳ������ID
                    $sql .= "    intro_ac_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $intro_account_id), ";       //�Ҳ������CD1
                    $sql .= "    intro_ac_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $intro_account_id), ";       //�Ҳ������CD2
                    $sql .= "    intro_ac_name = (SELECT client_cname FROM t_client WHERE client_id = $intro_account_id), ";    //�Ҳ������̾
                }else{
                    $sql .= "    intro_account_id = NULL, ";    //�Ҳ������ID
                    $sql .= "    intro_ac_cd1 = NULL, ";        //�Ҳ������CD1
                    $sql .= "    intro_ac_cd2 = NULL, ";        //�Ҳ������CD2
                    $sql .= "    intro_ac_name = NULL, ";       //�Ҳ������̾
                }
                $sql .= "    intro_ac_div = '$intro_ac_div', ";             //�Ҳ���¶�ʬ
                if($intro_ac_price != NULL){
                    $sql .= "    intro_ac_price = $intro_ac_price, ";       //�Ҳ����ñ��
                }else{
                    $sql .= "    intro_ac_price = NULL, ";
                }
                if($intro_ac_rate != NULL){
                    $sql .= "    intro_ac_rate = '$intro_ac_rate' ";        //�Ҳ����Ψ
                }else{
                    $sql .= "    intro_ac_rate = NULL ";
                }
                $sql .= "WHERE ";
                $sql .= "    aord_id = $aord_id ";
                $sql .= ";";
//print($sql);

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                //�Ҳ�����׻�
                if($intro_ac_div != "1" && $intro_account_id != null){
                    $intro_amount = FC_Intro_Amount_Calc($db_con, "aord", $aord_id);

                    if($intro_amount === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }else{
                    $intro_amount = null;
                }

                //�Ҳ����򹹿�
                $sql  = "UPDATE t_aorder_h SET ";
                if($intro_amount !== null){
                    $sql .= "    intro_amount = $intro_amount ";    //�Ҳ������
                }else{
                    $sql .= "    intro_amount = NULL ";
                }
                $sql .= "WHERE ";
                $sql .= "    aord_id = $aord_id;";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

			}

            //��۹����ؿ��ʰʲ��Υ����򹹿���
            //�����إå�
            //���Ķȶ�ۡʼ������
            //������ۡʼ������
            //�������ǡʼ������
            //�����ǡ���
            //��������ۡʼ������
            //���Ķȶ�ۡʼ������
            //������ۡʼ������
            $result = Update_Act_Amount($db_con, $aord_id, "aord");
			if($result === false){
			    Db_Query($db_con, "ROLLBACK;");
				exit;
			}


			/****************************/
			//�����ơ��֥빹��
			/****************************/
/*
			for($s=1;$s<=5;$s++){
				//�����ǡ���ID����SQL
				$sql  = "SELECT ";
				$sql .= "    aord_d_id ";
				$sql .= "FROM ";
				$sql .= "    t_aorder_d ";
				$sql .= "WHERE ";
				$sql .= "    aord_id = $aord_id ";
				$sql .= "AND ";
				$sql .= "    line = $s;";
				$result = Db_Query($db_con, $sql);
				$row_num = pg_num_rows($result);

				//�����ǡ���ID¸��Ƚ��
				if($row_num == 1){
					$aord_d_id = pg_fetch_result($result,0,0);    //�����ǡ���ID

					for($d=1;$d<=5;$d++){
						//��������ID�����ꤵ��Ƥ��뤫Ƚ��
						if($break_goods_id[$s][$d] != NULL){
							$sql  = "UPDATE t_aorder_detail SET ";
							$sql .= "    trust_trade_price = ".$break_trade_price[$s][$d].",";       //�Ķȸ���
							$sql .= "    trust_trade_amount = ".$break_trade_amount[$s][$d];         //�Ķȶ��
							$sql .= " WHERE ";
							$sql .= "    line = $d ";
							$sql .= " AND ";
							$sql .= "    aord_d_id = $aord_d_id;";

							$result = Db_Query($db_con, $sql);
							if($result === false){
							    Db_Query($db_con, "ROLLBACK");
							    exit;
							}
						}	
					}
				}
			}
*/
			/****************************/
			//�и��ʺ��
			/****************************/
            $sql  = "DELETE FROM \n";
            $sql .= "    t_aorder_ship \n";
            $sql .= "WHERE \n";
            $sql .= "    aord_d_id IN (SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $aord_id) \n";
            $sql .= ";";

			$result = Db_Query($db_con, $sql);
			if($result === false){
				Db_Query($db_con, "ROLLBACK;");
				exit;
			}

			/****************************/
			//��ʧ�ǡ������
			/****************************/
            $sql  = "DELETE FROM \n";
            $sql .= "    t_stock_hand \n";
            $sql .= "WHERE \n";
            $sql .= "    aord_d_id IN (SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $aord_id) \n";
            $sql .= ";";

			$result = Db_Query($db_con, $sql);
			if($result === false){
				Db_Query($db_con, "ROLLBACK;");
				exit;
			}


			/****************************/
			//�и��ʡ���ʧ�ǡ�����Ͽ
			/****************************/
            for($s=1;$s<=5;$s++){
                if($sale_amount[$s] != NULL){
                    $sql = "SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $aord_id AND line = $s;";
        			$result = Db_Query($db_con, $sql);
		        	if($result === false){
				        Db_Query($db_con, "ROLLBACK;");
        				exit;
		        	}
                    $aord_d_id = pg_fetch_result($result, 0, 0);

                    require(INCLUDE_DIR."plan_data_sql_stock_hand.inc");
                }
            }
		}

		Db_Query($db_con, "COMMIT;"); 

		//ͽ�����٤����ܥܥ���
		header("Location: ".FC_DIR."sale/2-2-106.php?aord_id[0]=$aord_id&aord_id_array=".$array_id."&back_display=$back_display");

/*
		//������������Ƚ��
		switch($back_display){
			case 'cal_month':
				//��������(��)
				header("Location: ".FC_DIR."sale/2-2-101-2.php");
				break;
			case 'cal_week':
				//��������(��)
				header("Location: ".FC_DIR."sale/2-2-102-2.php");
				break;
			case 'confirm':
				//������
				header("Location: ".FC_DIR."sale/2-2-206.php");
				break;
			case 'output':
				//��ɼȯ��
				header("Location: ".FC_DIR."sale/2-2-204.php");
				break;
			case 'count_daily':
				//��������
				header("Location: ".FC_DIR."sale/2-2-113.php");
				break;
			case 'round':
				//���������(������)
				header("Location: ".FC_DIR."system/2-1-237.php");
				break;
			case 'round_act':
				//���������(������)
				header("Location: ".FC_DIR."system/2-1-238.php");
				break;
			Default:
				//̵�����ϡ���������(��)������
				header("Location: ".FC_DIR."sale/2-2-101-2.php");
		}
*/
	}
}


/****************************/
//POST������ͤ��ѹ�
/****************************/
$form->setConstants($con_data2);

($freeze_data != null) ? $form->freeze($freeze_data) : "";


#2009-09-21 hashimoto-y
$freeze_flg = $form->isFrozen();
#echo "freeze_flg:" .$freeze_flg;

if($contract_div == '1' || $hand_slip_flg == true || $hand_plan_flg == true){
}else{
#if($contract_div != '1' || $hand_slip_flg != true || $hand_plan_flg != true){
    #echo "freeze";

    $num = 5;
    $toSmarty_discount_flg = array();
    for ($i=1; $i<=$num; $i++){
        $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
        #2009-09-26 hashimoto-y
        #if($hdn_discount_flg === 't' ||
        #   $trade_sale_select[0] == '13' || $trade_sale_select[0] == '14' || $trade_sale_select[0] == '63' || $trade_sale_select[0] == '64'
        if($hdn_discount_flg === 't'
        ){
            $toSmarty_discount_flg[$i] = 't';
        }else{
            $toSmarty_discount_flg[$i] = 'f';

        }
    }
}



/****************************/
//javascript
/****************************/

//�켰�˥����å����դ�����硢��۷׻�����
$java_sheet  = "function Set_num(row,coax,daiko_coax){ \n";
//ľ�Ĥ������ɼ���������ξ�硢�Ķȸ���������ۤ�Ʊ�ͤ�ñ���ߣ��ˤ���
if($group_kind == "2"){
    $java_sheet .= "    Mult_double2( \n";
    $java_sheet .= "        'form_goods_num1['+row+']', \n";
    $java_sheet .= "        'form_sale_price['+row+'][1]', \n";
    $java_sheet .= "        'form_sale_price['+row+'][2]', \n";
    $java_sheet .= "        'form_sale_amount['+row+']', \n";
    $java_sheet .= "        'form_trade_price['+row+'][1]', \n";
    $java_sheet .= "        'form_trade_price['+row+'][2]', \n";
    $java_sheet .= "        'form_trade_amount['+row+']', \n";
    $java_sheet .= "        'form_issiki['+row+']', \n";
    $java_sheet .= "        coax, \n";
    $java_sheet .= "        false, \n";
    $java_sheet .= "        daiko_coax, \n";
    $java_sheet .= "        '$contract_div', \n";
    $java_sheet .= "        '$act_div' \n";
    $java_sheet .= "    );\n";
}else{
    $java_sheet .= "    Mult_double2( \n";
    $java_sheet .= "        'form_goods_num1['+row+']', \n";
    $java_sheet .= "        'form_sale_price['+row+'][1]', \n";
    $java_sheet .= "        'form_sale_price['+row+'][2]', \n";
    $java_sheet .= "        'form_sale_amount['+row+']', \n";
    $java_sheet .= "        'form_trade_price['+row+'][1]', \n";
    $java_sheet .= "        'form_trade_price['+row+'][2]', \n";
    $java_sheet .= "        'form_trade_amount['+row+']', \n";
    $java_sheet .= "        'form_issiki['+row+']', \n";
    $java_sheet .= "        coax, \n";
    $java_sheet .= "        false, \n";
    $java_sheet .= "        daiko_coax \n";
    $java_sheet .= "    );\n";
}
$java_sheet .= "}\n\n";

//�����
$java_sheet .= <<<DAIKO

//����饤����ԡ����ե饤����Ԥξ�硢�Ķȸ��������Բ�
function daiko_checked(){
	//�Ķȸ���
	document.dateForm.elements["form_trade_price[1][1]"].readOnly = true;
	document.dateForm.elements["form_trade_price[1][2]"].readOnly = true;
	document.dateForm.elements["form_trade_price[2][1]"].readOnly = true;
	document.dateForm.elements["form_trade_price[2][2]"].readOnly = true;
	document.dateForm.elements["form_trade_price[3][1]"].readOnly = true;
	document.dateForm.elements["form_trade_price[3][2]"].readOnly = true;
	document.dateForm.elements["form_trade_price[4][1]"].readOnly = true;
	document.dateForm.elements["form_trade_price[4][2]"].readOnly = true;
	document.dateForm.elements["form_trade_price[5][1]"].readOnly = true;
	document.dateForm.elements["form_trade_price[5][2]"].readOnly = true;

}

DAIKO;

/*
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

//plan_data.inc �� JS ���ɲ�
$java_sheet .= $plan_data_js;


//�ե�����롼�׿�
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�1
$error_loop_num1 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�2
$error_loop_num2 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�3
$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");

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


//print_array($_POST);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);
$smarty->assign('error_loop_num1',$error_loop_num1);
$smarty->assign('error_loop_num2',$error_loop_num2);
$smarty->assign('error_loop_num3',$error_loop_num3);
$smarty->assign('error_msg4',$error_msg4);
$smarty->assign('error_msg5',$error_msg5);
//$smarty->assign('error_msg6',$error_msg6);
//$smarty->assign('error_msg7',$error_msg7);
//$smarty->assign('error_msg8',$error_msg8);
//$smarty->assign('error_msg9',$error_msg9);
$smarty->assign('error_msg10',$error_msg10);
//$smarty->assign('error_msg11',$error_msg11);
//$smarty->assign('error_msg13',$error_msg13);

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'java_sheet'    => "$java_sheet",
	'flg'           => "$flg",
	'last_day'      => "$last_day",
	'error_flg'     => $error_flg,
	'error_msg'     => "$error_msg",
	'error_msg2'    => "$error_msg2",
	'error_msg3'    => "$error_msg3",
	'error_msg12'   => "$error_msg12",
	'error_msg14'   => "$error_msg14",
	'error_msg15'   => "$error_msg15",
	'error_msg16'   => "$error_msg16",
	'ac_name'       => "$ac_name",
	'act_name'      => "$act_name",
	'act_amount'    => "$act_amount",
	'act_div'       => "$act_div",
	'return_flg'    => "$return_flg",
	'get_flg'       => "$get_flg",
	'client_id'     => "$client_id",
	'form_load'     => "$form_load",
	'ware_name'     => "$ware_name",
	'trade_error_flg' => "$trade_error_flg",
	'client_cd'     => "$client_cd ",          
	'client_name'   => "$client_name ",
	'money'         => "$money",
	'tax_money'     => "$tax_money",
	'total_money'   => "$total_money",
	'ord_no'        => "$ord_no",
	'contract_div'  => "$contract_div",
	'group_kind'    => "$group_kind",
	'round_form'    => "$round_form",
	'br_flg'        => "$br_flg",
	'err_mess_confirm_flg'  => "$err_mess_confirm_flg",
	'del_mess'      => "$del_mess",
	'concurrent_err_flg'    => $concurrent_err_flg,
    'ad_total_warn_mess'    => $ad_total_warn_mess,
    'warn_lump_change'      => $warn_lump_change,	//rev.1.3 ͽ�������ٹ��å�����
));

//trade_error_flg�ϸ�Ǻ��


#2009-09-17 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_POST);
//print_array($form->_errors);


?>