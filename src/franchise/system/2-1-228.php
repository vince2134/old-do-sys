<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0083    suzuki      登録・変更のログを残すように修正
 *  
 *  
 *
*/

/*----------------------------------------------------------
    ページ内定義
----------------------------------------------------------*/

/*------------------------------------------------
    外部参照ファイル定義
------------------------------------------------*/
// 環境設定ファイル
require_once("ENV_local.php");

/*------------------------------------------------
    変数定義
------------------------------------------------*/
// ページ名
$page_title = "コースマスタ";

// フォーム
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=javascript:return confirm(true)");

// DB接続設定
$db_con     = Db_Connect();


// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*------------------------------------------------
    外部変数取得
------------------------------------------------*/
$shop_id        = $_SESSION["client_id"];
$group_kind     = $_SESSION["group_kind"];
$get_staff_id   = $_GET["staff_id"];
$post_staff_id  = $_POST["form_staff_select"];

$where = ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["staff_id"] != null && Get_Id_Check_Db($db_con, $_GET["staff_id"], "staff_id", "t_attach", "num", $where) != true){
    header("Location: ../top.php");
}

/*------------------------------------------------
    読込時の処理
------------------------------------------------*/
// スタッフID取得
if ($get_staff_id != null || $post_staff_id != null){
    $staff_id = ($get_staff_id != null) ? $get_staff_id : $post_staff_id;
}

// 登録or変更判断
if ($staff_id != null){
    $sql    = "SELECT COUNT(staff_id) FROM t_course WHERE staff_id = $staff_id;";
    $res    = Db_Query($db_con, $sql);
    $count  = pg_fetch_result($res, 0);
    $submit_state   = ($count > 0) ? "変更" : "登録";
    $submit_label   = ($count > 0) ? "変　更" : "登　録";
}else{
    $submit_label   = "登　録";
}


/*------------------------------------------------
    QuickForm - フォームオブジェクト定義
------------------------------------------------*/
/* ヘッダフォーム */
// 登録画面
$form->addElement("button", "new_button", "登録画面", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:Referer('2-1-227.php')\"");

/* メインフォーム */
// 担当者
$select_value = Select_Get($db_con, "staff");
$freeze_form = $form->addElement("select", "form_staff_select", "", $select_value, "onChange=\"document.dateForm.submit();\"");

// スタッフの指定がある場合のみ生成
if ($get_staff_id != null || $post_staff_id != null){

    // コース名
    // 巡回区分毎ループ
    for ($i=0; $i<3; $i++){
        // 週毎ループ
        $j_num = ($i == 1) ? 5 : 4;                     // 巡回区分1の場合のみ第5週目が存在するので5回ループ
        for ($j=0; $j<$j_num; $j++){
            // 曜日毎ループ
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // 第5週目は1日しかないので1ループ
            for ($k=0; $k<$k_num; $k++){
                $form->addElement("text", "form_course_name[$i][$j][$k]", "", "size=\"24\" maxlength=\"15\" $g_form_option");
            }
        }
    }

    // 登録ボタン
    $form->addElement("submit", "form_submit_btn", $submit_label, "onClick=\"javascript:return Dialogue4('".$submit_state."します');\" $disabled");

    // OKボタン
    $form->addElement("button", "form_ok_btn", "Ｏ　Ｋ", "onClick=javascript:location.href='./2-1-227.php'");
    
    // 戻るボタン
    $form->addElement("button", "form_return_btn", "戻　る", "onClick=\"history.back()\"");

}

/* フリーズ */
// 一覧から遷移してきた（GETがある）場合は巡回担当者セレクトボックスにGETデータを代入し、フリーズ
if ($_GET["staff_id"] != null){
    $get_staff_data["form_staff_select"] = $_GET["staff_id"];
    $form->setConstants($get_staff_data);
    $freeze_form->freeze();
}


