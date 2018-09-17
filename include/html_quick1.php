<?php
$head = "/amenity/src/head/";
$fc = "/amenity/src/franchise/";

/******************************************テキスト**************************************/

//コード関連
//部署コード
$text1[] =& $form->createElement("text","code","テキストフォーム","size=\"3\" maxLength=\"3\" value=\"\" onKeyUp=\"javascript:part(this,'form_part[name]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text1[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text1, "form_part", "form_part");

//部署コード
$form->addElement("text","form_part_cd[1]","テキストフォーム","size=\"3\" maxLength=\"3\" value=\"\" onKeyUp=\"javascript:part(this,'form_part_name[1]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$form->addElement("text","form_part_name[1]","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');

//倉庫コード
$text2[] =& $form->createElement("text","code","テキストフォーム","size=\"3\" maxLength=\"3\" value=\"\" onKeyUp=\"javascript:ware(this,'form_ware[name]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text2[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text2, "form_ware", "form_ware");

//業種コード
$text3[] =& $form->createElement("text","code","テキストフォーム","size=\"5\" maxLength=\"5\" value=\"\" onKeyUp=\"javascript:btype(this,'form_btype[name]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text3[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text3, "form_btype", "form_btype");

//銀行コード
$text4[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:bank(this,'form_bank[name]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text4[] =& $form->createElement("text","name","テキストフォーム",'size="51" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text4, "form_bank", "form_bank");

//製品区分
$text5[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:product(this,'product')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text5[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text5, "form_product", "form_product");

//Ｍ区分
$text6[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:g_goods(this,'form_g_goods[name]')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text6[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text6, "form_g_goods", "form_g_goods");

//分類区分
$text7[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:kind(this,'kind')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text7[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text7, "form_kind", "form_kind");

//仕入先コード
$text8[] =& $form->createElement("text","code","テキストフォーム","size=\"7\" maxLength=\"6\" value=\"\" onKeyUp=\"javascript:layer(this,'layer')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text8[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text8, "form_layer", "form_layer");

//商品コード
$text9[] =& $form->createElement("text","cd","テキストフォーム","size=\"10\" maxLength=\"8\" value=\"\" onKeyUp=\"javascript:goods(this,'goods')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text9[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text9, "form_goods", "form_goods");

//サービス
$text10[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:service(this,'service')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text10[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text10, "form_service", "form_service");

//運送業者
$text11[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:forwarding(this,'forwarding')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text11[] =& $form->createElement("text","name","テキストフォーム",'size="51" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text11, "form_forwarding", "form_forwarding");

//直送先
$text12[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:direct(this,'direct')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text12[] =& $form->createElement("text","name","テキストフォーム",'size="51" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text12, "form_direct", "form_direct");

//地区
$text13[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:area(this,'area')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text13[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text13, "form_area", "form_area");

//顧客区分コード
$text14[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:client(this,'client')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text14[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text14, "form_client", "form_client");

//取引区分コード
$text15[] =& $form->createElement("text","code","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onKeyUp=\"javascript:dealing(this,'dealing')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text15[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text15, "form_dealing", "form_dealing");

//担当者コード
$text16[] =& $form->createElement("text","code","テキストフォーム","size=\"4\" maxLength=\"4\" value=\"\" onKeyUp=\"javascript:charge(this,'charge')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text16[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text16, "form_charge", "form_charge");


//締日コード
$text18[] =& $form->createElement("text","code","テキストフォーム","size=\"2\" maxLength=\"2\" value=\"\" onKeyUp=\"javascript:close(this,'close')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text18[] =& $form->createElement("text","name","テキストフォーム",'size="25" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text18, "form_close", "form_close");

//ショップコード
$text19[] =& $form->createElement("text","code1","テキストフォーム",'size="7" maxLength="6" value="" onkeyup="changeText_shop(this.form)" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text19[] =& $form->createElement("static","","","-");
$text19[] =& $form->createElement("text","code2","テキストフォーム",'size="4" maxLength="4" value="" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text19[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text19, "form_shop", "form_shop");

//スタッフコード
$text20[] =& $form->createElement("text","code1","テキストフォーム",'size="7" maxLength="6" value="" onkeyup="changeText_staff(this.form)" onFocus="onForm(this)" onBlur="blurForm(this)" onKeyUp="javascript:staff()"');
$text20[] =& $form->createElement("static","","","-");
$text20[] =& $form->createElement("text","code2","テキストフォーム",'size="3" maxLength="3" value="" onFocus="onForm(this)" onBlur="blurForm(this)" onKeyUp="javascript:staff()"');
$text20[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text20, "form_staff", "form_staff");

//スタッフコード
$text22[] =& $form->createElement("text","code1","テキストフォーム",'size="7" maxLength="6" value="" onkeyup="changeText_staff(this.form)" onFocus="onForm(this)" onBlur="blurForm(this)" onKeyUp="javascript:staff(1)"');
$text22[] =& $form->createElement("static","","","-");
$text22[] =& $form->createElement("text","code2","テキストフォーム",'size="3" maxLength="3" value="" onFocus="onForm(this)" onBlur="blurForm(this)" onKeyUp="javascript:staff(1)"');
$text22[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text22, "form_staff1", "form_staff1");

//請求先コード
$text17[] =& $form->createElement("text","code1","テキストフォーム","size=\"7\" maxLength=\"6\" value=\"\" onKeyUp=\"javascript:claim(this,'claim')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$text17[] =& $form->createElement("static","","","-");
$text17[] =& $form->createElement("text","code2","テキストフォーム",'size="4" maxLength="4" value="" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text17[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text17, "form_claim", "form_claim");

//得意先コード
$text21[] =& $form->createElement("text","code1","テキストフォーム",'size="7" maxLength="6" value="" onkeyup="changeText_customer(this.form)" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text21[] =& $form->createElement("static","","","-");
$text21[] =& $form->createElement("text","code2","テキストフォーム",'size="4" maxLength="4" value="" onFocus="onForm(this)" onBlur="blurForm(this)"');
$text21[] =& $form->createElement("text","name","テキストフォーム",'size="34" value="" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly tabindex="-1"');
$form->addGroup( $text21, "form_customer", "form_customer");


//エラーメッセージを日本語設定に変更
$form->setRequiredNote('(<font color="#ff0000">*必須項目</font>)');
$form->setJsWarnings("以下で入力エラーがあります。\n","\n再度、入力項目を確認して下さい");
$form->addElement('reset','reset','Reset');
$form->addGroup($button, "button", "");


?>
