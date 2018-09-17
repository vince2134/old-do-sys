<?php
/**
 * @fileoverview アメニティ共通関数ファイル
 *
 * ・既存の関数名使っちゃ駄目
 * ・ファイルを開いたまま離席しちゃ駄目
 * ・エラーを出したまま離席しちゃ駄目
 * ・汎用性のない関数はそれぞれのPHPスクリプト内（もしくは別jsファイル）に
 * ・ほとんど処理が同じなのに、2とか3とか名前をつけて関数を増やしてファイルを重くしない
 *   （関数側の変更で済む場合は、関数側で対応する）
 * ・使わなくなった関数は消す（コメントアウトする）
 * ・共通のファイルに関数を追加するのなら、
 *   引数、戻り値ぐらいはまともに説明を書きましょう
 *                       ~~~~~~~
 *
 */


/**
 * 郵便番号からデータ取得
 *
 * DBから郵便番号に対応する住所、住所フリガナを取得。
 *
 * 変更履歴
 * 1.0.0 (2005/12/07) 新規作成(watanabe-n)
 *
 * @author      watanabe-n <watanabe-n@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/07)
 *
 * @param               string      $post1      フォームで入力された郵便番号前3桁
 * @param               string      $post2      フォームで入力された郵便番号後4桁
 *
 * @return              array       $address_record
 *
 *
 */

function Post_Get($post1,$post2,$conn){
    $select_sql = "SELECT kana,ken,banchi";
    $select_sql .= " FROM t_post_no";
    $select_sql .= " WHERE post_no='$post1$post2'";
    $select_sql .= ";";
    $result = Db_Query($conn,$select_sql);
    $post_no = pg_num_rows($result);
    if($post_no==1){
        $address_record = pg_fetch_array($result);
    }else{
        $address_record = "";
    }
    return $address_record;
}



/**
 * 年月から、該当する日を表示
 *
 * 変更履歴
 * 1.0.0 (2005/12/14) 新規作成(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/14)
 *
 * @param               string      $year       フォームで入力された年
 * @param               string      $month      フォームで入力された月
 * @param               string      $week       フォームで入力された週
 * @param               string      $day        フォームで入力された曜日
 *
 * @return              string      $display[$week]
 *
 *
 */

function Day_Get($year,$month,$week,$day){

    //配列の添え字
    $x = 0;

    //年月指定
    $now = mktime(0, 0, 0, $month, 1, $year);
    //月の日数
    $dnum = date("t", $now);

    //月の日数分
    for ($i=1;$i<=$dnum;$i++){
        $t = mktime(0, 0, 0, $month, $i, $year);
        $w = date("w", $t);
        //日曜の場合には、アメニティのコードに変更
        if($w==0){
            $w = 7;
        }
     
        //入力された曜日と比較
        if($day==$w){
            $display[$x] = $i;
            $x++;
        }
    }

    //添え字調整
    $week--;
    return $display[$week];
}

/**
 * 基準日から、指定日がA〜D週のどの週か計算する
 *
 * 変更履歴
 * 1.0.0 (2005/12/26) 新規作成(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/12/26)
 *
 * @param               string      $b_year     フォームで入力された基準の年
 * @param               string      $b_month    フォームで入力された基準の月
 * @param               string      $b_day      フォームで入力された基準の日
 * @param               string      $year       フォームで入力された年
 * @param               string      $month      フォームで入力された月
 * @param               string      $day        フォームで入力された日
 *
 * @return              string      $display
 *
 *
 */

function Basic_date($b_year,$b_month,$b_day,$year,$month,$day){

    //基準日
    $now = mktime(0, 0, 0, $b_month, $b_day, $b_year);
    $date = date(U,$now) / 86400;
    //指定日
    $now = mktime(0, 0, 0, $month, $day, $year);
    $date2 = date(U,$now) / 86400;

    //基準日から指定日までの日数計算
    $basic = $date2 - $date;
    //周期は28日だから割る
    $basic = $basic % 28;

    //A週判定
    if(0 <= $basic && $basic <= 6){
        //週の何日目か
        $basic++;
        $display[0] = 1;
        $display[1] = $basic;
    //B週判定   
    }else if(7 <= $basic && $basic <= 13){
        $basic = $basic - 6;
        $display[0] = 2;
        $display[1] = $basic;
    //C週判定   
    }else if(14 <= $basic && $basic <= 20){
        $basic = $basic - 13;
        $display[0] = 3;
        $display[1] = $basic;
    //D週判定   
    }else if(21 <= $basic && $basic <= 27){
        $basic = $basic - 20;
        $display[0] = 4;
        $display[1] = $basic;
    }else{
        $display = false;
    }

    return $display;
}


/**
 * 帳票のヘッダー表示関数
 *
 * 変更履歴
 * 1.0.0 (2006/01/05) 新規作成(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/01/05)
 *
 * @param               string      $pdf            PDFオブジェクト
 * @param               string      $left_margin    レフトマージン
 * @param               string      $top_margin     トップマージン
 * @param               string      $title          タイトル
 * @param               string      $left_top       左上のヘッダー項目名
 * @param               string      $left_bottom    左下のヘッダー項目名
 * @param               string      $right_top      右上のヘッダー項目名
 * @param               string      $right_bottom   右下のヘッダー項目名
 * @param               string      $page_count     ページ数
 * @param               string      $list           項目名
 * @param               string      $font_size      フォントサイズ
 * @param               string      $page_size      ページサイズ(A3:1110 A4:515)
 *
 */

function Header_disp($pdf,$left_margin,$top_margin,$title,$left_top,$right_top,$left_bottom,$right_bottom,$page_count,$list,$font_size,$page_size){

    $pdf->SetFont(GOTHIC, '', $font_size);
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $title, '0', '1', 'C');
    $pdf->SetXY($left_margin,$top_margin);
    $pdf->Cell($page_size, 14, $page_count."ページ", '0', '2', 'R');
    $pdf->SetX($left_margin);
    $pdf->Cell($page_size, 14, $left_top, '0', '1', 'L');
    $pdf->SetXY($left_margin,$top_margin+14);
    $pdf->Cell($page_size, 14, $right_top, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $right_bottom, '0', '1', 'R');
    $pdf->SetXY($left_margin,$top_margin+28);
    $pdf->Cell($page_size, 14, $left_bottom, '0', '2', 'L');

    //項目表示
    $posY = $pdf->GetY();
    $pdf->SetXY($left_margin, $posY);
    for($i=0;$i<count($list)-1;$i++)
    {
        $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '0', $list[$i][2]);
    }
    $pdf->Cell($list[$i][0], 14, $list[$i][1], '1', '2', $list[$i][2]);

}


/**
 * セレクトボックスの値を取得する関数
 *
 * 変更履歴
 * 1.0.0 (2006/01/18) 新規作成(suzuki-t)
 * 1.1.0 (2006/01/24) 製品区分、Ｍ区分は共有フラグのものも表示するように変更(kaji)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/01/24)
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
			if($_SESSION["group_kind"] == '2'){
			    $where = "WHERE shop_id IN (".Rank_Sql().") \n";
			}else{
			    $where = "WHERE shop_id = ".$_SESSION["client_id"];
			}
		//部署
        }else if($column=="cal_part"){
		    $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //倉庫
        }else if($column=="ware"){
            if($_SESSION["group_kind"] == '2'){
                $where  = "WHERE shop_id IN (".Rank_Sql().") \n";
            }else{
                $where  = "WHERE shop_id = ".$_SESSION["client_id"];
            }
            $where .= " AND nondisp_flg = 'f'";
        //銀行
        }else if($column=="bank"){
            if($_SESSION["group_kind"] == '2'){
                $where  = "WHERE shop_id IN (".Rank_Sql().") \n";
            }else{
                $where  = "WHERE shop_id = ".$_SESSION["client_id"];
            }
        //製品区分
        }else if($column=="product"){
            //FCの場合、共有フラグがtrueのものと自グループのものを表示
/*
            $where = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= " AND accept_flg = '1' ";
*/
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
/*
            $where = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= "AND accept_flg = '1' ";
*/
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
/*
            $where  = "WHERE public_flg = true ";
            if($fc_flg != 't'){
                $where .= "OR shop_id = ".$_SESSION["client_id"];
            }
            $where .= "AND accept_flg = '1' ";
*/
            if($fc_flg != 't'){
                $where .= " WHERE (public_flg = 't' AND accept_flg = '1')";
                $where .= " OR";
                $where .= " shop_id = $_SESSION[client_id]";
            }else{
                $where .= " WHERE shop_id = $_SESSION[client_id]";
                $where .= " AND";
                $where .= " accept_flg = '1'";
            }
        //商品グループ
        }else if($column=="goods_gr"){
            //$where = "WHERE shop_id = ".$_SESSION["client_id"];
        //地区
        }else if($column=="area"){
            if($_SESSION["group_kind"] == '2'){
                $where = "WHERE shop_id IN (".Rank_Sql().")";
            }else{
                $where = "WHERE shop_id = ".$_SESSION["client_id"];
            }
        //直送先
        }else if($column=="direct"){
//            $where = "WHERE shop_id = ".$_SESSION["client_id"];
            $where = "WHERE t_direct.shop_id = ".$_SESSION["client_id"];
        //構成品
        }else if($column=="compose"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //運送業者
        }else if($column=="trans"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //取引区分(受注)
        }else if($column=="trade_aord"){
            $where = "WHERE trade_id = '11' OR trade_id = '61'";
        //取引区分(売上)
        }else if($column=="trade_sale"){
            $where = "WHERE kind = '1'";
        //取引区分（受注を起こしている売上）
        }else if($column == "trade_sale_aord"){
            $where = "WHERE trade_id IN (11,15,61)";
            $column = "trade";
        //取引区分(入金)
        }else if($column=="trade_payin"){
            $where = "WHERE kind = '2'";
        //取引区分(発注)
        }else if($column=="trade_ord"){
            $where = "WHERE trade_id = '21' OR trade_id = '71'";
        //取引区分(仕入)
        }else if($column=="trade_buy"){
            $where = "WHERE kind = '3'";
        //取引区分（発注を起こしている仕入）
        }else if($column == "trade_buy_ord"){
            $where = "WHERE trade_id IN (21,25,71)";
            $column = "trade";
        //取引区分(支払)
        }else if($column=="trade_payout"){
            $where = "WHERE kind = '4'";
        //スタッフ
        }else if($column=="staff"){
//          $where = "WHERE shop_id = ".$_SESSION["client_id"];
            $where = "";
        //コース
        }else if($column=="course"){
            $where = "WHERE shop_id = ".$_SESSION["client_id"];
        //顧客区分
        }else if($column=="rank"){
            $where = "WHERE disp_flg = 't'";
        //支店 OR 対象拠点
        }else if($column=="cshop"){
            $where = "WHERE ";
            $where .= " client_div = '3' ";
            $where .= " AND ";
            $where .= " shop_div = '2' ";

        //事業所
        }else if($column=="fcshop"){
            $where = "WHERE ";
            //$where .= " client_id IN (".Rank_Sql().")";
            $where .= " client_id = $_SESSION[client_id]";
            $where .= " AND ";
            $where .= " client_div = '3' ";
            $where .= " AND ";
            $where .= " (shop_div = '2' OR client_id = $_SESSION[client_id])";
/*
        //直営のショップ
        }else if($column=="petition"){
            $where = "WHERE ";
            $where .= " attach_gid = ".$_SESSION["shop_gid"];
            $where .= " AND ";
            $where .= " shop_div = '1' ";
*/
        //直営のショップ
        }else if($column=="dshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '2' ";
        //FCのショップ
        }else if($column=="fshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '3' ";
		//FCのショップ(取引中のみ)
        }else if($column=="calshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind = '3' ";
            $where .= " AND ";
			$where .= "     t_client.state = '1' ";
        //FC・直営のショップ
        }else if($column=="rshop"){
            $where  = " WHERE ";
            $where .= "     t_client.client_div = '3' ";
            $where .= " AND ";
            $where .= "     t_rank.group_kind IN ('2','3') ";
            $where .= " AND ";
			$where .= "     t_client.state = '1' ";
        //所有ショップ
        }else if($column=="own_shop"){
//            $where  = "WHERE";
//            $where .= " t_client.attach_gid = ".$_SESSION["shop_gid"];
//            $where .= " AND t_client.client_div = '3'";
            // 直営の場合は「直営のFC」のみ抽出
            if ($_SESSION["group_kind"] == "2"){
                $where .= " INNER JOIN t_rank ";
                $where .= " ON t_client.rank_cd = t_rank.rank_cd ";
                $where .= " WHERE ";
                $where .= " t_rank.group_kind = '2' ";
                $where .= " AND ";
            }else{
				$where .= "WHERE ";
			}
            $where .= " t_client.client_div = '3' ";
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
        }elseif($column == "claim_pattern"){
            $where  = " WHERE";
            if($_SESSION["group_kind"] == "2"){
                $where .= "    shop_id IN (".Rank_Sql().")";
            }else{
                $where .= "     shop_id = ".$_SESSION["client_id"];
            }
        }

    }

    //値取得判別
    switch ($column){
        case 'divide':
            //販売区分(＊keyの値を変更しないで下さい！！)
            $select_value = array(
                ""  =>  "",
                "01"  =>  "01 ： リピート",
                "02"  =>  "02 ： 商品",
                "03"  =>  "03 ： レンタル",
                "04"  =>  "04 ： リース",
                //"05"  =>  "05 ： 卸",
                "05"  =>  "05 ： 工事",
                "06"  =>  "06 ： その他",
                //"08"  =>  "08 ： 保険",
                //"09"  =>  "09 ： 返却",
                //"10"  =>  "10 ： 代行",
            );
            break;
		case 'divide_con':
            //契約の販売区分(＊keyの値を変更しないで下さい！！)
            $select_value = array(
                ""  =>  "",
                "01"  =>  "リピート",
                "02"  =>  "商品",
                "03"  =>  "レンタル",
                "04"  =>  "リース",
                //"05"  =>  "05 ： 卸",
                "05"  =>  "工事",
                "06"  =>  "その他",
                //"08"  =>  "08 ： 保険",
                //"09"  =>  "09 ： 返却",
                //"10"  =>  "代行",
            );
            break;
        case 'trade_aord':
        case 'trade_sale':
        case 'trade_payin':
        case 'trade_ord':
        case 'trade_buy':
        case 'trade_payout':
            //取引区分(受注・売上・入金・発注・仕入・支払)
            $sql = "SELECT trade_id,trade_cd, trade_name ";
            $sql .= "FROM t_trade ";
            $sql = $sql.$where;
            $sql .= " ORDER BY trade_cd";
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
        case 'close':
            //締日
            $select_value[""] = "";
            for($x=1;$x<=28;$x++){
                $select_value[$x] = $x."日";
            }
            $select_value["29"] = "月末";

            break;
/*
        case 'close2':
            //締日
            $select_value[""] = "";
            for($x=1;$x<=28;$x++){
                if($x>=29){
                    $g_form_option_select .= " style=\"color:RED;\"";
                }
                $select_value[$x] = $x."日";
            }
            $select_value["31"] = "31日(月末)";
            $select_value["91"] = "現金";
            break;
*/
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
        case 'petition':
            //本社
            $sql = "SELECT client_id,client_cd1,client_cd2,client_name ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
            }
            break;
        case 'fcshop':
            //事業所
            $sql = "SELECT client_id,client_cd1,client_cd2,client_cname ";
            $sql .= "FROM t_client ";
            $sql = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
            }
            break;
        case 'dshop':
        case 'fshop':
        case 'calshop':
        case 'rshop':
            //直営のショップ
            //FCのショップ
            $sql  = "SELECT ";
            $sql .= "    t_client.client_id,";
            $sql .= "    t_client.client_cd1,";
            $sql .= "    t_client.client_cd2,";
            $sql .= "    t_client.client_cname ";
            $sql .= "FROM ";
            $sql .= "    t_client ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql  = $sql.$where;
            $sql .= " ORDER BY client_cd1,client_cd2";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                    $data_list[0] = htmlspecialchars($data_list[0]);
                    $data_list[1] = htmlspecialchars($data_list[1]);
                    $data_list[2] = htmlspecialchars($data_list[2]);
                    $data_list[3] = htmlspecialchars($data_list[3]);
                   $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." ： ".$data_list[3];
            }
            break;
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

		case 'cal_staff':
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
            $sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
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
		case 'sale_staff':
			//売上伝票では、value値に担当者CDを使用する

            //担当者
            $sql = "SELECT t_staff.charge_cd,t_staff.staff_name ";
            $sql .= "FROM t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
            $sql .= "WHERE";
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
                $data_list[0] = str_pad($data_list[0], 4, 0, STR_POS_LEFT);
                $select_value[$data_list[0]] = $data_list[0]." ： ".$data_list[1];
            }
            break;

        case "shop_staff":
            // ショップに所属するスタッフ
            $sql  = "SELECT t_attach.staff_id, t_staff.charge_cd, t_staff.staff_name ";
            $sql .= "FROM t_attach ";
            $sql .= "INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
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
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case "round_staff_m":
            // 巡回担当者（スタッフマスタから取得）
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            t_attach.staff_id \n";
            $sql .= "        FROM \n";
            $sql .= "            t_attach \n";
            $sql .= "            LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "        WHERE \n";
            $sql .= "            t_staff.state = '在職中' \n";
            $sql .= "        AND \n";
            $sql .= "            t_staff.round_staff_flg = 't' \n";
            $sql .= "        AND \n";
            $sql .= "            t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case "round_staff_ms":
            // 巡回担当者（スタッフマスタ＋売上伝票から取得）
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                t_attach.staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_attach \n";
            $sql .= "                LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_staff.state = '在職中' \n";
            $sql .= "            AND \n";
            $sql .= "                t_staff.round_staff_flg = 't' \n";
            $sql .= "            AND \n";
            $sql .= "                t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '1' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.act_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_aorder_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_aorder_h \n";
            $sql .= "                LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_aorder_h.contract_div = '1' \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_aorder_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_aorder_h \n";
            $sql .= "                LEFT JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_aorder_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_h.act_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_aorder_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case "round_staff_ms_cd":
            // 巡回担当者（スタッフマスタ＋売上伝票から取得）
            $sql  = "SELECT \n";
            $sql .= "    t_round_staff.staff_id, \n";
            $sql .= "    LPAD(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
            $sql .= "    t_staff.staff_name \n";
            $sql .= "FROM \n";
            $sql .= "    ( \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                t_attach.staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_attach \n";
            $sql .= "                LEFT JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_staff.state = '在職中' \n";
            $sql .= "            AND \n";
            $sql .= "                t_staff.round_staff_flg = 't' \n";
            $sql .= "            AND \n";
            $sql .= "                t_attach.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "        ) \n";
            $sql .= "        UNION \n";
            $sql .= "        ( \n";
            $sql .= "            SELECT \n";
            $sql .= "                 t_sale_staff.staff_id AS staff_id \n";
            $sql .= "            FROM \n";
            $sql .= "                t_sale_h \n";
            $sql .= "                LEFT JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
            $sql .= "            WHERE \n";
            $sql .= "                t_sale_h.contract_div = '2' \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
            $sql .= "            AND \n";
            $sql .= "                t_sale_staff.staff_div = '0' \n";
            $sql .= "        ) \n";
            $sql .= "    ) \n";
            $sql .= "    AS t_round_staff \n";
            $sql .= "    LEFT JOIN t_staff ON t_round_staff.staff_id = t_staff.staff_id \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $Select_Value[""] = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($res)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[1]] = $data_list[1]." ： ".$data_list[2];
            }
            break;

        case "claim":
            // 請求先
            $sql  = "SELECT t_claim.claim_div, t_client.client_cname ";
            $sql .= "FROM t_claim ";
            $sql .= "INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= ($where != null) ? " $where AND " : null;
            //直営の場合
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_client.shop_id IN (".Rank_Sql().")";
            //直営以外
            }else{
                $sql .= "   t_client.shop_id = ".$_SESSION[client_id];
            }
            $sql .= "ORDER BY t_claim.client_id, t_claim.claim_id, t_claim.claim_div ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;


        case "claim_payin":
            // 請求先
            $sql  = "SELECT t_claim.claim_div, t_client.client_cname ";
            $sql .= "FROM t_claim ";
            $sql .= "INNER JOIN t_client ON t_claim.claim_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= ($where != null) ? " $where AND " : null;
            //直営の場合
            if($_SESSION["group_kind"] == '2'){
                $sql .= "   t_client.shop_id IN (".Rank_Sql().")";
            //直営以外
            }else{
                $sql .= "   t_client.shop_id = ".$_SESSION[client_id];
            }
            $sql .= "ORDER BY t_claim.claim_div ";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;


        case 'bank':
            //銀行
            $sql  = "SELECT ".$column."_id, bank_cd,".$column."_name ";
            $sql .= "FROM t_".$column." ";