/*----------------------------------------------------------
    登録ボタン押下時の処理
----------------------------------------------------------*/
if (isset($_POST["form_submit_btn"])){

    /*------------------------------------------------
        エラーチェック
    ------------------------------------------------*/
    // コース名
    // 全角/半角スペースのみチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_bank_name", "銀行名 にスペースのみの登録はできません。", "no_sp_name");
    foreach ($_POST["form_course_name"] as $key1 => $value1){
        foreach ($value1 as $key2 => $value2){
            foreach ($value2 as $key3 => $value3){
                if (ereg("^[ 　]+$", $value3)){
                    $form_err_flg = true;
                    break;
                }
            }
            if ($form_err_flg == true){
                break;
            }
        }
        if ($form_err_flg == true){
            break;
        }
    }

    // エラーの無い場合
    if ($form_err_flg != true){
    /*------------------------------------------------
        DB処理
    ------------------------------------------------*/
    Db_Query($db_con, "BEGIN;");

    // POSTデータを配列に代入
    // 月曜スタート→日曜スタートに仕変されたので配列の中身を入れ替え
    foreach ($_POST["form_course_name"] as $key1 => $value1){
        foreach ($value1 as $key2 => $value2){
            foreach ($value2 as $key3 => $value3){

                // 月例（日付）の場合は普通に代入する
                if ($key1 == "1"){
                    $post_course_name[$key1][$key2][$key3] = $value3;
                // それ以外の場合は配列の中身を入れ替えて代入
                }else{
                    switch ($key3){
                        case "0":
                            $post_course_name[$key1][$key2][6] = $value3;
                            break;
                        case "1":
                            $post_course_name[$key1][$key2][0] = $value3;
                            break;
                        case "2":
                            $post_course_name[$key1][$key2][1] = $value3;
                            break;
                        case "3":
                            $post_course_name[$key1][$key2][2] = $value3;
                            break;
                        case "4":
                            $post_course_name[$key1][$key2][3] = $value3;
                            break;
                        case "5":
                            $post_course_name[$key1][$key2][4] = $value3;
                            break;
                        case "6":
                            $post_course_name[$key1][$key2][5] = $value3;
                            break;
                    }
                }

            }
        }
    }

    // 種類でループ（ABCD週、月例（日付）、月例（曜日））
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // 巡回区分1の場合のみ第5週目が存在するので5回ループ
        // 週でループ
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // 第5週目は1日しかないので1ループ
            // 曜日でループ
            for ($k=0; $k<$k_num; $k++){

                // INSERT
                if ($submit_state == "登録"){
					$work_div = 1;

                    $sql  = "INSERT INTO t_course ";
                    $sql .= "( ";
                    $sql .= "   course_id, ";       // コースID
                    $sql .= "   course_name, ";     // コース名
                    $sql .= "   staff_id, ";        // 担当者ID
                    $sql .= "   round_div, ";       // 巡回区分
                    $sql .= "   abcd_week, ";       // 週名(ABCD)
                    $sql .= "   cale_week, ";       // 週名(1234)
                    $sql .= "   week_rday, ";       // 指定曜日
                    $sql .= "   rday, ";            // 指定日
                    $sql .= "   shop_id ";          // ショップID
                    $sql .= ") ";
                    $sql .= "VALUES ";
                    $sql .= "( ";
                    $sql .= "   (SELECT COALESCE(MAX(course_id), 0)+1 FROM t_course), ";
                    $sql .= "   '".(string)($post_course_name[$i][$j][$k])."', ";
                    $sql .= "   $staff_id, ";
                    $sql .= "   '".($i+1)."', ";
                    $sql .=     ($i == 0) ? "'".($j+1)."', " : "NULL, ";
                    $sql .=     ($i == 2) ? "'".($j+1)."', " : "NULL, ";
                    $sql .=     ($i != 1) ? "'".($k+1)."', " : "NULL, ";
                    if ($i == 1 && $j == 4 && $k == 0){
                        $sql .= " '30', ";          // 月例（日付）の月末の場合は30で登録する
                    }else{
                        $sql .=     ($i == 1) ? "'".(($j*7)+($k+1))."', " : "NULL, ";
                    }
                    $sql .= "   $shop_id ";
                    $sql .= ") ";
                    $sql .= ";";
                // UPDATE
                }else{
					$work_div = 2;

                    $sql  = "UPDATE t_course ";
                    $sql .= "SET ";
                    $sql .= "   course_name = '".(string)($post_course_name[$i][$j][$k])."' ";
                    $sql .= "WHERE ";
                    $sql .= "   staff_id = $staff_id ";
                    $sql .= "AND ";
                    $sql .= "   round_div = '".($i+1)."' ";
                    $sql .= "AND ";
                    $sql .=     ($i == 0) ? "abcd_week = '".($j+1)."' " : "abcd_week IS NULL ";
                    $sql .= "AND ";
                    $sql .=     ($i == 2) ? "cale_week = '".($j+1)."' " : "cale_week IS NULL ";
                    $sql .= "AND ";
                    $sql .=     ($i != 1) ? "week_rday = '".($k+1)."' " : "week_rday IS NULL ";
                    $sql .= "AND ";
                    if ($i == 1 && $j == 4 && $k == 0){
                        $sql .= " rday = 30 ";    // 月例（日付）の月末の場合は30で指定する
                    }else{
                        $sql .=     ($i == 1) ? "rday = ".(($j*7)+($k+1))." " : "rday IS NULL ";
                    }
                    $sql .= "AND ";
                    $sql .= "   shop_id = $shop_id ";
                    $sql .= ";";
                }

                $res = Db_Query($db_con,$sql);
                if ($res == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

            }
        }
    }

	//コースマスタの値をログに書き込む
	//（データコード：巡回担当者CD  名称：巡回担当者名）
	$sql  = "SELECT ";
	$sql .= "    charge_cd,";
	$sql .= "    staff_name ";
	$sql .= "FROM ";
	$sql .= "    t_staff ";
	$sql .= "WHERE ";
	$sql .= "    staff_id = $staff_id;";
	$res = Db_Query($db_con,$sql);
	$data_list = Get_Data($res,3);
    $result = Log_Save($db_con,'course',$work_div,$data_list[0][0],$data_list[0][1]);
    //ログ登録時にエラーになった場合
    if($result === false){
        Db_Query($db_con,"ROLLBACK;");
        exit;
    }

    Db_Query($db_con, "COMMIT;");

    $form->freeze();

    $touroku_ok_flg = true;

    }else{

        // エラーメッセージ作成
        $err_msg1 = "コース名 にスペースのみの登録はできません。";

    }

}

