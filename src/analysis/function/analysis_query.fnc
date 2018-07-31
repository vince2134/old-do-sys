<?php

/**
 * ����褫������Ρ���������ζ�ۤ����  
 *
 * �ѹ�����  
 * 1.0.0 (2007/10/04) �������� <br>
 * 1.1.0 (2007/10/14) ������Υ������̲����� <br>
 * 1.2.0 (2007/10/15) �����θ�����������$_POST ���ѹ� <br>
 * 1.2.1 (2007/10/15) ���롼�פθ��������ɲ� <br>
 * 1.2.2 (2007/10/20) ����оݤθ��������ɲ� <br>
 * 
 * @author      aizawa-m <aizawa-m@bhsk.co.jp> 
 * 
 * @param      conection    $db_con             DB���ͥ������
 * @param      string       $div                ���ξ��="sale",�����ξ��="buy"
 * @param      array        $form_data              ���̤����Ϥ��줿���������ݻ�����$_POST
 *  
 * @return     resource     $result             �����긡�����
 *
 */ 
function Select_Each_Customer_Amount ( $db_con, $div, $form_data ) {
    
    /***********************/
    // SESSION�ѿ��μ���
    /***********************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /**************************/
    // �������鸡���������
    /**************************/
    $start_y        = $form_data["form_trade_ym_s"]["y"];   //����ǯ
    $start_m        = $form_data["form_trade_ym_s"]["m"];   //���Ϸ�
    $client_cd1     = $form_data["form_client"]["cd1"];     //������ʻ�����)������1
    $client_cd2     = $form_data["form_client"]["cd2"];     //������ʻ�����)������2  
    $client_name    = $form_data["form_client"]["name"];    //������ʻ�����)̾
    $period         = $form_data["form_trade_ym_e"];        //���״���
    $rank_cd        = $form_data["form_rank"];              //FC��������ʬ������
    $client_gr_id   = $form_data["form_client_gr"]["cd"];       //���롼�ץ�����
    $client_gr_name = $form_data["form_client_gr"]["name"];     //���롼��̾
    $out_abstract   = $form_data["form_out_abstract"];      //����о�


    if ( $div == "sale" ) {
        //���ξ��
        $tbl_name   = "t_sale_h";
        //�����ʬID
        $trade_id   = "11, 15, 61";
        //�����
        $term_day   = "sale_day";
        //������ʬ(������)
        $client_div = '1';
    } 
    else {
        //�����ξ��
        $tbl_name   = "t_buy_h";
        //������ʬID
        $trade_id   = "21, 25, 71";
        //������
        $term_day   = "buy_day";
        //������ʬ(������)
        $client_div = '2';
    }

    //�����ξ��
    if ( $group_kind == "1" ) {
        //������ʬ��FC��
        $client_div = '3';
    }

    /**********************/
    // ���������
    /**********************/
    $sql =  "SELECT \n";
    //������FC�ξ��ϡ������襳����1�Τ߼���
    if ( $div == "buy" AND $group_kind != "1" ) { 
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    } else {
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n";
    $sql.=  "   t_client.rank_cd  AS rank_cd, \n";
    $sql.=  "   t_rank.rank_name AS rank_name, \n";
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( ".$tbl_name.(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   COALESCE( ".$tbl_name.(string)($i+1).".arari_gaku, 0) AS arari_gaku".(string)($i+1).", \n";
        $sql.=  "   COALESCE( NULL , 0) AS num".(string)($i+1).", \n";
    }
    $sql.=  "   t_client.shop_id \n";
    $sql.=  "FROM \n";
    
    $sql.=  " ( \n";
    $sql.=  "   t_client \n";       
    for ( $i=0 ; $i<$period ; $i++ ) {
        //���դν񼰤��Ѥ���
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));
        
        $sql.=  "   LEFT JOIN ( \n";
        $sql.=  "       SELECT \n";
        $sql.=  "           client_id, \n";
        $sql.=  "           (net_amount -  cost_amount) AS arari_gaku, \n";
        $sql.=  "           net_amount \n";
        $sql.=  "       FROM \n";
        $sql.=  "           ( \n";
        $sql.=  "               SELECT \n";
        $sql.=  "                   SUM( \n";
        $sql.=  "                       CASE \n";
        $sql.=  "                           WHEN trade_id IN ($trade_id) THEN net_amount \n";
        $sql.=  "                           ELSE -1 * net_amount \n";
        $sql.=  "                       END \n";
        $sql.=  "                   ) AS net_amount, \n";
        //���ξ��Τ�
        if ( $div == "sale") {
            $sql.=  "               SUM ( \n";
            $sql.=  "                   CASE \n";          
            $sql.=  "                       WHEN trade_id IN ($trade_id) THEN cost_amount \n";
            $sql.=  "                       ELSE -1 * cost_amount \n";
            $sql.=  "                   END \n";
            $sql.=  "               ) AS cost_amount, \n";
        }
        else {
            //������cost_amount��¸�ߤ��ʤ�����0�����
            $sql.=  "               0 AS cost_amount, \n";
        }
        $sql.=  "                   client_id \n";
        $sql.=  "               FROM \n";
        $sql.=  "                   $tbl_name \n";
        $sql.=  "               WHERE \n";
        $sql.=  "                       shop_id = $shop_id \n";
        $sql.=  "                   AND \n";
        $sql.=  "                       $term_day >= '$this_date' \n";
        $sql.=  "                   AND \n";
        $sql.=  "                       $term_day < '$next_date' \n";
        $sql.=  "               GROUP BY \n";
        $sql.=  "                   client_id \n";
        $sql.=  "           ) $tbl_name \n";
        $sql.=  "   ) AS $tbl_name".(string)($i+1)." ON t_client.client_id = $tbl_name".(string)($i+1).".client_id \n";
    }
    $sql.=  " ) \n";
    //FC��������ʬ�����ɤȷ��
    $sql.=  "   LEFT JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";

    $sql.=  "WHERE \n";
    $sql.=  "       t_client.shop_id = $shop_id \n";
    $sql.=  "   AND \n";
    $sql.=  "       t_client.client_div = $client_div \n";

    /****************************/
    // ���������ɲ�
    /****************************/
    if ( $client_cd1 != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    //FC�λ����ξ��ϡ������򤷤ʤ�
    if ( $client_cd2 != NULL ) { 
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_cd2 LIKE '$client_cd2%' \n";
    }
    if ( $client_name != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   t_client.client_name LIKE '$client_name%' \n";
        $sql.=  "       OR \n";
        $sql.=  "           t_client.client_name2 LIKE '$client_name%' \n";
        $sql.=  "       OR \n";
        $sql.=  "           t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "       ) \n";
    }
    if ( $rank_cd != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.rank_cd = '$rank_cd' \n";
    }
    if ( $client_gr_id != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   SELECT \n";
        $sql.=  "               t_client_gr.client_gr_id \n";
        $sql.=  "           FROM \n";
        $sql.=  "               t_client_gr \n";
        $sql.=  "           WHERE \n";
        $sql.=  "               t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "       = $client_gr_id \n";
    }
    if ( $client_gr_name != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "       (   SELECT \n";
        $sql.=  "               t_client_gr.client_gr_name \n";
        $sql.=  "           FROM \n";
        $sql.=  "               t_client_gr \n";
        $sql.=  "           WHERE \n";
        $sql.=  "               t_client_gr.client_gr_id = t_client.client_gr_id ) \n";
        $sql.=  "       LIKE '%$client_gr_name%' \n";
    }
    //����оݤ����۰ʳ��ξ��
    if ( $out_abstract == "1" ) {
        $sql.=  "   AND \n";
        $sql.=  "       t_client.client_id <> 93 \n";
    }
    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2 \n";
    $sql.=  "; \n";

//echo nl2br( $sql);

    //������μ¹�
    $result =   Db_Query( $db_con , $sql );

    return $result;
}



/**
 * �����ӥ��̡�����������ܥǡ�������ѥ���������ؿ� 
 *
 * 
 *
 * �ѹ�����
 * 1.0.0 (2007/10/06) ��������(watanabe-k)
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/10/06)
 *
 * @param                   $db_con     DB���ͥ������
 * @param       array       $div        �����ӥ���serv�������ʡ�goods
 * @param       string      $form_data  POST����
 *
 * @return                  $resut      ������¹Է��
 *
 * ����
 *---------------------------------------------------------------------
 * 2007-12-07    watanabe-k    ������ʬ��ν���ͤ�����
 *                             ����INNER�פ��LEFT�פ˽���
 *                             ���������ʤιʤꤳ�߾���shop_id=1���ѹ�
 */
