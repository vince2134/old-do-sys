<?php
/*********************************************************************
 * @Program         function_qf_parts.inc
 * @fnc.Overview    QuickFormパーツ
 * @author          
 * @Cng.Tracking    #1: 20060112
 ********************************************************************/

/*------------------------------------------------------------------
    フォーム定義
------------------------------------------------------------------*/

/*--------------------------------------------------------
    説明:   QuickForm - text
    param:  $form                  フォーム
            $element_type          要素
            $f_name                フォーム名
            $width                 フォームの長さ
            $length                文字数制限
            $l_name                ラベル
            $opt_type              その他属性オプションのタイプ(省略可)
            $ary_opt               その他属性オプション用変数配列(省略可)
    return: フォーム
--------------------------------------------------------*/
function Qf_Text_Part($form, $element_type, $f_name, $width, $length, $l_name, $opt_type = null, $ary_opt = null){

    $option = "size=\"".$width."\" maxlength=\"".$length."\" ";

    switch ($opt_type){

        // 一定文字数入力後、自動フォーカス移動
        //    $ary_opt[0]: グループ名
        //    $ary_opt[1]: フォーカス移動先フォーム名
        case "next_focus":
            $option .= "onkeyup=\"Nextfocus(this.form, '$ary_opt[0]', '$f_name', '$ary_opt[1]', '$length')\" ";
            $option .= "onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
            break;

        // 入力が無ければ現在の日付を補完、さらに一定文字数入力後、自動フォーカス移動
        //    $ary_opt[0]: グループ名
        //    $ary_opt[1]: フォーカス移動先フォーム名
        //    $ary_opt[2]: 日付フォーム名(年月日の順に二次元配列)
        case "today_compform_next_focus":
            $option .= "onkeyup=\"Nextfocus(this.form, '$ary_opt[0]', '$f_name', '$ary_opt[1]', '$length')\" ";
            $option .= "onFocus=\"Comp_DateForm_Today(this, this.form, '$ary_opt[0]', '".$ary_opt[2][0]."', '".$ary_opt[2][1]."', '".$ary_opt[2][2]."')\" ";
            $option .= "onBlur=\"blurForm(this)\"";
            break;

        // value表示(コード入力側)
        //    $ary_opt[0]: jsユーザ関数用の名前
        //    $ary_opt[1]: フォームのグループ名
        //    $ary_opt[2]: valueフォーム名
        case "disp_value_jack":
            $option .= "onKeyup=\"javascript:Code_Value_$ary_opt[0]('$ary_opt[1]', this, '$ary_opt[2]')\" ";
            $option .= "onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
            break;

        // value表示(データ表示側)
        case "disp_value_gill":
            $option .= "style=\"color: #555555; border: #ffffff 1px solid; ";
            $option .= "background-color: #ffffff;\" readonly tabindex=\"-1\"";
            break;

        // else
        default:
            $option .= "onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";

    }

    return $form->$element_type("text", $f_name, $l_name, $option);

}

