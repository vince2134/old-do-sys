<?php
/**
 * セレクトボックスの値を取得する関数
 *
 * 変更履歴
 * 1.0.0 (2006/01/18) 新規作成(suzuki-t)
 * 1.1.0 (2006/01/24) 製品区分、Ｍ区分は共有フラグのものも表示するように変更(kaji)
 * 1.2.0 (2007/10/06) 必要ない項目は削除<watanabe-k>
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version     1.2.0 (2007/10/06)
 *
 * @param               string      $db_con         DBのコネクション
 * @param               string      $column         指定したcolumn名
 *
 * @return              string      $select_value   指定したTableの値（0番目：ID　1番目：名前）
 *
 *
 */

function Select_Get($db_con,$column,$where="",$auth_flg=""){

    //本部画面かFC画面か判別
    //FCの場合、FCフラグをtrue　本部の場合、false
    $fc_flg = $_SESSION["staff_flg"];

    //条件指定判別
    if($where==""){
        //部署
        if($column=="part"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        // FC・取引先区分
        }elseif($column=="rank"){
            $where = "WHERE disp_flg = 't'";
        //製品区分
        }elseif($column=="product"){
            //FCの場合、共有フラグがtrueのものと自グループのものを表示
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }

        //対象
        }else if($column=="g_product"){
            //FCの場合、共有フラグがtrueのものと自グループのものを表示
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }
        //Ｍ区分
        }else if($column=="g_goods"){
            //FCの場合、共有フラグがtrueのものと自グループのものを表示
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }
        //業種（大分類）
        }else if($column=="lbtype"){
            $where = " WHERE accept_flg = '1' ";
        //顧客区分
        }else if($column=="rank"){
            $where = "WHERE disp_flg = 't'";
        //本部スタッフ
        }elseif($column == "h_staff"){
            $where  = " WHERE";
            $where .= "     t_staff.staff_id = t_attach.staff_id";
            $where .= "     AND";
            $where .= "     t_attach.h_staff_flg = 't'";
        }elseif($column == "pattern"){
            $where  = " WHERE";
            if($_SESSION["group_kind"] == "2"){
                $where .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $where .= "     shop_id = ".$_SESSION["client_id"];
            }
        //↓必要ないかもしれない↓　どこかで使用している場合は、このコメントを消してね。
        //支店 OR 対象拠点
        }elseif($column == "cshop"){
            $where = "WHERE ";
            $where .= " client_div = '3' ";
            $where .= " AND ";
            $where .= " shop_div = '2' ";
        }
    }

    //値取得判別
    switch ($column){
        case 'staff':
            //担当者
            if ($auth_flg == true){
                // ページ名を権限マスタカラム名に変換
                $page_name   = substr($_SERVER[PHP_SELF], strrpos($_SERVER[PHP_SELF], "/")+1);
                $module_name = substr($page_name, 0,  strpos($page_name, "."));
                $column_name = str_replace("-", "_", substr_replace($module_name, substr($module_name, 0, 1) == "1" ? "h" : "f", 0, 1));
                // FROM句に権限テーブルを連結
                $join_sql =  " INNER JOIN t_permit ON t_staff.staff_id = t_permit.staff_id ";
                // WHERE句に追加する条件
//                $where_sql = " AND t_permit.$column_name = 't' ";
                $where_sql = " AND t_permit.$column_name = 'w' ";
            }

            $sql = "SELECT t_staff.".$column."_id, t_staff.charge_cd, t_staff.".$column."_name ";
            $sql .= "FROM t_".$column." INNER JOIN t_attach ";
            $sql .= " ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= ($auth_flg == true) ? $join_sql : null;
            $sql .= "WHERE";
            $sql .= "   t_staff.state = '在職中'";
            $sql .= ($auth_flg == true) ? $where_sql : null;
            $sql .= " AND";
            //直営の場合
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            }else{
                $sql .= "   t_attach.shop_id = $_SESSION[client_id]";
            }
            $sql .= " ORDER BY t_staff.charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case 'cstaff':
            //担当者
            $sql = "SELECT t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name ";
            $sql .= "FROM t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= "WHERE";
            //得意先マスタでは退職中も表示
            if($auth_flg != '1'){
                $sql .= "   t_staff.state = '在職中' ";
                $sql .= "AND ";
            }

            //直営の場合
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
            //直営以外
            }else{
                $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
            }
            $sql .= " ORDER BY charge_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case 'h_staff':
            //本部スタッフ
            $sql  = "SELECT t_staff.staff_id, t_staff.charge_cd, t_staff.staff_name";
            $sql .= " FROM t_attach, t_staff";
            $sql .=  $where;
            $sql .= "   ORDER BY t_staff.charge_cd";
            $sql .= ";";
            break;

        case 'rank':
            //顧客区分
            $sql = "SELECT ".$column."_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY ".$column."_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[0]." ： ".$data_list[1];
            }
            break;
        case 'btype':
            //業種
            $sql  = "SELECT";
            $sql .= "   t_lbtype.lbtype_cd,";
            $sql .= "   t_lbtype.lbtype_name,";
            $sql .= "   t_sbtype.sbtype_id,";
            $sql .= "   t_sbtype.sbtype_cd,";
            $sql .= "   t_sbtype.sbtype_name";
            $sql .= " FROM";
            $sql .= "   t_lbtype";
            $sql .= "       INNER JOIN";
            $sql .= "   t_sbtype";
            $sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
            $sql .= " WHERE t_sbtype.accept_flg = 't' ";
            $sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);

            while($data_list = pg_fetch_array($result)){
                if($max_len < mb_strwidth($data_list[1])){
                    $max_len = mb_strwidth($data_list[1]);
                }
            }

            $result = Db_Query($db_con, $sql);
            $select_value = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                            $data_list[1] = $data_list[1]."　";
                    }
                }
                
                $select_value[$data_list[2]] = $data_list[0]." ： ".$data_list[1]."　　 ".$data_list[3]." ： ".$data_list[4];
            }

            break;
        case 'serv_con':
            //契約のサービス
            $sql = "SELECT serv_id,serv_cd,serv_name ";
            $sql .= "FROM t_serv ";
            $sql = $sql.$where;
            $sql .= " ORDER BY serv_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[2];
            }
            break;
        //↓いらないかもしれない↓ 上のコメントを消したら、これも消してね。
        case 'cshop':
            //支店 OR 対象拠点
            $sql = "SELECT client_id,client_cd1,client_cd2,client_name ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = @pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $data_list[3] = htmlspecialchars($data_list[3]);
                $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
            }
            break;
        case 'branch':
            //支店
            $sql  = "SELECT branch_id, branch_cd, branch_name ";
            $sql .= "FROM t_branch ";
            $sql .= "WHERE ";
            $sql .= " shop_id = ".$_SESSION["client_id"]." ";
            $sql .= " ORDER BY branch_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;
        case 'client_gr':
            //グループマスタ
            $sql  = "SELECT client_gr_id, client_gr_cd, client_gr_name ";
            $sql .= "FROM t_client_gr ";
            $sql .= "WHERE ";
            if($_SESSION["group_kind"] == "2"){
                $sql .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $sql .= "     shop_id = ".$_SESSION["client_id"];
            }
            $sql .= " ORDER BY client_gr_cd ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }       
            break;  
        default:
            $sql = "SELECT ".$column."_id,".$column."_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY ".$column."_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
    }

    return $select_value;
}

