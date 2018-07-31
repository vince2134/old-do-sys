<?php

/*
 * ����
 *  ����        ô����      ����
 *-----------------------------------------------
 *  2007-10-17  aizawa-m    ��������
 *
 * @file       121.php
 *  
 * Ŭ���ϰϡ�   �������̾����̻������( 1-6-121.php, 2-6-121.php ) 
 *              
 */

//��������䤹
//var_dump(ini_set('memory_limit', '32M'));

// �ǥХå��ե饰
 $proc_flg   = true;
//$proc_flg   = false;
$start  = microtime();

/***********************/
// ��������
/***********************/
$page_title = "�������̾����̻������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//DB��³
$db_con = Db_Connect();


/***********************/
// SESSION�������
/***********************/
$group_kind = $_SESSION["group_kind"];


/****************************/
// �ե�����ѡ������
/****************************/
// �ե���������ؿ� 
Mk_Form($db_con, $form);

//�����ξ��
if ($group_kind == "1") {
    //csv�����ȥ�
    $csv_head[] = "FC������襳����";
    $csv_head[] = "FC�������̾";
    $csv_head[] = "FC��������ʬ������";
    $csv_head[] = "FC��������ʬ̾";
    $csv_head[] = "���ʥ�����";
    $csv_head[] = "����̾";

} else {
    $obj    = null;
    $obj[]  = $form->createElement("text", "cd1", "", "size=\"7\" maxlength=\"6\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\" class=\"ime_disabled\"");
    $obj[]  = $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" onKeyDown=\"chgkeycode();\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\"");
    $form->addGroup($obj, "form_client");

    //csv�����ȥ�
    $csv_head[] = "�����襳����";
    $csv_head[] = "������̾";
    $csv_head[] = "���ʥ�����";
    $csv_head[] = "����̾";
}



/***************************/
// ɽ���ܥ��󲡲�
/***************************/
if ( $_POST["form_display"] == "ɽ����" ) {

    //���դΥ��顼�����å��ؿ�
    Err_Chk_Date_YM($form, "form_trade_ym_s");


    /*******************/
    // ���顼�ʤ�
    /*******************/
    if ( $form->validate()) {
        //���ϥե饰
        $out_flg    = true;

        $sql_s = microtime();
        //������¹Դؿ�
        $result     = Select_Each_Goods_Supplier ($db_con, $_POST);
        $sql_e = microtime();

        //ɽ�Υ����ȥ�
        $disp_head  = Get_Header_YM($_POST["form_trade_ym_s"]["y"],
                                    $_POST["form_trade_ym_s"]["m"],
                                    $_POST["form_trade_ym_e"] );

        $edit_s = microtime();
        //�ۤ��Ԥ轸�״ؿ�
        $disp_data  = Edit_Query_Data_Hogepiyo($result, $_POST);

//        $disp_data  = Edit_Query_Data_Hogepiyo2($result, $_POST);

        //�� ���פ�Ф��ʤ����״ؿ� aizawa-m
##        $disp_data      = Edit_Query_Data2($result, $_POST);
#print_array($disp_data);
        $edit_e = microtime();

        /***********************/
        // �����оݤ�CSV�ξ��
        /***********************/
        if ($_POST["form_output_type"] == "2") {

            $csvobj = new Analysis_Csv_Class(false, true, false);
            $csvobj->Enc_FileName($page_title.date("Ymd").".csv");

            // CSV����̾����
            $csvobj->Make_Csv_Head($disp_head, $csv_head);
            $csvobj->Make_Csv_Data($disp_data, true);

            // CSV����
            Header("Content-disposition: attachment; filename=".$csvobj->filename);
            Header("Content-type; application/octet-stream; name=".$csvobj->filename);
            print $csvobj->res_csv;
            exit;
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
//$page_menu = Create_Menu_h('analysis','1');

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
	//'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'group_kind'    => "$group_kind",
));

//assign
$smarty->assign("disp_head", $disp_head);
$smarty->assign("disp_data", $disp_data);
$smarty->assign("out_flg",   $out_flg);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename("121.php.tpl"));
//$smarty->display(basename("121_test.php.tpl"));
//$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

$end = microtime();

// �ǥХå��ѡ�����®�ٽ���Ƚ��
if ($proc_flg === false) {

    $sql_s = Cnt_Microtime($sql_s);
    $sql_e = Cnt_Microtime($sql_e);
    $edit_e = Cnt_Microtime($edit_e);
    $edit_s = Cnt_Microtime($edit_s);
    $end    = Cnt_Microtime($end);
    $start  = Cnt_Microtime($start);

    echo "<br>";
    echo "�����ꡡ:".($sql_e-$sql_s);
    echo "<br>";
    echo "���׻���:".($edit_e-$edit_s);
    echo "<br>";
    echo "���Τν�������:".($end-$start);
}


/*
 * DEBUG��
 * microtime() �Խ��ؿ�
 */
