<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/09) セッション情報変更
 * 1.1.0 (2006/03/21) スタッフ種別の分岐変更
 * 1.1.1 (2006/04/13) 本社・支社区分追加
 * 1.2.0 (2006/07/06) shop_gidをなくす(kaji)
 * 1.5.0 (2010/06/14) 名称Do.sys2007をDo.sys2010に変更 Line21,299（松浦）
 *
 * @version     1.5.0 (2010/06/14)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007-02-20                  watanabe-k  セッションに支店IDを追加
 */


$page_title="Do.sys2010 ログイン";

// 環境設定ファイル読み込み
require_once("ENV_local.php");

// セッションを破棄する
session_start();
session_unset();
session_destroy();
session_start();

$login_id=$_POST["login_id"]; //入力ユーザ名
$password=$_POST["password"]; //入力パスワード

$error_mes ="<br><br>"; //エラーメッセージ初期化

//メンテ時間判別
if($g_mente_mode === true){
    $disabled = "disabled";
    $warning  = "※只今メンテナンス作業中のためログインできません。";
}

//ログインボタンが押された時
if($_POST[submit]=="ログイン"){
    //DB接続
    $db_con = Db_Connect();
    //ユーザ情報取得SQL
    $sql  = "SELECT ";
    $sql .= "   t_login.password, ";           //ログインテーブル.パスワード
    $sql .= "   t_staff.staff_id";

    $sql .= " FROM ";
    $sql .= "   t_login,";                     //ログイン
    $sql .= "   t_staff, ";                    //スタッフ
    $sql .= "   t_attach ";                   //所属マスタ

    $sql .= " WHERE ";
    $sql .= "   t_login.login_id = '$login_id' ";
    $sql .= "   AND";
    $sql .= "   t_login.staff_id = t_staff.staff_id";
    $sql .= "   AND";
    $sql .= "   t_staff.staff_id = t_attach.staff_id";
    $sql .= "   AND\n";
    $sql .= "   t_staff.state = '在職中'\n";
    $sql .= ";";

    //ユーザ情報取得
    $result      = Db_Query($db_con,$sql);
    $db_password = @pg_fetch_result ($result, 0, "password"); //DBに保存されたパスワード
    $staff_id    = @pg_fetch_result ($result, 0, "staff_id"); 

    //パスワード比較(一致した場合)
    if (crypt($password,$db_password) == $db_password){

        $sql  = "SELECT\n";
        $sql .= "   t_staff.staff_id,\n";
        $sql .= "   t_staff.staff_name,\n";         
        $sql .= "   t_attach.sys_flg,\n";
        $sql .= "   t_attach.h_staff_flg,\n";
        $sql .= "   t_client.client_id,\n";
        $sql .= "   t_client.client_name,\n";
        $sql .= "   t_client.client_cname,\n";             
        $sql .= "   t_client.shop_name,\n";          
        $sql .= "   t_rank.group_kind,\n";
        $sql .= "   t_client.rank_cd,\n";
        $sql .= "   t_client.shop_div,\n";
        $sql .= "   t_part.branch_id \n";
        $sql .= " FROM\n";
        $sql .= "   t_staff\n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_attach\n";
        $sql .= "   ON t_staff.staff_id = t_attach.staff_id \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_client\n";
        $sql .= "   ON t_attach.shop_id = t_client.client_id \n";
        $sql .= "       INNER JOIN \n";   
        $sql .= "   t_rank\n";
        $sql .= "   ON t_client.rank_cd = t_rank.rank_cd \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "   t_part \n";
        $sql .="    ON t_attach.part_id = t_part.part_id \n";
        $sql .= " WHERE\n";
        $sql .= "   t_staff.staff_id = $staff_id\n";
        $sql .= "   ORDER BY t_attach.h_staff_flg DESC\n";
        $sql .= ";\n";

        $result = Db_Query($db_con,$sql);

        $data_num = pg_num_rows($result);
        //切替フラグがFの場合
        if($data_num == 1){
            $staff_id       = @pg_fetch_result ($result, 0, "staff_id");      //スタッフID
            $staff_name     = @pg_fetch_result ($result, 0, "staff_name");    //スタッフ名
            $client_id      = @pg_fetch_result ($result, 0, "client_id");     //取引先ID
            $client_name    = @pg_fetch_result ($result, 0, "client_name");   //取引先名
            $client_cname   = @pg_fetch_result ($result, 0, "client_cname");  //取引先名(略称)
            $shop_name      = @pg_fetch_result ($result, 0, "shop_name");     //ショップ名
            $h_staff_flg    = @pg_fetch_result ($result, 0, "h_staff_flg");   //本部スタッフフラグ
            $sys_flg        = @pg_fetch_result ($result, 0, "sys_flg");       //システム切替フラグ
            $group_kind     = @pg_fetch_result ($result, 0, "group_kind");    //グループ種別
            $rank_cd        = @pg_fetch_result ($result, 0, "rank_cd");       //FC区分コード
            $shop_div       = @pg_fetch_result ($result, 0, "shop_div");      //本社・支社区分
            $branch_id      = @pg_fetch_result ($result, 0, "branch_id");     //支店ID

            $_SESSION["sys_flg"]      = $sys_flg;
            $_SESSION["staff_id"]     = $staff_id;
            $_SESSION["staff_name"]   = $staff_name;
            $_SESSION["shop_div"]     = $shop_div;

            //ログイン者がFCの場合
            if($h_staff_flg == 'f'){
                $_SESSION["fc_client_id"]    = $client_id;
                $_SESSION["fc_client_name"]  = $client_name;
                $_SESSION["fc_client_cname"] = $client_cname;
                $_SESSION["fc_staff_flg"]    = $h_staff_flg;
                $_SESSION["fc_shop_name"]    = $shop_name;
                $_SESSION["fc_rank_cd"]      = $rank_cd;
                $_SESSION["fc_group_kind"]   = $group_kind;
                $_SESSION["fc_branch_id"]    = $branch_id;

                //FCスタッフ
                $fc_head_flg = "fc";
/*
            //ログイン者が本部の場合
            }elseif($h_staff_flg == 't'){
                $_SESSION["h_client_id"]   = $client_id;
                $_SESSION["h_staff_flg"]   = $h_staff_flg;
                $_SESSION["h_shop_name"]   = $shop_name;
                $_SESSION["h_rank_cd"]     = $rank_cd;
                $_SESSION["h_group_kind"]  = $group_kind;
                //本部スタッフ
                $fc_head_flg = "head";
*/
            }
        //切替フラグがTの場合
        }elseif($data_num == 2){

            for($i = 0; $i < $data_num; $i++){
                $ary_staff_id[$i]       = @pg_fetch_result ($result, $i, "staff_id");     //スタッフID
                $ary_staff_name[$i]     = @pg_fetch_result ($result, $i, "staff_name");   //スタッフ名
                $ary_sys_flg[$i]        = @pg_fetch_result ($result, $i, "sys_flg");      //システム切替フラグ
                $ary_h_staff_flg[$i]    = @pg_fetch_result ($result, $i, "h_staff_flg");  //本部スタッフフラグ
                $ary_client_id[$i]      = @pg_fetch_result ($result, $i, "client_id");    //取引先ID
                $ary_client_name[$i]    = @pg_fetch_result ($result, $i, "client_name");  //取引先名
                $ary_client_cname[$i]   = @pg_fetch_result ($result, $i, "client_cname"); //取引先名(略称)
                $ary_shop_name[$i]      = @pg_fetch_result ($result, $i, "shop_name");    //ショップ名
                $ary_group_kind[$i]     = @pg_fetch_result ($result, $i, "group_kind");   //グループ種別
                $ary_rank_cd[$i]        = @pg_fetch_result ($result, $i, "rank_cd");      //FC区分コード
                $ary_shop_div[$i]       = @pg_fetch_result ($result, $i, "shop_div");     //本社・支社区分
                $ary_branch_id[$i]      = @pg_fetch_result ($result, $i, "branch_id");    //支店ID
            }

            //本部・FC共通
            $_SESSION["staff_id"]       = $ary_staff_id[0];
            $_SESSION["sys_flg"]        = $ary_sys_flg[0]; 
            $_SESSION["staff_name"]     = $ary_staff_name[0];
            $_SESSION["shop_div"]       = $ary_shop_div[0];
            //本部スタッフ
            $fc_head_flg = "head";

            //本部
            $_SESSION["h_client_id"]    = $ary_client_id[0];
            $_SESSION["h_staff_flg"]    = $ary_h_staff_flg[0];
            $_SESSION["h_shop_name"]    = $ary_shop_name[0];
            $_SESSION["h_rank_cd"]      = $ary_rank_cd[0];
            $_SESSION["h_group_kind"]   = $ary_group_kind[0];
    
            //FC
            $_SESSION["fc_client_id"]    = $ary_client_id[1];
            $_SESSION["fc_client_name"]  = $ary_client_name[1];
            $_SESSION["fc_client_cname"] = $ary_client_cname[1];
            $_SESSION["fc_staff_flg"]    = $ary_h_staff_flg[1];
            $_SESSION["fc_shop_name"]    = $ary_shop_name[1];
            $_SESSION["fc_rank_cd"]      = $ary_rank_cd[1];
            $_SESSION["fc_group_kind"]   = $ary_group_kind[1];
            $_SESSION["fc_branch_id"]    = $ary_branch_id[1];
        }
    
        //デモ環境でユーザのログインをログに吐き出す処理
        $pwd = shell_exec("pwd");
        $demo_flg = (strpos($pwd, "demo") !== false)? true : false;

        if($demo_flg === true){
            shell_exec("date >> /tmp/demo_login.txt");
        }
        //本部ユーザの場合
        if($fc_head_flg == "head"){
            if($demo_flg === true){
                shell_exec("echo スタッフID：".$ary_staff_id[0].", スタッフ名：".$ary_staff_name[0]." >> /tmp/demo_login.txt");
            }
            header("Location:" .TOP_PAGE_H); //top.phpへ遷移
        //FCユーザの場合
        }elseif($fc_head_flg == "fc"){
            if($demo_flg === true){
                shell_exec("echo スタッフID：".$staff_id.",　スタッフ名：".$staff_name." >> /tmp/demo_login.txt");
            }
            header("Location:" .TOP_PAGE_F); //top.phpへ遷移
        }
        
        exit;

    //パスワード比較(一致しない場合)
    }else{
        $error_mes  = "<font color=red><b>";
        $error_mes .= "「ログインID」 もしくは 「パスワード」 が正しくありません。<br>";
        $error_mes .= "もう一度入力し直してください。<br>";
        $error_mes .= "</b></font>";
    }

    //DB切断
    Db_Disconnect($db_con);

}