/**
 * 直営のショップＩＤを抽出するSQLを作成する関数 
 * 現在の使用では必要ないが、その他の関数に影響があるため残してある。 
 *
 * 変更履歴
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version     
 *
 * @param       string      $rank           顧客区分コード　デフォルトなし
 *
 * @return      string      $sql            SQL
 *
 *
 */

function Rank_Sql($rank=""){
    if ($rank == ""){
        $rank_cd = $_SESSION["rank_cd"];
    }else{
        $rank_cd = $rank;
    }
    $sql = " SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_cd' ";

    return $sql;
}

/**
 * 概要     真・ナンバーフォーマット
 *
 * 説明     負数赤文字対応、小数位対応、nullはnull対応
 *
 * @param int       $int        数値
 * @param int       $dot        小数第何位まで表示するか（任意）
 * @param boolean   $null       true: 数値nullならnullのまま返す（任意）
 *
 */
function Minus_Numformat ($int, $dot = 0, $null = null){
    if ($null === true && $int === null){
        return null;
    }else{
        return ($int < 0) ? "<span style=\"color: #ff0000;\">".number_format($int, $dot)."</span>" : number_format($int, $dot);
    }

}

/**
 *
 * PHP6から正式サポートされる超絶関数（仮）
 *
 * 変更履歴
 * 1.0.0 (2006.06.08)    新規作成
 *
 * @author      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $ary          //表示したい配列
 * @param       string    $str          //タイトル
 * @param       string    $print_type   //特殊文字がサニタイズされている場合はそのまま出力するとかしないとか
 *
 * @return      void
 *
 */
