<?php
/***********************************************************
 *
 * HTML表示関数群
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(kajioka-h)
 *
 * @version     1.0.0 (2005/03/22)
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * 1.1.0 (2005/10/18) 変更(suzuki-t)
 *
 * @version     1.1.0 (2005/10/18)
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 ***********************************************************/




/**
 * HTMLのヘッダを表示
 *
 * HTMLのヘッダ部分を生成・表示する
 * HTMLタグ、HEAD〜/HEADタグの生成。
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       string      $html_title     titleタグ内で使用するタイトル
 * @param       string      $js             ページに読み込む外部JavaScriptファイル名
 * @param       string      $css            ページに読み込む外部スタイルシートファイル名
 *
 * @return      void
 *
 * @global      string      $g_html_charset ページに指定する文字コード（config/config.php 内で指定）
 * @global      string      $bgcolor        なし？
 *
 */
function Html_Header($html_title="", $js="amenity.js", $css="global.css", $css2="") {

    $charset  = HTML_CHAR;
    $css_file = CSS_DIR ."$css";
    $js_file  = JS_DIR ."$js";
    $favicon  = IMAGE_DIR ."favicon.ico";

    if($css2 != ""){
        $css2 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".CSS_DIR.$css2."\">";
    }

$html_header  =<<<PRINT_HTML_SRC
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=$charset">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <META HTTP-EQUIV="Imagetoolbar" CONTENT="no">
    <title>$html_title</title>
    <link rel="shortcut icon" href="$favicon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="$css_file">
    $css2
    <base target="_self">
</head>
<script language="javascript" src="$js_file">
</script>
PRINT_HTML_SRC;

    #echo "$html_header";
    return $html_header;

}

/**
 * HTMLのBODYタグを表示
 *
 * Html_Headerの後に表示するBODYタグを表示
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       string      $debug      BODYタグ内で指定する属性を指定
 *
 * @return      void
 *
 */
function Html_Body($debug="") {
    echo "\n\n<body $debug>\n\n";
    /*
    //デバック
    if($debug === 1){
        echo "<hr>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<hr>\n";
        echo "<b>GET</b>\n";
        print_r ($_GET);
    }else if ($debug === 2){
        echo "<pre>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "</pre>\n";
    }
    */

}

/**
 * HTMLのフッタを表示
 *
 * ページの最後にフッタを表示
 * 著作権表示テーブル〜/HTMLタグ
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(kajioka-h)
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/03/22)
 *
 * @param       int     $debug      デバッグ表示のオン・オフ切替え
 *                                  1または2を指定するとデバッグ表示（1と2は表示形式の違いのみ）
 *
 * @return      void
 *
 */
function Html_Footer($debug = 0) 
{

$html_footer =<<<PRINT_HTML_SRC

<!--    <br>-->
    <!---------------------- フッタテーブル開始 --------------------->
    <table border="0" cellpadding="5" width="100%" height="0">
    <tr>
        <td>
            <div align="center">
            <font color="#585858" style="font-size: 12px;">
            Revision 1.6.0
            </div>
            </font>
        </td>
    </tr>
    <tr>
        <td>
            <div align="center">
            <font color="#585858" style="font-size: 12px;">
            Copyright &copy; 2007 Amenity Co.,Ltd. All Rights Reserved.
            </font>
            </div>
        </td>
    </tr>
    </table>
    <!--********************* フッタテーブル終了 ******************-->
</form>
</body>
</html>
PRINT_HTML_SRC;

    #echo $html_footer;
    return $html_footer;

    /*
    //デバック
    if($debug === 1){
        echo "<hr>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<hr>\n";
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "<hr>\n";
        echo "<b>SESSION</b>\n";
        print_r ($_SESSON);

    }else if ($debug === 2){
        echo "<pre>\n";
        echo "<b>POST</b>\n";
        print_r ($_POST);
        echo "<b>GET</b>\n";
        print_r ($_GET);
        echo "<b>SESSION</b>\n";
        print_r ($_SESSON);
        echo "</pre>\n";
    }
    */

}

