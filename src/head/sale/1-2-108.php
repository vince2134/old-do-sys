<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/03��08-067��������watanabe-k�����˥�����������̵����
 * ��2006/11/03��08-073��������watanabe-k��Get�����å��ɲ�
 * ��2006/11/03��08-074��������watanabe-k��Get�����å��ɲ�
 * ��2006/11/03��08-074��������watanabe-k��Get�����å��ɲ�
 * ��2006/11/03��08-141��������watanabe-k��ľ���衢�����ȼ�̾��ά��ɽ�����ѹ�
 * ��2006/11/03��08-146��������watanabe-k������饤�󡢥��ե饤������������ѹ�
 * ��2006/12/01������      ����watanabe-k��ñ�����ڤ�夲���Ƥ���Х��ν���
 *   2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *   2009/09/25  rev.1.2       kajioka-h   �������ϥ��ե饤��ʬǼ�б��������Ȥˤ�ꡢ�������ϸ�����ܥ�����
 *   2009/10/12                hashimoto-y �Ͱ������ʤ��ֻ�ɽ�����ѹ�
 *
 */


$page_title = "����Ȳ�";

//environment setting file �Ķ�����ե�����
require_once("ENV_local.php");

//Create HTML_QuickForm HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³ connect Database
$db_con = Db_Connect();

// ���¥����å� aithority check
$auth       = Auth_Check($db_con);


/****************************/
//�ǡ������ܺ����ؿ� data item creation function
/****************************/
//(������FCȯ��ID) argument:FC ordering number 
function Get_Ord_Item($fc_ord_id){
    //����饤�� is it online order?
    if($fc_ord_id != NULL){
        //����饤�� online order
        $row_item[] = array("No.","���ʥ�����<br>����̾","�вٿ�","����ñ��<br>���ñ��","�������<br>�����");
    }else{
        //���ե饤�� offline order 
        $row_item[] = array("No.","���ʥ�����<br>����̾","�����","����ñ��<br>���ñ��","�������<br>�����");
    }

    return $row_item;
}

/****************************/
//�����ѿ����� acquire external variables 
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$aord_id      = $_GET["aord_id"];             //����ID order ID
$fc_ord_id    = $_GET["fc_ord_id"];           //FCȯ��ID FC ordering ID
$input_flg    = $_GET["input_flg"];           //�������ϼ��� discern order input 
$del_flg      = $_GET["del_flg"];             //ȯ����ä��ե饰 ordering cancellation flag
$add_flg      = $_GET["add_flg"];             //������Ͽ�Ѥߥե饰 order registered flag
$aord_del_flg = $_GET["aord_del_flg"];        //�������ե饰 deleted order flag
$add_del_flg  = $_GET["add_del_flg"];         //�������ե饰 deleted order flag
Get_Id_Check3($_GET[aord_id]);
Get_Id_Check3($_GET[fc_ord_id]);
/****************************/
//����饤����� online process
/****************************/
$aord_id = null;
//���ܸ�Ƚ�� determine where it transitioned from
if($del_flg == true || $aord_del_flg == true || $add_del_flg == true || $add_flg == true){
}elseif($fc_ord_id != NULL){
    //�в�ͽ�����ϲ��� input screen for planned delivery
    $sql  = "SELECT ";
    $sql .= "    aord_id ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "WHERE ";
    $sql .= "    fc_ord_id = $fc_ord_id;";
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ�� determine GET data
    Get_Id_Check($result);

    //����IDʬ�إå����ȥǡ���ɽ�� header and data display of order ID
    while($aord_id_data = pg_fetch_array($result)){
        $aord_id[] = $aord_id_data[0];
    }
}else{
    //�������ϲ��̡�����Ȳ� order input screen��order inquiry
    //���ե饤��ϡ����ɽ�� display 1 item if it's offline
    $num = 1;
    $aord_id[0]      = $_GET["aord_id"];             //����ID order ID
    Get_Id_Check2($aord_id[0]);
}


