<?php

/**
 *
 * ��������κ߸˼�ʧ����ư����Υ������ȯ��
 *
 * �������ô���ԥơ��֥롢���и��ʥơ��֥����Ͽ���Ƥ��뤳�Ȥ�����
 * �����������ID��������ʬ�������������ˤ�ä�ɬ�פʥ������ȯ�Ԥ���
 * ���������ξ��ν������ɲá�2006-09-05��
 * ����ԡ��Ҳ���¤μ�ư��������ư������ϸƽи��Υ⥸�塼��ǲ������δؿ���Ƥ�Ǥ�������
 *
 *
 * �ѹ�����
 * 1.1.0 (2006-09-16) kaji
 *   ���Ȥꤢ������������ǥե����2����ѹ�
 * 1.1.1 (2006-09-26) kaji
 *   �������ΤȤ��μ�ʧ���ְ�äƤ����Τ���
 *     ���ϡ�1�����ˡע���2���иˡס������ϡ�2���иˡע���1�����ˡ�
 * 2006-12-12  ���Ͱ��������Ͱ��ϼ�ʧ���ˤ���Ͽ���ʤ��褦�˽��� suzuki
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $sale_id    ���ID
 *
 * @return      bool        ������true
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2006/09/16)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/03/02      ��˾5-2     kajioka-h   �����ɼ�������μ�ʧ������ֽв��Ҹˢ�ô�����Ҹˢ�������פȤ���ή���
 *  2007/03/27      ��˾21¾    kajioka-h   ͽ��ǡ�������������μ�ʧ�ϡְ�������ס������Ͽ�פȤ���������
 *  2007/03/28      ��˾21¾    kajioka-h   ����ͽ��в٤��Ƥ��ʤ�ͽ����ɼ�ϡ��إå��νв��Ҹˤ�ô���Ԥε����Ҹˤ˹�������
 *  2007-06-07                  fukuda      FC_Trade_Query: ���إå�����ǡ�����������ݡ������껦�۹�פ����
 *  2007-06-07                  fukuda      FC_Payin_Query: ���Ǽ������������껦�۹�פ�������ϼ����ʬ�������껦�פ����⤹��
 *  2007/06/09      ����¾14    kajioka-h   �ֳ����פϥץ饹���ֳ����ʡסֳ��Ͱ��פϥޥ��ʥ��������껦����
 *  2007-07-12                  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *
 */
function FC_Trade_Query($db_con, $sale_id)
{
    //���إå�����
    //�����ʬ�������ɼ�ե饰������å�ID���в��Ҹ�ID�����ô���ԡʥᥤ��ˡ���ɼ�ֹ桢���������
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.trade_id, ";      //�����ʬ
    $sql .= "    t_sale_h.contract_div, ";  //�����ʬ
    $sql .= "    t_sale_h.hand_slip_flg, "; //�����ɼ�ե饰
    $sql .= "    t_sale_h.client_id, ";     //������ID
    $sql .= "    t_sale_h.ware_id, ";       //�в��Ҹ�ID
    $sql .= "    t_sale_h.shop_id, ";       //����å�ID
    $sql .= "    t_sale_h.act_id, ";        //������ID
    $sql .= "    t_sale_staff.staff_id, ";  //���ô����ID�ʥᥤ���
    $sql .= "    t_sale_h.sale_no, ";       //��ɼ�ֹ�
    $sql .= "    t_sale_h.aord_id, ";       //����ID
    $sql .= "    t_sale_h.net_amount, ";    //����ۡ���ȴ��
    $sql .= "    t_sale_h.tax_amount, ";    //�����ǳۡ���ȴ��
    $sql .= "    t_sale_h.sale_day, ";      //�����
    $sql .= "    t_sale_h.claim_day, ";     //������
    $sql .= "    t_sale_h.advance_offset_totalamount, ";    // �����껦�۹�ס�2007-06-07 fukuda��
    $sql .= "    t_sale_h.claim_div ";                      // �������ʬ��2007-06-12 fukuda��
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "        AND t_sale_staff.staff_div ='0' ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id ";
    $sql .= ";";
//echo "$sql<br>";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //�쥳���ɤ�¸�ߤ��ʤ����Ͻ��������
    if(pg_num_rows($result) == 0){
        return true;
    }

    $trade_id      = pg_fetch_result($result, 0, "trade_id");       //�����ʬ
    $contract_div  = pg_fetch_result($result, 0, "contract_div");   //�����ʬ
    $hand_slip_flg = pg_fetch_result($result, 0, "hand_slip_flg");  //�����ɼ�ե饰
    $client_id     = pg_fetch_result($result, 0, "client_id");      //������ID
    $ware_id       = pg_fetch_result($result, 0, "ware_id");        //�в��Ҹ�ID����ɼ�Ρ�
    $shop_id       = pg_fetch_result($result, 0, "shop_id");        //����å�ID����Ԥξ��ϰ�����ID��
    $act_id        = pg_fetch_result($result, 0, "act_id");         //������ID
    $staff_id      = pg_fetch_result($result, 0, "staff_id");       //���ô����ID�ʥᥤ���
    $slip_no       = pg_fetch_result($result, 0, "sale_no");        //��ɼ�ֹ�
    $aord_id       = pg_fetch_result($result, 0, "aord_id");        //����ID
    $net_amount    = pg_fetch_result($result, 0, "net_amount");     //����ۡ���ȴ��
    $tax_amount    = pg_fetch_result($result, 0, "tax_amount");     //�����ǳۡ���ȴ��
    $sale_day      = pg_fetch_result($result, 0, "sale_day");       //�����
    $claim_day     = pg_fetch_result($result, 0, "claim_day");      //������
    $advance_offset= pg_fetch_result($result, 0, "advance_offset_totalamount");     // �����껦�۹�ס�2007-06-07 fukuda��
    $claim_div     = pg_fetch_result($result, 0, "claim_div");                      // �������ʬ��2007-06-12 fukuda��

    $branch_id     = Get_Branch_Id($db_con, $staff_id);             //���ô���Ԥλ�ŹID
    $staff_bases_ware_id = Get_Ware_Id($db_con, $branch_id);        //���ô���Ԥε����Ҹ�ID
    $staff_ware_id = Get_Staff_Ware_Id($db_con, $staff_id);         //���ô���Ԥ�ô���Ҹ�ID

    //����إå��ξ���ͽ��в٥ե饰����
    $sql  = "SELECT t_aorder_h.move_flg \n";
    $sql .= "FROM t_aorder_h INNER JOIN t_sale_h ON t_aorder_h.aord_id = t_sale_h.aord_id \n";
    $sql .= "WHERE t_sale_h.sale_id = $sale_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $move_flg = ($hand_slip_flg == "f") ? pg_fetch_result($result, 0, "move_flg") : "f";    //����ͽ��в٥ե饰

    //���ǡ���ID����
    $sql = "SELECT sale_d_id FROM t_sale_d WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $count = pg_num_rows($result);
    for($i=0;$i<$count;$i++){
        $sale_d_id[$i] = pg_fetch_result($result, $i, "sale_d_id");
    }


    //�����ʬ��2�֥���饤����ԡפǡ�������ξ��ʽ�����ˤϤޤ���ʧ�Ͻ񤫤ʤ�
    //�����ʬ��3�֥��ե饤����ԡפξ��ϼ�ʧ�Ͻ񤫤ʤ�
    //if(($contract_div == "2" && $_SESSION["group_kind"] == "2") || $contract_div != 3){

    //�����ʬ��1�ּ��ҽ��פΤȤ��Τ�
    if($contract_div == "1"){

        //ͽ����ɼ�ξ��
        if($hand_slip_flg == "f"){
            //����ͽ��в٤��Ƥ��ʤ����ϡ�����إå������إå��νв��Ҹˤ򸽻�����ô���Ԥε����Ҹˤ˹���
            if($move_flg == "f"){
                $sql  = "UPDATE t_aorder_h SET \n";
                $sql .= "    ware_id = $staff_bases_ware_id , \n";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $staff_bases_ware_id) \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = (SELECT aord_id FROM t_sale_h WHERE sale_id = $sale_id) \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    return false;
                }

                $sql  = "UPDATE t_sale_h SET \n";
                $sql .= "    ware_id = $staff_bases_ware_id , \n";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $staff_bases_ware_id) \n";
                $sql .= "WHERE \n";
                $sql .= "    sale_id = $sale_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    return false;
                }
            }

            //����μ�ʧ�ʰ����ˤ����ƺ��
            $sql  = "DELETE FROM t_stock_hand \n";
            $sql .= "WHERE aord_d_id IN ( \n";
            $sql .= "    SELECT \n";
            $sql .= "        t_aorder_d.aord_d_id \n";
            $sql .= "    FROM \n";
            $sql .= "        t_sale_h \n";
            $sql .= "        INNER JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
            $sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
            $sql .= "    WHERE \n";
            $sql .= "        t_sale_h.sale_id = $sale_id \n";
            $sql .= "    ) \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }
        }


        //���ǡ���IDʬ�롼��
        for($i=0;$i<$count;$i++){

            //�и��ʥơ��֥뤫�龦��ID�����̤����
            $sql  = "SELECT ";
            $sql .= "    goods_id, ";
            $sql .= "    num ";
            $sql .= "FROM ";
            $sql .= "    t_sale_ship ";
            $sql .= "WHERE ";
            $sql .= "    sale_d_id = ".$sale_d_id[$i]." ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }

            $ship_count = pg_num_rows($result);
            //�и��ʥơ��֥�ʬ�롼��
            for($j=0;$j<$ship_count;$j++){

                $goods_id = pg_fetch_result($result, $j, "goods_id");
                $num      = pg_fetch_result($result, $j, "num");


                //�����ʬ���Ȥν���
                switch($trade_id){
                    case "11":
                    case "15":
                    case "61":
                        //����塢�ޤ��ϳ������ξ��
                        //�������ξ��

                        //�����ɼ�ξ��
                        if($hand_slip_flg == 't'){

                            //���إå��νв��Ҹˡʵ����Ҹˡˤ���ô���Ҹˤˡְ�ư��
                            //�в��Ҹˤ���ְ�ư�פǡֽиˡ�
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "5",        //��ư
                                //$client_id, 
                                null, 
                                $ware_id,   //�в��Ҹ�
                                "2",        //�и�
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }

                            //ô���Ҹˤءְ�ư�פǡ����ˡ�
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "5",        //��ư
                                //$client_id, 
                                null, 
                                $staff_ware_id,     //ô���Ҹ�
                                "1",        //����
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }

                            //ô�����Ҹˤ�������פǡֽиˡ�
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "2",        //���
                                $client_id, 
                                $staff_ware_id,     //ô���Ҹ�
                                "2",        //�и�
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }


                        //�����ɼ����ʤ����
                        }else{
/*
                            //��ʧ�ˡְ����פ�ֽиˡ�
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "1",        //����
                                //null, 
                                $client_id, 
                                $ware_id,   //�в��Ҹ�
                                //"2", 
                                "1",    //��äѤ�����ϡ����ˡס�
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }
*/
                            if($move_flg == "t"){
                                //����ͽ��в٤��Ƥ����硢ô���Ҹˤ�������פǡֽиˡ�
                                $return = FC_Trade_Stock_hand_Query(
                                    $db_con, 
                                    $goods_id, 
                                    $sale_day, 
                                    "2",        //���
                                    $client_id, 
                                    $staff_ware_id, //ô���Ҹ�
                                    "2",        //�и�
                                    $num, 
                                    $slip_no, 
                                    $sale_d_id[$i], 
                                    $_SESSION["staff_id"], 
                                    $shop_id
                                );
                            }else{
                                //����ͽ��в٤��Ƥ��ʤ���硢�в��Ҹˤ�������פǡֽиˡ�
                                $return = FC_Trade_Stock_hand_Query(
                                    $db_con, 
                                    $goods_id, 
                                    $sale_day, 
                                    "2",        //���
                                    $client_id, 
                                    $ware_id,   //�в��Ҹ�
                                    "2",        //�и�
                                    $num, 
                                    $slip_no, 
                                    $sale_d_id[$i], 
                                    $_SESSION["staff_id"], 
                                    $shop_id
                                );
                            }
                            if($return === false){
                                return false;
                            }

                        }//�����ɼ����ʤ���罪���

                        break;

                    case "13":
                    case "63":
                        //�����ʤξ��
                        //�������ʤξ��
                        //�в��Ҹˤ�������פǡ����ˡ�
                        $return = FC_Trade_Stock_hand_Query(
                            $db_con, 
                            $goods_id, 
                            $sale_day, 
                            "2",        //���
                            $client_id, 
                            $ware_id,   //�в��Ҹ�
                            "1",        //����
                            $num, 
                            $slip_no, 
                            $sale_d_id[$i], 
                            $_SESSION["staff_id"], 
                            $shop_id
                        );

                        if($return === false){
                            return false;
                        }

                        //�����ɼ�����ʤ��Τǡ������ν����ϥʥ�

                        break;

                    case "14":
                    case "64":
                        //���Ͱ��ξ��
                        //�����Ͱ��ξ��
/*
                        //��ʧ�˽и��ʥơ��֥�ξ��ʤ�����פǡֽиˡ�
                        $return = FC_Trade_Stock_hand_Query(
                            $db_con, 
                            $goods_id, 
                            $sale_day, 
                            "2", 
                            $client_id, 
                            $ware_id, 
                            "2", 
                            $num, 
                            $slip_no, 
                            $sale_d_id[$i], 
                            $_SESSION["staff_id"], 
                            $shop_id
                        );

                        if($return === false){
                            return false;
                        }

                        //�����ɼ�����ʤ��Τǡ������ν����ϥʥ�
*/
                        break;

                }//�����ʬ���Ȥν���

            }//�и��ʥơ��֥�ʬ�Υ롼�׽����

        }//���ǡ���IDʬ�롼�׽����

    }//��ʧ���������



    //�����ʬ���ָ���פξ��ϼ�ư������򤪤���
    if($trade_id == "61" || $trade_id == "63" || $trade_id == "64"){
        //�����ʬ����63���������ʡפޤ��ϡ�64�������Ͱ��פξ��ϥޥ��ʥ�������
        if($trade_id == "63" || $trade_id == "64"){
            $pay_amount = ($net_amount + $tax_amount) * (-1);
        }else{
            $pay_amount = ($net_amount + $tax_amount);
        }

        //����ơ��֥�ˡָ��������
        $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $shop_id);
        if($return === false){
            return false;
        }

    // �����ʬ���ֳݡסʳ��ꤸ��ʤ��ˡ����������껦�ۤ�������
    }elseif($trade_id != "15" && $advance_offset != null){
        //�����ʬ���ֳ����ʡפޤ��ϡֳ��Ͱ��פξ��ϥޥ��ʥ�������
        if($trade_id == "13" || $trade_id == "14"){
            $advance_offset = $advance_offset * (-1);
        }
        //����ơ��֥�ˡ������껦��
        $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $shop_id, $advance_offset, $claim_div);
    }

    //�����ʬ���ֳ������פξ��ϳ������ơ��֥��2�����ǤȤꤢ������Ͽ
    if($trade_id == "15"){
        //ʬ����
        $sql = "UPDATE t_sale_h SET total_split_num = 2 WHERE sale_id = $sale_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

        $claim_day_arr = explode("-", $claim_day);
        //ʬ��ơ��֥�
        $division_array = Division_Price($db_con, $client_id, ($net_amount + $tax_amount), $claim_day_arr[0], $claim_day_arr[1]);
        for($k=0;$k<2;$k++){
            $sql  = "INSERT INTO \n";
            $sql .= "    t_installment_sales \n";
            $sql .= "( \n";
            $sql .= "    installment_sales_id, \n";
            $sql .= "    sale_id, \n";
            $sql .= "    collect_day, \n";
            $sql .= "    collect_amount \n";
            $sql .= ") VALUES ( \n";
            $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
            $sql .= "    $sale_id, \n";
            $sql .= "    '".$division_array[1][$k]."', \n";
            $sql .= "    ".$division_array[0][$k]." \n";
            $sql .= ") \n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }
        }
    }else{
        //�������ʳ���ʬ����������
        $sql = "UPDATE t_sale_h SET total_split_num = null WHERE sale_id = $sale_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
    }


    return true;

}



/**
 *
 * �߸˼�ʧ����Ͽ���륯�����ȯ��
 *
 * ������
 * 1.0.0 (2006/08/18) kaji
 *   ����������
 * 1.0.1 (2006/10/12) kaji
 *   ����ʧ��ά�Τ�Ĥ��褦��
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $goods_id   ����ID
 * @param       string      $sale_day   ��ȼ»������������
 * @param       string      $work_div   ��ȶ�ʬ
 * @param       int         $client_id  ������ID
 * @param       int         $ware_id    �Ҹ�ID
 * @param       string      $io_div     ���и˶�ʬ
 * @param       int         $num        ��ư��
 * @param       string      $slip_no    ��ɼ�ֹ�
 * @param       int         $sale_d_id  ���ǡ���ID
 * @param       int         $staff_id   �����å�ID�ʺ�ȼ�ID��
 * @param       int         $shop_id    ����å�ID
 *
 * @return      bool        ������true
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.1 (2006/10/12)
 *
 */
