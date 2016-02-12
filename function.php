<?php 

// 引数で渡した値をhtmlspecialcharsで変換してくれる関数
function h($value) {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// 引数で渡した値をmysqli~で変換してくれる関数
function m($db, $value) {
  return mysqli_real_escape_string($db,$value);
}

//本文内のURLにリンクを設定します
function makeLink($value) {
  return mb_ereg_replace('(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)','<a href="\1\2" target="_blank">\1\2</a>', $value);
}

 ?>