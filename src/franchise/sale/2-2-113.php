<?php
/*******************************/
//　・変更履歴
//
// (2006/09/06) (kaji) 削除伝票は一覧に表示しない
// (2006/10/16) (watanabe-k)
//              ・集計日報から予定明細へ遷移すると、伝票が順路順になっていないバグの修正
//              ・部署で検索しても代行先が表示されてしまうバグの修正
//              ・検索を実行しても、集計日報印字のチェックがクリアされないバグの修正
/* (2006-11-01）・受注番号がふられた代行伝票を表示<suzuki>
                ・委託先側で部署・担当者の検索ができるように変更<suzuki>
                ・休止中・解約中の得意先の伝票を表示<suzuki>
                ・カレンダー表示期間分表示<suzuki>
   (2006-11-02）・日付妥当性判定追加<suzuki>
   (2006-11-06）・代行側で予定データ明細に遷移できるように修正<suzuki>
*/
//
//
/*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/10      02-056      suzuki      担当者コードに半角数字チェックを追加
 *  2006/11/10      02-053      suzuki      該当件数表示
 *  2006/11/10      02-054      suzuki      日付順にソート
 *  2006/11/10      02-045      suzuki      ＦＣ側の集計日報では、同じ日の同じ担当者の代行伝票・自社伝票を纏める
 *  2006/11/13      02-062      suzuki      代行区分で検索できるように修正
 *  2006/12/07      ban_0057    suzuki      日付をゼロ埋め
 *  2007/01/30                  watanabe-k  発行形式を選択可能とするように修正
 *  2007/02/07                  watanabe-k  直営以外でログインした場合にクエリエラーがでるバグの修正
 *  2007/03/22                  watanabe-k  ヘッダのボタンを変更
 *  2007/03/27                  watanabe-k  巡回担当者のリストをスタッフマスタを元に作成するように修正 
 *  2007/04/06                  watanabe-k  検索項目を変更
 *  2007/05/14                  watanabe-k  発行日を表示するように修正
 *  2007/05/22                  watanabe-k  代行集計表のボタン名を変更 
 *  2007/05/22                  watanabe-k  文言の修正 
 *  2007/07/26                  watanabe-k  伝票発行でクエリエラーが表示されるバグの修正 
*/

$page_title = "集計日報";

//環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth   = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"]; 


/****************************/
//検索条件復元
/****************************/
// 検索フォーム初期値配列
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_attach_branch"    => "",
    "form_round_staff"      => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_multi_staff"      => "",
    "form_not_multi_staff"  => "",
    "form_ware"             => "",
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_round_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => date("d"),
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("d")
    ),
    "form_act_div"          => "1" 
);

// 検索条件復元
//Restore_Filter($form, "hdn_show_button_flg", $ary_form_list);
//Restore_Filter($form, "form_show_button", $ary_form_list);
Restore_Filter2($form, "contract", "form_show_button", $ary_form_list);

/****************************/
// 初期値設定
/****************************/
$limit          = null;
$offset         = "0";
$total_count    = "0";
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";

/****************************/
// フォームパーツ定義
/****************************/
/* 共通フォーム */

Search_Form($db_con, $form, $ary_form_list);

//表示しないフォームを削除
$form->removeElement("form_client");
$form->removeElement("form_claim");
$form->removeElement("form_claim_day");
$form->removeElement("form_client_branch");
$form->removeElement("form_ware");

// 除外巡回担当者コード（カンマ区切り）
$form->addElement("text", "form_not_multi_staff", "", "size=\"40\" style=\"$g_form_style\" $g_form_option");

//代行区分
$radio = null; 
$radio[] = $form->createElement("radio", null, null, "指定なし", "1");
$radio[] = $form->createElement("radio", null, null, "自社巡回", "2");
$radio[] = $form->createElement("radio", null, null, "代行分", "3");
$form->addGroup($radio, "form_act_div", "");

// 表示ボタン
//$form->addElement("button", "form_show_button", "表　示", "onClick=\"javascript:Button_Submit('hdn_show_button_flg','$_SERVER[PHP_SELF]','t');\"");
$form->addElement("submit", "form_show_button", "表　示", "");

// クリアボタン
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$search_html = Search_Table($form);

$form->addElement("button", "form_preslipout_button", "前集計日報(0)", 
                "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit','付番前発行');\" ");
$form->addElement("button", "form_slipout_button", "付番集計日報(1)", 
                "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit','集計日報発行');\" ");