function Select_Each_SG_Amount($db_con, $div, $form_data){

    $shop_id = $_SESSION["client_id"];      //����å�ID
    $trade_id   = "11, 15, 61";             //�����ʬ

    /****************************/
    //���������
    /****************************/
    $sql =  "SELECT \n";

    //����Υǡ���
    for($i=1; $i <= $form_data["form_trade_ym_e"]; $i++){
    $sql .= "   COALESCE(t_sale_data".$i.".num, 0) AS num".$i.", \n"                 //����
           ."   COALESCE(t_sale_data".$i.".cost_amount, 0) AS cost_amount".$i.", \n" //�������
           ."   COALESCE(t_sale_data".$i.".sale_amount, 0) AS net_amount".$i.", \n" //�����
           ."   COALESCE(t_sale_data".$i.".sale_amount, 0) - COALESCE(t_sale_data".$i.".cost_amount, 0) AS arari_gaku".$i.", \n";    //������
    }

    $sql .= "   t_".$div.".".$div."_id, \n"          //id
           ."   t_".$div.".".$div."_cd AS cd, \n";    //������

    //����̾
    if($div == "goods"){
    //$sql .= "   t_g_product.g_product_name || ' ' || t_goods.goods_name AS name, \n";
    $sql .= "   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name  AS name, \n";

    //�����ӥ�̿
    }else{
    $sql .= "   t_serv.serv_name AS name, \n";
    }

    $sql .= "   null AS rank_cd,\n"             //FC��������ʬ�����ɡ�NULL��
           ."   null As rank_name\n"            //FC��������ʬ̾��NULL��
           ."FROM \n"
           ."   t_".$div." \n";


    //����Υǡ�������ѥơ��֥�
    for($i=1; $i <= $form_data["form_trade_ym_e"]; $i++){
        $start_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$i-1, 1, $form_data["form_trade_ym_s"]["y"])
            );

        $end_day = date('Ymd',
                mktime(0,0,0,$form_data["form_trade_ym_s"]["m"]+$i, 0, $form_data["form_trade_ym_s"]["y"])
            );

    $sql .= "       LEFT JOIN \n"
           ."   ( \n"
           ."   SELECT \n"
           ."       t_sale_d.".$div."_id, \n";

        //�����̤ξ��
        if($div == "goods"){
    $sql .= "       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.num \n"
           ."               WHEN t_sale_h.trade_id IN ('14','64') THEN 0 \n"
           ."               ELSE -1 * t_sale_d.num \n"
           ."           END \n"
           ."       ) AS num, \n";

        //�����ӥ��̤ξ��
        }else{
    $sql .= "       SUM( \n"
           ."       CASE \n"
           ."           WHEN t_sale_h.trade_id IN ($trade_id) THEN 1 \n"
           ."           WHEN t_sale_h.trade_id IN ('14','64') THEN 0 \n"
           ."           ELSE -1 \n"
           ."       END \n"
           ."       ) AS num, \n";

        }

    $sql .= "       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.sale_amount \n"
           ."               ELSE -1 * t_sale_d.sale_amount \n"
           ."           END \n"
           ."       ) AS sale_amount, \n"
           ."       SUM( \n"
           ."           CASE \n"
           ."               WHEN t_sale_h.trade_id IN ($trade_id) THEN t_sale_d.cost_amount \n"
           ."               ELSE -1 * t_sale_d.cost_amount \n"
           ."           END \n"
           ."       ) AS cost_amount \n"
           ."   FROM \n"
           ."       t_sale_h \n"
           ."           INNER JOIN \n"
           ."       t_sale_d \n"
           ."       ON t_sale_h.sale_id = t_sale_d.sale_id \n"
           ."   WHERE \n"
           ."       t_sale_h.shop_id   = ".$shop_id." \n"
           ."       AND \n"
           ."       t_sale_h.sale_day >= '".$start_day."' \n"
           ."       AND \n"
           ."       t_sale_h.sale_day <= '".$end_day."' \n"
           ."       AND \n"
           ."       t_sale_d.".$div."_id IS NOT NULL \n";
                    //����оݤ����򤵤줿���
                    if($form_data["form_out_abstract"] == "1"){
    $sql .= "   AND \n"
           ."   t_sale_h.client_id != 93 \n";
                    }

    $sql .= "   GROUP BY t_sale_d.".$div."_id \n"
           ."   ) AS t_sale_data".$i." \n"
           ."   ON t_".$div.".".$div."_id = t_sale_data".$i.".".$div."_id \n";

    }

    //����������ܤξ��
    if($div == "goods"){

    $sql .= "       LEFT JOIN \n"
           ."   t_g_product \n"
           ."   ON t_goods.g_product_id = t_g_product.g_product_id \n"
           ."WHERE \n"
           //."   t_goods.public_flg = true \n";
           ."   t_goods.shop_id = 1 \n";
    }

    //���ʥ����ɤ����ꤵ�줿���
    if($form_data["form_goods"]["cd"] != null){
    $sql .= "   AND \n"
           ."   t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
    }

    //����̾�����ꤵ�줿���
    if($form_data["form_goods"]["name"] != null){
    $sql .= "   AND \n"
           ."   t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
    }

    //�Ͷ�ʬ�����ꤵ�줿���
    if($form_data["form_g_goods"] != null){
    $sql .= "   AND \n"
           ."   t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
    }

    //������ʬ�����ꤵ�줿���
    if($form_data["form_product"] != null){
    $sql .= "   AND \n"
           ."   t_goods.product_id = ".$form_data["form_product"]." \n";
    }

    //����ʬ�ब���ꤵ�줿���
    if($form_data["form_g_product"] != null){
    $sql .= "   AND \n"
           ."   t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
    }


    //�����ӥ������򤵤�Ƥ������
    if($form_data["form_serv"] != null){
    $sql .= "WHERE \n"
           ."   t_serv.serv_id = ".$form_data["form_serv"]." \n";
    }

    $sql .= "ORDER BY \n"
           ."   t_".$div.".".$div."_cd \n"
           .";";
#print_array($sql);
    $result = Db_Query($db_con, $sql);

    return $result;
}


/**
 * ô�����̡�����������ܥǡ�������ѥ���������ؿ�
 *
 * @author      fuku
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DB���ͥ������
 * @param       string      $form_data      POST����
 * @param       integer     $shop_id        ���å����Υ���å�ID
 * @param       array       $ary_ym         ��д��֤������YYYYMM������
 *
 * @return                  $res            ������¹Է��
 *
 * ����
 * ------------------------------------------------------
 * 2007-11-04   aizawa-m        rank_cd��rank_name��Null����Ф��ɲ�
 *
 */
