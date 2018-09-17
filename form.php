<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=euc-jp">
  <title>Do.sys2010 お知らせ</title>
  <link rel="stylesheet" type="text/css" href="./css/global.css">
</head>
<?php
  require_once "HTML/QuickForm.php";

    $form = new HTML_QuickForm('frmTest2-1', 'get');
    $form->addElement('header', 'MyHeader', 'QuickFormのテスト');
	
	$salutations = array("0"=>"Mr",
                         "1"=>"Miss",
                         "2"=>"Mrs",
                         "3"=>"Dr",
                         "4"=>"Sir");
	$form->addElement('select', 'sal_id', '敬称:', $salutations);
	
	
	$select1[0] = 'Pop';
$select1[1] = 'Classical';
$select1[2] = 'Funeral doom';

// 2 番目の select
$select2[0][0] = '--- Artist ---';
$select2[0][1] = 'Red Hot Chil Peppers';
$select2[0][2] = 'The Pixies';
      
$select2[1][0] = '--- Artist ---';
$select2[1][1] = 'Wagner';
$select2[1][2] = 'Strauss';
      
$select2[2][0] = '--- Artist ---';
$select2[2][1] = 'Pantheist';
$select2[2][2] = 'Skepticism';
     
// 3 番目の select で、CD の価格を指定します
$select3[0][0][0] = '--- Choose the artist ---';
$select3[0][1][0] = '15.00$';
$select3[0][2][1] = '17.00$';
$select3[1][0][0] = '--- Choose the artist ---';
$select3[1][1][0] = '15.00$';
$select3[1][2][1] = '17.00$';
$select3[2][0][0] = '--- Choose the artist ---';
$select3[2][1][0] = '15.00$';
$select3[2][2][1] = '17.00$';     

// 要素を作成します
$sel =& $form->addElement('hierselect', 'cds', 'Choose CD:');

// そして選択肢を追加します
$sel->setOptions(array($select1, $select2, $select3));

    $form->display();
?>
</BODY>
</html>