//            $sql .= "WHERE ";
//            $sql .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
            $sql .= $where;
            $sql .= " ORDER BY bank_cd";
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

        case 'b_bank2':
            //銀行支店
            $sql  = "SELECT t_b_bank.b_bank_id, t_b_bank.b_bank_cd, t_b_bank.b_bank_name ";
            $sql .= "FROM t_b_bank ";
            $sql .= "INNER JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
            $sql .= "WHERE ";
            $sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
            $sql .= $where;
            $sql .= "ORDER BY t_b_bank.b_bank_cd ";
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

/*
        case 'bank_b_bank':
            // 銀行：支店
            $sql  = "SELECT ";
            $sql .= "   t_b_bank.b_bank_id, ";
            $sql .= "   t_bank.bank_cd, ";
            $sql .= "   t_bank.bank_name, ";
            $sql .= "   t_b_bank.b_bank_cd, ";
            $sql .= "   t_b_bank.b_bank_name ";
            $sql .= "FROM ";
            $sql .= "   t_b_bank ";
            $sql .= "   LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
            $sql .= "ORDER BY ";
            $sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd ";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            $select_value = "";
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[2]) <= $max_len && $i != 0){
                            $data_list[2] = $data_list[2]."　";
                    }
                }
                
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2]."　　 ".$data_list[3]." ： ".$data_list[4];
            }
            break;
*/

        case 'goods_gr':
            //商品グループ
            $sql = "SELECT DISTINCT goods_gid,goods_gname ";
            $sql .= "FROM t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY goods_gname";
            $sql .= ";";
        
            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'compose':
        case 'make_goods':
            //構成品 OR 製造品
            $sql = "SELECT t_goods.goods_id,t_goods.goods_cd,t_goods.goods_name ";
            $sql .= "FROM t_goods,t_".$column." ";
            $sql = $sql.$where;
            $sql .= " ORDER BY t_goods.goods_cd";
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
        case 'own_shop':
            //所有ショップ
            $sql  = "SELECT";
            $sql .= "   t_client.client_id,";
            $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
            $sql .= "   t_client.client_cname";
            $sql .= " FROM";
            $sql .= "   t_client ";
            $sql .= $where;
            $sql .= " ORDER BY t_client.client_cd1, t_client.client_cd2";

            $result = Db_Query($db_con, $sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." : ".$data_list[2];
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
        case 'h_area':
            $sql = "SELECT area_id,area_cd,area_name ";
            $sql .= "FROM t_area ";
            $sql .= " WHERE shop_id = $_SESSION[client_id] ";
            $sql .= " ORDER BY area_cd";
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
        case 'b_bank':
            $sql  = "SELECT";
            $sql .= "   t_bank.bank_id,";
            $sql .= "   t_b_bank.b_bank_id,";
            $sql .= "   t_b_bank.b_bank_cd,";
            $sql .= "   t_b_bank.b_bank_name";
            $sql .= " FROM";
            $sql .= "    t_bank";
            $sql .= " LEFT JOIN";
            $sql .= "   t_b_bank";
            $sql .= "   ON t_bank.bank_id = t_b_bank.bank_id";
            $sql .= $where;
            $sql .= " ORDER BY t_bank.bank_cd, t_b_bank.b_bank_cd";
            $sql .= ";";
            $result = Db_Query($db_con,$sql);

            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $data_list[3] = htmlspecialchars($data_list[3]);
                $select_value[$data_list[0]][$data_list[1]] = $data_list[2]." ： ".$data_list[3];
            }
            break;
/*
        case 'shop_gr':
            //FCグループ
            $sql = "SELECT shop_gid, shop_gcd, shop_gname";
            $sql .= " FROM t_shop_gr";
            $sql .= " ORDER BY shop_gcd";
            $select_value[""] = "";

            $result = Db_Query($db_con, $sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."　：　".$data_list[2];
            }
            break;
*/
        case 'pattern':
            //パターン
            $sql = "SELECT s_pattern_id, s_pattern_no, s_pattern_name ";
            $sql .= "FROM t_slip_sheet ";
            $sql = $sql.$where;
            $sql .= " ORDER BY s_pattern_no";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
            }
            break;
        case 'claim_pattern':
            //パターン
            $sql = "SELECT c_pattern_id,c_pattern_name ";
            $sql .= "FROM t_claim_sheet ";
            $sql = $sql.$where;
            $sql .= " ORDER BY c_pattern_id";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'pay_way':
            //集金方法
            $select_value[""]   = null;
            $select_value["1"]  = "1 ： 自動引落";
            $select_value["2"]  = "2 ： 振込"; 
            $select_value["3"]  = "3 ： 訪問集金";
            $select_value["4"]  = "4 ： 手形";
            $select_value["5"]  = "5 ： その他";
            break;
        case 'trans';
            //運送業者
            $sql  = "SELECT trans_id, trans_cd, trans_cname ";
            $sql .= "FROM t_trans ";
            $sql .= "$where ";
            $sql .= "ORDER by trans_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."　：　".$data_list[2];
            }
            break;
        case 'direct';
/*
            //運送業者
            $sql  = "SELECT direct_id, direct_cd, direct_cname ";
            $sql .= "FROM t_direct ";
            $sql .= "$where ";
            $sql .= "ORDER by direct_cd";
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $data_list[2] = htmlspecialchars($data_list[2]);
                $select_value[$data_list[0]] = $data_list[1]."　：　".$data_list[2];
            }
            break;
*/
            //直送先
            $sql  = "SELECT direct_id, direct_cd, direct_cname, t_client.client_cname ";
            $sql .= "FROM t_direct LEFT JOIN t_client ON t_direct.client_id = t_client.client_id ";
            $sql .= "$where ";
            $sql .= "ORDER by direct_cd";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            while($data_list = pg_fetch_array($result)){
                if($max_len < mb_strwidth($data_list[2])){
                    $max_len = mb_strwidth($data_list[2]);
                }
            }

            $result = Db_Query($db_con, $sql);
            $select_value       = "";   
            $select_value[""]   = "";   
            while($data_list = pg_fetch_array($result)){
                $space = "";
                for($i = 0; $i< $max_len; $i++){
                    if(mb_strwidth($data_list[2]) <= $max_len && $i != 0){
                        $data_list[2] = $data_list[2]."　";
                    }       
                }
    
            $select_value[$data_list[0]]  = htmlspecialchars($data_list[1]);
            $select_value[$data_list[0]] .= " : ";
            $select_value[$data_list[0]] .= htmlspecialchars($data_list[2]);
            $select_value[$data_list[0]] .= "請求先 : ";
            $select_value[$data_list[0]] .= htmlspecialchars($data_list[3]);
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
		case 'cal_part':
            $sql = "SELECT part_id,part_cd,part_name ";
            $sql .= "FROM t_part ";
            $sql = $sql.$where;
            $sql .= " ORDER BY part_cd";
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
        case 'course':
            $sql  = "SELECT course_id, course_name ";
            $sql .= "FROM t_course ";
            $sql .= $where;
            $sql .= ";";

            $result = Db_Query($db_con,$sql);
            $select_value[""] = "";
            while($data_list = pg_fetch_array($result)){
                $data_list[0] = htmlspecialchars($data_list[0]);
                $data_list[1] = htmlspecialchars($data_list[1]);
                $select_value[$data_list[0]] = $data_list[1];
            }
            break;
        case 'client_gr':
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
        case 'ware':
            //倉庫
            $sql  = "SELECT ware_id, ware_cd, ware_name ";
            $sql .= "FROM t_ware ";
            $sql .= " $where ";
            $sql .= " ORDER BY staff_ware_flg, ware_cd";
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
//  return $g_form_option_select;
}

/**
 * ログを登録
 *
 * 変更履歴
 * 1.0.0 (2005/01/28) 新規作成(suzuki-t)
 * 1.1.0 (2006/03/15) shop_idをclient_idに変更(suzuki-t)
 * 1.2.0 (2007/03/28) スタッフ名とデータIDを登録するように修正(morita-d)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/03/15)
 *
 * @param               string      $db_con         DBのコネクション
 * @param               string      $mst_name       マスタ名
 * @param               string      $work_div       作業区分
 * @param               string      $data_cd        データコード
 * @param               string      $data_name      データコードの名称
 * @param               int         $data_name      データIDの名称
 *
 * @return              string      $display[$week]
 *
 *
 */

function Log_Save($db_con,$mst_name,$work_div,$data_cd,$data_name,$data_id=-1){

    //担当者ID・ショップID取得
    $staff_id   = $_SESSION["staff_id"];
    $client_id  = $_SESSION["client_id"];
    $staff_name = addslashes($_SESSION["staff_name"]);   //ログイン者名

    $mst_name = "t_".$mst_name;
    $pkey = Get_Pkey();

    $table["t_part"]            = "部署マスタ";
    $table["t_ware"]            = "倉庫マスタ";
    $table["t_area"]            = "地区マスタ";
    $table["t_lbtype"]          = "業種マスタ（Ｍ区分）";
    $table["t_sbtype"]          = "業種マスタ（小分類）";
    $table["t_serv"]            = "サービスマスタ";
    $table["t_course"]          = "コースマスタ";
    $table["t_client"]          = "得意先マスタ";
    $table["t_shop"]            = "FC・取引先マスタ";
    $table["t_staff"]           = "スタッフマスタ";
    $table["t_goods"]           = "商品マスタ";
    $table["t_g_goods"]         = "Ｍ区分マスタ";
    $table["t_product"]         = "管理区分マスタ";      
    $table["t_g_product"]       = "商品分類マスタ";        
    $table["t_make_goods"]      = "製造品マスタ";
    $table["t_compose"]         = "構成品マスタ";
    $table["t_shop_gr"]         = "FCグループマスタ";
    $table["t_rank"]            = "FC・取引先区分マスタ";
    $table["t_bank"]            = "銀行マスタ";
    $table["t_b_bank"]          = "銀行支店マスタ";
    $table["t_account"]         = "口座マスタ";
    $table["t_trans"]           = "運送業者マスタ";
    $table["t_direct"]          = "直送先マスタ";
    $table["t_contract"]        = "契約マスタ";
    $table["t_bstruct"]         = "業態マスタ";
    $table["t_inst"]            = "施設マスタ";
    $table["t_supplier"]        = "仕入先マスタ";
    $table["t_gr"]              = "グループマスタ";

    //ログを登録
    $sql  = "INSERT INTO ";
    $sql .= "t_mst_log ";
    $sql .= "(";
    $sql .= "log_id,";
    $sql .= "staff_id,";
    $sql .= "staff_name,";
    $sql .= "mst_name,";
    $sql .= "work_div,";
    $sql .= "data_id,";
    $sql .= "data_cd,";
    $sql .= "data_name,";
    $sql .= "shop_id ";
    $sql .= ")VALUES(";
    $sql .= "$pkey, ";
    $sql .= "$staff_id,";
    $sql .= "'$staff_name',";
    $sql .= "'$table[$mst_name]',";
    $sql .= "'$work_div',";
    $sql .= "$data_id,";
    $sql .= "'$data_cd',";
    $sql .= "'$data_name',";
    $sql .= "$client_id";
    $sql .= ");";

    $result = Db_Query($db_con,$sql);

    return $result;
}


/**
 * 変更ログを取得
 *
 * 変更履歴
 * 1.0.0 (2007/03/29) 新規作成(morita-d)
 *
 * @author      morita-d
 *
 * @version     1.0.0 (2007/03/29)
 *
 * @param               resource    $db_con         DBリソース
 * @param               string      $mst_name       マスタ名
 * @param               int         $id             データID
 *
 * @return              array       変更ログ
 *
 */
function Log_Get($db_con,$mst_name,$id){

    //担当者ID・ショップID取得
    $shop_id  = $_SESSION["client_id"];

    $sql ="
        SELECT
        staff_id,
        staff_name,
        --CAST( work_time AS DATE)
        work_time
        FROM t_mst_log
        WHERE shop_id = $shop_id 
        AND data_id = $id
        AND work_div = 2
        AND mst_name = '契約マスタ'
        ORDER BY work_time DESC
        LIMIT 2 OFFSET 0
    ";

    $result = Db_Query($db_con,$sql);
    $data   = pg_fetch_all($result);

    return $data;
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
function Make_Csv($row ,$header){

/**************鈴木修正*******************************/
    //レコードが無い場合は、CSVデータにNULLを表示させる
    //$row = (count($row) == 0) ? "" : $row;
    if(count($row)==0){
        $row[] = array("","");
    }
/****************************************************/

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
 * DBからデータを取得する。
 *
 *
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.0 (2005/03/22)
 *
 * @param               string          $result     クエリ情報
 *
 * @return              array
 *
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/05/28      xx-xxx      kajioka-h   $output_typeに「5」を追加
 *                                          （「3」等を使って取得したデータをDBに突っ込んでる人、気をつけて！余計なタグが付いてるよ！）
 *
 */
function Get_Data($result, $output_type="", $key_type=""){
    $result_count = pg_numrows($result);

    $key_type = ($key_type == "ASSOC") ? "PGSQL_ASSOC" : "PGSQL_NUM";

    if ($key_type == "PGSQL_NUM"){

        for($i = 0; $i < $result_count; $i++){
            $row[] = @pg_fetch_array ($result, $i,PGSQL_NUM);
        }

/*
        if($output_type != 2 && $output_type != 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
                }
            }
        }

		//引数に「３」を指定したらaddslashesを行う
		if($output_type == 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes($row[$i][$j]));
                }
            }
        }
*/

        //引数に「1」を指定した、または指定が無い場合はhtmlspecialcharsを行う
        if($output_type == null || $output_type == 1){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(htmlspecialchars($row[$i][$j]));
                }
            }
        }

        //引数に「2」を指定した場合は何もしない
        if($output_type == 2){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = $row[$i][$j];
                }
            }
        }

        //引数に「3」を指定したらaddslashesを行う
        if($output_type == 3){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes($row[$i][$j]));
                }       
            }       
        }       

        //引数に「4」を指定したらaddslashesとhtmlspecialcharsとnl2brを行う
        if($output_type == 4){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = nl2br(addslashes(htmlspecialchars($row[$i][$j])));
                }       
            }       
        }

        //引数に「5」を指定したらaddslashesのみを行う
        if($output_type == 5){
            for($i = 0; $i < $result_count; $i++){
                for($j = 0; $j < count($row[$i]); $j++){
                    $row[$i][$j] = addslashes($row[$i][$j]);
                }
            }
        }

    }else{

        for ($i=0; $i<$result_count; $i++){
            $row[] = @pg_fetch_array ($result, $i, PGSQL_ASSOC);
        }

        if ($output_type != 2){
            foreach ($row as $key1 => $value1){
                foreach ($value1 as $key2 => $value2){
                    $row[$key1][$key2] = nl2br(htmlspecialchars($value2));
                }
            }
        }

    }

    return $row;
}

/**
*Getした値が不正な場合はメインメニューへ遷移
*
*
*
*
*変更履歴
*1.0.0 (2006/2/10) 新規作成(watanabe-k)
*
*
*@author                watanabe-k<watanabe-k@bhsk.co.jp>
*
*@version               1.0.0 (2005/03/22)
*
*@param                 string? 
*
*@return                void
*
*/
function Get_Id_Check($result){
    $num = pg_num_rows($result);
    if($num == 0){
        Header("Location: ../top.php"); 
    }
}


