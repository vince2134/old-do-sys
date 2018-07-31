<?php
/********************************/
//  �ѹ�����
//      ����襳���ɣ�����Ф��ʤ��褦���ѹ�
//
//    (2006-07-07 kaji)
//      shop_gid��ʤ���
//    2006/11/29  �в�ͽ�����������������ʤ�ȯ�����ɽ�������������ʤ�Τ���
/********************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/11��06-092��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-093��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-094��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-053��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-054��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-055��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-095��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-096��������watanabe-k��GET�����å��ɲ�
 * ��2006/11/11��06-058��������watanabe-k��GET�����å��ɲ�
 * ��2006/02/06��      ��������watanabe-k��ȯ������ɽ�����ʤ��褦�˽���
 * ��2007/08/28��      ��������watanabe-k�����ٿ�����Ф�COUNT��SUM�˽���
 * ��2009/08/28��      ������  aoyama-n    �̿����ɽ����
 * ��2009/09/18��      ������  aoyama-n    �Ͱ����ʤξ����ֻ���ɽ����
 *
 */


$page_title = "ȯ��Ȳ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
//������¹Դؿ�
/****************************/
//(�����꡼��̡�������λ�ե饰������������ȯ��ID��DB���ͥ������)
function Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con,$discount_flg){
    $result_count = pg_numrows($result);   //���ǿ�
    $day_flg      = false;                 //Ϣ��ե饰
    $num          = 1;                     //Ϣ��Կ�

    //ȯ��ǡ���ID����
    $data_sql  = "SELECT ";
    $data_sql .= "    t_order_d.ord_d_id ";
    $data_sql .= "FROM ";
    $data_sql .= "    t_order_d ";
    $data_sql .= "    LEFT JOIN ";
    $data_sql .= "        (SELECT";
    $data_sql .= "            t_aorder_d.goods_id,";
    $data_sql .= "            t_aorder_h.arrival_day ";
    $data_sql .= "        FROM ";
    $data_sql .= "            t_aorder_h ";
    $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
    $data_sql .= "        WHERE ";
    $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
    $data_sql .= "        GROUP BY \n";
    $data_sql .= "            t_aorder_d.goods_id, \n";
    $data_sql .= "            t_aorder_h.arrival_day \n";
    $data_sql .= "        )AS t_aorder ";
    $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";  
    $data_sql .= "    LEFT JOIN ";
    $data_sql .= "    (SELECT";        
    $data_sql .= "        ord_d_id,";
//    $data_sql .= "        COUNT(num) AS buy_num";
    $data_sql .= "        SUM(num) AS buy_num";
    $data_sql .= "    FROM ";    
    $data_sql .= "        t_buy_d";
    $data_sql .= "    GROUP BY ord_d_id";    
    $data_sql .= "    ) AS t_buy_d";    
    $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";
    $data_sql .= "WHERE ";
    $data_sql .= "    t_order_d.ord_id = $ord_id ";
    $data_sql .= "ORDER BY ";
    $data_sql .= "    t_order_d.line;";
    $dresult = Db_Query($db_con,$data_sql);
    $id_list = Get_Data($dresult);

    for($i = 0; $i < $result_count; $i++){
        $ord_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
        //Ϣ�뤷���Ԥ���ɽ��
        if($day_flg == true){
            $row[$i-1] = NULL;
            $day_flg = false;
        }
        //�Ԥο�����
        //aoyama-n 2009-09-18
        if($discount_flg[$i] === 't'){
            $font_color = 'color: red; ';
        }else{
            $font_color = 'color: #555555; ';
        }
        #$row[$i][0] = "<tr class=\"Result1\">";
        $row[$i][0] = "<tr class=\"Result1\"i style=\"$font_color\">";

        for($j=0;$j<count($ord_data[$i]);$j++){
            //ȯ���
            if($j==2){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j]);
                $ord_array = $ord_data[$i][$j];
            //����ñ��
            }else if($j==3){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j],2);
                $ord_array = $ord_data[$i][$j];
            //�������
            }else if($j==4){
                $ord_data[$i][$j] = number_format($ord_data[$i][$j]);
                $ord_array = $ord_data[$i][$j];
            //�����в�ͽ����
            }else if($j==5 && $ord_stat=='2'){
                //���ʥ����ɤ�ȯ��ǡ���ID��Ʊ���֡������в�ͽ������Ϣ�뤹��
                if($row[$i-$num][1]==$ord_data[$i][0] && $idrow[$i-$num]==$id_list[$i][0]){
                    //���ιԤ�Ʊ�����Ϣ�뤹��
                    $ord_data[$i][$j] = htmlspecialchars($ord_data[$i][$j]);
                    $row[$i-$num][$j+1] = $row[$i-$num][$j+1]."<br>".$ord_data[$i][$j];
                    //Ϣ�뤷���Ԥ�ɽ�����ʤ�
                    $day_flg = true;
                    $num++;
                }else{
                    $num = 1;
                    $ord_array = $ord_data[$i][$j];
                }
            //ȯ��λ��ͳ
            }else if($j==7 || $j==8){
                if($ord_data[$i][$j] == NULL){
                    $ord_array = "��";
                }else{
                    $ord_array = $ord_data[$i][$j];
                }
            }else{
                $ord_array = $ord_data[$i][$j];
            }

            if($day_flg == false){
                $row[$i][$j+1] = htmlspecialchars($ord_array);
            }
        }
        //ȯ��ǡ���ID
        $idrow[$i] = $id_list[$i][0];
    }
    //�ǽ��Ԥ�Ϣ�뤷���Ԥ�
    if($day_flg == true){
        $row[$i-1] = NULL;
    }

    //NULL�ιԤ����������ʤ�
    for($i = 0; $i < count($row); $i++){
        if($row[$i]!=null){
            $row_data[] = $row[$i];
        }
    }

    return $row_data;
}