function Print_Array($ary, $str=null, $print_type=null){

    $p_type = ($print_type == "xmp") ? "xmp" : "pre";
    $p_type = "xmp";

    print "<pre style=\"font: 10px; font-family: 'ＭＳ ゴシック'; \">";
    print "<hr>";
    print ($str != null) ? "<b>$str</b><br>" : null;
    print ($p_type == "xmp") ? "<xmp>" : null;
    print_r($ary);
    print ($p_type == "xmp") ? "</xmp>" : null;
    print "</pre>";
}

/**
 * 
 * 多次元配列内のvalue全てに指定した関数を適用する
 *
 *
 * 変更履歴
 * 1.0.0. (2007.10.07)      追加 
 *
 * @author      
 *
 * @version     1.0.0 (2007.10.07)
 *
 * @param       array       $ary        適用したい配列
 * @param       string      $func       使用したい関数名（要case文追加）
 *
 * @return      array       $ary_ret    関数適用後の配列
 *
 */
function Ary_Foreach ( $ary , $func ) {

        // $aryでループ
        foreach ($ary as $key => $value ) {
           
            //要素が配列の場合 
            if (is_array($value) == true) {
        
                $ary_res[$key] = Ary_Foreach( $value ,$func);

            //要素が配列でない場合
            } else {
                
                // $funcに応じて関数適用
                switch ($func) {
                    case "number_format" :
                        $ary_res[$key] = number_format($value);
                        break;        
                }
            }
        }

        // 関数的用語の配列を返す
        return $ary_res;
}


/**
 * CSV形式のデータを作成
 *
 * 配列の要素ごとにカンマを挿入する。
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 * 1.0.1 (2006/02/01) 編集（ふくだ）
 * 1.0.2 (2006/02/18) 修正（鈴木）
 * 1.0.3 (2006/10/17) str_replace → mb_ereg_replace（かじ）
 * 1.0.4 (2006/12/07) SJISへ文字コード変換を最後にした（かじ）
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.4 (2006/12/07)
 *
 * @param               array           $row        CSV化するレコードのリスト
 * @param               string          $header     CSVファイルの1行目に追加するヘッダ
 *
 * @return              array
 *
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      12-004      kajioka-h   mb_ereg_replaceをstr_replaceに戻した
 *                  12-018      kajioka-h   同上
 */