/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header("$page_title");

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();


//HTML****************************************/


$sys_title = IMAGE_DIR ."sys_title.gif";
$login = IMAGE_DIR ."login.gif";
$company_rogo = IMAGE_DIR ."company_rogo.gif";

echo <<<PRINT_HTML_SRC

$html_header 

<style type='text/css'>
</style>

<body onLoad="document.login.login_id.focus()">

<table border="0" width="100%" height="100%">
<tr>
  <td valign="middle" align="center">
    <table  align="center" valign="middle" border="0">
     <tr>
     <td align="center"><b><font color="red">$warning</font></b></td>
     </tr>
     <tr>
      <td VALIGN="middle">
      <form enctype="multipart/form-data" name="login" action="$_SERVER[PHP_SELF]" method="post">
      <center>

      <img src="$sys_title">
      <br>
      <table border="0" width="470" height="190" style="background: url($login)" no-repeat><tr><td>
      <table border="0" align="center">
      <tr>
        <td><font color="#FFFFFF">ログインID</font></td>
        <td><input type="text" name="login_id" value="" maxlength="15" style="width:140px; height=20; ime-mode: disabled;" $g_form_option></td>
      </tr>

      <tr>
        <td><font color="#FFFFFF">パスワード</font></td>
        <td><input type="password" name="password" value="" maxlength="15" style="width:140px; height=20; ime-mode: disabled;" $g_form_option></td>
      </tr>

      <tr>
        <td colspan="2" align="right"><input type="submit" name="submit" value="ログイン" $disabled></td>
      </tr>
      </table>
      </td></tr></table>

      <div>$error_mes</div>
      <div>Amenity Network Do.system 2010<br></div>
      <div>$g_sys_version<br><br><br></div>
      <div><img src=$company_rogo></div>
      </center>
      </form>
    </td>
  </tr>
<!--
  <tr>
    <td align="center">
        <b><font color="red">※</font>メンテナンスのため<font size="5" color="red">12:00〜13:00／20:00〜21:00</font>の間は、サービスを停止させて頂きます。
    </td>
  </tr>
  <tr>
    <td>
    <b>ご不便をおかけいたしますが、ご協力のほど、よろしくお願いいたします。</b></td>
    </td>
  </tr>
-->
  </table>

  </td>
</tr>
</table>

</body>
</html>

PRINT_HTML_SRC;

?>