$form->addElement("button", "form_reslipout_button", "(1)再発行", 
                    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit', '　再　発　行　');\" 
                ");

// ヘッダに表示するボタン
$form->addElement("button","slip_button","集計日報",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","act_button","代行期間集計表","onClick=\"location.href='./2-2-116.php'\"");
$form->addElement("button","2-2-111_button","商品予定出荷","onClick=\"location.href='./2-2-111.php'\"");
$form->addElement("button","2-2-204_button","予定伝票発行","onClick=\"location.href='./2-2-204.php'\"");

//ボタン押下hidden
$form->addElement("hidden", "form_hdn_submit");
$form->addElement("hidden","hdn_show_button_flg");

/****************************/
//イベント判別フラグ設定
/****************************/
//表示ボタンが押下された場合、表示ボタン押下フラグを立てる
//$show_button_flg    = ($_POST["hdn_show_button_flg"] == 't')? true : false;
$show_button_flg    = ($_POST["form_show_button"] == '表　示')? true : false;
//集計日報ボタンが押下された場合、クリアボタンフラグを立てる
if($_POST["form_slipout_button"] == "集計日報付番"
    ||
   $_POST["form_preslipout_button"] == "付番前発行"    
    ||
   $_POST["form_reslipout_button"] == "　再　発　行　"
    ){
    $slipout_button_flg = true;
}


/****************************/
//表示ボタン押下
/****************************/
if($show_button_flg == true || $_POST["switch_page_flg"]== 't'){
    /****************************/
    //POST情報取得
    /****************************/
    $send_sday_y        = $_POST["form_round_day"]["sy"];       //配送日（開始年） 
    $send_sday_m        = $_POST["form_round_day"]["sm"];       //配送日（開始月）
    $send_sday_d        = $_POST["form_round_day"]["sd"];       //配送日（開始日）
    $send_eday_y        = $_POST["form_round_day"]["ey"];       //配送日（終了年） 
    $send_eday_m        = $_POST["form_round_day"]["em"];       //配送日（終了月）
    $send_eday_d        = $_POST["form_round_day"]["ed"];       //配送日（終了日）

    $act_div            = $_POST["form_act_div"];               //代行フラグ
    $display_num        = $_POST["form_display_num"];           //表示件数

    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];      //委託先FC　コード１
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];      //委託先FC　コード２
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];     //委託先FC　名
    $charge_fc_id       = $_POST["form_charge_fc"]["select"]["1"];  //委託先FC　ID

    $attach_branch      = $_POST["form_attach_branch"];         //所属支店ID
    $part_id            = $_POST["form_part"];                  //部署

    $staff_cd           = $_POST["form_round_staff"]["cd"];     //巡回担当者コード
    $staff_id           = $_POST["form_round_staff"]["select"]; //巡回担当者ID

    $staff_in_cd        = $_POST["form_multi_staff"];           //巡回担当者コード(カンマ区切り)
    $staff_not_in_cd    = $_POST["form_not_multi_staff"];       //除外巡回担当者コード(カンマ区切り) 

    /****************************/
    //ルール作成
    /****************************/
    //担当者コードの半角数字チェック
    $form->addGroupRule('form_round_staff', array(
            'cd' => array(
                    array('担当者コード は半角数字のみです。', 'regex', "/^[0-9]+$/")
            ),
        )
    );

    //担当者コード（カンマ区切り）の半角数字チェック
    Err_Chk_Delimited($form, "form_multi_staff", "巡回担当者コード(カンマ区切り) は半角数字と「,」のみです。");

    //除外担当者コード（カンマ区切り）が指定されている場合
    Err_Chk_Delimited($form, "form_not_multi_staff", "除外担当者コード(カンマ区切り) は半角数字と「,」のみです。");

    //予定巡回日
    $form->addGroupRule('form_round_day', array(
            'sy' => array(
                    array('予定巡回日は必須入力です。', 'required')
            ),      
            'sm' => array(
                    array('予定巡回日は必須入力です。','required')
            ),      
            'sd' => array(
                    array('予定巡回日は必須入力です。','required')
            ),         
            'ey' => array(
                    array('予定巡回日は必須入力です。', 'required')
            ),      
            'em' => array(
                    array('予定巡回日は必須入力です。','required')
            ),      
            'ed' => array(
                    array('予定巡回日は必須入力です。','required')
            )         
    ));

    Err_Chk_Date($form, "form_round_day", "予定巡回日 の日付は妥当ではありません。");

    $set_data["hdn_show_button_flg"] = "";
    /***************************/
    //値検証
    /***************************/
/*
    if($form->validate() || $_GET["search"] == '1'){
        //バリデートフラグ
        $validate_flg = true;
    }
*/
    $form->validate();
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = true;
}else{
    $post_flg = false;
}