function FC_Trade_Stock_hand_Query($db_con, $goods_id, $sale_day, $work_div, $client_id, $ware_id, $io_div, $num, $slip_no, $sale_d_id, $staff_id, $shop_id)
{
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.client_cname ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_d.sale_d_id = ".$sale_d_id." ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $client_cname = pg_fetch_result($result, 0, 0);     //ά��
	$client_cname = addslashes($client_cname);

    $sql  = "INSERT INTO t_stock_hand ( ";
    $sql .= "    goods_id, ";
    $sql .= "    enter_day, ";
    $sql .= "    work_day, ";
    $sql .= "    work_div, ";
    if($client_id != null){
        $sql .= "    client_id, ";
        $sql .= "    client_cname, ";
    }
    $sql .= "    ware_id, ";
    $sql .= "    io_div, ";
    $sql .= "    num, ";
    $sql .= "    slip_no, ";
    $sql .= "    sale_d_id, ";
    $sql .= "    staff_id, ";
    $sql .= "    shop_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    ".$goods_id.", ";
    $sql .= "    CURRENT_TIMESTAMP, ";
    $sql .= "    '$sale_day', ";
    $sql .= "    '$work_div', ";
    if($client_id != null){
        $sql .= "    ".$client_id.", ";
        $sql .= "    '".$client_cname."', ";
    }
    $sql .= "    ".$ware_id.", ";
    $sql .= "    '$io_div', ";
    $sql .= "    ".$num.", ";
    $sql .= "    '".$slip_no."', ";
    $sql .= "    ".$sale_d_id.", ";
    $sql .= "    ".$staff_id.", ";
    $sql .= "    ".$shop_id." ";
    $sql .= "); ";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}



/**
 *
 * ����ơ��֥����Ͽ���륯�����ȯ��
 *
 * �ѹ�����
 * 1.0.1 (2006-09-26) kaji
 *   ��ô���ԥ�����ac_staff_xx�ˤ��齸��ô��������collect_staff_xx�ˤ��ѹ�
 *
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $sale_id    ���ID
 * @param       int         $client_id  ������ID
 * @param       int         $amount     �����
 * @param       string      $sale_day   ���������������
 * @param       int         $shop_id    ����å�ID
 * @param       int         $advance_offset     �����껦�۹�סʤʤ�����null��
 * @param       str         $claim_div          �������ʬ�ʤʤ�����null��
 *
 * @return      bool        ������true
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/18)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/05/23      xx-xxx      kajioka-h   �����ɼ�θ���������ǽ�ˤʤä�
 *
 */
function FC_Payin_Query($db_con, $sale_id, $client_id, $amount, $sale_day, $shop_id, $advance_offset = null, $claim_div = null)
{
    //����ID�����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $pay_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //�����ֹ����Ƚ��
    if($_SESSION["group_kind"] == '2'){
        //ľ��

        //�����ͤ���ɼ�ֹ����
        $sql  = "SELECT ";
        $sql .= "    MAX(pay_no) ";
        $sql .= "FROM ";
        $sql .= "    t_payin_no_serial;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $pay_no = pg_fetch_result($result, 0, 0) + 1;
        $pay_no = str_pad($pay_no, 8, '0', STR_PAD_LEFT);   //�����ֹ�

        //���ߤκ����ͤ򹹿�
        $sql  = "INSERT INTO t_payin_no_serial VALUES('$pay_no');";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

    }else{ 
        //FC

        $sql  = "SELECT ";
        $sql .= "    MAX(pay_no) ";
        $sql .= "FROM ";
        $sql .= "    t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "    shop_id = $shop_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $pay_no = pg_fetch_result($result, 0, 0) + 1;
        $pay_no = str_pad($pay_no, 8, '0', STR_PAD_LEFT);   //�����ֹ�
    }


    //��Ԥξ�������
    $sql  = "SELECT \n";
    $sql .= "    contract_div, \n";
    $sql .= "    act_id, \n";
    $sql .= "    act_cd1, \n";
    $sql .= "    act_cd2, \n";
    $sql .= "    act_name1, \n";
    $sql .= "    act_cname \n";
    $sql .= "FROM \n";
    $sql .= "    t_sale_h \n";
    $sql .= "WHERE \n";
    $sql .= "    sale_id = $sale_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    $contract_div = pg_fetch_result($result, 0, "contract_div");
    if($contract_div != "1"){
        $act_id     = pg_fetch_result($result, 0, "act_id");
        $act_cd1    = pg_fetch_result($result, 0, "act_cd1");
        $act_cd2    = pg_fetch_result($result, 0, "act_cd2");
        $act_name   = pg_fetch_result($result, 0, "act_name1");
        $act_cname  = pg_fetch_result($result, 0, "act_cname");
    }


    $sql  = "INSERT INTO ";
    $sql .= "   t_payin_h ";
    $sql .= "( ";
    $sql .= "    pay_id, ";
    $sql .= "    pay_no, ";
    $sql .= "    pay_day, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_cname, ";
/*
    $sql .= "    c_bank_cd, ";
    $sql .= "    c_bank_name, ";
    $sql .= "    c_b_bank_cd, ";
    $sql .= "    c_b_bank_name, ";
    $sql .= "    c_deposit_kind, ";
    $sql .= "    c_account_no, ";
*/
    $sql .= "    claim_div, ";
    //$sql .= "    bill_id, ";
    //$sql .= "    claim_cd1, ";
    //$sql .= "    claim_cd2, ";
    //$sql .= "    claim_cname, ";
    $sql .= "    input_day, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    //2006-09-26 kaji ô���ԥ���फ�齸��ô���������ѹ�
    //$sql .= "    ac_staff_id, ";      //���ô����(�ᥤ��)��ID
    //$sql .= "    ac_staff_name, ";    //���ô����(�ᥤ��)��̾��
    $sql .= "    collect_staff_id, ";      //���ô����(�ᥤ��)��ID
    $sql .= "    collect_staff_name, ";    //���ô����(�ᥤ��)��̾��
    $sql .= "    act_client_id, ";
    $sql .= "    act_client_cd1, ";
    $sql .= "    act_client_cd2, ";
    $sql .= "    act_client_name, ";
    $sql .= "    act_client_cname, ";
    $sql .= "    sale_id, ";
    $sql .= "    shop_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    $pay_id, ";
    $sql .= "    '$pay_no', ";
    $sql .= "    '$sale_day', ";
    $sql .= "    $client_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
/*
    $sql .= "   ( ";
    $sql .= "       SELECT t_bank.bank_cd FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_bank.bank_name FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_b_bank.b_bank_cd FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_b_bank.b_bank_name FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_account.deposit_kind FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_account.account_no FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
*/
    //$sql .= "    claim_div, ";
    //$sql .= "    bill_id, ";
    //$sql .= "    claim_cd1, ";
    //$sql .= "    claim_cd2, ";
    //$sql .= "    claim_cname, ";
    // �����껦����2007-06-12 fukuda��
    if ($advance_offset !== null){
        $sql .= "   '$claim_div', \n";
/*
        $sql .= "   (SELECT t_client.client_cd1 FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
        $sql .= "   (SELECT t_client.client_cd2 FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
        $sql .= "   (SELECT t_client.client_cname FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
*/
    //����ʳ����������ʬ�����������Ͽ
    }else{
        $sql .= "    '1', ";
    }
    $sql .= "    CURRENT_TIMESTAMP, ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    //�����ɼ�ξ�硢��Ԥξ������Ͽ
    if($contract_div != "1"){
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    $act_id, ";
        $sql .= "    '$act_cd1', ";
        $sql .= "    '$act_cd2', ";
        $sql .= "    '".addslashes($act_name)."', ";
        $sql .= "    '".addslashes($act_cname)."', ";
    }else{
        $sql .= "    (SELECT staff_id FROM t_sale_staff WHERE sale_id = $sale_id AND staff_div = '0'), ";
        $sql .= "    (SELECT staff_name FROM t_sale_staff WHERE sale_id = $sale_id AND staff_div = '0'), ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
    }
    $sql .= "    ".$sale_id.", ";
    $sql .= "    $shop_id ";
    $sql .= ");";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }


    //����ǡ���ID�����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $pay_d_id  = $microtime[1].substr("$microtime[0]", 2, 5);

    $sql  = "INSERT INTO ";
    $sql .= "    t_payin_d ";
    $sql .= "( ";
    $sql .= "    pay_d_id, ";
    $sql .= "    pay_id, ";
    $sql .= "    trade_id, ";
    $sql .= "    amount ";
    //$sql .= "    bank_id, ";
    //$sql .= "    bank_cd, ";
    //$sql .= "    bank_name, ";
    //$sql .= "    payable_day, ";
    //$sql .= "    payable_no, ";
    //$sql .= "    note ";
    $sql .= ") VALUES ( ";
    $sql .= "    $pay_d_id, ";
    $sql .= "    $pay_id, ";
    if ($advance_offset === null){
        $sql .= "    '39', ";
        $sql .= "    $amount ";
    }else{
        $sql .= "    '40', ";
        $sql .= "    $advance_offset ";
    }
    $sql .= ");";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}



