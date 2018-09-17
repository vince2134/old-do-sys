<?php

// メニュー画面一覧(本部)
function Create_Menu_h($head_menu, $select_menu){
}


// メニュー画面一覧(FC)
function Create_Menu_f($fc_menu, $select_menu){
}


// 値を基にメニュー作成
function Create_Menu($menu, $select_menu, $menu_disp, $where_menu, $menu_color){

    // 連想配列の添え字取得
    $data_menu = array_keys($menu_disp);

    // TOPページの識別
    if ($where_menu == "head"){
        $top_page = TOP_PAGE_H; // TOP（本部）
    }else{
        $top_page = TOP_PAGE_F; // TOP（FC）
    }

    $table_m = null;

    $table_m .= "<table border=\"0\">\n";
    $table_m .= "    <tr>\n";
    $table_m .= "        <td>\n";
    $table_m .= "            <table width=\"158px\" class=\"Menu_Table\">\n";
    $table_m .= "                <tr>\n";
    $table_m .= "                    <td align=\"left\">\n";
    $table_m .= "                        <a href=\"$top_page\" class=\"MyMenu2\" tabindex=\"-1\"><div class=\"backcolor\">メインメニュー</div></a>\n";
    $table_m .= "                    </td>\n";
    $table_m .= "                </tr>\n";

    $i = 1;

    // メニュー存在チェック用にコピー
    $menu_disp2 = $menu_disp;

    // メニュー存在チェックフラグ
    $find_flg = false;

    while ($main_menu = each($menu_disp)){

        // メインメニュー名称
        // $main_menu[0]
        $table_m .= "                <tr>\n";
        $table_m .= "                    <td class=\"Sub_Menu\" valign=\"middle\">\n";
        $table_m .= "                        <table border=\"0\" id=\"$main_menu[0]\" width=\"100%\">\n";
        $table_m .= "                            <tr>\n";
        $table_m .= "                                <td>\n";
        $table_m .= "                                    <div class=\"Menu\">\n";
        // マスタ管理の場合だけbottomマージンが違う為、クラスを分けている
        if($main_menu[0] == "マスタ管理"){
            $table_m .= "                                    <div class=\"Main_Menu_M\"><font size=\"+0.5\" color=\"#555555\"><b>$main_menu[0]</b></font></div>\n";
        }else{
            $table_m .= "                                    <div class=\"Main_Menu\"><font size=\"+0.5\" color=\"#555555\"><b>$main_menu[0]</b></font></div>\n";
        }
        $j = 0;

        // $sub_menu[0]　URL
        // $sub_menu[1]　画面名称
        while ($sub_menu = each($main_menu[1])){
            // 現在の画面がメニュー項目に存在するか
            while ($m_menu = each($menu_disp2)){
                while ($s_menu = each($m_menu[1])){
                    if (basename($_SERVER["PHP_SELF"]) == basename($s_menu[0])){
                        // メニューに存在した
                        $find_flg = true;
                        // メニューにない場合のみ値を保持
                        $_SESSION["display"] = null;
                        break;
                    }
                }
            }

            // 現在表示させているメニューは色を変える(CSSを変更) 
            // メニューに存在しない画面なら、遷移前の画面に色を付ける

            // GET情報が付加されている場合がある為、?で分割しURL取得
            $referer_flg    = "false";
            $referer_name   = explode("?", $_SERVER["HTTP_REFERER"]);
            // GET情報の場合は、$_SESSION[display]に分割したURLを代入
            if (count($referer_name) != 0){
                $referer_flg = "true";
            }

            if ((basename($_SERVER["PHP_SELF"]) == basename($sub_menu[0])) ||
                ($find_flg == false && basename($_SERVER["HTTP_REFERER"]) == basename($sub_menu[0])) ||
                ($find_flg == false && basename($referer_name[0]) == basename($sub_menu[0]))
            ){
                $css_class = "MyMenu";
                // メニューにない場合は、遷移前の画面をセッションに保持する
                if ($find_flg == false){
                    if ($referer_flg == "true"){
                        $_SESSION["display"] = basename($referer_name[0]);
                    }else{
                        $_SESSION["display"] = basename($_SERVER["HTTP_REFERER"]);
                    }
                }
            }else{
                // リファラーの画面がメニューに無い場合は、セッションの画面に色を付ける
                if ($_SESSION["display"] == basename($sub_menu[0])){
                    $css_class = "MyMenu";
                }else{
                    $css_class = "MyMenu2";
                }
            }

            // 共通項目名
            if ($sub_menu[1][1] == "form3"){
                $table_m .= "                                        <div class=\"M_Menu\">\n";
                $table_m .= "                                            <a class=\"M_Menu\" tabindex=\"-1\">".$sub_menu[1][0]."</a>\n";
                $table_m .= "                                        </div>\n";
                $table_m .= "                                        <br>\n";
            // 一つの画面名
            }else
            if ($sub_menu[1][1] == "form1"){
                if ($css_class == "MyMenu"){
                    $css_class2 = "MyMenu";
                }else{
                    $css_class2 = "M_Menu";
                }
                $table_m .= "                                        <div class=\"$css_class\">\n";
                $table_m .= "                                            <a href=\"$sub_menu[0]\" class=\"$css_class2\" tabindex=\"-1\">".$sub_menu[1][0]."</a>\n";
                $table_m .= "                                        </div>\n";
                $table_m .= "                                        <br>\n";
            }
            // 形式比較変数
            $_SESSION["form"] = $sub_menu[1][1];
            // メニュー比較変数
            $_SESSION["main"] = $main_menu[0];
            $j++;

        }

        $table_m .= "                                    </div>\n";
        $table_m .= "                                </td>\n";
        $table_m .= "                            </tr>\n";
        $table_m .= "                        </table>\n";
        $table_m .= "                    </td>\n";
        $table_m .= "                </tr>\n";
        $table_m .= "                <tr>\n";
        $table_m .= "                    <td height=\"10\">\n";
        $table_m .= "                    </td>\n";
        $table_m .= "                </tr>\n";
        $i++;

    }

    // LOGOUT
    $logout_page = LOGOUT_PAGE;

    $table_m .= "            </td>\n";
    $table_m .= "        </tr>\n";
    $table_m .= "        <tr>\n";
    $table_m .= "            <td align=\"left\">\n";
    $table_m .= "                <a href=\"$logout_page\" class=\"MyMenu2\" tabindex=\"-1\"><div class=\"backcolor2\">　　　　 ログアウト</div></a>\n";
    $table_m .= "                            </td>\n";
    $table_m .= "                        </tr>\n";
    $table_m .= "                    </td>\n";
    $table_m .= "                </tr>\n";
    $table_m .= "            </table>\n";
    $table_m .= "        </td>\n";
    $table_m .= "    </tr>\n";
    $table_m .= "</table>\n";

    return $table_m;
}