function Select_Each_Staff_Goods_Amount_h($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // �ǡ�����о�����
    //-----------------------------------------------
    // ����Ū�ʸ������
    $sql = null;

    // ô����
    if ($post["form_staff"] != null) {
        $sql .= "AND \n";
        $sql .= "   t_staff.staff_id = ".$post["form_staff"]." \n";
    }

    // ���ʥ����ɡ��������ס�
    if ($post["form_goods"]["cd"] != null) {
        $sql .= "AND \n";
        $sql .= "   t_goods.goods_cd LIKE '".$post["form_goods"]["cd"]."%' \n";
    }

    // ����̾����ʬ���ס�
    if ($post["form_goods"]["name"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.goods_name LIKE '%".$post["form_goods"]["name"]."%' \n";
    }

    // �Ͷ�ʬ��ID��
    if ($post["form_g_goods"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.g_goods_id = ".$post["form_g_goods"]." \n";
    }

    // ������ʬ��ID��
    if ($post["form_product"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.product_id = ".$post["form_product"]." \n";
    }

    // ����ʬ���ID��
    if ($post["form_g_product"] != null) {
        $sql .= "AND \n";
        $sql .= " t_goods.g_product_id = ".$post["form_g_product"]." \n";
    }

    // �ѿ��˳�Ǽ
    $where_sql = $sql;

    // �ü�ʸ������
    $sql = null;

    // ����оݡ�bool��
    if ($post["form_out_abstract"] == "1") {
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.client_id != 93 \n";
    }

    $where_touyou_sql = $sql;

    // �ü�ʸ������
    $sql = null;

    // ����оݡ�bool��
    if ($post["form_out_abstract"] == "1") {
        $sql .= "AND \n";
    }

    $where_touyou_sql2 = $sql;

    //-----------------------------------------------
    // �ǡ�����Х��������
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')                                      AS cd,                  \n";
    $sql .= "   t_staff.staff_name                                                      AS name,                \n";
    $sql .= "   t_goods.goods_cd                                                        AS cd2,                 \n";
    $sql .= "   COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name   AS name2,               \n";
    $sql .= "   NULL                                                                    AS rank_cd,             \n";
    $sql .= "   NULL                                                                    AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0)                              AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0) - \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)                              AS arari_gaku".$cnt.",  \n";
    $sql .= "   NULL                                                                    AS num".$cnt.",         \n";
    }
    $sql .= "   t_attach.shop_id \n";

    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff          ON  t_attach.staff_id       = t_staff.staff_id          \n";
    $sql .= "   INNER JOIN t_goods_info     ON  t_attach.shop_id        = t_goods_info.shop_id      \n";
    $sql .= "   INNER JOIN t_goods          ON  t_goods_info.goods_id   = t_goods.goods_id          \n";
    $sql .= "   LEFT  JOIN t_g_product      ON  t_goods.g_product_id    = t_g_product.g_product_id  \n";

    // ���ꤵ�줿����ʬ�롼��
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // ������ʬ�Υǡ�������
        $sql .= "   LEFT JOIN ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_staff.staff_id, \n";
        $sql .= "           t_sale_d.goods_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.cost_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.sale_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS sale_amount \n";
        $sql .= "           FROM \n";
        $sql .= "               t_staff \n";
        $sql .= "               INNER JOIN t_sale_h ON  t_staff.staff_id  = t_sale_h.c_staff_id \n";
        $sql .= "                                   AND t_sale_h.sale_day LIKE '".$this_ym."%'  \n";
        $sql .= "                                   AND t_sale_h.shop_id  = 1                   \n";
        $sql .= "               INNER JOIN t_sale_d ON  t_sale_h.sale_id  = t_sale_d.sale_id    \n";
        $sql .= "                                   AND t_sale_d.goods_id IS NOT NULL           \n";
        $sql .=             $where_touyou_sql;
        $sql .= "           GROUP BY \n";
        $sql .= "               t_staff.staff_id, \n";
        $sql .= "               t_sale_d.goods_id \n";
        $sql .= "           ORDER BY \n";
        $sql .= "               t_staff.staff_id, \n";
        $sql .= "               t_sale_d.goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  t_staff.staff_id = analysis_".$cnt.".staff_id \n";
        $sql .= "   AND t_goods.goods_id = analysis_".$cnt.".goods_id \n";

    }

    // WHERE��
    $sql .= "WHERE \n";
    $sql .= "   t_attach.h_staff_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_staff.staff_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".goods_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "\n";
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;


    // �����Ƚ�
    $sql .= "ORDER BY \n";
    $sql .= "   t_staff.charge_cd, \n";
    $sql .= "   t_goods.goods_cd \n";
    $sql .= "; \n";


    //-----------------------------------------------
    // �ǡ�����м¹ԡ���̤��֤�
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * �ȼ��̡�����������ܥǡ�������ѥ���������ؿ�
 *
 * @author      fuku
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DB���ͥ������
 * @param       string      $form_data      POST����
 * @param       integer     $shop_id        ���å����Υ���å�ID
 * @param       array       $ary_ym         ��д��֤������YYYYMM������
 *
 * @return                  $res            ������¹Է��
 *
 * �ѹ�
 * ------------------------------------------------------
 * 2007-11-04   aizawa-m            rank_cd��rank_name��NULL����Ф��ɲ�
 *
 */
function Select_Each_Btype_Goods_Amount_h($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // �ǡ�����о�����
    //-----------------------------------------------
    // ����Ū�ʸ������
    $sql = null;

    // �ȼ��ID��
    if ($post["form_lbtype"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.id = ".$post["form_lbtype"]." \n";
    }

    // ���ʥ����ɡ��������ס�
    if ($post["form_goods"]["cd"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.cd2 LIKE '".$post["form_goods"]["cd"]."%' \n";
    }

    // ����̾����ʬ���ס�
    if ($post["form_goods"]["name"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.name2 LIKE '%".$post["form_goods"]["name"]."%' \n";
    }

    // �Ͷ�ʬ��ID��
    if ($post["form_g_goods"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.g_goods_id = ".$post["form_g_goods"]." \n";
    }

    // ������ʬ��ID��
    if ($post["form_product"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.product_id = ".$post["form_product"]." \n";
    }

    // ����ʬ���ID��
    if ($post["form_g_product"] != null) {
        $sql .= "AND \n";
        $sql .= "   analysis_base.g_product_id = ".$post["form_g_product"]." \n";
    }

    // �ѿ��˳�Ǽ
    $where_sql = $sql;

    // �ü�ʸ������
    $sql = null;

    // ����оݡ�bool��
    if ($post["form_out_abstract"] == "1") {
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.client_id != 93 \n";
    }

    $where_touyou_sql = $sql;

    //-----------------------------------------------
    // �ǡ�����Х��������
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";

    $sql .= "   analysis_base.cd                                    AS cd,                  \n";
    $sql .= "   analysis_base.name                                  AS name,                \n";
    $sql .= "   analysis_base.id2                                   AS id2,                 \n";
    $sql .= "   analysis_base.cd2                                   AS cd2,                 \n";
    $sql .= "   analysis_base.name2                                 AS name2,               \n";
    $sql .= "   NULL                                                AS rank_cd,             \n";
    $sql .= "   NULL                                                AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0)          AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".sale_amount, 0) - \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)          AS arari_gaku".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".num, 0)                  AS NUM".$cnt.((count($ary_ym) != $cnt) ? ", \n" : "\n");
    }

    $sql .= "FROM \n";

    // ���ܥơ��֥�
    $sql .= "   ( \n";
    $sql .= "        SELECT \n";
    $sql .= "            t_lbtype.lbtype_id                                                     AS id, \n";
    $sql .= "            t_lbtype.lbtype_cd                                                     AS cd, \n";
    $sql .= "            t_lbtype.lbtype_name                                                   AS name, \n";
    $sql .= "            t_goods.goods_id                                                       AS id2, \n";
    $sql .= "            t_goods.goods_cd                                                       AS cd2, \n";
    $sql .= "            COALESCE(t_g_product.g_product_name, '') || ' ' || t_goods.goods_name  AS name2, \n";
    $sql .= "            t_goods.g_goods_id, \n";
    $sql .= "            t_goods.product_id, \n";
    $sql .= "            t_goods.g_product_id \n";
    $sql .= "        FROM \n";
    $sql .= "            t_lbtype \n";
    $sql .= "            INNER JOIN t_sbtype     ON  t_lbtype.lbtype_id      = t_sbtype.lbtype_id \n";
    $sql .= "            INNER JOIN t_client     ON  t_sbtype.sbtype_id      = t_client.sbtype_id \n";
    $sql .= "                                    AND client_div              = '3' \n";
    $sql .= "            INNER JOIN t_goods_info ON  t_client.shop_id        = t_goods_info.shop_id \n";
    $sql .= "                                    AND t_goods_info.shop_id    = 1 \n";
    $sql .= "            INNER JOIN t_goods      ON  t_goods_info.goods_id   = t_goods.goods_id \n";
    $sql .= "            LEFT  JOIN t_g_product  ON  t_goods.g_product_id    = t_g_product.g_product_id \n";
    $sql .= "                                    AND t_g_product.shop_id     = 1 \n";
    $sql .= "        GROUP BY \n";
    $sql .= "            t_lbtype.lbtype_id, \n";
    $sql .= "            t_lbtype.lbtype_cd, \n";
    $sql .= "            t_lbtype.lbtype_name, \n";
    $sql .= "            t_goods.goods_id, \n";
    $sql .= "            t_goods.goods_cd, \n";
    $sql .= "            t_g_product.g_product_name, \n";
    $sql .= "            t_goods.goods_name, \n";
    $sql .= "            t_goods.g_goods_id, \n";
    $sql .= "            t_goods.product_id, \n";
    $sql .= "            t_goods.g_product_id \n";
    $sql .= "        ORDER BY \n";
    $sql .= "            t_lbtype.lbtype_cd, \n";
    $sql .= "            t_goods.goods_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS analysis_base \n";

    // ���ꤵ�줿����ʬ�롼��
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // �����ʬ�Υǡ����ơ��֥�
        $sql .= "   LEFT JOIN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_sbtype.lbtype_id  AS lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id   AS goods_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.num, 0) *  1 \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (14, 64) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.num, 0) *  0 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.num, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS num, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.cost_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.cost_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN COALESCE(t_sale_d.sale_amount, 0) *  1 \n";
        $sql .= "                   ELSE COALESCE(t_sale_d.sale_amount, 0) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS sale_amount \n";
        $sql .= "       FROM \n";
        $sql .= "           t_sbtype \n";
        $sql .= "           INNER JOIN t_client ON  t_sbtype.sbtype_id  = t_client.sbtype_id \n";
        $sql .= "           INNER JOIN t_sale_h ON  t_client.client_id  = t_sale_h.client_id \n";
        $sql .= "                               AND t_sale_h.sale_day  LIKE '".$this_ym."%' \n";
        $sql .= "                               AND t_sale_h.shop_id    = 1 \n";
        $sql .= "           INNER JOIN t_sale_d ON  t_sale_h.sale_id    = t_sale_d.sale_id \n";
        $sql .= "                               AND t_sale_d.goods_id   IS NOT NULL \n";
        $sql .=         $where_touyou_sql;
        $sql .= "       GROUP BY \n";
        $sql .= "           t_sbtype.lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id \n";
        $sql .= "       ORDER BY \n";
        $sql .= "           t_sbtype.lbtype_id, \n";
        $sql .= "           t_sale_d.goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  analysis_base.id    = analysis_".$cnt.".lbtype_id \n";
        $sql .= "   AND analysis_base.id2   = analysis_".$cnt.".goods_id \n";

    }

    // WHERE��
    $sql .= "WHERE \n";
    $sql .= "   analysis_base.id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".goods_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "\n"; 
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;

    // �����Ƚ�
    $sql .= "ORDER BY \n";
    $sql .= "   analysis_base.cd, \n";
    $sql .= "   analysis_base.cd2 \n";
    $sql .= "; \n";
//print_array($sql);

    //-----------------------------------------------
    // �ǡ�����м¹ԡ���̤��֤�
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}


/**
 * �ȼ���(FC��������)�� ����ܤζ�ۤ����  
 *
 * �ѹ�����  
 * 1.0.0 (2007/10/19) �������� <br>
 * 
 * @author      aizawa-m <aizawa-m@bhsk.co.jp> 
 * 
 * @param       conection    $db_con    DB���ͥ������
 * @param       array        $post      ���̤����Ϥ��줿���������ݻ�����$_POST
 *  
 * @return      resource     $result    �����긡�����
 *
 */ 
function Select_Each_Type_Customer_Amount ( $db_con, $post ) {

    /*****************************/
    // SESSION�ѿ��μ���
    /*****************************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /****************************/
    // �������鸡���������
    /****************************/
    $start_y        = $post["form_trade_ym_s"]["y"];    //���״���(ǯ)
    $start_m        = $post["form_trade_ym_s"]["m"];    //���״���(��)
    $period         = $post["form_trade_ym_e"];         //���״���
    $lbtype_id      = $post["form_lbtype"];             //�ȼ�ID
    $client_cd1     = $post["form_client"]["cd1"];      //�����襳����1
    $client_cd2     = $post["form_client"]["cd2"];      //�����襳����2
    $client_name    = $post["form_client"]["name"];     //������̾
    $rank_cd        = $post["form_rank"];               //FC��������ʬ������
    $client_gr_cd   = $post["form_client_gr"]["cd"];    //���롼��ID
    $client_gr_name = $post["form_client_gr"]["name"];  //���롼��̾
    $margin         = $post["form_margin"];             //����Ψ
    $out_range      = $post["form_out_range"];          //ɽ���о�
    $out_abstract   = $post["form_out_abstract"];       //����о�

    //�����ξ��
    if ( $group_kind == "1" ) {
        $client_div = "3";  //FC
    } else {
        $client_div = "1";  //������
    }


    /***************************/
    // ���������
    /***************************/

    // ------ �ȼ老�ȤǤޤȤ�� ------ //
    $sql.=  "SELECT \n";
    $sql.=  "   t_lbtype.lbtype_cd AS cd, \n";        //��ʬ��ȼ拾����
    $sql.=  "   t_lbtype.lbtype_name AS name, \n";      //��ʬ��ȼ�̾
    $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd2, \n";//�����襳����
    $sql.=  "   t_client.client_cname AS name2, \n";     //������̾


    //���״���ʬ������ۤ����
    #for ( $i=0 ; $i<$period ; $i++ ) {
    #    $sql.=  "t_client_new.net_amount".(string)($i+1).", \n";    //���������
    #    $sql.=  "t_client_new.arari_gaku".(string)($i+1).", \n";    //���������׳�
    #}

    //���״���ʬ������ۤ����
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( \n";  //�����
        $sql.=  "      t_sale_h".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   COALESCE( \n";  //�����׳�
        $sql.=  "      t_sale_h".(string)($i+1).".arari_gaku, 0) AS arari_gaku".(string)($i+1).", \n";

        $sql.=  "   NULL AS num".(string)($i+1).", \n";     //������̾
    }
    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC��������ʬ������
    $sql.=  "   t_rank.rank_name AS rank_name \n";     //FC��������ʬ̾


    $sql.=  "FROM \n";
    $sql.=  "   t_lbtype \n";//��ʬ��ޥ���

    #hashimoto-y
    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_sbtype \n";//
    $sql.=  "ON t_lbtype.lbtype_id = t_sbtype.lbtype_id \n";//

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_client \n";//
    $sql.=  "ON t_sbtype.sbtype_id = t_client.sbtype_id \n";//

    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_client_gr \n";
    $sql.=  "ON t_client.client_gr_id = t_client_gr.client_gr_id \n";

    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_rank \n";
    $sql.=  "ON t_client.rank_cd = t_rank.rank_cd \n";



    //------ �����褴�Ȥ����ι�פ���� START ------ //
    for ( $i=0 ; $i<$period ; $i++ ) {
        //���դν񼰤��Ѥ���
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));   
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "       LEFT JOIN \n";  //t_sale_h($i)
        $sql.=  "           (  SELECT \n";
        $sql.=  "                   client_id, \n";
        $sql.=  "                   net_amount, \n";
        $sql.=  "                   (net_amount - cost_amount) AS arari_gaku \n";
        $sql.=  "               FROM \n";


        $sql.=  "                   (   SELECT \n";
        $sql.=  "                           SUM ( \n";  //����ۤι��  
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) \n";
        $sql.=  "                                   THEN t_sale_h.net_amount \n";
        $sql.=  "                                   ELSE -1 * t_sale_h.net_amount \n";
        $sql.=  "                               END \n";
        $sql.=  "                           ) AS net_amount, \n";
        $sql.=  "                           SUM ( \n";  //�����ۤι��
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) \n";
        $sql.=  "                                   THEN t_sale_h.cost_amount \n";
        $sql.=  "                                   ELSE -1 * t_sale_h.cost_amount \n";
        $sql.=  "                               END \n";
        $sql.=  "                           ) AS cost_amount, \n";
        $sql.=  "                           client_id \n";
        $sql.=  "                       FROM \n";
        $sql.=  "                           t_sale_h \n";
        $sql.=  "                       WHERE \n";
        $sql.=  "                               shop_id = $shop_id \n";
        $sql.=  "                           AND \n";
        $sql.=  "                               sale_day >= '$this_date' \n";
        $sql.=  "                           AND \n";
        $sql.=  "                               sale_day < '$next_date' \n";
        $sql.=  "                       GROUP BY \n";
        $sql.=  "                           client_id \n";
        $sql.=  "                   ) t_sale_h \n";


        $sql.=  "               ORDER BY \n";
        $sql.=  "                   client_id \n";
        $sql.=  "           ) AS t_sale_h".(string)($i+1)." \n";
        $sql.=  "                ON t_client.client_id = t_sale_h".(string)($i+1).".client_id \n";



        // ����оݤ����۰ʳ�
        if ( $out_abstract ==  "1" ) {
            $sql.=  "           AND \n";
            $sql.=  "               t_sale_h".(string)($i+1).".client_id <> 93 \n";
        }
    }

    $sql.=  "       WHERE \n";
    $sql.=  "               t_client.shop_id = $shop_id \n";
    $sql.=  "           AND \n";
    $sql.=  "               t_client.client_div = $client_div \n";

    /*******************************/
    // ���������ɲ�
    /*******************************/
    if ( $client_cd1 != NULL ) { 
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    if ( $client_cd2 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd2 LIKE '$client_cd2%' \n";    
    }
    if ( $client_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           ( \n";
        $sql.=  "               t_client.client_name LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_name2 LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "           ) \n";
    }
    if ( $rank_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.rank_cd = '$rank_cd' \n";
    }
    if ( $client_gr_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_gr_id = $client_gr_cd \n";
    }
    if ( $client_gr_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n";
    }

    // �ֶȼ�פθ������    
    if ( $lbtype_id != NULL ) {
        $sql.=  "   AND \n";
        $sql.=  "   t_lbtype.lbtype_id = $lbtype_id \n";
    }

    $sql.=  "ORDER BY \n";
    $sql.=  "   t_lbtype.lbtype_cd \n";
    $sql.=  ";";
   
    //echo nl2br($sql);

    /***********************/
    // ������μ¹�
    /***********************/
    $result = Db_Query($db_con, $sql);

    #hashimoto-y
    $debug_flg = false;
    if($debug_flg == "true"){
        $count = pg_num_rows($result );

        for ( $i=0 ; $i < $count ; $i++ ) {
            $column_cd = pg_fetch_result($result, $i, "cd");
            $column_name = pg_fetch_result($result, $i, "name");
            $column_cd2 = pg_fetch_result($result, $i, "cd2");
            $column_name2 = pg_fetch_result($result, $i, "name2");

            $column = "net_amount" .(int)$start_m;
            $column_net_amount = pg_fetch_result($result, $i,  $column);
            echo "cd : " .$column_cd ."<br>";
            echo "name : " .$column_name ."<br>";
            echo "cd2 : " .$column_cd2 ."<br>";
            echo "name2 : " .$column_name2 ."<br>";
            echo "net_amount : " .$column_net_amount ."<br><br>";

        }

    }

    return $result;

}