/*----------------------------------------------------------
    一覧表データ作成
----------------------------------------------------------*/
/*
// セレクトボックスでスタッフの選択がされた場合は一旦フォームを空にする
if ($_POST["form_staff_select"] != null){
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // 巡回区分1の場合のみ第5週目が存在するので5回ループ
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // 第5週目は1日しかないので1ループ
            for ($k=0; $k<$k_num; $k++){
                $course_null["form_course_name"][$i][$j][$k] = "";
            }
        }
    }
    $form->setDefaults($cource_null);
}
*/


// スタッフの指定がある場合のみ作成
if ($get_staff_id != null || $post_staff_id != null){

    /* フォームにデータをぶっこむ */
    // 登録ボタン押下時はPOSTされたデータを代入
    // 初期表示の場合はnullを代入
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // 巡回区分1の場合のみ第5週目が存在するので5回ループ
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // 第5週目は1日しかないので1ループ
            for ($k=0; $k<$k_num; $k++){
                $course_data["form_course_name"][$i][$j][$k] = (isset($_POST["form_submit_btn"])) ? $_POST["form_course_name"][$i][$j][$k] : "";
            }
        }
    }

    /*------------------------------------------------
        登録済コース名取得
    ------------------------------------------------*/
    $sql  = "SELECT ";
    $sql .= "   t_course.round_div, ";  // 巡回区分(1:ABCD週, 2:月例（日付）, 3:月例（曜日）)
    $sql .= "   t_course.abcd_week, ";  // 週名（ABCD）
    $sql .= "   t_course.cale_week, ";  // 週名（1〜4）
    $sql .= "   t_course.rday, ";       // 指定日
    $sql .= "   t_course.week_rday, ";  // 指定曜日
    $sql .= "   t_course.course_name "; // コース名
    $sql .= "FROM t_course ";
    $sql .= "   INNER JOIN t_staff ";
    $sql .= "   ON t_course.staff_id = t_staff.staff_id ";
    $sql .= "   AND t_staff.staff_id = $staff_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_course.shop_id IN (".Rank_Sql().") " : " t_course.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "   t_staff.charge_cd, ";
    $sql .= "   t_staff.staff_name, ";
    $sql .= "   t_course.round_div, ";
    $sql .= "   t_course.abcd_week, ";
    $sql .= "   t_course.cale_week, ";
    $sql .= "   t_course.rday, ";
    $sql .= "   t_course.week_rday ";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $total_count = @pg_num_rows($res);
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // フォーム格納用コース名データ作成
    for ($i=0; $i<$total_count; $i++){

        // 配列key作成
        $round_div  = $ary_list_data[$i][0]-1;  // 巡回区分
        $abcd_week  = $ary_list_data[$i][1]-1;  // 週名(ABCD)
        $cale_week  = $ary_list_data[$i][2]-1;  // 週名(1234)
        $week_rday  = $ary_list_data[$i][4]-1;  // 指定曜日

        // 月例（日付）の場合
        if ($ary_list_data[$i][0] == "2"){
            // 配列key作成
            // 指定日が（月曜スタートで）何週目にあたるか算出（指定日が30なら4）
            $week_num   = ($ary_list_data[$i][3] != "30") ? bcdiv(($ary_list_data[$i][3]-1), 7) : 4;
            // 指定日が（月曜スタートで）↑で算出した週の何日目にあたるか算出（指定日が30なら0）
            $day_num    = ($ary_list_data[$i][3] != "30") ? ($ary_list_data[$i][3]-1) - ($week_num*7) : 0;
        }

        // コース名（ABCD週の場合）
        if ($ary_list_data[$i][0] == "1"){
            $course_data["form_course_name"][$round_div][$abcd_week][$week_rday]    = $ary_list_data[$i][5];
        // コース名（月例（日付）の場合）
        }elseif ($ary_list_data[$i][0] == "2"){
            $course_data["form_course_name"][$round_div][$week_num][$day_num]       = $ary_list_data[$i][5];
        // コース名（月例（曜日）の場合）
        }elseif ($ary_list_data[$i][0] == "3"){
            $course_data["form_course_name"][$round_div][$cale_week][$week_rday]    = $ary_list_data[$i][5];
        }

    }

    // 月曜スタート→日曜スタートに仕変されたので配列の中身を入れ替え
    for ($i=0; $i<count($course_data["form_course_name"][0]); $i++){
        $ary_cd0[$i][0] = $course_data["form_course_name"][0][$i][6];
        $ary_cd0[$i][1] = $course_data["form_course_name"][0][$i][0];
        $ary_cd0[$i][2] = $course_data["form_course_name"][0][$i][1];
        $ary_cd0[$i][3] = $course_data["form_course_name"][0][$i][2];
        $ary_cd0[$i][4] = $course_data["form_course_name"][0][$i][3];
        $ary_cd0[$i][5] = $course_data["form_course_name"][0][$i][4];
        $ary_cd0[$i][6] = $course_data["form_course_name"][0][$i][5];
    }
    $course_data["form_course_name"][0] = $ary_cd0; 
    for ($i=0; $i<count($course_data["form_course_name"][2]); $i++){
        $ary_cd1[$i][0] = $course_data["form_course_name"][2][$i][6];
        $ary_cd1[$i][1] = $course_data["form_course_name"][2][$i][0];
        $ary_cd1[$i][2] = $course_data["form_course_name"][2][$i][1];
        $ary_cd1[$i][3] = $course_data["form_course_name"][2][$i][2];
        $ary_cd1[$i][4] = $course_data["form_course_name"][2][$i][3];
        $ary_cd1[$i][5] = $course_data["form_course_name"][2][$i][4];
        $ary_cd1[$i][6] = $course_data["form_course_name"][2][$i][5];
    }
    $course_data["form_course_name"][2] = $ary_cd1; 