//ページ表示関数（全件数,ページ数,ページプルダウン識別）
function Html_Page($t_count,$p_count,$flg,$range,$width="100%")
{

    //表示件数が０か
    if($t_count == 0 || $t_count == 1){
        $html_page = <<<PRINT_HTML_SRC
            <!---------------------- ページテーブル開始 --------------------->
            <table border="0" width=$width>
            <tr>
                <td width="50%" align="left">全<b>$t_count</b>件</td>
            </tr>
            </table>
            <!--********************* ページテーブル終了 ******************-->
PRINT_HTML_SRC;
    }else{
        //ページ数取得
        if($t_count%$range == 0){
            $p_page = $t_count/$range;
        }else{
            $p_page = ((int)($t_count/$range))+1;
        }

        $select = "<select name=\"f_page".$flg."\" onChange=\"page_check(".$flg.")\">";

        //ページ数分表示
        for($c=1;$c<=$p_page;$c++){
            if($p_count == $c)
            {
                $select .= "\n<option value=".$c." selected>".$c;
            }else{
                $select .= "\n<option value=".$c.">".$c;
            }
        }
        $select .= "\n</select>";

        //戻る・進むリンクの表示、非表示
        switch ($p_count){
            case 1:

            case null:
                $page = "<font color=\"#ABABAB\">戻る</font> | <a href=\"javascript:page_next(1)\">進む</a> | ";
    break;
            case $p_page:
                $page = "<a href=\"javascript:page_back(".$p_page.")\">戻る</a> | <font color=\"#ABABAB\">進む</font> | ";
    break;
            default:
                $page = "<a href=\"javascript:page_back(".$p_count.")\">戻る</a> | <a href=\"javascript:page_next(".$p_count.")\">進む</a> | ";
        }

        $apage_flg = ($t_count * $p_count <= $range) ? true : false;

        //初期画面判定
//        if($p_count == null){
        if($p_count == null || $apage_flg == true){
            //全件数が、表示範囲以内の場合、戻る・進む・プルダウンを非表示
            if($t_count <= $range){
                $page = null;
                $select = null;
                //範囲を１〜全件数
                $p_count_e = $t_count;
            }else{
                //範囲を１〜範囲数
                $p_count_e = $range;
            }
            $p_count_s = 1;
        }else{
            $p_count_s = $p_count*$range-($range-1);
            //ページ遷移時に、範囲数より全件数が小さい場合、○○〜全件数にする
            if($t_count < $p_count*$range){
                $p_count_e = $t_count;
            }else{
                $p_count_e = $p_count*$range;
            }
        }
            $html_page = <<<PRINT_HTML_SRC
            <!---------------------- ページテーブル開始 --------------------->
            <table border="0" width=$width>
            <tr>
                <td width="50%" align="left">全<b>$t_count</b>件中&nbsp;<b>$p_count_s</b>〜<b>$p_count_e</b>表示</td>
                <td width="50%" align="right">$page</td>
                <td width="50%" align="right">$select</td>
            </tr>
            </table>
            <!--********************* ページテーブル終了 ******************-->
PRINT_HTML_SRC;
    }
    return $html_page;
}


