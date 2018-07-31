#!/bin/sh

###
#
# モジュール一覧を作成する
#


output=`pwd`
cd "/usr/local/apache2/htdocs/amenity/src"


find ./head/ -name "*" |
grep -v OLD | 
grep -v templates | 
grep -v ENV_local | 
#grep -v _ | 
egrep "(?\-?\-....php)$|(?\-?\-???\-[0-9].php)$" |
sort > $output/file_list.txt


find ./franchise/ -name "*" |
grep -v OLD | 
grep -v templates | 
grep -v ENV_local | 
#grep -v _ | 
egrep "(?\-?\-....php)$|(?\-?\-???\-[0-9].php)$" |
sort >> $output/file_list.txt