$html = NULL;     //HTMLɽ���ǡ�������� initialization of HTML display data 
for($s=0;$s<count($aord_id);$s++){
    /****************************/
    //����إå������Ƚ����� order header extraction determination process
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    ps_stat,";
    $sql .= "    client_id ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_h ";
    $sql .= "WHERE ";
    $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s].";";
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ�� determine GET data
    Get_Id_Check($result);

    //������������ acquire process status
    $ps_stat = pg_fetch_result($result,0,0);
    //������ID���� acquire customer ID 
    $client_id = pg_fetch_result($result,0,1);

    //�������������������夫 is the process status after the daily update is done?
    if($ps_stat == '4' && $input_flg != "true"){
        /****************************/
        //����إå����SQL�ʽ��������������������SQL for order header extraction (order process is after the daily update)
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_aorder_h.ord_time,";                        
        $sql .= "    t_aorder_h.hope_day,";
        $sql .= "    t_aorder_h.arrival_day,";
        $sql .= "    t_aorder_h.green_flg,";
        $sql .= "    t_aorder_h.trans_cname,";
        $sql .= "    t_aorder_h.client_cd1,";
        $sql .= "    t_aorder_h.client_cd2,";
        $sql .= "    t_aorder_h.client_cname,";
        $sql .= "    t_aorder_h.direct_cname,";
        $sql .= "    t_aorder_h.ware_name,";
        $sql .= "    CASE t_aorder_h.trade_id";            
        $sql .= "        WHEN '11' THEN '�����'";
        $sql .= "        WHEN '61' THEN '�������'";
        $sql .= "    END,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_aorder_h.note_your,";
        $sql .= "    t_aorder_h.note_my, ";
        $sql .= "    t_aorder_h.net_amount, ";
        $sql .= "    t_aorder_h.tax_amount ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "WHERE ";
        $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s]."";
        $sql .= "    AND";
        $sql .= "    t_aorder_h.ps_stat = '4'";
    }elseif($ps_stat == '1' && $input_flg != 'true' && $fc_ord_id == null){
        header("Location:../top.php");
        exit;
    }else{
        /****************************/
        //����إå������SQL SQL for order header extraction 
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_aorder_h.ord_time,";                        
        $sql .= "    t_aorder_h.hope_day,";
        $sql .= "    t_aorder_h.arrival_day,";
        $sql .= "    t_aorder_h.green_flg,";
//        $sql .= "    t_trans.trans_name,";
//        $sql .= "    t_client.client_cd1,";
//        $sql .= "    t_client.client_cd2,";
//        $sql .= "    t_client.client_name,";
//        $sql .= "    t_direct.direct_name,";
//        $sql .= "    t_ware.ware_name,";
        $sql .= "    t_aorder_h.trans_cname,";
        $sql .= "    t_aorder_h.client_cd1,";
        $sql .= "    t_aorder_h.client_cd2,";
        $sql .= "    t_aorder_h.client_cname,";
        $sql .= "    t_aorder_h.direct_cname,";
        $sql .= "    t_aorder_h.ware_name,";
        $sql .= "    CASE t_aorder_h.trade_id";            
        $sql .= "        WHEN '11' THEN '�����'";
        $sql .= "        WHEN '61' THEN '�������'";
        $sql .= "    END,";
//        $sql .= "    t_staff.staff_name,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_aorder_h.note_your,";
        $sql .= "    t_aorder_h.note_my, ";
        $sql .= "    t_aorder_h.net_amount, ";
        $sql .= "    t_aorder_h.tax_amount ";
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_trans  ";
        $sql .= "    ON t_aorder_h.trans_id   = t_trans.trans_id ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_direct ";
        $sql .= "    ON t_aorder_h.direct_id  = t_direct.direct_id ";

        $sql .= "    INNER JOIN t_client ON t_aorder_h.client_id  = t_client.client_id ";
        $sql .= "    INNER JOIN t_ware   ON t_aorder_h.ware_id    = t_ware.ware_id ";
        $sql .= "    INNER JOIN t_staff  ON t_aorder_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "    t_aorder_h.aord_id = ".$aord_id[$s]."";
        $sql .= "    AND";
        $sql .= "    t_aorder_h.ps_stat <> '4'";
        $sql .= ";";
    }
    $result = Db_Query($db_con,$sql);
    Get_Id_Check($result);
    $h_data_list = Get_Data($result);

    /****************************/
    //����ǡ������SQL SQL for order data extraction
    /****************************/
    $data_sql  = "SELECT ";
    //�������������������夫 is the process status after the daily update
//    if($ps_stat == '4'){
        $data_sql .= "    t_aorder_d.goods_cd,";
