<?php
$page_title = "コースマスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
//部品定義
/****************************/
/* ヘッダフォーム */
// 登録画面
$form->addElement("button", "new_button", "登録画面", "onClick=\"javascript:Referer('2-1-228.php')\"");

// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

/* メインフォーム */
// 担当者
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

// 表示
$form->addElement("submit", "show_button", "表　示");

//クリア
$form->addElement("button", "clear_button", "クリア", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");



/****************************/
// ページ読込時の処理
/****************************/
// 全件数を取得
$sql = "SELECT DISTINCT staff_id FROM t_course;";
$res = Db_Query($db_con, $sql);
$total_count =  pg_num_rows($res);


/****************************/
// 一覧表用データ作成
/****************************/
// 表示ボタンが押下された場合
if (isset($_POST["show_button"])){

    // 選択されたスタッフのstaff_idを変数に代入
    $staff_id   = $_POST["form_staff_select"];

    /* 空の連想配列を作成する */
    // スタッフが選択されている場合は1ループのみ
    // されていない場合はt_courseに登録されている全staff_idから重複分を取り除いた件数分ループする
    $sql  = "SELECT DISTINCT staff_id FROM t_course WHERE ";
    $sql .= ($group_kind == "2") ? " t_course.shop_id IN (".Rank_Sql().") " : " t_course.shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = ($staff_id == null) ? pg_num_rows($res) : 1;
    for ($i=0; $i<$num; $i++){
        for ($j=0; $j<3; $j++){
            for ($k=0; $k<3; $k++){
                for ($l=0; $l<5; $l++){
                    for ($m=0; $m<7; $m++){
                        $ary_disp_data[$i][$j][$k][$l][$m] = null;
                    }
                }
            }
        }
    }

    /* 件数表示用データ取得 */
    $staff_count = ($staff_id != null) ? 1 : $num;

    // 一覧表示用絞り込みSQL
    $where_sql  = ($staff_id != null) ? " AND t_staff.staff_id = $staff_id " : null;

    /* 一覧表示用データ取得SQL */
    $sql  = "SELECT ";
    $sql .= "   t_staff.staff_id, ";    // （巡回）スタッフID
    $sql .= "   t_staff.charge_cd, ";   // （巡回）担当者コード
    $sql .= "   t_staff.staff_name, ";  // （巡回）スタッフ名
    $sql .= "   t_course.round_div, ";  // 巡回区分(1:ABCD週, 2:月例（日付）, 3:月例（曜日）)
    $sql .= "   t_course.abcd_week, ";  // 週名（ABCD）
    $sql .= "   t_course.cale_week, ";  // 週名（1〜4）
    $sql .= "   t_course.rday, ";       // 指定日
    $sql .= "   t_course.week_rday, ";  // 指定曜日
    $sql .= "   t_course.course_name "; // コース名
    $sql .= "FROM t_course ";
    $sql .= "   INNER JOIN t_staff ";
    $sql .= "   ON t_course.staff_id = t_staff.staff_id ";
    $sql .= $where_sql;
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
    $count = @pg_num_rows($res);
    for ($i=0; $i<$count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    /* 一覧表示用データ作成 */
    $staff_row = 0;   // 担当者単位の行番号

    // 一覧表示用データ作成
    for ($i=0; $i<$count; $i++){

        // 行色css
        $ary_disp_data[$staff_row][0]       = (bcmod($staff_row, 2) == 0) ? "Result1" : "Result2";

        // スタッフ情報
        $ary_disp_data[$staff_row][1][0]    = $ary_list_data[$i][0]; // スタッフID
        $ary_disp_data[$staff_row][1][1]    = htmlspecialchars($ary_list_data[$i][2]); // スタッフ名

        // 一覧表示用の配列key作成
        $round_div  = $ary_list_data[$i][3]-1;  // 巡回区分
        $abcd_week  = $ary_list_data[$i][4]-1;  // 週名(ABCD)
        $cale_week  = $ary_list_data[$i][5]-1;  // 週名(1-4)
        $week_rday  = $ary_list_data[$i][7]-1;  // 指定曜日

        // 月例（日付）の場合
        if ($ary_list_data[$i][3] == "2"){
            // 指定日が（月曜スタートで）何週目にあたるか算出
            $week_num   = ($ary_list_data[$i][6] != "30") ? bcdiv(($ary_list_data[$i][6]-1), 7) : 4;
            // 指定日が（月曜スタートで）↑で算出した週の何日目にあたるか算出
            $day_num    = ($ary_list_data[$i][6] != "30") ? ($ary_list_data[$i][6]-1) - ($week_num*7) : 0;
        }

        // コース名（ABCD週の場合）
        if ($ary_list_data[$i][3] == "1"){
            $ary_disp_data[$staff_row][2][$round_div][$abcd_week][$week_rday]   = htmlspecialchars($ary_list_data[$i][8]);
        // コース名（月例（日付）の場合）
        }elseif ($ary_list_data[$i][3] == "2"){
            $ary_disp_data[$staff_row][2][$round_div][$week_num][$day_num]      = htmlspecialchars($ary_list_data[$i][8]);
        // コース名（月例（曜日）の場合）
        }elseif ($ary_list_data[$i][3] == "3"){
            $ary_disp_data[$staff_row][2][$round_div][$cale_week][$week_rday]   = htmlspecialchars($ary_list_data[$i][8]);
        }

        // 担当者が変わる時、担当者単位の行番号に1を加算する
        ($ary_list_data[$i][0] != $ary_list_data[$i+1][0]) ? $staff_row++ : null;

    }

    /* 選択されたスタッフのレコードが無い場合 */
    if ($staff_id != null && $count == 0){

        // スタッフ名抽出SQL
        $sql = "SELECT staff_name FROM t_staff WHERE staff_id = $_POST[form_staff_select];";
        $res = Db_Query($db_con, $sql);

        // 何も無いとかわいそうなので空データを作る
        $ary_disp_data[0][0]    = "Result1";                    // 行色css
        $ary_disp_data[0][1][0] = $_POST["form_staff_select"];  // 巡回担当者ID
        $ary_disp_data[0][1][1] = htmlspecialchars(pg_fetch_result($res, 0));     // 巡回担当者名

        // 件数表示用
        $staff_count = 1;

    }

}

// 月曜スタート→日曜スタートに仕変されたので配列の中身を入れ替え
for ($i=0; $i<count($ary_disp_data[0][2][0]); $i++){
    $ary_0[$i][0] = $ary_disp_data[0][2][0][$i][6];
    $ary_0[$i][1] = $ary_disp_data[0][2][0][$i][0];
    $ary_0[$i][2] = $ary_disp_data[0][2][0][$i][1];
    $ary_0[$i][3] = $ary_disp_data[0][2][0][$i][2];
    $ary_0[$i][4] = $ary_disp_data[0][2][0][$i][3];
    $ary_0[$i][5] = $ary_disp_data[0][2][0][$i][4];
    $ary_0[$i][6] = $ary_disp_data[0][2][0][$i][5];
}
$ary_disp_data[0][2][0] = $ary_0;
for ($i=0; $i<count($ary_disp_data[0][2][2]); $i++){
    $ary_1[$i][0] = $ary_disp_data[0][2][2][$i][6];
    $ary_1[$i][1] = $ary_disp_data[0][2][2][$i][0];
    $ary_1[$i][2] = $ary_disp_data[0][2][2][$i][1];
    $ary_1[$i][3] = $ary_disp_data[0][2][2][$i][2];
    $ary_1[$i][4] = $ary_disp_data[0][2][2][$i][3];
    $ary_1[$i][5] = $ary_disp_data[0][2][2][$i][4];
    $ary_1[$i][6] = $ary_disp_data[0][2][2][$i][5];
}
$ary_disp_data[0][2][2] = $ary_1;


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
$page_menu = Create_Menu_f('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

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
    'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
    'comp_msg'      => "$comp_msg",
    'staff_count'   => "$staff_count",
));

$smarty->assign("ary_disp_data", $ary_disp_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