/*--------------------------------------------------------
    説明:   QuickForm - text
    param:  $form                  フォーム
            $element_type          要素
            $f_name                フォーム名
            $width                 フォームの長さ
            $length                文字数制限
            $l_name                ラベル
            $opt                   オプション(省略可)
                [*][0]             オプションタイプ
                [*][1〜]           オプション用データ
    return: フォーム
--------------------------------------------------------*/
function Qf_Text_Part1($form, $element_type, $f_name, $width, $length, $l_name, $opt = null){

    // オプション作成開始
    $option = "size=\"".$width."\" maxlength=\"".$length."\" ";

    // フォーカスがある時のBGColor設定（デフォルトON）
    $ary_onform_flg[] = true;
    $ary_blurform_flg[] = true;

    // ノーマルタイプのフォーム（$optが無い）の場合
    if ($opt == null){
        $option .= "onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";
        return $form->$element_type("text", $f_name, $l_name, $option);
    }

    // 配列（$opt）で指定されているオプションを追加
    foreach ($opt as $ary_opt){

        switch ($ary_opt[0]){

            // 特定文字数入力されたらフォーカスを次のフォームへ移す
            case "next_focus":
                // [1]: グループ名
                // [2]: フォーカス遷移先のフォーム名
                $option .= "onkeyup=\"Nextfocus(this.form, '".$ary_opt[1]."', '$f_name', '".$ary_opt[2]."', '$length');\" ";
                break;

            // 入力が無ければ当日の年月日をそれぞれのフォーム(年,月,日)に補完する
            case "comp_form_today":
                // [1]: グループ名
                // [2]: 年のフォーム名
                // [3]: 月のフォーム名
                // [4]: 日のフォーム名
                $option .= "onFocus=\"Comp_Form_Today(this, this.form, ";
                $option .= "'".$ary_opt[1]."', '".$ary_opt[2]."', '".$ary_opt[3]."', '".$ary_opt[4]."');\" ";
                $ary_onform_flg[] = false;
                break;

            // keyupで特定のフォームに値を補完する(特定のフォームデータがnullの場合)
            case "comp_form_val":
                // [1]: グループ名
                // [2]: 補完対象フォーム名
                // [3]: 補完文字列
                $option .= "onKeyup=\"Comp_Form_Val(this.form, '".$ary_opt[1]."', '".$f_name."', '".$ary_opt[2]."', '".$ary_opt[3]."');\" ";
                break;

            // 入力されたコードに対するvalueを表示（コード入力側用）
            // コードのフォームが2つの場合は、特定文字数入力されたらフォーム１からフォーム２へフォーカス移動
            case "disp_value_jack":
                // [1]: Javascriptユーザ関数名に使用する文字列
                // [2]: グループ名
                // [3]: value表示フォーム名
                // [4][0]: コード１のフォーム名
                // [4][1]: コード２のフォーム名(コードのフォームが2つの場合)
                if (isset($ary_opt[4][1])){
                    $cd_form = "['".$ary_opt[4][0]."', '".$ary_opt[4][1]."', $length]";
                }else{
                    $cd_form = "['".$f_name."']";
                }
                $option .= "onKeyup=\"javascript:Code_Value_".$ary_opt[1]."('".$ary_opt[2]."', '".$ary_opt[3]."', ".$cd_form.");\" ";
                break;

            // 入力されたコードに対するvalueを表示（データ表示側用：隠しフォームの場合）
            case "disp_value_gill1":
                $option .= "style=\"color: #555555; border: #ffffff 1px solid; ";
                $option .= "background-color: #ffffff;\" readonly tabindex=\"-1\"";
                $ary_onform_flg[] = false;
                $ary_blurform_flg[] = false;
                break;

        }

    }

    // onFormオプションを付ける/付けない
    if (in_array(false, $ary_onform_flg)){
        $option .= null;
    }else{
        $option .="onFocus=\"onForm(this)\" ";
    }

    // blurFormオプションを付ける/付けない
    if (in_array(false, $ary_blurform_flg)){
        $option .= null;
    }else{
        $option .="onBlur=\"blurForm(this)\" ";
    }

# debug print
#print "オプション：".$option."<br>";

    // QuickForm作成
    return $form->$element_type("text", $f_name, $l_name, $option);

}

/*--------------------------------------------------------
    説明:   QuickForm - password
    param:  $form                  フォーム
            $element_type          要素
            $f_name                フォーム名
            $width                 フォームの長さ
            $length                文字数制限
            $l_name                ラベル
    return: フォーム
--------------------------------------------------------*/
function Qf_Password_Part($form, $element_type, $f_name, $width, $length, $l_name){

    $option  = "size=\"".$width."\" maxlength=\"".$length."\" ";
    $option .= "onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";

    return $form->$element_type("password", $f_name, $l_name, $option);

}

/*--------------------------------------------------------
    説明:   QuickForm - textarea
    param:  $form                  フォーム
            $element_type          要素
            $f_name                フォーム名
            $rows                  行数
            $cols                  列数
            $l_name                ラベル
    return: フォーム
--------------------------------------------------------*/
function Qf_Textarea_Part($form, $element_type, $f_name, $rows, $cols, $l_name){

    $option = "rows=\"".$rows."\" cols=\"".$cols."\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"";

    return $form->$element_type("textarea", $f_name, $l_name, $option);

}

/*--------------------------------------------------------
    説明:   QuickForm - button
    param:  $form                  フォーム
            $element_type          要素
            $button_type           ボタンのタイプ属性
            $f_name                フォーム名
            $f_value               ボタンのバリュー属性
            $opt_type              その他属性オプションのタイプ(省略可)
            $ary_opt               その他属性オプション用変数配列(省略可)
    return: フォーム
--------------------------------------------------------*/
function Qf_button_Part($form, $element_type, $button_type, $f_name, $f_value, $opt_type = null, $ary_opt = null){

    switch ($opt_type){

        // 登録しますダイアログ→ページ遷移
        case "submit_01":
            $option = "onClick=\"javascript:return Dialogue('登録します　','#')\"";
            break;

        // 戻る
        case "return_01":
            $option = "onClick=\"javascript:history.back()\"";
            break;

        // 検索
        // $ary_opt[0]: hiddenのフォーム名
        // $ary_opt[1]: 遷移先ページ
        // $ary_opt[2]: hiddenに補完する文字列
        case "search_01":
            $option = "onClick=\"javascript:Button_Submit('$ary_opt[0]', '$ary_opt[1]', '$ary_opt[2]')\"";
            break;

        // else
        default:
            $option = null;

    }

    return $form->$element_type($button_type, $f_name, $f_value, $option);

}