/**
 * �������̾����̻�������ѤΥ�����¹Դؿ� 
 *
 * �ѹ����� 
 * 1.0.0 (2007/10/17)   aizawa-m    �������� <br>
 *
 * 
 * @param   conection   $db_con     DB���ͥ������
 * @param   array       $post       $_POST          
 *
 * @return  resource    $result     ������¹ԥ꥽����
 *
 */
function Select_Each_Goods_Supplier ($db_con, $_POST) {

    /***********************/
    // SESSION�ѿ��μ���
    /***********************/
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /***********************/
    // �����������
    /***********************/
    $period         = $_POST["form_trade_ym_e"];   
    $start_y        = $_POST["form_trade_ym_s"]["y"];   
    $start_m        = $_POST["form_trade_ym_s"]["m"];   

    $client_cd1     = $_POST["form_client"]["cd1"];      //�����襳����1
    $client_cd2     = $_POST["form_client"]["cd2"];      //�����襳����2
    $client_name    = $_POST["form_client"]["name"];     //������̾
    $rank_cd        = $_POST["form_rank"];               //FC��������ʬ������

    $goods_cd       = $_POST["form_goods"]["cd"];        //���ʥ�����
    $goods_name     = $_POST["form_goods"]["name"];      //����̾

    $g_goods        = $_POST["form_g_goods"];            //�Ͷ�ʬ
    $product        = $_POST["form_product"];            //������ʬ
    $g_product      = $_POST["form_g_product"];          //����ʬ��

    $out_range      = $_POST["form_out_range"];          //ɽ���о�
    $out_abstract   = $_POST["form_out_abstract"];       //����о�


//    echo "period:" .$period ."<br>";


    // �����ξ��
    if ( $group_kind == "1" ) {
        $client_div = "3";  //FC
    } else {
        $client_div = "2";  //������
    }


    /***********************/
    // ���������
    /***********************/

    $sql =  "SELECT \n";

    //�����ξ��ϡ������襳���ɣ��������襳���ɣ������
    if ( $group_kind == "1" ) { 
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    //FC�ξ��ϡ������襳���ɣ��Τ����
    } else {
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    }

    $sql.=  "   t_client.client_cname AS name, \n"; 

    $sql.=  "   t_client.goods_cd AS cd2, \n";
    $sql.=  "   t_client.g_product_name || ' ' || t_client.goods_name AS name2, \n";

    for ($i = 0; $i < $period; $i++ ) {
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).", \n";
        $sql.=  "   0 AS arari_gaku".(string)($i+1).", \n";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".num , 0) AS num".(string)($i+1).", \n";
        $sql.=  "   t_buy_d".(string)($i+1).".goods_id AS goods_id".(string)($i+1).", \n";
    }

    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC��������ʬ������
    $sql.=  "   t_client.rank_name AS rank_name \n";     //FC��������ʬ̾