//ページ表示関数（全件数,ページ数,ページプルダウン識別）
function Html_Page2($t_count, $p_count, $flg, $range, $width="100%")
{

    // 表示件数が0件の場合
    if($t_count == 0 || $t_count == 1){

        // 全件数のみ表示するテーブルを作成
        $html_page = 
<<<PRINT_HTML_SRC
<table border="0" width="$width">
    <tr>
        <td width="50%" align="left">全<b>$t_count</b>件</td>
    </tr>
</table>
PRINT_HTML_SRC;

    // 表示件数が1件以上の場合
    }else{

        // ページ数取得
        $p_page = ($t_count % $range == 0) ? $p_page = $t_count / $range : $p_page = ((int)($t_count / $range)) + 1;

        // ページ切り替えセレクトボックス作成
        $select = "\n<select name=\"f_page".$flg."\" onChange=\"page_check2(".$flg.", '".$_SERVER["PHP_SELF"]."')\">\n";
        // ページ数分アイテムを作成（選択されたアイテムはselectedにする）
        for($c = 1; $c <= $p_page; $c++){
            $select .= "    <option value=".$c." ".(($p_count == $c) ? "selected" : null).">".$c."</option>\n";
        }
        $select .= "</select>\n";

        // 戻る・進むリンクの表示、非表示
        switch ($p_count){
            case 1:

            case null:
                $page = "<font color=\"#ABABAB\">戻る</font> | <a href=\"javascript:page_next2(1, '".$_SERVER["PHP_SELF"]."')\">進む</a> | ";
                break;
            case $p_page:
                $page = "<a href=\"javascript:page_back2(".$p_page.", '".$_SERVER["PHP_SELF"]."')\">戻る</a> | <font color=\"#ABABAB\">進む</font> | ";
                break;
            default:
                $page = "<a href=\"javascript:page_back2(".$p_count.", '".$_SERVER["PHP_SELF"]."')\">戻る</a> | <a href=\"javascript:page_next2(".$p_count.", '".$_SERVER["PHP_SELF"]."')\">進む</a> | ";
        }

        $apage_flg = ($t_count * $p_count <= $range) ? true : false;

        // 初期画面判定
        if($p_count == null || $apage_flg == true){

            //全件数が、表示範囲以内の場合、戻る・進む・プルダウンを非表示
            if ($t_count <= $range){
                $page = null;
                $select = null;
                // 範囲を１〜全件数
                $p_count_e = $t_count;
            }else{
                // 範囲を１〜範囲数
                $p_count_e = $range;
            }
            $p_count_s = 1;

        }else{

            $p_count_s = $p_count*$range-($range-1);
            //ページ遷移時に、範囲数より全件数が小さい場合、○○〜全件数にする
            if ($t_count < $p_count * $range){
                $p_count_e = $t_count;
            }else{
                $p_count_e = $p_count * $range;
            }

        }

        // 件数・リンク・プルダウンを表示するテーブルを作成
        $html_page = 
<<<PRINT_HTML_SRC
<table border="0" width="$width">
    <tr>
        <td width="50%" align="left">全<b>$t_count</b>件中&nbsp;<b>$p_count_s</b>〜<b>$p_count_e</b>表示</td>
        <td width="50%" align="right">$page</td>
        <td width="50%" align="right">$select</td>
    </tr>
    </table>
PRINT_HTML_SRC;

    }

    // 作成したhtmlをを返す
    return $html_page;

}



