<?php

/*
 * ��������
 *�����ա�2007/06/14��ô���ԡ�aizawa-m��������������������λ�������ʧ�����٤�ɽ������
 *
 * �ѹ�
 *�����ա�������ô���ԡ���������
 *��2007/06/14��aizawa_m������ۤΤ�Τϡ�����ξ��������ʸ��
 *  2007-07-12  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *
 */

$page_title = "��ʧ����";   //�����Ǥ���

//�Ķ�����ե�����
require_once("ENV_local.php");


//************************************************//
//	    -----------QuickForm-------------
//************************************************//

$form = new HTML_QuickForm("dateForm","POST");


/**********************************/
//DB��³   
/**********************************/
$con    = Db_Connect("");
//$con    = Db_Connect("aizawa");


/**********************************/
//��ʧͽ��ǡ����������ѿ�   
/**********************************/
//���å����Υ���å�ID
$shop_id    = $_SESSION["client_id"];
//GET�ͤ��Ǽ
$schedule_payment_id    = $_GET["pay_id"];  //��ʧͽ��ID
$client_id              = $_GET["c_id"];    //������ID
//�����ƥ೫����
$s_system_day   = START_DAY;

//GET�ͤο��ͥ����å��ʿ��ͤǤʤ�����TOP���̤ء�
Get_Id_Check3( array( $schedule_payment_id  , $client_id ) );


/**********************************/
//����������Ⱥ�������������   
/**********************************/
//��������� -��ʧͽ��ơ��֥�-
$s_sql =    "SELECT "."\n";
$s_sql.=    "   payment_close_day "."\n";   //��������
$s_sql.=    "FROM "."\n";
$s_sql.=    "   t_schedule_payment "."\n";
$s_sql.=    "WHERE "."\n";
$s_sql.=    "   client_id = ".$client_id."\n" ;
$s_sql.=    "AND "."\n";
$s_sql.=    "   shop_id = ".$shop_id."\n" ;
$s_sql.=    "AND "."\n" ;
$s_sql.=    "   (   SELECT "."\n";          //GET�Ǽ�����ä���ʧͽ��ID�λ������������
$s_sql.=    "           payment_close_day "."\n" ;
$s_sql.=    "       FROM "."\n" ;
$s_sql.=    "           t_schedule_payment "."\n" ;
$s_sql.=    "       WHERE "."\n" ;
$s_sql.=    "           schedule_payment_id = ".$schedule_payment_id."\n" ;
$s_sql.=    "   ) "."\n" ;
$s_sql.=    "   >=  payment_close_day "."\n" ;
$s_sql.=    "ORDER BY payment_close_day DESC"."\n";
$s_sql.=    "LIMIT 2"."\n";     //2�ԡʺ���������
$s_sql.=    "OFFSET 0"."\n";    //��Ƭ����
$s_sql.=    ";";

//������¹�
$ret_s_sql  = Db_Query( $con , $s_sql );

//echo nl2br($s_sql); 
//�������̷��
$max    = pg_num_rows( $ret_s_sql );

//---������̤�0��ξ��---//
if ( $max == 0 ) {
    //TOP���̤�����
    header( "location: ../top.php" );
}

//�������̤�����Ǽ���
for ( $i=0; $i < $max ; $i++ ) {
    //Ϣ������ǻ������������
    $arr_close_day  = pg_fetch_array( $ret_s_sql , $i );       
    //��������
    $close_day[$i]    = $arr_close_day['payment_close_day'];
}

//---�����ط�̤�1��ξ��---//
if ( $max == 1 ) {
    //����λ��������򥷥��ƥ೫����������
    $close_day[$i]  = $s_system_day;   
}

//print_array( $close_day);