/**
*Getした値がNULLの場合はメインメニューへ遷移
*
*
*
*
*変更履歴
*1.0.0 (2006/2/10) 新規作成(suzuki-t)
*
*
*@author                suzuki-t
*
*@version               1.0.0 (2006/05/08)
*
*@param                 string? 
*
*@return                void
*
*/
function Get_Id_Check2($num){
    if($num == NULL){
        Header("Location: ../top.php"); 
    }
}
 
/**
*GETした値がint以外の場合はメインメニューへ遷移
*
*
*
*
*変更履歴
*1.0.0 (2006/10/18) 新規作成(watanabe-k)
*
*
*@author                watanabe-k
*
*@version               1.0.0
*
*@param                 ????? 
*
*@return                void
*
*/
function Get_Id_Check3($num){
    if($num != NULL){

        //配列の場合
        if(is_array($num)){

            for($i = 0; $i < count($num); $i++){
                if(!ereg("^[0-9]+$", $num[$i])){
                    header("Location: ../top.php");
                    exit;
                }
            }

        //配列以外の場合
        }else{
            if(!ereg("^[0-9]+$", $num)){
                header("Location: ../top.php");
            }
        }
    }
}


/**
* GETしたIDの正当性をチェック
*
* 変更履歴
* 1.0.0 (2006/11/20) 新規作成
*
* @author       fu
* @version      1.0.0
* @param        
*               int/string      $get_data
*               string          $get_col
*               string          $type
*               string          $where
* @return       boolean         $valid_flg
*
*/
function Get_Id_Check_Db($db_con, $get_data, $get_col, $table, $type, $where=null){

    // GETデータのタイプが数値の場合
    if ($type == "num"){

        // GETデータの数値チェック→結果をフラグに
        $safe_flg = (ereg("^[0-9]+$", $get_data)) ? true : false;

    // GETデータのタイプが文字列の場合
    }elseif ($type == "str"){

        // 特殊文字をエスケープ＋「'」で囲む
        $get_data = "'".addslashes($get_data)."'";

        $safe_flg = true;

    }

    // エラーの無い場合
    if ($safe_flg === true){
        $sql  = "SELECT \n";
        $sql .= "   * \n";
        $sql .= "FROM \n";
        $sql .= "   $table \n";
        $sql .= "WHERE \n";
        $sql .= "   $get_col = $get_data \n";
        $sql .= ($where != null) ? "AND $where \n" : null;
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        $safe_flg = ($num > 0) ? true : false;
    }

    return $safe_flg;

}


/**
 *
 * POSTされたデータが既に登録されているデータと重複していないかチェック
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $status         ステータス（新規・変更）
 * @param       string      $origin_data    変更前データ（無い場合はnull）
 * @param       string      $post_data      POSTされたデータ
 * @param       string      $sql            重複をチェックするSQL
 *
 * @return      boolean                     エラー：true
 *
 */
function Duplicate_Chk($con, $status, $origin_data, $post_data, $sql){

    // POSTされたデータが配列の場合（２フォームの重複チェックの場合）
    if (is_array($post_data)){
        $post_data = $post_data[0]."-".$post_data[1];
        // 変更の場合（元データがある場合）
        if ($status == "chg"){
            $origin_data = $origin_data[0]."-".$origin_data[1];
        }
    }

    // 新規登録の場合・変更で元データとPOSTデータが違う場合
    if ( (($status == "add") && ($post_data != null) ||
         (($status == "chg") && ($origin_data != $post_data) && ($post_data) != null)) ){

        $res = Db_Query($con, $sql);

        // 該当レコードが1件以上あれば重複エラー
        return (pg_fetch_result($res, 0, 0) >= 1) ? true : false;

    }

    return false;

}


    
/**
 *
 * POSTされたデータが既に登録されているデータと重複していないかチェック
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ  
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       double      $coax            端数区分
 * @param       double      $price           金額
 *
 * @return      double                      
 *
 */
function Coax_Col($coax, $price){
    #2010-05-13 hashimoto-y
    if($price >= 0){
        if($coax == '1'){
            $price = floor($price);
        }elseif($coax == '2'){
            $price = round($price);
        }elseif($coax == '3'){
            $price = ceil($price);
        }
    }else{
        if($coax == '1'){
            $price = ceil($price);
        }elseif($coax == '2'){
            $price = round($price);
        }elseif($coax == '3'){
            $price = floor($price);
        }
    }

    return $price;
}

/**
 *
 *合計金額、消費税合計、伝票金額を算出する
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       array       $price_data     それぞれの商品の合計金額
 * @param       array       $tax_div        それぞれの商品の課税区分
 * @param       string      $coax           丸め区分
 * @param       string      $tax_franct     端数区分
 * @param       string      $tax_rate       消費税率
 * @param       int         $client_id      得意先ID
 * @param       object      $db_con         Dbとのコネクション
 *
 * @return      array                       合計金額、消費税合計、伝票金額
 *
 */
//function Total_Amount($price_data, $tax_div, $coax="1", $tax_franct="1", $tax_rate="5", $client_id, $db_con){
function Total_Amount($price_data, $tax_div, $coax, $tax_franct, $tax_rate, $client_id, $db_con){
    //得意先の課税区分を抽出
    $sql  = "SELECT";
    $sql .= "   c_tax_div ";
    $sql .= "FROM";
    $sql .= "   t_client ";
    $sql .= "WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $c_tax_div = pg_fetch_result($result, 0,0);

    //消費税率
    $rate = bcdiv($tax_rate, 100, 2);

    //消費税率税　＋　１
    $in_rate = bcadd($rate,1,2);

    //伝票合計を求める場合
    if(is_array($price_data) === true){

        //商品数ループ
        for($i = 0; $i < count($price_data); $i++){
            $buy_amount = str_replace(',','',$price_data[$i]);

            //課税区分を決める
            if($c_tax_div == '1' && $tax_div[$i] == '1'){
                $tax_div[$i] = '1';             //外税
            }elseif($c_tax_div == '2' && $tax_div[$i] == '1'){
                $tax_div[$i] = '2';             //内税
            }elseif($tax_div[$i] == '3'){
                $tax_div[$i] = '3';             //非課税
            }

            //配列の中身がNULLの場合は、処理を行わない
            if($buy_amount != null){
                //課税区分ごとに商品の合計を求める
                //外税の場合
                if($tax_div[$i] == '1'){
                    $outside_buy_amount     = bcadd($outside_buy_amount,$buy_amount);
                //内税の場合
                }elseif($tax_div[$i] == '2'){
                    $inside_amount          = bcadd($inside_amount, $buy_amount);

                }elseif($tax_div[$i] == '3'){
                    $exemption_buy_amount   = bcadd($exemption_buy_amount, $buy_amount);
                }
            }
        }

        //消費税を求める
        //外税
        if($outside_buy_amount != 0){
            $outside_tax_amount   = bcmul($outside_buy_amount, $rate,2);                    //消費税額（丸め前）
            $outside_tax_amount   = Coax_Col($tax_franct, $outside_tax_amount);             //消費税額（丸め後）
        }

        //内税
        if($inside_amount != 0){
            $in_rate              = bcmul($in_rate,100);
            $inside_tax_amount    = bcdiv($inside_amount, $in_rate,2);
            $inside_tax_amount    = bcmul($inside_tax_amount, $tax_rate,2);
            $inside_tax_amount    = Coax_Col($tax_franct, $inside_tax_amount);
            $inside_buy_amount    = bcsub($inside_amount, $inside_tax_amount);
        }
        

        //税抜き金額合計
        $buy_amount_all     = $outside_buy_amount + $inside_buy_amount + $exemption_buy_amount;
        //消費税合計
        $tax_amount_all     = $outside_tax_amount + $inside_tax_amount;
        //税込み金額合計
        $total_amount       = $buy_amount_all + $tax_amount_all;

/*
                //消費税を算出
                //外税  
                if($tax_div[$i] == '1'){
                    $tax_amount = bcmul($buy_amount,$rate,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                //内税
                }elseif($tax_div[$i] == '2'){
                    $tax_amount = bcdiv($buy_amount, $in_rate,2);
                    $tax_amount = bcsub($buy_amount, $tax_amount,2);
                    $tax_amount = Coax_Col($tax_franct,$tax_amount);
                    $buy_amount = bcsub($buy_amount, $tax_amount);

                //非課税
                }elseif($tax_div[$i] == '3'){
                    $tax_amount = 0;
                }

                //消費税合計
                $tax_amount_all = bcadd($tax_amount_all, $tax_amount);

                //仕入金額合計（税抜）
                $buy_amount_all = bcadd($buy_amount_all, $buy_amount);
        
                //仕入金額合計（税込）
                $total_amount = bcadd($buy_amount_all, $tax_amount_all);
                $total_amount_all = bcadd($total_amount_all, $total_amount);
            }
        }
*/
    //行単位の合計を求める場合
    }else{
        if($tax_div == null){
            $tax_div == '1';
        }

        //課税区分を決める
        if($c_tax_div == '1' && $tax_div == '1'){
            $tax_div = '1';             //外税
        }elseif($c_tax_div == '2' && $tax_div == '1'){
            $tax_div = '2';             //内税
        }elseif($tax_div == '3'){
            $tax_div = '3';             //非課税
        }

        //金額
        $buy_amount = str_replace(',','',$price_data);

        //消費税
        //外税
        if($tax_div[$i] == '1'){
            $tax_amount = bcmul($buy_amount,$rate,2);
            $tax_amount = Coax_Col($tax_franct, $tax_amount);
        //内税
        //先に消費税額を求め、合計金額から消費税額を引いたものを税抜き金額とする。
        }elseif($tax_div[$i] == '2'){
            $tax_amount = bcdiv($buy_amount, $in_rate,2);
            $tax_amount = bcsub($buy_amount, $tax_amount,2);
            $tax_amount = Coax_Col($tax_franct, $tax_amount);
            $buy_amount = bcsub($buy_amount, $tax_amount);
        //非課税
        }elseif($tax_div[$i] == '3'){
            $tax_amount = 0;
        }

        $buy_amount_all = $buy_amount;
        $tax_amount_all = $tax_amount;

        $total_amount = bcadd($buy_amount, $tax_amount);
    }

    $data = array($buy_amount_all, $tax_amount_all, $total_amount);
    return $data;
}
       
    
/**
 *
 * Getで渡ってきたデータの次と前のコードを取得
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ  
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $table          テーブル名
 * @param       string      $get_cd         渡ってきたIDより抽出したコード(コードが２つある場合は,で区切る)
 * @param       strint      $type           本部・FC・取引先区分
 * 
 * 
 *
 * @return      array                       次と前のコード
 *
 */
function Make_Get_Id($conn, $table, $get_cd, $type=null){
//$table 対応表
//goods     : 商品マスタ
//client    ：得意先マスタ（得意先）
//staff     ：スタッフマスタ
//supplier  ：得意先マスタ（仕入先）
//direct    ：直送先マスタ
//compose   ：構成品マスタ
//make_goods：製造品マスタ
    //商品マスタ
    if($table == "goods"){
		//本部判定
        if($type == '2'){
	        $sql  = "SELECT";
	        $sql .= "   t_goods.goods_cd";
	        $sql .= " FROM";
	        $sql .= "   t_goods_info";
	        $sql .= "       INNER JOIN";
	        $sql .= "   t_goods";
	        $sql .= "       ON t_goods_info.goods_id = t_goods.goods_id";
	        $sql .= " WHERE";
			//直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   t_goods_info.shop_id IN(".Rank_Sql().")";
	            $sql .= "   AND ";
                //直営は本部商品の有効または有効（直営）の商品と、FC商品（有効、無効関係なく全て）
                $sql .= "   ( ";
                $sql .= "      (t_goods.public_flg = true AND t_goods.state IN (1, 3)) ";
                $sql .= "      OR t_goods.public_flg = false ";
                $sql .= "   ) ";
	        }else{ 
				//ＦＣ
				$sql .= "   t_goods_info.shop_id = ".$_SESSION[client_id]."";
	            $sql .= "   AND ";
                //FCは本部商品の有効の商品と、FC商品（有効、無効関係なく全て）
                $sql .= "   ( ";
                $sql .= "      (t_goods.public_flg = true AND t_goods.state = 1) ";
                $sql .= "      OR t_goods.public_flg = false ";
                $sql .= "   ) ";
			}
	        $sql .= "   AND";
	        $sql .= "   t_goods_info.head_fc_flg = 'f'";
	        $sql .= "   AND";
	        $sql .= "   t_goods.accept_flg = '1'";
	        $sql .= " ORDER BY t_goods.goods_cd;";
        }else{  
			//本部
            $sql  = "SELECT";
            $sql .= "   goods_cd";
            $sql .= " FROM";
            $sql .= "   t_goods";
            $sql .= " WHERE";
            $sql .= "   public_flg = 't'";
            $sql .= " ORDER BY goods_cd";
            $sql .= ";";
        }

    //直送先マスタ
    }elseif($table == "direct" ){
	    $sql  = "SELECT";
	    $sql .= "   direct_cd";
	    $sql .= " FROM";
	    $sql .= "   t_direct";
	    $sql .= " WHERE";
	    //直営判定
		if($_SESSION[group_kind] == '2'){
			//直営
			$sql .= "   shop_id IN(".Rank_Sql().")";
	    }else{ 
			//本部・ＦＣ
			$sql .= "   shop_id = ".$_SESSION[client_id]."";
		}
	    $sql .= " ORDER BY direct_cd";
	    $sql .= ";";
    //仕入先
    }elseif($table == "supplier"){
	    $sql  = "SELECT";
	    $sql .= "   client_cd1";
	    $sql .= " FROM";
	    $sql .= "   t_client";
	    $sql .= " WHERE";
	    $sql .= "   client_div = '2'";
	    $sql .= "   AND";
	    //直営判定
		if($_SESSION[group_kind] == '2'){
			//直営
			$sql .= "   shop_id IN(".Rank_Sql().")";
	    }else{ 
			//本部・ＦＣ
			$sql .= "   shop_id = ".$_SESSION[client_id]."";
		}
	    $sql .= "   ORDER BY client_cd1";
	    $sql .= ";";
    //得意先
    }elseif($table == "client"){
		//本部判定
//        if($type == '2'){
	        $sql  = "SELECT";
	        $sql .= "   client_cd1 ||','|| client_cd2";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        //直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   shop_id IN(".Rank_Sql().")";
		    }else{ 
				//ＦＣ
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   client_div = '1'";
	        $sql .= " ORDER BY client_cd1, client_cd2";
	        $sql .= ";";
//        }else{
/*
			//本部
            $sql  = "SELECT";
            $sql .= "   client_cd1 ||','|| client_cd2";
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   shop_id = ".$_SESSION[client_id];
            $sql .= "   AND";
            $sql .= "   (client_div = '1'";
            $sql .= "   OR";
            $sql .= "   client_div = '3')";
            $sql .= "   ORDER BY client_cd1, client_cd2";
            $sql .= ";";
        }
*/
    //スタッフマスタ
    }elseif($table == "staff"){
		//本部判定
        if($type == '2'){
	        $sql  = "SELECT DISTINCT ";
	        $sql .= "    t_staff.charge_cd ";
	        $sql .= "FROM";
	        $sql .= "    t_attach ";
	        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
	        $sql .= "WHERE";
			//直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   t_attach.shop_id IN(".Rank_Sql().")";
		    }else{ 
				//ＦＣ
				$sql .= "   t_attach.shop_id = ".$_SESSION[client_id];
			}
	        $sql .= "ORDER BY t_staff.charge_cd;";
        }else{
			//本部
/*
            $sql  = "SELECT DISTINCT ";
            $sql .= "   t_staff.charge_cd ";
            $sql .= " FROM";
            $sql .= "   t_staff";
            $sql .= "   ORDER BY charge_cd";
            $sql .= ";";
*/
            //FCコード、担当者コードでソート
            $sql  = "SELECT \n";
            $sql .= "    t_staff.staff_id \n";
            $sql .= "FROM \n";
            $sql .= "    t_staff \n";
            $sql .= "    INNER JOIN t_attach ON t_staff.staff_id = t_attach.staff_id \n";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id \n";
            $sql .= "WHERE \n";
            $sql .= "    t_attach.h_staff_flg = false \n";
            $sql .= "ORDER BY \n";
            $sql .= "    t_client.client_cd1, \n";
            $sql .= "    t_client.client_cd2, \n";
            $sql .= "    t_staff.charge_cd \n";
            $sql .= ";\n";
        }
	//構成品
    }elseif($table == "compose"){
	    $sql  = "SELECT";
	    $sql .= "   t_goods.goods_cd";
	    $sql .= " FROM";
	    $sql .= "   t_goods";
	    $sql .= " WHERE";
	    $sql .= "   t_goods.compose_flg = 't'";
	    $sql .= "   ORDER BY t_goods.goods_cd";
	    $sql .= ";";
	    $table = "goods";
	//製造品
    }elseif($table == "make_goods"){
	    $sql .= "SELECT";
	    $sql .= "   DISTINCT";
	    $sql .= "   t_goods.goods_cd";
	    $sql .= " FROM";
	    $sql .= "   t_goods,";
	    $sql .= "   t_make_goods";
	    $sql .= " WHERE";
	    $sql .= "   t_make_goods.goods_id = t_goods.goods_id";
	    $sql .= "   ORDER BY t_goods.goods_cd";
	    $sql .= ";";
	    $table = "goods";
	//ＦＣ      
    }elseif($table == "shop"){
	    $sql .= "SELECT";
	    $sql .= "   client_cd1 || ',' || client_cd2";
	    $sql .= " FROM";
	    $sql .= "   t_client";
	    $sql .= " WHERE";
	    $sql .= "   client_div = '3'";
	    $sql .= " ORDER BY client_cd1, client_cd2";
	    $sql .= ";";
    }

    $result = Db_Query($conn, $sql);
    $data_num = pg_num_rows($result);
    for($i = 0; $i < $data_num; $i++){
        $cd_data[] = pg_fetch_result($result, $i, 0);
    }
    $current_cd = @array_search($get_cd, $cd_data);

    //次へ
    $get_cd_data[0] = $cd_data[$current_cd+1];

    //前へ
    $get_cd_data[1] = $cd_data[$current_cd-1];

    for($i = 0; $i < 2; $i++){
        //商品
        if($table == "goods"){
			$sql  = "SELECT";
	        $sql .= "   ".$table."_id";
	        $sql .= " FROM";
	        $sql .= "   t_".$table."";
	        $sql .= " WHERE";
	        $sql .= "   ".$table."_cd = '$get_cd_data[$i]'";
	        $sql .= "   AND";
			//直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   (shop_id IN(".Rank_Sql().")";
	        }else{ 
				//本部・ＦＣ
				$sql .= "   (shop_id = ".$_SESSION[client_id];
			}
	        $sql .= "   OR";
	        $sql .= "   public_flg = 't')";
	        $sql .= ";";
        }elseif($table == "direct"){
	        $sql  = "SELECT";
	        $sql .= "   direct_id";
	        $sql .= " FROM";
	        $sql .= "   t_direct";
	        $sql .= " WHERE";
	        $sql .= "   direct_cd = '$get_cd_data[$i]'";
	        $sql .= "   AND";
			//直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//本部・ＦＣ
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= ";";
        }elseif($table == "supplier"){
			$sql  = "SELECT";
	        $sql .= "   client_id";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        $sql .= "   client_cd1 = '$get_cd_data[$i]'";
	        $sql .= "   AND";
	        //直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//本部・ＦＣ
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   client_div = '2'";
	        $sql .= ";";
        }elseif($table == "staff"){
	        $sql  = "SELECT";
	        $sql .= "   t_staff.".$table."_id";
	        $sql .= " FROM";
			$sql .= "    t_attach ";
	        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
	        $sql .= " WHERE";
            if($_SESSION["group_kind"] != "1"){
    	        if($get_cd_data[$i] != NULL){
	                $sql .= "   t_staff.charge_cd = '".$get_cd_data[$i]."' ";
	            }else{
	                $sql .= "   t_staff.charge_cd = null ";
    	        }
            }
			//直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= " AND t_attach.shop_id IN(".Rank_Sql().")";
	        }elseif ($_SESSION["group_kind"] == "1"){
                // 本部
                //$sql .= null;
                if($get_cd_data[$i] != null){
                    $sql .= " t_staff.staff_id = ".$get_cd_data[$i]."";
                }else{
                    $sql .= " t_staff.staff_id = null ";
                }
            }else{
				// ＦＣ
				$sql .= " AND t_attach.shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= ";";
        }elseif($table == "client"){
            $get_cd_data_exp[$i] = explode(",",$get_cd_data[$i]);

	        $sql  = "SELECT";
	        $sql .= "   ".$table."_id";
	        $sql .= " FROM";
	        $sql .= "   t_".$table."";
	        $sql .= " WHERE";
	        $sql .= "   ".$table."_cd1 = '".$get_cd_data_exp[$i][0]."'";
	        $sql .= "   AND";
	        $sql .= "   ".$table."_cd2 = '".$get_cd_data_exp[$i][1]."'";
	        $sql .= "   AND";
	        //直営判定
			if($_SESSION[group_kind] == '2'){
				//直営
				$sql .= "   shop_id IN(".Rank_Sql().")";
	        }else{ 
				//本部・ＦＣ
				$sql .= "   shop_id = ".$_SESSION[client_id]."";
			}
	        $sql .= "   AND";
	        $sql .= "   (client_div = '1'";
	        $sql .= "   OR";
	        $sql .= "   client_div = '3')";
	        $sql .= ";";
        }elseif($table == "shop"){
            $get_cd_data_exp[$i] = explode(",",$get_cd_data[$i]);

	        $sql  = "SELECT";
	        $sql .= "   client_id";
	        $sql .= " FROM";
	        $sql .= "   t_client";
	        $sql .= " WHERE";
	        $sql .= "   t_client.client_cd1 = '".$get_cd_data_exp[$i][0]."'";
	        $sql .= "   AND";
	        $sql .= "   t_client.client_cd2 = '".$get_cd_data_exp[$i][1]."'";
	        $sql .= "   AND";
	        $sql .= "   t_client.client_div = '3'";
	        $sql .= "   AND";
			$sql .= "   t_client.shop_id = ".$_SESSION[client_id]."";
	        $sql .= ";";
        }

        $result = Db_Query($conn, $sql);
        $num = pg_num_rows($result);
        if($num != 0){
            $id_data[$i] = pg_fetch_result($result,0,0);
        }
    }
    return $id_data;
}