if ($form_err_flg != true){
    // コース名をフォームにセット
    $form->setConstants($course_data);
}

    /*------------------------------------------------
        コース内容取得
    ------------------------------------------------*/
    /* 空の連想配列を作成する */
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // 巡回区分1の場合のみ第5週目が存在するので5回ループ
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // 第5週目は1日しかないので1ループ
            for ($k=0; $k<$k_num; $k++){
                $ary_disp_data[$i][$j][$k] = null;
            }
        }
    }

    /* コース内容取得（ABCD週） */
    // 週毎ループ
    for ($i=0; $i<4; $i++){

        // 取得条件作成
        $where_sql  = " AND (t_contract.abcd_week = '".($i+1)."' ";
        $where_sql .= ($i <= 1) ? ") " : null;
        $where_sql .= ($i == 2) ? " OR (t_contract.abcd_week = '1' AND t_contract.cycle = '2')) " : null;
        $where_sql .= ($i == 3) ? " OR (t_contract.abcd_week = '2' AND t_contract.cycle = '2')) " : null;

        $sql  = "SELECT ";
        $sql .= "   t_contract.week_rday, ";        // 指定曜日
        $sql .= "   t_contract.route, ";            // 順路
        $sql .= "   t_client.client_cname, ";       // 契約先名（略称）
        $sql .= "   t_client.client_id, ";          // 契約先ID
        $sql .= "   t_contract.contract_id ";       // 契約情報ID
        $sql .= "FROM ";
        $sql .= "   t_contract ";
        $sql .= "   INNER JOIN t_con_staff ";
        $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
        $sql .= "       AND t_con_staff.staff_id = $staff_id ";
        $sql .= "   INNER JOIN t_client ";
        $sql .= "       ON t_contract.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
        $sql .= "AND ";
        $sql .= "   t_contract.round_div = '1' ";
        $sql .= $where_sql;
        $sql .= "ORDER BY ";
        $sql .= "   t_contract.week_rday, ";
        $sql .= "   t_contract.route, ";
        $sql .= "   t_client.client_id ";
        $sql .= ";";

        $res  = Db_Query($db_con, $sql);
        $total_count = pg_num_rows($res);
        $ary_list_data = null;
        for ($j=0; $j<$total_count; $j++){
            $ary_list_data[] = @pg_fetch_array($res, $j, PGSQL_NUM);
        }

        // 1日の内の契約先番号
        $client_row = 0;

        // コース内容一覧作成
        for ($j=0; $j<$total_count; $j++){

            // 配列key作成
            $week_rday  = $ary_list_data[$j][0]-1;  // 指定曜日

            // 順路を整形する（4桁に0埋め→xx-xxの形に）
            $route = str_pad($ary_list_data[$j][1], 4, "0", STR_PAD_LEFT);
            $route = substr($route, 0, 2)."-".substr($route, 2, 2);

            // 表示用データ配列作成
            // $ary_disp_data[巡回区分][週][曜日][契約先情報]
            $ary_disp_data[0][$i][$week_rday][$client_row][0] = $ary_list_data[$j][3];      // 契約先ID
            $ary_disp_data[0][$i][$week_rday][$client_row][1] = $route;                     // 整形済順路
            $ary_disp_data[0][$i][$week_rday][$client_row][2] = htmlspecialchars($ary_list_data[$j][2]);      // 契約先名（略称）

            // 巡回日が同じであれば1を加算し、別の曜日になったら0に戻す
            ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

        }

    }

    /* コース内容取得（月例（日付）） */
    // 取得条件作成
    $sql  = "SELECT ";
    $sql .= "   t_contract.rday, ";             // 指定日
    $sql .= "   t_contract.route, ";            // 順路
    $sql .= "   t_client.client_cname, ";       // 契約先名（略称）
    $sql .= "   t_client.client_id, ";          // 契約先ID
    $sql .= "   t_contract.contract_id ";       // 契約情報ID
    $sql .= "FROM ";
    $sql .= "   t_contract ";
    $sql .= "   INNER JOIN t_con_staff ";
    $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
    $sql .= "       AND t_con_staff.staff_id = $staff_id ";
    $sql .= "   INNER JOIN t_client ";
    $sql .= "       ON t_contract.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_contract.round_div = '2' ";
    $sql .= $where_sql;
    $sql .= "ORDER BY ";
    $sql .= "   t_contract.rday, ";
    $sql .= "   t_contract.route, ";
    $sql .= "   t_client.client_id ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $ary_list_data = null;
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // 1日の内の契約先番号
    $client_row = 0;

    // コース内容一覧作成
    for ($i=0; $i<$total_count; $i++){

        // 配列key作成
        // 指定日が（月曜スタートで）何週目にあたるか算出（指定日が30なら4）
        $week_num   = ($ary_list_data[$i][0] != "30") ? bcdiv(($ary_list_data[$i][0]-1), 7) : 4;
        // 指定日が（月曜スタートで）↑で算出した週の何日目にあたるか算出（指定日が30なら0）
        $day_num    = ($ary_list_data[$i][0] != "30") ? ($ary_list_data[$i][0]-1) - ($week_num*7) : 0;

        // 順路を整形する（4桁に0埋め→xx-xxの形に）
        $route = str_pad($ary_list_data[$j][1], 4, "0", STR_PAD_LEFT);
        $route = substr($route, 0, 2)."-".substr($route, 2, 2);

        // 表示用データ配列作成
        // $ary_disp_data[巡回区分][週（月曜スタートとした場合の）][その週の何日目か][契約先情報]
        $ary_disp_data[1][$week_num][$day_num][$client_row][0] = $ary_list_data[$i][3];     // 契約先ID
        $ary_disp_data[1][$week_num][$day_num][$client_row][1] = $route;                    // 整形済順路
        $ary_disp_data[1][$week_num][$day_num][$client_row][2] = htmlspecialchars($ary_list_data[$i][2]);     // 契約先名（略称）

        // 指定日が同じであれば1を加算し、別の日になったら0に戻す
        ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

    }

    /* コース内容取得（月例（曜日）） */
    // 取得条件作成
    $sql  = "SELECT ";
    $sql .= "   t_contract.cale_week, ";    // 週名(1234)
    $sql .= "   t_contract.week_rday, ";    // 指定曜日
    $sql .= "   t_contract.route, ";        // 順路
    $sql .= "   t_client.client_cname, ";   // 契約先名（略称）
    $sql .= "   t_client.client_id, ";      // 契約先ID
    $sql .= "   t_contract.contract_id ";   // 契約情報ID
    $sql .= "FROM t_contract ";
    $sql .= "   INNER JOIN t_con_staff ";
    $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
    $sql .= "       AND t_con_staff.staff_id = $staff_id ";
    $sql .= "   INNER JOIN t_client ";
    $sql .= "       ON t_contract.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_contract.round_div = '3' ";
    $sql .= "ORDER BY ";
    $sql .= "   t_contract.cale_week, ";
    $sql .= "   t_contract.week_rday, ";
    $sql .= "   t_contract.route, ";
    $sql .= "   t_client.client_id ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $ary_list_data = null;
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // 1日の内の契約先番号
    $client_row = 0;

    // コース内容一覧作成
    for ($i=0; $i<$total_count; $i++){

        // 配列key作成
        $cale_week  = $ary_list_data[$i][0]-1;      // 週名(1234)
        $week_rday  = $ary_list_data[$i][1]-1;      // 指定曜日

        // 順路を整形する（4桁に0埋め→xx-xxの形に）
        $route = str_pad($ary_list_data[$j][2], 4, "0", STR_PAD_LEFT);
        $route = substr($route, 0, 2)."-".substr($route, 2, 2);

        // 表示用データ配列作成
        // $ary_disp_data[巡回区分][週（月曜スタートとした場合の）][その週の何日目か][契約先情報]
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][0] = $ary_list_data[$i][4];     // 契約先ID
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][1] = $route;                    // 整形済順路
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][2] = htmlspecialchars($ary_list_data[$i][3]);     // 契約先名（略称）

        // 指定日が同じであれば1を加算し、別の日になったら0に戻す
        ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

        // 同じ週の中で、指定曜日が変われば契約先番号を0に戻す
        //               指定曜日が同じであれば契約先番号に1を加算する
        if ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]){
            ($ary_list_data[$j][1] != $ary_list_data[$j+1][0]) ? $client_row = 0 : $client_row++;
        // 週が変われば問答無用で契約先番号を0に戻す
        }else{
            $client_row = 0;
        }

    }

    // 月曜スタート→日曜スタートに仕変されたので配列の中身を入れ替え
    for ($i=0; $i<count($ary_disp_data[0]); $i++){
        $ary_0[$i][0] = $ary_disp_data[0][$i][6];
        $ary_0[$i][1] = $ary_disp_data[0][$i][0];
        $ary_0[$i][2] = $ary_disp_data[0][$i][1];
        $ary_0[$i][3] = $ary_disp_data[0][$i][2];
        $ary_0[$i][4] = $ary_disp_data[0][$i][3];
        $ary_0[$i][5] = $ary_disp_data[0][$i][4];
        $ary_0[$i][6] = $ary_disp_data[0][$i][5];
    }
    $ary_disp_data[0] = $ary_0; 
    for ($i=0; $i<count($ary_disp_data[2]); $i++){
        $ary_1[$i][0] = $ary_disp_data[2][$i][6];
        $ary_1[$i][1] = $ary_disp_data[2][$i][0];
        $ary_1[$i][2] = $ary_disp_data[2][$i][1];
        $ary_1[$i][3] = $ary_disp_data[2][$i][2];
        $ary_1[$i][4] = $ary_disp_data[2][$i][3];
        $ary_1[$i][5] = $ary_disp_data[2][$i][4];
        $ary_1[$i][6] = $ary_disp_data[2][$i][5];
    }
    $ary_disp_data[2] = $ary_1; 

}


/*----------------------------------------------------------
    画面出力メッセージ作成
----------------------------------------------------------*/
// 巡回担当者が指定されていない場合のメッセージ
$staff_select_msg = ($get_staff_id == null && $post_staff_id == null) ? "※巡回担当者を選択して下さい。" : null;


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
$page_menu = Create_Menu_f("system", "1");

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var", array(
	"html_header" => "$html_header",
	"page_menu"   => "$page_menu",
	"page_header" => "$page_header",
	"html_footer" => "$html_footer",
	"total_count" => "$total_count",
    'auth_r_msg'  => "$auth_r_msg",
    "staff_select_msg"  => $staff_select_msg,
    "submit_state"      => "$submit_state",
    "form_err_flg"      => "$form_err_flg",
    "err_msg1"          => "$err_msg1",
    "touroku_ok_flg"    => "$touroku_ok_flg",
));
$smarty->assign("ary_disp_data", $ary_disp_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