/**********************************/
//��ʧͽ��ơ��֥�ǡ��������   
/**********************************/
//���������
$p_sql =    "SELECT "."\n";
$p_sql.=    "   last_account_payable ,"."\n" ;      //������ݻĹ�
$p_sql.=    "   payment , "."\n" ;                  //�����ʧ��
$p_sql.=    "   rest_amount ,"."\n" ;               //���۳�
$p_sql.=    "   sale_amount ,"."\n" ;               //���������
$p_sql.=    "   tax_amount ,"."\n" ;                //��������ǳ�
$p_sql.=    "   account_payable ,"."\n" ;           //��������ۡ��ǹ���
$p_sql.=    "   ca_balance_this ,"."\n" ;           //������ݻĹ���ǹ���
$p_sql.=    "   schedule_of_payment_this ,"."\n" ;  //�����ʧͽ���
$p_sql.=    "   payment_expected_date ,"."\n" ;     //��ʧͽ����
$p_sql.=    "   client_cname , "."\n" ;             //������̾(ά��)
$p_sql.=    "   client_cd1 , "."\n" ;               //�����襳����1
$p_sql.=    "   client_cd2 ,"."\n" ;                //�����襳����2
$p_sql.=    "   tax_div "."\n" ;                    //�����ǡʲ���ñ�̡�
$p_sql.=    "FROM "."\n";   
$p_sql.=    "   t_schedule_payment "."\n" ;
$p_sql.=    "WHERE "."\n";
$p_sql.=    "   schedule_payment_id = ".$schedule_payment_id."\n" ;
$p_sql.=    ";";

//������¹�
$ret_pay    = Db_Query( $con , $p_sql );

//---������Υ��顼Ƚ��---//
if ( !$ret_pay ) {
    exit();
}

//---������̤�0��ξ��---//
if ( pg_num_rows( $ret_pay ) == 0 ) {
        //Top���̤�����
        header( "location: ../top.php" );
}

//�������̤�����Ǽ���
$arr_pay    = pg_fetch_array( $ret_pay , 0 );

//��ʧͽ��ơ��֥�ǡ���������˳�Ǽ (�����ʸ���б���
$pay_data[0]    = Numformat_Ortho( $arr_pay["last_account_payable"] );//������ݻĹ�
$pay_data[1]    = Numformat_Ortho( $arr_pay["payment"] );             //�����ʧ��
$pay_data[2]    = Numformat_Ortho( $arr_pay["rest_amount"] );         //���۳�
$pay_data[3]    = Numformat_Ortho( $arr_pay["sale_amount"] );         //���������
$pay_data[4]    = Numformat_Ortho( $arr_pay["tax_amount"] );          //��������ǳ�
$pay_data[5]    = Numformat_Ortho( $arr_pay["account_payable"] );     //��������ۡ��ǹ���
$pay_data[6]    = Numformat_Ortho( $arr_pay["ca_balance_this"] );     //������ݻĹ���ǹ���
$pay_data[7]    = Numformat_Ortho( $arr_pay["schedule_of_payment_this"] ); //�����ʧͽ���
$pay_data[8]    = $arr_pay["payment_expected_date"];                //��ʧͽ����
$pay_data[9]    = Change_Html( $arr_pay["client_cname"] );          //������̾��ά�Ρ�
$pay_data[10]   = $arr_pay["client_cd1"];                           //�����襳����1
$pay_data[11]   = $arr_pay["client_cd2"];                           //�����襳����2         
$tax_div        = $arr_pay['tax_div'];                              //�����ǡʲ���ñ�̡�


/**********************************/
//��ʧ������ФΥ�����κ���   
/**********************************/
//���������
$sql =  "SELECT "."\n" ;
$sql.=  "   t_payout_h.pay_day ,"."\n" ;        //��ʧ��
$sql.=  "   t_payout_h.pay_no  ,"."\n" ;        //��ʧ�ֹ�
$sql.=  "   (   SELECT trade_cname "."\n" ;     //�����ʬ̾
$sql.=  "       FROM t_trade "."\n" ; 
$sql.=  "       WHERE t_trade.trade_id = t_payout_d.trade_id ) AS trade_name ,"."\n" ;
$sql.=  "   (   CASE t_payout_d.trade_id "."\n" ;
$sql.=  "           WHEN '41' THEN '��ʧ�ʸ����' "."\n" ;
$sql.=  "           WHEN '43' THEN '��ʧ�ʿ�����' "."\n" ;
$sql.=  "           WHEN '44' THEN '��ʧ�ʼ����' "."\n" ;
$sql.=  "           WHEN '45' THEN '�껦' "."\n" ;
$sql.=  "           WHEN '46' THEN 'Ĵ��' "."\n" ;
$sql.=  "           WHEN '47' THEN '��ʧ�ʤ���¾��' "."\n" ;
$sql.=  "           WHEN '48' THEN '�����' "."\n" ;
$sql.=  "           ELSE '' "."\n";
$sql.=  "       END ";
$sql.=  "   ) AS goods_name , "."\n" ; 
$sql.=  "   NULL AS count ,"."\n" ;
$sql.=  "   NULL AS price ,"."\n" ;
$sql.=  "   NULL AS amount ,"."\n" ;
$sql.=  "   NULL AS tax_div ,"."\n" ;
$sql.=  "   t_payout_d.pay_amount ,"."\n" ;     //��ʧ���
$sql.=  "   NULL AS line ,"."\n" ;
$sql.=  "   1 AS div "."\n" ;   //��ʧ�ξ���"1"
$sql.=  "FROM "."\n" ;
$sql.=  "   t_payout_h , t_payout_d "."\n" ;
$sql.=  "WHERE "."\n" ;
$sql.=  "       t_payout_h.pay_id = t_payout_d.pay_id "."\n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.pay_day > '".$close_day[1]."' \n"; 
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.pay_day  <= '".$close_day[0]."' \n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.shop_id = ".$shop_id."\n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.client_id = ".$client_id."\n" ;
$sql.=  "   AND " ;
$sql.=  "       t_payout_h.renew_flg = 't' "."\n";      //���������Ѥ�
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.buy_id IS NULL "."\n" ;      //����ID��NULL