/**
 *
 * Getで渡ってきた契約データの次と前のコードを取得
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    suzuki新規作成
 *
 * @author      suzuki
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $client_id      得意先ID
 * @param       string      $get_id         渡ってきたID
 * 
 * 
 *
 * @return      array                       次と前のコード
 *
 */
function Make_Get_Id2($conn,$client_id,$get_id){
    //契約マスタ
    $sql  = "SELECT";
    $sql .= "   contract_id";
    $sql .= " FROM";
    $sql .= "   t_contract";
    $sql .= " WHERE";
    $sql .= "   client_id = $client_id";
    $sql .= " ORDER BY contract_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $data_num = pg_num_rows($result);
    for($i = 0; $i < $data_num; $i++){
        $cd_data[] = pg_fetch_result($result, $i, 0);
    }

    $current_cd = array_search($get_id, $cd_data);

    //次へ
    $get_cd_data[0] = $cd_data[$current_cd+1];

    //前へ
    $get_cd_data[1] = $cd_data[$current_cd-1];

    for($i = 0; $i < 2; $i++){
        if($get_cd_data[$i] != NULL){
            $sql  = "SELECT";
            $sql .= "   contract_id";
            $sql .= " FROM";
            $sql .= "   t_contract";
            $sql .= " WHERE";
            $sql .= "   contract_id = ".$get_cd_data[$i];
            $sql .= "   AND";
            $sql .= "   client_id = $client_id";
            $sql .= ";";
         
            $result = Db_Query($conn, $sql);
            $num = pg_num_rows($result);
            if($num != 0){
                $id_data[$i] = pg_fetch_result($result,0,0);
            }
        }
    }
    return $id_data;
}


/**
 *
 * PHP6から正式サポートされる超絶関数（仮）
 *
 * 変更履歴
 * 1.0.0 (2006.06.08)    じうこべなたわ　新規作成
 *
 * @author      じうこべ
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
 * PHP7から正式サポートされる超絶関数（仮）
 *
 * 変更履歴
 * 1.0.0 (2006.06.08)    じうこべなたわ　新規作成
 *
 * @author      あべこうじ
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $ary      //表示したい配列
 * 
 * 
 *
 * @return      void
 *
 */
function Print_var($ary, $str=null){

    print "<pre style=\"font: 10px; font-family: 'ＭＳ ゴシック'; \">";
    print "<hr>";
    print ($str != null) ? "<b>$str</b><br>" : null;
    var_dump($ary);
    print "</pre>";
}


/**
 *
 *
 *直営の場合のSQL
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
function Rank_Sql($rank=""){
    if ($rank == ""){
        $rank_cd = $_SESSION["rank_cd"];
    }else{
        $rank_cd = $rank;
    }
    $sql = " SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_cd' ";

    return $sql;
}

function Rank_Sql2($rank = ""){

    if ($_SESSION["groyup_kind"] == "2"){
        if ($rank == ""){
            $rank_cd = $_SESSION["rank_cd"];
        }else{
            $rank_cd = $rank;
        }
        $sql = " (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_cd') ";
    }else{
        $sql = " (".$_SESSION["client_id"].") \n";
    }

    return $sql;
}


/** 
 *　ロイヤリティを計算する
 * 
 *
 * 変更履歴
 * 1.0.0 (2006.07.29)    watanabe-k　新規作成
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       array     $buy_amount      //表示したい配列
 *              array     $royalty      
 *              int       $royalty_rate
 *              string    $coax
 *
 * @return      void    
 * 
 * 
**/ 
function Total_Royalty($buy_amount, $royalty, $royalty_rate, $coax){
    $rate = bcdiv($royalty_rate, 100,2);
    for($i = 0; $i < count($royalty); $i++){
        $buy_amount[$i] = str_replace(",","",$buy_amount[$i]);
        if($royalty[$i] == '1'){
            $royalty_price = bcmul($buy_amount[$i], $rate,2);
        }

        $royalty_price = Coax_Col($coax, $royalty_price);

        $royalty_total = bcadd($royalty_price, $royalty_total);
    }

    return $royalty_total;
}

/**
 * ナンバーフォーマット
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
function My_Number_Format($num=null, $int=0){
    //
    if($num != null){
        $num = number_format($num, $int);
    }

    //戻り値

    return $num;
}


/** 
 *　銀行・支店・口座のhierselect用配列生成関数
 * 
 *
 * 変更履歴
 * 1.0.0 (2006.07.29)    watanabe-k　新規作成
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       string    $db_con           DB接続
 *              
 *
 * @return      array
 * 
 * 
**/ 
function Make_Ary_Bank($db_con, $type=null){

    // 銀行・支店・口座情報取得SQL
    $sql  = "SELECT ";
    $sql .= "   t_bank.bank_id, ";
    $sql .= "   t_bank.bank_cd, ";
    $sql .= "   t_bank.bank_name, ";
    $sql .= "   t_b_bank.b_bank_id, ";
    $sql .= "   t_b_bank.b_bank_cd, ";
    $sql .= "   t_b_bank.b_bank_name, ";
    $sql .= "   t_account.account_id, ";
    $sql .= "   CASE t_account.deposit_kind ";
    $sql .= "       WHEN '1' THEN '普通' ";
    $sql .= "       WHEN '2' THEN '当座' ";
    $sql .= "   END ";
    $sql .= "   AS deposit, ";
    $sql .= "   t_account.account_no ";
    $sql .= "FROM ";
    $sql .= "   t_bank ";
    $sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
    $sql .= "   INNER JOIN t_account ON t_b_bank.b_bank_id = t_account.b_bank_id ";
    $sql .= "WHERE ";
    $sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
    #2010-04-21 hashimoto-y
    $sql .= "AND t_bank.nondisp_flg = false ";
    $sql .= "AND t_b_bank.nondisp_flg = false ";
    $sql .= "AND t_account.nondisp_flg = false ";
    $sql .= "ORDER BY ";
    $sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect用配列定義
    $ary_hier1[null] = null; 
    $ary_hier2       = null; 
    $ary_hier3       = null;

    // 1件以上ある場合
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // データ取得（レコード毎）
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // 分かりやすいように各階層のIDを変数に代入
            $hier1_id = $data_list[$i]["bank_id"];
            $hier2_id = $data_list[$i]["b_bank_id"];
            $hier3_id = $data_list[$i]["account_id"];

            /* 第1階層配列作成処理 */
            // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                // 第1階層取得アイテムを配列へ
//                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." ： ".htmlspecialchars($data_list[$i]["bank_name"]);
                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." ： ".htmlentities($data_list[$i]["bank_name"], ENT_COMPAT, EUC);
            }

            /* 第2階層配列作成処理 */
            // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
            // または、現在参照レコードの支店コードと前に参照したレコードの支店コードが異なる場合
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                // 第2階層セレクトアイテムの最初にNULLを設定
                if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                    //$ary_hier2[$hier1_id][null] = "";
                    $ary_hier2[$hier1_id][0] = ""; //2015-03-24 amano
                }
                // 第2階層取得アイテムを配列へ
//                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." ： ".htmlspecialchars($data_list[$i]["b_bank_name"]);
                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." ： ".htmlentities($data_list[$i]["b_bank_name"], ENT_COMPAT, EUC);
            }

            /* 第3階層配列作成処理 */
            // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
            // または、現在参照レコードの支店コードと前に参照したレコードの支店コードが異なる場合
            // または、現在参照レコードの口座番号と前に参照したレコードの口座番号が異なる場合
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"] ||
                $data_list[$i]["account_no"] != $data_list[$i-1]["account_no"]){
                // 第3階層セレクトアイテムの最初にNULLを設定
                if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] || 
                    $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                    $ary_hier3[$hier1_id][$hier2_id][null] = "";
                }
                // 第3階層取得アイテムを配列へ
                $ary_hier3[$hier1_id][$hier2_id][$hier3_id] = $data_list[$i]["deposit"]." ： ".$data_list[$i]["account_no"];
            }

        }
        // 1つの配列にまとて返す
        return array($ary_hier1, $ary_hier2, $ary_hier3);

    // 1件も無い場合
    }else{

        // 空の配列を返す
//        return array(array(""), array(""), array(""));
        //array(null)にすると、array[0]=nullとなるので[null][]
        $array[null] = "";
        return array($array, $array, $array);
    }

}

/** 
 *　支店、部署のhierselect用配列生成関数
 * 
 *
 * 変更履歴
 * 1.0.0 (2006.07.29)    watanabe-k　新規作成
 *
 * @author      watanabe-k      
 *
 * @version     1.0.0 (2006.06.08)
 *
 * @param       string    $db_con           DB接続
 *              
 *
 * @return      array
 * 
 * 
**/ 
function Make_Ary_Branch($db_con, $shop_id=null){

    $sql  = "SELECT ";
    $sql .= "   t_branch.branch_id, ";
    $sql .= "   t_branch.branch_cd, ";
    $sql .= "   t_branch.branch_name, ";
    $sql .= "   t_part.part_id, ";
    $sql .= "   t_part.part_cd, ";
    $sql .= "   t_part.part_name ";
    $sql .= "FROM ";
    $sql .= "   t_branch ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_part ";
    $sql .= "   ON t_branch.branch_id = t_part.branch_id ";
    $sql .= "WHERE ";
    //ショップ指定されていない場合
    if($shop_id != null){
        $sql .= "   t_branch.shop_id = ".$shop_id." ";
    }else{
        $sql .= "   t_branch.shop_id = ".$_SESSION["client_id"]." ";
    }
    $sql .= "ORDER BY t_branch.branch_cd, t_part.part_cd ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect用配列定義
    $ary_hier1[null] = null;
    $ary_hier2       = null;

    // 1件以上ある場合
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // データ取得（レコード毎）
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // 分かりやすいように各階層のIDを変数に代入
            $hier1_id = $data_list[$i]["branch_id"];
            $hier2_id = $data_list[$i]["part_id"];

            /* 第1階層配列作成処理 */
            // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
            if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["banch_cd"]){
                // 第1階層取得アイテムを配列へ
//                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." ： ".htmlspecialchars($data_list[$i]["bank_name"]);
                $ary_hier1[$hier1_id] = $data_list[$i]["branch_cd"]." ： ".htmlentities($data_list[$i]["branch_name"], ENT_COMPAT, EUC);
            }

            /* 第2階層配列作成処理 */
            // 現在参照レコードの銀行コードと前に参照したレコードの銀行コードが異なる場合
            // または、現在参照レコードの支店コードと前に参照したレコードの支店コードが異なる場合
            if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["branch_cd"] ||
                $data_list[$i]["part_cd"] != $data_list[$i-1]["part_cd"]){
                // 第2階層セレクトアイテムの最初にNULLを設定
                if ($data_list[$i]["branch_cd"] != $data_list[$i-1]["branch_cd"]){
                    $ary_hier2[$hier1_id][null] = "";
                }
                // 第2階層取得アイテムを配列へ
//                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." ： ".htmlspecialchars($data_list[$i]["b_bank_name"]);
                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["part_cd"]." ： ".htmlentities($data_list[$i]["part_name"], ENT_COMPAT, EUC);
            }

        }

        // 1つの配列にまとて返す
        return array($ary_hier1, $ary_hier2);

    // 1件も無い場合
    }else{

        // 空の配列を返す
//        return array(array(""), array(""), array(""));
        //array(null)にすると、array[0]=nullとなるので[null][]
        $array[null] = "";
        return array($array, $array);
    }

}


/** 
* 概要 表示ページの妥当性をチェックし、正当なページを返す 
* 
* 説明  
* 
* @param string    $all_num  データの総数 
* @param string    $limit    1ページの表示件数 
* @param string    $page     現在のページ数
* 
* @return array          表示ページ、ページの開始件数、ページの終了件数
* 
*/
function Check_Page ($all_num, $limit, $page="1") {

    //表示件数が0の場合は１ページ目を表示
    if ($all_num == "0" ) { 
        $data[0] = 1;
        $data[1] = 0;
        $data[2] = 0;
    
        return $data;
    }

    //ページ数の計算(最終ページの最後までデータがある場合)
    if (($all_num % $limit) == "0" ) {
        $all_page = ($all_num / $limit);

    //ページ数の計算（最終ページの途中までしかデータが無い場合）
    } else {
        $all_page = (int)($all_num / $limit)+1;
    }

    //1ページ以下の場合、1ページ目を表示する
    if ($page < 1) {
        $page = 1;
    //最終ページ以降の場合、最終ページを表示する
    } elseif ($all_page < $page) {
        $page = $all_page;
    }

    //表示開始件数を計算
    $page_snum = (($page -1) * $limit) +1; 
    
    //表示終了件数を計算
    $page_enum   = $page * $limit; 
    //総件数より表示終了件数が多い場合は、総件数まで表示する
    if ($all_num < $page_enum) {
        $page_enum = $all_num;
    }

    $data[0] = $page;
    $data[1] = $page_snum;
    $data[2] = $page_enum;

    return $data;
}

/**
 *
 * 日付が月次更新された期間かどうかをチェック
 *
 * @param       resource    $db_con     DB接続リソース
 * @param       int         $client_id  取引先ID
 * @param       string      $client_div 取引先区分
 *                              0：自分（棚卸用）
 *                              1：得意先として使われている
 *                              2：仕入先として使われている
 * @param       string      $y          チェックする日付の年
 *                          $m          チェックする日付の月
 *                          $d          チェックする日付の日
 *
 * @return      bool        true        月次更新されてない
 *                          false       月次更新されている
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.1 (2006/10/17)
 *
 */