/**
 *
 * �����褬�����������������ʼ������ѡ�
 *
 * ����ID�����������׻��������ơ��֥����Ͽ
 * ������إå�������ۤȡ��������ʬ�������������׻�
 * ���ޤ���ʬ��ü����������Ψ�ϼ��ҡʼ�����ˤ�����򻲾Ȥ���
 *
 * �ѹ�����
 *    1.0.0 (2006//) (kaji)
 *      ����������
 *    1.0.1 (2006/10/18) (suzuki-t)
 *      ����������ľ�Ĥ������������ѹ�
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $aord_id    ����ID
 * @param       int         $shop_id    ������ID�ʰ�����ˡ����ۡ�
 * @param       int         $act_id     ����å�ID�ʰ�����ˡʼ�ʬ��ID��
 *
 * @return      bool        ��������Ͽ�����ǡ��������ǡ���ID
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/18)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-029      kajioka-h   �ޤ���ʬ�������ˤޤ��Ƥ����Τ���
 *                  03-034      kajioka-h   ���Ψ������ξ���null�������
 *  2006/11/16      -           suzuki-t    ����̾(����)����SQL�ѹ�
 *  2006/12/08      03-088      suzuki-t    ���ô������Ͽ
 *  2007/03/30      �׷�26-2    kajioka-h   ���ξ���̾���Ǽ����ά�Ρ�Ⱦ�ѥ��ڡ����ܶ�̳������פ�
 *  2007/05/03      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/30      xx-xxx      kajioka-h   Get_Data�ΰ�����5���ѹ�
 *  2007/06/18      ����¾14    kajioka-h   ���ǡ����������껦�ե饰����Ͽ���ä˻Ȥ�ʤ�����ǰ�Τ����
 *  2009/12/24                  aoyama-n    ��Ψ��TaxRate���饹�������
 *
 */
function FC_Act_Sale_Query($db_con, $aord_id, $shop_id, $act_id)
{

    /****************************/
    //�����ѿ�����
    /****************************/
    $staff_id    = $_SESSION["staff_id"];     //�������ID
    $staff_name  = $_SESSION["staff_name"];   //�������̾


    //�����ʬ��2�ʥ���饤����ԡˤξ�硢�����褫�������ؼ�ư�����򵯤���

    //������Τޤ���ʬ��ü����ʬ���������ʻ�ʧ���ˤ����
    //$sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$shop_id.";";
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE act_flg = true AND shop_id = ".$act_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //�ޤ���ʬ
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //ü����ʬ
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //�������ʷ��
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //������������

/*
    //����إå�������԰������ʡ�ˡ�����ۡʹ�סˤ����
    $sql  = "SELECT act_request_rate, net_amount FROM t_aorder_h WHERE aord_id = $aord_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_request_rate = pg_fetch_result($result, 0, "act_request_rate");    //��԰������ʡ��
    $net_amount = pg_fetch_result($result, 0, "net_amount");    //�����
*/

    //����إå�����ʲ��ι��ܤ����
    $sql  = "SELECT \n";
    $sql .= "    net_amount, \n";           //����ۡ���ȴ��
    $sql .= "    trust_cost_amount, \n";    //������ۡʼ������
    $sql .= "    trust_net_amount, \n";     //����ۡʼ������
    $sql .= "    trust_tax_amount, \n";     //�����ǳۡʼ������
    $sql .= "    act_div, \n";              //�������ʬ
    $sql .= "    act_request_price, \n";    //������ʸ����
    $sql .= "    act_request_rate, \n";     //������ʡ��
    $sql .= "    hand_plan_flg \n";         //ͽ����ե饰
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "    aord_id = $aord_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    $net_amount = pg_fetch_result($result, 0, "net_amount");            //����ۡ���ȴ��
    $cost_amount = pg_fetch_result($result, 0, "trust_cost_amount");    //������ۡʼ������
    $act_div = pg_fetch_result($result, 0, "act_div");                  //�������ʬ
    $act_request_price = pg_fetch_result($result, 0, "act_request_price");  //������ʸ����
    $act_request_rate = pg_fetch_result($result, 0, "act_request_rate");    //������ʡ��
    $hand_plan_flg = (pg_fetch_result($result, 0, "hand_plan_flg") == "t") ? "true" : "false";  //ͽ����ե饰

    //�������ȯ�����ʤ����
    if($act_div == "1"){
        //return true;
        return false;   //��ʧ��ɳ�դ����ʤ��Τǡ���ȯ�����ʤ��פϤʤ�

    //������ʸ���ˤξ��
    }elseif($act_div == "2"){
        $act_amount = $act_request_price;

    //������ʡ�ˤξ��
    }elseif($act_div == "3"){
    	$act_amount = bcmul($net_amount, bcdiv($act_request_rate, 100, 2), 2);
        $act_amount = Coax_Col($coax, $act_amount);                         //�����
    }
/*
    }else{
        $act_amount = pg_fetch_result($result, 0, "trust_net_amount");      //����ۡʼ������
        $act_tax    = pg_fetch_result($result, 0, "trust_tax_amount");      //�����ǳۡʼ������

        $cost_amount = pg_fetch_result($result, 0, "trust_cost_amount");    //������ۡʼ������
    }
*/

    //������ξ���ID������̾������̾��ά�Ρˡ�ñ�̡����Ƕ�ʬ�����
    $sql  = "SELECT goods_id, goods_name, goods_cname, unit, tax_div FROM t_goods WHERE goods_cd = '09999901';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_goods_id = pg_fetch_result($result, 0, "goods_id");        //������ξ���ID
    $act_goods_name = pg_fetch_result($result, 0, "goods_name");    //������ξ���̾
    $act_goods_cname = pg_fetch_result($result, 0, "goods_cname");  //������ξ���̾��ά�Ρ�
    $act_unit = pg_fetch_result($result, 0, "unit");                //�������ñ��
    $act_tax_div = pg_fetch_result($result, 0, "tax_div");          //������β��Ƕ�ʬ

    #2009-12-24 aoyama-n
    //����إå�����������������ˤ����
    $sql  = "SELECT ord_time FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $sale_day  = pg_fetch_result($result, 0, "ord_time");      //�����

    #2009-12-24 aoyama-n
    //������������Ƥ���������᤿�����������������ˤ���
    $sale_day_arr = explode("-", $sale_day);

    #2013-05-23 hashimoto-y
    #�������ʬ(claim_div)�ξ����­
    #����饤����Ԥξ�硢�������ʬ��1�׸���
    #if(!Check_Bill_Close_Day($db_con, $shop_id, $sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
    if(!Check_Bill_Close_Day_Claim($db_con, $shop_id, "1" ,$sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
        $sql  = "SELECT\n";
        $sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
        $sql .= "FROM\n";
        $sql .= "   t_bill_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_bill_d.client_id = $client_id";
        $sql .= ";";

        $next_close_day = pg_fetch_result($result, 0, 0);       //������
    }else{
        $next_close_day = $sale_day;                            //������
    }

    //����إå������������Ǽ�����̾��ά�Ρˤ����
    $sql  = "SELECT client_cname FROM t_aorder_h WHERE aord_id = $aord_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //������̾��Ǽ�����̾��ά�Ρ�

    //������ʼ�ʬ�ˤξ�����Ψ�����
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$act_id.";";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //������Ψ

    #2009-12-24 aoyama-n
    //����饤����Ԥμ�����ν����Ǥϼ��Ҥ�ü�����ޤ���ʬ�����Ƕ�ʬ����Ѥ���
    //��Ψ���饹�����󥹥�������
    $tax_rate_obj = new TaxRate($act_id);
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($act_id);

    //������ξ����Ǥ�׻�
    $array_amount = Total_Amount(array($act_amount), array($act_tax_div), $coax, $tax_franct, $tax_rate, $act_id, $db_con);
    //$act_amount = $array_amount[0];     //�����
    $act_tax = $array_amount[1];        //�����ǳ�

    //��ư�ǵ��������������Ͽ�������إå��˻Ȥ����ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_sale_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //Ʊ����������ֹ����
    $sql  = "SELECT ";
    $sql .= "    MAX(ord_no) ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_no_serial_fc ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = ".$act_id." ";   //ľ�İʳ��������������夷�ʤ��Τǡ�Rank_Sql�ȤäƤޤ���
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_sale_no = pg_fetch_result($result, 0, 0) + 1;
    $act_sale_no = str_pad($act_sale_no, 8, '0', STR_PAD_LEFT);  //����ֹ�

    //���ߤκ����ͤ򹹿�
    $sql  = "INSERT INTO t_aorder_no_serial_fc (ord_no,shop_id)VALUES('$act_sale_no',$act_id);";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

/*
    //�����褬��Ԥ��פ������������
    //$sql  = "SELECT SUM(trust_trade_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    //�����褬��Ԥ��פ���������ۡʼ�����ˤ����
    $sql  = "SELECT SUM(trust_cost_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $cost_amount = pg_fetch_result($result, 0, 0);      //�����踶��
*/

	//����λ�����ۤι���ͼ���
    //$sql  = "SELECT SUM(buy_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
	//����λ�����ۡʼ�����ˤι���ͼ���
    $sql  = "SELECT SUM(trust_buy_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_amount = pg_fetch_result($result, 0, 0);      //�߸˶�ۤι��

    //������ν��ô���Ԥ����
    $sql  = "SELECT staff_div, staff_id, sale_rate, staff_name,course_id FROM t_aorder_staff WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $staff_count = pg_num_rows($result);
    for($i=0;$i<$staff_count;$i++){
        $array_staff[$i]["staff_div"]  = pg_fetch_result($result, $i, "staff_div");
        $array_staff[$i]["staff_id"]   = pg_fetch_result($result, $i, "staff_id");
        $array_staff[$i]["sale_rate"]  = pg_fetch_result($result, $i, "sale_rate");
        $array_staff[$i]["staff_name"] = pg_fetch_result($result, $i, "staff_name");
		$array_staff[$i]["staff_name"] = addslashes($array_staff[$i]["staff_name"]);
        $array_staff[$i]["course_id"]  = pg_fetch_result($result, $i, "course_id");
    }

    //����إå�����������������ˤ����
    #2009-12-24 aoyama-n
    #$sql  = "SELECT ord_time FROM t_aorder_h WHERE aord_id = $aord_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$sale_day  = pg_fetch_result($result, 0, "ord_time");      //�����

/*
	//ľ�Ĥ����������
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //����

	//����Ƚ��
	if($close_day == 29){
		//���η����������Ȥ��Ʒ׻�
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//����������׻�
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//������
	$next_close_day = $year."-".$month."-".$day;
*/

    //������������Ƥ���������᤿�����������������ˤ���
    #2009-12-24 aoyama-n
    #$sale_day_arr = explode("-", $sale_day);

    #if(!Check_Bill_Close_Day($db_con, $shop_id, $sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
        #$sql  = "SELECT\n";
        #$sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
        #$sql .= "FROM\n";
        #$sql .= "   t_bill_d \n";
        #$sql .= "WHERE \n";
        #$sql .= "   t_bill_d.client_id = $client_id";
        #$sql .= ";";

        #$next_close_day = pg_fetch_result($result, 0, 0);       //������
    #}else{
        #$next_close_day = $sale_day;                            //������
    #}

    //�в��Ҹˡ����͡�������ͳ����
    $sql = "SELECT ware_id, ware_name, note, reason_cor, round_form FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $ware_id    = pg_fetch_result($result, 0, "ware_id");   //�в��Ҹ�ID
    $ware_name  = pg_fetch_result($result, 0, "ware_name"); //�в��Ҹ�̾
    $note       = pg_fetch_result($result, 0, "note");      //����
    $reason_cor = pg_fetch_result($result, 0, "reason_cor");    //������ͳ
    $round_form = pg_fetch_result($result, 0, "round_form");    //������

    //���إå���ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_sale_h ";
    $sql .= "( ";
    $sql .= "    sale_id, ";
    $sql .= "    sale_no, ";
    $sql .= "    aord_id, ";
    $sql .= "    sale_day, ";
    $sql .= "    claim_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    c_shop_name, ";
    $sql .= "    c_shop_name2, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    c_post_no1, ";
    $sql .= "    c_post_no2, ";
    $sql .= "    c_address1, ";
    $sql .= "    c_address2, ";
    $sql .= "    c_address3, ";
    $sql .= "    claim_id, ";
    $sql .= "    claim_div, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    cost_amount, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= "    shop_id, ";
    $sql .= "    act_request_flg, ";
    $sql .= "    contract_div, ";
    $sql .= "    slip_out, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    note, ";
    $sql .= "    reason_cor, ";
    $sql .= "    round_form, ";
	$sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    act_div, ";
    $sql .= "    act_request_price, ";
    $sql .= "    act_request_rate, ";
    $sql .= "    hand_plan_flg ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_sale_id, ";
    $sql .= "    '$act_sale_no', ";
    $sql .= "    $aord_id, ";
    $sql .= "    '$sale_day', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '11', ";
    $sql .= "    $shop_id, ";
    $sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT post_no1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT post_no2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address3 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $shop_id AND claim_div = '1'), ";
    $sql .= "    '1', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_tax, ";
    $sql .= "    $act_id, ";
    $sql .= "    't',";
    $sql .= "    '2',";
    $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    $ware_id,";
    $sql .= "    '".addslashes($ware_name)."', ";
    $sql .= "    '".addslashes($note)."', ";
    $sql .= "    '".addslashes($reason_cor)."', ";
    $sql .= "    '".addslashes($round_form)."', ";
	$sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    '$act_div', ";
    $sql .= ($act_request_price != null) ? "    $act_request_price, " : "    null, ";
    $sql .= "    '$act_request_rate', ";
    $sql .= "    $hand_plan_flg ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //������������ǡ���ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_sale_d_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //���������Ƚ��
    if($act_goods_id != NULL){
        //����ʬ�ࡦ����̾�μ���
        $sql  = "SELECT ";
        $sql .= "    t_g_product.g_product_name,";
        $sql .= "    t_g_product.g_product_name || '��' || t_goods.goods_name "; 
        $sql .= "FROM ";
        $sql .= "    t_g_product ";
        $sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
        $sql .= "WHERE ";
        $sql .= "    t_goods.goods_id = $act_goods_id;";
        $result = Db_Query($db_con, $sql);
        $pro_data = NULL;
        $pro_data = Get_Data($result,5);
    }

    //���ǡ�����ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_sale_d ";
    $sql .= "( ";
    $sql .= "    sale_d_id, ";
    $sql .= "    sale_id, ";
    $sql .= "    line, ";
    $sql .= "    sale_div_cd, ";
    $sql .= "    goods_print_flg, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_cd, ";
    $sql .= "    goods_name, ";
    $sql .= "    num, ";
    $sql .= "    unit, ";
    $sql .= "    tax_div, ";
    $sql .= "    buy_price, ";
    $sql .= "    cost_price, ";
    $sql .= "    sale_price, ";
    $sql .= "    buy_amount, ";
    $sql .= "    cost_amount, ";
    $sql .= "    sale_amount, ";
    $sql .= "    g_product_name, ";
    $sql .= "    official_goods_name, ";
    $sql .= "    advance_flg ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_sale_d_id, ";
    $sql .= "    $act_sale_id, ";
    $sql .= "    1, ";
    $sql .= "    '01', ";       //�����ʬ�ϥ�ԡ���
    $sql .= "    true, ";
    $sql .= "    $act_goods_id, ";
    $sql .= "    '09999901', ";
    //$sql .= "    '".addslashes($act_goods_name)."', ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    1, ";
    $sql .= "    '$act_unit', ";
    $sql .= "    '$act_tax_div', ";
    $sql .= "    $buy_amount, ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $buy_amount, ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    '".$pro_data[0][0]."', ";
    //$sql .= "    '".$pro_data[0][1]."' ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    '1' ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //���ô������ϿSQL
    for($i=0;$i<$staff_count;$i++){
        $sql  = "INSERT INTO ";
        $sql .= "    t_sale_staff ";
        $sql .= "( ";
        $sql .= "    sale_id, ";
        $sql .= "    staff_div, ";
        $sql .= "    staff_id, ";
        $sql .= "    sale_rate, ";
        $sql .= "    staff_name, ";
        $sql .= "    course_id ";
        $sql .= ") VALUES ( ";
        $sql .= "    ".$act_sale_id.", ";
        $sql .= "    '".$array_staff[$i]["staff_div"]."', ";
        $sql .= "    ".$array_staff[$i]["staff_id"].", ";
        $sql .= ($array_staff[$i]["sale_rate"] == null) ? "    null, " : "    '".$array_staff[$i]["sale_rate"]."', ";
        $sql .= "    '".$array_staff[$i]["staff_name"]."',";
        //����������Ƚ��
        if($array_staff[$i]["course_id"] != NULL){
            $sql .= "    ".$array_staff[$i]["course_id"];
        }else{
            $sql .= "    NULL";
        }
        $sql .= ");";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

    }

    //����ͤ����ǡ���ID
    return $act_sale_d_id;

}



