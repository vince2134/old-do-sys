<?php
/**
 *
 * POST�μ���������Ͽ�ܥ��󤬲����줿Ƚ�����������ޤǤΥ����å�
 *
 * �ƽи�
 * ��2-2-107��ͽ��ǡ���������
 * ��2-2-201�ʼ����ɼȯ�ԡ�
 * ��2-2-202�������ɼ������
 * ��2-2-118��ͽ�����
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/06/09      ����¾14    kajioka-h   ������
 *  2007/07/17      B0702-073   kajioka-h   ͽ������ɼȯ�ԤǺ���������ɼ������������ɼ�������ˤ��ѹ�����ȡ�������ͳ���ʤ��Ƥ��ѹ��Ǥ���Х�����
 *  2007/08/28                  kajioka-h   �����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ���ˤ���
 *
 */

/****************************/
//POST�ǡ�������
/****************************/
$trade_amount = NULL;                    //�Ķȶ�۽����
$sale_amount = NULL;                     //����۽����

//5��ʬ��������1
for($s=1;$s<=5;$s++){
    $divide[$s]  = $_POST["form_divide"][$s];        //�����ʬ
    $serv_id[$s] = $_POST["form_serv"][$s];          //�����ӥ�ID

    $slip_flg[$s] = $_POST["form_print_flg1"][$s];   //�����ӥ������ե饰1
    if($slip_flg[$s] == NULL){
        $slip_flg[$s] = 'false';
    }else{
        $slip_flg[$s] = 'true';
    }

    $set_flg[$s] = $_POST["form_issiki"][$s];        //�켰�ե饰1
    if($set_flg[$s] == NULL){
        $set_flg[$s] = 'false';
    }else{
        $set_flg[$s] = 'true';
    }

    //�Ķȸ���
    $t_price1[$s] = $_POST["form_trade_price"][$s][1];
    $t_price2[$s] = $_POST["form_trade_price"][$s][2];
    $trade_price[$s] = $t_price1[$s].".".$t_price2[$s];

    //���ñ��
    $s_price1[$s] = $_POST["form_sale_price"][$s][1];
    $s_price2[$s] = $_POST["form_sale_price"][$s][2];
    $sale_price[$s] = $s_price1[$s].".".$s_price2[$s];

    //��۷׻�����Ƚ��
    if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] != null){
    //�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
        //�Ķȶ��
        //�����ɼ�������������Τǰ켰���ξ�硢������׳ۤϸ���ñ����Ʊ��
        //���켰���ΤȤ����ñ��������׳ۤǡ�����ñ�������ñ����������������׳ۡ��������Ḷ����׳�
        //����äơ����̣��Ƿ׻����Ƹ���ñ���Ḷ����׳ۤ���Ͽ
        if($contract_div != "1" && $_POST["act_div"][0] == "3"){
            $trade_amount[$s] = bcmul($trade_price[$s], 1, 2);
        //����ʳ���ñ���߿���
        }else{
            $trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s], 2);
        }
        //$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //�����
        $sale_amount[$s] = bcmul($sale_price[$s], 1,2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);

    //�켰�������̡ߤξ�硢ñ���ߣ�
    }else if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] == null){
        //�Ķȶ��
        $trade_amount[$s] = bcmul($trade_price[$s], 1,2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //�����
        $sale_amount[$s] = bcmul($sale_price[$s], 1,2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);

    //�켰�ߡ����̡��ξ�硢ñ���߿���
    }else if($set_flg[$s] == 'false' && $_POST["form_goods_num1"][$s] != null){
        //�Ķȶ��
        $trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //�����
        $sale_amount[$s] = bcmul($sale_price[$s], $_POST["form_goods_num1"][$s],2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
    }

    //���ꥢ�ܥ��󲡲��ξ�硢���������٤��������ʤ�
    if($post_flg2 != true){
        //���Τ��򤫤�ʤ��������åȤ��Ƥ����ʤ�����������ʤ���
        $aprice_div[$s] = $_POST["form_aprice_div"][$s][0];                //���¶�ʬ
        $con_data2["form_aprice_div[$s]"] = $aprice_div[$s];
    }

    //���¶�ʬȽ��
    if($aprice_div[$s] == 2){
        //������
        $ac_price[$s] = $_POST["form_account_price"][$s];                 //����ñ��
    }else if($aprice_div[$s] == 3){
        //Ψ
        $ac_rate[$s] = $_POST["form_account_rate"][$s];                   //����Ψ
    }

    //����̵���ξ��ϡ�NULL����
    if($ac_price[$s] == NULL){
        $ac_price[$s] = 'NULL';
    }

    //����
    $ad_flg[$s] = $_POST["form_ad_offset_radio"][$s];                   //�����껦�ե饰
    if($ad_flg[$s] == "2"){
        $ad_offset_amount[$s] = $_POST["form_ad_offset_amount"][$s];    //�����껦��
        $ad_offset_total_amount += $ad_offset_amount[$s];
        $ad_offset_flg = true;                                          //�������Ϥ���Ƥ��ե饰
    }

}//5��ʬ��������1�����


//��ԤǼ�����ξ�硢�������Ϥ���Ƥ��뤫�����å�
if($plan_aord_flg && $contract_div != "1" && $_SESSION["group_kind"] == "3"){
    $sql = "SELECT advance_offset_totalamount FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    $ad_offset_flg = (pg_fetch_result($result, 0, "advance_offset_totalamount") != null) ? true : false;
}


$delivery_day_y           = $_POST["form_delivery_day"]["y"];     //������
$delivery_day_m           = $_POST["form_delivery_day"]["m"];
$delivery_day_d           = $_POST["form_delivery_day"]["d"];
$delivery_day = $delivery_day_y."-".$delivery_day_m."-".$delivery_day_d;

$request_day_y           = $_POST["form_request_day"]["y"];      //������
$request_day_m           = $_POST["form_request_day"]["m"];
$request_day_d           = $_POST["form_request_day"]["d"];
$request_day = $request_day_y."-".$request_day_m."-".$request_day_d;

$claim_data = $_POST["form_claim"];                           //������,�������ʬ
$c_data = explode(',', $claim_data);
$claim_id = $c_data[0];                                       //������ID
$claim_div = $c_data[1];                                      //�������ʬ

$note = $_POST["form_note"];                                     //����

$direct_id              = $_POST["form_direct_select"];         //ľ����ID


$intro_account_id       = $_POST["hdn_intro_account_id"];       //�Ҳ������ID
$intro_ac_div_arr = array("1", "2", "3", "4");  //�Ҳ���¶�ʬ��ǧ��

//���ɽ������DB���顢����ʳ���POST��������
if((($plan_aord_flg || ($hand_plan_flg && $plan_sale_flg != true)) && $_POST["check_value_flg"] != "t") || (($plan_sale_flg || $hand_slip_flg) && $_POST["intro_ac_div"][0] != null)){
    $intro_ac_div = (in_array($_POST["intro_ac_div"][0], $intro_ac_div_arr)) ? $_POST["intro_ac_div"][0] : "1";   //�Ҳ���¶�ʬ
}
$intro_ac_price         = $_POST["intro_ac_price"];             //�Ҳ����ñ��
$intro_ac_rate          = $_POST["intro_ac_rate"];              //�Ҳ����Ψ

$con_data2["intro_ac_div[]"] = $intro_ac_div;
$form->setConstants($con_data2);


if($hand_slip_flg == true || $hand_plan_flg == true){
    $act_id = $_POST["hdn_daiko_id"];                       //��Լ�ID

    $act_div_arr = array("1", "2", "3");    //�������ʬ��ǧ��
    $act_div = in_array($_POST["act_div"][0], $act_div_arr) ? $_POST["act_div"][0] : "1";   //�������ʬ
    $act_request_price = $_POST["act_request_price"];       //������ʸ���ۡ�
    $act_request_rate  = $_POST["act_request_rate"];        //������ʡ��
}else{
    $act_id = $_POST["hdn_act_id"];
}


//�����ɼ�ǻȤ�
if($hand_slip_flg == true){
    $ac_staff_id = $_POST["form_ac_staff_select"];  //���ô����

//�����ɼ�ʳ��ǻȤ�
}else{

    $route  = $_POST["form_route_load"][1];      //��ϩ
    $route .= $_POST["form_route_load"][2];

    //���ô��������
    $staff_check = NULL;                         //��ʣȽ������
    $staff_rate = NULL;                          //���Ψ��Ͽ������

    $staff1 = $_POST["form_c_staff_id1"];        //���ô����
    $staff_check[0] = $staff1;
    $rate1 = $_POST["form_sale_rate1"];          //���Ψ��
    $staff_rate[0] = $rate1;

    $staff2 = $_POST["form_c_staff_id2"];        //���ô����
    //�����ͤ�������˽�ʣȽ�����������
    if($staff2 != NULL){
        $staff_check[1] = $staff2;
    }
    $rate2 = $_POST["form_sale_rate2"];          //���Ψ��
    $staff_rate[1] = $rate2;

    $staff3 = $_POST["form_c_staff_id3"];        //���ô����
    //�����ͤ�������˽�ʣȽ�����������
    if($staff3 != NULL){
        $staff_check[2] = $staff3;
    }
    $rate3 = $_POST["form_sale_rate3"];          //���Ψ��
    $staff_rate[2] = $rate3;

    $staff4 = $_POST["form_c_staff_id4"];        //���ô����
    //�����ͤ�������˽�ʣȽ�����������
    if($staff4 != NULL){
        $staff_check[3] = $staff4;
    }
    $rate4 = $_POST["form_sale_rate4"];          //���Ψ��
    $staff_rate[3] = $rate4;


    $trade_aord = $_POST["trade_aord"];         //�����ʬ
    $reason = $_POST["form_reason"];            //������ͳ

}


//5��ʬ��������2
for($s=1;$s<=5;$s++){
    //�����������ƥ�
    $goods_item_id[$s] = $_POST["hdn_goods_id1"][$s];                   //����ID
    //����Ƚ��
    if($goods_item_id[$s] != NULL){

        $goods_item_cd[$s] = $_POST["form_goods_cd1"][$s];              //���ʥ�����
        $goods_item_name[$s] = $_POST["form_goods_name1"][$s];          //����̾��ά�Ρ�
        $official_goods_name[$s] = $_POST["official_goods_name"][$s];   //����̾��������
        $goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //����
        $goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //��ɼ�����ե饰
        if($goods_item_flg[$s] == NULL){
            $goods_item_flg[$s] = 'false';
        }else{
            $goods_item_flg[$s] = 'true';
        }

        $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$s].";";
        $result = Db_Query($db_con, $sql);
        $goods_item_com[$s] = pg_fetch_result($result,0,0);          //�����ʥե饰

        //������Ƚ��
        if($goods_item_com[$s] == 'f'){
            //�����ʤǤ�̵����硢Ǽ�ʥե饰��false
            $goods_item_deli[$s] = 'false';
        }else{
            //�ƹ����ʤξ��ʾ������
            $sql  = "SELECT ";
            $sql .= "    parts_goods_id ";                       //������ID
            $sql .= "FROM ";
            $sql .= "    t_compose ";
            $sql .= "WHERE ";
            $sql .= "    goods_id = ".$goods_item_id[$s].";";
            $result = Db_Query($db_con, $sql);
            $item_parts[$s] = Get_Data($result);

            //�ƹ����ʤο��̼���
            for($i=0;$i<count($item_parts[$s]);$i++){
                $sql  = "SELECT ";
                $sql .= "    t_goods.goods_name,";
                $sql .= "    t_goods.goods_cname,";
                $sql .= "    t_compose.count ";
                $sql .= "FROM ";
                $sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                $sql .= "WHERE ";
                $sql .= "    t_compose.goods_id = ".$goods_item_id[$s]." ";
                $sql .= "AND ";
                $sql .= "    t_compose.parts_goods_id = ".$item_parts[$s][$i][0].";";
                $result = Db_Query($db_con, $sql);
                $item_parts_name[$s][$i] = pg_fetch_result($result,0,0);    //����̾
                $item_parts_cname[$s][$i] = pg_fetch_result($result,0,1);   //ά��
                $parts_num = pg_fetch_result($result,0,2);                  //�����ʤ��Ф������
                $item_parts_num[$s][$i] = $parts_num * $goods_item_num[$s]; //����
            }
        }
    }else{
        //�켰�ե饰�������ƥ���̤Υ��顼Ƚ��ΰ١������ͤ����
        $goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //����
        $goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //��ɼ�����ե饰
        if($goods_item_flg[$s] == NULL){
            $goods_item_flg[$s] = 'false';
        }else{
            $goods_item_flg[$s] = 'true';
        }
    }

    //����������
    $goods_body_id[$s] = $_POST["hdn_goods_id2"][$s];            //����ID
    //����Ƚ��
    if($goods_body_id[$s] != NULL){

        $goods_body_cd[$s] = $_POST["form_goods_cd2"][$s];       //���ʥ�����
        $goods_body_name[$s] = $_POST["form_goods_name2"][$s];   //ά��
        $goods_body_num[$s] = $_POST["form_goods_num2"][$s];     //����

    }else{
        //���ξ��ʡ����̤Υ��顼Ƚ��ΰ١������ͤ����
        $goods_body_num[$s] = $_POST["form_goods_num2"][$s];     //����
    }

    //������������
    $goods_expend_id[$s] = $_POST["hdn_goods_id3"][$s];          //����ID
    //����Ƚ��
    if($goods_expend_id[$s] != NULL){

        $goods_expend_cd[$s] = $_POST["form_goods_cd3"][$s];     //���ʥ�����
        $goods_expend_name[$s] = $_POST["form_goods_name3"][$s]; //����̾
        $goods_expend_num[$s] = $_POST["form_goods_num3"][$s];   //����
        
        $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_expend_id[$s].";";
        $result = Db_Query($db_con, $sql);
        $goods_expend_com[$s] = pg_fetch_result($result,0,0);    //�����ʥե饰

        //������Ƚ��
        if($goods_expend_com[$s] == 'f'){
            //�����ʤǤ�̵����硢Ǽ�ʥե饰��false
            $goods_expend_deli[$s] = 'false';
        }else{
            //�ƹ����ʤξ��ʾ������
            $sql  = "SELECT ";
            $sql .= "    parts_goods_id ";                 //������ID
            $sql .= "FROM ";
            $sql .= "    t_compose ";
            $sql .= "WHERE ";
            $sql .= "    goods_id = ".$goods_expend_id[$s].";";
            $result = Db_Query($db_con, $sql);
            $expend_parts[$s] = Get_Data($result);

            //�ƹ����ʤο��̼���
            for($i=0;$i<count($expend_parts[$s]);$i++){
                $sql  = "SELECT ";
                $sql .= "    t_goods.goods_name,";
                $sql .= "    t_goods.goods_cname,";
                $sql .= "    t_compose.count ";
                $sql .= "FROM ";
                $sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                $sql .= "WHERE ";
                $sql .= "    t_compose.goods_id = ".$goods_expend_id[$s]." ";
                $sql .= "AND ";
                $sql .= "    t_compose.parts_goods_id = ".$expend_parts[$s][$i][0].";";
                $result = Db_Query($db_con, $sql);

                $expend_parts_name[$s][$i] = pg_fetch_result($result,0,0);      //����̾
                $expend_parts_cname[$s][$i] = pg_fetch_result($result,0,1);     //ά��
                $parts_num = pg_fetch_result($result,0,2);                      //�����ʤ��Ф������
                $expend_parts_num[$s][$i] = $parts_num * $goods_expend_num[$s]; //����
            }
        }
    }else{
        //�����ʡ����̤Υ��顼Ƚ��ΰ١������ͤ����
        $goods_expend_num[$s] = $_POST["form_goods_num3"][$s];    //����
    }
}//5��ʬ��������2�����


/****************************/
//���顼�����å�(addRule)
/****************************/
//������
//��ɬ�ܥ����å�
$delivery_day_err = ($hand_slip_flg) ? $h_mess[26] : $h_mess[35];
$form->addGroupRule('form_delivery_day', array(
        'y' => array(
                array($delivery_day_err, 'required'),
        ),
        'm' => array(
                array($delivery_day_err, 'required'),
        ),
        'd' => array(
                array($delivery_day_err, 'required'),
        )
));

//�����ʬ���̾�orľ�ĤΤ�
if($contract_div == '1' || $group_kind == 2){
    //������
    //��ɬ�ܥ����å�
    $form->addGroupRule('form_request_day', array(
            'y' => array(
                    array($h_mess[25], 'required'),
            ),
            'm' => array(
                    array($h_mess[25],'required'),
            ),
            'd' => array(
                    array($h_mess[25],'required'),
            )
    ));
}

//����
//��ʸ���������å�
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note",$h_mess[23],"mb_maxlength","100");


//���ʳ��ξ��˥����å�
if($hand_slip_flg != true){
    //�����ʬ
    //��ɬ�ܥ����å�
    $form->addRule('trade_aord',$h_mess[30],'required');

    //������ͳ
    //��ɬ�ܥ����å���ͽ����ο�����Ͽ���Ϥʤ���
    //if($hand_plan_flg != true || $new_entry != "true"){
    //if($hand_plan_flg != true || $aord_id != null){
    if(!($hand_plan_flg == true && $aord_id == null && $plan_sale_flg != true)){
        $form->addRule('form_reason',$h_mess[36],'required');
    }

    //�����ʬ���̾�or�ƣäΤ�
    if($contract_div == '1' || $group_kind == 3){
        //���ô��������
        //��ɬ�ܥ����å�
        //�ᥤ��
        $form->addRule('form_c_staff_id1',$h_mess[8],'required');
        $form->addRule('form_sale_rate1',$h_mess[8],'required');

        //���֣�
        //��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
        if($staff2 == NULL && $rate2 != NULL){
            $form->addRule('form_c_staff_id2',$h_mess[9],'required');
        }
        if($staff2 != NULL && $rate2 == NULL && ((int)$rate1 + (int)$rate3 + (int)$rate4) != 100){
            $form->addRule('form_sale_rate2',$h_mess[9],'required');
        }

        //���֣�
        //��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
        if($staff3 == NULL && $rate3 != NULL){
            $form->addRule('form_c_staff_id3',$h_mess[10],'required');
        }
        if($staff3 != NULL && $rate3 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate4) != 100){
            $form->addRule('form_sale_rate3',$h_mess[10],'required');
        }

        //���֣�
        //��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
        if($staff4 == NULL && $rate4 != NULL){
            $form->addRule('form_c_staff_id4',$h_mess[11],'required');
        }
        if($staff4 != NULL && $rate4 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate3) != 100){
            $form->addRule('form_sale_rate4',$h_mess[11],'required');
        }

        //��ϩ
        //��ɬ�ܥ����å�
        //��Ⱦ�ѿ��������å�
        $form->addGroupRule('form_route_load', array(
                '1' => array(
                        array($h_mess[18], 'required'),
                        array($h_mess[18], 'numeric')
                ),
                '2' => array(
                        array($h_mess[18],'required'),
                        array($h_mess[18], 'numeric')
                ),
        ));
    }
}//���ʳ������å������


