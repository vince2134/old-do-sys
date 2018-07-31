<?php
//日付部品クラス
class Form_part{

	//日付部品定義
	public function date_part($form,$num){
	
		$f_date_a = "f_date_a".$num;

		//4文字-2文字-2文字
		$text[] =& $form->createElement("text","y_input","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"changeText3(this.form,$num)\" onFocus=\"onForm2(this,this.form,$num)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("text","m_input","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"changeText4(this.form,$num)\" onFocus=\"onForm2(this,this.form,$num)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("text","d_input","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onFocus=\"onForm2(this,this.form,$num)\" onBlur=\"blurForm(this)\"");
		$form->addGroup( $text,"$f_date_a","$f_date_a","-");

		//配列初期化
		$text = array();

		$f_date_b = "f_date_b".$num;

		//4文字-2文字-2文字〜4文字-2文字-2文字
		$text[] =& $form->createElement("text","y_start","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"changeText5(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("static","","","-");
		$text[] =& $form->createElement("text","m_start","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"changeText6(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("static","","","-");
		$text[] =& $form->createElement("text","d_start","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"changeText7(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("static","","","　〜　");
		$text[] =& $form->createElement("text","y_end","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onkeyup=\"changeText8(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("static","","","-");
		$text[] =& $form->createElement("text","m_end","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onkeyup=\"changeText9(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
		$text[] =& $form->createElement("static","","","-");
		$text[] =& $form->createElement("text","d_end","テキストフォーム",'size="2" maxLength="2" value="" onFocus="onForm(this)" onBlur="blurForm(this)"');
		$form->addGroup( $text,"$f_date_b","$f_date_b");
		
	}

	//金額部品定義
	public function money_part($form,$num){

		$f_code_c = "f_code_c".$num;

		//9文字.2文字
		$text[] =& $form->createElement("text","f_text9","テキストフォーム","size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText10(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" style=\"text-align: right\"");
		$text[] =& $form->createElement("text","f_text2","テキストフォーム",'size="2" maxLength="2" value="" onFocus="onForm(this)" onBlur="blurForm(this)" style="text-align: left"');
		$form->addGroup( $text, "$f_code_c", "$f_code_c",".");

		//必須入力チェック（サーバ側）
		$form->addGroupRule('f_code_c1', array(
			'f_text9' => array(
				array('金額は必須項目です！！', 'required',"","client")
			),
			'f_text2' => array(
				array('小数点は必須項目です！！','required',"","client")
			)
		));
		//フォーム全てに対して行う
		//半角スペース削除
		$form->applyFilter('__ALL__','trim');
		//タグ無効
		$form->applyFilter('__ALL__','htmlspecialchars');
		//￥マークを取り除く
		$form->applyFilter('__ALL__','stripslashes');
		//チェック判定
		$form->validate();

	}

	//商品コード部品定義
	public function goods_part($form,$num){

		$f_goods = "f_goods".$num;
		$t_goods = "t_goods".$num;
		$goods = "'goods".$num."'";

		//商品コード
		$form->addElement("text","$f_goods","テキストフォーム","size=\"10\" maxLength=\"8\" value=\"\" onKeyUp=\"javascript:display4(this,$goods)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$form->addElement("text","$t_goods","テキストフォーム","size=\"34\" maxLength=\"30\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

	}
}
?>