function Check_Monthly_Renew($db_con, $client_id, $client_div, $y, $m, $d, $shop_id="")
{
    $shop_id = ($shop_id == "") ? $_SESSION["client_id"] : $shop_id;

    $max_day = START_DAY;
    $today  = str_pad($y, 4, "0", STR_PAD_LEFT)."-";
    $today .= str_pad($m, 2, "0", STR_PAD_LEFT)."-";
    $today .= str_pad($d, 2, "0", STR_PAD_LEFT);

    //前回の月次更新日を取得
    $sql  = "SELECT \n";
    $sql .= "    COALESCE(MAX(close_day), '".START_DAY."') \n";
    $sql .= "FROM \n";
    $sql .= "    t_sys_renew \n";
    $sql .= "WHERE \n";
    $sql .= "    shop_id = ".$shop_id." \n";
    $sql .= "    AND \n";
    $sql .= "    renew_div = '2' \n";
    $sql .= ";\n";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $close_day = (pg_num_rows($result) == 0) ? $max_day : pg_fetch_result($result, 0, 0);

    if($client_div == "0"){
        if($close_day < $today){
            return true;
        }else{
            return false;
        }
    }

    //最終の月次売掛（買掛）残高登録日を取得
    //（まだ月次更新をしていないor追加された得意先（仕入先））
    $sql  = "SELECT \n";
    $sql .= "    COALESCE(MAX(monthly_close_day_this), '".START_DAY."') \n";
    $sql .= "FROM \n";
    if($client_div == "1"){
        $sql .= "    t_ar_balance \n";
    }else{
        $sql .= "    t_ap_balance \n";
    }
    $sql .= "WHERE \n";
    $sql .= "    client_id = ".$client_id." \n";
    $sql .= "    AND \n";
    $sql .= "    shop_id = ".$shop_id." \n";
    $sql .= ";\n";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    $monthly_close_day = (pg_num_rows($result) == 0) ? $max_day : pg_fetch_result($result, 0, 0);

    if($close_day < $today && $monthly_close_day < $today){
        return true;
    }

    return false;

}

/**
 *
 * 日付が請求締処理以降かどうかをチェック
 *
 * @param       resource    $db_con     DB接続リソース
 * @param       int         $client_id  得意先ID 
 * @param       string      $y          チェックする日付の年
 *                          $m          チェックする日付の月
 *                          $d          チェックする日付の日
 *
 * @return      bool        true        請求締日より先
 *                          false       請求締日から前
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/09/20)
 *
 */
function Check_Bill_Close_Day($db_con, $client_id, $y, $m, $d){
/*
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(close_day), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "WHERE\n";
    //本部処理の場合
    if($_SESSION[shop_id] == 1){
        $sql .= "   t_bill.claim_id = (SELECT\n";
        $sql .= "                           claim_id\n";
        $sql .= "                       FROM\n";
        $sql .= "                           t_claim\n";
        $sql .= "                       WHERE\n";
        $sql .= "                           client_id = $client_id\n";
        $sql .= "                       )\n";
    //FC処理の場合
    }else{
        $sql .= "   t_bill.claim_id = $client_id\n";
    }

    $sql .= ";\n";
*/
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill_d \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $client_id";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $bill_close_day = pg_fetch_result($result, 0,0);

    //引数で渡された日付を結合
    $y = str_pad($y, 4, 0, STR_PAD_LEFT);
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    //抽出した日付が渡された日付より大きい場合はエラー
    if($bill_close_day >= $pram_date){
        return false;
    }
    return true;
}

/**
 *
 * 日付が仕入締処理以降かどうかをチェック
 *
 * @param       resource    $db_con     DB接続リソース
 * @param       int         $client_id  仕入先ID
 * @param       string      $y          チェックする日付の年
 *                          $m          チェックする日付の月
 *                          $d          チェックする日付の日
 * @param       int         $shop_id    ショップID
 *
 * @return      bool        true        仕入締日より先
 *                          false       仕入締日から前
 *
 * @author      watanabe-k <watanabe-k@bhsk.co.jp>
 * @version     1.0.0 (2006/09/20)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/05      xx-xxx      kajioka-h   shop_idを指定できるようにしました
 */
function Check_Payment_Close_Day($db_con, $client_id, $y, $m, $d, $shop_id=""){
    
    $sql  = "SELECT\n";
    $sql .= "   COALESCE(MAX(payment_close_day), '".START_DAY."') \n";
    $sql .= "FROM\n";
    $sql .= "   t_schedule_payment\n";
    $sql .= "WHERE\n";
    $sql .= "   client_id = $client_id\n";
    if($shop_id != ""){
        $sql .= "   AND \n";
        $sql .= "   shop_id = $shop_id \n";
    }
    $sql .= ";\n";
    $result = Db_Query($db_con, $sql);

    $payment_close_day = pg_fetch_result($result, 0,0);

//テストデータ
//$payment_close_day = '2006-09-01';

    //引数で渡された日付を結合
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    //抽出した日付が渡された日付より大きい場合はエラー
    if($payment_close_day >= $pram_date){
        return false;
    }
    return true;
}

/**
 *
 * 割賦金額、日付計算
 *
 * @param       resource    $db_con         DB接続リソース
 * @param       int         $client_id      取引先ID
 * @param       int         $total_money    価格
 * @param       int         $y              基準年（売上だと請求日の年、仕入だと仕入日の年）
 * @param       int         $m              基準月（売上だと請求日の月、仕入だと仕入日の月）
 * @param       int         $pay_out_div    1：売上  2：仕入
 * @param       int         $division_num   割賦回数
 *
 * @return      array       [0][0]             1回目の値段
 *                          [0][1]〜           2回目以降の値段
 *                          [1][0]             1回目の日付
 *                          [1][1]〜           2回目以降の日付
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/09/16)
 *
 */
function Division_Price($db_con, $client_id, $total_money, $y, $m, $pay_out_div=1, $division_num=2)
{

    //取引先の支払日（集金日）を取得
    if($pay_out_div == 1){
        $sql = "SELECT pay_m, pay_d FROM t_client WHERE client_id = $client_id;";
    }else{
        $sql = "SELECT payout_m, payout_d FROM t_client WHERE client_id = $client_id;";
    }
    $result = Db_Query($db_con, $sql);
    //$pay_m = (int)pg_fetch_result($result, 0, 0);
    $pay_m = date("m"); // 現在の月
    $pay_d = (int)pg_fetch_result($result, 0, 1);

    // 税込金額÷分割回数の商
    $division_quotient_price = bcdiv($total_money, $division_num);
    // 税込金額÷分割回数の余り
    $division_franct_price   = bcmod($total_money, $division_num);
    // 2回目以降の回収金額
    $second_over_price       = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
    // 1回目の回収金額
    $first_price             = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;

    // 金額が分割回数で割り切れる場合
    if ($division_franct_price == "0"){
        $first_price = $second_over_price = $division_quotient_price;
    }  

    for($i=0;$i<$division_num;$i++){
        //お金
        if($i==0){
            $price_array[0][0] = $first_price;
        }else{
            $price_array[0][$i] = $second_over_price;
        }

/*
        //日付
        //月末の場合
        if($pay_d == 29){
            $last_day = date("t", mktime(0, 0, 0, (int)$m + $pay_m + $i + 1, 1, (int)$y));
        }else{
            $last_day = $pay_d;
        }
        $price_array[1][$i] = date("Y-m-d", mktime(0, 0, 0, (int)$m + $pay_m + $i + 1 , $last_day, (int)$y));
*/

        // 分割支払日作成
        $date_y     = date("Y", mktime(0, 0, 0, $pay_m + $i, 1, $y));
        $date_m     = date("m", mktime(0, 0, 0, $pay_m + $i, 1, $y));
        $mktime_m   = ($pay_d == "29") ? $pay_m + $i + 1 : $pay_m + $i;
        $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
        $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $y));

        $price_array[1][$i] = date("Y-m-d", mktime(0, 0, 0, (int)$date_m, (int)$date_d, (int)$date_y));
    }

    return $price_array;
}


/**
 *
 * 日付がシステム開始日後かチェック
 *
 * @param       string      $y          チェックする日付の年
 *                          $m          チェックする日付の月
 *                          $d          チェックする日付の日
 *                          $label      エラーメッセージに出力する名前
 *
 * @return      str                     エラーメッセージ
 *
 * @author      ふ
 * @version     1.0.0 (2006/10/04)
 *
 */
function Sys_Start_Date_Chk($y, $m, $d, $label){

    // 全て入力かつ全て数値の場合
    if (($y != null && $m != null && $d != null) && (ereg("^[0-9]+$", $y) && ereg("^[0-9]+$", $m) && ereg("^[0-9]+$", $d))){
        // 0埋め
        $y = str_pad($y, 4, "0", STR_PAD_LEFT);
        $m = str_pad($m, 2, "0", STR_PAD_LEFT);
        $d = str_pad($d, 2, "0", STR_PAD_LEFT);
        // システム開始日の分割（エラーメッセージ用）
        $ary_sys_date = explode("-", START_DAY);
        // システム開始日前後の判定
        if ($y."-".$m."-".$d < START_DAY){
            return "$label に".(int)$ary_sys_date[0]."年".(int)$ary_sys_date[1]."月".(int)$ary_sys_date[2]."日より前の日付は入力できません。";
        }else{
            return;
        }
    }else{
        return;
    }

}

/**
 *
 * 該当するテーブルの該当レコードが存在しているか判定する
 * 
 * @param       resource    $db_con         DB接続リソース
 *                          $table          talbe名
 *                          $column         カラム名
 *                          $p_id           プライマリキー
 *                          $enter_day      登録日  
 *
 * @return      boolean     true            存在する場合
 *                          false           存在しない場合
 * @autor       こうじ
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Update_Check($db_con, $table, $column, $p_id, $enter_day){

    //登録日とプライマリキーをキーとしてレコード数をカウント
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   enter_day = '".$enter_day."' ";
    $sql .= "AND ";
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //該当レコードがある場合
    if($row_num > 0){
        return true;
    //該当レコードがない場合
    }else{
        return false;
    }
}

/**
 *
 * 該当するテーブルの該当レコードが日次更新されているか判定する
 * 
 * @param       resource    $db_con         DB接続リソース
 *                          $table          talbe名
 *                          $column         カラム名
 *                          $p_id           プライマリキー
 *
 * @return      boolean     true            日次更新未実施の場合（OKな場合）
 *                          false           日次更新実施済の場合（NGの場合）
 * @autor       ふ
 * @version     1.00 (2006/10/30)
 *
**/
function Renew_Check($db_con, $table, $column, $p_id){

    //登録日とプライマリキーをキーとしてレコード数をカウント
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   ".$column." = $p_id ";
    $sql .= "AND ";
    $sql .= "   renew_flg = 'f' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //該当レコードがある場合
    if($row_num > 0){
        return true;
    //該当レコードがない場合
    }else{
        return false;
    }

}

/**
 * 概要　日付の妥当性をチェックします。
 *
 * 説明　この関数はHTML_QuickFormのregisterRuleでの利用を前提に作成しています。
 *     　そのため、不要な引数がいくつか存在します。
 *
 * @param string    $val1   不要
 * @param string    $val2   不要
 * @param array     $date   チェックする日付（年、月、日の順）
 *
 * @return boolean          妥当でない日付の場合はfalseを返します。
 */
//日付チェック関数を追加
function Check_Date($val1, $val2, $date){

    //日付を取得
    $yy = array_shift($date);
    $mm = array_shift($date);
    $dd = array_shift($date);
    
    //日付が入力されていない場合はチェックしない。
    if($yy == "" && $mm == "" && $dd == ""){
        return true;
    }

    //数値チェック
    if (!preg_match("/^[0-9]+$/", $yy)) {
        return false;
    }

    if (!preg_match("/^[0-9]+$/", $mm)) {
        return false;
    }

    if (!preg_match("/^[0-9]+$/", $dd)) {
        return false;
    }

    //日付チェック実施
    if(checkdate($mm,$dd,$yy)){
      return true;
    }else{
        return false;
    }
    
} 


/**
 * 概要　HTML_QuickFormを利用して日付の入力フォームを作成します。
 *
 * 説明　年・月・日のフォーム名が指定されない場合、y・m・dとなります。 
 *
 * @param object    $form      HTML_QuickFormオブジェクト
 * @param string    $form_name HTMLでのフォーム名
 * @param string    $label     表示名
 * @param string    $ifs       区切り文字
 * @param string    $yy        年のフォーム名
 * @param string    $mm        月のフォーム名
 * @param string    $dd        日のフォーム名
 *
 */
