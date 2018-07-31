<<-- plugins  ディレクトリの概要 -->>

Smartyで利用したい関数を保存しておくディレクトリ

    １. 命名規則
    
        ファイル名  ＜プラグインの型＞.＜プラグイン名＞.php
        関数名      smarty_＜プラグインの型＞_＜プラグイン名＞ () { 

    ２．プラグインの型

        function        テンプレート関数
        modifier        修飾子
        block           ブロック関数
        compiler        コンパイラ関数
        prefilter       プリフィルタ
        postfilter      ポストフィルタ
        outputfilter    出力フィルタ
        resource        リソース
        insert          インサート・プラグイン
    
    ３．関数名（プラグイン名） BHSK-命名規則
    
        プラグインの関数の頭には、「Plug」を付けるようにする

            smarty_＜プラグインの型＞.Plug_Xxxx_Xxxx () {

    ４．例
    
        modifier.Plug_Minus_Numformat.php
      
        function smarty_modifier_Plug_Minus_Numformat () {
    
以上    