/*function Cnt_Microtime($micro_time){

    $arr    = explode(" ", $micro_time);

    $second = (float)$arr[0]+(float)$arr[1];

    return $second;

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
/*function Select_Each_Goods_Supplier ($db_con, $_POST) {

    /***********************/
    // SESSION�ѿ��μ���
    /***********************/
/*    $shop_id    = $_SESSION["client_id"];
    $group_kind = $_SESSION["group_kind"];


    /***********************/
    // �����������
    /***********************/
/*    $period         = $_POST["form_trade_ym_e"];   
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
/*
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
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".goods_id , NULL) AS goods_id".(string)($i+1).", \n";
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
    $sql .= "           INNER JOIN  \n";
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
/*
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
  /*      $sql .= "       AND \n";
        $sql .= "       t_buy_h.buy_day LIKE '$like_day%' \n";

        $sql .= "   GROUP BY \n";
        $sql .= "       t_buy_h.client_id, \n";
        $sql .= "       t_buy_d.goods_id \n";
        $sql .= "   ) AS t_buy_d".(string)($i+1). " \n";
        $sql .= "   ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";
        $sql .= "   AND t_client.goods_id = t_buy_d".(string)($i+1).".goods_id \n";

// 2007-11-11 ������
///        $sql .= "   AND t_buy_d".(string)($i+1).".goods_id IS NOT NULL \n";


        // ����оݤ����۰ʳ�
        if ( $out_abstract ==  "1" ) {
            $sql.=  "   AND \n";
            $sql.=  "   t_buy_d".(string)($i+1).".client_id <> 93 \n";
        } 
    }



    $sql.=  "ORDER BY \n";
    $sql.=  "   t_client.client_cd1, \n";
    $sql.=  "   t_client.client_cd2 \n";
    $sql.=  ";";
    
#    print_array($sql);

    /********************/
    // ������¹�
    /********************/
/*    $result = Db_Query($db_con, $sql);

    return $result;


//----------------------------------------------------------------------------------------------------------------------------
//�ʲ����轵�ޤǤΥ�����Ǥ���

    //------- ��������� --------------------------//
/*    
    $sql =  "SELECT \n";
    if ( $group_kind == "1" ) { 
        //�����ξ��ϡ������襳���ɣ��������襳���ɣ������
        $sql.=  "   t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    } else {
        //FC�ξ��ϡ������襳���ɣ��Τ����
        $sql.=  "   t_client.client_cd1 AS cd, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n"; 

    $sql.=  "   t_goods.goods_cd AS cd2, \n";
    $sql.=  "    t_g_product.g_product_name || ' ' || t_goods.goods_name AS name2, \n";

    for ($i = 0; $i < $period; $i++ ) {
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".net_amount, 0) AS net_amount".(string)($i+1).",";
        $sql.=  "   0 AS arari_gaku".(string)($i+1).",";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".num , 0) AS num".(string)($i+1).",";
        $sql.=  "   COALESCE(t_buy_d".(string)($i+1).".goods_id , NULL) AS goods_id".(string)($i+1).",";
    }

    $sql.=  "   t_client.rank_cd AS rank_cd, \n";       //FC��������ʬ������
    $sql.=  "   t_rank.rank_name AS rank_name, \n";     //FC��������ʬ̾

    $sql.=  "   t_client.shop_id \n";

    $sql.=  "FROM \n";
    $sql.=  "   t_client \n";

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_goods_info \n";//
    $sql.=  "ON t_client.shop_id = t_goods_info.shop_id \n";//
    $sql.= "AND t_goods_info.shop_id = $shop_id \n";

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_goods \n";//
    $sql.=  "ON t_goods_info.goods_id = t_goods.goods_id \n";//

    $sql.=  "INNER JOIN  \n";//
    $sql.=  "   t_g_product \n";//
    $sql.=  "ON t_goods.g_product_id = t_g_product.g_product_id \n";//


    $sql.=  "LEFT JOIN  \n";
    $sql.=  "   t_rank \n";
    $sql.=  "ON t_client.rank_cd = t_rank.rank_cd \n";



    for ( $i = 0; $i < $period; $i++ ) {
        // ���դν񼰤��Ѥ���
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "       LEFT JOIN \n";
        $sql.=  "               (   SELECT \n";
        $sql.=  "                       t_buy_h.client_id, \n"; 
        $sql.=  "                       t_buy_d.goods_id, \n"; 
        $sql.=  "                       SUM ( \n";
        $sql.=  "                           CASE \n";
        $sql.=  "                               WHEN t_buy_h.trade_id IN (21, 25, 71) \n";
        $sql.=  "                               THEN t_buy_d.buy_amount \n";
        $sql.=  "                               ELSE -1 * t_buy_d.buy_amount \n";   
        $sql.=  "                           END \n";
        $sql.=  "                       ) AS net_amount, \n";
        $sql.=  "                       SUM ( t_buy_d.num ) AS num \n";
        $sql.=  "                   FROM \n";
        $sql.=  "                       t_buy_h INNER JOIN t_buy_d \n"; 
        $sql.=  "                           ON t_buy_h.buy_id = t_buy_d.buy_id \n";
        $sql.=  "                   WHERE \n";
        $sql.=  "                           t_buy_h.buy_day >= '$this_date' \n";
        $sql.=  "                       AND \n";
        $sql.=  "                           t_buy_h.buy_day < '$next_date' \n";
        $sql.=  "                       AND \n";
        $sql.=  "                           t_buy_h.shop_id = $shop_id \n";
        $sql.=  "                   GROUP BY \n";
        $sql.=  "                       t_buy_d.goods_id, \n";
        $sql.=  "                       t_buy_h.client_id \n";
        $sql.=  "                   ORDER BY \n";
        $sql.=  "                       t_buy_h.client_id, \n";
        $sql.=  "                       t_buy_d.goods_id \n";
        $sql.=  "       ) AS t_buy_d".(string)($i+1). " \n";
        $sql.=  "               ON t_client.client_id = t_buy_d".(string)($i+1).".client_id \n";

        // ����оݤ����۰ʳ�
        if ( $out_abstract ==  "1" ) {
            $sql.=  "           AND \n";
            $sql.=  "               t_buy_d".(string)($i+1).".client_id <> 93 \n";
        }
 

    }

    $sql.=  "WHERE \n";
    $sql.=  "       t_client.shop_id = $shop_id \n";
    $sql.=  "   AND \n";
    $sql.=  "       t_client.client_div = $client_div \n";

    // ���������ɲ�
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



    $sql.=  "ORDER BY \n";
    $sql.=  "   client_cd1, \n";
    $sql.=  "   client_cd2 \n";

    $sql.=  ";";
   */ 