//    }else{
//        $data_sql .= "    t_goods.goods_cd,";
//        $data_sql .= "    t_aorder_d.goods_cd,";
//    }
    $data_sql .= "    t_aorder_d.official_goods_name,";
    $data_sql .= "    t_aorder_d.num,";
    $data_sql .= "    t_aorder_d.cost_price,";
    $data_sql .= "    t_aorder_d.sale_price,";
    $data_sql .= "    t_aorder_d.cost_amount,";          
    #2009-10-13 hashimoto-y
    #$data_sql .= "    t_aorder_d.sale_amount ";
    $data_sql .= "    t_aorder_d.sale_amount, ";
    $data_sql .= "    t_goods.discount_flg ";

    $data_sql .= "FROM ";
    $data_sql .= "    t_aorder_d ";
    $data_sql .= "    INNER JOIN t_aorder_h ON t_aorder_d.aord_id = t_aorder_h.aord_id ";
    //��������������������ǤϤʤ� the process status is not after the daily update
    #2010-03-31 hashimoto-y
    #if($ps_stat != '4'){
    #    $data_sql .= "    INNER JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";
    #}
    $data_sql .= "    INNER JOIN t_goods ON t_aorder_d.goods_id = t_goods.goods_id ";

    $data_sql .= "WHERE ";
    $data_sql .= "    t_aorder_d.aord_id = ".$aord_id[$s];
    $data_sql .= " AND ";
    $data_sql .= "    t_aorder_h.shop_id = $shop_id ";
    $data_sql .= "ORDER BY ";
    $data_sql .= "    t_aorder_d.line;";

    $result = Db_Query($db_con,$data_sql);
    /****************************/
    //����ǡ�����ɽ�� display order data
    /****************************/
    //�Թ������ʤ���� create the row item component 
    $row_item = Get_Ord_Item($fc_ord_id);
    //�ԥǡ������ʤ���� create the row data component
    $row_data = Get_Data($result);

    $sale_money                    =   number_format($h_data_list[0][15]);                     //��ȴ��� amount without tax
    $tax_money                     =   number_format($h_data_list[0][16]);                     //������ consumption tax
    $st_money                      =   $h_data_list[0][15] + $h_data_list[0][16];              //�ǹ���� amount with tax
    $st_money                      =   number_format($st_money);

    /****************************/
    //�إå���HTML���� create HTML header 
    /****************************/
    //���꡼����ꤵ��Ƥ��뤫 is it green assigned?
    if($h_data_list[0][4] == 't'){
        $green_flg = "���꡼����ꤢ�ꡡ";
    }else{
        $green_flg = null;
    }

    //���շ����ѹ� change the format of the date
    $form_sale_day                                 =   explode('-',$h_data_list[0][1]);
    $form_hope_day                                 =   explode('-',$h_data_list[0][2]);
    $form_arr_day                                  =   explode('-',$h_data_list[0][3]);

    $html .= "<tr>";
    $html .= "<td>";