$sql.=  "UNION ALL"."\n";
$sql.=  "   ( " ;
$sql.=  "       SELECT "."\n";
$sql.=  "           t_buy_h.buy_day ,"."\n";        //������
$sql.=  "           t_buy_h.buy_no ,"."\n" ;        //�����ֹ�
$sql.=  "           ( SELECT trade_cname FROM t_trade "."\n";
$sql.=  "               WHERE t_trade.trade_id = t_buy_h.trade_id ) ,"."\n";//�����ʬ(ά��)
$sql.=  "           t_buy_d.goods_name , "."\n" ;   //����̾
$sql.=  "           t_buy_d.num , "."\n" ;          //������
$sql.=  "           (   CASE "."\n";                
$sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
$sql.=  "                   THEN t_buy_d.buy_price * -1 "."\n";
$sql.=  "               ELSE t_buy_d.buy_price "."\n";
$sql.=  "               END ) ,"."\n" ;             //����ñ��
$sql.=  "           (   CASE "."\n";            
$sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
$sql.=  "                    THEN t_buy_d.buy_amount * -1 "."\n";
$sql.=  "               ELSE t_buy_d.buy_amount "."\n" ;
$sql.=  "               END ) , "."\n";     //������ۡ���ȴ��
$sql.=  "           (   CASE WHEN t_buy_d.tax_div = 3 "."\n";
$sql.=  "                   THEN '�����' ELSE '' END ),"."\n" ;//���Ƕ�ʬ
$sql.=  "           NULL ,"."\n";       
$sql.=  "           t_buy_d.line ,"."\n" ;  //���ֹ�
$sql.=  "           2 AS div "."\n" ;       //�����ξ���"2"
$sql.=  "       FROM ";
$sql.=  "           t_buy_h , t_buy_d "."\n" ;
$sql.=  "       WHERE ";
$sql.=  "           t_buy_h.buy_id = t_buy_d.buy_id "."\n";     //�إå��ȥǡ���
$sql.=  "       AND "."\n";
$sql.=  "           t_buy_h.buy_day > '".$close_day[1]."' \n";      //����λ������� 
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.buy_day <= '".$close_day[0]."' \n" ;//����λ�������
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.client_id = ".$client_id."\n" ;     //������ID
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.shop_id = ".$shop_id."\n" ;         //����å�ID
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.renew_flg = 't' "."\n";             //���������Ѥ�
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.trade_id IN ( 21 , 23 , 24 , 25 ) "."\n" ;  //�ݤλ����Τ�

//---����ñ�̤�2(��ɼñ��)�ξ��---//
if ( $tax_div == '2' ) {
    $sql.=  "   UNION ALL"."\n";
    $sql.=  "       SELECT "."\n" ;
    $sql.=  "           t_buy_h.buy_day ,"."\n" ;       //������
    $sql.=  "           t_buy_h.buy_no ,"."\n" ;        //�����ֹ�
    $sql.=  "           NULL ,"."\n" ;                  
    $sql.=  "           '�����Ƕ��' ,"."\n" ;      
    $sql.=  "           NULL ,"."\n" ;
    $sql.=  "           NULL ,"."\n" ;
//    $sql.=  "           t_buy_h.tax_amount ,"."\n" ;        //�����ǳ�
    $sql.=  "           (   CASE "."\n";
    $sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
    $sql.=  "                   THEN t_buy_h.tax_amount * -1 "."\n";
    $sql.=  "               ELSE t_buy_h.tax_amount "."\n";
    $sql.=  "               END ) ,"."\n";
    $sql.=  "           NULL ,"."\n" ;
    $sql.=  "           t_buy_h.buy_id ,"."\n" ;            //����ID�����ס�
    $sql.=  "           MAX( t_buy_d.line ) + 1 ,"."\n" ;   //�����ǡ����ι��ֹ��MAX+1
    $sql.=  "           3 AS div "."\n" ;                   //�����Ǥξ���"3"
    $sql.=  "       FROM " ;
    $sql.=  "           t_buy_h , t_buy_d "."\n" ;
    $sql.=  "       WHERE "."\n" ;
    $sql.=  "           t_buy_h.buy_id = t_buy_d.buy_id "."\n";     //�إå��ȥǡ���
    $sql.=  "       AND "."\n";
    $sql.=  "           t_buy_h.buy_day > '".$close_day[1]."' \n";  //����λ������� 
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.buy_day <= '".$close_day[0]."' \n" ;//����λ�������
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.client_id = ".$client_id."\n" ;     //������ID
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.shop_id = ".$shop_id."\n" ;         //����å�ID
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.renew_flg = 't' "."\n" ;            //���������Ѥ�
    $sql.=  "       AND " ;
    $sql.=  "           t_buy_h.trade_id IN ( 21 , 23 , 24 , 25 ) "."\n" ;  //�ݤΤ�
    $sql.=  "       GROUP BY "."\n";
    $sql.=  "           t_buy_h.buy_day , "."\n" ;
    $sql.=  "           t_buy_h.buy_no , "."\n" ;
    $sql.=  "           t_buy_h.trade_id , "."\n" ;
    $sql.=  "           t_buy_h.tax_amount ,"."\n" ;
    $sql.=  "           t_buy_h.buy_id  "."\n" ;
}
$sql.=  "       ORDER BY "."\n" ;
$sql.=  "           buy_day , "."\n" ;
$sql.=  "           buy_no , "."\n" ;
$sql.=  "           line ASC " ;
$sql.=  "   ) "."\n" ;
$sql.=  "ORDER BY "."\n" ;
$sql.=  "   pay_day , "."\n" ;
$sql.=  "   pay_no , "."\n" ;
$sql.=  "   line ASC "."\n" ;      
$sql.=  ";";

//echo nl2br($sql); 
//������¹�
$ret_sql    = Db_Query( $con , $sql ) ;

//---������Υ��顼Ƚ��---//
if ( !$ret_sql ) {
    exit();
}

//������η�̷�������
$all_row    = pg_num_rows( $ret_sql );

//���ߤξ�����ݻ������ѿ�
$cur_day    = '';
$cur_no     = '';
$cur_div    = '';
//������ξ�����ݻ������ѿ�
$hold_day   = '';
$hold_no    = '';
$hold_div   = '';