$input_goods_flg = false;   //��������Ƚ��ե饰
for($n=1;$n<=5;$n++){

    //���Ϲ�Ƚ��
    if($divide[$n] != NULL || $slip_flg[$n] == 'true' || $serv_id[$n] != NULL ||$goods_item_flg[$n] == 'true' || $goods_item_id[$n] != NULL || $goods_item_num[$n] != NULL || $set_flg[$n] == 'true' || $t_price1[$n] != NULL || $t_price2[$n] != NULL || $s_price1[$n] != NULL || $s_price2[$n] != NULL || $trade_amount[$n] != NULL || $sale_amount[$n] != NULL || $goods_body_id[$n] != NULL || $goods_expend_id[$n] || $goods_body_num[$n] != NULL || $goods_expend_num[$n] != NULL || $aprice_div[$n] == 2 || $aprice_div[$n] == 3 || $ad_flg[$n] == "2"){
        //�����ʬ
        //��ɬ�ܥ����å�
        $form->addRule("form_divide[$n]",$d_mess[0][$n],'required');

        //�����ӥ��������ƥ�
        //��ɬ�ܥ����å�
        if($serv_id[$n] == NULL && $goods_item_id[$n] == NULL){
            //ξ�����Ϥ��Ƥ��ʤ���票�顼
            $form->addRule("form_serv[$n]",$d_mess[1][$n],'required');
        }else if($serv_id[$n] == NULL && $set_flg[$n] == 'true'){
            if($contract_div == "1"){
                //�켰�˥����å������ꡢ�����ӥ������򤵤�Ƥ��ʤ���票�顼
                $form->addRule("form_serv[$n]",$d_mess[2][$n],'required');
            }else{
                $form->setElementError("form_serv[$n]", $d_mess[26][$n]);
            }
        }

        //���̡��켰
        //��ɬ�ܥ����å�
        if($goods_item_num[$n] == NULL && $set_flg[$n] == 'false' && $serv_id[$n] != NULL){
            //�����ӥ������򤵤�Ƥ�����ˡ�ξ�����Ϥ��Ƥ��ʤ���票�顼
            $form->addRule("form_goods_num1[$n]",$d_mess[3][$n],'required');
        }

        //�Ķȸ��������ñ��
        //��ɬ�ܥ����å�
        //��Ⱦ�ѿ��������å�
        $form->addGroupRule("form_trade_price[$n]", array(
            '1' => array(
                    array($d_mess[5][$n], 'required'),
                    array($d_mess[5][$n], 'numeric')
            ),
            '2' => array(
                    array($d_mess[5][$n],'required'),
                    array($d_mess[5][$n], 'numeric')
            ),
        ));

        $form->addGroupRule("form_sale_price[$n]", array(
            '1' => array(
                    array($d_mess[7][$n], 'required'),
                    array($d_mess[7][$n], 'numeric')
            ),
            '2' => array(
                    array($d_mess[7][$n],'required'),
                    array($d_mess[7][$n], 'numeric')
            ),
        ));

        //���¶�ʬȽ��
        if($aprice_div[$n] == 2){
            //������
            //��ɬ�ܥ����å�
            $form->addRule("form_account_price[$n]",$d_mess[13][$n],'required');
        }else if($aprice_div[$n] == 3){
            //Ψ
            //��ɬ�ܥ����å�
            $form->addRule("form_account_rate[$n]",$d_mess[13][$n],'required');
        }

        //��������Ƚ��ե饰
        $input_goods_flg = true;
    }
}//5�Ծ�������Ƚ�ꤪ���

//�����ƥࡦ����
//��ɬ�ܥ����å�
for($n=1;$n<=5;$n++){
    //����ID����Ƚ��
    if($goods_item_id[$n] != NULL){
        $form->addRule("official_goods_name[$n]", $d_mess[27][$n], 'required'); //�����ƥ�����̾ɬ�ܥ����å�
        $form->addRule("form_goods_name1[$n]", $d_mess[28][$n], 'required');    //�����ƥ�ά��ɬ�ܥ����å�
        $form->addRule("form_goods_num1[$n]",$d_mess[8][$n],'required');        //�����ƥ����ɬ�ܥ����å�
    }
}

//�����ʡ�����
//��ɬ�ܥ����å�
for($n=1;$n<=5;$n++){
    //����ID����Ƚ��
    if($goods_expend_id[$n] != NULL){
        $form->addRule("form_goods_name3[$n]", $d_mess[29][$n], 'required');    //������̾ɬ�ܥ����å�
        $form->addRule("form_goods_num3[$n]",$d_mess[9][$n],'required');
    }
}

//���Ρ�����
//��ɬ�ܥ����å�
for($n=1;$n<=5;$n++){
    //����ID����Ƚ��
    if($goods_body_id[$n] != NULL){
        $form->addRule("form_goods_name2[$n]", $d_mess[30][$n], 'required');    //���ξ���̾ɬ�ܥ����å�
        $form->addRule("form_goods_num2[$n]",$d_mess[10][$n],'required');
    }
}


?>