//  2007-11-11 ������
////    $sql.=  "   t_client.shop_id \n";

    $sql.=  "FROM \n";

    //�������̾��ʾ���ơ��֥�
    $sql .= "   (\n";
    $sql .= "   SELECT\n";
    $sql .= "       t_client.client_id,  \n";
    $sql .= "       t_client.client_cd1, \n";
    $sql .= "       t_client.client_cd2, \n";
    $sql .= "       t_client.client_cname, \n";
    $sql .= "       t_client.shop_id, \n";
    $sql .= "       t_goods.goods_id,    \n";
    $sql .= "       t_goods.goods_cd,    \n";
    $sql .= "       t_goods.goods_name,  \n";
    $sql .= "       t_g_product.g_product_name, \n";
    $sql .= "       t_rank.rank_cd,      \n";
    $sql .= "       t_rank.rank_name     \n";
    $sql .= "   FROM \n";
    $sql .= "       t_client \n";
    $sql .= "           INNER JOIN  \n";
    $sql .= "       t_goods_info \n";
    $sql .= "       ON t_client.shop_id = t_goods_info.shop_id \n";
    $sql .= "       AND t_client.shop_id = $shop_id \n";
    $sql .= "           INNER JOIN  \n";
    $sql .= "       t_goods \n";
    $sql .= "       ON t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "           LEFT JOIN  \n";
    $sql .= "       t_g_product \n";
    $sql .= "       ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "           LEFT JOIN  \n";
    $sql .= "       t_rank \n";
    $sql .= "       ON t_client.rank_cd = t_rank.rank_cd \n";

    $sql .= "   WHERE \n";
    $sql .= "       t_client.client_div = '$client_div' \n";

    // ���������ɲ�
    if ( $client_cd1 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd1 LIKE '$client_cd1%' \n";
    }
    if ( $client_cd2 != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.client_cd2 LIKE '$client_cd2%' \n";    }
    if ( $client_name != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           ( \n";
        $sql.=  "               t_client.client_name LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_name2 LIKE '%$client_name%' \n";
        $sql.=  "           OR \n";
        $sql.=  "               t_client.client_cname LIKE '%$client_name%' \n";
        $sql.=  "           ) \n";    }
    if ( $rank_cd != NULL ) {
        $sql.=  "       AND \n";
        $sql.=  "           t_client.rank_cd = '$rank_cd' \n";
    }
    //���ʥ����ɤ����ꤵ�줿���
    if($goods_cd != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.goods_cd LIKE '".$goods_cd."%' \n";
    }
    //����̾�����ꤵ�줿���
    if($goods_name != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.goods_name LIKE '%".$goods_name."%' \n";
    }
    //�Ͷ�ʬ�����ꤵ�줿���
    if($g_goods != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.g_goods_id = ".$g_goods." \n";
    }
    //������ʬ�����ꤵ�줿���
    if($product != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.product_id = ".$product." \n";
    }
    //����ʬ�ब���ꤵ�줿���
    if($g_product != null){
        $sql .= "    AND \n";
        $sql .= "    t_goods.g_product_id = ".$g_product." \n";
    }

    $sql .= "   ) AS t_client \n";

    //����λ������ץơ��֥�
    for ( $i = 0; $i < $period; $i++ ) {
        // ���դν񼰤��Ѥ���

/*
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));
*/

        $like_day =  date("Y-m-", mktime(0,0,0, $start_m + $i, 1, $start_y));

        $sql .= "       LEFT JOIN \n";
        $sql .= "   (\n";
        $sql .= "   SELECT \n";
        $sql .= "       t_buy_h.client_id, \n"; 
        $sql .= "       t_buy_d.goods_id, \n"; 
        $sql .= "       SUM ( \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql .= "               THEN t_buy_d.buy_amount \n";
        $sql .= "               ELSE -1 * t_buy_d.buy_amount \n";   
        $sql .= "           END \n";
        $sql .= "       ) AS net_amount, \n";
        $sql .= "       SUM ( \n";
        $sql .= "           CASE \n";
        $sql .= "               WHEN t_buy_h.trade_id IN (21, 25, 71) THEN t_buy_d.num\n";
        $sql .= "               WHEN t_buy_h.trade_id IN (24, 74) THEN 0 \n";
        $sql .= "               ELSE -1 * t_buy_d.num \n";
        $sql .= "           END \n";
        $sql .= "       ) AS num \n";
        $sql .= "   FROM \n";
        $sql .= "       t_buy_h \n";
        $sql .= "           INNER JOIN \n";
        $sql .= "       t_buy_d \n";
        $sql .= "       ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql .= "   WHERE \n";
        $sql .= "       t_buy_h.shop_id = $shop_id \n";
/*
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day >= '$this_date' \n";
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day < '$next_date' \n";
*/
        $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day LIKE '$like_day%' \n";

        $sql .= "   GROUP BY \n";
        $sql .= "       t_buy_h.client_id, \n";
        $sql .= "       t_buy_d.goods_id \n";
        $sql .= "   ) AS t_buy_d".(string)($i+1). " \n";
        $sql .= "   ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";
        $sql .= "   AND t_client.goods_id = t_buy_d".(string)($i+1).".goods_id \n";

// 2007-11-11 ������
//        $sql .= "   AND t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";


        // ����оݤ����۰ʳ�
        if ( $out_abstract ==  "1" ) {
            $sql.=  "   AND \n";
            $sql.=  "   t_buy_d".(string)($i+1).".client_id <> 93 \n";
        } 
    }


    //�����Τʤ����ʤ���Ф��ʤ���kaji��
    //¾���̤Ȼ��ͤ���äƤ��뤱�ɡ�419874�733��ޤǸ��餻�ޤ�
    $sql .= "WHERE \n";
    $sql .= "    ( \n";
    for ( $i = 0; $i < $period; $i++ ) {
        $sql .= "        t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";
        $sql .= ($i < $period - 1) ? "        OR \n" : "";
    }
    $sql .= "    ) \n";


    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2, \n";
    $sql.=  "   t_client.goods_cd \n";
    $sql.=  ";";
    
#    print_array($sql);

    /********************/
    // ������¹�
    /********************/
    $result = Db_Query($db_con, $sql);

    return $result;
}


/**
 * ���� ���Ķ�����    �ǡ�������ѥ���������ؿ�
 * FC   ô����������ܥǡ�������ѥ���������ؿ�
 * 
 * @author      fukuda
 * @version     1.0.0 (2007/11/03)
 *
 * @param       resource    $db_con         DB���ͥ������
 * @param       string      $form_data      POST����
 * @param       integer     $shop_id        ���å����Υ���å�ID
 * @param       array       $ary_ym         ��д��֤������YYYYMM������
 *
 * @return                  $res            ������¹Է��
 *
 */
function Select_Each_Part_Staff_Amount($db_con, $post, $shop_id, $ary_ym){

    //-----------------------------------------------
    // ������ǽ�ѽ���
    //-----------------------------------------------
    // ������ǽ�ξ��
    if ($shop_id === "1" ) {

        // ���ν�����$shop_id���񤭤��Ƥ��ޤ��ΤǸ����ͤ��̤��ѿ�������Ƥ���
        $session_shop_id = $shop_id;

        // �����ϥ���åפ�����ɬ�ܤʤΤǡ����򤵤줿����åפ�������Ӥ���Ϥ����Ѥ��ѿ�����
        // ����åפ����򤵤�Ƥ�����ϡ����򤵤줿�ͤ��Ǽ
        $shop_id = ($post["form_shop_part"][1] != null) ? $post["form_shop_part"][1] : $shop_id;

    }

    //-----------------------------------------------
    // �ǡ�����о�����
    //-----------------------------------------------
    // ����Ū�ʸ������
    $sql = null;

    // ������ǽ�ξ��
    if ($session_shop_id === "1") {

        // �����ID��
        if ($post["form_shop_part"][2] != null) {
            $sql .= "AND \n";
            $sql .= "   t_part.part_id = ".$post["form_shop_part"][2]." \n";
        }

    // FC��ǽ�ξ��
    } else {

        // �����ID��
        if ($post["form_part"] != null) {
            $sql .= "AND \n";
            $sql .= "   t_part.part_id = ".$post["form_part"]." \n";
        }

        // ô���ԡ�ID��
        if ($post["form_staff"] != null) {
            $sql .= "AND \n";
            $sql .= "   t_staff.staff_id = ".$post["form_staff"]." \n";
        }

    }

    // �ѿ��˳�Ǽ
    $where_sql = $sql;

    //-----------------------------------------------
    // �ǡ�����Х��������
    //-----------------------------------------------
    $sql  = null;

    $sql .= "SELECT \n";

    $sql .= "   t_part.part_cd                                  AS cd,                  \n";
    $sql .= "   t_part.part_name                                AS name,                \n";
    $sql .= "   to_char(t_staff.charge_cd, '0000')              AS cd2,                 \n";
    $sql .= "   t_staff.staff_name                              AS name2,               \n";
    $sql .= "   NULL                                            AS rank_cd,             \n";
    $sql .= "   NULL                                            AS rank_name,           \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "   COALESCE(analysis_".$cnt.".net_amount,  0)      AS net_amount".$cnt.",  \n";
    $sql .= "   COALESCE(analysis_".$cnt.".net_amount,  0) -                            \n";
    $sql .= "   COALESCE(analysis_".$cnt.".cost_amount, 0)      AS arari_gaku".$cnt.",  \n";
    $sql .= "   NULL                                            AS num".$cnt.",         \n";
    }
    $sql .= "   t_attach.shop_id                                                        \n";

    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_part   ON  t_attach.part_id        = t_part.part_id        \n";
    $sql .= "   INNER JOIN t_staff  ON  t_attach.staff_id       = t_staff.staff_id      \n";

    // ���ꤵ�줿����ʬ�롼��
    foreach ($ary_ym as $key => $this_ym) {

        $cnt  = (string)($key + 1);

        // ������ʬ�Υǡ�������
        $sql .= "   LEFT JOIN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN \n";
        $sql .= "                       CASE t_sale_staff.staff_div \n";
        $sql .= "                           WHEN '0' \n";
        $sql .= "                           THEN t_sale_h.cost_amount - COALESCE(t_sale_h_sub.cost_amount, 0) \n";
        $sql .= "                           ELSE trunc(t_sale_h.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ELSE (t_sale_h.cost_amount - COALESCE(t_sale_h_sub.cost_amount, 0)) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS cost_amount, \n";
        $sql .= "           SUM( \n";
        $sql .= "               CASE \n";
        $sql .= "                   WHEN t_sale_h.trade_id IN (11, 15, 61) \n";
        $sql .= "                   THEN \n";
        $sql .= "                       CASE t_sale_staff.staff_div \n";
        $sql .= "                           WHEN '0' \n";
        $sql .= "                           THEN t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0) \n";
        $sql .= "                           ELSE trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ELSE (t_sale_h.net_amount - COALESCE(t_sale_h_sub.net_amount, 0)) * -1 \n";
        $sql .= "               END \n";
        $sql .= "           ) \n";
        $sql .= "           AS net_amount \n";
        $sql .= "       FROM \n";
        $sql .= "           t_sale_h \n";
        $sql .= "           INNER JOIN t_sale_staff ON  t_sale_h.sale_id        = t_sale_staff.sale_id  \n";
        $sql .= "           INNER JOIN t_attach     ON  t_sale_staff.staff_id   = t_attach.staff_id     \n";
        // ���֤Τߤι�׶�ۤ򽸷פ��륵�֥�����
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   t_sale_h.sale_id, \n";
        $sql .= "                   SUM(\n";
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                           THEN trunc(t_sale_h.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ) AS cost_amount, \n";
        $sql .= "                   SUM(\n";
        $sql .= "                       CASE \n";
        $sql .= "                           WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                           THEN trunc(t_sale_h.net_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                       END \n";
        $sql .= "                   ) AS net_amount \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_sale_h \n";
        $sql .= "                   INNER JOIN t_sale_staff ON  t_sale_h.sale_id = t_sale_staff.sale_id \n";
        $sql .= "               WHERE \n";
        $sql .= "                   t_sale_h.shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_h.sale_day LIKE '$this_ym%' \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "               AND \n";
        $sql .= "                   t_sale_staff.staff_div != '0' \n";
        $sql .= "               GROUP BY t_sale_h.sale_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_sale_h_sub ON  t_sale_h.sale_id = t_sale_h_sub.sale_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_sale_h.shop_id = $shop_id \n";
        $sql .= "       AND \n";
        $sql .= "           t_sale_h.sale_day LIKE '$this_ym%' \n";
        $sql .= "       AND \n";
        $sql .= "           t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "       GROUP BY \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       ORDER BY \n";
        $sql .= "           t_attach.part_id, \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS  analysis_".$cnt." \n";
        $sql .= "   ON  t_part.part_id      = analysis_".$cnt.".part_id \n";
        $sql .= "   AND t_staff.staff_id    = analysis_".$cnt.".staff_id \n";

    }

    // WHERE��
    $sql .= "WHERE \n";
    $sql .= "   t_attach.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_part.part_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   ( \n";
    foreach ($ary_ym as $key => $this_ym) {
    $cnt  = (string)($key + 1);
    $sql .= "       analysis_".$cnt.".staff_id IS NOT NULL \n";
    $sql .= (count($ary_ym) != $cnt) ? "        OR \n" : "";
    }
    $sql .= "   ) \n";
    $sql .= $where_sql;

    // �����Ƚ�
    $sql .= "ORDER BY \n";
    $sql .= "   t_part.part_cd, \n";
    $sql .= "   t_staff.charge_cd \n";
    $sql .= "; \n";

    // �ǥХå���
    #print_array($sql, "������");

    //-----------------------------------------------
    // �ǡ�����м¹ԡ���̤��֤�
    //-----------------------------------------------
    $res  = Db_Query($db_con, $sql);

    return $res;

}