/****************************/
//�ǡ������ܺ����ؿ�
/****************************/
//(������λ�ե饰����������)
function Get_Ord_Item($finish_flg,$ord_stat){
    //�����ե饰��true��
    if($finish_flg == 't'){
        //ȯ�������ȯ����դ�
        if($ord_stat == '2'){
            //��������λ�ե饰��� �� ȯ�������ȯ����ա��ξ��
            $row_item[] = array("No.","���ʥ�����<br>����̾","ȯ���","����ñ��","�������","�����в�ͽ����","���ٿ�","ȯ���","ȯ��λ��ͳ");
        }else{
            //��������λ�ե饰������ξ��
            $row_item[] = array("No.","���ʥ�����<br>����̾","ȯ���","����ñ��","�������","���ٿ�","ȯ���","ȯ��λ��ͳ");
        }
    }else{
        //ȯ�������ȯ����դ�
        if($ord_stat == '2'){
            //��������λ�ե饰��� �� ȯ�������ȯ����ա��ξ��
            $row_item[] = array("No.","���ʥ�����<br>����̾","ȯ���","����ñ��","�������","�����в�ͽ����");
        }else{
            //��������λ�ե饰��桡�ξ��
            $row_item[] = array("No.","���ʥ�����<br>����̾","ȯ���","����ñ��","�������");
        }
    }

    return $row_item;
}

//�����ȥץåȥե饰��true�ξ��Τ�
if($_GET[output_flg] == 'true'){
    /****************************/
    //ȯ���ȯ�Խ���
    /****************************/
    $order_sheet  = " function Order_Sheet(hidden1,ord_id,head_flg){\n";
    $order_sheet .= "   var id = ord_id;\n";
    $order_sheet .= "   var hdn1 = hidden1;\n";
    $order_sheet .= "   if(head_flg == 't'){\n";
    $order_sheet .= "       window.open('../../franchise/buy/2-3-105.php?ord_id='+id,'_blank','');\n";
    $order_sheet .= "   }else{\n";
    $order_sheet .= "       window.open('../../franchise/buy/2-3-107.php?ord_id='+id,'_blank','');\n";
    $order_sheet .= "   }\n";
    $order_sheet .= "   document.dateForm.elements[hdn1].value = ord_id;\n";
    $order_sheet .= "   //Ʊ��������ɥ������ܤ���\n";
    $order_sheet .= "   document.dateForm.target=\"_self\";\n";
    $order_sheet .= "   //�����̤����ܤ���\n";
    $order_sheet .= "   document.dateForm.action='#';\n";
    $order_sheet .= "   //POST�������������\n";
    $order_sheet .= "   document.dateForm.submit();\n";
    $order_sheet .= "   return true;\n";
    $order_sheet .= "}\n";
}