function Make_Csv($row ,$header,$sub_header=NULL){

/**************鈴木修正*******************************/
    //レコードが無い場合は、CSVデータにNULLを表示させる
    //$row = (count($row) == 0) ? "" : $row;
    if(count($row)==0){
        $row[] = array("","");
    }
/****************************************************/

    if ($sub_header !== NULL ) {
        array_unshift($row, $sub_header);
    }
 
    // 配列にヘッダ行を追加
    $count = array_unshift($row, $header);
    
    //置換する文字
    $trans = array("\n" => "　", "\r" => "　");
    // 整形
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){


            //改行コードを全角スペースで置換
            $row[$i][$j] = strtr($row[$i][$j], $trans);

            // エンコーディング
            //$row[$i][$j] = mb_convert_encoding($row[$i][$j], "SJIS", "EUC-JP");
            // "→""
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            //$row[$i][$j] = mb_ereg_replace("\"", "\"\"", $row[$i][$j]);
            // ""で囲む
            $row[$i][$j] = "\"".$row[$i][$j]."\"";
        }
        // 配列をカンマ区切りで結合
        $data_csv[$i] = implode(",", $row[$i]);
    }
    $data_csv = implode("\n", $data_csv);
    // エンコーディング
    $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");
    return $data_csv;

}


/**
 * 画面表示データをCSV出力形式に変換する関数
 *
 *
 *
 * 変更履歴<br>
 * 1.0.0 (2007/10/27) 新規作成(watanabe-n)<br>
 * 1.0.1 (2007/11/24) 粗利率に"%"を付けないよう変更(aizawa-m)<br>
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version     1.0.0 (2007/10/06)
 *
 * @param       $disp_data      array    画面表示データ
 * @param       $disp_head      array    CSVに表示する月データ
 * @param       $csv_head       array    CSVに表示する画面固有の値（例：サービス名、サービスコード）
 * @param       $num_flg        boolean  商品数表示　表示：true　非表示：false
 * @param       $margin_flg     boolean  粗利率表示  表示：true　非表示：false
 * @param       $buy_flg        string   仕入フラグ  default: false
 *
 * @return      $csv_data   array    csv出力用データ
 *
 *
 */