/*
    $html .= "<table  class=\"Data_Table\" border=\"1\" width=\"650\">";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�����ֹ�</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][0]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>������</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][6]."  -  ".$h_data_list[0][7]."��".$h_data_list[0][8]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>������</b></td>";
    $html .= "<td class=\"Value\">".$form_sale_day[0]." - ".$form_sale_day[1]." - ".$form_sale_day[2]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>��˾Ǽ��</b></td>";
    if($form_hope_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_hope_day[0]." - ".$form_hope_day[1]." - ".$form_hope_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">��</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�в�ͽ����</b></td>";
    if($form_arr_day[0] != NULL){
        $html .= "<td class=\"Value\" colspan=\"3\">".$form_arr_day[0]." - ".$form_arr_day[1]." - ".$form_arr_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\" colspan=\"3\">��</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�����ȼ�</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$green_flg."��".$h_data_list[0][5]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>ľ����</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][9]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�в��Ҹ�</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][10]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�����ʬ</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][11]."</td>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>ô����</b></td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][12]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�̿���<br>�������谸��</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][13]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\" width=\"100\"><b>�̿���<br>����������</b></td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][14]."</td>";
    $html .= "</tr>";
    $html .= "</table>";
*/
    $html .= "<table class=\"Data_Table\" border=\"1\">";
    $html .= "<col width=\"110\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<col width=\"60\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<col width=\"90\" style=\"font-weight: bold;\">";
    $html .= "<col>"; 
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">�����ֹ�</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][0]."</td>";
    $html .= "<td class=\"Title_Blue\">������</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][6]."  -  ".$h_data_list[0][7]."��".$h_data_list[0][8]."</td>";
    $html .= "<td class=\"Title_Blue\">������</td>";
    $html .= "<td class=\"Value\">".$form_sale_day[0]." - ".$form_sale_day[1]." - ".$form_sale_day[2]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">�����ȼ�</td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$green_flg.$h_data_list[0][5]."</td>";
    $html .= "<td class=\"Title_Blue\">��˾Ǽ��</td>";
    if($form_hope_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_hope_day[0]." - ".$form_hope_day[1]." - ".$form_hope_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">��</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">ľ����</td>";
    $html .= "<td class=\"Value\" colspan=\"3\">".$h_data_list[0][9]."</td>";
    $html .= "<td class=\"Title_Blue\">�в�ͽ����</td>";
    if($form_arr_day[0] != NULL){
        $html .= "<td class=\"Value\">".$form_arr_day[0]." - ".$form_arr_day[1]." - ".$form_arr_day[2]."</td>";
    }else{
        $html .= "<td class=\"Value\">��</td>";
    }
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">�����ʬ</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][11]."</td>";
    $html .= "<td class=\"Title_Blue\">ô����</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][12]."</td>";
    $html .= "<td class=\"Title_Blue\">�в��Ҹ�</td>";
    $html .= "<td class=\"Value\">".$h_data_list[0][10]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">�̿���<br>�������谸��</td>";
    $html .= "<td class=\"Value\" colspan=\"5\">".$h_data_list[0][13]."</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Blue\">�̿���<br>����������</td>";
    $html .= "<td class=\"Value\" colspan=\"5\">".$h_data_list[0][14]."</td>";
    $html .= "</tr>";
    $html .= "</table>";

    $html .= "<br>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td>";
    /****************************/
    //�ǡ���HTML���� create data HTML 
    /****************************/
    //���ܺ��� create items
    $html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">";
    $html .= "<tr align=\"center\">";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][0]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][1]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][2]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][3]."</b></td>";
    $html .= "<td class=\"Title_Blue\" width=\"\"><b>".$row_item[0][4]."</b></td>";
    $html .= "</tr>";

    //�ǡ������� create date
    $num = 1;
    for($x=0;$x<count($row_data);$x++){
        if($row_data[$x][7] == 't'){
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\" style=\"color: red\">$num</td>";
            $html .=    "<td align=\"left\" style=\"color: red\">".$row_data[$x][0]."<br>".$row_data[$x][1]."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][2])."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][3],2)."<br>".number_format($row_data[$x][4],2)."</td>";
            $html .=    "<td align=\"right\" style=\"color: red\">".number_format($row_data[$x][5])."<br>".number_format($row_data[$x][6])."</td>";
            $html .= "</tr>";
        }else{
            $html .= "<tr class=\"Result1\">";
            $html .=    "<td align=\"right\">$num</td>";
            $html .=    "<td align=\"left\">".$row_data[$x][0]."<br>".$row_data[$x][1]."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][2])."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][3],2)."<br>".number_format($row_data[$x][4],2)."</td>";
            $html .=    "<td align=\"right\">".number_format($row_data[$x][5])."<br>".number_format($row_data[$x][6])."</td>";
            $html .= "</tr>";
        }
        $num++;
    }
    $html .= "</table>";
    /****************************/
    //���HTML���� create total HTML
    /****************************/
    $html .= "<table width=\"100%\">";
    $html .= "<tr>";
    $html .= "<td align=\"right\">";
    $html .= "<table class=\"List_Table\" border=\"1\">";
    $html .= "<tr>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>��ȴ���</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$sale_money</td>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>������</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$tax_money</td>";
    $html .= "<td class=\"Title_Pink\" width=\"70\" align=\"center\"><b>�ǹ����</b></td>";
    $html .= "<td class=\"Value\" width=\"100\" align=\"right\">$st_money</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
}


/****************************/
//������� component definition
/****************************/
//���ܸ������å� check the where it transitioned from
if($input_flg == true && $ps_stat != '4'){
    //�������ϲ��� order input screen
    //OK�ܥ��� ok button
    $form->addElement("button", "ok_button", "�ϡ���",
        "onClick=\"location.href='".Make_Rtn_Page("aord")."'\""
    );

    //����饤�󡦥��ե饤��Ƚ�� determin if online or offline    
    $sql  = "SELECT";
    $sql .= "   CASE ";
    $sql .= "       WHEN fc_ord_id IS NOT NULL THEN 't'";
    $sql .= "       ELSE 'f'";
    $sql .= "   END ";
    $sql .= "FROM";
    $sql .= "   t_aorder_h ";
    $sql .= "WHERE";
    $sql .= "   aord_id = $aord_id[0]";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $online_div = (pg_fetch_result($result, 0,0) == 't')? true: false;

    if($online_div === true){    
        //��� back
        $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='1-2-110.php?aord_id=".$aord_id[0]."'\""); 
    }else{
        //��� back
		//rev.1.2 �������ϥ��ե饤�������ܥ����� delete the back button after offline order input
        //$form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='1-2-101.php?aord_id=".$aord_id[0]."'\""); 
    }
    $freeze_flg = true;    //����λ��å�����ɽ���ե饰 flag display order completion message 

}else{
    //OK�ܥ��� ok button
    if ($fc_ord_id != null){
        $form->addElement("button", "ok_button", "�ϡ���",
            "onClick=\"Submit_Page('".Make_Rtn_Page("aord")."');\""
        );
    }
    if($del_flg != true && $aord_del_flg != true && $fc_ord_id == null){
        //��� back
        $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    }
}


/****************************/
//HTML�إå� HTML header 
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� HTML footer 
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('sale','1');

/****************************/
//���̥إå������� create screen header 
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variable
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variable
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html'          => "$html",
    'freeze_flg'    => "$freeze_flg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
s