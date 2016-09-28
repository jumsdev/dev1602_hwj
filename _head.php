<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($co_id=="menu01"||$co_id=="menu01A"){
include_once(G5_THEME_PATH.'/head01.php');
}
else if($bo_table=="room"||$co_id=="menu02A"||$co_id=="menu02B"){
include_once(G5_THEME_PATH.'/head02.php');
}
else if($gr_id=="reserve"){
include_once(G5_THEME_PATH.'/head03.php');
}
else if($co_id=="menu04"||$co_id=="menu04A"){
include_once(G5_THEME_PATH.'/head04.php');
}
else if($gr_id=="cs"){
include_once(G5_THEME_PATH.'/head05.php');
}
else
include_once(G5_PATH.'/head.php');

?>