/**
 *
 * �����褬����������������������ۡʰ�������ѡ�
 *�ʻ����ϰ�����ǤϤʤ������˵������ޤ���
 *
 * ���ID�����������׻����������ơ��֥����Ͽ
 * 
 * ������
 * 1.0.0 (2006/08/18) kaji
 *   ����������
 * 1.0.1 (2006/10/12) kaji
 *   �������إå���ά�Τ�Ĥ��褦��
 *   ���������ޤ�������ɲ�
 * 1.0.2 (2006/10/18) suzuki-t
 *   ���������������������������ѹ�
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $sale_id    ���ID
 * @param       int         $shop_id    ������ID�ʼ������
 * @param       int         $act_id     ����å�ID�ʰ�����ˡ����ۡˡʼ�ʬ��ID��
 *                                      �ʻ����ϰ�����ǤϤʤ������˵������ޤ���
 *
 * @return      bool        ������true
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.2 (2006/10/18)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-050      kajioka-h   ���͡�������ͳ�����ʽв��Ҹˡ������ʬ�������
 *  2006/12/08      03-087      suzuki      ����ô������Ͽ
 *  2007/02/21      ��˾6-1     kajioka-h   �����ɼ����������Ͽ�Ǥ���褦�ˤ����б�
 *  2007/03/16      03-001      kajioka-h   ������η׻��ˡ�������ǤϤʤ���ʬ�β��Ƕ�ʬ��ȤäƤ����Τ���
 *                  xx-xxx      kajioka-h   �����Ҹˤ���ܽв��Ҹˤ��������桼���ε����Ҹˤ��ѹ�
 *  2007/03/30      �׷�26-2    kajioka-h   �����ξ���̾���Ǽ����ά�Ρ�Ⱦ�ѥ��ڡ����ܶ�̳������פ�
 *  2007/04/02      �׷�6-2     kajioka-h   �����ɼ��Ǽ����ؤ����μ����ʬ�ȡ�������ؤ������������ʲ��Τ褦���ѹ�
 *                                               ���      ����
 *                                              ����� �� �ݻ���
 *                                              ������ �� ������
 *                                              ���Ͱ� �� ���Ͱ�
 *  2007/04/03      ����¾25    kajioka-h   ������λ����ϰ���������ۡˤǤϤʤ����������ѹ�
 *                                          �������ξ�����Ψ���������׻�
 *                                          �������Ҹˤ������δ����Ҹˤ��ѹ�
 *                                          �������إå���shop_id��������ID���ѹ�
 *                                          �������إå���buy_div=2����Ͽ
 *  2007/04/26      ¾79,152    kajioka-h   ������λ����ѹ�
 *  2007/05/23      xx-xxx      kajioka-h   ����������Ԥ���ǽ�ˤʤä����ᡢ�����μ��������ѹ�����夬����Ǥ⡢�����ϳݡ�
 *  2009/12/24                  aoyama-n    ��Ψ��TaxRate���饹�������
 *
 */