/*------------------------------------------------------------------
    ルール定義
------------------------------------------------------------------*/

/*--------------------------------------------------------
    説明:   QuickForm - 必須項目チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
    return: void
--------------------------------------------------------*/
function Qf_Chk_Required($form, $f_name, $l_name){

    $form->addRule($f_name, $l_name." は必須項目です。", "required", null);

}

/*--------------------------------------------------------
    説明:   QuickForm - [0-9]チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numeric($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." は半角数字".$maxlen."桁以内です", "numeric。", null);

}

/*--------------------------------------------------------
    説明:   QuickForm - [0-9-]チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numhyphen($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." は半角数字と「-」の".$maxlen."桁以内です。", "numhyphen");

}

/*--------------------------------------------------------
    説明:   QuickForm - 重複チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $duplicate_flg         重複フラグ(重複: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Duplicate($form, $f_name, $l_name, $duplicate_flg){

    if($duplicate_flg == true){
        $form->setElementError($f_name, "既に使用されている".$l_name."です。");
    }

}

/*--------------------------------------------------------
    説明:   QuickForm - 同一ショップ内での重複数チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $num_over_flg          個数オーバフラグ(エラー: true)
            $maxnum                最大個数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numover($form, $f_name, $l_name, $num_over_flg, $maxnum){

    if($num_over_flg == true){
        $form->setElementError($f_name, $l_name." は同一ショップ内で".$maxnum."個までです。");
    }

}

/*--------------------------------------------------------
    説明:   QuickForm - 郵便番号フォーマットチェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen1               最大桁数１
            $maxlen2               最大桁数２
            $format_err_flg        フォーマットエラーフラグ(エラー: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Post($form, $f_name, $l_name, $maxlen1, $maxlen2, $format_err_flg){

    if($format_err_flg == true){
        $form->setElementError($f_name, $l_name." は半角数字".$maxlen1."桁-".$maxlen2."桁です。");
    }

}

/*--------------------------------------------------------
    説明:   QuickForm - TEL, FAXフォーマットチェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Telfax($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." は半角数字と「-」の".$maxlen."桁以内です。", "telfax");

}

/*--------------------------------------------------------
    説明:   QuickForm - 文字列長チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
            $fnc_type              使用する関数(1byte/MultiByte用)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Strlen($form, $f_name, $l_name, $maxlen, $unit, $fnc_type){

    $form->addRule($f_name, $l_name." は".$maxlen.$unit."以内です。", $fnc_type, $maxlen);
    $form->applyFilter($f_name, "trim");

}

















/*
    //日付部品定義
    function date_part($form,$num){
	
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
 function money_part($form,$num){

		$f_code_c = "f_code_c".$num;

		//9文字.2文字
		$text[] =& $form->createElement("text","f_text9","テキストフォーム","size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText10(this.form,$num)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" style=\"text-align: right\"");
		$text[] =& $form->createElement("text","f_text2","テキストフォーム",'size="2" maxLength="2" value="" onFocus="onForm(this)" onBlur="blurForm(this)" style="text-align: left"');
		$form->addGroup( $text, "$f_code_c", "$f_code_c",".");

		$radio15[] =& $form->createElement( "radio",NULL,NULL, "全商品","1");
		$radio15[] =& $form->createElement( "radio",NULL,NULL, "在庫数0以外","2");
		$radio15[] =& $form->createElement( "radio",NULL,NULL, "在庫数0","3");
		$form->addGroup( $radio15, "f_radio6", "対象商品");

		//必須入力チェック（サーバ側）
		$form->addRule('f_radio6', '年は必須項目です！！', 'required');

		//チェック判定
		$form->validate();

	}

	function goods_part($form,$num){

		$f_goods = "f_goods".$num;
		$t_goods = "t_goods".$num;
		$goods = "'goods".$num."'";

		//商品コード
		$form->addElement("text","$f_goods","テキストフォーム","size=\"10\" maxLength=\"8\" value=\"\" onKeyUp=\"javascript:display4(this,$goods)\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
$form->addElement("text","$t_goods","テキストフォーム","size=\"34\" maxLength=\"30\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

	}
*/
?>