/**
 * ô�����̡�����������ܥǡ�������ѥ���������ؿ�
 *
 *
 * ����
 *
 * �����ǡ����Υ����ӥ��������ƥ��̵ͭ�ˤ�� <br>
 *   �ʲ���ɽ�Ρ�ɽ���פζ�ۤȤ���ɽ������ <br>
 *
 *    �����ӥ�  |  �����ƥ�  |    ɽ��      <br>
 *  --------------------------------------  <br>
 *       ��     |     ��     |    ����      <br>
 *       ��     |     ��     |  �����ӥ�    <br>
 *       ��     |     ��     |    ����      <br>
 *
 * �����Ҥ�ô���ԤΤ�����оݤȤ��Ƥ���Τǡ� <br>
 *   ľ�ĤǤϼ��ҽ������Τߤν��פˤʤ� <br>
 *   �����Ǥ������ɼ�ϡֶ�̳������פȤ������ʤˤ����� <br>
 *
 * ���������� <br>
 *     ���ʥ����ɡ�����̾���Ͷ�ʬ��������ʬ������ʬ�� <br>
 *   �����ꤵ�줿���ϥ����ӥ��Τߤ����ǡ�������Ф��ʤ� <br>
 *
 * ��������η�̤򸺤餹���ᡢ <br>
 *   ���Τʤ��ä����ʡ������ӥ��ϼ�äƤ��Ƥޤ��� <br>
 *   ��¾���̤Ȼ��ͤ��㤦�ߤ����Ǥ������������������ư���ޤ����
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.1.0 (2007/12/01)
 *
 * @param       resource    $db_con         DB���ͥ������
 * @param       string      $form_data      POST����
 *
 * @return      resource    $resut          ������¹Է��
 *
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/11/03                  kajioka-h   ��������
 *  2007/11/04                  aizawa-m    rank_cd��rank_name��NULL�����
 *  2007/11/23                  kajioka-h   �����ʤ���Ф���褦�˽���
 *  2007/11/24                  hashimoto-y �־���+�����ӥ��פȡ֥����ӥ��פ�����UNION
 *  2007/12/01                  kajioka-h   �������ɲá��������򥭥쥤�ˡʳᲬŪ�ˡ�
 *
 */


//�־���+�����ӥ��פȡ֥����ӥ��פ�UNION����������
//���餯�־��ʡפȡ֥����ӥ�+���ʡפ�UNION����������Τۤ����ɤ�
//12����¹Ԥ��Ƥ�ϣ�

function Select_Each_Staff_Goods_Amount_f($db_con, $form_data)
{

    //���å����
    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    $sql  = "";
    //$sql  = "EXPLAIN \n";


    //���ʤ���Ф��륯����
    $sql .= "SELECT \n";
    $sql .= "    to_char(t_staff.charge_cd, '0000') AS cd, \n";
    $sql .= "    t_staff.staff_name AS name, \n";

    $sql .= "    t_goods.goods_cd AS cd2, \n";
    $sql .= "    CASE \n";
    $sql .= "        WHEN t_goods.compose_flg = true THEN t_goods.goods_name \n";
    $sql .= "        ELSE t_g_product.g_product_name || ' ' || t_goods.goods_name \n";
    $sql .= "    END AS name2, \n";

    $sql .= "    NULL AS rank_cd, \n";  //aizawa-m
    $sql .= "    NULL AS rank_name, \n";// �ɲ�
    $sql .= "    1, \n";    //���ʡ������ӥ���ʬ�����ʤϡ�1�סʰ����Ǿ��ʡ������ӥ��ν��ɽ�����뤿���
    //�������ʬ�롼�סʼ���������
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
        //�����
        $sql .= "    COALESCE(t_sale_".(string)($i+1).".sale_amount, 0) AS net_amount".(string)($i+1).", \n";
        //�����׳�
        $sql .= "    COALESCE((t_sale_".(string)($i+1).".sale_amount - t_sale_".(string)($i+1).".cost_amount), 0) AS arari_gaku".(string)($i+1).", \n";
        //����
        $sql .= "    NULL AS num".(string)($i+1).", \n";
    }
    $sql .= "    t_attach.shop_id \n";  //�ä�ɬ�פʤ����ɡ���Υ롼�׽�ü�ǡ�,�פ��դ��ʤ�Ƚ��򤷤ʤ�����
    $sql .= "FROM \n";
    $sql .= "    t_attach \n";
    $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "        AND t_attach.shop_id = $shop_id \n";
    $sql .= "    INNER JOIN t_goods_info ON t_attach.shop_id = t_goods_info.shop_id \n";
    $sql .= "        AND t_goods_info.shop_id = $shop_id \n";
    $sql .= "    INNER JOIN t_goods ON t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "    LEFT JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    //��°�ܻ�Ź�����𤬻��ꤵ�줿��硢����ޥ����ơ��֥����
    if($form_data["form_branch"] != null || $form_data["form_part"] != null){
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
    }

    //�������ʬ�롼�ס�1����Ȥν��ץ��֥������
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){

        //���դν񼰤��Ѥ���
        $this_date = date("Y-m-", mktime(0, 0, 0, $form_data["form_trade_ym_s"]["m"] + $i, 1, $form_data["form_trade_ym_s"]["y"]));

        //1����ʬ���ץ��֥�����
        $sql .= "    LEFT JOIN ( \n";
        $sql .= "        SELECT \n";
        $sql .= "            t_sale_staff.staff_id, \n";
        $sql .= "            t_sale_d.goods_id, \n";

        //$sql .= "            t_sale_d.serv_id, \n";  //hashimoto�ɲ�

        //1����θ�����۹��
        $sql .= "            SUM( \n";
        $sql .= "                CASE \n";
        $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
        $sql .= "                        CASE t_sale_staff.staff_div \n";
        $sql .= "                            WHEN '0' THEN t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0) \n";
        $sql .= "                            ELSE trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ELSE \n";

                                        //�Ͱ������ʤξ��ϥᥤ�󤷤����ʤ�
        $sql .= "                            -1 * (t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0)) \n";
        $sql .= "                END \n";
        $sql .= "            ) AS cost_amount, \n";
        //1���������۹��
        $sql .= "            SUM( \n";
        $sql .= "                CASE \n";
        $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
        $sql .= "                        CASE t_sale_staff.staff_div \n";
        $sql .= "                            WHEN '0' THEN t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0) \n";
        $sql .= "                            ELSE trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ELSE \n";

                                        //�Ͱ������ʤξ��ϥᥤ�󤷤����ʤ�
        $sql .= "                            -1 * (t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0)) \n";
        $sql .= "                END \n";
        $sql .= "            ) AS sale_amount \n";

        $sql .= "        FROM \n";
        $sql .= "            t_sale_h \n";
        $sql .= "            INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "            INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
        //���֤Τߤι�׶�ۤ򽸷פ��륵�֥�����\n";
        $sql .= "            LEFT JOIN ( \n";
        $sql .= "                SELECT \n";
        $sql .= "                    t_sale_d.sale_d_id, \n";
        $sql .= "                    SUM( \n";
        $sql .= "                        CASE \n";
        $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                                THEN trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ) AS cost_amount, \n";
        $sql .= "                    SUM( \n";
        $sql .= "                        CASE \n";
        $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
        $sql .= "                                THEN trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
        $sql .= "                        END \n";
        $sql .= "                    ) AS sale_amount \n";
        $sql .= "                FROM \n";
        $sql .= "                    t_sale_h \n";
        $sql .= "                    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
        $sql .= "                    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
        $sql .= "                WHERE \n";
        $sql .= "                    t_sale_h.shop_id = $shop_id \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_h.sale_day LIKE '$this_date%' \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_d.goods_id IS NOT NULL \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_staff.sale_rate IS NOT NULL \n";
        $sql .= "                    AND \n";
        $sql .= "                    t_sale_staff.staff_div != '0' \n";
        $sql .= "                GROUP BY \n";
        $sql .= "                    t_sale_d.sale_d_id \n";
        $sql .= "            ) AS t_sale_d_sub ON t_sale_d.sale_d_id = t_sale_d_sub.sale_d_id \n";
        $sql .= "        WHERE \n";
        $sql .= "            t_sale_h.shop_id = $shop_id \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_h.sale_day LIKE '$this_date%' \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_d.goods_id IS NOT NULL \n";
        $sql .= "            AND \n";
        $sql .= "            t_sale_staff.sale_rate IS NOT NULL \n";


        //�����ӥ������򤵤줿���
        if($form_data["form_serv"] != null){
            $sql .= "            AND \n";
            $sql .= "            t_sale_d.serv_id = ".$form_data["form_serv"]." \n";
        }


        $sql .= "\n";
        $sql .= "        GROUP BY \n";
        $sql .= "            t_sale_staff.staff_id, \n";
        $sql .= "            t_sale_d.goods_id \n";

        //$sql .= "            t_sale_d.serv_id \n"; //hashimoto�ɲ�

        $sql .= "    ) AS t_sale_".(string)($i+1)." ON t_staff.staff_id = t_sale_".(string)($i+1).".staff_id \n";
        $sql .= "        AND t_goods.goods_id = t_sale_".(string)($i+1).".goods_id \n";

    }

    //WHERE������
    $sql .= "WHERE \n";

    //ô���Ԥ����ꤵ�줿���
    if($form_data["form_staff"] != null){
        $sql .= "    t_staff.staff_id = ".$form_data["form_staff"]." \n";
        $sql .= "    AND \n";
    //̤����Ϻ߿����ô����
    }else{
        //$sql .= "    t_staff.state = '�߿���' \n";
        //$sql .= "    AND \n";
    }

    //��°�ܻ�Ź�����ꤵ�줿���
    if($form_data["form_branch"] != null){
        $sql .= "    t_part.branch_id = ".$form_data["form_branch"]." \n";
        $sql .= "    AND \n";
    }

    //���𤬻��ꤵ�줿���
    if($form_data["form_part"] != null){
        $sql .= "    t_part.part_id = ".$form_data["form_part"]." \n";
        $sql .= "    AND \n";
    }

    //���ʥ����ɤ����ꤵ�줿���
    if($form_data["form_goods"]["cd"] != null){
        $sql .= "    t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
        $sql .= "    AND \n";
    }

    //����̾�����ꤵ�줿���
    if($form_data["form_goods"]["name"] != null){
        $sql .= "    t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
        $sql .= "    AND \n";
    }

    //�Ͷ�ʬ�����ꤵ�줿���
    if($form_data["form_g_goods"] != null){
        $sql .= "    t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
        $sql .= "    AND \n";
    }

    //������ʬ�����ꤵ�줿���
    if($form_data["form_product"] != null){
        $sql .= "    t_goods.product_id = ".$form_data["form_product"]." \n";
        $sql .= "    AND \n";
    }

    //����ʬ�ब���ꤵ�줿���
    if($form_data["form_g_product"] != null){
        $sql .= "    t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
        $sql .= "    AND \n";
    }


    //�����ӥ������ꤵ�줿���
    #if($form_data["form_serv"] != null){

    #    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
    #        $sql .= "        t_sale_".(string)($i+1).".serv_id = ".$form_data["form_serv"]." \n";
    #        $sql .= "    AND \n";
    #    }

    #}




    $sql .= "    ( \n";
    //�������ʬ�롼��
    for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
        $sql .= "        t_sale_".(string)($i+1).".goods_id IS NOT NULL \n";
        $sql .= ($i < $form_data["form_trade_ym_e"] - 1) ? "        OR \n" : "";
    }
    $sql .= "    ) \n";



    switch ($form_data) {

        //�ʲ��ξ��Ǥϡ������ӥ�����Ф��륯�����UNION���ʤ�
        case $form_data["form_goods"]["cd"] != null :   //���ʥ����ɤ����ꤵ�줿���
        case $form_data["form_goods"]["name"] != null : //����̾�����ꤵ�줿���
        case $form_data["form_g_goods"] != null :       //�Ͷ�ʬ�����ꤵ�줿���
        case $form_data["form_product"] != null :       //������ʬ�����ꤵ�줿���
        case $form_data["form_g_product"] != null :     //����ʬ�ब���ꤵ�줿���
            break;
        default:


        $sql .= "\n";
        $sql .= "UNION \n";
        $sql .= "\n";


        //�����ӥ��Τߤ���Ф��륯����
        $sql .= "SELECT \n";
        $sql .= "    to_char(t_staff.charge_cd, '0000') AS cd, \n";
        $sql .= "    t_staff.staff_name AS name, \n";

        $sql .= "    t_serv.serv_cd AS cd2, \n";
        $sql .= "    t_serv.serv_name AS name2, \n";

        $sql .= "    NULL AS rank_cd, \n";  //aizawa-m
        $sql .= "    NULL AS rank_name, \n";// �ɲ�
        $sql .= "    2, \n";    //���ʡ������ӥ���ʬ�������ӥ��ϡ�2�סʰ����Ǿ��ʡ������ӥ��ν��ɽ�����뤿���
        //�������ʬ�롼�סʼ���������
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
            //�����
            $sql .= "    COALESCE(t_sale_".(string)($i+1).".sale_amount, 0) AS net_amount".(string)($i+1).", \n";
            //�����׳�
            $sql .= "    COALESCE((t_sale_".(string)($i+1).".sale_amount - t_sale_".(string)($i+1).".cost_amount), 0) AS arari_gaku".(string)($i+1).", \n";
            //����
            $sql .= "    NULL AS num".(string)($i+1).", \n";
        }
        $sql .= "    t_attach.shop_id \n";  //�ä�ɬ�פʤ����ɡ���Υ롼�׽�ü�ǡ�,�פ��դ��ʤ�Ƚ��򤷤ʤ�����
        $sql .= "FROM \n";
        $sql .= "    t_attach \n";
        $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
        $sql .= "        AND t_attach.shop_id = $shop_id \n";
        $sql .= "    CROSS JOIN t_serv \n";
        //��°�ܻ�Ź�����𤬻��ꤵ�줿��硢����ޥ����ơ��֥����
        if($form_data["form_branch"] != null || $form_data["form_part"] != null){
            $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        }

        //�������ʬ�롼�ס�1����Ȥν��ץ��֥������
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){

            //���դν񼰤��Ѥ���
            $this_date = date("Y-m-", mktime(0, 0, 0, $form_data["form_trade_ym_s"]["m"] + $i, 1, $form_data["form_trade_ym_s"]["y"]));

            //1����ʬ���ץ��֥�����
            $sql .= "    LEFT JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            t_sale_staff.staff_id, \n";
            $sql .= "            t_sale_d.serv_id, \n";
            //1����θ�����۹��
            $sql .= "            SUM( \n";
            $sql .= "                CASE \n";
            $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
            $sql .= "                        CASE t_sale_staff.staff_div \n";
            $sql .= "                            WHEN '0' THEN t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0) \n";
            $sql .= "                            ELSE trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ELSE \n";

                                        //�Ͱ������ʤξ��ϥᥤ�󤷤����ʤ�
            $sql .= "                            -1 * (t_sale_d.cost_amount - COALESCE(t_sale_d_sub.cost_amount, 0)) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS cost_amount, \n";
            //1���������۹��
            $sql .= "            SUM( \n";
            $sql .= "                CASE \n";
            $sql .= "                    WHEN t_sale_h.trade_id IN (11, 15, 61) THEN \n";
            $sql .= "                        CASE t_sale_staff.staff_div \n";
            $sql .= "                            WHEN '0' THEN t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0) \n";
            $sql .= "                            ELSE trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ELSE \n";

                                        //�Ͱ������ʤξ��ϥᥤ�󤷤����ʤ�
            $sql .= "                            -1 * (t_sale_d.sale_amount - COALESCE(t_sale_d_sub.sale_amount, 0)) \n";
            $sql .= "                END \n";
            $sql .= "            ) AS sale_amount \n";

            $sql .= "        FROM \n";
            $sql .= "            t_sale_h \n";
            $sql .= "            INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
            $sql .= "            INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            //���֤Τߤι�׶�ۤ򽸷פ��륵�֥�����
            $sql .= "            LEFT JOIN ( \n";
            $sql .= "                SELECT \n";
            $sql .= "                    t_sale_d.sale_d_id, \n";
            $sql .= "                    SUM( \n";
            $sql .= "                        CASE \n";
            $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
            $sql .= "                                THEN trunc(t_sale_d.cost_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ) AS cost_amount, \n";
            $sql .= "                    SUM( \n";
            $sql .= "                        CASE \n";
            $sql .= "                            WHEN t_sale_staff.staff_div != '0' \n";
            $sql .= "                                THEN trunc(t_sale_d.sale_amount * CAST(t_sale_staff.sale_rate AS int8) / 100) \n";
            $sql .= "                        END \n";
            $sql .= "                    ) AS sale_amount \n";
            $sql .= "                FROM \n";
            $sql .= "                    t_sale_h \n";
            $sql .= "                    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id \n";
            $sql .= "                    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "                WHERE \n";
            $sql .= "                    t_sale_h.shop_id = $shop_id \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_h.sale_day LIKE '$this_date%' \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_d.goods_id IS NULL \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_staff.sale_rate IS NOT NULL \n";
            $sql .= "                    AND \n";
            $sql .= "                    t_sale_staff.staff_div != '0' \n";
            $sql .= "                GROUP BY \n";
            $sql .= "                    t_sale_d.sale_d_id \n";
            $sql .= "            ) AS t_sale_d_sub ON t_sale_d.sale_d_id = t_sale_d_sub.sale_d_id \n";
            $sql .= "        WHERE \n";
            $sql .= "            t_sale_h.shop_id = $shop_id \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_h.sale_day LIKE '$this_date%' \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_d.goods_id IS NULL \n";
            $sql .= "            AND \n";
            $sql .= "            t_sale_staff.sale_rate IS NOT NULL \n";
            $sql .= "\n";
            $sql .= "        GROUP BY \n";
            $sql .= "            t_sale_staff.staff_id, \n";
            $sql .= "            t_sale_d.serv_id \n";
            $sql .= "    ) AS t_sale_".(string)($i+1)." ON t_staff.staff_id = t_sale_".(string)($i+1).".staff_id \n";
            $sql .= "        AND t_serv.serv_id = t_sale_".(string)($i+1).".serv_id \n";

            if($form_data["form_serv"] != null){
                $sql .= "    AND t_serv.serv_id = ".$form_data["form_serv"]." \n";
            }

        }

        //WHERE������
        $sql .= "WHERE \n";

        //ô���Ԥ����ꤵ�줿���
        if($form_data["form_staff"] != null){
            $sql .= "    t_staff.staff_id = ".$form_data["form_staff"]." \n";
            $sql .= "    AND \n";
        //̤����Ϻ߿����ô����
        }else{
            //$sql .= "    t_staff.state = '�߿���' \n";
            //$sql .= "    AND \n";
        }

        //��°�ܻ�Ź�����ꤵ�줿���
        if($form_data["form_branch"] != null){
            $sql .= "    t_part.branch_id = ".$form_data["form_branch"]." \n";
            $sql .= "    AND \n";
        }

        //���𤬻��ꤵ�줿���
        if($form_data["form_part"] != null){
            $sql .= "    t_part.part_id = ".$form_data["form_part"]." \n";
            $sql .= "    AND \n";
        }

        #//���ʥ����ɤ����ꤵ�줿���
        #if($form_data["form_goods"]["cd"] != null){
        #    $sql .= "    t_goods.goods_cd LIKE '".$form_data["form_goods"]["cd"]."%' \n";
        #    $sql .= "    AND \n";
        #}

        #//����̾�����ꤵ�줿���
        #if($form_data["form_goods"]["name"] != null){
        #    $sql .= "    t_goods.goods_name LIKE '%".$form_data["form_goods"]["name"]."%' \n";
        #    $sql .= "    AND \n";
        #}

        #//�Ͷ�ʬ�����ꤵ�줿���
        #if($form_data["form_g_goods"] != null){
        #    $sql .= "    t_goods.g_goods_id = ".$form_data["form_g_goods"]." \n";
        #    $sql .= "    AND \n";
        #}

        #//������ʬ�����ꤵ�줿���
        #if($form_data["form_product"] != null){
        #    $sql .= "    t_goods.product_id = ".$form_data["form_product"]." \n";
        #    $sql .= "    AND \n";
        #}

        #//����ʬ�ब���ꤵ�줿���
        #if($form_data["form_g_product"] != null){
        #    $sql .= "    t_goods.g_product_id = ".$form_data["form_g_product"]." \n";
        #    $sql .= "    AND \n";
        #}

        $sql .= "    ( \n";
        //�������ʬ�롼��
        for($i=0; $i<$form_data["form_trade_ym_e"]; $i++){
            $sql .= "        t_sale_".(string)($i+1).".serv_id IS NOT NULL \n";
            $sql .= ($i < $form_data["form_trade_ym_e"] - 1) ? "        OR \n" : "";
        }
        $sql .= "    ) \n";


    } //switch��λ


    $sql .= "ORDER BY \n";
    $sql .= "    1, \n";    //�����åեޥ���.ô���ԥ�����
    $sql .= "    7, \n";    //���ʡ������ӥ���ʬ
    $sql .= "    3 \n";     //���ʥޥ���.���ʥ����� or �����ӥ��ޥ���.�����ӥ�������
    $sql .= ";\n";


//print_array($sql);


    $result = Db_Query($db_con, $sql);
/*
$count = pg_num_rows($result);
print_array($count);
*/
#print_array($form_data);

/*
$result_array = pg_fetch_all($result);
print_array($result_array);
$result = false;
*/

    return $result;

}

?>
