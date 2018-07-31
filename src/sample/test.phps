<?php

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickForm作成
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

$db_con = Db_Connect();

/*
$large_genre[null] = null;
$large_genre[0] = "和食";
$large_genre[1] = "洋食";

//二層目
$middle_genre[0][1] = "日本料理";
$middle_genre[0][2] = "寿司";
$middle_genre[1][3] = "洋食" ;
$middle_genre[1][4] = "フランス料理";
$middle_genre[1][5] = "イタリア料理";

//三層目
$small_genre[0][1] = array("会席料理", "懐石料理", "割烹", "料亭");
$small_genre[0][2] = array("江戸前寿司", "回転寿司", "ちらし寿司");
$small_genre[1][3] = array("ステーキ", "洋食一般");
$small_genre[1][4] = array("コース料理", "プリフィクス", "アラカルト");
$small_genre[1][5] = array("コース料理", "ピザ", "パスタ");

$obj_genre_select = &$form->addElement("hierselect", "genre", "ジャンル選択", "", "　　");
$obj_genre_select->setOptions(array($large_genre, $middle_genre, $small_genre));
*/

/*
$sql  = "SELECT ";
$sql .= "   t_bank.bank_id, ";
$sql .= "   t_bank.bank_cd, ";
$sql .= "   t_bank.bank_name, ";
$sql .= "   t_b_bank.b_bank_id, ";
$sql .= "   t_b_bank.b_bank_cd, ";
$sql .= "   t_b_bank.b_bank_name, ";
$sql .= "   t_account.account_id, ";
$sql .= "   t_account.account_no ";
$sql .= "FROM ";
$sql .= "   t_bank ";
$sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
$sql .= "   INNER JOIN t_account ON t_b_bank.b_bank_id = t_account.b_bank_id ";
$sql .= "WHERE ";
$sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
$sql .= "ORDER BY ";
$sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
// hierselect用配列定義
$ary_hier1[null] = null;
$ary_hier2       = null;
$ary_hier3       = null;
if ($num > 0){
    for ($i=0; $i<$num; $i++){
        // データ取得（レコード毎）
        $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
        // 分かりやすいように各階層のIDを変数に代入
        $hier1_id = $data_list[$i]["bank_id"];
        $hier2_id = $data_list[$i]["b_bank_id"];
        $hier3_id = $data_list[$i]["account_id"];
        /* 第1階層配列作成処理 */
/*
        // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
            // 第1階層アイテムを配列へ
            $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]."：".$data_list[$i]["bank_name"];
        }
        /* 第2階層配列作成処理 */
/*
        // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
        // または、現在参照レコードの支店コードと前に参照したレコードの支店コードが異なる場合
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
            // 第2階層セレクトアイテムの最初にNULLを設定
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                $ary_hier2[$hier1_id][null] = null;
            }
            // 第2階層アイテムを配列へ
            $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]."：".$data_list[$i]["b_bank_name"];
        }
        /* 第3階層配列作成処理 */
/*
        // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
        // または、現在参照レコードの支店コードと前に参照したレコードの支店コードが異なる場合
        // または、現在参照レコードの口座番号と前に参照したレコードの口座番号が異なる場合
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"] ||
            $data_list[$i]["account_no"] != $data_list[$i-1]["account_no"]){
            // 第3階層セレクトアイテムの最初にNULLを設定
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] || 
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                $ary_hier3[$hier1_id][$hier2_id][null] = null;
            }
            // 第3階層アイテムを配列へ
            $ary_hier3[$hier1_id][$hier2_id][$hier3_id] = $data_list[$i]["account_no"];
        }
    }
    // 1つの配列にまとめる
    $ary_hier_item = array($ary_hier1, $ary_hier2, $ary_hier3);
//print_array($data_list);
print_array($ary_hier_item);
}
*/

// 配列作成関数
$select_value = Make_Ary_Bank($db_con);

// 連結html
$attach_html = " → ";

// 銀行・支店・口座
$obj_bank_select = &$form->addElement("hierselect", "form_bank", "", "", $attach_html);
$obj_bank_select->setOptions($select_value);


/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
