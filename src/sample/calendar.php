<?php
$page_title = "カレンダー";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

//HTMLイメージ作成用部品
require_once("html_quick.php");

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
$page_menu = Create_Menu_h('system','2');

/****************************/
//画面ヘッダー作成
/****************************/
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
));


if(0 < count($_POST))
{
	$mm = $_POST["month"];
	$yyyy = $_POST["year"];
}
else
{
	$mm = date("n");
	$yyyy = date("Y");
}

//日付情報をセッションに格納
$_SESSION["month"]=$mm;
$_SESSION["year"]=$yyyy;

//曜日を作成
$youbi = array("日", "月", "火", "水", "木", "金", "土");

//当月の1日の曜日を取得
$wd1 = date("w", mktime(0, 0, 0, $mm, 1, $yyyy));
//当月の最終日を取得
$lastd = date("d", mktime(0, 0, 0, $mm + 1, 0, $yyyy));

//第1週
$d=1;
for($i = 0; $i < 7; $i++)
{
	if($i == $wd1)
	{
		$dd[0][$i] = $d;
		$wd1++;
		$d++;
	}
	else if($i < $wd1)
	{
		$dd[0][$i] = "<br>";
	}
}

//第2週目以降
for($i = 1; $i < 6; $i++)
{
	for($j = 0; $j < 7; $j++)
	{
		if($d > $lastd)
		{
			break;
		}
		$dd[$i][$j] = $d;
		$d++;
	}
}


//空白を＜ｂｒ＞にする。
for($i = 1; $i < 6; $i++)
{
	for($j = 0; $j < 7; $j++)
	{
		if(empty($dd[$i][$j]))
		{
			$dd[$i][$j] = "<br>";
		}
	}
}

//テンプレートに値を渡す。
$smarty->assign("youbi", $youbi);
$smarty->assign("dd", $dd);
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
?>