function Convert_Csv_Data($disp_data, $disp_head, $csv_head, $num_flg, $margin_flg, $buy_flg=false){
 
    //表示対象期間
    $count = count($disp_head);

    //合計行は表示しないため、削除
    array_pop($disp_data);
 
    //仕入の場合
    //表示するデータ判定
    if($buy_flg === true && $num_flg === true){
        $output_column = array( 
                                "net_amount"    => "仕入金額"
                            );

    //仕入数表示
    }elseif($buy_flg === true && $num_flg === false){
        $output_column = array(
                                "num"           => "仕入数",
                                "net_amount"    => "仕入金額
                            ");

    //以下売上の処理
    //両方表示
    }elseif($num_flg === true && $margin_flg === true){
        $output_column = array(
                                "num"           => "売上数", 
                                "net_amount"    => "売上金額",
                                "arari_gaku"    => "粗利益額",
                                "arari_rate"    => "粗利率",
                            );

    //粗利率表示
    }elseif($num_flg === false && $margin_flg === true){
        $output_column = array(
                                "net_amount"    => "売上金額",
                                "arari_gaku"    => "粗利益額",
                                "arari_rate"    => "粗利率"
                            );
 
    //売上数表示
    }elseif($num_flg === true && $margin_flg === false){
        $output_column = array(
                                "num"           => "売上数",
                                "net_amount"    => "売上数",
                                "arari_gaku"    => "粗利率"
                            );
 
    //両方非表示
    }else{
        $output_column = array(
                                "net_amount"    => "売上金額", 
                                "arari_gaku"    => "粗利利益額",
                            );
    }

    //CSVヘッダ作成
    //１行目の空白セル挿入数
    $sp_count = count($csv_head);
    for($i = 0; $i < $sp_count; $i++){
        $csv_head1[] = "";
    }
    //２行目の固定部の項目
    $csv_head2 = $csv_head;

    //１,２行目の項目を動的に作成
    foreach($disp_head AS $month){
        foreach($output_column AS $val){
            $csv_head1[] = $month;
            $csv_head2[] = $val;
        }
    }

    //csvの行数
    $row = 0;
    foreach($disp_data AS $i => $row_data){
 
        //小計行は表示しないためスキップ
        if($row_data["sub_flg"] === true){
            continue;
        }

        //コード、名前
        $csv_data[$row] = array($row_data["cd"], $row_data["name"]);

        //コード２がある場合
        if($row_data["cd2"] != null){
            array_push($csv_data[$row], $row_data["cd2"], $row_data["name2"]);
        }

        //顧客区分を表示する場合
        if($row_data["rank_cd"] != null){
            array_push($csv_data[$row], $row_data["rank_cd"], $row_data["rank_name"]);
        }

        //集計期間分ループ
        for($j = 0; $j < $count; $j++){

            //表示項目分ループ
            foreach($output_column AS $key => $val){

                //パーセント初期化
                $percent = null;

                /* コメント 2007-11-24_aizawa-m
                //粗利の場合はパーセント
                if($key == "arari_rate"){
                    $percent = "%";
                }
                */

                //CSVデータ挿入
                $csv_data[$row][] = $disp_data[$i][$key][$j].$percent;
            }
 
        }
        //改行
        $row++;
    }

    $csv_data = Make_Csv($csv_data, $csv_head1, $csv_head2);
    return $csv_data;
}

/**
 * CSVクラス
 *
 * CSV関連の処理をまとめたクラスです。
 *
 *
 *
 * @access  public
 * @author  watanabe-k <watanabe-k@bhsk.co.jp>
 * @create  2007/11/03
 * @version 1.0
 **/
class Analysis_Csv_Class{

    protected $output_column;   //表示項目
    private   $count;           //表示対象期間
    private   $csv_head1;       //csvヘッダの１行目
    private   $csv_head2;       //csvヘッダの２行目
    protected $csv_data;        //csvのデータ部
    public    $filename;        //ファイル名
    public    $res_csv;         //出力データ

    /**
     * コンストラクタ
     * 表示するデータを決定します。
     * @access    public
     * @param     boolean    $margin_flg    defalut true    粗利率表示の有無         true：表示/false:非表示
     * @param     boolean    $num_flg       default true    商品数表示の有無         true：表示/false:非表示
     * @param     boolean    $sale_flg      default true    対象データが売上かの有無 true：売上/false:仕入   
     */
    public function __construct($margin_flg=true, $num_flg=true, $sale_flg=true){
        //仕入の場合
        //表示するデータ判定
        if($sale_flg === false && $num_flg === false){
            $this->output_column = array(
                                    "net_amount"    => "仕入金額"
                                );
 
        //仕入数表示
        }elseif($sale_flg === false && $num_flg === true){
            $this->output_column = array(
                                    "num"           => "仕入数",
                                    "net_amount"    => "仕入金額"
                                );

        //以下売上の処理
        //両方表示
        }elseif($num_flg === true && $margin_flg === true){
            $this->output_column = array(
                                    "num"           => "売上数",
                                    "net_amount"    => "売上金額",
                                    "arari_gaku"    => "粗利益額",
                                    "arari_rate"    => "粗利率",
                                );
 
        //粗利率表示
        }elseif($num_flg === false && $margin_flg === true){
            $this->output_column = array(
                                    "net_amount"    => "売上金額",
                                    "arari_gaku"    => "粗利益額",
                                    "arari_rate"    => "粗利率"
                                );

        //売上数表示
        }elseif($num_flg === true && $margin_flg === false){
            $this->output_column = array(
                                    "num"           => "売上数",
                                    "net_amount"    => "売上数",
                                    "arari_gaku"    => "粗利率"
                                );
 
        //両方非表示
        }else{
            $this->output_column = array(
                                    "net_amount"    => "売上金額",
                                    "arari_gaku"    => "粗利益額",
                                );
        }
    }

    /**
     * ファイル名をエンコードします。（ファイル名でなくてもエンコードできます。）
     * @access    public
     * @param     boolean    $margin_flg    defalut true    粗利率表示の有無         true：表示/false:非表示
     * @param     boolean    $num_flg       default true    商品数表示の有無         true：表示/false:非表示
     * @param     boolean    $sale_flg      default true    対象データが売上かの有無 true：売上/false:仕入   
     */
    public function Enc_FileName($filename){
        $this->filename = mb_convert_encoding($filename,"SJIS","EUC");
    }

    /**
     * CSVのヘッダ部を作成します。
     *
     * @access    public
     * @param     array      $disp_head     表示する年月日配列
     * @param     array      $csv_head      画面固有の表示する項目 例$csv_head = array("サービスコード", "サービス名");
     */
    public function Make_Csv_Head($disp_head, $csv_head){
        //CSVヘッダ作成
        //１行目の空白セル挿入数
        $sp_count = count($csv_head);

        //表示対象期間
        $this->count = count($disp_head);

        for($i = 0; $i < $sp_count; $i++){  
            $this->csv_head1[] = "";    
        }
        //２行目の固定部の項目
        $this->csv_head2 = $csv_head;

        //１,２行目の項目を動的に作成
        foreach($disp_head AS $month){
            foreach($this->output_column AS $val){
                $this->csv_head1[] = $month;
                $this->csv_head2[] = $val;
            }
        }
    }

    /**
     * CSVのデータ部を作成します。
     *
     * @access    public
     * @param     array     $disp_data          表示する年月日配列
     * @param     boolean   $before_rank_flg    顧客区分を先に出力する場合=true
     *
     * 変更履歴<br>
     * 2007-11-11   aizawa-m    コード２よりも先に顧客区分を出力させるよう引数を追加<br>
     * 2007-11-24   aizawa-m    粗利率に"%"を付けないよう変更<br>
     *
     */
    public function Make_Csv_Data($disp_data, $before_rank_flg=false){

        //合計行を削除
        array_pop($disp_data);

        //csvの行数
        $row = 0;
        foreach($disp_data AS $i => $row_data){

            //小計行は表示しないためスキップ
            if($row_data["sub_flg"] === "true"){
                continue;
            }

            //コード、名前
            $this->csv_data[$row] = array($row_data["cd"], $row_data["name"]);

            // aizawa-m 追加
            // 顧客区分がある場合かつ、コード２より先に出力する場合
            if ($before_rank_flg == true AND $row_data["rank_cd"] != null) {
                array_push($this->csv_data[$row], $row_data["rank_cd"], $row_data["rank_name"]);
            }

            //コード２がある場合
            if($row_data["cd2"] != null){
                array_push($this->csv_data[$row], $row_data["cd2"], $row_data["name2"]);
            }

            // aizawa-m 変更
            //顧客区分を表示する場合かつ、コード２より後の出力する場合
            if($before_rank_flg == false AND $row_data["rank_cd"] != null){
                array_push($this->csv_data[$row], $row_data["rank_cd"], $row_data["rank_name"]);
            }

            //集計期間分ループ
            for($j = 0; $j < $this->count; $j++){

                //表示項目分ループ
                foreach($this->output_column AS $key => $val){

                    //パーセント初期化
                    $percent = null;

                    /* コメント 2007-11-24_aizawa-m
                    //粗利の場合はパーセント
                    if($key == "arari_rate"){
                        $percent = "%";
                    }
                    */

                    //CSVデータ挿入
                    $this->csv_data[$row][] = $row_data[$key][$j].$percent;
                }
 
            }
            //改行
            $row++;
        }

        $this->res_csv = $this->Create_Csv($this->csv_data, $this->csv_head1, $this->csv_head2);

    }


    /**
     * CSV出力形式のデータに整形します。
     *
     * @access    public
     * @param     array      $row           表示データ
     * @param     array      $header        項目１行目
     * @param     array      $sub_header    項目２行目  default null
     */
    protected function Create_Csv($row ,$header,$sub_header=NULL){

        //レコードが無い場合は、CSVデータにNULLを表示させる
        if(count($row)==0){
            $row[] = array("","");
        }

        if ($sub_header !== NULL ) {
            array_unshift($row, $sub_header);
        }
 
        // 配列にヘッダ行を追加
        $count = array_unshift($row, $header);
    
        //置換する文字
        $trans = array("\n" => "　", "\r" => "　");
        // 整形 
        for($i = 0; $i < $count; $i++){
            for($j = 0; $j < count($row[$i]); $j++){

                //改行コードを全角スペースで置換
                $row[$i][$j] = strtr($row[$i][$j], $trans);

                // エンコーディング
                $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
                // ""で囲む
                $row[$i][$j] = "\"".$row[$i][$j]."\"";
            }       
            // 配列をカンマ区切りで結合
            $data_csv[$i] = implode(",", $row[$i]);
        }
        $data_csv = implode("\n", $data_csv);
        // エンコーディング
        $data_csv = mb_convert_encoding($data_csv, "SJIS", "EUC-JP");

        return $data_csv;
    }
}


/**
 * CSVクラス
 *
 * Analysis_Csv_Class を継承したクラスです。
 * 下記の3つのメソッドはABC分析用にオーバライドしました。
 *
 *
 *
 * @access  public
 * @author  watanabe-k <watanabe-k@bhsk.co.jp>
 * @create  2007/11/17
 * @version 1.0
 **/
class ABC_Csv_Class extends Analysis_Csv_Class{

    /**
     * コンストラクタ
     * 表示するデータを決定します。
     * @access    public
     */
    public function __construct(){
        $this->output_column = array(
                "net_amount" => "売上金額",
                "sale_rate"  => "構成比",
                "accumulated_sale" => "累積金額",
                "accumulated_rate" => "累積構成比",
            );
    }

    /**
     * CSVのヘッダ部を作成します。
     *
     * @access    public
     * @param     array      $csv_head      画面固有の表示する項目 例$csv_head = array("サービスコード", "サービス名");
     */
    public function Make_Csv_Head($csv_head) {

        // 固定部の項目
        $this->csv_head1 = $csv_head;

        // １,２行目の項目を動的に作成
        foreach($this->output_column AS $val){
            $this->csv_head1[] = $val;
        }

    }

    /**
     * CSVのデータ部を作成します。
     *
     * @access    public
     * @param     array     $disp_data          表示する年月日配列
     * @param     boolean   $before_rank_flg    顧客区分を先に出力する場合=true
     *
     * 変更履歴<br>
     * 2007-11-24   aizawa-m        粗利率と構成比率に"%"を付けないよう変更<br>
     *
     */
    public function Make_Csv_Data($disp_data, $csv_head, $before_rank_flg=false){

        //合計行を削除
        array_pop($disp_data);

        //csvの行数
        $row = 0;
        foreach($disp_data AS $i => $row_data){

            //小計行は表示しないためスキップ
            if($row_data["sub_flg"] === "true"){
                continue;
            }

            //コード、名前
            $this->csv_data[$row] = array($row_data["cd"], $row_data["name"]);

            // aizawa-m 追加
            // 顧客区分がある場合かつ、コード２より先に出力する場合
            if ($before_rank_flg == true AND $row_data["rank_cd"] != null) {
                array_push($this->csv_data[$row], $row_data["rank_cd"], $row_data["rank_name"]);
            }

            //コード２がある場合
            if($row_data["cd2"] != null){
                array_push($this->csv_data[$row], $row_data["cd2"], $row_data["name2"]);
            }

            // aizawa-m 変更
            //顧客区分を表示する場合かつ、コード２より後の出力する場合
            if($before_rank_flg == false AND $row_data["rank_cd"] != null){
                array_push($this->csv_data[$row], $row_data["rank_cd"], $row_data["rank_name"]);
            }


            //表示項目分ループ
            foreach($this->output_column AS $key => $val){

                //パーセント初期化
                $percent = null;

                /* コメント 2007-11-24_aizawa-m
                //粗利の場合はパーセント
                if($key == "sale_rate" || $key == "accumulated_rate"){
                    $percent = "%";
                }
                */

                //CSVデータ挿入
                $this->csv_data[$row][] = $row_data[$key].$percent;
            }

            //改行
            $row++;
        }

        $this->res_csv = $this->Create_Csv($this->csv_data, $this->csv_head1);

    }
}

?>