/***************************/
//条件式作成
/***************************/
//if($validate_flg === true){
if(!$err_flg && $post_flg == true){

    //日付を結合
    $send_sday = str_pad($send_sday_y,4,"0",STR_PAD_LEFT)."-".str_pad($send_sday_m,2,"0",STR_PAD_LEFT)."-".str_pad($send_sday_d,2,"0",STR_PAD_LEFT);
    $send_eday = str_pad($send_eday_y,4,"0",STR_PAD_LEFT)."-".str_pad($send_eday_m,2,"0",STR_PAD_LEFT)."-".str_pad($send_eday_d,2,"0",STR_PAD_LEFT);

    //配送日（開始）が入力された場合
    if($send_sday != '--' && $send_sday != null){
        $where_sql  = " AND t_aorder_h.ord_time >= '$send_sday'\n";
    }

    //配送日（終了）が入力された場合
    if($send_eday != '--' && $send_eday != null){
        $where_sql .= " AND t_aorder_h.ord_time <= '$send_eday'\n";
    }
    $date_sql = $where_sql;

    //巡回担当者コードが入力された場合
    if($staff_cd != null || $staff_id != null || $staff_not_in_cd != null || $staff_in_cd != null){
        $where_sql .= " AND t_aorder_staff.staff_id IN (\n";
        $where_sql .= "         SELECT\n";
        $where_sql .= "             t_staff.staff_id\n";
        $where_sql .= "         FROM\n";
        $where_sql .= "             t_aorder_staff\n";
        $where_sql .= "                 INNER JOIN\n";
        $where_sql .= "             t_staff\n";
        $where_sql .= "             ON t_aorder_staff.staff_id = t_staff.staff_id\n";

        //巡回担当者（カンマ区切り）
        //巡回担当者コード
        if($staff_in_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         charge_cd IN ($staff_in_cd)\n";
        }

        if($staff_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         t_staff.charge_cd = $staff_cd \n";
        }

        //除外巡回担当者コード（カンマ区切り）
        if($staff_not_in_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         charge_cd NOT IN ($staff_not_in_cd)\n";
        }

        //巡回担当者が選択されていた場合
        if($staff_id != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         t_staff.staff_id = $staff_id\n";
        }

        $where_sql .= ")\n";

        /*
        * 履歴：
        * 　日付　　　　B票No.　　　　担当者　　　内容　
        * 　2006/11/01　02-036　　　　suzuki-t　  委託先側で部署・担当者の検索をできるように変更
        */
       if($group_kind == '2'){
            $where2_sql  .= " AND t_aorder_h.act_id IS NULL\n";
       }
    }

    //部署が選択された場合
    if($part_id != NULL){
        $where_sql .= " AND t_aorder_staff.staff_id IN (";
        $where_sql .= "             SELECT\n";
        $where_sql .= "                 staff_id\n";
        $where_sql .= "             FROM\n";
        $where_sql .= "                 t_attach\n";
        $where_sql .= "             WHERE\n";
        $where_sql .= "                 t_attach.part_id = $part_id\n";
        $where_sql .= "             )\n";

        /*
        * 履歴：
        * 　日付　　　　B票No.　　　　担当者　　　内容　
        * 　2006/11/01　02-036　　　　suzuki-t　  委託先側で部署・担当者の検索をできるように変更
        */
        if($group_kind == '2'){
            $where2_sql .= " AND t_aorder_h.act_id IS NULL\n";
        }
    }

    //代行先ID
    if($charge_fc_id != null){
        $where2_sql .= " AND t_aorder_h.act_id = $charge_fc_id ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //代行先CD１
    if($charge_fc_cd1 != null){    
        $where2_sql .= " AND t_aorder_h.act_cd1 LIKE '%$charge_fc_cd1' ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //代行先CD2
    if($charge_fc_cd2 != null){
        $where2_sql .= " AND t_aorder_h.act_cd2 LIKE '%$charge_fc_cd2' ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //代行先名
    if($charge_fc_name != null){
        $where2_sql .= " AND t_aorder_h.act_id IN (SELECT \n";
        $where2_sql .= "                             client_id \n";
        $where2_sql .= "                         FROM \n";
        $where2_sql .= "                             t_client \n";
        $where2_sql .= "                         WHERE \n";
        $where2_sql .= "                             (t_client.client_name LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.client_name2 LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.shop_name LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.client_cname LIKE '%$charge_fc_name%')) \n";

        $where_sql .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }


    //所属マスタ
    if($attach_branch != null){
        $where_sql .= "  AND t_aorder_staff.staff_id IN (SELECT \n";
        $where_sql .= "                                     t_attach.staff_id  \n";
        $where_sql .= "                                 FROM \n";
        $where_sql .= "                                     t_part \n";
        $where_sql .= "                                         INNER JOIN ";
        $where_sql .= "                                     t_attach \n";
        $where_sql .= "                                     ON t_part.part_id = t_attach.part_id ";
        $where_sql .= "                                 WHERE \n";
        $where_sql .= "                                     branch_id = $attach_branch \n";
        $where_sql .= "                                 ) \n";

        if($group_kind == '2'){
            $where2_sql  .= " AND t_aorder_h.act_id IS NULL\n";
        }
    }

    //伝票区分
    if($act_div == "2"){
        $where_sql .= " AND t_aorder_h.act_id IS NULL ";
    }elseif($act_div == "3"){ 
        $where_sql .= " AND t_aorder_h.act_id IS NOT NULL ";
    }

    /*
    * 履歴：
    * 　日付　　　　B票No.　　　　担当者　　　内容　
    * 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
    */
    /****************************/
    //契約関数定義
    /****************************/
    require_once(INCLUDE_DIR."function_keiyaku.inc");
    /****************************/
    //カレンダ表示期間取得
    /****************************/
    $cal_array = Cal_range($db_con,$shop_id,true);
    $end_day   = $cal_array[1];     //対象終了期間

    /****************************/
    //一覧表示用SQL作成
    /****************************/
    //直営の場合
    if($group_kind == '2'){
        //代行分以外が選択された場合
        if($act_div != '3'){
            //--■自社の予定伝票
            $sql  = "(";
            $sql .= "SELECT\n";
            $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)";
            $sql .= "    ||";
            $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //--日報No.
            $sql .= "   t_aorder_h.ord_time,\n";                                            //--配送日
            $sql .= "   LPAD( CAST(t_staff.charge_cd AS text), 4, '0') AS charge_cd,\n";    //--スタッフコード（0埋め）
            $sql .= "   t_staff.staff_name,\n";                                             //--巡回担当者
            $sql .= "   COUNT(t_aorder_h.ord_time), \n";                                    //--巡回件数
            $sql .= "   t_staff.staff_id,\n";                                               //--スタッフID
            $sql .= "   CAST('' AS text) AS daikou_flg,\n";                                 //--代行の有無
            $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";                 //集計日報発行日
            $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
            $sql .= "   daily_slip_id \n";
            $sql .= "FROM\n";
            $sql .= "   t_aorder_h\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
            $sql .= "   AND t_aorder_staff.staff_div = 0\n";                               //--メイン担当者
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_client\n";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id\n";

            // 　2006/11/01　02-018　　　　suzuki-t　  休止中・解約の得意先表示
            //$sql .= "   AND t_client.state = '1'\n";

            $sql .= "       INNER JOIN\n";
            $sql .= "   t_staff\n";
            $sql .= "   ON t_staff.staff_id = t_aorder_staff.staff_id\n";
            $sql .= "WHERE \n";
            $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().")\n";                         //--自社伝票(直営のIDを全て指定して下さい)
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.act_id IS NULL\n";
            $sql .= "   AND\n";
//          $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない
            $sql .= "   t_aorder_h.del_flg = false \n";

            // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .=     $where_sql;
            $sql .= "GROUP BY\n";
            $sql .= "   t_aorder_h.daily_slip_id, \n";
            $sql .= "   t_aorder_h.ord_time,\n";
            $sql .= "   t_staff.staff_id,\n";
            $sql .= "   t_staff.charge_cd,\n";
            $sql .= "   t_staff.staff_name \n";
            $sql .= "ORDER BY\n";
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time\n";
            $sql .= ")\n";
        }

        //指定なしが選択された場合
        if($act_div == '1'){
            $sql .= "UNION\n";
        }

        //自社巡回以外が選択された場合
        if($act_div != '2'){
            //--■委託した予定伝票
            $sql .= "(\n";
            $sql .= "SELECT \n";
            $sql .= "   CAST('' AS text) AS No,\n";                                         //--日報No.（代行は無し）
            $sql .= "   t_aorder_h.ord_time,\n";                                            //--配送日
            $sql .= "   CAST(t_client.client_cd1 AS text)\n";
            $sql .= "    || '-' ||\n";
            $sql .= "   CAST(t_client.client_cd2 AS text),\n";                              //--得意先コード
            $sql .= "   t_client.shop_name,\n";                                             //--巡回担当者
            $sql .= "   COUNT(t_aorder_h.ord_time), \n";                                    //--巡回件数
            $sql .= "   t_client.client_id,\n";                                             //--受託先
            $sql .= "   CAST('○' AS text) AS daikou_flg,\n";                                //--代行の有無 
            $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
            $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
            $sql .= "   daily_slip_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_client \n";
            $sql .= "   ON t_aorder_h.act_id = t_client.client_id \n";
            $sql .= "   AND (t_aorder_h.contract_div=2 OR t_aorder_h.contract_div=3)\n";
            $sql .= " WHERE\n";
            $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
            $sql .= "   AND\n";
//          $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない
            $sql .= "   t_aorder_h.del_flg = false\n";

            // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .= "   $date_sql ";
            $sql .=     $where2_sql ;
            $sql .= " GROUP BY\n";
            $sql .= "   t_aorder_h.daily_slip_id, \n";
            $sql .= "   t_aorder_h.ord_time,\n";
            $sql .= "   t_client.client_id,\n";
            $sql .= "   t_client.client_cd1,\n";
            $sql .= "   t_client.client_cd2,\n";
            $sql .= "   t_client.shop_name\n";
            $sql .= " ORDER BY\n";
            $sql .= "   t_client.client_cd1,\n";
            $sql .= "   t_client.client_cd2,\n";
            $sql .= "   t_aorder_h.ord_time \n";
            $sql .= ") ";
        }

        //指定なしが選択された場合
        if($act_div == '1'){
            $sql .= " ORDER by 7,3 ";
        }

    //直営以外の場合
    }else{
        $sql  = "(\n";
        $sql .= "SELECT\n";
        $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
        $sql .= "    ||\n";
        $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //日報No.
        $sql .= "   t_aorder_h.ord_time,\n";                                            //配送日
        $sql .= "   lpad(t_staff.charge_cd, 4, '0') AS charge_cd,\n";                   //担当者コード
        $sql .= "   t_staff.staff_name,\n";                                             //巡回担当者
//        $sql .= "   count(t_aorder_h.ord_time), \n";                                    //巡回件数
        $sql .= "   NULL, \n";
        $sql .= "   t_staff.staff_id, \n";
        $sql .= "   CAST('' AS text) AS daikou_flg,\n";                                  //--代行の有無
//        $sql .= "   NULL, \n";
        $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
        $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
        $sql .= "   daily_slip_id, \n";
        $sql .= "   t_aorder_h.shop_id ";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_aorder_staff\n";
        $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";                                   //メイン担当者
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON  t_staff.staff_id = t_aorder_staff.staff_id \n";
        $sql .= "WHERE\n";
        $sql .= "   t_aorder_h.shop_id=$shop_id\n"; // ショップ
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.contract_div = '1'";
        $sql .= "   AND\n";
//      $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない
        $sql .= "   t_aorder_h.del_flg = false\n";

        // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        $sql .=     $where_sql;
        $sql .= "GROUP BY t_aorder_h.shop_id,t_aorder_h.daily_slip_id, t_aorder_h.ord_time,t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name \n";
        $sql .= "ORDER BY t_staff.charge_cd,t_aorder_h.ord_time \n";
        $sql .= ")\n";

        //  　2006/11/01　02-005　　　　suzuki-t　  受注番号がふられた代行伝票を表示
//      $sql .= ";\n";
        //--■委託した予定伝票
        $sql .= "UNION \n";

        $sql .= "(\n";
        $sql .= "SELECT \n";
        $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
        $sql .= "    ||\n";
        $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //日報No.
        $sql .= "   t_aorder_h.ord_time,\n";                                            //配送日
        $sql .= "   lpad(t_staff.charge_cd, 4, '0') AS charge_cd,\n";                   //担当者コード
        $sql .= "   t_staff.staff_name,\n";                                             //巡回担当者
        $sql .= "   NULL, \n";
//        $sql .= "   count(t_aorder_h.ord_time), \n";                                    //巡回件数
//      $sql .= "   $shop_id,\n";                                                       //--受託先
        $sql .= "   t_staff.staff_id, \n";                                               //--スタッフID

        $sql .= "   CAST('○' AS text) AS daikou_flg,\n";                                //--代行の有無 
//        $sql .= "   NULL, \n";
        $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
        $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
        $sql .= "   daily_slip_id, \n";
        $sql .= "   t_aorder_h.shop_id ";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h\n";
        $sql .= "   INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";                                   //メイン担当者
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON  t_staff.staff_id = t_aorder_staff.staff_id \n";
        $sql .= " WHERE\n";
        $sql .= "   t_aorder_h.act_id = $shop_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.contract_div = '2' ";
        $sql .= "   AND\n";
//        $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
//        $sql .= "   AND\n";
//      $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない
        $sql .= "   t_aorder_h.del_flg = false\n";

        // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        $sql .=     $where_sql;
        $sql .= "GROUP BY t_aorder_h.shop_id, t_aorder_h.daily_slip_id, t_aorder_h.ord_time,t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name \n";
        $sql .= "ORDER BY t_staff.charge_cd,t_aorder_h.ord_time \n";
        $sql .= ") \n";
        $sql .= " ORDER by 3,2 ";
    }


    $result = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($result);

    //表示件数
    if($display_num != null){
        // 表示件数
        switch ($display_num){
            case "1":
                $limit = $total_count;
                break;
            case "2":
                $limit = "100";
                break;
        }

        // 取得開始位置
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // 行削除でページに表示するレコードが無くなる場合の対処
        if($page_count != null){
            // 行削除でmatch_countとoffsetの関係が崩れた場合
            if ($total_count <= $offset){
                // オフセットを選択件前に
                $offset     = $offset - $limit;
                // 表示するページを1ページ前に（一気に2ページ分削除されていた場合などには対応してないです）
                $page_count = $page_count - 1;
                // 選択件数以下時はページ遷移を出力させない(nullにする)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }
        }else{
            $offset = 0;
        }
        $limit_offset   = ($limit != null) ? " LIMIT $limit OFFSET $offset \n" : null;
        $result         = Db_Query($db_con, $sql.$limit_offset);
        $match_count    = pg_num_rows($result);
        $page_data      = Get_Data($result);
    }

}else{
    $match_count = 0;
}

/***************************/
//予定データ明細へ送る受注IDを抽出
/***************************/
for($i = 0, $key=1; $i < $match_count; $i++,$key++){
    
    $page_data[$i]["key"] = $limit*($page_count-1) +$key;

    //直営の判定
    if($group_kind == '2'){
        //直営

        //代行の場合
        if($page_data[$i][6] == '○'){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= "FROM\n";
            $sql .= "   t_aorder_h \n";
            $sql .= "       INNER JOIN \n";
            $sql .= "   t_client \n";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.act_id = ".$page_data[$i][5]."\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .= "ORDER BY t_aorder_h.route\n";
            $sql .= ";";
        //代行以外
        }else{
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_aorder_h\n";
            $sql .= "   ON\n";
            $sql .= ($group_kind == 2)? "  t_aorder_h.shop_id IN (".Rank_Sql().")\n" : "  t_aorder_h.shop_id = $shop_id";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_staff.staff_div = '0'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
        
            // 　2006/11/01　02-018　　　　suzuki-t　  休止中・解約の得意先表示
            //$sql .= "   AND t_client.state = '1'\n";
            
            $sql .= "       INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";

            $sql .= "WHERE\n";
//            $sql .= "   t_aorder_h.reserve_del_flg = false \n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない
            $sql .= "   t_aorder_h.del_flg = false \n";  //(2006/09/06) (kaji) 削除伝票は一覧に表示しない

            // 　2006/11/02　02-037　　　　suzuki-t　　カレンダー表示期間指定  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= "ORDER BY t_aorder_h.route\n";
            $sql .= ";";
        }
    }else{
        //ＦＣ
        if($page_data[$i][6] == ''){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   INNER JOIN t_aorder_h ON t_aorder_h.shop_id = $shop_id ";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_div = '0'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
       
            $sql .= "   INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";


            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
            $sql .= "   AND \n";
            $sql .= "   t_aorder_h.contract_div = '1' \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= ";";
//        $sql .= "UNION\n";

        }elseif($page_data[$i][6] == '○'){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n" ;
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   INNER JOIN t_aorder_h ON t_aorder_h.act_id = $shop_id ";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_div = '0'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.aord_id = t_aorder_staff.aord_id\n";

            $sql .= "   INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";

            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
            $sql .= "   AND \n";
            $sql .= "   t_aorder_h.contract_div IN ('3', '2') \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= ";";

            //PDF側で代行として扱われないように、nullをセット
            $page_data[$i][6] = null;
        }
    }

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);

    $page_data[$i][4] = $num;   //巡回件数

    //集計日報発行済みフラグを初期化
    unset($slip_out_flg);

    for($j = 0; $j < $num; $j++){
        $get_ary[$i][$j] = pg_fetch_result($result,$j,0);

        //伝票発行対象(通常の場合)
        if(pg_fetch_result($result,$j,2) == '1'){
            $slip_ary[$i][] = pg_fetch_result($result,$j,0);
        }

        //集計日報発行済みチェック
        $slip_out_chk = pg_fetch_result($result,$j,1);
        if($slip_out_chk != null){
            $slip_out_flg[] = 't';
        }else{
            $slip_out_flg[] = 'f';
        }
    }

    //明細へ送るID
    $page_data[$i]["ary_id"] = urlencode(serialize($get_ary[$i]));

    //伝票発行に送るID
    if(count($slip_ary[$i]) > 0){
        $page_data[$i]["slip_out_id"]     = implode(',', $slip_ary[$i]);
    }

    //抽出用のID
    $page_data[$i]["slip_ary_id"]     = implode(',',$get_ary[$i]);
    $page_data[$i]["slip_all_count"]  = count($get_ary[$i]);    //伝票の総数

    //伝票発行している数を表示
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) AS slip_out_count ";
    $sql .= "FROM ";
    $sql .= "   t_aorder_h ";
    $sql .= "       INNER JOIN ";
    $sql .="    t_client ";
    $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= "   aord_id IN (".$page_data[$i]["slip_ary_id"].")";
    $sql .= "   AND ";
    $sql .= "   slip_out_day IS NOT NULL ";
    $sql .= "   AND ";
    $sql .= "   t_client.slip_out NOT IN ('2', '3') ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data[$i]["slip_out_count"] = pg_fetch_result($result, 0,0);

    //伝票発行形式が指定の数
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) AS slip_format_count ";
    $sql .= "FROM ";
    $sql .= "   t_aorder_h ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_client ";
    $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= "   aord_id IN (".$page_data[$i]["slip_ary_id"].")";
    $sql .= "   AND ";
    $sql .= "   t_client.slip_out IN ('2', '3') ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data[$i]["slip_format_count"] = pg_fetch_result($result, 0,0);

    //伝票の発行済みと未発行の数を数える
    $slip_state_count = array_count_values($slip_out_flg);
    $page_data[$i]["slip_count"]   = $slip_state_count['t'];    //付番済
    $page_data[$i]["unslip_count"] = $slip_state_count['f'];    //付番前

    //伝票発行していない伝票が存在した場合
    if(in_array('f', $slip_out_flg)){
        $page_data[$i]["slip_flg"] = false;

        //検索条件で未発行が指定されていた場合
        if($slip_state == '2'){
            unset($page_data[$i]);
        }
    }else{
        $page_data[$i]["slip_flg"] = true;

        //検索条件で発行済みが指定されていた場合
        if($slip_state == '3'){
            unset($page_data[$i]);
        }
    }
}