function FC_Act_Buy_Query($db_con, $sale_id, $shop_id, $act_id)
{

    //�����ʬ��2��3�ʥ���饤����ԡ����ե饤����ԡˤξ��ϡ������褫�������ؼ�ư�ǻ����򵯤���

    //������client_id�����
    $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $head_id = pg_fetch_result($result, 0, "client_id");    //������client_id

    //��԰����������
    $sql = "SELECT hand_slip_flg FROM t_sale_h WHERE sale_id = $sale_id ;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    //���󤫤餭�����ϼ���إå������������ʬ��������ʸ���ˡ�������ʡ�ˤ����
    if(pg_fetch_result($result, 0, 0) == "f"){
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.act_div, \n";              //�������ʬ
        $sql .= "    t_aorder_h.act_request_price, \n";    //������ʸ����
        #2009-12-24 aoyama-n
        #$sql .= "    t_aorder_h.act_request_rate \n";      //������ʡ��
        $sql .= "    t_aorder_h.act_request_rate, \n";      //������ʡ��
        $sql .= "    t_aorder_h.act_id \n";                 //��Լ�ID
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "    INNER JOIN t_sale_h ON t_aorder_h.aord_id = t_sale_h.aord_id ";
        $sql .= "WHERE ";
        $sql .= "    t_sale_h.sale_id = $sale_id ";
        $sql .= ";";
    //�����ɼ�ξ������إå������������ʬ��������ʸ���ˡ�������ʡ�ˤ����
    }else{
        $sql  = "SELECT \n";
        $sql .= "    act_div, \n";              //�������ʬ
        $sql .= "    act_request_price, \n";    //������ʸ����
        #2009-12-24 aoyama-n
        #$sql .= "    act_request_rate \n";      //������ʡ��
        $sql .= "    act_request_rate, \n";      //������ʡ��
        $sql .= "    act_id \n";                 //��Լ�ID
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";
        $sql .= "WHERE \n";
        $sql .= "    sale_id = $sale_id \n";
        $sql .= ";";
    }

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_div            = pg_fetch_result($result, 0, "act_div");               //�������ʬ
    $act_request_price  = pg_fetch_result($result, 0, "act_request_price");     //������ʸ����
    $act_request_rate   = pg_fetch_result($result, 0, "act_request_rate");      //������ʡ��
    #2009-12-24 aoyama-n
    $trustee_id         = pg_fetch_result($result, 0, "act_id");                //��Լ�ID

	//������Τޤ���ʬ��ü����ʬ���������ʻ�ʧ���ˤ����
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$shop_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //�ޤ���ʬ
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //ü����ʬ
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //�������ʷ��
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //������������

    //���إå���������ۡʹ�סˡ�������̾��Ǽ�����̾��ά�Ρˤ����
    $sql  = "SELECT net_amount, client_cname, trade_id FROM t_sale_h WHERE sale_id = $sale_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $net_amount = pg_fetch_result($result, 0, "net_amount");    //�����
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //�������Ǽ�����̾��ά�Ρ�
    $trade_id = pg_fetch_result($result, 0, "trade_id");        //���μ����ʬ
    //���μ�褬�ֳ����ʡסָ������ʡפξ�硢�����μ��ϡֳ����ʡ�
    if($trade_id == "13" || $trade_id == "63"){
        $buy_trade_id = "23";
    //���μ�褬�ֳ��Ͱ��סָ����Ͱ��פξ�硢�����μ��ϡֳ��Ͱ���
    }elseif($trade_id == "14" || $trade_id == "64"){
        $buy_trade_id = "24";
    //����ʳ��ϡ������μ��ϡֳݻ�����
    }else{
        $buy_trade_id = "21";
    }

    //$act_amount = $net_amount * $act_request_rate / 100;    //������ʲ���
	//2006-10-13 suzuki
	//$act_amount = bcmul($net_amount,bcdiv($act_request_rate,100,2),2);  //������ʲ���
	//1.0.1 (2006/10/12) �������ޤ�����
    //$act_amount = Coax_Col($coax, $act_amount);     //������ʤޤ����

    //������η׻�
    //�������ȯ�����ʤ����
    if($act_div == "1"){
        return true;

    //������ʸ���ˤξ��
    }elseif($act_div == "2"){
        $act_amount = $act_request_price;               //�����

    //������ʡ�ˤξ��
    }elseif($act_div == "3"){
    	$act_amount = bcmul($net_amount, bcdiv($act_request_rate, 100, 2), 2);
        $act_amount = Coax_Col($coax, $act_amount);     //�����
    }

    //������ξ���ID������̾��ñ�̡����Ƕ�ʬ�����
    $sql  = "SELECT goods_id, goods_name, unit, tax_div FROM t_goods WHERE goods_cd = '09999901';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_goods_id = pg_fetch_result($result, 0, "goods_id");        //������ξ���ID
    $act_goods_name = pg_fetch_result($result, 0, "goods_name");    //������ξ���̾
    //$act_goods_name = addslashes($act_goods_name);
    $act_unit = pg_fetch_result($result, 0, "unit");                //�������ñ��
    $act_tax_div = pg_fetch_result($result, 0, "tax_div");          //������β��Ƕ�ʬ

	//���إå�����������������ˤ����
    #2009-12-24 aoyama-n
    $sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_day     = pg_fetch_result($result, 0, "sale_day");     //�����

    #2009-12-24 aoyama-n
    $buy_day_arr = explode("-", $buy_day);

    //������������Ƥ���������᤿����������������ˤ���
    //if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2])){
    if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2], $head_id)){
        $sql  = "SELECT \n";
        $sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        $sql .= "FROM \n";
        $sql .= "    t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $shop_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $next_close_day = pg_fetch_result($result, 0, 0);       //������
    }else{
        $next_close_day = $buy_day;                             //������
    }

    //������ʼ�ʬ�ˤξ�����Ψ�����
    //$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$act_id.";";
    //�����ξ�����Ψ�����
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$head_id.";";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //������Ψ

    #2009-12-24 aoyama-n
    //��Ψ���饹�����󥹥�������
    $tax_rate_obj = new TaxRate($head_id);
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($trustee_id);

    //������ξ����Ǥ�׻�
    $array_amount = Total_Amount(array($act_amount), array($act_tax_div), $coax, $tax_franct, $tax_rate, $shop_id, $db_con);
    $act_amount = $array_amount[0];     //�����
    $act_tax = $array_amount[1];        //�����ǳ�

    //��ư�ǵ��������������Ͽ��������إå��˻Ȥ�����ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_buy_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //Ʊ�����������ֹ����
    $sql  = "SELECT ";
    $sql .= "    MAX(buy_no) ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "WHERE ";
    //$sql .= "    shop_id IN (".Rank_Sql().") ";     //ľ�Ĥ���������ǻ������ʤ��Τǡ�Rank_Sql�Τ�
    $sql .= "    shop_id = $head_id ";  //�����λ����ֹ�MAX�����
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_buy_no = pg_fetch_result($result, 0, 0) + 1;
    $act_buy_no = str_pad($act_buy_no, 8, '0', STR_PAD_LEFT);   //�����ֹ�

	//���إå�����������������ˤ����
    #2009-12-24 aoyama-n
    #�����Ǽ������ǽ�������
    #$sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$buy_day     = pg_fetch_result($result, 0, "sale_day");     //�����

/*
	//���������������
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //����
	//����Ƚ��
	if($close_day == 29){
		//���η����������Ȥ��Ʒ׻�
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//����������׻�
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//������
	$next_close_day = $year."-".$month."-".$day;
*/
    #2009-12-24 aoyama-n
    #$buy_day_arr = explode("-", $buy_day);

    //������������Ƥ���������᤿����������������ˤ���
    //if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2])){
    #2009-12-24 aoyama-n
    #if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2], $head_id)){
        #$sql  = "SELECT \n";
        #$sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        #$sql .= "FROM \n";
        #$sql .= "    t_schedule_payment \n";
        #$sql .= "WHERE \n";
        #$sql .= "    client_id = $shop_id \n";
        #$sql .= ";";
        #$result = Db_Query($db_con, $sql);

        #$next_close_day = pg_fetch_result($result, 0, 0);       //������
    #}else{
        #$next_close_day = $buy_day;                             //������
    #}

    //�����Ҹ����
    //$ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con));    //���ڥ졼���ε����Ҹ�

    //������ν��ô���ԡ��������������͡ˤ����
    //���������ɬ�סʤޤ�������

    //�����إå���ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_h ";
    $sql .= "( ";
    $sql .= "    buy_id, ";
    $sql .= "    shop_id, ";
    $sql .= "    buy_no, ";
    $sql .= "    buy_day, ";
    $sql .= "    arrival_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= "    act_sale_id, ";
    $sql .= "    buy_div ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_buy_id, ";
    //$sql .= "    $act_id, ";
    $sql .= "    $head_id, ";
    $sql .= "    '$act_buy_no', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '$buy_day', ";
    $sql .= "    '$buy_trade_id', ";
    $sql .= "    $shop_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
    //$sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $act_id), ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $act_id)), ";
    //$sql .= "    $ware_id, ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
    $sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $head_id), ";
    $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $head_id)), ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_tax, ";
    $sql .= "    $sale_id, ";
    $sql .= "    '2' ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //����������λ����ǡ���ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_buy_d_id = $microtime[1].substr("$microtime[0]", 2, 5);

    //�����ǡ�����ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_d ";
    $sql .= "( ";
    $sql .= "    buy_d_id, ";
    $sql .= "    buy_id, ";
    $sql .= "    line, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_name, ";
    $sql .= "    goods_cd, ";
    $sql .= "    tax_div, ";
    $sql .= "    num, ";
    $sql .= "    buy_price, ";
    $sql .= "    buy_amount ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_buy_d_id, ";
    $sql .= "    $act_buy_id, ";
    $sql .= "    1, ";
    $sql .= "    $act_goods_id, ";
    //$sql .= "    '$act_goods_name', ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    '09999901', ";
    $sql .= "    '$act_tax_div', ";
    $sql .= "    1, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_amount ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}





/**
 *
 * �Ҳ��������
 *
 * ���ID����Ҳ�����׻����������ơ��֥����Ͽ
 *
 *
 * ������
 * 1.0.0 (2006/08/18) kaji
 *   ����������
 * 1.0.1 (2006/10/12) kaji
 *   �������إå���ά�Τ�Ĥ��褦��
 * 1.0.2 (2006/10/18) suzuki-t
 *   ����������Ҳ�Ԥ������������ѹ�
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $sale_id    ���ID
 * @param       int         $client_id  �Ҳ��ID
 *
 * @return      bool        ������true
 *                          ���ԡ�false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.2 (2006/10/18)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-007      kajioka-h   ������ξ���client_cd2����Ͽ���ʤ��褦��
 *  2006/12/08      03-077      suzuki      ����ô���Ԥ���Ͽ
 *  2007/03/16      xx-xxx      kajioka-h   �����Ҹˤ���ܽв��Ҹˤ��������桼���ε����Ҹˤ��ѹ�
 *  2007/03/30      �׷�26-2    kajioka-h   �����ξ���̾���������ά�Ρ�Ⱦ�ѥ��ڡ����ܾҲ�������פ�
 *  2007/04/03      ����¾25    kajioka-h   �Ҳ�Ԥ�FC�ξ�硢�Ҳ����λ����ϰ���������ۡˤǤϤʤ����������ѹ�
 *                                          �������ξ�����Ψ�ǾҲ�����׻�
 *                                          �������Ҹˤ������δ����Ҹˤ��ѹ�
 *                                          �������إå���shop_id��������ID���ѹ�
 *                                          �������إå���buy_div=2����Ͽ
 *
 */
function FC_Intro_Buy_Query($db_con, $sale_id, $client_id)
{

    //�Ҳ�Ԥ�FC�������褫Ƚ��
    $sql = "SELECT client_div FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_client_div = pg_fetch_result($result, 0, "client_div");  //�Ҳ�Ԥμ�����ʬ
    //�Ҳ�Ԥ�FC�ξ�硢������client_id�����
    if($intro_client_div == "3"){
        //������client_id�����
        $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $head_id = pg_fetch_result($result, 0, "client_id");        //������client_id
    }

    //���ID����Ҳ��������
    $sql  = "SELECT ";
    $sql .= "    intro_amount, ";
    $sql .= "    shop_id, ";
    $sql .= "    client_cname ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "WHERE ";
    $sql .= "    sale_id = $sale_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_amount = pg_fetch_result($result, 0, "intro_amount");    //�Ҳ���
    $shop_id      = pg_fetch_result($result, 0, "shop_id");         //����å�ID
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //

    //�Ҳ����ξ���ID������̾��ñ�̡����Ƕ�ʬ�����
    $sql  = "SELECT goods_id, goods_name, unit, tax_div FROM t_goods WHERE goods_cd = '09999902';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_goods_id = pg_fetch_result($result, 0, "goods_id");        //�Ҳ����ξ���ID
    $intro_goods_name = pg_fetch_result($result, 0, "goods_name");    //�Ҳ����ξ���̾
	//$intro_goods_name = addslashes($intro_goods_name);

    //$intro_unit = pg_fetch_result($result, 0, "unit");                //�Ҳ�����ñ��
    $intro_tax_div = pg_fetch_result($result, 0, "tax_div");          //�Ҳ����β��Ƕ�ʬ

    //�Ҳ�ԤΤޤ���ʬ��ü����ʬ���������ʻ�ʧ���ˤ����
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$client_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //�ޤ���ʬ
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //ü����ʬ
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //�������ʷ��
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //������������

    //���إå�����������������ˤ����
    #2009-12-24 aoyama-n
    $sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_day     = pg_fetch_result($result, 0, "sale_day");         //�����

    #2009-12-24 aoyama-n
    $buy_day_arr = explode("-", $buy_day);

    //�����������å�
    $check_pcd = !Check_Payment_Close_Day($db_con, $client_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2]);
    //������������Ƥ���������᤿����������������ˤ���
    if($check_pcd){
        $sql  = "SELECT \n";
        $sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        $sql .= "FROM \n";
        $sql .= "    t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $client_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $next_close_day = pg_fetch_result($result, 0, 0);       //������
    //������������Ƥʤ����ϡ���������������
    }else{
        $next_close_day = $buy_day;                             //������
    }

    //��ʬ�ξ�����Ψ�����
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ";
    #$sql .= ($intro_client_div == "3") ? "$head_id;" : "$shop_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //������Ψ

    #2009-12-24 aoyama-n
    //��Ψ���饹�����󥹥�������
    if ($intro_client_div == "3") {
      $tax_rate_obj = new TaxRate($head_id);
    }else{
      $tax_rate_obj = new TaxRate($shop_id);
    }
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);


    //�Ҳ����ξ����Ǥ�׻�
    $array_amount = Total_Amount(array($intro_amount), array($intro_tax_div), $coax, $tax_franct, $tax_rate, $client_id, $db_con);
    $intro_amount = $array_amount[0];   //�Ҳ���
    $intro_tax    = $array_amount[1];   //�����ǳ�

    //��ư�ǵ������Ҳ�������Ͽ��������إå��˻Ȥ�����ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $intro_buy_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //Ʊ�����������ֹ����
    $sql  = "SELECT ";
    $sql .= "    MAX(buy_no) ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "WHERE ";
    //�Ҳ���¤�FC�ʤ������λ����ֹ�
    if($intro_client_div == "3"){
        $sql .= "   shop_id = $head_id ";
    //������ʤ�ľ�ġ��ޤ���FC�λ����ֹ�
    }else{
        if($_SESSION["group_kind"] == "2"){
            $sql .= "   shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   shop_id = $shop_id ";
        }
    }
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_buy_no = pg_fetch_result($result, 0, 0);
    $intro_buy_no = $intro_buy_no +1;
    $intro_buy_no = str_pad($intro_buy_no, 8, 0, STR_POS_LEFT);     //�����ֹ�

    //���إå�����������������ˤ����
    #2009-12-24 aoyama-n
    #�����Ǽ��������ǽ�������
    #$sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$buy_day     = pg_fetch_result($result, 0, "sale_day");         //�����

/*
	//�Ҳ�Ԥ����������
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //����
	//����Ƚ��
	if($close_day == 29){
		//���η����������Ȥ��Ʒ׻�
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//����������׻�
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//������
	$next_close_day = $year."-".$month."-".$day;
*/
    #2009-12-24 aoyama-n
    #$buy_day_arr = explode("-", $buy_day);

    //�����������å�
    #$check_pcd = !Check_Payment_Close_Day($db_con, $client_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2]);
    //������������Ƥ���������᤿����������������ˤ���
    #if($check_pcd){
        #$sql  = "SELECT \n";
        #$sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        #$sql .= "FROM \n";
        #$sql .= "    t_schedule_payment \n";
        #$sql .= "WHERE \n";
        #$sql .= "    client_id = $client_id \n";
        #$sql .= ";";
        #$result = Db_Query($db_con, $sql);

        #$next_close_day = pg_fetch_result($result, 0, 0);       //������
    //������������Ƥʤ����ϡ���������������
    #}else{
        #$next_close_day = $buy_day;                             //������
    #}

    //������ʬ��������ơ���������ä����client_cd2��NULL
    $sql = "SELECT client_div, client_cd2 FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    if(pg_fetch_result($result, 0, "client_div") != "2"){
        $client_cd2 = pg_fetch_result($result, 0, "client_cd2");
    }else{
        $client_cd2 = null;
    }

    //�����Ҹ����
    if($intro_client_div == "3"){
        //�����˻����򵯤����ϡ������δ����Ҹˤ������Ҹˤ�
        $sql = "SELECT ware_id FROM t_client WHERE client_id = $head_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $ware_id = pg_fetch_result($result, 0, "ware_id");          //�����δ����Ҹ�
    }else{
        //FC�˻����򵯤����ϡ����ڥ졼���ε����Ҹˤ������Ҹˤ�
        $ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con));    //���ڥ졼���ε����Ҹ�
    }

    //������ν��ô���ԡʾҲ���������줿�͡ˤ����
    //���������ɬ�סʤޤ�������

    //�����إå���ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_h ";
    $sql .= "( ";
    $sql .= "    buy_id, ";
    $sql .= "    shop_id, ";
    $sql .= "    buy_no, ";
    $sql .= "    buy_day, ";
    $sql .= "    arrival_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= ($client_cd2 == null) ? "" : "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= ($intro_client_div == "3") ? "    buy_div, " : "";
    $sql .= "    intro_sale_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    $intro_buy_id, ";
    $sql .= ($intro_client_div == "3") ? "    $head_id, " : "    $shop_id, ";
    $sql .= "    '$intro_buy_no', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '$buy_day', ";
    $sql .= "    '21', ";
    $sql .= "    $client_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
    $sql .= ($client_cd2 == null) ? "" : "    '$client_cd2', ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
    //$sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $shop_id), ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $shop_id)), ";
    $sql .= "    $ware_id, ";
    $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $intro_amount, ";
    $sql .= "    $intro_tax, ";
    $sql .= ($intro_client_div == "3") ? "    '2', " : "";
    $sql .= "    $sale_id ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //����������λ����ǡ���ID����
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $intro_buy_d_id = $microtime[1].substr("$microtime[0]", 2, 5);

    //�����ǡ�����ϿSQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_d ";
    $sql .= "( ";
    $sql .= "    buy_d_id, ";
    $sql .= "    buy_id, ";
    $sql .= "    line, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_name, ";
    $sql .= "    goods_cd, ";
    $sql .= "    tax_div, ";
    $sql .= "    num, ";
    $sql .= "    buy_price, ";
    $sql .= "    buy_amount ";
    $sql .= ") VALUES ( ";
    $sql .= "    $intro_buy_d_id, ";
    $sql .= "    $intro_buy_id, ";
    $sql .= "    1, ";
    $sql .= "    $intro_goods_id, ";
    //$sql .= "    '$intro_goods_name', ";
    $sql .= "    '".addslashes($client_cname." ".$intro_goods_name)."', ";
    $sql .= "    '09999902', ";
    $sql .= "    '$intro_tax_div', ";
    $sql .= "    1, ";
    $sql .= "    $intro_amount, ";
    $sql .= "    $intro_amount ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}


/**
 *
 * �Ҳ�����׻�
 *
 * ����ޤ������ID����Ҳ�����׻�
 * ����ޤ������Υإå����ǡ���������ۡ�����Ψ�����¶�ۤ���Ͽ�ѤȤ���
 *
 *
 * ������
 * 1.0.0 (2007/02/27) kaji
 *   ����������
 * 1.1.0 (2007/04/06) kaji
 *   ���Ҳ�������λ����ѹ����б�
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       string      $slip_div   ��ɼ��ʬ�ʼ������Τɤ���Υơ��֥뤫��׻����뤫��
 *                                          "aord"  ������
 *                                          "sale"  �����
 * @param       int         $slip_id    ��ɼID
 *
 * @return      int         �Ҳ������
 *                          ���ԡ��ޤ��ϾҲ�����ȯ�����ʤ�����ξ��� false
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/04/06)
 *
 */
function FC_Intro_Amount_Calc($db_con, $slip_div, $slip_id)
{
    //�׻�����ݤ˥ǡ������������ơ��֥�̾
    $table_name = ($slip_div == "aord") ? "t_aorder_" : "t_sale_";

    //�إå��ξҲ��ID������ñ����������ˡ�����Ψ��������ˡ�����ۡ���ȴ�ˤ����
    $sql  = "SELECT \n";
    $sql .= "    intro_account_id, \n";
    $sql .= "    intro_ac_div, \n";
    $sql .= "    intro_ac_price, \n";
    $sql .= "    intro_ac_rate, \n";
    $sql .= "    net_amount \n";
    $sql .= "FROM \n";
    $sql .= "    ".$table_name."h \n";
    $sql .= "WHERE \n";
    $sql .= "    ".$slip_div."_id = ".$slip_id." \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_account_id       = pg_fetch_result($result, 0, "intro_account_id");      //�Ҳ��ID
    $intro_account_div      = pg_fetch_result($result, 0, "intro_ac_div");          //���¶�ʬ
    $intro_account_price    = pg_fetch_result($result, 0, "intro_ac_price");        //����ñ�����������
    $intro_account_rate     = pg_fetch_result($result, 0, "intro_ac_rate");         //����Ψ���������
    $net_amount             = pg_fetch_result($result, 0, "net_amount");            //����ۡ���ȴ��

    //�Ҳ�ԤΤޤ���ʬ����
    $sql = "SELECT coax FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_coax = pg_fetch_result($result, 0, "coax");  //�Ҳ�ԤΤޤ���ʬ


    //�Ҳ�����ȯ�����ʤ����
    if($intro_account_div == "1"){
        $intro_amount = false;

    //�����
    }elseif($intro_account_div == "2"){
        $intro_amount = $intro_account_price;

    //���Ψ
    }elseif($intro_account_div == "3"){
        $intro_amount = bcmul($net_amount, bcdiv($intro_account_rate, 100, 2), 2);
        $intro_amount = Coax_Col($intro_coax, $intro_amount);

    //������
    }elseif($intro_account_div == "4"){

        //�ǡ����ơ��֥�θ���ñ��������Ψ������ۤ����
        $sql  = "SELECT \n";
        $sql .= "    account_price, \n";
        $sql .= "    account_rate, \n";
        $sql .= "    sale_amount \n";
        $sql .= "FROM \n";
        $sql .= "    ".$table_name."d \n";
        $sql .= "WHERE \n";
        $sql .= "    ".$slip_div."_id = ".$slip_id." \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

        $count = pg_num_rows($result);
        for($i=0, $intro_amount=0 ; $i<$count; $i++){
            $account_price  = pg_fetch_result($result, $i, "account_price");    //����ñ��
            $account_rate   = pg_fetch_result($result, $i, "account_rate");     //����Ψ
            $sale_amount    = pg_fetch_result($result, $i, "sale_amount");      //�����

            //����ñ�����ꡢ����Ψ�ʤ��ξ�硢����ñ����ä���
            if($account_price != null && $account_rate == null){
                $intro_amount = bcadd($intro_amount, $account_price);

            //����ñ���ʤ�������Ψ����ξ�硢����ۡ߸���Ψ��ä���
            }elseif($account_price == null && $account_rate != null){
                $price = bcmul($sale_amount, bcdiv($account_rate, 100, 2), 2);
                $price = Coax_Col($intro_coax, $price);
                $intro_amount = bcadd($intro_amount, $price);
            }
        }
    }


    return $intro_amount;   //�Ҳ������

}


/**
 *
 * ����ͽ��вٺѤʤ���ô���ʥᥤ��ˤ�ô���Ҹˡ���äƤʤ��ä������إå��νв��Ҹˤ��֤������δؿ�
 *
 *
 * ������
 * 1.0.0 (2007/03/28) kaji
 *   ����������
 *
 * @param       object      $db_con     DB��³�꥽����
 * @param       int         $aord_id    ����ID
 *
 * @return      ������int   �Ҹ�ID
 *              ���ԡ�bool  false
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2007/03/28)
 *
 */
function FC_Move_Ware_Id($db_con, $aord_id)
{
    $sql  = "SELECT \n";
    $sql .= "    CASE t_aorder_h.move_flg \n";
    $sql .= "        WHEN true THEN t_attach.ware_id \n";
    $sql .= "        ELSE t_aorder_h.ware_id \n";
    $sql .= "    END \n";
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
    $sql .= "        AND t_aorder_staff.staff_div = '0' \n";
    $sql .= "    INNER JOIN t_attach ON t_aorder_staff.staff_id = t_attach.staff_id \n";
    $sql .= "        AND t_attach.h_staff_flg = false \n";
    $sql .= "WHERE \n";
    $sql .= "    t_aorder_h.aord_id = $aord_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return pg_fetch_result($result, 0, 0);

}

?>
