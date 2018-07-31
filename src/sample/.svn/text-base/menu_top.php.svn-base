<?php
$page_title = "棚卸実績一覧";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//HTMLヘッダ作成関数
/****************************/
function Create_Header2($title,$form){
//PATHの文字数を取得
$count_path = mb_strwidth(PATH);
//定数HEAD_PAGEからPATHを抜いた部分を取得
$head = mb_substr(HEAD_DIR,$count_path);
//現在のURLに定数HEAD_PAGEからPATHを抜いた部分が含まれているか
$which = strstr ($_SERVER[PHP_SELF],$head);
if($which!=false){
	$head_img = '<img src="../../../image/head_img.png">';
}

//マスタ・設定
$menu_path = PATH."src/head/system";
$system_menu = array (
	"1" => "共有マスタ",
	"$menu_path/1-1-205.php" => "業種",
	"$menu_path/1-1-234.php" => "業態",
	"$menu_path/1-1-233.php" => "施設",
	"$menu_path/1-1-231.php" => "サービス",
	"2" => "個別マスタ",
	"$menu_path/1-1-201.php" => "部署",
	"$menu_path/1-1-203.php" => "倉庫",
	"$menu_path/1-1-109.php" => "スタッフ",
	"$menu_path/1-1-213.php" => "地区",
	"$menu_path/1-1-207.php" => "銀行",
	"$menu_path/1-1-211.php" => "Ｍ区分",
	"$menu_path/1-1-209.php" => "製品区分",
	"$menu_path/1-1-221.php" => "商品",
	"$menu_path/1-1-224.php" => "製造品",
	"$menu_path/1-1-230.php" => "構成品",
	"$menu_path/1-1-227.php" => "顧客区分",
	"$menu_path/1-1-121.php" => "システムコード",
	"$menu_path/1-1-103.php" => "FC",
	"$menu_path/1-1-115.php" => "得意先",
	"$menu_path/1-1-116.php" => "契約",
	"$menu_path/1-1-216.php" => "仕入先",
	"$menu_path/1-1-219.php" => "直送先",
	"$menu_path/1-1-225.php" => "運送業者",
);

$system_arr  = "<select name='form_system' \"onKeyDown=\"chgKeycode();\" onChange=\"window.focus()\";\">";
$num = 1;
while ($main_menu = each($system_menu)){
	//グループ名判定
	if($main_menu[0] == $num){
		$system_arr .= "    <OPTGROUP LABEL=\"■$main_menu[1]\">";
	}else{
		$system_arr .= "    <option value=\"$main_menu[0]\">　　●$main_menu[1]</option>";
	}
	//グループの値が無くなった場合は、グループを閉じる
	if($main_menu[0] == $num){
		$system_arr .= "    </OPTGROUP>";
		$num++;
	}
}
$system_arr .= "</select>";

if($which!=false){
	$table_h =<<<HTML_SRC

	<table width="100%" bgcolor="#213B82">
		<tr><td align="left">

            <table id="page_title_table">
            <!--- <table width="900"> --->
                <tr>
			        <td align="left" valign="middle" width="35%">
        				<font color="#FFFFFF"><b> $_SESSION[shop_name]</b></font><br>
        			</td>
			
		        	<td align="right" valign="middle" width="5%">
        				$head_img&nbsp;
		        	</td>
			
        			<td align="center" valign="middle" width="20%">
		        		<font style="font-size: 11pt; font-weight: bold; color:#FFFFFF">$title</font>
        			</td>

                    <td align="right" valign="middle" width="40%">
                        <br>
                    </td>

		        </tr>
            </table>

        </td></tr>
        <tr><td align="center">
		<hr color="#FFFFFF">
        </td></tr>
		<tr><td align="left" width="35%">

			<font color="#FFFFFF"><b> $_SESSION[staff_name]</b></font><br></td>
		</tr>
    </table>
HTML_SRC;
}else{
	$table_h =<<<HTML_SRC

	<table width='100%'>
		<tr><td align="left">

            <table id="page_title_table" width='100%' border='0' bgcolor='#213B82'>
            <!--- <table width="900"> --->
                <tr>
			        <td align="left" valign="middle" width="35%">
        				<font color="#FEFEFE"><b> $_SESSION[shop_name]</b></font><br>
        			</td>
			
		        	<td align="right" valign="middle" width="5%">
						$system_arr
		        	</td>
			
        			<td align="center" valign="middle" width="20%">
		        		
        			</td>

                    <td align="right" valign="middle" width="40%">
                        <br>
                    </td>

		        </tr>
            </table>

        </td></tr>
		<tr>
		</tr>
		<tr>
			<td >
				<table width="100%">
				<tr>
					<td align="center" valign="middle" width="15%"></td>
					<td align="center" width="80%"><font class=Page_Title>$title</font></td>
HTML_SRC;
$table_h .= "<td align=\"right\" width=\"15%\"><a href='".LOGOUT_PAGE."'><img src='".IMAGE_DIR."logout.gif' border='0'></a></td>";
$table_h .=<<<HTML_SRC
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left" width="35%"><font color="#555555"><b> $_SESSION[staff_name]</b></font><br></td>
		</tr>
    </table>
HTML_SRC;
}
	return  $table_h;
}

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
$page_menu = Create_Menu_h('stock','2');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header2($page_title,$form);


/****************************/
//ページ作成
/****************************/
//仮の件数
$total_count = 100;

//表示範囲指定
$range = "20";

//ページ数を取得
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


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
	'staff_name'    => "$staff_name",
	'shop_name'     => "$shop_name",
	'menu_link'     => "$menu_link",
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