//---������̷��ʬ�롼�פ���---//
for ( $i=0 ; $i < $all_row ; $i++ ) {

    //$i���ܤΥ쥳���ɤ����
    $arr_data       =   pg_fetch_array( $ret_sql , $i );

    /**********************************/
    //���������ǡ���������˳�Ǽ
    /**********************************/
    //---"div"��3(�����ǳ�)�ξ��---//
    if ( $arr_data['div'] == 3 ) {
            //���󤻤�ɽ��
            $detail_data[$i][3] = "<p align='RIGHT'>".$arr_data['goods_name']."</p>";       
            //3���襫��ޤ������ʸ���б��δؿ�
            $detail_data[$i][6] = Numformat_Ortho( $arr_data['amount'] );   //�����ǳ�
    }
    //---"div"��1(��ʧ��)�ξ��---//
    else if ( $arr_data['div'] == 1 ) {
        $detail_data[$i][0] = substr( $arr_data['pay_day'] , 5 , 5 );   //����
        $detail_data[$i][1] = $arr_data['pay_no'];      //��ɼ�ֹ�
        $detail_data[$i][2] = $arr_data['trade_name'];  //�����ʬ
        $detail_data[$i][3] = $arr_data['goods_name'];  //����̾
        $detail_data[$i][8] = Numformat_Ortho( $arr_data['pay_amount'] ); //��ʧ

        //����ѤǸ��ߤΥǡ������Ǽ
        $cur_day    = $detail_data[$i][0];  //��������  
        $cur_no     = $detail_data[$i][1];  //��ɼ�ֹ�
        $cur_div    = $detail_data[$i][2];  //�����ʬ
    }
    //---"div"��2(������)�ξ��---//
    else {
        $detail_data[$i][0] = substr( $arr_data['pay_day'] , 5 , 5 );   //����  
        $detail_data[$i][1] = $arr_data['pay_no'];                      //��ɼ�ֹ�   
        $detail_data[$i][2] = $arr_data['trade_name'];                  //�����ʬ
        $detail_data[$i][3] = Change_Html( $arr_data['goods_name'] );   //����̾
        $detail_data[$i][4] = number_format( $arr_data['count'] );      //����(�����)
        $detail_data[$i][5] = Numformat_Ortho( $arr_data['price'] , 2 );    //ñ��
        $detail_data[$i][6] = Numformat_Ortho( $arr_data['amount'] );       //���
        $detail_data[$i][7] = $arr_data['tax_div'];     //�Ƕ�ʬ
    
        //����ѤǸ��ߤΥǡ������Ǽ
        $cur_day    = $detail_data[$i][0];  //��������  
        $cur_no     = $detail_data[$i][1];  //��ɼ�ֹ�
        $cur_div    = $detail_data[$i][2];  //�����ʬ
    }

    /*********************************************/
    //������������ɼ�ֹ桦�����ʬ��ɽ�������å�
    /*********************************************/
    //---����Ⱥ���Ρַ����פ�Ʊ�����---//
    if ( $hold_day == $cur_day ) {
        //��������ˤ���
        $detail_data[$i][0] = '' ;  
    } else {
        //���ߤη������ݻ�����
        $hold_day   = $cur_day;  
    }
    //---����Ⱥ���Ρ���ɼ�ֹ�פ�Ʊ�����---//
    if ( $hold_no == $cur_no ) {
        //��ɼ�ֹ����ˤ��� 
        $detail_data[$i][1] = ''; 
       
        //---����Ⱥ���Ρּ����ʬ�פ�Ʊ�����---//
        if ( $hold_div == $cur_div ) { 
            //�����ʬ����ˤ��� 
            $detail_data[$i][2] = '';       
        }
    } else {
        $hold_no    = $cur_no;  //��ɼ�ֹ���ݻ�
        $hold_div   = $cur_div; //�����ʬ���ݻ�
    }
}


/****************************/
//�ե�����κ���
/****************************/
//���ܥ���ʸ����������)
$form->addElement( "button" , "btn_back" , "�ᡡ��" , "onClick=javascript:location.href='1-3-301.php?search=1';" );


/****************************/
//DB����
/****************************/
Db_Disconnect( $con );

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

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'group_kind'    => "$group_kind",
));


//QuikForm�Υե��������������
$render =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($render);
$smarty->assign("form",$render->toArray());

// ���٥ǡ��������assign����
$smarty->assign("detail_data",  $detail_data    );
$smarty->assign("close_day",    $close_day[0]   );      //��������
$smarty->assign("pay_data",     $pay_data       );      //��ʧͽ��ơ��֥�ǡ�������
$smarty->assign("tax_div",      $tax_div       );       //�����ǡʲ���ñ�̡�
 
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/*************************************************************************/
// *
// *
// * ʸ�������λ��Ȥ��Ѵ�����
// *
// *
// * @author              aizawa-m <aizawa-m@bhsk.co.jp>
// * @version             1.0.0 (2007/06/11)
// *
/*************************************************************************/
function Change_Html( $string ) {
    $trans_tbl      = array(    '&amp;' => '&'  ,
                                '&#59;' => ';'  ,
                                '&quot;'=> '\'' ,
                                '&#039;'=> "'"  ,
                                '&lt;'  => '<'  ,
                                '&gt;'  => '>'  ,
                                '&#37;' => '%'  ,
                                '&#40;' => '('  ,
                                '&#41;' => ')'  ,
                                '&#43;' => '+'
         );

         $trans_tbl      = array_flip ( $trans_tbl );
         return strtr ( $string , $trans_tbl );
}
?>