/****************************/
//�����ѿ�����
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
//$shop_gid     = $_SESSION[shop_gid];
$ord_id       = $_GET["ord_id"];             //ȯ��ID
Get_Id_Check3($ord_id);
Get_Id_Check2($ord_id);
$online_flg   = $_GET["online_flg"];         //ȯ�����ϥ���饤���̥ե饰
$offline_flg  = $_GET["offline_flg"];        //ȯ�����ϥ��ե饤���̥ե饰
$ord_flg      = $_GET["ord_flg"];            //ȯ��Ȳ��̥ե饰
$output_flg   = $_GET["output_flg"];         //ȯ�����ϥե饰

/****************************/
//�������
/****************************/

//ȯ����
$form->addElement(
    "text","form_send_date","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);


//ȯ����
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_ord_time","form_ord_time");


//����ͽ����
$text="";
$text[] =& $form->createElement("static","y","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","-");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","-");
$form->addGroup( $text,"form_arrival_day","form_arrival_day");

//��˾Ǽ��
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_hope_day","form_hope_day");
    
//ȯ���ֹ�
$form->addElement("static","form_ord_no","","");

//������̾
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//ľ����̾
$form->addElement("static","form_direct_name","","");
//�����Ҹ�
$form->addElement("static","form_ware_name","","");
//�����ʬ
$form->addElement("static","form_trade_ord","","");
//ô����
$form->addElement("static","form_c_staff_name","","");
//�̿���ʻ����谸��
$form->addElement("static","form_note_my","","");
//�̿������������
$form->addElement("static","form_note_your","","");

//����۹��
$form->addElement(
    "text","form_buy_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_buy_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����)
$form->addElement(
        "text","form_buy_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

if($_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){
    //ȯ������
    $first_list  = " SELECT ";
    $first_list .= " t_client.head_flg ";
    $first_list .= " FROM ";
    $first_list .= " t_order_h ";
    $first_list .= " INNER JOIN ";
    $first_list .= " t_client ";
    $first_list .= " ON t_order_h.client_id = t_client.client_id ";
    $first_list .= " WHERE ";
    if($online_flg == 'true'){
        $first_list .= " t_order_h.ord_stat IS NOT NULL";
        $first_list .= "    AND";
    }elseif($offline_flg == 'true'){
        $first_list .= " t_order_h.ord_stat IS NULL";
        $first_list .= "    AND";
    }elseif($ord_flg == 'true'){
        $first_list .= " (t_order_h.ord_stat != '3'";
        $first_list .= " OR";
        $first_list .= " t_order_h.ord_stat IS NULL)";
        $first_list .= " AND";
    }
    $first_list .= "    t_order_h.shop_id = $shop_id";
    $first_list .= "    AND";
    $first_list .= "    t_order_h.ord_id = $ord_id;";
    $result = Db_Query($db_con, $first_list);
    Get_Id_Check($result);
    $head_flg = pg_fetch_result($result,0,0);
}

//onLoad����
//ȯ�����ϥܥ��󤬲���������ܤ��Ƥ������˽���
if($output_flg  == true && $_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){
    $load = "onLoad=\"javascript:Order_Sheet('order_sheet_id',$ord_id,'$head_flg');\"";
}

//ȯ���ȯ��ID
$form->addElement("hidden", "order_sheet_id");

//���ܸ������å�
if($online_flg == true){
    //ȯ�����ϡʥ���饤��˲���
    //OK�ܥ���
    $form->addElement("button", "ok_button", "�ϡ���", "onClick=\"location.href='".Make_Rtn_Page("ord")."'\"");
    $warning = "�ѹ�����ݤˤϡ������˼�ä���ꤷ�Ʋ�������";
    $freeze_flg = true;    //ȯ��λ��å�����ɽ���ե饰
}else if($offline_flg == true){
    //ȯ�����ϡʥ��ե饤��˲���
    //OK�ܥ���
    $form->addElement("button", "ok_button", "�ϡ���", "onClick=\"location.href='".Make_Rtn_Page("ord")."'\"");
    //���
    $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='2-3-102.php?ord_id=$ord_id'\"");
    $freeze_flg = true;    //ȯ��λ��å�����ɽ���ե饰
}else{
    //ȯ��Ȳ����
    if($ord_flg == true){
        //���
        $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"Submit_Page('".Make_Rtn_Page("ord")."')\"");
    }else{
        //���
        $form->addElement("button","return_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    }
}

/****************************/
//ȯ���ȯ�ԥܥ��󲡲�����
/****************************/
if($_POST["order_sheet_id"]!=NULL){

    Db_Query($db_con, "BEGIN");

    $flg_update  = " UPDATE ";
    $flg_update .= "    t_order_h ";
    $flg_update .= "    SET ";
    $flg_update .= "    ord_sheet_flg = 't' ";
    $flg_update .= "    where ";
    $flg_update .= "    ord_id = ".$_POST["order_sheet_id"];
    $flg_update .= ";";

    //�����ǡ������
    $result = @Db_Query($db_con, $flg_update);
    if($result == false){
        Db_Query($db_con, "ROLLBACK");
        exit;
    }
    Db_Query($db_con, "COMMIT");

    $load = NULL;
}

if($_GET[output_flg] != "delete" && $_GET[output_flg] != "finish"){

    /****************************/
    //ȯ��إå������Ƚ�����
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    ord_stat,";
    $sql .= "    ps_stat,";
    $sql .= "    finish_flg ";
    $sql .= "FROM ";
    $sql .= "    t_order_h ";
    $sql .= "WHERE ";
    $sql .= "    t_order_h.ord_id = $ord_id;";
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ��
    Get_Id_Check($result);

    //ȯ���������
    $ord_stat = pg_fetch_result($result,0,0);
    //������������
    $ps_stat = pg_fetch_result($result,0,1);
    //������λ�ե饰����
    $finish_flg = pg_fetch_result($result,0,2);

    //�������������������夫
    if($ps_stat == '4'){
        /****************************/
        //ȯ��إå����SQL�ʽ��������������������
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_order_h.ord_no,";
        $sql .= "    to_char(t_order_h.ord_time, 'yyyy-mm-dd'),";                        
        $sql .= "    t_order_h.hope_day,";
        $sql .= "    t_order_h.arrival_day,";
        $sql .= "    t_order_h.green_flg,";
        $sql .= "    t_order_h.trans_name,";
        $sql .= "    t_order_h.client_cd1,";
//      $sql .= "    t_order_h.client_cd2,";
        $sql .= "    t_order_h.client_cname,";
        $sql .= "    t_order_h.direct_name,";
        $sql .= "    t_order_h.ware_name,";
        $sql .= "    CASE t_order_h.trade_id";            
        $sql .= "        WHEN '21' THEN '�ݻ���'";
        $sql .= "        WHEN '71' THEN '�������'";
        $sql .= "    END,";
        $sql .= "    t_order_h.c_staff_name,";
        $sql .= "    t_order_h.note_my,";
        $sql .= "    t_order_h.note_your, ";
        $sql .= "    t_order_h.net_amount, ";
        $sql .= "    t_order_h.tax_amount, ";
        $sql .= "    to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') ";
        $sql .= "FROM ";
        $sql .= "    t_order_h ";
        $sql .= "WHERE ";
        $sql .= "    t_order_h.ord_id = $ord_id;";
    }else{
        /****************************/
        //ȯ��إå������SQL
        /****************************/
        $sql  = "SELECT ";
        $sql .= "    t_order_h.ord_no,";
        $sql .= "    to_char(t_order_h.ord_time, 'yyyy-mm-dd'),";                        
        $sql .= "    t_order_h.hope_day,";
        $sql .= "    t_order_h.arrival_day,";
        $sql .= "    t_order_h.green_flg,";
//    $sql .= "    t_trans.trans_name,";
//  $sql .= "    t_client.client_cd1,";
//    $sql .= "    t_client.client_name,";
//    $sql .= "    t_direct.direct_name,";
//    $sql .= "    t_ware.ware_name,";
        $sql .= "    t_order_h.trans_name,";
        $sql .= "    t_order_h.client_cd1,";
        $sql .= "    t_order_h.client_cname,";
        $sql .= "    t_order_h.direct_name,";
        $sql .= "    t_order_h.ware_name,";
        $sql .= "    CASE t_order_h.trade_id";            
        $sql .= "        WHEN '21' THEN '�ݻ���'";
        $sql .= "        WHEN '71' THEN '�������'";
        $sql .= "    END,";
//    $sql .= "    t_staff.staff_name,";
        $sql .= "    t_order_h.c_staff_name,";
        $sql .= "    t_order_h.note_my,";
        $sql .= "    t_order_h.note_your,";
        $sql .= "    t_order_h.net_amount, ";
        $sql .= "    t_order_h.tax_amount, ";
        $sql .= "    to_char(t_order_h.send_date, 'yyyy-mm-dd hh24:mi') ";
        $sql .= "FROM ";
        $sql .= "    t_order_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_trans  ";
        $sql .= "    ON t_order_h.trans_id   = t_trans.trans_id ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_direct ";
        $sql .= "    ON t_order_h.direct_id  = t_direct.direct_id ";

        $sql .= "    INNER JOIN t_client ON t_order_h.client_id  = t_client.client_id ";
        $sql .= "    INNER JOIN t_ware   ON t_order_h.ware_id    = t_ware.ware_id ";
        $sql .= "    INNER JOIN t_staff  ON t_order_h.c_staff_id = t_staff.staff_id ";
        $sql .= "WHERE ";
        $sql .= "    t_order_h.ord_id = $ord_id;";
    }
    $result = Db_Query($db_con,$sql);
    $h_data_list = Get_Data($result);
}
//aoyama-n 2009-08-28
//����������̿�������
$sql  = "SELECT ";
$sql .= "    t_aorder_h.note_your ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.fc_ord_id = $ord_id ";
$sql .= "ORDER BY t_aorder_h.arrival_day;";

$result = Db_Query($db_con,$sql);
$array_note_head = Get_Data($result);

//������λ�ե饰��true��
if($finish_flg == 't'){
    //ȯ�������ȯ����դ�
    if($ord_stat == '2'){
        /****************************/
        //ȯ��ǡ���+(�в�ͽ���������ٿ���ȯ��ġ�ȯ��λ��ͳ) ���SQL
        //��������λ�ե饰��� �� ȯ�������ȯ����ա��ξ��
        /****************************/
        $data_sql  = "SELECT ";
        //�������������������夫
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount,";
        $data_sql .= "    t_aorder.arrival_day,";
        $data_sql .= "    COALESCE(t_buy_d.buy_num,0),";
        $data_sql .= "    t_order_d.num - COALESCE(t_buy_d.buy_num,0) AS ord_close_num,";
        $data_sql .= "    t_order_d.reason ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";

        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "        (SELECT";
        $data_sql .= "            t_aorder_d.goods_id,";
        $data_sql .= "            t_aorder_h.arrival_day ";
        $data_sql .= "        FROM ";
        $data_sql .= "            t_aorder_h ";
        $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
        $data_sql .= "        WHERE ";
        $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
        $data_sql .= "        GROUP BY \n";
        $data_sql .= "            t_aorder_d.goods_id, \n";
        $data_sql .= "            t_aorder_h.arrival_day \n";
        $data_sql .= "        )AS t_aorder ";
        $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";
          
        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "    (SELECT";        
        $data_sql .= "        ord_d_id,";
//        $data_sql .= "        COUNT(num) AS buy_num";
        $data_sql .= "        SUM(num) AS buy_num";
        $data_sql .= "    FROM ";    
        $data_sql .= "        t_buy_d";
        $data_sql .= "    GROUP BY ord_d_id";    
        $data_sql .= "    ) AS t_buy_d";    
        $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //��������������������ǤϤʤ�
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //�������������������夫
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
            $data_sql .= "    t_order_d.goods_cd;";
        }
    }else{
        /****************************/
        //ȯ��ǡ���+(���ٿ���ȯ��ġ�ȯ��λ��ͳ) ���SQL
        //��������λ�ե饰������ξ��
        /****************************/
        $data_sql  = "SELECT ";
        //�������������������夫
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount,";
        $data_sql .= "    COALESCE(t_buy_d.buy_num,0),";
        $data_sql .= "    t_order_d.num - COALESCE(t_buy_d.buy_num,0) AS ord_close_num,";
        $data_sql .= "    t_order_d.reason ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";
          
        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "    (SELECT";        
        $data_sql .= "        ord_d_id,";
//        $data_sql .= "        COUNT(num) AS buy_num";
        $data_sql .= "        SUM(num) AS buy_num";
        $data_sql .= "    FROM ";    
        $data_sql .= "        t_buy_d";
        $data_sql .= "    GROUP BY ord_d_id";    
        $data_sql .= "    ) AS t_buy_d";    
        $data_sql .= "    ON t_order_d.ord_d_id = t_buy_d.ord_d_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";

        //��������������������ǤϤʤ�
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //�������������������夫
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }
}else{
    //ȯ�������ȯ����դ�
    if($ord_stat == '2'){
        /****************************/
        //ȯ��ǡ���+(�в�ͽ����) ���SQL
        //��������λ�ե饰��� �� ȯ�������ȯ����ա��ξ��
        /****************************/
        $data_sql  = "SELECT ";
        //�������������������夫
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount, ";
        $data_sql .= "    t_aorder.arrival_day ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";

        $data_sql .= "    LEFT JOIN ";
        $data_sql .= "        (SELECT";
        $data_sql .= "            t_aorder_d.goods_id,";
        $data_sql .= "            t_aorder_h.arrival_day ";
        $data_sql .= "        FROM ";
        $data_sql .= "            t_aorder_h ";
        $data_sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
        $data_sql .= "        WHERE ";
        $data_sql .= "            t_aorder_h.fc_ord_id = $ord_id";
        $data_sql .= "        GROUP BY \n";
        $data_sql .= "            t_aorder_d.goods_id, \n";
        $data_sql .= "            t_aorder_h.arrival_day \n";
        $data_sql .= "        )AS t_aorder ";
        $data_sql .= "    ON t_order_d.goods_id = t_aorder.goods_id ";

        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //��������������������ǤϤʤ�
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //�������������������夫
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }else{
        /****************************/
        //ȯ��ǡ������SQL
        //��������λ�ե饰��桡�ξ��
        /****************************/
        $data_sql  = "SELECT ";
        //�������������������夫
        if($ps_stat == '4'){
            $data_sql .= "    t_order_d.goods_cd,";
        }else{
//            $data_sql .= "    t_goods.goods_cd,";
            $data_sql .= "    t_order_d.goods_cd,";
        }
        $data_sql .= "    t_order_d.goods_name,";
        $data_sql .= "    t_order_d.num,";            
        $data_sql .= "    t_order_d.buy_price,";
        $data_sql .= "    t_order_d.buy_amount ";
        $data_sql .= "FROM ";
        $data_sql .= "    t_order_d ";
        $data_sql .= "    INNER JOIN t_order_h ON t_order_d.ord_id = t_order_h.ord_id ";
        //��������������������ǤϤʤ�
        if($ps_stat != '4'){
            $data_sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
        }

        $data_sql .= "WHERE ";
        $data_sql .= "    t_order_d.ord_id = $ord_id ";
        $data_sql .= "AND ";
        $data_sql .= "    t_order_h.shop_id = $shop_id ";
        $data_sql .= "ORDER BY ";
        //�������������������夫
        if($ps_stat == '4'){
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }else{
//            $data_sql .= "    t_goods.goods_cd;";
//            $data_sql .= "    t_order_d.goods_cd;";
            $data_sql .= "    t_order_d.line;";
        }
    }
}
$result = Db_Query($db_con,$data_sql);

//aoyama-n 2009-09-18
//�Ͱ��ե饰���
$sql  = "SELECT ";
$sql .= "    t_goods.discount_flg ";
$sql .= "FROM ";
$sql .= "    t_order_h INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id ";
$sql .= "    INNER JOIN t_goods ON t_order_d.goods_id = t_goods.goods_id ";
$sql .= "WHERE ";
$sql .= "    t_order_d.ord_id = $ord_id ";
$sql .= "AND ";
$sql .= "    t_order_h.shop_id = $shop_id ";
$sql .= "ORDER BY ";
$sql .= "    t_order_d.line;";
$sql_result = Db_Query($db_con,$sql);
for($i = 0; $i < pg_numrows($sql_result); $i++){
    $discount_flg[] = pg_fetch_result ($sql_result, $i, "discount_flg");
}


/****************************/
//ȯ��ǡ�����ɽ��
/****************************/
//�Թ������ʤ����
$row_item = Get_Ord_Item($finish_flg,$ord_stat);
//�ԥǡ������ʤ����
//aoyama-n 2009-09-18
#$row_data = Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con);
$row_data = Get_Ord_Data($result,$finish_flg,$ord_stat,$ord_id,$db_con,$discount_flg);

/****************************/
//ȯ��إå���ɽ��
/****************************/
//��������
$form_ord_date    = explode('-',$h_data_list[0][1]);
$form_hope_day    = explode('-',$h_data_list[0][2]);
$form_arrival_day = explode('-',$h_data_list[0][3]);

$def_fdata["form_send_date"]                    =   $h_data_list[0][16];                  //ȯ����
$def_fdata["form_ord_no"]                       =   $h_data_list[0][0];                   //ȯ��No.

$def_fdata["form_ord_time"]["y"]                =   $form_ord_date[0];                    //ȯ����(ǯ)
$def_fdata["form_ord_time"]["m"]                =   $form_ord_date[1];                    //ȯ����(��)
$def_fdata["form_ord_time"]["d"]                =   $form_ord_date[2];                    //ȯ����(��)

if($form_hope_day[0] != NULL){
    $def_fdata["form_hope_day"]["y"]            =   $form_hope_day[0]." -";               //��˾Ǽ��(ǯ)
    $def_fdata["form_hope_day"]["m"]            =   $form_hope_day[1]." -";               //��˾Ǽ��(��)
    $def_fdata["form_hope_day"]["d"]            =   $form_hope_day[2];                    //��˾Ǽ��(��)
}

$def_fdata["form_arrival_day"]["y"]             =   $form_arrival_day[0];                 //����ͽ����(ǯ)
$def_fdata["form_arrival_day"]["m"]             =   $form_arrival_day[1];                 //����ͽ����(��)
$def_fdata["form_arrival_day"]["d"]             =   $form_arrival_day[2];                 //����ͽ����(��)

//���꡼�����������ȼ����ʺ���
$text="";
//���꡼����ꤵ��Ƥ��뤫
if($h_data_list[0][4] == 't'){
    $text[] =& $form->createElement("static","green_trans","","");
    $text[] =& $form->createElement("static","","","��");
    $def_fdata["form_trans"]["green_trans"]     =  ($h_data_list[0][4] == 't')? ���꡼����ꤢ�� : null;
}
$text[] =& $form->createElement("static","trans_name","","");
$def_fdata["form_trans"]["trans_name"]          =   $h_data_list[0][5];                      //�����ȼ�
$form->addGroup( $text,"form_trans","form_trans");
              
$def_fdata["form_client"]["cd1"]                =   $h_data_list[0][6];                      //������    
//$def_fdata["form_client"]["cd2"]                =   $h_data_list[0][7];                          
$def_fdata["form_client"]["name"]               =   $h_data_list[0][7];                          

$def_fdata["form_direct_name"]                  =   $h_data_list[0][8];                      //ľ����
$def_fdata["form_ware_name"]                    =   $h_data_list[0][9];                     //�Ҹ�
$def_fdata["form_trade_ord"]                    =   $h_data_list[0][10];                     //�����ʬ
$def_fdata["form_c_staff_name"]                 =   $h_data_list[0][11];                     //ô����
//aoyama-n 2009-08-28
#$def_fdata["form_note_my"]                      =   $h_data_list[0][12];                     //�̿���(������)
#$note_my                     =   $h_data_list[0][12];                     //�̿���(������)
$def_fdata["form_note_my"]                      =   $h_data_list[0][13];                     //�̿���(�����谸�Υ�����)

$def_fdata["form_buy_total"]                    =   number_format($h_data_list[0][14]);      //��ȴ���
$def_fdata["form_buy_tax"]                      =   number_format($h_data_list[0][15]);      //������
$total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];  //�ǹ����
$def_fdata["form_buy_money"]                    =   number_format($total_money);  
//aoyama-n 2009-08-28
$def_fdata["form_note_head"]                    =   $array_note_head;  


$form->setDefaults($def_fdata);

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
    'offline_flg'   => "$offline_flg",
    'order_sheet'   => "$order_sheet",
    'load'          => "$load",
    //aoyama-n 2009-08-28 
    #'note_my'       => "$note_my",
    'freeze_flg'    => "$freeze_flg",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//aoyama-n 2009-08-28
//�̿���ʣƣð���
$smarty->assign('note_head',$array_note_head);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