//----------------------------------------------------------------------------------------------------------------------------







/*    $sql.=  "SELECT \n";
    if ( $group_kind == "1" ) {
       $sql.=   "t_client.client_cd1 || '-' || t_client.client_cd2 AS cd, \n";
    } else {
        $sql.=  "t_client.client_cd1, \n";
    }
    $sql.=  "   t_client.client_cname AS name, \n";
    $sql.=  "   t_client.rank_cd AS rank_cd, \n";
    $sql.=  "   t_rank.rank_name AS rank_name, \n";
    for ( $i=0 ; $i<$period ; $i++ ) {
        $sql.=  "   COALESCE( t_buy_d".(string)($i+1).".buy_amount, 0) AS buy_amount".(string)($i+1).", \n";   
        $sql.=  "   COALESCE( t_buy_d".(string)($i+1).".num, 0) AS num".(string)($i+1).", \n";   
    }


    $sql.=  "   t_client.shop_id \n";
    $sql.=  "FROM \n";

    $sql.=  " ( \n";
    $sql.=  "   t_client \n";
    $sql.=  "       LEFT JOIN t_buy_h ON \n";
    $sql.=  "               t_client.client_id = t_buy_h.client_id \n"; 
    $sql.=  "           AND \n";
    $sql.=  "               t_buy_h.shop_id = $shop_id \n";
    $sql.=  "           AND \n";
    $sql.=  "               t_buy_h.buy_day >= '".$start_y.$start_m."01' \n";
    $sql.=  " ) \n";
    $sql.=  "   LEFT JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd \n";
    $sql.=  ";";    


    $sql.=  "SELECT \n";

    for ( $i=0 ; $i<$period ; $i++ ) {
        //���դν񼰤򤫤���
        $this_date  = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date  = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        $sql.=  "   LEFT JOIN ( \n";
        $sql.=  "       SELECT \n";
        $sql.=  "           client_id \n";
        $sql.=  "       FROM \n";
        $sql.=  "           t_buy_h \n";
        $sql.=  "               LEFT JOIN ( \n";
        $sql.=  "                   SELECT \n";
        $sql.=  "                       buy_id, \n";
        $sql.=  "                       goods_id, \n";
        $sql.=  "                       buy_amount, \n";
        $sql.=  "                       num \n";
        $sql.=  "                   FROM \n";
        $sql.=  "                     ( \n";
        $sql.=  "                       SELECT \m";
        $sql.=  "                           SUM( \n";
        $sql.=  "                               CASE \n";
        $sql.=  "                                   WHEN trade_id IN (11, 15, 61) THEN buy_amount \n";
        $sql.=  "                                   ELSE -1 * buy_amount \n";
        $sql.=  "                           ) AS buy_amount, \n";
        $sql.=  "                           SUM ( num ) AS num, \n";
        $sql.=  "                           goods_id \n";
        $sql.=  "                       FROM \n";
        $sql.=  "                           t_buy_d \n";
        $sql.=  "                       GROUP BY \n";    
        $sql.=  "                           goods_id \n";
        $sql.=  "                   ) t_buy_d \n";
        $sql.=  "               ) AS t_buy_d".(string)($i+1)." ON t_buy_h.buy_id = t_buy_d".(string)($i+1).".buy_id \n";
        $sql.=  "   ) AS t_buy_h".(string)($i+1)." ON t_client.client_id = t_buy_h".(string)($i+1)."client_id  \n"; 

    }



}
*/

?>