/**
 *
 * 画面上のヘッダ部分・メニューを作成する
 *
 * @param       string      $title       ページタイトル
 *
 * @return      bool        $table_h     生成されたHTML
 *
 * @author      
 * @version     1.0.0 (2006/04/18)
 *
 */

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2010/09/04                  aoyama-n    メニュー構成を変更
 *  2010/09/04                  aoyama-n    「システム設定」を「残高初期設定」に変更
*/
function Create_Header($title){

    // PATHの文字数を取得
    $count_path = mb_strwidth(PATH);
    // 定数HEAD_PAGEからPATHを抜いた部分を取得
    $head = mb_substr(HEAD_DIR, $count_path);
    // 現在のURLに定数HEAD_PAGEからPATHを抜いた部分が含まれているか
    $which = strstr($_SERVER["PHP_SELF"], $head);

    //上記はコメントアウト
    $which = ($_SESSION["group_kind"] != '1')? false:true; 

    // ライン
    $background = IMAGE_DIR."line.png";
    $head_img = "<img src=\"../../../image/head_img.png\">";
    $db_con = Db_Connect();


    /*** 使用可能なスタッフか調べる ***/
    $sql = "SELECT staff_id FROM t_staff WHERE staff_id = ".$_SESSION["staff_id"]." AND state = '在職中';";
    $res = Db_Query($db_con, $sql);
    // 存在しないスタッフの場合
    if (pg_num_rows($res) == 0){
        // セッションを破棄する
        session_start();
        session_unset();
        session_destroy();
        // ログイン画面へ遷移
        header("Location: ../top.php");
        exit;
    }

    /*** 権限を取得する ***/
    // モジュール番号取得、カラム名作成
    $page_name   = substr($_SERVER["PHP_SELF"], strrpos($_SERVER["PHP_SELF"], "/")+1);
    $module_name = substr($page_name, 0,  strpos($page_name, "."));
    $column_name = str_replace("-", "_", substr_replace($module_name, substr($module_name, 0, 1) == "1" ? "h" : "f", 0, 1));

    // 権限チェック一覧を取得し、配列へ代入
    $permit_col  = Permit_Col("head");
    foreach ($permit_col as $key_hf => $value_hf){
        foreach ($value_hf as $key_1 => $value_1){
            foreach ($value_1 as $key_2 => $value_2){
                foreach ($value_2 as $key_3 => $value_3){
                    foreach ($value_3 as $key_4 => $value_4){
                        $ary_column_name[] = $value_4;
                    }       
                }
            }
        }
    }

    // 権限チェックモジュール一覧に載ってるモジュールは権限チェックを行う
    if (in_array($column_name, $ary_column_name)){
        $auth       = Auth_Check($db_con);
        $auth_msg   = ($auth[3] != null) ? $auth[3] : null;
    }

    // 本部の場合
    if ($which != false){

        // 売上管理
        $menu_path = PATH."src/head/sale";
        $set_menu[0] = array (
            "menu" => "売上管理",
            "1" => "受注取引",
            "$menu_path/1-2-102.php" => "オンライン受注",
            "$menu_path/1-2-101.php" => "受注入力",
            "$menu_path/1-2-105.php" => "受注照会",
            "$menu_path/1-2-106.php" => "受注残一覧",
            "$menu_path/1-2-130.php" => "レンタルTOレンタル",
            "2" => "売上取引",
            "$menu_path/1-2-201.php" => "売上入力",
            "$menu_path/1-2-203.php" => "売上（割賦）照会",
            "$menu_path/1-2-209.php" => "納品書メモ設定",
            //"$menu_path/1-2-202.php" => "売上伝票一括発行",
            "3" => "請求管理",
            "$menu_path/1-2-301.php" => "請求データ作成照会",
            "4" => "入金管理",
            "$menu_path/1-2-402.php" => "入金入力",
            "$menu_path/1-2-403.php" => "入金照会",
            "5" => "実績管理",
            "$menu_path/1-2-501.php" => "売掛残高一覧",
            "$menu_path/1-2-503.php" => "取引先元帳",
        );

        // 仕入管理
        $menu_path = PATH."src/head/buy";
        $set_menu[1] = array (
            "menu" => "仕入管理",
            "1" => "発注取引",
            "$menu_path/1-3-101.php" => "発注点警告リスト",
            "$menu_path/1-3-102.php" => "発注入力",
            "$menu_path/1-3-104.php" => "発注照会",
            "$menu_path/1-3-106.php" => "発注残一覧",
            "2" => "仕入取引",
            "$menu_path/1-3-207.php" =>"仕入入力",
            "$menu_path/1-3-202.php" =>"仕入照会",
            "3" => "支払管理",
            "$menu_path/1-3-307.php" => "仕入締処理",
            "$menu_path/1-3-302.php" => "支払入力",
            "$menu_path/1-3-303.php" => "支払照会",
            "4" => "実績管理",
            "$menu_path/1-3-401.php" => "買掛残高一覧",
            "$menu_path/1-3-403.php" => "仕入先元帳",
        );

        // 在庫管理
        $menu_path = PATH."src/head/stock";
        $set_menu[2] = array (
            "menu" => "在庫管理",
            "1" => "在庫取引",
            "$menu_path/1-4-101.php" => "在庫照会／受払",
            "$menu_path/1-4-107.php" => "在庫移動",
            "$menu_path/1-4-109.php" => "商品組立",
            "$menu_path/1-4-104.php" => "商品グループ設定",
            "2" => "棚卸管理",
            "$menu_path/1-4-201.php" => "棚卸調査表",
            "$menu_path/1-4-108.php" => "在庫調整入力",
        );

        // 更新
        $menu_path = PATH."src/head/renew";
        $set_menu[3] = array (
            "menu" => "更　　新",
            "1" => "更新管理",
            "$menu_path/1-5-105.php" => "バッチ表",
            "$menu_path/1-5-107.php" => "オペレータ入力情報",
            "$menu_path/1-5-101.php" => "日次更新履歴",
            "$menu_path/1-5-104.php" => "棚卸更新処理",
            "$menu_path/1-5-102.php" => "月次更新処理",
        );

        // データ出力
//        $menu_path = PATH."src/head/analysis";
        $menu_path = PATH."src/analysis/head";
        $set_menu[4] = array (
            "menu" => "データ出力",
            "1" => "統計情報",
            "$menu_path/1-6-132.php" => "売上成績",
            //"$menu_path/1-6-131.php" => "契約成績",
            //"$menu_path/1-6-135.php" => "商品別契約成績",
            //"$menu_path/1-6-133.php" => "得意先別契約成績",
            //"$menu_path/1-6-143.php" => "売上金額一覧",
            "2" => "売上推移",
            "$menu_path/1-6-103.php" => "ＦＣ別",
            //"$menu_path/1-6-100.php" => "サービス別",
            "$menu_path/1-6-101.php" => "商品別",
            "$menu_path/1-6-108.php" => "担当者別商品別",
            //"$menu_path/1-6-105.php" => "地区別商品別",
            "$menu_path/1-6-106.php" => "業種別ＦＣ別",
            "$menu_path/1-6-107.php" => "業種別商品別",
            "3" => "ABC分析",
            "$menu_path/1-6-112.php" => "FC別",
            "$menu_path/1-6-110.php" => "商品別",
            "$menu_path/1-6-111.php" => "FC別商品別",
            "$menu_path/1-6-113.php" => "業種別",
            "$menu_path/1-6-114.php" => "担当者別",
            "4" => "仕入推移",
            "$menu_path/1-6-122.php" => "仕入先別",
            "$menu_path/1-6-121.php" => "仕入先別商品別",
            "5" => "CSV出力",
            "$menu_path/1-6-301.php" => "マスタデータ",
            "$menu_path/1-6-302.php" => "実績データ",
            "$menu_path/1-6-303.php" => "マスタ操作ログ",
        );

        // マスタ・設定
        $menu_path = PATH."src/head/system";
        $set_menu[5] = array (
            "menu" => "マスタ・設定",
            "1" => "本部管理マスタ",
            "$menu_path/1-1-205.php" => "業種",
            "$menu_path/1-1-234.php" => "業態",
            "$menu_path/1-1-233.php" => "施設",
            "$menu_path/1-1-231.php" => "サービス",
            "$menu_path/1-1-230.php" => "構成品",
            "2" => "一部共有マスタ",
            "$menu_path/1-1-211.php" => "Ｍ区分",
            "$menu_path/1-1-209.php" => "管理区分",
            "$menu_path/1-1-235.php" => "商品分類",
            "$menu_path/1-1-220.php" => "商品",
            "3" => "個別マスタ",
            "$menu_path/1-1-203.php" => "倉庫",
            "$menu_path/1-1-201.php" => "部署",
            "$menu_path/1-1-213.php" => "地区",
            "$menu_path/1-1-207.php" => "銀行",
            "$menu_path/1-1-107.php" => "スタッフ",
            "$menu_path/1-1-302.php" => "パスワード変更",
            "$menu_path/1-1-227.php" => "FC・取引先区分",
            "$menu_path/1-1-101.php" => "FC・取引先",
            "$menu_path/1-1-113.php" => "得意先",
            "$menu_path/1-1-219.php" => "直送先",
            "$menu_path/1-1-225.php" => "運送業者",
            "$menu_path/1-1-224.php" => "製造品",
            "4" => "帳票設定",
            "$menu_path/1-1-303.php" => "発注書コメント",
            "$menu_path/1-1-304.php" => "注文書ﾌｫｰﾏｯﾄ設定",
            "$menu_path/1-1-312.php" => "納品書",
            "$menu_path/1-1-310.php" => "請求書",
            "5" => "システム設定",
            "$menu_path/1-1-301.php" => "本部プロフィール",
            "$menu_path/1-1-305.php" => "買掛残高初期設定",
            "$menu_path/1-1-306.php" => "売掛残高初期設定",
            "$menu_path/1-1-307.php" => "請求残高初期設定",
        );

    // 直営・FC時
    }else{
    
        // 売上管理
        $menu_path = PATH."src/franchise/sale";
        $menu_path_system = PATH."src/franchise/system";
        $set_menu[0] = array (
            "menu" => "売上管理",
            "1" => "予定取引",
            "$menu_path/2-2-101-2.php" => "巡回カレンダー",
            "$menu_path/2-2-113.php" => "集計日報／伝票発行",
            "$menu_path/2-2-118.php" => "予定手書伝票発行",
            "$menu_path/2-2-206.php" => "予定伝票売上確定",
            "$menu_path/2-2-209.php" => "削除伝票一覧",
            "2" => "売上取引",
            "$menu_path/2-2-201.php" => "手書伝票発行",
            "$menu_path/2-2-207.php" => "売上確定一覧",
            "$menu_path/2-2-210.php" => "売上伝票(備考)設定",
            "3" => "請求管理",
            "$menu_path/2-2-301.php" => "請求データ作成照会",
            "4" => "入金管理",
            "$menu_path/2-2-402.php" => "入金入力",
            "$menu_path/2-2-403.php" => "入金照会",
            "$menu_path/2-2-411.php" => "前受金入力",
            "$menu_path/2-2-412.php" => "前受金照会",
            "$menu_path/2-2-414.php" => "前受金残高一覧",
            "$menu_path/2-2-415.php" => "前受金受払一覧",
            "5" => "実績管理",
            "$menu_path/2-2-501.php" => "売掛残高一覧",
            "$menu_path/2-2-503.php" => "得意先元帳",
        );

        // 仕入管理
        $menu_path = PATH."src/franchise/buy";
        $menu_path_system = PATH."src/franchise/system";
        $set_menu[1] = array (
            "menu" => "仕入管理",
            "1" => "発注取引",
            "$menu_path/2-3-101.php" => "発注点警告リスト",
            "$menu_path/2-3-102.php" => "発注入力",
            "$menu_path/2-3-104.php" => "発注照会",
            "$menu_path/2-3-106.php" => "発注残一覧",
            "$menu_path_system/2-1-142.php" => "レンタルTOレンタル",
            "2" => "仕入取引",
            "$menu_path/2-3-201.php" =>"仕入入力",
            "$menu_path/2-3-202.php" =>"仕入照会",
            "3" => "支払管理",
            "$menu_path/2-3-307.php" => "仕入締処理",
            "$menu_path/2-3-302.php" => "支払入力",
            "$menu_path/2-3-303.php" => "支払照会",
            "4" => "実績管理",
            "$menu_path/2-3-401.php" => "買掛残高一覧",
            "$menu_path/2-3-403.php" => "仕入先元帳",
        );

        // 在庫管理
        $menu_path = PATH."src/franchise/stock";
        $set_menu[2] = array (
            "menu" => "在庫管理",
            "1" => "在庫取引",
            "$menu_path/2-4-101.php" => "在庫照会／受払",
            "$menu_path/2-4-107.php" => "在庫移動",
            "2" => "棚卸管理",
            "$menu_path/2-4-201.php" => "棚卸調査表",
            "$menu_path/2-4-108.php" => "在庫調整入力",
        );

        // 更新
        $menu_path = PATH."src/franchise/renew";
        $set_menu[3] = array (
            "menu" => "更　　新",
            "1" => "更新管理",
            "$menu_path/2-5-105.php" => "バッチ表",
            "$menu_path/2-5-107.php" => "オペレータ入力情報",
            "$menu_path/2-5-101.php" => "日次更新履歴",
            "$menu_path/2-5-104.php" => "棚卸更新処理",
            "$menu_path/2-5-102.php" => "月次更新処理",
        );

        // データ出力
//        $menu_path = PATH."src/franchise/analysis";
        $menu_path = PATH."src/analysis/franchise";
        $set_menu[4] = array (
            "menu" => "データ出力",
            "1" => "統計情報",
            "$menu_path/2-6-132.php" => "売上成績",
            //"$menu_path/2-6-131.php" => "契約成績",
            //"$menu_path/2-6-137.php" => "商品別契約成績",
            //"$menu_path/2-6-135.php" => "得意先別契約成績",
            //"$menu_path/2-6-151.php" => "ルート予定表",
            //"$menu_path/2-6-153.php" => "変則日顧客一覧",
            "2" => "売上推移",
            "$menu_path/2-6-103.php" => "得意先別",
            "$menu_path/2-6-100.php" => "サービス別",
            //"$menu_path/2-6-101.php" => "商品別",
            "$menu_path/2-6-108.php" => "担当者別商品別",
            //"$menu_path/2-6-104.php" => "地区別得意先別",
            "$menu_path/2-6-106.php" => "業種別得意先別",
            "3" => "ABC分析",
            "$menu_path/2-6-112.php" => "得意先別",
            "$menu_path/2-6-110.php" => "商品別",
            "$menu_path/2-6-114.php" => "担当者別",
            "4" => "仕入推移",
            "$menu_path/2-6-122.php" => "仕入先別",
            "$menu_path/2-6-121.php" => "仕入先別商品別",
            "5" => "CSV出力",
            "$menu_path/2-6-201.php" => "マスタデータ",
            "$menu_path/2-6-202.php" => "実績データ",
            "$menu_path/2-6-203.php" => "マスタ操作ログ",
        );

        // マスタ・設定
        $menu_path = PATH."src/franchise/system";
        // 直営時
        if ($_SESSION["group_kind"] == "2"){
            #2010-09-04 aoyama-n
            #メニュー構成変更
            $set_menu[5] = array (
                "menu" => "マスタ・設定",
                "1" => "個別マスタ",
                "$menu_path/2-1-301.php" => "自社プロフィール",
                "$menu_path/2-1-350.php" => "休日設定",
                "$menu_path/2-1-203.php" => "倉庫",
                "$menu_path/2-1-200.php" => "本支店",
                "$menu_path/2-1-201.php" => "部署",
                "$menu_path/2-1-213.php" => "地区",
                "$menu_path/2-1-207.php" => "銀行",
                "$menu_path/2-1-107.php" => "スタッフ",
                "$menu_path/2-1-302.php" => "パスワード変更",
                "$menu_path/2-1-219.php" => "直送先",
                "$menu_path/2-1-225.php" => "運送業者",
                "$menu_path/2-1-215.php" => "仕入先",
                "$menu_path/2-1-113.php" => "グループ",
                #2010-04-06 hashimoto-y
                #"$menu_path/2-1-103.php" => "得意先",
                "$menu_path/2-1-101.php" => "得意先",
                "$menu_path/2-1-111.php" => "契約",
                "2" => "一部共有マスタ",
                "$menu_path/2-1-211.php" => "Ｍ区分",
                "$menu_path/2-1-209.php" => "管理区分",
                "$menu_path/2-1-241.php" => "商品分類",
                "$menu_path/2-1-220.php" => "商品",
                "3" => "帳票設定",
                "$menu_path/2-1-303.php" => "発注書コメント",
                "$menu_path/2-1-308.php" => "売上伝票",
                "$menu_path/2-1-307.php" => "請求書",
                "4" => "残高初期設定",
                "$menu_path/2-1-304.php" => "買掛残高初期設定",
                "$menu_path/2-1-305.php" => "売掛残高初期設定",
                "$menu_path/2-1-306.php" => "請求残高初期設定",
                "5" => "本部管理マスタ",
                "$menu_path/2-1-231.php" => "業種",
                "$menu_path/2-1-234.php" => "業態",
                "$menu_path/2-1-233.php" => "施設",
                "$menu_path/2-1-232.php" => "サービス",
                "$menu_path/2-1-229.php" => "構成品",
            );
        // FC時
        }else{
            #2010-09-04 aoyama-n
            #メニュー構成変更
            $set_menu[5] = array (
                "menu" => "マスタ・設定",
                "1" => "個別マスタ",
                "$menu_path/2-1-301.php" => "自社プロフィール",
                "$menu_path/2-1-350.php" => "休日設定",
                "$menu_path/2-1-203.php" => "倉庫",
                "$menu_path/2-1-200.php" => "本支店",
                "$menu_path/2-1-201.php" => "部署",
                "$menu_path/2-1-213.php" => "地区",
                "$menu_path/2-1-207.php" => "銀行",
                "$menu_path/2-1-107.php" => "スタッフ",
                "$menu_path/2-1-302.php" => "パスワード変更",
                "$menu_path/2-1-219.php" => "直送先",
                "$menu_path/2-1-225.php" => "運送業者",
                "$menu_path/2-1-239.php" => "代行依頼",
                "$menu_path/2-1-215.php" => "仕入先",
                "$menu_path/2-1-113.php" => "グループ",
                #2010-04-06 hashimoto-y
                #"$menu_path/2-1-103.php" => "得意先",
                "$menu_path/2-1-101.php" => "得意先",
                "$menu_path/2-1-111.php" => "契約",
                "2" => "一部共有マスタ",
                "$menu_path/2-1-211.php" => "Ｍ区分",
                "$menu_path/2-1-209.php" => "管理区分",
                "$menu_path/2-1-241.php" => "商品分類",
                "$menu_path/2-1-220.php" => "商品",
                "3" => "帳票設定",
                "$menu_path/2-1-303.php" => "発注書コメント",
                "$menu_path/2-1-308.php" => "売上伝票",
                "$menu_path/2-1-307.php" => "請求書",
                "4" => "残高残高設定",
                "$menu_path/2-1-304.php" => "買掛残高初期設定",
                "$menu_path/2-1-305.php" => "売掛残高初期設定",
                "$menu_path/2-1-306.php" => "請求残高初期設定",
                "5" => "本部管理マスタ",
                "$menu_path/2-1-231.php" => "業種",
                "$menu_path/2-1-234.php" => "業態",
                "$menu_path/2-1-233.php" => "施設",
                "$menu_path/2-1-232.php" => "サービス",
                "$menu_path/2-1-229.php" => "構成品",
            );
        }

    }

    // 売上管理プルダウン作成
    $set_name[0] = "form_sale";
    $set_arr[0]  = Make_Slct_Html($set_name[0]);
    // 仕入プルダウン作成
    $set_name[1] = "form_buy";
    $set_arr[1]  = Make_Slct_Html($set_name[1]);
    // 在庫プルダウン作成
    $set_name[2] = "form_stock";
    $set_arr[2]  = Make_Slct_Html($set_name[2]);
    // 更新プルダウン作成
    $set_name[3] = "form_renew";
    $set_arr[3]  = Make_Slct_Html($set_name[3]);
    // 統計プルダウン作成
    $set_name[4] = "form_analy";
    $set_arr[4]  = Make_Slct_Html($set_name[5]);
    // マスタ・設定プルダウン作成
    $set_name[5] = "form_system";
    $set_arr[5]  = Make_Slct_Html($set_name[4]);

    //現在の画面がどのディレクトリなのか判定する配列
    $menu_name[0] = "sale";
    $menu_name[1] = "buy";
    $menu_name[2] = "stock";
    $menu_name[3] = "renew";
    $menu_name[4] = "analysis";
    $menu_name[5] = "system";

    $staff_name   = htmlspecialchars($_SESSION["staff_name"]);
    $shop_name    = htmlspecialchars($_SESSION["h_shop_name"]);
    $fc_shop_name = htmlspecialchars($_SESSION["fc_client_name"]);

    $count = count($set_menu);
    for ($x = 0; $x < $count; $x++){
        $num = 1;
        while ($main_menu = each($set_menu[$x])){
            // 各グループ名の場合
            if ($main_menu[0] == $num){
                $set_arr[$x] .= "    <OPTGROUP LABEL=\"■$main_menu[1]\" style=\"background-color:#828180; color:#FEFEFE; font-weight:lighter;\">\n";
            }else
            // メニュー名の場合
            if($main_menu[0] == "menu"){
                // 現在の画面のメニューは色を変更する
                if (ereg($menu_name[$x], $_SERVER["PHP_SELF"])){
                    // 現在のメニュー
                    $set_arr[$x] .= "    <option value=\"$main_menu[0]\" style='background-color:#FDFD66;'>$main_menu[1]</option>\n";
                }else{
                    // その他のメニュー
                    $set_arr[$x] .= "    <option value=\"$main_menu[0]\" style='background-color:#EEEEEE;'>$main_menu[1]</option>\n";
                }
            }else{
            // 各<option>の場合
                $set_arr[$x] .= "    <option value=\"$main_menu[0]\">$main_menu[1]</option>\n";
            }
            // グループの値が無くなった場合は、グループを閉じる
            if ($main_menu[0] == $num){
                $set_arr[$x] .= "    </OPTGROUP>\n";
                $num++;
            }
        }
        $set_arr[$x] .= "</select>\n";
    }

    // 本部時
    if ($which != false){

        $table_h  = null;
        $table_h .= "    <table align=\"left\">\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // プルダウンメニュー
        $table_h .= "                <table width=\"100%\" bgcolor=\"#213B82\">\n";
        $table_h .= "                    <tr valign=\"middle\">\n";
        $ary_label = array("sale_label", "buy_label", "stock_label", "update_label", "data_label", "setup_label");
        foreach ($ary_label as $key => $label){
        $table_h .= "                        <td>\n";
        $table_h .= "                            <div style=\"position: relative;\">\n";
        $table_h .= "                            <img src=\"".IMAGE_DIR.$label.".gif\" border=\"0\" width=\"155px\" height=\"40px\">\n";
        $table_h .= "                            <div style=\"position: absolute; top:10px; left:10px;\">\n";
        $table_h .= "                            <font color=\"#6981E9\">".$set_arr[$key]."</font>\n";
        $table_h .= "                            </div>\n";
        $table_h .= "                            </div>\n";
        $table_h .= "                        </td>\n";
        }
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";
            
        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // ページ名
        $table_h .= "                <table width=\"100%\" style=\"margin-top: 0px; margin-bottom: 0px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"180px\"><font color=\"#555555\"><b>$shop_name</b></font></td>\n";
        $table_h .= "                        <td align=\"center\">$head_img&nbsp;\n";
        $table_h .= "                            <font style=\"font-size: 11pt; font-weight: bold; color:#555555;\">$title</font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"180px\">\n";
        $table_h .= "                            <a href=\"".TOP_PAGE_H."\"><img src=\"".IMAGE_DIR."main_menu.gif\" border=\"0\"></a>　\n";
        $table_h .= "                            <a href=\"".LOGOUT_PAGE."\"><img src=\"".IMAGE_DIR."logout.gif\" border=\"0\"></a>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                     </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // hr
        $table_h .= "                <table width=\"100%\" background=\"$background\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // スタッフ名
        $table_h .= "                <table width=\"100%\" style=\"margin-top: -5px;margin-bottom: -4px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"35%\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$staff_name</font>　<font color=\"ff0000\">$auth_msg</font></b>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"35%\">\n";
        $table_h .= "                            <input type=\"button\" value=\"別ウィンドウを開く\" onClick=\"window.open('".TOP_PAGE_H."');\">\n";


		#2008-06-19 パス変更により変更 watanabe-k
#        $table_h .= "                            <input type=\"button\" value=\"別ウィンドウを開く\" onClick=\"window.open('".PATH."src/window.php');\">\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "    </table>\n";

    // 直営時
    }else{

        $table_h  = null;

        $table_h .= "    <table align=\"left\">\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // プルダウンメニュー
        $table_h .= "            <table width=\"100%\">\n";
        $table_h .= "                <tr valign=\"middle\">\n";
        $ary_label = array("sale_label", "buy_label", "stock_label", "update_label", "data_label", "setup_label");
        foreach ($ary_label as $key => $label){
        $table_h .= "                    <td>\n";
        $table_h .= "                        <div style=\"position: relative;\">\n";
        $table_h .= "                        <img src=\"".IMAGE_DIR.$label."_fc.gif\" border=\"0\" width=\"155px\" height=\"40px\">\n";
        $table_h .= "                        <div style=\"position: absolute; top:10px; left:10px;\">\n";
        $table_h .= "                        <font color=\"#6981E9\">".$set_arr[$key]."</font>\n";
        $table_h .= "                        </div>\n";
        $table_h .= "                        </div>\n";
        $table_h .= "                    </td>\n";      
        }
        $table_h .= "                </tr>\n";
        $table_h .= "            </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // ページ名
        $table_h .= "                <table width=\"100%\" style=\"margin-top: 0px; margin-bottom: 0px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"180px\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$fc_shop_name</b></font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"center\">\n";
        $table_h .= "                            <font style=\"font-size: 11pt; font-weight: bold; color:#555555\">$title</font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"180px\">\n";
        $table_h .= "                            <a href=\"".TOP_PAGE_F."\"><img src=\"".IMAGE_DIR."main_menu.gif\" border=\"0\"></a>　\n";
        $table_h .= "                            <a href=\"".LOGOUT_PAGE."\"><img src=\"".IMAGE_DIR."logout.gif\" border=\"0\"></a>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // hr
        $table_h .= "                <table width=\"100%\" background=\"$background\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "        <tr>\n";
        $table_h .= "            <td>\n";

        // スタッフ名
        $table_h .= "                <table width=\"100%\" style=\"margin-top: -5px;margin-bottom: -4px;\">\n";
        $table_h .= "                    <tr>\n";
        $table_h .= "                        <td width=\"35%\">\n";
        $table_h .= "                            <font color=\"#555555\"><b>$staff_name</font>　<font color=\"#ff0000\">$auth_msg</b></font>\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                        <td align=\"right\" width=\"35%\">\n";
        $page_name  = substr($_SERVER["PHP_SELF"], strrpos($_SERVER["PHP_SELF"], "/")+1);
        $module_no  = substr($page_name, 0, strpos($page_name, "."));
        if ($module_no == "2-2-206"){
        $table_h .= "                            <input type=\"button\" value=\"手書伝票発行\" onClick=\"window.open('./2-2-201.php');\">　\n";
        //集計日報
        }elseif ($module_no == "2-2-113"){
        $table_h .= "                            <input type=\"button\" value=\"集計日報プレビュー\" onClick=\"window.open('./2-2-114.php?format=true');\">　\n";
        }
        $table_h .= "                            <input type=\"button\" value=\"別ウィンドウを開く\" onClick=\"window.open('".TOP_PAGE_F."');\">\n";

		#2008-06-19 パス変更により変更 watanabe-k
#        $table_h .= "                            <input type=\"button\" value=\"別ウィンドウを開く\" onClick=\"window.open('".PATH."src/window.php');\">\n";
        $table_h .= "                        </td>\n";
        $table_h .= "                    </tr>\n";
        $table_h .= "                </table>\n";

        $table_h .= "            </td>\n";
        $table_h .= "        </tr>\n";
        $table_h .= "    </table>\n";

    }

    return $table_h;

}


function Make_Slct_Html($name){

    $slct  = "<select class=\"select_title\" ";
    $slct .= "name=\"".$name."_menu\" ";
    $slct .= "style=\"width: 135px;\" ";
    $slct .= "onKeyDown=\"chgKeycode();\" ";
    $slct .= "onChange=\"window.focus(); javascript:Change_Menu(this.form, '".$name."_menu');\">\n";

    return $slct;

}

?>