//表示データ配列のキーを振りなおす
if(is_array($page_data)){
    $page_data = array_values($page_data);
}

/***************************/
//動的フォーム作成
/***************************/
$form->addElement("checkbox", "aord_prefix_all", "", "前集計日報(0)", 
                    "onClick=\"javascript:All_Check_Aord_Prefix('aord_prefix_all')\"
                ");
$form->addElement("checkbox", "aord_unfix_all", "", "付番集計日報(1)", 
                    "onClick=\"javascript:All_Check_Aord_Unfix('aord_unfix_all')\"
                ");
$form->addElement("checkbox", "aord_fix_all", "", "(1)再発行", 
                    "onClick=\"javascript:All_Check_Aord_Fix('aord_fix_all')\"
                ");

//伝票発行
// 一括チェック用チェックボックス
$form->addElement("checkbox", "slip_out_all", "売上伝票発行", "売上伝票発行",
    "onClick=\"javascript:All_Check_Slip('slip_out_all');\""
);
$form->addElement("checkbox", "reslip_out_all", "再発行", "再発行",
    "onClick=\"javascript:All_Check_Reslip('reslip_out_all');\""
);

$form->addElement("hidden","hdn_button");
$form->addElement("hidden","src_module","集計日報");                 //売上伝票（PDF）で遷移元を知るために定義
//表示データ件数
$match_count = count($page_data);

$form->addElement("button", "slip_out_button", "売上伝票発行",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '売上伝票発行');\""
);

$form->addElement("button", "reslip_out_button", "　再　発　行　",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '再発行');\""
);

//検索条件に該当するデータ分ループ
$k = 0;
for($i = 0; $i < $match_count; $i++){


    //発行済の場合
    if($page_data[$i]["slip_flg"] == true){
        $slipout_chk_data[] = $i;

        $form->addElement(
            "checkbox", "form_reslipout_check[$i]", "", "");
        $set_data["form_reslipout_check"][$i] = "";
    //未発行の場合
    }else{
        $unslipout_chk_data[] = $i;

        $form->addElement(
            "checkbox", "form_preslipout_check[$i]", "", ""
        );
        $set_data["form_preslipout_check"][$i] = "";

        $form->addElement(
            "checkbox", "form_slipout_check[$i]", "", "");
        $set_data["form_slipout_check"][$i] = "";
    }

    // 配送日
    $form->addElement(
        "hidden", "hdn_send_day[$i]"
    );
    $set_data["hdn_send_day"][$i] = $page_data[$i][1];

    // スタッフID
    $form->addElement(
        "hidden", "hdn_staff_id[$i]"
    );
    $set_data["hdn_staff_id"][$i] = $page_data[$i][5];

    // 代行区分
    $form->addElement(
        "hidden", "hdn_act_flg[$i]"
    );
    $set_data["hdn_act_flg"][$i] = $page_data[$i][6];
    //集計日報ID
    $form->addElement(
        "hidden", "hdn_daily_slip_id[$i]"
    );
    $set_data["hdn_daily_slip_id"][$i] = $page_data[$i][9];

    //伝票ID
    $form->addElement(
        "hidden", "hdn_imp_slip_id[$i]"
    );
    $set_data["hdn_imp_slip_id"][$i] = implode(',', $get_ary[$i]);


    //伝票発行
    //伝票の総数と指定伝票を指定している得意先の数が同じ場合
    //何も表示しない
    if($page_data[$i]["slip_all_count"] == $page_data[$i]["slip_format_count"]){
    //伝票の総数から指定伝票を指定している得意先の数を引いたものと、発行済みの伝票の数が同じ場合
    //再発行
    }elseif(($page_data[$i]["slip_all_count"] - $page_data[$i]["slip_format_count"]) == $page_data[$i]["slip_out_count"]){
        $form->addElement("advcheckbox", "form_reslip_check[$i]", NULL, NULL, NULL, array("f", $page_data[$i]["slip_out_id"]));
        $reslip_out_id[$k] = $page_data[$i]["slip_out_id"];
        $set_data["form_reslip_check"][$i] = "f";
    //発行
    }elseif($page_data[$i]["slip_flg"] == true){
        $form->addElement("advcheckbox", "form_slip_check[$i]", NULL, NULL, NULL, array("f", $page_data[$i]["slip_out_id"]));
        $slip_out_id[$k] = $page_data[$i]["slip_out_id"];
        $set_data["form_slip_check"][$i] = "f";
    }
    $k++;
}

//値をセット
$form->setConstants($set_data);

/****************************/
//js
/****************************/
// 集計日報(ALLチェックJSを作成)
$javascript   = Create_Allcheck_Js ("All_Check_Aord_Prefix","form_preslipout_check",$unslipout_chk_data,1);
$javascript  .= Create_Allcheck_Js ("All_Check_Aord_Unfix" ,"form_slipout_check"   ,$unslipout_chk_data,1);
$javascript  .= Create_Allcheck_Js ("All_Check_Aord_Fix"   ,"form_reslipout_check"   ,$slipout_chk_data,1);
// 伝票発行(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js  ("All_Check_Slip",  "form_slip_check",  $slip_out_id);
// 再発行(ALLチェックJSを作成)
$javascript .= Create_Allcheck_Js  ("All_Check_Reslip", "form_reslip_check",    $reslip_out_id);



//ボタンのPOSTを渡す
$javascript  .= "function Post_Next_Page(page,hidden_form, mesg){\n";
$javascript  .= "   var hdn = hidden_form;\n";
$javascript  .= "   document.dateForm.elements[hdn].value = mesg;\n";
$javascript  .= "   //別画面でウィンドウを開く\n";
$javascript  .= "   document.dateForm.target=\"_blank\";\n";
$javascript  .= "   document.dateForm.action=page;\n";
$javascript  .= "   //POST情報を送信する\n";
$javascript  .= "   document.dateForm.submit();\n";
$javascript  .= "   document.dateForm.target=\"_self\";\n";
$javascript  .= "   document.dateForm.action='./2-2-113.php';\n";
$javascript  .= "}\n";

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_f('sale','1');

/****************************/
//画面ヘッダー作成
/****************************/

$page_title .= "　".$form->_elements[$form->_elementIndex[slip_button]]->toHtml();
if($group_kind == '2'){
    $page_title .= "　".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
}
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();

$page_header = Create_Header($page_title);

$html_page  = Html_Page2($total_count,$page_count,1,$limit,950);
$html_page2 = Html_Page2($total_count,$page_count,2,$limit,950);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'charges_msg'   => "$charges_msg",
    'chargee_msg'   => "$chargee_msg",
    'decimal_msg'   => "$decimal_msg",
    'nodecimal_msg' => "$nodecimal_msg",
    'match_count'   => "$match_count",
    'javascript'    => "$javascript",
    'search_html'   => "$search_html"
));
$smarty->assign('page_data',$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