/*
function Code_value($which,$db_con,$jouken=""){
    if($which=="商品"){
        $table = "t_goods";
        $which = "t_goods.goods_cd,t_goods.goods_name";
        $where = "goods";
    }else if($which=="Ｍ区分"){
        $table = "t_g_goods";
        $which = "g_goods_cd,g_goods_name";
        $where = "g_goods";
    }else if($which=="製品区分"){
        $table = "t_product";
        $which = "product_cd,product_name";
        $where = "product";
    }else if($which=="地区"){
        $table = "t_area";
        $which = "area_cd,area_name";
        $where = "area";
    }else if($which=="銀行"){
        $table = "t_bank";
        $which = "enter_cd,bank_name";
        $where = "bank";
    }else if($which=="業種"){
        $table = "t_btype";
        $which = "btype_cd,btype_name";
        $where = "business";
    }else if($which=="部署"){
        $table = "t_part";
        $which = "part_cd,part_name";
        $where = "position";
    }else if($which=="顧客区分"){
        $table = "t_rank";
        $which = "rank_cd,rank_name";
        $where = "client";
    }else if($which=="グループ"){
        $table = "t_shop_gr";
        $which = "shop_gcd,shop_gname";
        $where = "group";
    }else if($which=="運送業者"){
        $table = "t_trans";
        $which = "trans_cd,trans_name";
        $where = "forwarding";
    }else if($which=="倉庫"){
        $table = "t_ware";
        $which = "ware_cd,ware_name";
        $where = "warehouse";
    }else if($which=="スタッフ"){
        $table = "t_staff";
        $which = "staff_cd1,staff_cd2,staff_name";
        $where = "staff";
    }else if($which=="締日"){
    $data .= "function close(code,place,num){\n";
    $data .= "  if(num != undefined){\n";
    $data .= "      var name = \"form_close\"+num+\"[name]\";\n";
    $data .= "  }else{\n";
    $data .= "      var name = \"form_close[name]\";\n";
    $data .= "  }\n";
    $data .= "  data = new Array(33);\n";
    $data .= "  len = code.value.length;\n";
    $data .= "  if(2==len && code.value>=1 && code.value<=30 && code.value!=null){\n";
    $data .= "      data[code.value]=\"通常締日\";\n";
    $data .= "  }\n";
    $data .= "  data['31']=\"月末指定\";\n";
    $data .= "  data['91']=\"現金得意先\";\n";
    $data .= "  data['99']=\"随時締日\";\n";
    $data .= "  var data = data[code.value];\n";
    $data .= "  if(data == undefined){\n";
    $data .= "      document.dateForm.elements[name].value = \"\";\n";
    $data .= "  }else{\n";
    $data .= "      document.dateForm.elements[name].value = data;\n";
    $data .= "  }\n";
    $data .= "}\n";
    return $data;
    }
    $data_sql = "select ".$which." from ".$table." ".$jouken.";";
    //SQL実行
    $result = pg_query($db_con,$data_sql);
    
    //SQLエラー判定
    if($result == false)
    {
        print "SQLが実行できません";
        exit;
    }
    $row = pg_num_rows($result);
    if($where=="staff"){
        $data .= "function $where(num){\n";
        $data .= "  if(num != undefined){\n";
        $data .= "      var name = \"form_staff\"+num+\"[name]\";\n";
        $data .= "      var code1 = \"form_staff\"+num+\"[code1]\";\n";
        $data .= "      var code2 = \"form_staff\"+num+\"[code2]\";\n";
        $data .= "  }else{\n";
        $data .= "      var name = \"form_staff[name]\";\n";
        $data .= "      var code1 = \"form_staff[code1]\";\n";
        $data .= "      var code2 = \"form_staff[code2]\";\n";
        $data .= "  }\n";
        $data .= "  len = document.dateForm.elements[code2].value.length;\n";
    }else{
        $data .= "function $where(code,place,search,num){\n";
        $data .= "  if(num != undefined && search == null){\n";
        $data .= "      var name = \"form_\"+place+num+\"[name]\";\n";
        $data .= "  }else if(search == undefined){\n";
        $data .= "      var name = \"form_\"+place+\"[name]\";\n";
        $data .= "  }else if(search != undefined && num == undefined){\n";
        $data .= "      var name = \"form_\"+place+\"\";\n";
        $data .= "  }else{\n";
        $data .= "      var name = \"t_\"+place+num;\n";
        $data .= "  }\n";
    }
    $data .= "          data = new Array($row);\n";
    
    if($where =="staff"){
        for($i=0;$i<$row;$i++)
        {
            //code1取得
            $cd1 = pg_fetch_result($result,$i,0);
            //code2取得
            $cd2 = pg_fetch_result($result,$i,1);
            //name取得
            $name = pg_fetch_result($result,$i,2);
            $name = mb_ereg_replace('"','\"',$name);
            $data .= "  data[$cd1-$cd2]=\"$name\"\n";
        }
        $data .= "  var data = data[document.dateForm.elements[code1].value-document.dateForm.elements[code2].value];\n";
        $data .= "  if(len==3){\n";
        $data .= "      if(data == undefined){\n";
        $data .= "          document.dateForm.elements[name].value = \"\";\n";
        $data .= "      }else{\n";
        $data .= "          document.dateForm.elements[name].value = data; \n";
        $data .= "      }\n";
        $data .= "  }\n";
        $data .= "}\n";
    }else{
        for($i=0;$i<$row;$i++)
        {
            //code取得
            $id = pg_fetch_result($result,$i,0);
            //name取得
            $name = pg_fetch_result($result,$i,1);
            $name = mb_ereg_replace('"','\"',$name);
            $data .= "  data['$id']=\"$name\"\n";
        }
        $data .= "  var data = data[code.value];\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else{\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";
    }
    return $data;
}

*/
//<!--********************* 以下最新版 ******************-->
function Code_value($table, $db_con, $jouken="", $type=""){

    // セッションのショップIDを取得
    $shop_id    = $_SESSION["client_id"];

    // セッションのグループ種別を取得
    $group_kind = $_SESSION["group_kind"];

    //条作成
    if($jouken == null){
        $shop_id = $_SESSION["client_id"];
        $jouken  = " WHERE";
        $jouken .= "  shop_id = $shop_id";
    }

    $start = mb_substr($table,'2');

    //得意先マスタが指定された場合
    if($table == "t_client"){
        //仕入先のデータを抽出
        if($type==2){
            $which = $start."_cd1,".$start."_cname";
        //得意先のデータを抽出
        }elseif($type == 1){
            $which = $start."_cd1,".$start."_cd2,".$start."_name";
        }elseif($type == 3){
            $which = $start."_cd1,".$start."_cd2, shop_name";
            $type = 1;
        }elseif($type == 4){
            $which = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "     INNER JOIN";
            $table .= " t_claim";
            $table .= " ON t_client.client_id = t_claim.claim_id";
           
            $jouken  = " WHERE";
            $jouken .= "    t_claim.client_id = t_claim.claim_id";
            $jouken .= "    AND";
            $jouken .= "    t_client.client_div = '3'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";

            $type = 1;
        }elseif($type == 5){
/*
            $which = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "     INNER JOIN";
            $table .= " t_client_info";
            $table .= " ON t_client.client_id = t_client_info.client_id";

            $jouken  = " WHERE";
            $jouken .= "    t_client_info.client_id = t_client_info.claim_id";
            $jouken .= "    AND";
            $jouken .= "    t_client.client_div = '1'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";
            $jouken .= "    AND";
            $jouken .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
*/
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " (SELECT";
            $table .= "    claim_id";
            $table .= " FROM";
            $table .= "    t_claim";
            $table .= " ) AS t_claim";
            $table .= "    INNER JOIN";
            $table .= " t_client";
            $table .= " ON t_claim.claim_id = t_client.client_id";

            $table .= " AND t_client.shop_id = $shop_id";
            $jouken  = " WHERE";
            $jouken .= "    t_client.state = '1'";

            $type = 1;

        //FC得意先一覧でしよう
        }elseif($type == 6){
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table  = " t_client";
            $table .= "  INNER JOIN";
            $table .= " (SELECT";
            $table .= "     client_id";
            $table .= " FROM";
            $table .= "     t_claim";
            $table .= " WHERE";
            $table .= "     client_id IN (SELECT";
            $table .= "                     client_id";
            $table .= "                 FROM";
            $table .= "                     t_claim";
            $table .= "                 WHERE";
            $table .= "                     client_id = claim_id";
            $table .= "                 )";
            $table .= " GROUP BY client_id";
            $table .= " HAVING COUNT(client_id) = 1";
            $table .= " ) AS t_claim";
            $table .= " ON t_client.client_id = t_claim.client_id";

            $jouken  = " WHERE";
            $jouken .= "    t_client.client_div = '1'";
            $jouken .= "    AND";
            $jouken .= "    t_client.state = '1'";
            $jouken .= "    AND";
            $jouken .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";

            $type = 1;
        //FC請求書作成で使用
        }elseif($type == 7){
            $which  = $start."_cd1, ".$start."_cd2, client_cname";
            $table = " (SELECT";
            $table .= "    claim_id";
            $table .= " FROM";
            $table .= "    t_claim";
            $table .= " ) AS t_claim";
            $table .= "    INNER JOIN";
            $table .= " t_client";
            $table .= " ON t_claim.claim_id = t_client.client_id";

            if($_SESSION[group_kind] == "2"){
                $table .= "     INNER JOIN\n";
                $table .= " t_client_info\n";
                $table .= " ON t_client.client_id = t_client_info.client_id";
                $table .= " AND t_client_info.cclient_shop = $shop_id";
            }else{
                $table .= " AND t_client.shop_id = $shop_id";
            }
            $jouken  = " WHERE";
            $jouken .= "    t_client.state = '1'";

            $type = 1;
        //紹介口座先で仕様(FC得意先マスタ)
        }elseif($type == 8){
            $which   = "client_cd1,";
            $which  .= "CASE client_div ";
            $which  .= "     WHEN '2' THEN ''";
            $which  .= "     WHEN '3' THEN client_cd2 ";
            $which  .= "END AS client_cd2, ";
            $which  .= "client_name ";

            $table   = "t_client";

            $jouken  = " WHERE ";
            $jouken .= "client_div = '3' ";
            $jouken .= "OR ";
            $jouken .= "(client_div = '2' ";
            $jouken .= "AND ";
            $jouken .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
            $jouken .= ")";

        //本部商品マスタで使用
        }elseif($type == 9){
            $which = $start."_cd1,".$start."_cd2, client_cname";
            $type = 1;
        }
    }elseif($table == "t_goods" && $type == "1"){
        $which  = " t_goods.goods_cd,";
        $which .= " t_goods.goods_name";

        $jouken  = " WHERE";
        $jouken .= ($group_kind == "2") ? " t_goods_info.shop_id IN (".Rank_Sql().") " : " t_goods_info.shop_id = $shop_id ";
        $jouken .= " AND";
        $jouken .= " t_goods_info.goods_id = t_goods.goods_id";

        $table  = "t_goods, t_goods_info";
    //製造品
    }elseif($table == "t_goods" && $type == "2"){
        $which  = " t_goods.goods_cd,";
        $which .= " t_goods.goods_name";

        $jouken  = " WHERE";
        //$jouken .= "    t_goods.shop_gid = $_SESSION[shop_gid]";
        $jouken .= ($group_kind == "2") ? " t_goods.shop_id IN (".Rank_Sql().") " : " t_goods.shop_id = $shop_id ";
        $jouken .= "    AND";
        $jouken .= "    t_goods.public_flg = 't'";
        $jouken .= "    AND";
        $jouken .= "    t_goods.make_goods_flg = 't'";

    //その他のテーブルを参照する場合
    }else{
        $which = $table.".".$start."_cd, ".$table.".".$start."_name";
    }

    $where = $start;
    $data_sql = "select ".$which." from ".$table." ".$jouken.";";

    //SQL実行
    $result = Db_Query($db_con,$data_sql);
    
    //SQLエラー判定
    if($result == false)
    {
        print "SQLが実行できません";
        exit;
    }

    $row = pg_num_rows($result);

    if($where=="client" && ($type==1 || $type == 8)){
        $fnc_name = $where."1";
        $data .= "function $fnc_name(code1,code2,name){\n";
        $data .= "  data = new Array($row);\n";
        for($i=0;$i<$row;$i++)
        {
            //code1取得
            $cd1 = pg_fetch_result($result,$i,0);
            //code2取得
            $cd2 = pg_fetch_result($result,$i,1);
            //name取得
            $name = pg_fetch_result($result,$i,2);
            $name = addslashes($name);
            //$name = mb_ereg_replace('"','\"',$name);
            $data .= "  data['$cd1-$cd2']=\"$name\";\n";
        }

        $data .= "    var data = data[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
//        $data .= "  var data = data[document.dateForm.elements[code1].value+document.dateForm.elements[code2].value];\n";
        $data .= "  len1 = document.dateForm.elements[code1].value.length;\n";
        $data .= "  len2 = document.dateForm.elements[code2].value.length;\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else if(len1 == 6 && len2 == 4){\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";

        return $data;

    }else{
        $data .= "function $where(code,name){\n";
        $data .= "  data = new Array($row);\n";
        for($i=0;$i<$row;$i++)
        {
            //code取得
            $id = pg_fetch_result($result,$i,0);
            //name取得
            $name = pg_fetch_result($result,$i,1);
            $name = addslashes($name);
            //$name = mb_ereg_replace('"','\"',$name);
            
            $data .= "  data['$id']=\"$name\"\n";
        }

        $data .= "  var data = data[code.value];\n";
        $data .= "  if(data == undefined){\n";
        $data .= "      document.dateForm.elements[name].value = \"\";\n";
        $data .= "  }else{\n";
        $data .= "      document.dateForm.elements[name].value = data; \n";
        $data .= "  }\n";
        $data .= "}\n";
        return $data;
    }
}


?>
