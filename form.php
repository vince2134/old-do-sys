<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=euc-jp">
  <title>Do.sys2010 ���Τ餻</title>
  <link rel="stylesheet" type="text/css" href="./css/global.css">
</head>
<?php
  require_once "HTML/QuickForm.php";

    $form = new HTML_QuickForm('frmTest2-1', 'get');
    $form->addElement('header', 'MyHeader', 'QuickForm�Υƥ���');
	
	$salutations = array("0"=>"Mr",
                         "1"=>"Miss",
                         "2"=>"Mrs",
                         "3"=>"Dr",
                         "4"=>"Sir");
	$form->addElement('select', 'sal_id', '�ɾ�:', $salutations);
	
	
	$select1[0] = 'Pop';
$select1[1] = 'Classical';
$select1[2] = 'Funeral doom';

// 2 ���ܤ� select
$select2[0][0] = '--- Artist ---';
$select2[0][1] = 'Red Hot Chil Peppers';
$select2[0][2] = 'The Pixies';
      
$select2[1][0] = '--- Artist ---';
$select2[1][1] = 'Wagner';
$select2[1][2] = 'Strauss';
      
$select2[2][0] = '--- Artist ---';
$select2[2][1] = 'Pantheist';
$select2[2][2] = 'Skepticism';
     
// 3 ���ܤ� select �ǡ�CD �β��ʤ���ꤷ�ޤ�
$select3[0][0][0] = '--- Choose the artist ---';
$select3[0][1][0] = '15.00$';
$select3[0][2][1] = '17.00$';
$select3[1][0][0] = '--- Choose the artist ---';
$select3[1][1][0] = '15.00$';
$select3[1][2][1] = '17.00$';
$select3[2][0][0] = '--- Choose the artist ---';
$select3[2][1][0] = '15.00$';
$select3[2][2][1] = '17.00$';     

// ���Ǥ�������ޤ�
$sel =& $form->addElement('hierselect', 'cds', 'Choose CD:');

// �������������ɲä��ޤ�
$sel->setOptions(array($select1, $select2, $select3));

    $form->display();
?>
</BODY>
</html>