function Addelement_Date($form, $form_name, $label="", $ifs="", $yy="y", $mm="m", $dd="d",$option=""){

    //年と月のフォーム名（自動フォーカスのために使用）
    $form_y = "$form_name"."[".$yy."]";
    $form_m = "$form_name"."[".$mm."]";
    $form_d = "$form_name"."[".$dd."]";

    //年
    $form_option = "class=\"ime_disabled\"".$option;
    $form_data[] =& $form->createElement("text", "$yy", "", "
    size=\"4\" maxLength=\"4\" 
    onkeyup=\"changeText(this.form,'$form_y', '$form_m', '4')\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\"
    $form_option
    ");

    //月
    $form_data[] =& $form->createElement("text", "$mm", "", "
    size=\"1\" maxLength=\"2\" 
    onkeyup=\"changeText(this.form,'$form_m', '$form_d', '2')\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\" 
    $form_option"
    );

    //日
    $form_data[] =& $form->createElement("text", "$dd", "", "
    size=\"1\" maxLength=\"2\" 
    onKeyDown=\"chgKeycode();\" 
    onfocus=\"onForm_today(this,this.form,'$form_y','$form_m','$form_d')\" 
    onBlur=\"blurForm(this)\" 
    $form_option"
    );
    
    $obj = $form->addGroup($form_data, $form_name, $label, $ifs);  

    return $obj;
}





/**
 *
 * 受注・売上エラーチェック関数
 * 
 * @param       int         $goods_id       商品ID
 *              string      $goods_cd       商品コード
 *              string      $goods_name     商品名
 *              int         $num            数量
 *              int         $price          単価  
 *              int         $amount         金額  
 *              string      $del_row        削除履歴    
 *              int         $max_row        最大行数
 *              string      $type           区分
 *              
 *
 * @return      array       $return_array   結果配列
 *              
 * @autor       こうじ
 * @version     1.00 (2006/10/07)
 *
 *
 * 2009/09/04   aoyama-n    値引き金額が入力できるようにマイナス値を許可
 * 2009/09/16   kajioka-h   受注入力オフライン時に数量チェックしないように変更
 *
**/
function Row_Data_Check2($check_ary){

    //引数として渡された配列の用ををそれぞれ変数にデータを格納
    $goods_id       = $check_ary[0];            //商品ID
    $goods_cd       = $check_ary[1];            //商品コード
    $goods_name     = $check_ary[2];            //商品名
    $sale_num       = $check_ary[3];            //受注数・出荷数
    $cost_price     = $check_ary[4];            //原価単価
    $sale_price     = $check_ary[5];            //売上単価
    $cost_amount    = $check_ary[6];            //原価金額
    $sale_amount    = $check_ary[7];            //売上金額
    $tax_div        = $check_ary[8];            //課税区分
    $del_row        = $check_ary[9];            //削除履歴
    $max_row        = $check_ary[10];           //最大行数
    $type           = $check_ary[11];           //受注・売上区分
    $db_con         = $check_ary[12];           //DBコネクション
    $aord_num       = $check_ary[13];           //受注数
    $royalty        = $check_ary[14];           //ロイヤリティ
    //aoyama-n 2009-09-04
    $discount_flg   = $check_ary[15];           //値引フラグ


    //エラーメッセージ判定
    //if($type == 'aord'){
	//rev.1.2 kajioka-h 2009/09/16
    if($type == 'aord' || $type == 'aord_offline'){
        $type_name = "受注";
    }elseif($type == 'sale'){
        $type_name = "出荷";
    }

    //行数
    $line = 0;
    //登録データ配列キー
    $j = 0;

    //表示行数分ループ
    for($i = 0; $i < $max_row; $i++){

        //削除行を処理対処外とする
        if(!in_array("$i", $del_row)){

            //チェックする行NO
            $line = $line+1;

            //商品入力チェック
            if($goods_cd[$i] != null){

                if(ereg("^[0-9]+$",$goods_cd[$i]) && $goods_id[$i] != null){

                    $goods_id[$i] = ($goods_id[$i] != null)? $goods_id[$i] : "null";

                    //登録ボタン押下前に商品コードが変更されていないかチェック
                    $sql  = "SELECT";
                    $sql .= "   COUNT(goods_id) ";
                    $sql .= "FROM";
                    $sql .= "   t_goods ";
                    $sql .= "WHERE";
                    $sql .= "   goods_id =  $goods_id[$i]";
                    $sql .= "   AND";
                    $sql .= "   goods_cd = '$goods_cd[$i]'";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    $count = pg_fetch_result($result, 0,0);

                    $input_flg[$i] = true;
                    //違っていた場合
                    if($count != 1){
                        $goods_err[$i] = $line."行目　商品情報取得前に ".$type_name."確認画面へボタンが押されました。<br>操作をやり直してください。";
                        $err_flg[$i] = true;
                    }

                }else{
                    $goods_err[$i] = $line."行目　正しい商品コードを入力して下さい。";
                    $err_flg[$i] = true;
                    continue;
                }

            }else{
                $input_flg[$i] = false;
            }

            //商品が入力されている場合
            if($input_flg[$i] == true){

                //数量と仕入単価に入力があるか
                //if($sale_num[$i] == null || $cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null){
				//rev.1.2 kajioka-h 2009/09/16
                if(($type != 'aord_offline' && ($sale_num[$i] == null || $cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null)) ||
				   ($type == 'aord_offline' && ($cost_price[$i]["i"] == null || $sale_price[$i]["i"] == null))
				){
					if($type != 'aord_offline'){
	                    $price_num_err[$i] = $line."行目　".$type_name."入力に".$type_name."数と原価単価と売上単価は必須です。";
					}else{
	                    $price_num_err[$i] = $line."行目　".$type_name."入力に原価単価と売上単価は必須です。";
					}

                    $err_flg[$i] = true;
                    continue;

                //数量と仕入単価に入力がある場合
                }else{
					if($type != 'aord_offline'){
                    	//数量数半角数字チェック
                    	if(!ereg("^[0-9]+$",$sale_num[$i]) || ($sale_num[$i] == null || $sale_num[$i] == 0)){
                        	$num_err[$i] = $line."行目　".$type_name."数は半角数字のみ入力可能です。";
                        	$err_flg[$i] = true;
                    	}
					}

                    //aoyama-n 2009-09-04
                    /**************
                    //受注の場合
                    if($type == aord){

                        //原価半角数字チェック
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."行目　原価単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }

                        //売上半角数字チェック
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."行目　売上単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }
                    //売上の場合
                    }else{
                        //原価半角数字チェック
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."行目　原価単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }

                        //売上半角数字チェック
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."行目　売上単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }
                        

                    }
                    **************/
                    //値引商品のチェック
                    if($discount_flg[$i] === 't'){ 
                        //原価半角数字チェック
                        if(($cost_price[$i]["i"] != null && !ereg("^[-0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."行目　原価単価は「-」と半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }elseif ($cost_price[$i]["i"] > 0 ){
                            $cost_price_err[$i] = $line."行目　商品に値引を指定した場合、原価単価は０以下の数値のみ入力可能です。";
                            $err_flg[$i] = true;
                        }

                        //売上半角数字チェック
                        if(($sale_price[$i]["i"] != null && !ereg("^[-0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."行目　売上単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }elseif($sale_price[$i]["i"] > 0 ){
                            $sale_price_err[$i] = $line."行目　商品に値引を指定した場合、売上単価は０以下の数値のみ入力可能です。";
                            $err_flg[$i] = true;
                        }
                    //値引商品以外のチェック
                    }else{
                        //原価半角数字チェック
                        if(($cost_price[$i]["i"] != null && !ereg("^[0-9]+$",$cost_price[$i]["i"])) 
                            || 
                            ($cost_price[$i]["d"] != null && !ereg("^[0-9]+$",$cost_price[$i]["d"]))
                        ){
                            $cost_price_err[$i] = $line."行目　原価単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }

                        //売上半角数字チェック
                        if(($sale_price[$i]["i"] != null && !ereg("^[0-9]+$",$sale_price[$i]["i"])) 
                            || 
                            ($sale_price[$i]["d"] != null && !ereg("^[0-9]+$",$sale_price[$i]["d"]))
                        ){
                            $sale_price_err[$i] = $line."行目　売上単価は半角数字のみ入力可能です。";
                            $err_flg[$i] = true;
                        }
                    }

                }

                //登録データ配列
                $add_data[goods_id][$j]     = $goods_id[$i];                                        //商品ID              
                $add_data[goods_cd][$j]     = $goods_cd[$i];                                        //商品CD              
                $add_data[goods_name][$j]   = $goods_name[$i];                                      //商品名           
                $add_data[sale_num][$j]     = $sale_num[$i];                                        //数量             
                $add_data[cost_price][$j]   = $cost_price[$i][i].".".$cost_price[$i][d];            //原価単価
                $add_data[sale_price][$j]   = $sale_price[$i][i].".".$sale_price[$i][d];            //売上単価
                $add_data[cost_amount][$j]  = str_replace(',','',$cost_amount[$i]);                 //原価金額
                $add_data[sale_amount][$j]  = str_replace(',','',$sale_amount[$i]);                 //売上金額
                $add_data[tax_div][$j]      = $tax_div[$i];                                         //課税区分              
                $add_data[aord_num][$j]     = $aord_num[$i];                                        //数量             
                $add_data[royalty][$j]      = $royalty[$i];                                         //ロイヤリティ            
                $add_data[def_line][$j]     = $line;
                //登録カウンタ
                $j++;

            //商品が選択されていないのに、数量、単価のいずれかに入力がある場合
            }elseif(($goods_cd[$i] == null 
                    || 
                    $goods_name[$i] == null)
                    && 
                    ($sale_price[$i]["i"] != null 
                    || 
                    $sale_price[$i]["d"] != null
                    ||
                    $cost_price[$i]["i"] != null
                    ||
                    $cost_price[$i]["d"] != null
                    ||
                    $sale_num[$i] != null)
            ){
                $price_num_err[$i] = $line."行目　商品を選択して下さい。";
                $err_flg[$i] = true;
                $err_input_flg = true;
                continue;
            }
        }
    }

    //商品入力がない場合
    if(!@in_array(true, $input_flg) && $err_input_flg != true){
        $no_goods_err = "商品が一つも選択されていません。";
        $err_flg[] = true;
    }

    //エラーがあった場合
    if(@in_array(true, $err_flg)){
        $return_array = array(true, $no_goods_err, $goods_err, $price_num_err, $num_err, $cost_price_err, $sale_price_err);
    }else{
        $return_array = array(false, $add_data);
    }

    return $return_array;
}

/**
 * 概要　チェックボックスの全チェックを行なうjavascriptを作成します。
 *
 * 説明　HTML_QuickFormのadvcheckboxで作成されたチェックボックス用の関数です。
 *
 * 履歴　????/??/??　新規作成　<morita-d>
 * 　　　2007/01/30　通常のチェックボックスにも対応するように変更　<watanabe-k>
 *
 * @param string    $function_name   javascriptの関数名
 * @param string    $name            全チェックするチェックボックス名
 *
 * @return string          全チェックのjavascript
 */
function Create_Allcheck_Js ($function_name, $name, $data, $type=null) {

  if (is_array($data)) {
        while ($val = each($data)) {

            $line        = $val[0];
            $bill_id     = $val[1];

            //通常のチェックボックスの場合
            if($type == '1'){
                $f_name_val  = $name."[".$bill_id."]";

                $js_parts1 .= "         document.forms[0].elements[\"$f_name_val\"].checked = true; \n";
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_val\"].checked = false; \n";

            //advcheckboxの場合
            }else{
                $f_name_val  = $name."[".$line."]";
                $f_name_chk  = "__".$name."[".$line."]";

                $js_parts1 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"$bill_id\";\n ";
                $js_parts1 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = true; \n";
                
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"f\";\n ";
                $js_parts2 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = false; \n";
            }

        }       
    }
    $javascript = "
    function $function_name (all_name) {
        var ALL = all_name;
        if(document.forms[0].elements[ALL].checked == true){
            $js_parts1
        }else{
            $js_parts2
        }
    }
    ";

    return $javascript;
}


/**
 * 概要 数値をカンマ区切りに変換します。
 *
 * 説明 マイナス数値が与えられた場合、赤文字で表示します。
 *
 * @param integer     $int   数値
 * 
 * @return string HTMLデータ
 *
 */
function Minus_Numformat ($int) {

	if ($int < 0) {
		$int = "<font color=\"red\">".number_format($int)."</font>";
	} else {
		$int = number_format($int);
	}

	return $int;
}

/**
 *
 * 該当するテーブルの該当レコードが変更されているか確認する
 * 
 * @param       resource    $db_con         DB接続リソース
 *                          $table          talbe名 
 *                          $column         カラム名
 *                          $p_id           プライマリキー
 *
 * @return      boolean     true            存在する場合
 *                          false           存在しない場合
 * @autor       こうじ  
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Finish_Check($db_con, $table, $column, $p_id){

    //登録日とプライマリキーをキーとしてレコード数をカウント
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   ps_stat = '1'";
    $sql .= " AND "; 
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //該当レコードがある場合
    if($row_num > 0){
        return true;
    //該当レコードがない場合
    }else{  
        return false;
    }
}

/**
 *
 * 該当するテーブルの該当レコードが変更されているか確認する * 
 * @param       resource    $db_con         DB接続リソース
 *                          $table          talbe名 
 *                          $column         カラム名
 *                          $p_id           プライマリキー
 *                          $change_day     プライマリキー
 *
 * @return      boolean     true            存在する場合
 *                          false           存在しない場合
 * @autor       こうじ  
 * @version     1.00 (2006/10/07)
 *
 *
 *
**/
function Update_Data_Check($db_con, $table, $column, $p_id, $change_day){ 

    //登録日とプライマリキーをキーとしてレコード数をカウント
    $sql  = "SELECT ";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   ".$table." ";
    $sql .= "WHERE ";
    $sql .= "   change_day = '$change_day'"; 
    $sql .= " AND ";  
    $sql .= "   ".$column." = $p_id ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $row_num = pg_fetch_result($result ,0,0);

    //該当レコードがある場合
    if($row_num > 0){
        return true;
    //該当レコードがない場合
    }else{  
        return false;
    }
}


/**
 * メール送信関数
 *
 * 変更履歴
 * 1.0.0 (2006/11/17) 新規作成(suzuki-t)
 *
 * @version     1.0.0 (2006/11/17)
 *
 * @param               string      $mail_flg     通知判定 
 * @param               string      $address      アドレス 
 * @param               string      $subject      件名   
 * @param               string      $contents     本文   
 *                                  
 *
 *                                  
 */
function Error_send_mail($mail_flg,$address,$subject,$contents){ 

	//通知判定
	if($mail_flg == true){
	    //言語の指定と内部エンコーディング
		mb_language("Ja"); 
		mb_internal_encoding("EUC");
		mb_send_mail($address,$subject,$contents);
	}
}


/**
 * 拠点倉庫抽出関数
 *
 *
 * 変更履歴
 * 1.0.0 (2007/02/21) 新規作成 （watanabe-k）
 *
 * @version     1.0.0(2007/02/21)
 *
 * @param                         $db_con        リソース
 * @param                         $branch_id     支店ID
 *
 *
 *
 *
 */
function Get_Ware_Id($db_con, $branch_id){

    $sql  = "SELECT \n";
    $sql .= "   bases_ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_branch \n";
    $sql .= "WHERE \n";
    $sql .= "   branch_id = $branch_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $num = pg_num_rows($result);

    if($num != 0){
        $ware_id = pg_fetch_result($result, 0,0);
        return $ware_id;
    }else{
        return ;
    }
}

/**
 * スタッフの担当倉庫抽出関数
 *
 *
 * 変更履歴
 * 1.0.0 (2007/03/01) 新規作成 （kj）
 *
 * @version     1.0.0(2007/03/01)
 *
 * @param                         $db_con        リソース
 * @param                         $staff_id      スタッフID
 *                                              （指定しない場合はログイン者のIDとなる）
 *
 * @return      int     成功：倉庫ID
 *                      失敗：ぬる
 *
 */
function Get_Staff_Ware_Id($db_con, $staff_id = null){

    $sql  = "SELECT \n";
    $sql .= "   ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "WHERE \n";
    if($staff_id == null){
        $sql .= "   staff_id = ".$_SESSION["staff_id"]." \n";
    }else{
        $sql .= "   staff_id = $staff_id \n";
    }
    $sql .= "   AND \n";
    $sql .= "   h_staff_flg = false \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $num = pg_num_rows($result);

    if($num != 0){
        $ware_id = pg_fetch_result($result, 0,0);
        return $ware_id;
    }else{
        return ;
    }
}

/**
 * 支店抽出関数
 *
 *
 * 変更履歴
 * 1.0.0 (2007/02/21) 新規作成 （watanabe-k）
 * 1.1.0 (2007/02/27) スタッフIDを指定可能に （watanabe-k）
 *
 * @version     1.0.0(2007/02/21)
 *
 * @param                         $db_con        リソース
 * @param                         $staff_id      スタッフID
 *                                              （指定しない場合はログイン者のIDとなる）
 *
 *
 */
function Get_Branch_Id($db_con, $staff_id = null){

    $sql  = "SELECT ";
    $sql .= "   branch_id ";
    $sql .= "FROM ";
    $sql .= "   t_attach ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_part";
    $sql .= "   ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    if($staff_id == null){
        $sql .= "   t_attach.staff_id = ".$_SESSION["staff_id"]." ";
    }else{
        $sql .= "   t_attach.staff_id = $staff_id ";
    }
    $sql .= "   AND";
    $sql .= "   t_attach.h_staff_flg = 'f' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    $ware_id = pg_fetch_result($result, 0,0);
    return $ware_id;
}


/**
 * 概要 主キーを生成します
 *
 * 説明 主キーの生成にはマイクロタイムを利用します。
 *
 * @return integer         主キー
 */
function Get_Pkey(){
    $microtime   = explode(" ",microtime());
    $pkey = $microtime[1].substr("$microtime[0]", 2, 6);

    return $pkey;
}


/**
 * 概要     モジュール番号取得関数
 *
 * 説明     自画面のモジュール番号を取得する
 *
 * @param   N/A
 *
 * @return  $module_no      自画面のモジュール番号(../DIR/MODULE.php)
 */
function Get_Mod_No(){

    $explode_url    = explode("/", $_SERVER["PHP_SELF"]);
    $count          = count($explode_url);
    $module_no      = "../".$explode_url[$count-2]."/".$explode_url[$count-1];

    // モジュール番号を返す
    return $module_no;

}


/**
 * 概要     再遷移先として自モジュールをSESSIONにセット
 *
 * 説明     検索条件復元関連
 *
 * @param   $type           自画面が属する分類（受注、売上、発注、仕入、入金、支払、契約、請求）
 *                          複数の分類に属している場合は配列で記述（例. 発注残は発注伝票変更と仕入入力が行えるので発注と仕入に属する）
 *          $search_flg     検索条件を復元させるモジュールの場合はtrueを指定する
 *
 * @return  void
 */
function Set_Rtn_Page($type, $search_flg = null){

    // 自画面の本部/FCタイプ取得
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    // 分類が配列の場合
    if (is_array($type) == true){
        // それぞれの分類のSESSIONにセット
        foreach ($type as $key => $value){
            $_SESSION[$hf][$value]["return_page"]["page"]   = Get_Mod_No();
            $_SESSION[$hf][$value]["return_page"]["get"]    = ($search_flg == true) ? "?search=1" : "";
        }
    // 分類が配列でない場合
    }else{
        // 指定された分類のSESSIONにセット
        $_SESSION[$hf][$type]["return_page"]["page"]    = Get_Mod_No();
        $_SESSION[$hf][$type]["return_page"]["get"]     = ($search_flg == true) ? "?search=1" : "";
    }

}


/**
 * 概要     SESSIONの指定されたキーに入っている再遷移先を返す
 *
 * 説明     完了画面のOKボタン、明細画面の戻るボタンなどの遷移先に使用
 *
 * @param   $type           自画面が属する分類（受注、売上、発注、仕入、入金、支払、契約、請求）
 *          $search_flg     検索条件を復元させるモジュールの場合はtrueを指定する
 *
 * @return  void
 */
function Make_Rtn_Page($type){

    // 自画面の本部/FCタイプ取得
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    return $_SESSION[$hf][$type]["return_page"]["page"].$_SESSION[$hf][$type]["return_page"]["get"];

}


/**
 * 概要     検索条件復元処理
 *
 * 説明     検索条件を復元させたい照会画面で必ず参照させる
 *
 * @param   $form           フォームオブジェクト
 *          $type           自画面が属する分類を配列で記述（受注、売上、発注、仕入、入金、支払、契約、請求）
 *                          （例. 発注残一覧は発注伝票変更と仕入入力が行えるので発注と仕入に属する -> array("ord", "sale") ）
 *                          入金照会のように1つしか属していない場合は配列にしなくてもOKです
 *          $disp_btn       「表示」ボタンの名前
 *          $ary_form_list  検索項目と初期値のリスト
 *          $ary_pass_list  検索条件復元時、ページ数切り替え時にセットするPOSTデータリスト（配列になっているフォームは未対応）
 *
 * @return  void
 */
function Restore_Filter2($form, $type, $disp_btn, $ary_form_list, $ary_pass_list = null){

    // ページ切り替えフラグセット用hidden
    $form->addElement("hidden", "switch_page_flg");

    // 自画面のモジュール番号取得
    $module_no = Get_Mod_No();

    // ソート順をセッションにセット（常時）
    if ($_POST["hdn_sort_col"] != null){
        $_SESSION[$module_no]["all"]["hdn_sort_col"]    = $_POST["hdn_sort_col"];
        $_SESSION[$module_no]["search"]["hdn_sort_col"] = $_POST["hdn_sort_col"];
    }

    // 自画面の本部/FCタイプ取得
    $hf = ($_SESSION["group_kind"] == "1") ? "h" : "f";

    // 再遷移先SESSIONに自モジュールがあるか調べる
    // あれば$return_flgにtrueをセット
    if (is_array($type) == true){
        foreach ($type as $key => $value){
            if ($_SESSION[$hf][$value]["return_page"]["page"] == $module_no){
                $return_flg = true;
                break;
            }
        }
    }else{
        $return_flg = ($_SESSION[$hf][$type]["return_page"]["page"] == $module_no) ? true : false;
    }

    // 再遷移時（再遷移先SESSIONに自モジュールがある＋検索GETがある場合）
    if ($return_flg == true && $_GET["search"] == "1"){

        // 検索条件SESSION(all)をPOSTに代入
        $_POST = $_SESSION[$module_no]["all"];

        // 検索条件復元除外リストでループ
        if (count($ary_pass_list) > 0){
            foreach ($ary_pass_list as $key => $value){
                // フォームのPOSTを検索条件復元除外リストの値で上書き
                $_POST[$key] = $value;
            }
        }

        // $_POSTがあれば、フォームセット用に値をstripslashes
        $ss_to_form = (count($_POST) > 0) ? Ary_Foreach($_POST, "stripslashes") : null;

        // 値をフォームにセット
        $form->setConstants($ss_to_form);

    // ページ切り替え・自画面POST時（表示ボタン未押下＋表示ボタン以外のPOSTがある）
    }elseif ($_POST[$disp_btn] == null && $_POST != null){

        // 検索条件SESSION(hidden)がある場合
        if (count($_SESSION[$module_no]["search"]) > 0){

            // 検索条件SESSION(hidden)をPOSTとフォームセット用配列に代入
            foreach ($_SESSION[$module_no]["search"] as $key => $value){
                $_POST[$key]        = $value; 
                $ss_to_form[$key]   = $value; 
            }

            // 出力形式が「帳票」「CSV」の場合
            if ($_POST["form_output_type"] == "2" || $_POST["form_output_type"] == "3"){
                // 出力形式のPOST値を「画面」にセット
                $_POST["form_output_type"]      = "1";
                $ss_to_form["form_output_type"] = "1";
            }

            // フォームセット用に値をstripslashes
            $ss_to_form = Ary_Foreach($ss_to_form, "stripslashes");
            $form->setConstants($ss_to_form);

        // 検索条件SESSION(hidden)がない場合
        }else{  

            // 検索条件初期値をPOSTとフォームセット用配列に代入
            foreach ($ary_form_list as $key => $value){
                $_POST[$key] = $def_to_form[$key] = $value; 
            }
            $form->setConstants($def_to_form);

        }

        // POSTされたページ数をSESSION(all)にセット
        // 再遷移時のページ数復元に使用
        Post_To_Session($ary_form_list, "page");

        // ページ切り替えフラグをクリア
        $clear_hdn["switch_page_flg"] = "";
        $form->setConstants($clear_hdn);

    // 表示ボタン押下時
    }elseif ($_POST[$disp_btn] != null){

        // 検索項目のPOSTをSESSION(all)にセット
        // 再遷移時の検索条件復元に使用
        Post_To_Session($ary_form_list);

        // 検索項目のPOSTをSESSION(hidden)にセット
        // ページ切り替え時、自画面POST時の検索条件復元に使用
        Post_To_Session($ary_form_list, "search");

        // ページ数POSTをアンセット（1ページ目を表示させるため）
        unset($_POST["f_page1"]);
        unset($_POST["f_page2"]);

    }

    // POSTがない＋GETが無い場合
    if ($_POST == null && $_GET["search"] == null){
        // SESSION破棄
        $_SESSION[$module_no] = null;
    }

    // 最遷移先として自モジュールをSESSIONにセット
    Set_Rtn_Page($type, true);

}


/**
 * 概要     検索条件復元処理
 *
 * 説明     検索条件を復元させたい照会画面で必ず参照させる
 *
 * @param   $form           フォームオブジェクト
 *          $disp_btn       「表示」ボタンの名前
 *          $ary_form_list  検索項目と初期値のリスト
 *          $ary_pass_list  検索条件復元の除外POST名リスト（配列になっているフォームは未対応）
 *
 * @return  void
 */
function Restore_Filter($form, $disp_btn, $ary_form_list, $ary_pass_list = null){

    // ページ切り替えフラグセット用hidden
    $form->addElement("hidden", "switch_page_flg");

    // 自画面のモジュール番号取得
    $module_no = Get_Mod_No();

    // 再遷移時（再遷移先が自画面＋検索GETがある場合）
    if ($module_no == $_SESSION["return_page"]["page"] && $_GET["search"] == "1"){

        // 検索条件SESSION(all)をPOSTに代入
        $_POST = $_SESSION[$module_no]["all"];

        // 検索条件復元除外リストでループ
        if (count($ary_pass_list) > 0){
            foreach ($ary_pass_list as $key => $value){
                // フォームのPOSTを検索条件復元除外リストの値で上書き
                $_POST[$key] = $value;
            }
        }

        // $_POSTがあれば、フォームセット用に値をstripslashes
        $ss_to_form = (count($_POST) > 0) ? Ary_Foreach($_POST, "stripslashes") : null;

        // 値をフォームにセット
        $form->setConstants($ss_to_form);

    // ページ切り替え・自画面POST時（表示ボタン未押下＋表示ボタン以外のPOSTがある）
    }elseif ($_POST[$disp_btn] == null && $_POST != null){

        // 検索条件SESSION(hidden)がある場合
        if (count($_SESSION[$module_no]["search"]) > 0){

            // 検索条件SESSION(hidden)をPOSTとフォームセット用配列に代入
            foreach ($_SESSION[$module_no]["search"] as $key => $value){
                $_POST[$key]        = $value; 
                $ss_to_form[$key]   = $value; 
            }
            // フォームセット用に値をstripslashes
            $ss_to_form = Ary_Foreach($ss_to_form, "stripslashes");
            $form->setConstants($ss_to_form);

        // 検索条件SESSION(hidden)がない場合
        }else{  

            // 検索条件初期値をPOSTとフォームセット用配列に代入
            foreach ($ary_form_list as $key => $value){
                $_POST[$key] = $def_to_form[$key] = $value; 
            }       
            $form->setConstants($def_to_form);

        }

        // POSTされたページ数をSESSION(all)にセット
        // 再遷移時のページ数復元に使用
        Post_To_Session($ary_form_list, "page");

        // ページ切り替えフラグをクリア
        $clear_hdn["switch_page_flg"] = "";
        $form->setConstants($clear_hdn);

    // 表示ボタン押下時
    }elseif ($_POST[$disp_btn] != null){

        // 検索項目のPOSTをSESSION(all)にセット
        // 再遷移時の検索条件復元に使用
        Post_To_Session($ary_form_list);

        // 検索項目のPOSTをSESSION(hidden)にセット
        // ページ切り替え時、自画面POST時の検索条件復元に使用
        Post_To_Session($ary_form_list, "search");

        // ページ数POSTをアンセット（1ページ目を表示させるため）
        unset($_POST["f_page1"]);
        unset($_POST["f_page2"]);

    }

    // POSTがない＋GETが無い場合
    if ($_POST == null && $_GET["search"] == null){
        // SESSION破棄
        $_SESSION[$module_no] = null;
    }

    // 再遷移先として自モジュール番号とGETに付加する文字列をSESSIONにセット
    $_SESSION["return_page"]["page"]  = "$module_no";
    $_SESSION["return_page"]["get"]   = "?search=1";

}


/**
 * 概要     POSTをSESSIONにセット
 *
 * 説明     ポストをセッションにSET
 *
 * @param   $ary_form_list  検索項目と初期値の配列
 *          $type           SESSIONにセットするパターンの識別子
 *                          null:POST全て search:検索項目のPOSTのみ  page:ページ数のPOSTのみ
 *
 * @return  void
 */
function Post_To_Session($ary_form_list, $type = null){

    // 自画面のモジュール番号取得
    $module_no = Get_Mod_No();

    if ($type == null){

        // 全てのPOSTをSESSIONにセット
        // 表示ボタン押下時に行う
        // 再遷移時の検索条件復元に使用
        $_SESSION[$module_no]["all"] = $_POST;

    }elseif ($type == "search"){

        // 検索項目のPOSTをSESSIONにセット
        // 表示ボタン押下時に行う
        // ページ切り替え時、自画面POST時の検索条件復元に使用
        foreach ($ary_form_list as $key => $value){
            $_SESSION[$module_no]["search"][$key] = $_POST[$key];
        }

    }elseif ($type == "page"){

        // ページ数のみSESSIONにセット
        // ページ切り替え時に行う（POSTされたページ数のみSESSIONに保持させるため）
        // 再遷移時のページ数復元に使用
        $_SESSION[$module_no]["all"]["f_page1"] = $_POST["f_page1"];
        $_SESSION[$module_no]["all"]["f_page2"] = $_POST["f_page2"];

    }

}


/**
 * 概要     HTML_QuickFormを利用して日付の入力フォームを作成（範囲）
 *
 * 説明     年・月・日のフォーム名が指定されない場合、y, m, dとなります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $ifs        区切り文字
 * @param string    $yy         年のフォーム名
 * @param string    $mm         月のフォーム名
 * @param string    $dd         日のフォーム名
 *
 */
function Addelement_Date_Range($form, $form_name, $label = "", $ifs = "", $yy = "y", $mm = "m", $dd = "d", $option = ""){

    // js用フォーム名
    $form_sy    = "$form_name"."[s".$yy."]";
    $form_sm    = "$form_name"."[s".$mm."]";
    $form_sd    = "$form_name"."[s".$dd."]";
    $form_ey    = "$form_name"."[e".$yy."]";
    $form_em    = "$form_name"."[e".$mm."]";
    $form_ed    = "$form_name"."[e".$dd."]";

    // 属性とjs
    $sizelen_y  = "size=\"4\" maxLength=\"4\" ";
    $sizelen_md = "size=\"1\" maxLength=\"2\" ";
    $onfocus_s  = "onfocus=\"onForm_today(this, this.form, '$form_sy', '$form_sm', '$form_sd');\" ";
    $onfocus_e  = "onfocus=\"onForm_today(this, this.form, '$form_ey', '$form_em', '$form_ed');\" ";
    $onblur     = "onBlur=\"blurForm(this);\" ";
    $onkeydown  = "onKeyDown=\"chgKeycode();\" ";
    $form_option= "class=\"ime_disabled\" ".$option;

    $obj = null; 

    // 年（開始）
    $obj[] =& $form->createElement("text", "s$yy", "", "
        onkeyup=\"changeText(this.form, '$form_sy', '$form_sm', '4');\"
        $sizelen_y $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // 月（開始）
    $obj[] =& $form->createElement("text", "s$mm", "", "
        onkeyup=\"changeText(this.form, '$form_sm', '$form_sd', '2');\"
        $sizelen_md $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // 日（開始）
    $obj[] =& $form->createElement("text", "s$dd", "", "
        onkeyup=\"changeText(this.form, '$form_sd', '$form_ey', '2');\"
        $sizelen_md $onfocus_s $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", "〜");
    // 年（終了）
    $obj[] =& $form->createElement("text", "e$yy", "", "
        onkeyup=\"changeText(this.form, '$form_ey', '$form_em', '4');\"
        $sizelen_y $onfocus_e $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // 月（終了）
    $obj[] =& $form->createElement("text", "e$mm", "", "
        onkeyup=\"changeText(this.form, '$form_em', '$form_ed', '2');\"
        $sizelen_md $onfocus_e $onblur $onkeydown $form_option
    ");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    // 日（終了）
    $obj[] =& $form->createElement("text", "e$dd", "", "
        $sizelen_md $onfocus_e $onblur $onkeydown $form_option
    ");

    $gr_obj = $form->addGroup($obj, $form_name, $label, "");  

    return $gr_obj;

}


/**
 * 概要     日付POST値の0埋め
 *
 * 説明     年月日の日付POSTデータを0埋めして返す（nullはnullで返す）
 *
 * @param   array   $ary_post_date      y, m, dの配列
 *
 */
function Str_Pad_Date($ary_post_date){

    // 配列の場合
    if (count($ary_post_date) > 0){

        // 配列でループ
        $i = 1;
        foreach ($ary_post_date as $key => $value){
            // 埋める桁数を設定
            $pad_len = (bcmod($i, 3) == "1") ? "4" : "2";
            // 0埋めして変数へ代入（値がnullの場合は0埋めせずにnullをセット）
            $ary_pad_date[$key] = ($value != null) ? str_pad($value, $pad_len, "0", STR_PAD_LEFT) : null;
            $i++;
        }

    }

    return $ary_pad_date;

}


/**
 * 概要     HTML_QuickFormを利用して金額の入力フォームを作成（範囲）
 *
 * 説明     開始・終了のフォーム名が指定されない場合、s, eとなります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $ifs        区切り文字
 * @param string    $start      開始のフォーム名
 * @param string    $end        終了のフォーム名
 *
 */
function Addelement_Money_Range($form, $form_name, $label = "", $ifs = "", $s = "s", $e = "e", $option = ""){

    // global css
    global $g_form_option;

    // 属性
    $sizelen    = "size=\"11\" maxLength=\"9\" ";
    $form_option= "class=\"ime_disabled\" class=\"money\" $g_form_option ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$s", "", "$sizelen $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "〜");
    $obj[]  =&  $form->createElement("text", "$e", "", "$sizelen $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     HTML_QuickFormを利用して取引先コードの入力フォームを作成（6桁-4桁）
 *
 * 説明     コード１・コード２のフォーム名が指定されない場合、cd1, cd2となります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $ifs        区切り文字
 * @param string    $cd1        コード１のフォーム名
 * @param string    $cd2        コード２のフォーム名
 *
 */
function Addelement_Client_64($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $option = ""){

    // global css
    global $g_form_option;

    // js用フォーム名
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // 属性とjs
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option    = "class=\"ime_disabled\" ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     HTML_QuickFormを利用して取引先コードの入力フォームを作成（6桁-4桁 取引先名）
 *
 * 説明     コード１・コード２・取引先名のフォーム名が指定されない場合、cd1, cd2, nameとなります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $ifs        区切り文字
 * @param string    $cd1        コード１のフォーム名
 * @param string    $cd2        コード２のフォーム名
 * @param string    $name       取引先名のフォーム名
 *
 */
function Addelement_Client_64n($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js用フォーム名
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // 属性とjs
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"15\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_64 = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     HTML_QuickFormを利用して取引先コードの入力フォームを作成（6桁 取引先名）
 *
 * 説明     コード１・コード２・取引先名のフォーム名が指定されない場合、cd1, cd2, nameとなります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $cd1        コード１のフォーム名
 * @param string    $name       取引先名のフォーム名
 *
 */
function Addelement_Client_6n($form, $form_name, $label = "", $cd1 = "cd1", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js用フォーム名
    $form_cd1   = "$form_name"."[".$cd1."]";

    // 属性とjs
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"15\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_6  = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeydown $onfocus $onblur $form_option_6");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     多次元配列内のvalue全てに指定した関数を適用
 *
 * 説明     
 *
 * @param   $ary            配列名
 *          $func           使用したい関数名（要case文追加）
 *
 * @return  $ary_res        関数適用後の配列
 */
function Ary_Foreach($ary, $func){

    // $aryでループ
    foreach ($ary as $key => $value){

        // 要素が配列の場合
        if (is_array($value) == true){

            // 再帰的に自分を呼ぶ
            $ary_res[$key] = Ary_Foreach($value, $func);

        // 要素が配列でない場合
        }else{

            // $funcに応じて関数適用
            switch ($func){
                case "stripslashes" :
                    $ary_res[$key] = stripslashes($value);
                    break;
            }

        }

    }

    // 関数適用後の配列を返す
    return $ary_res;

}


//消費税率を取得(デフォルトは自社の消費税率）
function Get_Tax_Rate($db_con,$client_id=NULL){

		if($client_id == NULL){
			$client_id = $_SESSION[client_id];
		}

    //消費税率取得
    $sql  = "SELECT ";
    $sql .= "    tax_rate_n ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $client_id";
    $result = Db_Query($db_con, $sql); 
    $tax = pg_fetch_result($result, 0,0);

    return $tax;

}


/**
 * 指定した日付の消費税率取得
 *
 * 売上日・仕入日等に合った自社プロフィールの消費税率を返す
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     0.1.0 (2009/10/21)
 *
 * @param       resource    $db_con     DBリソース
 * @param       int         $shop_id    ショップID
 * @param       int         $client_id  取引先ID
 * @param       string      $date       計上日（YYYY-MM-DD 形式（じゃない場合は本日の日付で処理します））
 *
 * @return      int                     消費税率
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2009/10/21                  kajioka-h   新規作成
 *
 */
function Get_TaxRate_Day($db_con, $shop_id, $client_id, $date)
{
    //計上日が正しくないの場合、本日の日付を設定
    $array = explode("-", $date);
    if(@checkdate($array[1], $array[2], $array[0])){
        $y = $array[0];
        $m = $array[1];
        $d = $array[2];
    }else{
        $y = date("Y");
        $m = date("m");
        $y = date("d");
    }
    $date = date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));

    //取引先の課税区分を取得
    $sql  = "SELECT \n";
    $sql .= "    tax_div \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id = $client_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $tax_div = pg_fetch_result($result, 0, 0);

    //課税区分3（非課税）の取引先は消費税率0
    if($tax_div == "3"){
        return 0;
    }

    //自社の消費税設定を取得
    $sql  = "SELECT \n";
    $sql .= "    tax_rate_old, \n";
    $sql .= "    tax_rate_now, \n";
    $sql .= "    tax_change_day_now, \n";
    $sql .= "    tax_rate_new, \n";
    $sql .= "    tax_change_day_new \n";
    $sql .= "FROM \n";
    $sql .= "    t_client \n";
    $sql .= "WHERE \n";
    $sql .= "    client_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);

    $tax_rate_old       = pg_fetch_result($result, 0, 0);	//旧消費税率
    $tax_rate_now       = pg_fetch_result($result, 0, 1);	//現消費税率
    $tax_change_day_now = pg_fetch_result($result, 0, 2);	//現税率切替日
    $tax_rate_new       = pg_fetch_result($result, 0, 3);	//新消費税率
    $tax_change_day_new = pg_fetch_result($result, 0, 4);	//新税率切替日

    //現税率切替日より前の日付は旧消費税率
    if($date < $tax_change_day_now){
        return (int)$tax_rate_old;

    //新消費税率切替日が空でなく、新消費税率以後の日付は新消費税率
    }elseif($tax_change_day_new != NULL && $date >= $tax_change_day_new){
        return (int)$tax_rate_new;
    }

    //上記以外は現消費税率
    return (int)$tax_rate_now;

}


//端数区分を取得
function Get_Tax_div($db_con,$client_id){

    //得意先の情報を抽出
    $sql  = "SELECT";
    $sql .= "    coax, ";
    $sql .= "    tax_franct ";
    $sql .= "FROM";
    $sql .= "    t_client ";
    $sql .= "WHERE";
    $sql .= "    client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    $tax_div = pg_fetch_array($result);

    return $tax_div;

}


/**
 * 概要     取引先状態取得関数
 *
 * 説明     指定された取引先IDの状態を取得し、状態出力用HTMLを返す
 *
 * @param   $db_con             DBリソース
 *          $client_id  int     取引先ID
 *
 * @return  str                 状態（html）
 */
function Get_Client_State($db_con, $client_id){

    // 取引先IDがある場合
    if ($client_id != null){

        // 状態取得
        $sql  = "SELECT \n";
        $sql .= "   state \n";
        $sql .= "FROM \n";
        $sql .= "   t_client \n";
        $sql .= "WHERE \n";
        $sql .= "   client_id = $client_id \n";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);
        $client_state = pg_fetch_result($res, 0, 0);

        // 出力データ作成
        switch ($client_state){
            case "1":
                $client_state_print = "<span style=\"color: #555555;\">取引中</span>\n";
                break;  
            case "2":
                $client_state_print = "<span style=\"color: #ff0000; font-weight: bold;\">解約・休止中</span>\n";
                break;  
            default:
                $client_state_print = null; 
        }

        // 出力する結果を返す
        return $client_state_print;

    // 取引先IDがない場合
    }else{

        return null;

    }

}


/**
 * 概要     FC・取引先区分、FC・取引先名のヒアセレクト用配列作成
 *
 * 説明     
 *
 * @param   $db_con             DBリソース
 *
 * @return  array               FC・取引先区分、FC・取引先名のヒアセレクト用配列
 */
function Make_Ary_Shop($db_con, $where = null){

    $sql  = "SELECT \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_client.client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   INNER JOIN t_rank ON  t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "                     AND t_rank.disp_flg = 't' \n";
    $sql .= $where." \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2 \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // hierselect用配列定義
    $ary_hier1[null] = null; 
    $ary_hier2       = null; 

    // データがある場合
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // データ取得（レコード毎）
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // 分かりやすいように各階層のIDを変数に代入
            $hier1_id = $data_list[$i]["rank_cd"];
            $hier2_id = $data_list[$i]["client_id"];

            /* 第1階層配列作成処理 */
            // 現在参照レコードのFC・取引先区分コードと前に参照したレコードのFC・取引先区分コードが異なる場合
            if ($data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"]){
                // 第1階層取得アイテムを配列へ
                $ary_hier1[$hier1_id] = $data_list[$i]["rank_cd"]." ： ".htmlentities($data_list[$i]["rank_name"], ENT_COMPAT, EUC);
            }

            /* 第2階層配列作成処理 */
            // 現在参照レコードのFC・取引先区分コードと前に参照したレコードのFC・取引先区分コードが異なる場合
            // または、現在参照レコードのFC・取引先IDと前に参照したレコードのFC・取引先IDが異なる場合
            if (
                $data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_id"] != $data_list[$i-1]["client_id"]
            ){
                // 第2階層取得アイテムを配列へ
                $ary_hier2[$hier1_id][$hier2_id]  = $data_list[$i]["client_cd1"];
                $ary_hier2[$hier1_id][$hier2_id] .= ($data_list[$i]["client_cd2"] != null) ? "-".$data_list[$i]["client_cd2"] : null;
                $ary_hier2[$hier1_id][$hier2_id] .= " ： ";
                $ary_hier2[$hier1_id][$hier2_id] .= htmlentities($data_list[$i]["client_cname"], ENT_COMPAT, EUC);
            }

        }

        // 1つの配列にまとて返す
        return array($ary_hier1, $ary_hier2);

    // 1件も無い場合
    }else{

        // 空の配列を返す
        $array[null] = null;
        return array($array, $array);

    }

}


/**
 * 概要     HTML_QuickFormを利用して伝票番号の入力フォームを作成（範囲）
 *
 * 説明     開始・終了のフォーム名が指定されない場合、s, eとなります
 *
 * @param object    $form       HTML_QuickFormオブジェクト
 * @param string    $form_name  HTMLでのフォーム名
 * @param string    $label      表示名
 * @param string    $ifs        区切り文字
 * @param string    $start      開始のフォーム名
 * @param string    $end        終了のフォーム名
 *
 */
function Addelement_Slip_Range($form, $form_name, $label = "", $ifs = "", $s = "s", $e = "e", $option = ""){

    // global css
    global $g_form_option;

    // 属性
    $sizelen    = "size=\"10\" maxLength=\"8\" ";
    $form_option= "class=\"ime_disabled\" $g_form_option ".$option;

    $obj = null; 

    $obj[]  =&  $form->createElement("text", "$s", "", "$sizelen $form_option");
    $obj[]  =&  $form->createElement("static", "", "", "〜");
    $obj[]  =&  $form->createElement("text", "$e", "", "$sizelen $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * 概要     前回の前受相殺以降チェック
 *
 * 説明     日付が前回の前受相殺日以降かをチェックする
 *
 * @param resource  $db_con     DB接続リソース
 * @param int       $client_id  得意先ID
 * @param sring     $claim_div  請求先区分
 * @param string    $y          チェックする日付（年）
 * @param string    $m          チェックする日付（月）
 * @param string    $d          チェックする日付（日）
 *
 */
function Check_Adv_Offset_Day($db_con, $client_id, $claim_div, $y, $m, $d){

    // 前回の前受相殺日を取得
    $sql  = "SELECT \n";
    //$sql .= "   COALESCE(MAX(t_payin_h.pay_day), '".START_DAY."') \n";
    $sql .= "   MAX(t_payin_h.pay_day) \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "       ON  t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       AND t_payin_d.trade_id = 40 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.claim_div = '$claim_div' \n";
    $sql .= ";"; 

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        return true;
    }

    $last_day = pg_fetch_result($res, 0, 0);

    // 引数で渡された日付の0埋め/結合
    $arg_day  = Str_Pad_Date(array($y, $m, $d));
    $post_day = $arg_day[0]."-".$arg_day[1]."-".$arg_day[2];

    // 入力された日付 <= 抽出した日付：エラー
    if ($post_day <= $last_day){
        return false;
    }
    return true;

}


/**
 * 概要     選択された得意先の請求先が存在するかチェック
 *
 * 説明     
 *
 * @param resource  $db_con     DB接続リソース
 * @param int       $client_id  得意先ID
 * @param sring     $claim_div  請求先区分
 *
 */
function Check_Claim_Alive($db_con, $client_id, $claim_div){

    // 請求先が存在するかチェック
    $sql .= "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "INNER JOIN t_client ON  t_claim.claim_id = t_client.client_id \n";
    $sql .= "                    AND t_claim.client_id = $client_id \n";
    $sql .= "                    AND t_claim.claim_div = '$claim_div' \n";
    $sql .= "                    AND t_client.shop_id IN ".Rank_Sql2()." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $cnt  = pg_fetch_result($res, 0, 0);

    // 0件ならエラー
    if ($cnt == 0){
        return false;
    }
    return true;

}


/**
 * 概要     ヘッダ部ボタン作成関数
 *
 * 説明     
 *
 * @param           $form       フォーム
 * @param ary       $ary_list   ボタンvalue => リンク先 の配列
 * @param int       $color_no   ボタンに色を付ける番号（指定の無い場合は自動で）
 *
 */
function Make_H_Link_Btn($form, $ary_list, $color_no = null){

    global $g_button_color;

    $i = 1;

    foreach ($ary_list as $key => $value){

        // ボタン色オプション
        if ($color_no != null){
            $color_opt = ($i == $color_no) ? $g_button_color : null;
        }else{
            $value = str_replace("../", "", $value);    // 相対パスの上位階層指定を削除
            $value = str_replace("./",  "", $value);    // 相対パスのカレント指定を削除
            $color_opt = (strpos($_SERVER["PHP_SELF"], $value) !== false) ? $g_button_color : null;
        }

        // ボタン名作成
        $start_num = (strrpos($value, "/") === false) ? 0 : strrpos($value, "/") + 1;
        $str_cnt   = strrpos($value, ".") - $start_num;
        $btn_name  = substr($value, $start_num, $str_cnt)."_link_button";

        // ボタン作成
        $form->addELement("button", $btn_name, $key, $color_opt." onClick=\"location.href='$value'\"");

        $i++;

    }

}


/**
 * 概要     ヘッダ部ボタン出力関数
 *
 * 説明     
 *
 * @param           $form       フォーム
 * @param ary       $ary_list   ボタンvalue => リンクURL の配列
 *
 */
function Print_H_Link_Btn($form, $ary_list){

    foreach ($ary_list as $key => $value){

        // ボタン名作成
        $start_num = (strrpos($value, "/") === false) ? 0 : strrpos($value, "/") + 1;
        $str_cnt   = strrpos($value, ".") - $start_num;
        $btn_name  = substr($value, $start_num, $str_cnt)."_link_button";

        // ボタン出力
        $print    .= "　".$form->_elements[$form->_elementIndex[$btn_name]]->toHtml();

    }

    return $print;

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
function Numformat_Ortho($int, $dot = 0, $null = null){

    if ($null === true && $int === null){
        return null;
    }else{
        return ($int < 0) ? "<span style=\"color: #ff0000;\">".number_format($int, $dot)."</span>" : number_format($int, $dot);
    }

}


/**
 * 概要     請求先に対する前受金残高を取得する
 *
 * 説明     請求先に対する前受金残高を取得する（前受未確定込み）
 *
 * @param resource  $db_con     DB接続リソース
 * @param string    $count_day  集計日
 * @param int       $client_id  得意先ID
 * @param boolean   $claim_div  請求先区分
 * @param int       $sale_id    この売上で発生した前受相殺額は含まないよ
 *
 */
function Advance_Offset_Claim($db_con, $count_day, $client_id, $claim_div, $sale_id=null){

    $sql  = "SELECT \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) < 0 THEN 0 \n";
    $sql .= "       ELSE COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) \n";
    $sql .= "   END \n";
    $sql .= "   AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           claim_div = '$claim_div' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           claim_div = '$claim_div' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    if($sale_id != null){
        $sql .= "       AND \n";
        $sql .= "           t_payin_h.sale_id != $sale_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        $advance_offset = 0;
    }else{
        $advance_offset = pg_fetch_result($res, 0, 0);
    }

    return $advance_offset;
    

}


/**
 * 概要     得意先に対する前受金残高を取得する
 *
 * 説明     得意先に対する前受金残高を取得する（前受未確定込み）
 *
 * @param resource  $db_con     DB接続リソース
 * @param string    $count_day  集計日
 * @param int       $client_id  得意先ID
 * @param boolean   $motocho    trueなら前受相殺伝票も集計日以前のもので集計するよフラグ（得意先元帳で使ってるよ）
 *
 */
function Advance_Offset_Client($db_con, $count_day, $client_id, $motocho = null){

    $sql  = "SELECT \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    if ($motocho === true){
        $sql .= "       AND \n";
        $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    }
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        $advance_offset = 0;
    }else{
        $advance_offset = pg_fetch_result($res, 0, 0);
    }

    return $advance_offset;
    

}


/**
 * 概要     指定された日以前に、請求先に対する確定されていない前受金伝票がないかチェック
 *
 * 説明     指定された日以前に、請求先に対する確定されていない前受金伝票がないかチェックする
 *
 * @param resource  $db_con     DB接続リソース
 * @param string    $count_day  集計日
 * @param int       $client_id  得意先ID
 * @param boolean   $claim_div  請求先区分
 *
 */
function Chk_Advance_Fix($db_con, $count_day, $client_id, $claim_div){

    // 該当条件で、確定されていない伝票を取得
    $sql  = "SELECT \n";
    $sql .= "   advance_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   claim_div = '$claim_div' \n";
    $sql .= "AND \n";
    $sql .= "   pay_day <= '$count_day' \n";
    $sql .= "AND \n";
    $sql .= "   fix_day IS NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 確定されていない伝票がある場合はエラー：ない場合はtrue
    return ($num > 0) ?  false : true;

}


/**
 * 概要     日付が請求締処理以降かどうかをチェック
 *
 * 説明     日付が請求締処理以降かどうかをチェック
 *
 * @param   resource    $db_con     DB接続リソース
 * @param   int         $client_id  得意先ID 
 * @param   string      $y          チェックする日付の年
 * @param   string      $m          チェックする日付の月
 * @param   string      $d          チェックする日付の日
 *
 */
function Check_Bill_Close_Day_Claim($db_con, $client_id, $claim_div, $y, $m, $d){

    $sql  = "SELECT \n";
    //$sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
    $sql .= "   MAX(bill_close_day_this) \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill_d \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill_d.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.claim_div = '$claim_div' \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num == 0){
        return true;
    }

    $bill_close_day = pg_fetch_result($res, 0, 0);

    // 引数で渡された日付を結合
    $y = str_pad($y, 4, 0, STR_PAD_LEFT);
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $pram_date = $y."-".$m."-".$d;

    // 抽出した日付が渡された日付より大きい場合はエラー
    if($bill_close_day >= $pram_date){
        return false;
    }
    return true;

}


/**
 * 概要     照会画面用ソートリンク作成
 *
 * 説明     
 *
 * @param               $form           フォーム
 * @param   array       $ary_sort_link  作成するソートリンク達を配列で記述したもの（"フォーム名" => "リンク表示名"）
 * @param   string      $def_item       初期状態のソート対象フォーム名
 * @param   string      $hdn_form       選択されたアイテムをセットするhidden（任意）
 *
 */
function Addelement_Sort_Link($form, $ary_sort_link, $def_item, $hdn_form = null){

    if ($hdn_form === null){
        $hdn_form = "hdn_sort_col";
    }

    // ソートリンク作成
    foreach ($ary_sort_link as $f_name => $value){

        // 選択がない場合（初期表示時）＋作成するリンクがデフォルトアイテムの場合
        // 初期状態で一覧出力されている画面用
        if ($_POST[$hdn_form] == null && $f_name == $def_item){
            $form->addElement("static", $f_name, null, $value."▼");
        }

        // 選択された列
        elseif ($_POST[$hdn_form] == $f_name){
            $form->addElement("static", $f_name, null, $value);
        }

        // 選択されていない列
        else{
            $form->addElement("link", $f_name, "", $_SERVER["PHP_SELF"], $value, 
                "onClick=\"javascript:Button_Submit('$hdn_form', '".$_SERVER["PHP_SELF"]."', '".$f_name."'); return false;\""
            );
        }
    }

    // ソート内容格納用hidden作成
    $form->addElement("hidden", $hdn_form);

    // ↑のhiddenに、指定された初期値をセット
    $set_def[$hdn_form] = $def_item;
    $form->setDefaults($set_def);

}


/**
 * 概要     照会画面用ソートリンク出力（.php用）
 *
 * 説明     
 *
 * @param               $form       フォーム
 * @param   string      $f_name     フォーム名
 *
 */
function Make_Sort_Link($form, $f_name){

    return $form->_elements[$form->_elementIndex[$f_name]]->toHtml().Make_Sort_Mark($f_name);

}


/**
 * 概要     照会画面用ソートリンク出力（.tpl用）
 *
 * 説明     .php側でこの関数をレジストし、.tpl側でコールしてください（引数: form=$form f_name="ソートリンクフォーム名"）
 *
 * @param   array       $params     テンプレートからテンプレート関数に渡された全ての属性は、連想配列として$paramsに格納されます
 *
 */
function Make_Sort_Link_Tpl($params){

    if ($params["hdn_form"] === null){
        return $params["form"][$params["f_name"]]["html"].Make_Sort_Mark($params["f_name"]);
    }else{
        return $params["form"][$params["f_name"]]["html"].Make_Sort_Mark($params["f_name"], $params["hdn_form"]);
    }

}


/**
 * 概要     照会画面用ソートリンクの状態出力
 *
 * 説明     私はMake_Sort_Link, Make_Sort_Link_Tplにコールされます
 *
 * @param   string      $f_name     フォーム名
 * @param   string      $hdn_form   選択されたアイテムがセットしてあるhidden（任意）
 *
 */
function Make_Sort_Mark($f_name, $hdn_form = null){

    if ($hdn_form === null){
        $hdn_form = "hdn_sort_col";
    }

    return ($_POST[$hdn_form] == $f_name) ? "▼" : null;

}


/**
 * 概要     請求先の親子関係をチェックする
 *
 * 説明     
 *
 * @param   resource  $db_con       DB接続リソース
 * @param   int       $claim_id     請求先ID
 *
 */
function Claim_Filiation_Chk($db_con, $target_claim_id){

    // 「対象の請求先ID」を請求先として登録している得意先を取得
    $sql  = "SELECT \n";
    $sql .= "   client_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "WHERE \n";
    $sql .= "   claim_id = $target_claim_id \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 「対象の請求先ID」を請求先として登録している得意先が複数ある場合は親子関係あり
    $filiation_flg = ($num > 1) ? true : null;

    // 「対象の請求先ID」を請求先として登録している得意先が1件の場合
    if ($num == 1){

        /*      
        ここにくるパターン
            ・自分を請求先に登録している独立
        */

        $filiation_flg = null;

    }

    // 親子関係あり：true
    // 親子関係なし：null
    return $filiation_flg;

}


/**
 * 概要     得意先の親子関係をチェックする
 *
 * 説明     
 *
 * @param   resource  $db_con       DB接続リソース
 * @param   int       $client_id    得意先ID
 *
 */
function Client_Filiation_Chk($db_con, $client_id){

    // 指定された得意先の請求先を取得
    $sql  = "SELECT \n";
    $sql .= "   claim_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 請求先が2件ある場合は親子関係あり
    $filiation_flg = ($num > 1) ? true : null;

    // 請求先が1件の場合
    if ($num == 1){

        /*      
        ここにくるパターン
            ・親の親のみを請求先に登録している親
            ・親        を請求先に登録している子
            ・自分      を請求先に登録している親
            ・自分      を請求先に登録している独立
        */

        // 対象の請求先IDを取得
        $target_claim_id = pg_fetch_result($res, 0, 0);

        // 得意先IDと、対象の請求先IDが違う場合は親子関係あり（親を請求先に登録している子）
        $filiation_flg = ($client_id != $target_claim_id) ? true : null;

        // 得意先IDと、対象の請求先IDが同じ場合
        if ($client_id == $target_claim_id){

            /*      
            ここにくるパターン
                ・自分を請求先に登録している親
                ・自分を請求先に登録している独立
            */

            // 「対象の請求先ID」の親子関係をチェックする
            $filiation_flg = Claim_Filiation_Chk($db_con, $target_claim_id);

        }

    }

    // 親子関係あり：true
    // 親子関係なし：null
    return $filiation_flg;

}

?>
